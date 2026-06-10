<?php
require_once __DIR__ . '/../includes/admin-layout.php';

$title = "Manage Articles";
$activeNav = "articles";
$db = getDB();

// --- Automatic DB Migration for new columns ---
try {
    $db->exec("ALTER TABLE articles ADD COLUMN article_type VARCHAR(100) AFTER authors");
} catch (PDOException $e) {}
try {
    $db->exec("ALTER TABLE articles ADD COLUMN in_press TINYINT(1) DEFAULT 0 AFTER is_published");
} catch (PDOException $e) {}
// ----------------------------------------------

$action = $_GET['action'] ?? 'list';
$article_id = $_GET['id'] ?? null;
$message = '';

// Handle Deletion
if ($action === 'delete' && $article_id) {
    if (!verifyCSRFToken($_GET['token'] ?? '')) {
        $message = '<div class="badge badge-danger">Security token mismatch. Delete aborted.</div>';
    } else {
        $article = $db->prepare("SELECT pdf_file FROM articles WHERE id = ?");
        $article->execute([$article_id]);
        $fileInfo = $article->fetch();
        
        if ($fileInfo) {
            deleteFile($fileInfo['pdf_file'], 'pdf');
            $stmt = $db->prepare("DELETE FROM articles WHERE id = ?");
            $stmt->execute([$article_id]);
            header("Location: articles.php?msg=deleted");
            exit();
        }
    }
}

// Handle Add/Edit Submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($action === 'add' || $action === 'edit')) {
    if (!verifyCSRFToken($_POST['csrf_token'] ?? '')) {
        $message = '<div class="badge badge-danger">Security token mismatch.</div>';
    } else {
        $data = [
            'journal_id'    => (int)$_POST['journal_id'],
            'volume'        => (int)$_POST['volume'],
            'issue'         => (int)$_POST['issue'],
            'title'         => sanitize($_POST['title']),
            'authors'       => sanitize($_POST['authors']),
            'article_type'  => sanitize($_POST['article_type']),
            'abstract'      => $_POST['abstract'],
            'keywords'      => sanitize($_POST['keywords']),
            'doi'           => sanitize($_POST['doi']),
            'pages'         => sanitize($_POST['pages']),
            'received_date' => $_POST['received_date'],
            'accepted_date' => $_POST['accepted_date'],
            'published_date'=> $_POST['published_date'],
            'views_count'   => isset($_POST['views_count']) ? (int)$_POST['views_count'] : 0,
            'downloads_count'=> isset($_POST['downloads_count']) ? (int)$_POST['downloads_count'] : 0,
            'is_published'  => isset($_POST['is_published']) ? 1 : 0,
            'in_press'      => isset($_POST['in_press']) ? 1 : 0
        ];

        $upload_failed = false;
        // Handle File Upload
        if (!empty($_FILES['pdf_file']['name'])) {
            $uploaded = uploadFile($_FILES['pdf_file'], 'pdf');
            if ($uploaded) {
                // If editing, delete old file
                if ($action === 'edit' && !empty($_POST['old_pdf'])) {
                    deleteFile($_POST['old_pdf'], 'pdf');
                }
                $data['pdf_file'] = $uploaded;
            } else {
                $message = '<div class="badge badge-danger">Failed to upload PDF file. Please verify folder permissions (755) and file constraints (max 10MB, PDF only).</div>';
                $upload_failed = true;
            }
        } elseif ($action === 'edit') {
            $data['pdf_file'] = $_POST['old_pdf'];
        }

        if (!$upload_failed) {
            if ($action === 'add') {
                $fields = implode(', ', array_keys($data));
                $placeholders = implode(', ', array_fill(0, count($data), '?'));
                $sql = "INSERT INTO articles ($fields) VALUES ($placeholders)";
                $stmt = $db->prepare($sql);
                if ($stmt->execute(array_values($data))) {
                    header("Location: articles.php?msg=added");
                    exit();
                }
            } else {
                $id = (int)$_POST['id'];
                $sets = [];
                foreach ($data as $key => $val) $sets[] = "$key = ?";
                $sql = "UPDATE articles SET " . implode(', ', $sets) . " WHERE id = ?";
                $stmt = $db->prepare($sql);
                if ($stmt->execute(array_merge(array_values($data), [$id]))) {
                    $message = '<div class="badge badge-success" style="padding: 10px; margin-bottom: 20px;">Article updated successfully!</div>';
                }
            }
        }
    }
}

