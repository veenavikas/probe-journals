<?php
require_once __DIR__ . '/../includes/admin-layout.php';

$title = "Manage Journals";
$activeNav = "journals";
$db = getDB();

$action = $_GET['action'] ?? 'list';
$journal_id = $_GET['id'] ?? null;
$message = '';

// Handle Form Submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $action === 'edit') {
    if (!verifyCSRFToken($_POST['csrf_token'])) {
        $message = '<div class="badge badge-danger">Security token mismatch.</div>';
    } else {
        $id = (int)$_POST['id'];
        $name = sanitize($_POST['name']);
        $slug = sanitize($_POST['slug']);
        $short_name = sanitize($_POST['short_name']);
        $category = sanitize($_POST['subject_category']);
        $description = $_POST['description'];
        $aim_and_scope = $_POST['aim_and_scope'];
        $impact_factor = (float)$_POST['impact_factor'];
        $cite_score = (float)$_POST['cite_score'];
        $h_index = (int)$_POST['h_index'];
        $apc = (float)$_POST['apc_amount'];
        
        $sql = "UPDATE journals SET 
                name = ?, slug = ?, short_name = ?, subject_category = ?, 
                description = ?, aim_and_scope = ?, impact_factor = ?, 
                cite_score = ?, h_index = ?, apc_amount = ? 
                WHERE id = ?";
        $stmt = $db->prepare($sql);
        if ($stmt->execute([$name, $slug, $short_name, $category, $description, $aim_and_scope, $impact_factor, $cite_score, $h_index, $apc, $id])) {
            $message = '<div class="badge badge-success" style="padding: 10px; margin-bottom: 20px;">Journal updated successfully!</div>';
        } else {
            $message = '<div class="badge badge-danger">Failed to update journal.</div>';
        }
    }
}

ob_start();

if ($action === 'edit' && $journal_id):
    $journal = getJournalById((int)$journal_id);
    if (!$journal):
        echo "<p>Journal not found.</p>";
    else:
?>
    <div style="margin-bottom: 20px;">
        <a href="journals.php" style="text-decoration: none; color: #64748b;">&larr; Back to List</a>
    </div>

    <?php echo $message; ?>

    <div class="card-table" style="padding: 30px;">
        <form action="journals.php?action=edit&id=<?php echo $journal['id']; ?>" method="POST">
            <input type="hidden" name="csrf_token" value="<?php echo generateCSRFToken(); ?>">
            <input type="hidden" name="id" value="<?php echo $journal['id']; ?>">
            
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                <div class="form-group">
                    <label>Journal Name</label>
                    <input type="text" name="name" value="<?php echo sanitize($journal['name']); ?>" required>
                </div>
                <div class="form-group">
                    <label>Slug (URL pathway)</label>
                    <input type="text" name="slug" value="<?php echo sanitize($journal['slug']); ?>" required>
                </div>
                <div class="form-group">
                    <label>Short Name (e.g. JOB)</label>
                    <input type="text" name="short_name" value="<?php echo sanitize($journal['short_name']); ?>">
                </div>
                <div class="form-group">
                    <label>Subject Category</label>
                    <select name="subject_category">
                        <option value="Clinical Sciences" <?php echo $journal['subject_category'] == 'Clinical Sciences' ? 'selected' : ''; ?>>Clinical Sciences</option>
                        <option value="Medical Sciences" <?php echo $journal['subject_category'] == 'Medical Sciences' ? 'selected' : ''; ?>>Medical Sciences</option>
                        <option value="General Sciences" <?php echo $journal['subject_category'] == 'General Sciences' ? 'selected' : ''; ?>>General Sciences</option>
                        <option value="Engineering" <?php echo $journal['subject_category'] == 'Engineering' ? 'selected' : ''; ?>>Engineering</option>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label>Description</label>
                <textarea name="description" rows="5"><?php echo sanitize($journal['description'] ?? ''); ?></textarea>
            </div>

            <div class="form-group">
                <label>Aim & Scope / Guidelines</label>
                <textarea name="aim_and_scope" rows="5"><?php echo sanitize($journal['aim_and_scope'] ?? ''); ?></textarea>
            </div>

            <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px;">
                <div class="form-group">
                    <label>Impact Factor</label>
                    <input type="number" step="0.01" name="impact_factor" value="<?php echo $journal['impact_factor']; ?>">
                </div>
                <div class="form-group">
                    <label>Cite Score</label>
                    <input type="number" step="0.01" name="cite_score" value="<?php echo $journal['cite_score']; ?>">
                </div>
                <div class="form-group">
                    <label>H-Index</label>
                    <input type="number" name="h_index" value="<?php echo $journal['h_index']; ?>">
                </div>
                <div class="form-group">
                    <label>APC Amount</label>
                    <input type="number" step="0.01" name="apc_amount" value="<?php echo $journal['apc_amount']; ?>">
                </div>
            </div>

            <div style="margin-top: 20px;">
                <button type="submit" class="btn-admin btn-primary-admin">Update Journal Details</button>
            </div>
        </form>
    </div>
<?php
    endif;
else:
    // List Layout
    $journals = $db->query("SELECT * FROM journals ORDER BY sort_order ASC")->fetchAll();
?>
    <div class="card-table">
        <div class="table-header">
            <h2 style="font-size: 1.1rem; font-weight: 600;">All Journals</h2>
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
renderAdminLayout($title, $content, $activeNav);
