<?php
require_once __DIR__ . '/../includes/admin-layout.php';

$title = "Manage Page Content";
$activeNav = "pages";
$db = getDB();

$message = '';
$action = $_GET['action'] ?? 'list';
$page_id = $_GET['id'] ?? null;

// Handle Add
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $action === 'add') {
    if (!verifyCSRFToken($_POST['csrf_token'])) {
        $message = '<div class="badge badge-danger">Security token mismatch.</div>';
    } else {
        $page_key = strtolower(trim(preg_replace('/[^a-zA-Z0-9_]/', '_', $_POST['page_key'])));
        $page_title = sanitize($_POST['page_title']);
        $content = $_POST['page_content'];
        $meta_title = sanitize($_POST['meta_title']);
        $meta_description = sanitize($_POST['meta_description']);
        
        try {
            $stmt = $db->prepare("INSERT INTO site_pages (page_key, page_title, content, meta_title, meta_description) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([$page_key, $page_title, $content, $meta_title, $meta_description]);
            $message = '<div class="badge badge-success" style="padding: 10px; margin-bottom: 20px;">Page content added successfully!</div>';
            $action = 'list'; // go back to list
        } catch (PDOException $e) {
            if ($e->getCode() == 23000) { // Duplicate entry
                $message = '<div class="badge badge-danger" style="padding: 10px; margin-bottom: 20px;">A page with this key already exists.</div>';
            } else {
                $message = '<div class="badge badge-danger" style="padding: 10px; margin-bottom: 20px;">Database error: ' . $e->getMessage() . '</div>';
            }
        }
    }
}

// Handle Update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $action === 'edit') {
    if (!verifyCSRFToken($_POST['csrf_token'])) {
        $message = '<div class="badge badge-danger">Security token mismatch.</div>';
    } else {
        $id = (int)$_POST['id'];
        $content = $_POST['page_content'];
        $meta_title = sanitize($_POST['meta_title']);
        $meta_description = sanitize($_POST['meta_description']);
        
        // We also allow updating the page title (not the key to avoid breaking hardcoded routes)
        $page_title = sanitize($_POST['page_title']);
        
        $stmt = $db->prepare("UPDATE site_pages SET page_title = ?, content = ?, meta_title = ?, meta_description = ? WHERE id = ?");
        if ($stmt->execute([$page_title, $content, $meta_title, $meta_description, $id])) {
            $message = '<div class="badge badge-success" style="padding: 10px; margin-bottom: 20px;">Page content updated successfully!</div>';
        }
    }
}

// Handle Delete
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $action === 'delete') {
    if (!verifyCSRFToken($_POST['csrf_token'])) {
        $message = '<div class="badge badge-danger">Security token mismatch.</div>';
    } else {
        $id = (int)$_POST['id'];
        $stmt = $db->prepare("DELETE FROM site_pages WHERE id = ?");
        if ($stmt->execute([$id])) {
            $message = '<div class="badge badge-success" style="padding: 10px; margin-bottom: 20px;">Page block deleted successfully!</div>';
        }
        $action = 'list';
    }
}

ob_start();

if ($action === 'add'):
?>
    <div style="margin-bottom: 20px;">
        <a href="pages.php" style="text-decoration: none; color: #64748b;">&larr; Back to List</a>
    </div>
    <?php echo $message; ?>
    <div class="card-table" style="padding: 30px;">
        <h2 style="margin-top:0; font-size: 1.2rem;">Add New Content Block</h2>
        <form action="pages.php?action=add" method="POST">
            <input type="hidden" name="csrf_token" value="<?php echo generateCSRFToken(); ?>">
            
            <div class="form-group">
                <label>Page Key (e.g., about_us, homepage_mission)</label>
                <input type="text" name="page_key" required placeholder="Lowercase letters, numbers, and underscores only">
            </div>

            <div class="form-group">
                <label>Page Title</label>
                <input type="text" name="page_title" required>
            </div>

            <div class="form-group">
                <label>Meta Title (Optional)</label>
                <input type="text" name="meta_title">
            </div>

            <div class="form-group">
                <label>Meta Description (Optional)</label>
                <textarea name="meta_description" rows="2"></textarea>
            </div>

            <div class="form-group">
                <label>Main Content (HTML Allowed)</label>
                <textarea name="page_content" rows="15" style="font-family: monospace; background: #f8fafc;"></textarea>
            </div>

            <button type="submit" class="btn-admin btn-primary-admin">Add Content Block</button>
        </form>
    </div>
