<?php
require_once __DIR__ . '/../includes/admin-layout.php';

$title = "Site Settings";
$activeNav = "settings";
$db = getDB();

// --- Automatic DB Migration for Brand Settings ---
try {
    $db->exec("INSERT IGNORE INTO site_settings (setting_key, setting_value, setting_label, setting_type) VALUES 
        ('site_logo', '/assets/img/probe_publisher_header_v1-removebg-preview.png', 'Site Logo', 'image'),
        ('site_favicon', '/assets/img/probe_publisher_header_v1-removebg-preview.png', 'Site Favicon (Icon Only)', 'image')
    ");
} catch (PDOException $e) {}

$message = '';

// Handle Update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!verifyCSRFToken($_POST['csrf_token'] ?? '')) {
        $message = '<div class="badge badge-danger">Security token mismatch.</div>';
    } else {
        $db->beginTransaction();
        try {
            // Update regular settings
            if (isset($_POST['settings']) && is_array($_POST['settings'])) {
                foreach ($_POST['settings'] as $key => $value) {
                    $stmt = $db->prepare("UPDATE site_settings SET setting_value = ? WHERE setting_key = ?");
                    $stmt->execute([$value, $key]);
                }
            }

            // Handle file uploads for 'image' settings
            if (isset($_FILES['settings_files']) && is_array($_FILES['settings_files']['name'])) {
                foreach ($_FILES['settings_files']['name'] as $key => $filename) {
                    if ($_FILES['settings_files']['error'][$key] === UPLOAD_ERR_OK) {
                        $file = [
                            'name' => $_FILES['settings_files']['name'][$key],
                            'type' => $_FILES['settings_files']['type'][$key],
                            'tmp_name' => $_FILES['settings_files']['tmp_name'][$key],
                            'error' => $_FILES['settings_files']['error'][$key],
                            'size' => $_FILES['settings_files']['size'][$key]
                        ];

                        // Delete old file if exists and it was an uploaded one
                        $old_val = getSiteSetting($key);
                        if (!empty($old_val) && strpos($old_val, 'brand/') === 0) {
                            deleteFile($old_val, 'brand');
                        }

                        $uploadResult = uploadFile($file, 'brand');
                        if ($uploadResult) {
                            $stmt = $db->prepare("UPDATE site_settings SET setting_value = ? WHERE setting_key = ?");
                            $stmt->execute([$uploadResult, $key]);
                        } else {
                            throw new Exception("Failed to upload image for setting: " . $key);
                        }
                    }
                }
            }

            $db->commit();
            $message = '<div class="badge badge-success" style="padding: 10px; margin-bottom: 20px;">Settings updated successfully!</div>';
        } catch (Exception $e) {
            $db->rollBack();
            $message = '<div class="badge badge-danger">Failed to update settings: ' . htmlspecialchars($e->getMessage()) . '</div>';
        }
    }
}

// Fetch all settings
$settings = $db->query("SELECT * FROM site_settings ORDER BY setting_label ASC")->fetchAll();

ob_start();
?>

<?php echo $message; ?>

<div class="card-table" style="padding: 30px;">
    <form action="settings.php" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="csrf_token" value="<?php echo generateCSRFToken(); ?>">
        
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 30px;">
            <?php foreach ($settings as $s): ?>
                <div class="form-group">
                    <label><?php echo sanitize($s['setting_label']); ?></label>
                    
                    <?php if ($s['setting_type'] === 'textarea'): ?>
                        <textarea name="settings[<?php echo $s['setting_key']; ?>]" rows="3"><?php echo sanitize($s['setting_value']); ?></textarea>
                    <?php elseif ($s['setting_type'] === 'number'): ?>
                        <input type="number" name="settings[<?php echo $s['setting_key']; ?>]" value="<?php echo sanitize($s['setting_value']); ?>">
                    <?php elseif ($s['setting_type'] === 'email'): ?>
                        <input type="email" name="settings[<?php echo $s['setting_key']; ?>]" value="<?php echo sanitize($s['setting_value']); ?>">
                    <?php elseif ($s['setting_type'] === 'url'): ?>
                        <input type="url" name="settings[<?php echo $s['setting_key']; ?>]" value="<?php echo sanitize($s['setting_value']); ?>">
                    <?php elseif ($s['setting_type'] === 'image'): ?>
                        <?php 
                        $imgVal = $s['setting_value'];
                        $imgUrl = (strpos($imgVal, '/') === 0 || strpos($imgVal, 'http') === 0) ? SITE_URL . $imgVal : SITE_URL . '/assets/uploads/' . $imgVal;
                        ?>
                        <div style="display: flex; align-items: center; gap: 15px; margin-top: 8px; margin-bottom: 8px;">
                            <img src="<?php echo $imgUrl; ?>" alt="Current Image" style="max-height: 60px; max-width: 180px; border: 1px solid #cbd5e1; padding: 4px; border-radius: 4px; background: #f8fafc; object-fit: contain;">
                        </div>
                        <input type="file" name="settings_files[<?php echo $s['setting_key']; ?>]" accept="image/*">
                    <?php else: ?>
                        <input type="text" name="settings[<?php echo $s['setting_key']; ?>]" value="<?php echo sanitize($s['setting_value']); ?>">
                    <?php endif; ?>
                    
                    <small style="color: #94a3b8; display: block; margin-top: 4px;">Key: <code><?php echo $s['setting_key']; ?></code></small>
                </div>
            <?php endforeach; ?>
        </div>

        <div style="margin-top: 30px; border-top: 1px solid #e2e8f0; padding-top: 20px;">
            <button type="submit" class="btn-admin btn-primary-admin">Save All Settings</button>
        </div>
    </form>
</div>

<div class="neumorphic" style="background: #fee2e2; box-shadow: none; border: 1px solid #fecaca; margin-top: 32px; padding: 24px;">
    <h3 style="color: #991b1b; margin-bottom: 10px; font-size: 1rem;">Security Action</h3>
    <p style="color: #b91c1c; font-size: 0.9rem; margin-bottom: 15px;">It is highly recommended to change the administrator password regularly.</p>
    <a href="#" class="btn-admin btn-danger-admin" style="text-decoration: none; font-size: 0.85rem;">Change Admin Password</a>
</div>

<?php
$content = ob_get_clean();
renderAdminLayout($title, $content, $activeNav);
