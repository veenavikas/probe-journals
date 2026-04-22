<?php
require_once __DIR__ . '/../includes/admin-layout.php';

$title = "Submissions Inbox";
$activeNav = "submissions";
$db = getDB();

$action = $_GET['action'] ?? 'list';
$sub_id = $_GET['id'] ?? null;
$message = '';

// Handle Status Update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $action === 'view') {
    if (!verifyCSRFToken($_POST['csrf_token'])) {
        $message = '<div class="badge badge-danger">Security token mismatch.</div>';
    } else {
        $id = (int)$_POST['id'];
        $status = $_POST['status'];
        $admin_notes = $_POST['admin_notes'];
        
        $stmt = $db->prepare("UPDATE submissions SET status = ?, admin_notes = ? WHERE id = ?");
        if ($stmt->execute([$status, $admin_notes, $id])) {
            $message = '<div class="badge badge-success" style="padding: 10px; margin-bottom: 20px;">Submission status updated!</div>';
        }
    }
}

ob_start();

if ($action === 'view' && $sub_id):
    $stmt = $db->prepare("SELECT s.*, j.name as journal_name FROM submissions s LEFT JOIN journals j ON s.journal_id = j.id WHERE s.id = ?");
    $stmt->execute([$sub_id]);
    $sub = $stmt->fetch();
    
    if (!$sub):
        echo "<p>Submission not found.</p>";
    else:
?>
    <div style="margin-bottom: 20px;">
        <a href="submissions-inbox.php" style="text-decoration: none; color: #64748b;">&larr; Back to Inbox</a>
    </div>
    <?php echo $message; ?>
    
    <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 30px;">
        <div class="card-table" style="padding: 30px;">
            <h3 style="margin-bottom: 20px; font-family: 'DM Sans'; font-size: 1.1rem; border-bottom: 1px solid #e2e8f0; padding-bottom: 10px;">Submission Details</h3>
            
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 30px;">
                <div>
                    <label style="color: #64748b; font-size: 0.8rem;">Journal</label>
                    <p><strong><?php echo sanitize($sub['journal_name']); ?></strong></p>
                </div>
                <div>
                    <label style="color: #64748b; font-size: 0.8rem;">Article Type</label>
                    <p><?php echo sanitize($sub['article_type']); ?></p>
                </div>
                <div style="grid-column: span 2;">
                    <label style="color: #64748b; font-size: 0.8rem;">Article Title</label>
                    <p style="font-weight: 600; font-size: 1.1rem;"><?php echo sanitize($sub['article_title']); ?></p>
                </div>
            </div>
            
            <div style="margin-bottom: 30px;">
                <label style="color: #64748b; font-size: 0.8rem;">Abstract</label>
                <div style="background: #f8fafc; padding: 15px; border-radius: 8px; font-size: 0.9rem; margin-top: 5px;">
                    <?php echo nl2br(sanitize($sub['abstract'])); ?>
                </div>
            </div>
            
            <div style="margin-bottom: 30px;">
                <label style="color: #64748b; font-size: 0.8rem;">Corresponding Author</label>
                <p><strong><?php echo sanitize($sub['author_name']); ?></strong> (<?php echo sanitize($sub['author_email']); ?>)</p>
                <p style="font-size: 0.85rem; color: #64748b;"><?php echo sanitize($sub['author_institution']); ?>, <?php echo sanitize($sub['author_country']); ?></p>
            </div>
            
            <?php if (!empty($sub['co_authors'])): ?>
            <div style="margin-bottom: 30px;">
                <label style="color: #64748b; font-size: 0.8rem;">Co-Authors</label>
                <p style="font-size: 0.9rem;"><?php echo sanitize($sub['co_authors']); ?></p>
            </div>
            <?php endif; ?>

            <div style="margin-bottom: 30px;">
                <label style="color: #64748b; font-size: 0.8rem;">Manuscript File</label>
                <div style="margin-top: 5px;">
                    <a href="<?php echo UPLOAD_URL . $sub['manuscript_file']; ?>" target="_blank" class="btn-admin" style="background: #4F46E5; color: white; text-decoration: none; display: inline-flex; align-items: center; gap: 8px;">
                        <i class="fas fa-file-pdf"></i> Download Manuscript
                    </a>
                </div>
            </div>
        </div>
        
        <div class="card-table" style="padding: 30px; height: fit-content;">
            <h3 style="margin-bottom: 20px; font-family: 'DM Sans'; font-size: 1rem;">Action & Notes</h3>
            <form action="submissions-inbox.php?action=view&id=<?php echo $sub['id']; ?>" method="POST">
                <input type="hidden" name="csrf_token" value="<?php echo generateCSRFToken(); ?>">
                <input type="hidden" name="id" value="<?php echo $sub['id']; ?>">
                
                <div class="form-group">
                    <label>Current Status</label>
                    <select name="status">
                        <option value="new" <?php echo $sub['status'] == 'new' ? 'selected' : ''; ?>>New Submission</option>
                        <option value="under_review" <?php echo $sub['status'] == 'under_review' ? 'selected' : ''; ?>>Under Review</option>
                        <option value="revision_requested" <?php echo $sub['status'] == 'revision_requested' ? 'selected' : ''; ?>>Revision Requested</option>
                        <option value="accepted" <?php echo $sub['status'] == 'accepted' ? 'selected' : ''; ?>>Accepted</option>
                        <option value="rejected" <?php echo $sub['status'] == 'rejected' ? 'selected' : ''; ?>>Rejected</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label>Admin Notes (Internal)</label>
                    <textarea name="admin_notes" rows="6"><?php echo sanitize($sub['admin_notes'] ?? ''); ?></textarea>
                </div>
                
                <button type="submit" class="btn-admin btn-primary-admin" style="width: 100%;">Update Status</button>
            </form>
            
            <p style="font-size: 0.75rem; color: #94a3b8; margin-top: 15px; text-align: center;">Submitted on: <?php echo date('F j, Y, g:i a', strtotime($sub['submitted_at'])); ?></p>
        </div>
    </div>
