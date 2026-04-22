<?php
require_once __DIR__ . '/../includes/header.php';
$content = getPageContent('membership_content');
$page_title = "Membership";
?>
<section style="background: rgba(79, 70, 229, 0.05); padding: 60px 0;">
    <div class="container"><h1 style="font-family: var(--font-serif); font-size: 2.5rem; text-align: center;">Membership</h1></div>
</section>
<section style="padding: 80px 0;">
    <div class="container" style="max-width: 900px;">
        <div style="line-height: 1.8; color: var(--text);">
            <?php echo $content ?: '<h2>Institutional Membership</h2><p>Special plans for universities and research institutions.</p><h2>Individual Membership</h2><p>Benefits for frequent authors and reviewers.</p>'; ?>
        </div>
    </div>
</section>
<?php require_once __DIR__ . '/../includes/footer.php'; ?>