<?php
elseif ($action === 'edit' && $page_id):
    $page = $db->prepare("SELECT * FROM site_pages WHERE id = ?");
    $page->execute([$page_id]);
    $page = $page->fetch();
    if (!$page):
        echo "<p>Page block not found.</p>";
    else:
?>
    <div style="margin-bottom: 20px;">
        <a href="pages.php" style="text-decoration: none; color: #64748b;">&larr; Back to List</a>
    </div>
    <?php echo $message; ?>
    <div class="card-table" style="padding: 30px;">
        <form action="pages.php?action=edit&id=<?php echo $page['id']; ?>" method="POST">
            <input type="hidden" name="csrf_token" value="<?php echo generateCSRFToken(); ?>">
            <input type="hidden" name="id" value="<?php echo $page['id']; ?>">
            
            <div class="form-group">
                <label>Page Block Key</label>
                <input type="text" value="<?php echo sanitize($page['page_key']); ?>" disabled style="background: #e2e8f0; cursor: not-allowed;">
                <p style="font-size: 0.8rem; color: #64748b; margin-bottom: 10px;">The key cannot be changed because it may be hardcoded into site templates.</p>
            </div>

            <div class="form-group">
                <label>Page Title</label>
                <input type="text" name="page_title" value="<?php echo sanitize($page['page_title']); ?>" required>
            </div>

            <div class="form-group">
                <label>Meta Title</label>
                <input type="text" name="meta_title" value="<?php echo sanitize($page['meta_title'] ?? ''); ?>">
            </div>

            <div class="form-group">
                <label>Meta Description</label>
                <textarea name="meta_description" rows="2"><?php echo sanitize($page['meta_description'] ?? ''); ?></textarea>
            </div>

            <div class="form-group">
                <label>Main Content (HTML Allowed)</label>
                <textarea name="page_content" rows="15" style="font-family: monospace; background: #f8fafc;"><?php echo htmlspecialchars($page['content']); ?></textarea>
            </div>

            <button type="submit" class="btn-admin btn-primary-admin">Save Page Content</button>
        </form>
    </div>
<?php
    endif;
else:
    // List all page blocks
    $pages = $db->query("SELECT * FROM site_pages ORDER BY page_key ASC")->fetchAll();
?>
    <?php echo $message; ?>
    <div class="card-table">
        <div class="table-header" style="display: flex; justify-content: space-between; align-items: center;">
            <h2 style="font-size: 1.1rem; font-weight: 600; margin: 0;">Website Content Blocks</h2>
            <a href="pages.php?action=add" class="btn-admin btn-primary-admin" style="text-decoration: none; font-size: 0.85rem;"><i class="fas fa-plus"></i> Add New Block</a>
        </div>
        
        <?php if (empty($pages)): ?>
            <p style='padding: 20px;'>No page blocks found. Click 'Add New Block' to create one.</p>
        <?php else: ?>
        <table>
            <thead>
                <tr>
                    <th>Key</th>
                    <th>Title</th>
                    <th>Last Updated</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($pages as $p): ?>
                <tr>
                    <td><code><?php echo sanitize($p['page_key']); ?></code></td>
                    <td><strong><?php echo sanitize($p['page_title']); ?></strong></td>
                    <td><?php echo date('M j, Y H:i', strtotime($p['updated_at'])); ?></td>
                    <td style="display: flex; gap: 10px;">
                        <a href="pages.php?action=edit&id=<?php echo $p['id']; ?>" class="btn-admin" style="background: #e2e8f0; color: #1e293b; text-decoration: none; font-size: 0.75rem;">Edit Content</a>
                        
                        <form action="pages.php?action=delete" method="POST" onsubmit="return confirm('Are you sure you want to delete this content block?');" style="margin: 0;">
                            <input type="hidden" name="csrf_token" value="<?php echo generateCSRFToken(); ?>">
                            <input type="hidden" name="id" value="<?php echo $p['id']; ?>">
                            <button type="submit" class="btn-admin" style="background: #ef4444; color: white; border: none; font-size: 0.75rem; cursor: pointer;">Delete</button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <?php endif; ?>
    </div>
<?php
endif;

$content = ob_get_clean();
renderAdminLayout($title, $content, $activeNav);
