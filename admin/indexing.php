<?php
require_once __DIR__ . '/../includes/admin-layout.php';

$title = "Indexing Partners";
$activeNav = "indexing";
$db = getDB();

$action = $_GET['action'] ?? 'list';
$p_id = $_GET['id'] ?? null;
$message = '';

// Handle Deletion
if ($action === 'delete' && $p_id) {
    if (!verifyCSRFToken($_GET['token'] ?? '')) {
        $message = '<div class="badge badge-danger">Security token mismatch. Delete aborted.</div>';
    } else {
        $stmt = $db->prepare("SELECT logo FROM indexing_partners WHERE id = ?");
        $stmt->execute([$p_id]);
        $fileInfo = $stmt->fetch();
        if ($fileInfo && $fileInfo['logo']) {
            deleteFile($fileInfo['logo'], 'indexing');
        }
        $stmt = $db->prepare("DELETE FROM indexing_partners WHERE id = ?");
        $stmt->execute([$p_id]);
        header("Location: indexing.php?msg=deleted");
        exit();
    }
}

// Handle Add/Edit
if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($action === 'add' || $action === 'edit')) {
    if (!verifyCSRFToken($_POST['csrf_token'])) {
        $message = '<div class="badge badge-danger">Security token mismatch.</div>';
    } else {
        $data = [
            'name'        => sanitize($_POST['name']),
            'website_url' => sanitize($_POST['website_url']),
            'sort_order'  => (int)$_POST['sort_order'],
            'is_active'   => isset($_POST['is_active']) ? 1 : 0
        ];

        if (!empty($_FILES['logo']['name'])) {
            $uploaded = uploadFile($_FILES['logo'], 'indexing');
            if ($uploaded) {
                if ($action === 'edit' && !empty($_POST['old_logo'])) {
                    deleteFile($_POST['old_logo'], 'indexing');
                }
                $data['logo'] = $uploaded;
            }
        } elseif ($action === 'edit') {
            $data['logo'] = $_POST['old_logo'] ?? null;
        }

        if ($action === 'add') {
            $fields = implode(', ', array_keys($data));
            $placeholders = implode(', ', array_fill(0, count($data), '?'));
            $stmt = $db->prepare("INSERT INTO indexing_partners ($fields) VALUES ($placeholders)");
            $stmt->execute(array_values($data));
            header("Location: indexing.php?msg=added");
            exit();
        } else {
            $id = (int)$_POST['id'];
            $sets = [];
            foreach ($data as $k => $v) $sets[] = "$k = ?";
            $stmt = $db->prepare("UPDATE indexing_partners SET " . implode(', ', $sets) . " WHERE id = ?");
            $stmt->execute(array_merge(array_values($data), [$id]));
            $message = '<div class="badge badge-success" style="padding: 10px; margin-bottom: 20px;">Partner updated!</div>';
        }
    }
}

ob_start();

if ($action === 'add' || ($action === 'edit' && $p_id)):
    $partner = ($action === 'edit') ? $db->prepare("SELECT * FROM indexing_partners WHERE id = ?") : null;
    if ($partner) { $partner->execute([$p_id]); $partner = $partner->fetch(); }