ob_start();

if ($action === 'add' || ($action === 'edit' && $article_id)):
    $article = ($action === 'edit') ? $db->prepare("SELECT * FROM articles WHERE id = ?") : null;
    if ($article) { $article->execute([$article_id]); $article = $article->fetch(); }
    $journals = getAllJournals();

    // Fetch existing unique article types to populate the suggestions datalist, merged with defaults
    $typeStmt = $db->query("SELECT DISTINCT article_type FROM articles WHERE article_type IS NOT NULL AND article_type != '' ORDER BY article_type ASC");
    $existingTypes = $typeStmt->fetchAll(PDO::FETCH_COLUMN);
    $standardTypes = [
        'Research Article', 
        'Review Article', 
        'Case Report', 
        'Mini Review', 
        'Brief Commentary', 
        'Commentary', 
        'Image Article', 
        'Case Study', 
        'Prospective', 
        'Editorial', 
        'Book Review', 
        'Thesis'
    ];
    $allTypes = array_unique(array_merge($existingTypes, $standardTypes));
    sort($allTypes);
?>
    <div style="margin-bottom: 20px;">
        <a href="articles.php" style="text-decoration: none; color: #64748b;">&larr; Back to List</a>
    </div>
    
    <?php echo $message; ?>

    <div class="card-table" style="padding: 30px;">
        <form action="articles.php?action=<?php echo $action; ?><?php echo $article_id ? '&id='.$article_id : ''; ?>" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="csrf_token" value="<?php echo generateCSRFToken(); ?>">
            <?php if ($article): ?>
                <input type="hidden" name="id" value="<?php echo $article['id']; ?>">
                <input type="hidden" name="old_pdf" value="<?php echo $article['pdf_file']; ?>">
            <?php endif; ?>

            <div style="display: grid; grid-template-columns: 2fr 1fr 1fr; gap: 20px;">
                <div class="form-group">
                    <label>Journal</label>
                    <select name="journal_id" required>
                        <?php foreach ($journals as $j): ?>
                        <option value="<?php echo $j['id']; ?>" <?php echo ($article && $article['journal_id'] == $j['id']) ? 'selected' : ''; ?>>
                            <?php echo sanitize($j['name']); ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label>Volume</label>
                    <input type="number" name="volume" value="<?php echo $article['volume'] ?? 1; ?>" required>
                </div>
                <div class="form-group">
                    <label>Issue</label>
                    <input type="number" name="issue" value="<?php echo $article['issue'] ?? 1; ?>" required>
                </div>
            </div>

            <div class="form-group">
                <label>Article Title</label>
                <input type="text" name="title" value="<?php echo sanitize($article['title'] ?? ''); ?>" required>
            </div>

            <div class="form-group">
                <label>Authors (comma separated)</label>
                <input type="text" name="authors" value="<?php echo sanitize($article['authors'] ?? ''); ?>" required>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                <div class="form-group">
                    <label>Article Type</label>
                    <input type="text" name="article_type" value="<?php echo sanitize($article['article_type'] ?? 'Research Article'); ?>" list="article_types" required>
                    <datalist id="article_types">
                        <?php foreach ($allTypes as $type): ?>
                            <option value="<?php echo sanitize($type); ?>">
                        <?php endforeach; ?>
                    </datalist>
                </div>
                <div class="form-group">
                    <label>DOI</label>
                    <input type="text" name="doi" value="<?php echo sanitize($article['doi'] ?? ''); ?>">
                </div>
            </div>

            <div class="form-group">
                <label>Abstract</label>
                <textarea name="abstract" rows="6"><?php echo sanitize($article['abstract'] ?? ''); ?></textarea>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 20px;">
                <div class="form-group">
                    <label>Received Date</label>
                    <input type="date" name="received_date" value="<?php echo $article['received_date'] ?? ''; ?>">
                </div>
                <div class="form-group">
                    <label>Accepted Date</label>
                    <input type="date" name="accepted_date" value="<?php echo $article['accepted_date'] ?? ''; ?>">
                </div>
                <div class="form-group">
                    <label>Published Date</label>
                    <input type="date" name="published_date" value="<?php echo $article['published_date'] ?? ''; ?>">
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                <div class="form-group">
                    <label>Views Count</label>
                    <input type="number" name="views_count" value="<?php echo $article['views_count'] ?? 0; ?>" min="0">
                </div>
                <div class="form-group">
                    <label>Downloads Count</label>
                    <input type="number" name="downloads_count" value="<?php echo $article['downloads_count'] ?? 0; ?>" min="0">
                </div>
            </div>

            <div class="form-group">
                <label>Upload PDF (Max 10MB)</label>
                <input type="file" name="pdf_file" accept=".pdf">
                <?php if ($article && $article['pdf_file']): ?>
                    <p style="font-size: 0.8rem; color: #64748b; margin-top: 5px;">Current: <a href="<?php echo UPLOAD_URL . $article['pdf_file']; ?>" target="_blank">View PDF</a></p>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <label style="display: flex; align-items: center; gap: 10px; cursor: pointer;">
                    <input type="checkbox" name="is_published" <?php echo (!$article || $article['is_published']) ? 'checked' : ''; ?>>
                    Published (Visible in Archive)
                </label>
            </div>

            <div class="form-group">
                <label style="display: flex; align-items: center; gap: 10px; cursor: pointer;">
                    <input type="checkbox" name="in_press" <?php echo ($article && $article['in_press']) ? 'checked' : ''; ?>>
                    Articles in Press (Accepted but not yet assigned to dynamic volume/issue)
                </label>
            </div>

            <button type="submit" class="btn-admin btn-primary-admin"><?php echo $article ? 'Update Article' : 'Publish Article'; ?></button>
        </form>
    </div>

