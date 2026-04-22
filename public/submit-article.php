<?php
require_once __DIR__ . '/../includes/header.php';

// Only allow POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo "Method Not Allowed";
    require_once __DIR__ . '/../includes/footer.php';
    exit();
}

$error = '';
$success = false;

if (!verifyCSRFToken($_POST['csrf_token'] ?? '')) {
    $error = "Security token mismatch. Please try your submission again.";
} else {
    $journal_id = (int)($_POST['journal_id'] ?? 0);
    $author_name = sanitize($_POST['author_name'] ?? '');
    $author_email = sanitize($_POST['author_email'] ?? '');
    $article_title = sanitize($_POST['article_title'] ?? '');
    $abstract = sanitize($_POST['abstract'] ?? '');
    
    // Validate required fields
    if (empty($journal_id) || empty($author_name) || empty($author_email) || empty($article_title)) {
        $error = "Please fill in all required fields.";
    } else {
        // Handle file upload
        if (isset($_FILES['manuscript']) && $_FILES['manuscript']['error'] === UPLOAD_ERR_OK) {
            $uploaded_file = uploadFile($_FILES['manuscript'], 'pdf');
            if ($uploaded_file) {
                // Save to database
                $db = getDB();
                $stmt = $db->prepare("
                    INSERT INTO submissions (journal_id, author_name, author_email, article_title, abstract, manuscript_file)
                    VALUES (?, ?, ?, ?, ?, ?)
                ");
                
                if ($stmt->execute([$journal_id, $author_name, $author_email, $article_title, $abstract, $uploaded_file])) {
                    $success = true;
                } else {
                    $error = "A database error occurred. Please try again later.";
                }
            } else {
                $error = "Failed to upload manuscript. Ensure it is a valid PDF and under the size limit.";
            }
        } else {
            $error = "Manuscript file is required.";
        }
    }
}
?>
<section style="background: rgba(79, 70, 229, 0.05); padding: 80px 0; min-height: 500px; display: flex; align-items: center; justify-content: center;">
    <div class="container center-text neumorphic" style="max-width: 600px; padding: 50px;">
        <?php if ($success): ?>
            <i class="fas fa-check-circle fa-4x" style="color: #059669; margin-bottom: 20px;"></i>
            <h2 style="margin-bottom: 20px;">Submission Successful</h2>
            <p style="color: var(--muted); margin-bottom: 30px;">Thank you, <?php echo htmlspecialchars($author_name); ?>. Your manuscript has been submitted successfully for review.</p>
            <a href="<?php echo SITE_URL; ?>" class="btn btn-primary">Return to Home</a>
        <?php else: ?>
            <i class="fas fa-exclamation-circle fa-4x" style="color: #dc2626; margin-bottom: 20px;"></i>
            <h2 style="margin-bottom: 20px;">Submission Failed</h2>
            <p style="color: var(--muted); margin-bottom: 30px;"><?php echo htmlspecialchars($error); ?></p>
            <a href="javascript:history.back()" class="btn btn-primary">Go Back and Try Again</a>
        <?php endif; ?>
    </div>
</section>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
