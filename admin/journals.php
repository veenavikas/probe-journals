<?php
require_once __DIR__ . '/../includes/admin-layout.php';

$title = "Manage Journals";
$activeNav = "journals";
$db = getDB();

// --- Automatic DB Migration for new columns ---
try {
    $db->exec("ALTER TABLE journals ADD COLUMN author_guidelines TEXT AFTER aim_and_scope");
} catch (PDOException $e) {}
try {
    $db->exec("ALTER TABLE journals ADD COLUMN submission_content TEXT AFTER author_guidelines");
} catch (PDOException $e) {}
try {
    $db->exec("ALTER TABLE journals ADD COLUMN publication_ethics TEXT AFTER submission_content");
} catch (PDOException $e) {}
try {
    $db->exec("ALTER TABLE journals ADD COLUMN acceptance_rate DECIMAL(5,2) DEFAULT 28.41");
} catch (PDOException $e) {}
try {
    $db->exec("ALTER TABLE journals ADD COLUMN rejection_rate DECIMAL(5,2) DEFAULT 40.89");
} catch (PDOException $e) {}
try {
    $db->exec("ALTER TABLE journals ADD COLUMN submitted_rate DECIMAL(5,2) DEFAULT 30.70");
} catch (PDOException $e) {}
// ----------------------------------------------

$action = $_GET['action'] ?? 'list';
$journal_id = $_GET['id'] ?? null;
$message = '';

if (isset($_GET['msg']) && $_GET['msg'] === 'added') {
    $message = '<div class="badge badge-success" style="padding: 10px; margin-bottom: 20px;">Journal created successfully!</div>';
}

