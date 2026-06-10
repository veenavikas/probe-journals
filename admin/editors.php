<?php
require_once __DIR__ . '/../includes/admin-layout.php';

$title = "Manage Editorial Board";
$activeNav = "editors";
$db = getDB();

$action = $_GET['action'] ?? 'list';
$editor_id = $_GET['id'] ?? null;
$message = '';

// Handle Deletion
if ($action === 'delete' && $editor_id) {
    if (!verifyCSRFToken($_GET['token'] ?? '')) {
        $message = '<div class="badge badge-danger">Security token mismatch. Delete aborted.</div>';
    } else {
        $editor = $db->prepare("SELECT photo FROM editors WHERE id = ?");
        $editor->execute([$editor_id]);
        $fileInfo = $editor->fetch();
        
        if ($fileInfo && $fileInfo['photo']) {
            deleteFile($fileInfo['photo'], 'editor');
        }
        
        $stmt = $db->prepare("DELETE FROM editors WHERE id = ?");
        $stmt->execute([$editor_id]);
        header("Location: editors.php?msg=deleted");
        exit();
    }
}

// Handle Add/Edit
if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($action === 'add' || $action === 'edit')) {
    if (!verifyCSRFToken($_POST['csrf_token'] ?? '')) {
        $message = '<div class="badge badge-danger">Security token mismatch.</div>';
    } else {
        $data = [
            'journal_id'  => (int)$_POST['journal_id'],
            'full_name'   => sanitize($_POST['full_name']),
            'role'        => sanitize($_POST['role']),
            'institution' => sanitize($_POST['institution']),
            'country'     => sanitize($_POST['country']),
            'email'       => sanitize($_POST['email']),
            'bio'         => $_POST['bio'],
            'sort_order'  => (int)$_POST['sort_order'],
            'is_active'   => isset($_POST['is_active']) ? 1 : 0
        ];

        $upload_failed = false;
        if (!empty($_FILES['photo']['name'])) {
            $uploaded = uploadFile($_FILES['photo'], 'editor');
            if ($uploaded) {
                if ($action === 'edit' && !empty($_POST['old_photo'])) {
                    deleteFile($_POST['old_photo'], 'editor');
                }
                $data['photo'] = $uploaded;
            } else {
                $message = '<div class="badge badge-danger">Failed to upload photo. Please verify folder permissions (755) and file size/type constraints (max 2MB, JPEG/PNG/WebP).</div>';
                $upload_failed = true;
            }
        } elseif ($action === 'edit') {
            $data['photo'] = $_POST['old_photo'] ?? null;
        }

        if (!$upload_failed) {
            if ($action === 'add') {
                $fields = implode(', ', array_keys($data));
                $placeholders = implode(', ', array_fill(0, count($data), '?'));
                $stmt = $db->prepare("INSERT INTO editors ($fields) VALUES ($placeholders)");
                $stmt->execute(array_values($data));
                header("Location: editors.php?msg=added");
                exit();
            } else {
                $id = (int)$_POST['id'];
                $sets = [];
                foreach ($data as $k => $v) $sets[] = "$k = ?";
                $stmt = $db->prepare("UPDATE editors SET " . implode(', ', $sets) . " WHERE id = ?");
                $stmt->execute(array_merge(array_values($data), [$id]));
                $message = '<div class="badge badge-success" style="padding: 10px; margin-bottom: 20px;">Editor updated!</div>';
            }
        }
    }
}

ob_start();

if ($action === 'add' || ($action === 'edit' && $editor_id)):
    $editor = ($action === 'edit') ? $db->prepare("SELECT * FROM editors WHERE id = ?") : null;
    if ($editor) { $editor->execute([$editor_id]); $editor = $editor->fetch(); }
    $journals = getAllJournals();