<?php
    endif;
else:
    $submissions = $db->query("SELECT s.*, j.short_name FROM submissions s LEFT JOIN journals j ON s.journal_id = j.id ORDER BY s.submitted_at DESC")->fetchAll();
?>
    <div class="card-table">
        <div class="table-header">
            <h2 style="font-size: 1.1rem; font-weight: 600;">Incoming Submissions</h2>
        </div>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Journal</th>
                    <th>Author</th>
                    <th>Article Title</th>
                    <th>Status</th>
                    <th>Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($submissions as $s): ?>
                <tr>
                    <td>#<?php echo $s['id']; ?></td>
                    <td><strong><?php echo $s['short_name'] ?: 'N/A'; ?></strong></td>
                    <td>
                        <div style="font-weight: 600; font-size: 0.9rem;"><?php echo sanitize($s['author_name']); ?></div>
                        <div style="font-size: 0.75rem; color: #64748b;"><?php echo sanitize($s['author_email']); ?></div>
                    </td>
                    <td>
                        <div style="font-size: 0.85rem; max-width: 250px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                            <?php echo sanitize($s['article_title']); ?>
                        </div>
                    </td>
                    <td>
                        <?php 
                        $statusClass = [
                            'new' => 'badge-warning',
                            'under_review' => 'badge-info',
                            'accepted' => 'badge-success',
                            'rejected' => 'badge-danger',
                            'revision_requested' => 'badge-warning'
                        ];
                        ?>
                        <span class="badge <?php echo $statusClass[$s['status']] ?? 'badge-warning'; ?>">
                            <?php echo ucfirst(str_replace('_', ' ', $s['status'])); ?>
                        </span>
                    </td>
                    <td><?php echo date('M j, Y', strtotime($s['submitted_at'])); ?></td>
                    <td>
                        <a href="submissions-inbox.php?action=view&id=<?php echo $s['id']; ?>" class="btn-admin" style="background: #e2e8f0; color: #1e293b; text-decoration: none; font-size: 0.75rem;">View</a>
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
