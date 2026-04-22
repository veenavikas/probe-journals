<?php
require_once __DIR__ . '/../includes/admin-layout.php';

$title = "Contact Messages";
$activeNav = "messages";
$db = getDB();

$action = $_GET['action'] ?? 'list';
$msg_id = $_GET['id'] ?? null;
$message = '';

// Mark as read when viewing
if ($action === 'view' && $msg_id) {
    $stmt = $db->prepare("UPDATE contact_messages SET is_read = 1 WHERE id = ?");
    $stmt->execute([$msg_id]);
}

ob_start();

if ($action === 'view' && $msg_id):
    $stmt = $db->prepare("SELECT * FROM contact_messages WHERE id = ?");
    $stmt->execute([$msg_id]);
    $msg = $stmt->fetch();
    
    if (!$msg):
        echo "<p>Message not found.</p>";
    else:
?>
    <div style="margin-bottom: 20px;">
        <a href="contact-messages.php" style="text-decoration: none; color: #64748b;">&larr; Back to Messages</a>
    </div>
    
    <div class="card-table" style="padding: 40px; max-width: 800px; margin: 0 auto;">
        <div style="border-bottom: 1px solid #e2e8f0; padding-bottom: 20px; margin-bottom: 20px;">
            <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 10px;">
                <h2 style="font-family: 'DM Sans'; font-size: 1.25rem;"><?php echo sanitize($msg['subject']); ?></h2>
                <span style="font-size: 0.8rem; color: #94a3b8;"><?php echo date('F j, Y, g:i a', strtotime($msg['submitted_at'])); ?></span>
            </div>
            <div style="color: #64748b; font-size: 0.9rem;">
                From: <strong><?php echo sanitize($msg['first_name'] . ' ' . $msg['last_name']); ?></strong> 
                &lt;<?php echo sanitize($msg['email']); ?>&gt;
            </div>
        </div>
        
        <div style="line-height: 1.8; color: #1e293b; font-size: 1rem; white-space: pre-wrap;">
<?php echo sanitize($msg['message']); ?>
        </div>
        
        <div style="margin-top: 40px; padding-top: 20px; border-top: 1px solid #e2e8f0;">
            <a href="mailto:<?php echo $msg['email']; ?>?subject=Re: <?php echo rawurlencode($msg['subject']); ?>" class="btn-admin btn-primary-admin" style="text-decoration: none;">
                <i class="fas fa-reply"></i> Reply via Email
            </a>
        </div>
    </div>
<?php
    endif;
else:
    $messages = $db->query("SELECT * FROM contact_messages ORDER BY submitted_at DESC")->fetchAll();
?>
    <div class="card-table">
        <div class="table-header">
            <h2 style="font-size: 1.1rem; font-weight: 600;">Contact Inquiries</h2>
        </div>
        <table>
            <thead>
                <tr>
                    <th>From</th>
                    <th>Email</th>
                    <th>Subject</th>
                    <th>Date</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($messages as $m): ?>
                <tr style="<?php echo !$m['is_read'] ? 'background: #f1f5f9; font-weight: 600;' : ''; ?>">
                    <td><?php echo sanitize($m['first_name'] . ' ' . $m['last_name']); ?></td>
                    <td><?php echo sanitize($m['email']); ?></td>
                    <td><?php echo sanitize($m['subject']); ?></td>
                    <td><?php echo date('M j, Y', strtotime($m['submitted_at'])); ?></td>
                    <td>
                        <?php if (!$m['is_read']): ?>
                            <span class="badge badge-warning">Unread</span>
                        <?php else: ?>
                            <span class="badge" style="background: #e2e8f0; color: #64748b;">Read</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <a href="contact-messages.php?action=view&id=<?php echo $m['id']; ?>" class="btn-admin" style="background: #e2e8f0; color: #1e293b; text-decoration: none; font-size: 0.75rem;">Read</a>
                    </td>
                </tr>
                <?php endforeach; ?>
                <?php if (empty($messages)): ?>
                <tr>
                    <td colspan="6" style="text-align: center; padding: 40px; color: #94a3b8;">No messages received yet.</td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
<?php
endif;

$content = ob_get_clean();
renderAdminLayout($title, $content, $activeNav);
