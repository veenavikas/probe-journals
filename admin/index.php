<?php
require_once __DIR__ . '/../includes/admin-layout.php';

$title = "Dashboard";
$activeNav = "dashboard";

$db = getDB();

// Fetch statistics
$totalArticles = $db->query("SELECT COUNT(*) FROM articles")->fetchColumn();
$totalSubmissions = $db->query("SELECT COUNT(*) FROM submissions")->fetchColumn();
$unreadMessages = getUnreadMessageCount();
$totalEditors = $db->query("SELECT COUNT(*) FROM editors")->fetchColumn();

// Fetch recent 5 submissions
$stmt = $db->query("SELECT s.*, j.short_name FROM submissions s LEFT JOIN journals j ON s.journal_id = j.id ORDER BY s.submitted_at DESC LIMIT 5");
$recentSubmissions = $stmt->fetchAll();

ob_start();
?>

<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon" style="background: #e0e7ff; color: #4338ca;">
            <i class="fas fa-file-alt"></i>
        </div>
        <div class="stat-info">
            <h3>Total Articles</h3>
            <p><?php echo $totalArticles; ?></p>
        </div>
    </div>
    
    <div class="stat-card">
        <div class="stat-icon" style="background: #fef3c7; color: #b45309;">
            <i class="fas fa-paper-plane"></i>
        </div>
        <div class="stat-info">
            <h3>Submissions</h3>
            <p><?php echo $totalSubmissions; ?></p>
        </div>
    </div>
    
    <div class="stat-card">
        <div class="stat-icon" style="background: #fee2e2; color: #b91c1c;">
            <i class="fas fa-envelope"></i>
        </div>
        <div class="stat-info">
            <h3>Unread Messages</h3>
            <p><?php echo $unreadMessages; ?></p>
        </div>
    </div>
    
    <div class="stat-card">
        <div class="stat-icon" style="background: #dcfce7; color: #15803d;">
            <i class="fas fa-users"></i>
        </div>
        <div class="stat-info">
            <h3>Total Editors</h3>
            <p><?php echo $totalEditors; ?></p>
        </div>
    </div>
</div>

<div class="card-table">
    <div class="table-header">
        <h2 style="font-size: 1.1rem; font-weight: 600;">Recent Submissions</h2>
        <a href="submissions-inbox.php" class="btn-admin" style="background: #f1f5f9; color: #475569; text-decoration: none; font-size: 0.8rem;">View All</a>
    </div>
    <table>
        <thead>
            <tr>
                <th>Journal</th>
                <th>Author</th>
                <th>Title</th>
                <th>Status</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($recentSubmissions)): ?>
                <tr>
                    <td colspan="5" style="text-align: center; padding: 40px; color: #64748b;">No submissions yet.</td>
                </tr>
            <?php else: ?>
                <?php foreach ($recentSubmissions as $sub): ?>
                <tr>
                    <td><strong><?php echo $sub['short_name'] ?: 'N/A'; ?></strong></td>
                    <td><?php echo sanitize($sub['author_name']); ?></td>
                    <td><?php echo sanitize($sub['article_title']); ?></td>
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
                        <span class="badge <?php echo $statusClass[$sub['status']] ?? 'badge-warning'; ?>">
                            <?php echo ucfirst(str_replace('_', ' ', $sub['status'])); ?>
                        </span>
                    </td>
                    <td><?php echo date('M j, Y', strtotime($sub['submitted_at'])); ?></td>
                </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<div style="margin-top: 32px; display: grid; grid-template-columns: 1fr 1fr; gap: 24px;">
    <div class="neumorphic" style="background: white; box-shadow: none; border: 1px solid #e2e8f0;">
        <h3 style="margin-bottom: 20px; font-size: 1rem;">Quick Actions</h3>
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
            <a href="articles.php?action=add" class="btn-admin btn-primary-admin" style="text-align: center; text-decoration: none;">Add Article</a>
            <a href="journals.php" class="btn-admin" style="text-align: center; text-decoration: none; border: 1px solid #e2e8f0;">Manage Journals</a>
            <a href="editors.php?action=add" class="btn-admin" style="text-align: center; text-decoration: none; border: 1px solid #e2e8f0;">Add Editor</a>
            <a href="settings.php" class="btn-admin" style="text-align: center; text-decoration: none; border: 1px solid #e2e8f0;">Site Settings</a>
        </div>
    </div>
    
    <div class="neumorphic" style="background: white; box-shadow: none; border: 1px solid #e2e8f0;">
        <h3 style="margin-bottom: 20px; font-size: 1rem;">System Info</h3>
        <ul style="color: #64748b; font-size: 0.9rem;">
            <li style="margin-bottom: 10px; display: flex; justify-content: space-between;">
                <span>PHP Version:</span> <strong><?php echo phpversion(); ?></strong>
            </li>
            <li style="margin-bottom: 10px; display: flex; justify-content: space-between;">
                <span>Database:</span> <strong>MySQL 8.0</strong>
            </li>
            <li style="margin-bottom: 10px; display: flex; justify-content: space-between;">
                <span>Environment:</span> <strong>Development</strong>
            </li>
        </ul>
    </div>
</div>

<?php
$content = ob_get_clean();
renderAdminLayout($title, $content, $activeNav);
