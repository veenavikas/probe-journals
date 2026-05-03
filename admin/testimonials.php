<?php
require_once __DIR__ . '/../includes/admin-layout.php';

$title = "Manage Testimonials";
$activeNav = "testimonials";
$db = getDB();

$action = $_GET['action'] ?? 'list';
$t_id = $_GET['id'] ?? null;
$message = '';

// Handle Deletion
if ($action === 'delete' && $t_id) {
    if (!verifyCSRFToken($_GET['token'] ?? '')) {
        $message = '<div class="badge badge-danger">Security token mismatch. Delete aborted.</div>';
    } else {
        $stmt = $db->prepare("DELETE FROM testimonials WHERE id = ?");
        $stmt->execute([$t_id]);
        header("Location: testimonials.php?msg=deleted");
        exit();
    }
}

// Handle Add/Edit
if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($action === 'add' || $action === 'edit')) {
    if (!verifyCSRFToken($_POST['csrf_token'] ?? '')) {
        $message = '<div class="badge badge-danger">Security token mismatch.</div>';
    } else {
        $data = [
            'journal_id'          => !empty($_POST['journal_id']) ? (int)$_POST['journal_id'] : null,
            'reviewer_name'       => sanitize($_POST['reviewer_name']),
            'reviewer_title'      => sanitize($_POST['reviewer_title']),
            'reviewer_institution' => sanitize($_POST['reviewer_institution']),
            'review_text'         => $_POST['review_text'],
            'rating'              => (int)$_POST['rating'],
            'sort_order'          => (int)$_POST['sort_order'],
            'is_active'           => isset($_POST['is_active']) ? 1 : 0
        ];

        if ($action === 'add') {
            $fields = implode(', ', array_keys($data));
            $placeholders = implode(', ', array_fill(0, count($data), '?'));
            $stmt = $db->prepare("INSERT INTO testimonials ($fields) VALUES ($placeholders)");
            $stmt->execute(array_values($data));
            header("Location: testimonials.php?msg=added");
            exit();
        } else {
            $id = (int)$_POST['id'];
            $sets = [];
            foreach ($data as $k => $v) $sets[] = "$k = ?";
            $stmt = $db->prepare("UPDATE testimonials SET " . implode(', ', $sets) . " WHERE id = ?");
            $stmt->execute(array_merge(array_values($data), [$id]));
            $message = '<div class="badge badge-success" style="padding: 10px; margin-bottom: 20px;">Testimonial updated!</div>';
        }
    }
}

ob_start();

if ($action === 'add' || ($action === 'edit' && $t_id)):
    $testimonial = ($action === 'edit') ? $db->prepare("SELECT * FROM testimonials WHERE id = ?") : null;
    if ($testimonial) { $testimonial->execute([$t_id]); $testimonial = $testimonial->fetch(); }
    $journals = getAllJournals();