// Handle Form Submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($action === 'add' || $action === 'edit')) {
    if (!verifyCSRFToken($_POST['csrf_token'] ?? '')) {
        $message = '<div class="badge badge-danger">Security token mismatch.</div>';
    } else {
        $name = sanitize($_POST['name']);
        $slug = sanitize($_POST['slug']);
        $short_name = sanitize($_POST['short_name']);
        $category = sanitize($_POST['subject_category']);
        $description = $_POST['description'] ?? '';
        $aim_and_scope = $_POST['aim_and_scope'] ?? '';
        $author_guidelines = $_POST['author_guidelines'] ?? '';
        $submission_content = $_POST['submission_content'] ?? '';
        $publication_ethics = $_POST['publication_ethics'] ?? '';
        $cite_score = !empty($_POST['cite_score']) ? (float)$_POST['cite_score'] : null;
        $impact_factor = !empty($_POST['impact_factor']) ? (float)$_POST['impact_factor'] : null;
        $h_index = !empty($_POST['h_index']) ? (int)$_POST['h_index'] : null;
        $acceptance_rate = !empty($_POST['acceptance_rate']) ? (float)$_POST['acceptance_rate'] : 28.41;
        $rejection_rate = !empty($_POST['rejection_rate']) ? (float)$_POST['rejection_rate'] : 40.89;
        $submitted_rate = !empty($_POST['submitted_rate']) ? (float)$_POST['submitted_rate'] : 30.70;
        
        $acceptance_time = sanitize($_POST['acceptance_time'] ?? '');
        $processing_time = sanitize($_POST['processing_time'] ?? '');
        $publishing_time = sanitize($_POST['publishing_time'] ?? '');
        $issue_frequency = sanitize($_POST['issue_frequency'] ?? '');
        
        $apc_amount = !empty($_POST['apc_amount']) ? (float)$_POST['apc_amount'] : null;
        $apc_currency = sanitize($_POST['apc_currency'] ?? 'EUR');
        $withdrawal_fee = !empty($_POST['withdrawal_fee']) ? (float)$_POST['withdrawal_fee'] : null;
        $withdrawal_days = !empty($_POST['withdrawal_days']) ? (int)$_POST['withdrawal_days'] : 5;
        
        $submission_email = sanitize($_POST['submission_email'] ?? '');
        $privacy_statement = $_POST['privacy_statement'] ?? '';
        $copyright_text = $_POST['copyright_text'] ?? '';
        $contact_info = $_POST['contact_info'] ?? null;
        
        $sort_order = (int)($_POST['sort_order'] ?? 0);
        $is_active = isset($_POST['is_active']) ? 1 : 0;
        
        $upload_failed = false;
        $cover_image = ($action === 'edit') ? ($_POST['current_cover_image'] ?? null) : null;
        
        if (isset($_FILES['cover_image']) && !empty($_FILES['cover_image']['name'])) {
            $new_file = uploadFile($_FILES['cover_image'], 'journal');
            if ($new_file) {
                if ($action === 'edit' && $cover_image) {
                    deleteFile($cover_image, 'journal');
                }
                $cover_image = $new_file;
            } else {
                $message = '<div class="badge badge-danger">Failed to upload cover image. Please verify folder permissions (755) and file size constraints (max 2MB, JPEG/PNG/WebP).</div>';
                $upload_failed = true;
            }
        }
        
        if (!$upload_failed) {
            if ($action === 'add') {
                $sql = "INSERT INTO journals (
                            name, slug, short_name, subject_category, description, aim_and_scope, 
                            author_guidelines, submission_content, publication_ethics,
                            cite_score, impact_factor, h_index, acceptance_time, processing_time, 
                            publishing_time, issue_frequency, apc_amount, apc_currency, 
                            withdrawal_fee, withdrawal_days, submission_email, privacy_statement, 
                            copyright_text, contact_info, cover_image, sort_order, is_active,
                            acceptance_rate, rejection_rate, submitted_rate
                        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
                $stmt = $db->prepare($sql);
                try {
                    if ($stmt->execute([
                        $name, $slug, $short_name, $category, $description, $aim_and_scope,
                        $author_guidelines, $submission_content, $publication_ethics,
                        $cite_score, $impact_factor, $h_index, $acceptance_time, $processing_time,
                        $publishing_time, $issue_frequency, $apc_amount, $apc_currency,
                        $withdrawal_fee, $withdrawal_days, $submission_email, $privacy_statement,
                        $copyright_text, $contact_info, $cover_image, $sort_order, $is_active,
                        $acceptance_rate, $rejection_rate, $submitted_rate
                    ])) {
                        header("Location: journals.php?msg=added");
                        exit();
                    } else {
                        $message = '<div class="badge badge-danger">Failed to add journal. Please check values.</div>';
                    }
                } catch (PDOException $e) {
                    $message = '<div class="badge badge-danger">Database error: ' . $e->getMessage() . '</div>';
                }
            } else {
                $id = (int)$_POST['id'];
                 $sql = "UPDATE journals SET 
                        name = ?, slug = ?, short_name = ?, subject_category = ?, 
                        description = ?, aim_and_scope = ?, author_guidelines = ?, 
                        submission_content = ?, publication_ethics = ?, cite_score = ?, 
                        impact_factor = ?, h_index = ?, acceptance_time = ?, 
                        processing_time = ?, publishing_time = ?, issue_frequency = ?, 
                        apc_amount = ?, apc_currency = ?, withdrawal_fee = ?, 
                        withdrawal_days = ?, submission_email = ?, privacy_statement = ?, 
                        copyright_text = ?, contact_info = ?, cover_image = ?, 
                        sort_order = ?, is_active = ?,
                        acceptance_rate = ?, rejection_rate = ?, submitted_rate = ?
                        WHERE id = ?";
                $stmt = $db->prepare($sql);
                if ($stmt->execute([
                    $name, $slug, $short_name, $category, $description, $aim_and_scope,
                    $author_guidelines, $submission_content, $publication_ethics,
                    $cite_score, $impact_factor, $h_index, $acceptance_time, $processing_time,
                    $publishing_time, $issue_frequency, $apc_amount, $apc_currency,
                    $withdrawal_fee, $withdrawal_days, $submission_email, $privacy_statement,
                    $copyright_text, $contact_info, $cover_image, $sort_order, $is_active,
                    $acceptance_rate, $rejection_rate, $submitted_rate,
                    $id
                ])) {
                    $message = '<div class="badge badge-success" style="padding: 10px; margin-bottom: 20px;">Journal updated successfully!</div>';
                } else {
                    $message = '<div class="badge badge-danger">Failed to update journal.</div>';
                }
            }
        }
    }
}

ob_start();

if (($action === 'add' || $action === 'edit') && ($action === 'add' || $journal_id)):
    $journal = ($action === 'edit') ? getJournalById((int)$journal_id) : null;
    if ($action === 'edit' && !$journal):
        echo "<p>Journal not found.</p>";
    else:
?>
    <div style="margin-bottom: 20px;">
        <a href="journals.php" style="text-decoration: none; color: #64748b;">&larr; Back to List</a>
    </div>

    <?php echo $message; ?>

    <div class="card-table" style="padding: 30px;">
        <h2 style="font-size: 1.2rem; font-weight: 600; margin-bottom: 20px;"><?php echo $action === 'add' ? 'Add New Journal' : 'Edit Journal Details'; ?></h2>
        <form action="journals.php?action=<?php echo $action; ?><?php echo $journal ? '&id='.$journal['id'] : ''; ?>" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="csrf_token" value="<?php echo generateCSRFToken(); ?>">
            <?php if ($journal): ?>
                <input type="hidden" name="id" value="<?php echo $journal['id']; ?>">
                <input type="hidden" name="current_cover_image" value="<?php echo $journal['cover_image']; ?>">
            <?php endif; ?>

            <div class="form-group" style="margin-bottom: 25px;">
                <label>Journal Cover Image</label>
                <?php if ($journal && $journal['cover_image']): ?>
                    <div style="margin-bottom: 10px;">
                        <img src="/assets/uploads/<?php echo $journal['cover_image']; ?>" style="width: 120px; height: 160px; object-fit: cover; border-radius: 8px; border: 1px solid #cbd5e1;">
                    </div>
                <?php endif; ?>
                <input type="file" name="cover_image" accept="image/*">
                <small style="display: block; color: #64748b; margin-top: 5px;">Recommended size: 300x400px (Portrait)</small>
            </div>
            
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                <div class="form-group">
                    <label>Journal Name</label>
                    <input type="text" name="name" value="<?php echo $journal ? sanitize($journal['name']) : ''; ?>" required>
                </div>
                <div class="form-group">
                    <label>Slug (URL pathway)</label>
                    <input type="text" name="slug" value="<?php echo $journal ? sanitize($journal['slug']) : ''; ?>" required placeholder="e.g. journal-of-biology">
                </div>
                <div class="form-group">
                    <label>Short Name (e.g. JOB)</label>
                    <input type="text" name="short_name" value="<?php echo $journal ? sanitize($journal['short_name']) : ''; ?>">
                </div>
                <div class="form-group">
                    <label>Subject Category</label>
                    <select name="subject_category">
                        <option value="Clinical Sciences" <?php echo ($journal && $journal['subject_category'] == 'Clinical Sciences') ? 'selected' : ''; ?>>Clinical Sciences</option>
                        <option value="Medical Sciences" <?php echo ($journal && $journal['subject_category'] == 'Medical Sciences') ? 'selected' : ''; ?>>Medical Sciences</option>
                        <option value="General Sciences" <?php echo ($journal && $journal['subject_category'] == 'General Sciences') ? 'selected' : ''; ?>>General Sciences</option>
                        <option value="Engineering" <?php echo ($journal && $journal['subject_category'] == 'Engineering') ? 'selected' : ''; ?>>Engineering</option>
                    </select>
                </div>
            </div>

            <h3 style="font-size: 1rem; border-bottom: 1px solid #e2e8f0; padding-bottom: 5px; margin-top: 30px; margin-bottom: 15px;">Journal Metrics</h3>
            <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px;">
                <div class="form-group">
                    <label>Impact Factor</label>
                    <input type="number" step="0.01" name="impact_factor" value="<?php echo $journal ? $journal['impact_factor'] : ''; ?>">
                </div>
                <div class="form-group">
                    <label>Cite Score</label>
                    <input type="number" step="0.01" name="cite_score" value="<?php echo $journal ? $journal['cite_score'] : ''; ?>">
                </div>
                <div class="form-group">
                    <label>H-Index</label>
                    <input type="number" name="h_index" value="<?php echo $journal ? $journal['h_index'] : ''; ?>">
                </div>
                <div class="form-group">
                    <label>Sort Order</label>
                    <input type="number" name="sort_order" value="<?php echo $journal ? $journal['sort_order'] : '0'; ?>">
                </div>
            </div>

            <h3 style="font-size: 1rem; border-bottom: 1px solid #e2e8f0; padding-bottom: 5px; margin-top: 30px; margin-bottom: 15px;">Article Statistics (Pie Chart Rates)</h3>
            <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px;">
                <div class="form-group">
                    <label>Acceptance Rate (%)</label>
                    <input type="number" step="0.01" name="acceptance_rate" value="<?php echo $journal ? $journal['acceptance_rate'] : '28.41'; ?>" required>
                </div>
                <div class="form-group">
                    <label>Rejection Rate (%)</label>
                    <input type="number" step="0.01" name="rejection_rate" value="<?php echo $journal ? $journal['rejection_rate'] : '40.89'; ?>" required>
                </div>
                <div class="form-group">
                    <label>Submitted Rate (%)</label>
                    <input type="number" step="0.01" name="submitted_rate" value="<?php echo $journal ? $journal['submitted_rate'] : '30.70'; ?>" required>
                </div>
            </div>

            <h3 style="font-size: 1rem; border-bottom: 1px solid #e2e8f0; padding-bottom: 5px; margin-top: 30px; margin-bottom: 15px;">Publication Timings &amp; Frequency</h3>
            <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px;">
                <div class="form-group">
                    <label>Acceptance Time</label>
                    <input type="text" name="acceptance_time" value="<?php echo $journal ? sanitize($journal['acceptance_time']) : ''; ?>" placeholder="e.g. 7-25 days">
                </div>
                <div class="form-group">
                    <label>Processing Time</label>
                    <input type="text" name="processing_time" value="<?php echo $journal ? sanitize($journal['processing_time']) : ''; ?>" placeholder="e.g. 10-20 days">
                </div>
                <div class="form-group">
                    <label>Publishing Time</label>
                    <input type="text" name="publishing_time" value="<?php echo $journal ? sanitize($journal['publishing_time']) : ''; ?>" placeholder="e.g. 15-25 days">
                </div>
                <div class="form-group">
                    <label>Issue Frequency</label>
                    <input type="text" name="issue_frequency" value="<?php echo $journal ? sanitize($journal['issue_frequency']) : 'Bimonthly'; ?>">
                </div>
            </div>

            <h3 style="font-size: 1rem; border-bottom: 1px solid #e2e8f0; padding-bottom: 5px; margin-top: 30px; margin-bottom: 15px;">Article Processing Charges (APC)</h3>
            <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px;">
                <div class="form-group">
                    <label>APC Amount</label>
                    <input type="number" step="0.01" name="apc_amount" value="<?php echo $journal ? $journal['apc_amount'] : '1019.00'; ?>">
                </div>
                <div class="form-group">
                    <label>APC Currency</label>
                    <input type="text" name="apc_currency" value="<?php echo $journal ? sanitize($journal['apc_currency']) : 'EUR'; ?>">
                </div>
                <div class="form-group">
                    <label>Withdrawal Fee</label>
                    <input type="number" step="0.01" name="withdrawal_fee" value="<?php echo $journal ? $journal['withdrawal_fee'] : '219.00'; ?>">
                </div>
                <div class="form-group">
                    <label>Withdrawal Days Limit</label>
                    <input type="number" name="withdrawal_days" value="<?php echo $journal ? $journal['withdrawal_days'] : '5'; ?>">
                </div>
            </div>

            <h3 style="font-size: 1rem; border-bottom: 1px solid #e2e8f0; padding-bottom: 5px; margin-top: 30px; margin-bottom: 15px;">Editorial Emails &amp; Contact Info</h3>
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                <div class="form-group">
                    <label>Submission Email</label>
                    <input type="email" name="submission_email" value="<?php echo $journal ? sanitize($journal['submission_email']) : 'publish@probejournals.com'; ?>">
                </div>
                <div class="form-group">
                    <label>Contact Info Block (Postal addresses, phone, etc.)</label>
                    <textarea name="contact_info" rows="3" placeholder="Registered Address and phone number..."><?php echo $journal ? sanitize($journal['contact_info'] ?? '') : ''; ?></textarea>
                </div>
            </div>

            <h3 style="font-size: 1rem; border-bottom: 1px solid #e2e8f0; padding-bottom: 5px; margin-top: 30px; margin-bottom: 15px;">Descriptions &amp; Scope</h3>
            <div class="form-group">
                <label>Description</label>
                <textarea name="description" rows="5"><?php echo $journal ? sanitize($journal['description'] ?? '') : ''; ?></textarea>
            </div>

            <div class="form-group">
                <label>Aim &amp; Scope</label>
                <textarea name="aim_and_scope" rows="5"><?php echo $journal ? sanitize($journal['aim_and_scope'] ?? '') : ''; ?></textarea>
            </div>

            <div class="form-group">
                <label>Author Guidelines</label>
                <textarea name="author_guidelines" class="rich-editor" rows="5"><?php echo $journal ? sanitize($journal['author_guidelines'] ?? '') : ''; ?></textarea>
            </div>

            <div class="form-group">
                <label>Submission Content</label>
                <textarea name="submission_content" class="rich-editor" rows="5"><?php echo $journal ? sanitize($journal['submission_content'] ?? '') : ''; ?></textarea>
            </div>

            <div class="form-group">
                <label>Publication Ethics</label>
                <textarea name="publication_ethics" class="rich-editor" rows="5"><?php echo $journal ? sanitize($journal['publication_ethics'] ?? '') : ''; ?></textarea>
            </div>

            <h3 style="font-size: 1rem; border-bottom: 1px solid #e2e8f0; padding-bottom: 5px; margin-top: 30px; margin-bottom: 15px;">Statements &amp; Policies</h3>
            <div class="form-group">
                <label>Privacy Statement</label>
                <textarea name="privacy_statement" class="rich-editor" rows="3"><?php echo $journal ? sanitize($journal['privacy_statement'] ?? '') : ''; ?></textarea>
            </div>

            <div class="form-group">
                <label>Copyright Text</label>
                <textarea name="copyright_text" rows="3"><?php echo $journal ? sanitize($journal['copyright_text'] ?? '') : ''; ?></textarea>
            </div>

            <div class="form-group" style="margin-top: 20px;">
                <label style="display: flex; align-items: center; gap: 10px; cursor: pointer;">
                    <input type="checkbox" name="is_active" <?php echo (!$journal || $journal['is_active']) ? 'checked' : ''; ?>> Active / Visible on site
                </label>
            </div>

            <div style="margin-top: 25px;">
                <button type="submit" class="btn-admin btn-primary-admin"><?php echo $journal ? 'Update Journal Details' : 'Create New Journal'; ?></button>
            </div>
        </form>
    </div>