?>
    <div style="margin-bottom: 20px;">
        <a href="indexing.php" style="text-decoration: none; color: #64748b;">&larr; Back to List</a>
    </div>
    <?php echo $message; ?>
    <div class="card-table" style="padding: 30px;">
        <form action="indexing.php?action=<?php echo $action; ?><?php echo $p_id ? '&id='.$p_id : ''; ?>" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="csrf_token" value="<?php echo generateCSRFToken(); ?>">
            <?php if ($partner): ?>
                <input type="hidden" name="id" value="<?php echo $partner['id']; ?>">
                <input type="hidden" name="old_logo" value="<?php echo $partner['logo']; ?>">
            <?php endif; ?>

            <div class="form-group">
                <label>Partner Name</label>
                <input type="text" name="name" value="<?php echo sanitize($partner['name'] ?? ''); ?>" required>
            </div>
            
            <div class="form-group">
                <label>Website URL</label>
                <input type="text" name="website_url" value="<?php echo sanitize($partner['website_url'] ?? ''); ?>">
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                <div class="form-group">
                    <label>Logo File (MIME-checked)</label>
                    <input type="file" name="logo" accept="image/*">
                    <?php if ($partner && $partner['logo']): ?>
                        <div style="margin-top: 10px; background: #f1f5f9; padding: 10px; border-radius: 8px; display: inline-block;">
                            <img src="<?php echo UPLOAD_URL . $partner['logo']; ?>" style="max-height: 50px;">
                        </div>
                    <?php endif; ?>
                </div>
                <div class="form-group">
                    <label>Sort Order</label>
                    <input type="number" name="sort_order" value="<?php echo $partner['sort_order'] ?? 0; ?>">
                </div>
            </div>

            <div class="form-group">
                <label style="display: flex; align-items: center; gap: 10px; cursor: pointer;">
                    <input type="checkbox" name="is_active" <?php echo (!$partner || $partner['is_active']) ? 'checked' : ''; ?>> Active
                </label>
            </div>

            <button type="submit" class="btn-admin btn-primary-admin"><?php echo $partner ? 'Update Partner' : 'Add Partner'; ?></button>
        </form>
    </div>
<?php else:
    $partners = $db->query("SELECT * FROM indexing_partners ORDER BY sort_order ASC")->fetchAll();
    if (isset($_GET['msg'])) echo '<div class="badge badge-success" style="padding: 10px; margin-bottom: 20px;">Operation successful!</div>';
?>
    <div class="card-table">
        <div class="table-header">
            <h2 style="font-size: 1.1rem; font-weight: 600;">Indexing & Associated Partners</h2>
            <a href="indexing.php?action=add" class="btn-admin btn-primary-admin" style="text-decoration: none; font-size: 0.85rem;">+ Add Partner</a>
        </div>
        <table>
            <thead>
                <tr>
                    <th>Logo</th>
                    <th>Name</th>
                    <th>Website</th>
                    <th>Sort</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($partners as $p): ?>
                <tr>
                    <td>
                        <div style="background: #f8fafc; padding: 5px; border-radius: 4px; display: inline-block;">
                            <?php if ($p['logo']): ?>
                                <img src="<?php echo UPLOAD_URL . $p['logo']; ?>" style="max-height: 30px;">
                            <?php else: ?>
                                <span style="font-size: 0.7rem; color: #94a3b8;">No Logo</span>
                            <?php endif; ?>
                        </div>
                    </td>
                    <td><strong><?php echo sanitize($p['name']); ?></strong></td>
                    <td><a href="<?php echo sanitize($p['website_url']); ?>" target="_blank" style="color: var(--admin-active); font-size: 0.8rem;"><?php echo sanitize($p['website_url']); ?></a></td>
                    <td><?php echo $p['sort_order']; ?></td>
                    <td>
                        <span class="badge <?php echo $p['is_active'] ? 'badge-success' : 'badge-danger'; ?>">
                            <?php echo $p['is_active'] ? 'Active' : 'Hidden'; ?>
                        </span>
                    </td>
                    <td>
                        <div style="display: flex; gap: 5px;">
                            <a href="indexing.php?action=edit&id=<?php echo $p['id']; ?>" class="btn-admin" style="background: #e2e8f0; color: #1e293b; text-decoration: none; font-size: 0.7rem;">Edit</a>
                            <a href="indexing.php?action=delete&id=<?php echo $p['id']; ?>&token=<?php echo generateCSRFToken(); ?>" class="btn-admin" style="background: #fee2e2; color: #991b1b; text-decoration: none; font-size: 0.7rem;" onclick="return confirm('Remove partner?')">Del</a>
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