<?php else:
    $articles = $db->query("SELECT a.*, j.short_name FROM articles a LEFT JOIN journals j ON a.journal_id = j.id ORDER BY a.created_at DESC")->fetchAll();
    if (isset($_GET['msg'])) {
        echo '<div class="badge badge-success" style="padding: 10px; margin-bottom: 20px;">Operation successful!</div>';
    }
?>
    <div class="card-table">
        <div class="table-header">
            <h2 style="font-size: 1.1rem; font-weight: 600;">All Articles</h2>
            <a href="articles.php?action=add" class="btn-admin btn-primary-admin" style="text-decoration: none; font-size: 0.85rem;">+ Add New Article</a>
        </div>
        <table>
            <thead>
                <tr>
                    <th>Journal</th>
                    <th>Vol/Issue</th>
                    <th>Title & Authors</th>
                    <th>Type</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($articles as $a): ?>
                <tr>
                    <td><strong><?php echo $a['short_name']; ?></strong></td>
                    <td>V<?php echo $a['volume']; ?> I<?php echo $a['issue']; ?></td>
                    <td>
                        <div style="font-weight: 600; font-size: 0.9rem;"><?php echo sanitize($a['title']); ?></div>
                        <div style="font-size: 0.75rem; color: #64748b;"><?php echo sanitize($a['authors']); ?></div>
                    </td>
                    <td><span class="badge" style="background: #e2e8f0; color: #1e293b;"><?php echo $a['article_type']; ?></span></td>
                    <td>
                        <span class="badge <?php echo $a['is_published'] ? 'badge-success' : 'badge-warning'; ?>">
                            <?php echo $a['is_published'] ? 'Published' : 'Draft'; ?>
                        </span>
                        <?php if ($a['in_press']): ?>
                            <span class="badge" style="background: #ec4899; color: white; margin-top: 4px; display: inline-block;">In Press</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <div style="display: flex; gap: 5px;">
                            <a href="articles.php?action=edit&id=<?php echo $a['id']; ?>" class="btn-admin" style="background: #e2e8f0; color: #1e293b; text-decoration: none; font-size: 0.7rem;">Edit</a>
                            <a href="articles.php?action=delete&id=<?php echo $a['id']; ?>&token=<?php echo generateCSRFToken(); ?>" class="btn-admin" style="background: #fee2e2; color: #991b1b; text-decoration: none; font-size: 0.7rem;" onclick="return confirm('Delete this article forever?')">Del</a>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php endif;

$content = ob_get_clean();
renderAdminLayout($title, $content, $activeNav);
