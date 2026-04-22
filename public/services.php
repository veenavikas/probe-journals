<?php
require_once __DIR__ . '/../includes/header.php';
$content = getPageContent('services_content');
$page_title = "Our Services";
?>
<section style="background: rgba(79, 70, 229, 0.05); padding: 60px 0;">
    <div class="container"><h1 style="font-family: var(--font-serif); font-size: 2.5rem; text-align: center;">Services</h1></div>
</section>
<section style="padding: 80px 0;">
    <div class="container" style="max-width: 900px;">
        <div style="line-height: 1.8; color: var(--text);">
            <?php echo $content ?: '<h2>Editorial Services</h2><p>Professional peer review and editorial guidance.</p><h2>Publishing Services</h2><p>Formatting, DOI assignment, and global distribution.</p>'; ?>
        </div>
    </div>
</section>
<?php require_once __DIR__ . '/../includes/footer.php'; ?>
