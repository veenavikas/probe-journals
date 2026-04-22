<?php
require_once __DIR__ . '/../includes/header.php';

$journals = getAllJournals();
$page_title = "List of Journals";
?>

<section style="background: rgba(79, 70, 229, 0.05); padding: 60px 0;">
    <div class="container">
        <h1 style="font-family: var(--font-serif); font-size: 2.5rem; margin-bottom: 15px; text-align: center;">Our Journals</h1>
        <p style="text-align: center; color: var(--muted); max-width: 600px; margin: 0 auto;">
            Explore our collection of high-impact, open-access journals across multiple disciplines.
        </p>
    </div>
</section>

<section style="padding: 80px 0;">
    <div class="container">
        <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 30px;">
            <?php foreach ($journals as $j): ?>
            <div class="neumorphic" style="display: flex; flex-direction: column; height: 100%;">
                <div style="display: flex; gap: 20px; align-items: start; margin-bottom: 20px;">
                    <div style="width: 100px; height: 130px; flex-shrink: 0;">
                        <img src="<?php echo $j['cover_image'] ? UPLOAD_URL . $j['cover_image'] : SITE_URL . '/assets/img/default-journal.jpg'; ?>" 
                             style="width: 100%; height: 100%; object-fit: cover; border-radius: 8px;">
                    </div>
                    <div>
                        <span class="badge" style="background: rgba(79, 70, 229, 0.1); color: var(--indigo); font-size: 0.7rem; margin-bottom: 10px; display: inline-block;">
                            <?php echo $j['subject_category']; ?>
                        </span>
                        <h3 style="font-size: 1.1rem; line-height: 1.4; margin-bottom: 10px;">
                            <a href="journals/<?php echo $j['slug']; ?>"><?php echo sanitize($j['name']); ?></a>
                        </h3>
                        <div style="font-size: 0.8rem; color: var(--muted);">
                            Impact Factor: <strong><?php echo $j['impact_factor']; ?></strong>
                        </div>
                    </div>
                </div>
                
                <p style="font-size: 0.85rem; color: var(--muted); margin-bottom: 20px; flex-grow: 1; display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden;">
                    <?php echo strip_tags($j['description']); ?>
                </p>
                
                <div style="display: flex; justify-content: space-between; align-items: center; border-top: 1px solid var(--border); padding-top: 15px;">
                    <a href="journals/<?php echo $j['slug']; ?>" style="color: var(--indigo); font-weight: 600; font-size: 0.9rem;">View Journal &rarr;</a>
                    <a href="journals/<?php echo $j['slug']; ?>&tab=submission" class="btn btn-primary" style="padding: 5px 15px; font-size: 0.8rem;">Submit</a>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