?>
    <div style="margin-bottom: 20px;">
        <a href="testimonials.php" style="text-decoration: none; color: #64748b;">&larr; Back to List</a>
    </div>
    <?php echo $message; ?>
    <div class="card-table" style="padding: 30px;">
        <form action="testimonials.php?action=<?php echo $action; ?><?php echo $t_id ? '&id='.$t_id : ''; ?>" method="POST">
            <input type="hidden" name="csrf_token" value="<?php echo generateCSRFToken(); ?>">
            <?php if ($testimonial): ?>
                <input type="hidden" name="id" value="<?php echo $testimonial['id']; ?>">
            <?php endif; ?>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                <div class="form-group">
                    <label>Journal (Select NULL for Homepage)</label>
                    <select name="journal_id">
                        <option value="">-- Homepage / General --</option>
                        <?php foreach ($journals as $j): ?>
                        <option value="<?php echo $j['id']; ?>" <?php echo ($testimonial && $testimonial['journal_id'] == $j['id']) ? 'selected' : ''; ?>><?php echo sanitize($j['name']); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label>Reviewer Name</label>
                    <input type="text" name="reviewer_name" value="<?php echo sanitize($testimonial['reviewer_name'] ?? ''); ?>" required>
                </div>
                <div class="form-group">
                    <label>Role / Title</label>
                    <input type="text" name="reviewer_title" value="<?php echo sanitize($testimonial['reviewer_title'] ?? ''); ?>" placeholder="e.g. Professor, Researcher">
                </div>
                <div class="form-group">
                    <label>Institution</label>
                    <input type="text" name="reviewer_institution" value="<?php echo sanitize($testimonial['reviewer_institution'] ?? ''); ?>">
                </div>
                <div class="form-group">
                    <label>Rating (1-5 Stars)</label>
                    <select name="rating">
                        <?php for($i=1; $i<=5; $i++): ?>
                        <option value="<?php echo $i; ?>" <?php echo ($testimonial && $testimonial['rating'] == $i) ? 'selected' : ($i==5?'selected':''); ?>><?php echo $i; ?> Stars</option>
                        <?php endfor; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label>Sort Order</label>
                    <input type="number" name="sort_order" value="<?php echo $testimonial['sort_order'] ?? 0; ?>">
                </div>
            </div>

            <div class="form-group">
                <label>Review Text</label>
                <textarea name="review_text" rows="5" required><?php echo sanitize($testimonial['review_text'] ?? ''); ?></textarea>
            </div>

            <div class="form-group">
                <label style="display: flex; align-items: center; gap: 10px; cursor: pointer;">
                    <input type="checkbox" name="is_active" <?php echo (!$testimonial || $testimonial['is_active']) ? 'checked' : ''; ?>> Visible on Site
                </label>
            </div>

            <button type="submit" class="btn-admin btn-primary-admin"><?php echo $testimonial ? 'Update testimonial' : 'Add Testimonial'; ?></button>
        </form>
    </div>
<?php else:
    $testimonials = $db->query("SELECT t.*, j.short_name FROM testimonials t LEFT JOIN journals j ON t.journal_id = j.id ORDER BY t.created_at DESC")->fetchAll();
    if (isset($_GET['msg'])) echo '<div class="badge badge-success" style="padding: 10px; margin-bottom: 20px;">Operation successful!</div>';
?>
    <div class="card-table">
        <div class="table-header">
            <h2 style="font-size: 1.1rem; font-weight: 600;">Reader Testimonials</h2>
            <a href="testimonials.php?action=add" class="btn-admin btn-primary-admin" style="text-decoration: none; font-size: 0.85rem;">+ Add New Testimonial</a>
        </div>
        <table>
            <thead>
                <tr>
                    <th>Reviewer</th>
                    <th>Journal</th>
                    <th>Rating</th>
                    <th>Text Snippet</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($testimonials as $t): ?>
                <tr>
                    <td>
                        <div style="font-weight: 600;"><?php echo sanitize($t['reviewer_name']); ?></div>
                        <div style="font-size: 0.75rem; color: #64748b;"><?php echo sanitize($t['reviewer_title']); ?></div>
                    </td>
                    <td><strong><?php echo $t['short_name'] ?: 'Homepage'; ?></strong></td>
                    <td style="color: #f59e0b;">
                        <?php echo str_repeat('<i class="fas fa-star"></i>', $t['rating']); ?>
                    </td>
                    <td>
                        <div style="font-size: 0.8rem; color: #64748b; max-width: 300px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                            <?php echo sanitize($t['review_text']); ?>
                        </div>
                    </td>
                    <td>
                        <span class="badge <?php echo $t['is_active'] ? 'badge-success' : 'badge-danger'; ?>">
                            <?php echo $t['is_active'] ? 'Active' : 'Hidden'; ?>
                        </span>
                    </td>
                    <td>
                        <div style="display: flex; gap: 5px;">
                            <a href="testimonials.php?action=edit&id=<?php echo $t['id']; ?>" class="btn-admin" style="background: #e2e8f0; color: #1e293b; text-decoration: none; font-size: 0.7rem;">Edit</a>
                            <a href="testimonials.php?action=delete&id=<?php echo $t['id']; ?>&token=<?php echo generateCSRFToken(); ?>" class="btn-admin" style="background: #fee2e2; color: #991b1b; text-decoration: none; font-size: 0.7rem;" onclick="return confirm('Remove this testimonial?')">Del</a>
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