<?php
    endif;
else:
    // List Layout
    $journals = $db->query("SELECT * FROM journals ORDER BY sort_order ASC")->fetchAll();
?>
    <?php echo $message; ?>

    <div class="card-table">
        <div class="table-header" style="display: flex; justify-content: space-between; align-items: center;">
            <h2 style="font-size: 1.1rem; font-weight: 600; margin: 0;">All Journals</h2>
            <a href="journals.php?action=add" class="btn-admin btn-primary-admin" style="text-decoration: none; font-size: 0.85rem;">+ Add New Journal</a>
        </div>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Journal Name</th>
                    <th>Category</th>
                    <th>Impact Factor</th>
                    <th>APC</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($journals as $j): ?>
                <tr>
                    <td><?php echo $j['id']; ?></td>
                    <td><strong><?php echo sanitize($j['name']); ?></strong><br><small style="color: #64748b; font-size: 0.75rem;"><?php echo $j['slug']; ?></small></td>
                    <td><?php echo $j['subject_category']; ?></td>
                    <td><?php echo $j['impact_factor']; ?></td>
                    <td><?php echo $j['apc_currency'] . ' ' . $j['apc_amount']; ?></td>
                    <td>
                        <span class="badge <?php echo $j['is_active'] ? 'badge-success' : 'badge-danger'; ?>">
                            <?php echo $j['is_active'] ? 'Active' : 'Inactive'; ?>
                        </span>
                    </td>
                    <td>
                        <a href="journals.php?action=edit&id=<?php echo $j['id']; ?>" class="btn-admin" style="background: #e2e8f0; color: #1e293b; text-decoration: none; font-size: 0.75rem;">Edit</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php
endif;

$content = ob_get_clean();

// Add TinyMCE script for rich text editing
$content .= '
<script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/6.8.3/tinymce.min.js" referrerpolicy="origin"></script>
<script>
  tinymce.init({
    selector: ".rich-editor",
    plugins: "lists link code",
    toolbar: "undo redo | formatselect | bold italic | alignleft aligncenter alignright | bullist numlist outdent indent | code",
    menubar: false,
    height: 300,
    base_url: "https://cdnjs.cloudflare.com/ajax/libs/tinymce/6.8.3"
  });
</script>
';

renderAdminLayout($title, $content, $activeNav);
