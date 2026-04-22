<?php
require_once __DIR__ . '/../includes/header.php';

$content = getPageContent('about_us');
$page_title = "About Us";
?>

<section style="background: rgba(79, 70, 229, 0.05); padding: 60px 0;">
    <div class="container">
        <h1 style="font-family: var(--font-serif); font-size: 2.5rem; margin-bottom: 15px; text-align: center;">About Probe Journals</h1>
        <p style="text-align: center; color: var(--muted); max-width: 600px; margin: 0 auto;">
            Our mission is to accelerate the pace of scientific discovery by providing a platform for high-quality, open-access research.
        </p>
    </div>
</section>

<section style="padding: 80px 0;">
    <div class="container" style="max-width: 900px;">
        <div style="line-height: 1.8; color: var(--text);">
            <?php if ($content): ?>
                <?php echo $content; ?>
            <?php else: ?>
                <h2>Our Vision</h2>
                <p>Probe Journals was founded on the principle that research should be accessible to everyone. We believe that by removing financial and geographical barriers to knowledge, we can foster a more collaborative and informed global scientific community.</p>
                
                <h2 style="margin-top: 40px;">Professional Excellence</h2>
                <p>Every article published in a Probe journal undergoes a rigorous double-blind peer review process. Our editorial boards consist of leading experts from around the world who ensure that only the most significant and well-conducted research is published.</p>
                
                <h2 style="margin-top: 40px;">Open Access Commitment</h2>
                <p>We are a gold open-access publisher. All articles are published under a Creative Commons Attribution License (CC BY), which allows for unrestricted use and distribution, provided the original work is properly cited.</p>
            <?php endif; ?>
        </div>
    </div>
</section>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