?>
    <div style="margin-bottom: 20px;">
        <a href="editors.php" style="text-decoration: none; color: #64748b;">&larr; Back to List</a>
    </div>
    <?php echo $message; ?>
    <div class="card-table" style="padding: 30px;">
        <form action="editors.php?action=<?php echo $action; ?><?php echo $editor_id ? '&id='.$editor_id : ''; ?>" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="csrf_token" value="<?php echo generateCSRFToken(); ?>">
            <?php if ($editor): ?>
                <input type="hidden" name="id" value="<?php echo $editor['id']; ?>">
                <input type="hidden" name="old_photo" value="<?php echo $editor['photo']; ?>">
            <?php endif; ?>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                <div class="form-group">
                    <label>Journal</label>
                    <select name="journal_id" required>
                        <?php foreach ($journals as $j): ?>
                        <option value="<?php echo $j['id']; ?>" <?php echo ($editor && $editor['journal_id'] == $j['id']) ? 'selected' : ''; ?>><?php echo sanitize($j['name']); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label>Full Name</label>
                    <input type="text" name="full_name" value="<?php echo sanitize($editor['full_name'] ?? ''); ?>" required>
                </div>
                <div class="form-group">
                    <label>Role</label>
                    <input type="text" name="role" value="<?php echo sanitize($editor['role'] ?? ''); ?>" placeholder="Editor in Chief / Associate Editor etc.">
                </div>
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" value="<?php echo sanitize($editor['email'] ?? ''); ?>">
                </div>
                <div class="form-group">
                    <label>Institution</label>
                    <input type="text" name="institution" value="<?php echo sanitize($editor['institution'] ?? ''); ?>">
                </div>
                <div class="form-group">
                    <label>Country</label>
                    <input type="text" name="country" value="<?php echo sanitize($editor['country'] ?? ''); ?>">
                </div>
            </div>

            <div class="form-group">
                <label>Brief Bio</label>
                <textarea name="bio" rows="4"><?php echo sanitize($editor['bio'] ?? ''); ?></textarea>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                <div class="form-group">
                    <label>Photo (Max 2MB)</label>
                    <input type="file" name="photo" accept="image/*">
                    <?php if ($editor && $editor['photo']): ?>
                        <div style="margin-top: 10px;"><img src="<?php echo UPLOAD_URL . $editor['photo']; ?>" style="width: 60px; height: 60px; border-radius: 50%; object-fit: cover;"></div>
                    <?php endif; ?>
                </div>
                <div class="form-group">
                    <label>Sort Order</label>
                    <input type="number" name="sort_order" value="<?php echo $editor['sort_order'] ?? 0; ?>">
                </div>
            </div>

            <div class="form-group">
                <label style="display: flex; align-items: center; gap: 10px; cursor: pointer;">
                    <input type="checkbox" name="is_active" <?php echo (!$editor || $editor['is_active']) ? 'checked' : ''; ?>> Active Status
                </label>
            </div>

            <button type="submit" class="btn-admin btn-primary-admin"><?php echo $editor ? 'Update Editor' : 'Add Editor'; ?></button>
        </form>
    </div>
<?php else:
    $editors = $db->query("SELECT e.*, j.short_name FROM editors e LEFT JOIN journals j ON e.journal_id = j.id ORDER BY j.name ASC, e.sort_order ASC")->fetchAll();
    if (isset($_GET['msg'])) echo '<div class="badge badge-success" style="padding: 10px; margin-bottom: 20px;">Operation successful!</div>';
?>
    <div class="card-table">
        <div class="table-header">
            <h2 style="font-size: 1.1rem; font-weight: 600;">Editorial Board Members</h2>
            <a href="editors.php?action=add" class="btn-admin btn-primary-admin" style="text-decoration: none; font-size: 0.85rem;">+ Add New Editor</a>
        </div>
        <table>
            <thead>
                <tr>
                    <th>Photo</th>
                    <th>Name / Role</th>
                    <th>Institution / Country</th>
                    <th>Journal</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($editors as $e): ?>
                <tr>
                    <td>
                        <img src="<?php echo $e['photo'] ? UPLOAD_URL . $e['photo'] : SITE_URL . '/assets/img/default-user.png'; ?>" style="width: 40px; height: 40px; border-radius: 50%; object-fit: cover;">
                    </td>
                    <td>
                        <div style="font-weight: 600;"><?php echo sanitize($e['full_name']); ?></div>
                        <div style="font-size: 0.75rem; color: #64748b;"><?php echo sanitize($e['role']); ?></div>
                    </td>
                    <td>
                        <div style="font-size: 0.85rem;"><?php echo sanitize($e['institution']); ?></div>
                        <div style="font-size: 0.75rem; color: #64748b;"><?php echo sanitize($e['country']); ?></div>
                    </td>
                    <td><strong><?php echo $e['short_name']; ?></strong></td>
                    <td>
                        <div style="display: flex; gap: 5px;">
                            <a href="editors.php?action=edit&id=<?php echo $e['id']; ?>" class="btn-admin" style="background: #e2e8f0; color: #1e293b; text-decoration: none; font-size: 0.7rem;">Edit</a>
                            <a href="editors.php?action=delete&id=<?php echo $e['id']; ?>&token=<?php echo generateCSRFToken(); ?>" class="btn-admin" style="background: #fee2e2; color: #991b1b; text-decoration: none; font-size: 0.7rem;" onclick="return confirm('Remove this editor?')">Del</a>
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
