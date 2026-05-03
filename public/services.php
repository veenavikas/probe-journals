<?php
require_once __DIR__ . '/../includes/header.php';
$testimonials = getTestimonialsByJournal();
$page_title = "Our Services";
?>

<!-- Hero -->
<section style="background: linear-gradient(135deg, rgba(37,99,235,0.08), rgba(29,78,216,0.04)); padding: 60px 0; border-bottom: 1px solid var(--border);">
    <div class="container">
        <h1 style="font-family: var(--font-serif); font-size: 2.5rem; margin-bottom: 15px; text-align: center;">Why Publish With Us?</h1>
        <p style="text-align: center; color: var(--muted); max-width: 650px; margin: 0 auto; line-height: 1.7;">
            We welcome researchers to submit their manuscripts to Probe Journals and join our growing, vibrant scholarly community.
        </p>
    </div>
</section>

<!-- Benefits Grid -->
<section style="padding: 80px 0;">
    <div class="container">
        <p style="max-width: 800px; margin: 0 auto 50px; text-align: center; color: var(--muted); line-height: 1.8;">
            By publishing with us, you benefit from a rigorous and transparent editorial process designed to maximise the reach and impact of your research.
        </p>

        <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 30px; margin-bottom: 60px;">
            <?php
            $benefits = [
                ['icon' => 'fa-balance-scale', 'title' => 'Ethical Publishing Practices',    'text' => 'All submissions follow COPE guidelines. We maintain full transparency in editorial decision-making and conflict-of-interest disclosure.'],
                ['icon' => 'fa-search',         'title' => 'Preliminary Analysis',           'text' => 'Every submission receives a preliminary quality and scope analysis within 48 hours so authors receive early feedback.'],
                ['icon' => 'fa-users',          'title' => 'Double-Blind Peer Review',       'text' => 'Manuscripts are reviewed by two or more independent experts who remain anonymous to the authors throughout the process.'],
                ['icon' => 'fa-user-tie',       'title' => 'Editor-in-Chief Decision',       'text' => 'The Editor-in-Chief makes all final publication decisions, ensuring consistent scientific quality across every journal.'],
                ['icon' => 'fa-bolt',           'title' => 'Swift Publishing Schedule',      'text' => 'Accepted articles are published online within 20–25 days of acceptance — well ahead of the industry average.'],
                ['icon' => 'fa-globe',          'title' => 'Worldwide Research Exposure',    'text' => 'Articles are indexed in Google Scholar, CrossRef, DOAJ and more, giving your research maximum global discoverability.'],
            ];
            foreach ($benefits as $b):
            ?>
            <div class="neumorphic" style="display: flex; flex-direction: column; align-items: flex-start; gap: 16px;">
                <div style="width: 52px; height: 52px; background: linear-gradient(135deg, #2563eb, #1d4ed8); border-radius: 12px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                    <i class="fas <?php echo $b['icon']; ?>" style="color: white; font-size: 1.3rem;"></i>
                </div>
                <div>
                    <h3 style="font-size: 1.05rem; font-weight: 700; margin-bottom: 8px; color: var(--heading);"><?php echo $b['title']; ?></h3>
                    <p style="font-size: 0.9rem; color: var(--muted); line-height: 1.7; margin: 0;"><?php echo $b['text']; ?></p>
                </div>
            </div>
            <?php endforeach; ?>
        </div>

        <!-- Publication Process Timeline -->
        <div class="neumorphic" style="padding: 40px; margin-bottom: 60px;">
            <h2 style="font-family: var(--font-serif); font-size: 1.8rem; text-align: center; margin-bottom: 40px;">Our Publication Process</h2>
            <div style="display: grid; grid-template-columns: repeat(5, 1fr); gap: 0; position: relative;">
                <?php
                $steps = [
                    ['num' => '01', 'icon' => 'fa-paper-plane', 'label' => 'Submit Manuscript'],
                    ['num' => '02', 'icon' => 'fa-search',       'label' => 'Preliminary Review'],
                    ['num' => '03', 'icon' => 'fa-users',        'label' => 'Peer Review'],
                    ['num' => '04', 'icon' => 'fa-check-circle', 'label' => 'Editorial Decision'],
                    ['num' => '05', 'icon' => 'fa-globe',        'label' => 'Online Publication'],
                ];
                foreach ($steps as $i => $step):
                ?>
                <div style="text-align: center; position: relative; <?php echo $i < 4 ? "padding-right: 20px;" : ""; ?>">
                    <?php if ($i < 4): ?>
                    <div style="position: absolute; top: 26px; left: 50%; right: -50%; height: 2px; background: linear-gradient(to right, #2563eb, #93c5fd); z-index: 0;"></div>
                    <?php endif; ?>
                    <div style="width: 52px; height: 52px; background: #2563eb; border-radius: 50%; margin: 0 auto 14px; display: flex; align-items: center; justify-content: center; position: relative; z-index: 1; box-shadow: 0 4px 12px rgba(37,99,235,0.3);">
                        <i class="fas <?php echo $step['icon']; ?>" style="color: white; font-size: 1.1rem;"></i>
                    </div>
                    <div style="font-size: 0.65rem; font-weight: 700; color: #2563eb; letter-spacing: 0.1em; margin-bottom: 4px;">STEP <?php echo $step['num']; ?></div>
                    <div style="font-size: 0.82rem; font-weight: 600; color: var(--heading);"><?php echo $step['label']; ?></div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Testimonials -->
        <?php
        $displayTestimonials = !empty($testimonials) ? $testimonials : [
            ['reviewer_name' => 'Prof. Sarah Mitchell',  'reviewer_institution' => 'University of Edinburgh',  'reviewer_title' => 'Associate Professor', 'review_text' => 'As someone who reads a lot of digital content, ProbeJournals stands out. The articles are well-written, thoroughly researched, and intellectually engaging.'],
            ['reviewer_name' => 'Dr. James Thornton',    'reviewer_institution' => 'Johns Hopkins University', 'reviewer_title' => 'Research Scientist',    'review_text' => 'A rare space where knowledge meets clarity. ProbeJournals is ideal for anyone who wants to explore current issues in-depth without the noise.'],
            ['reviewer_name' => 'Dr. Priya Nair',        'reviewer_institution' => 'IIT Mumbai',               'reviewer_title' => 'Senior Researcher',      'review_text' => 'I love how ProbeJournals strikes a balance between academic depth and easy readability. It\'s my go-to for weekend reads.'],
            ['reviewer_name' => 'A. Okonkwo',            'reviewer_institution' => 'University of Lagos',      'reviewer_title' => 'PhD Candidate',          'review_text' => 'I stumbled on ProbeJournals while researching for a college paper, and now I\'m hooked. It\'s like having a library of insights at your fingertips.'],
        ];
        ?>
        <h2 style="font-family: var(--font-serif); font-size: 1.8rem; text-align: center; margin-bottom: 10px;">What Authors Say</h2>
        <p style="text-align: center; color: var(--muted); margin-bottom: 35px;">Trusted by researchers and clinicians across the globe.</p>

        <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 24px;">
            <?php foreach (array_slice($displayTestimonials, 0, 4) as $t): ?>
            <div class="hp-testimonial-card">
                <div class="hp-testimonial-stars">
                    <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                </div>
                <p class="hp-testimonial-text">"<?php echo htmlspecialchars($t['review_text']); ?>"</p>
                <div class="hp-testimonial-author">
                    <div class="hp-testimonial-avatar"><?php echo strtoupper(substr($t['reviewer_name'], 0, 1)); ?></div>
                    <div>
                        <strong><?php echo htmlspecialchars($t['reviewer_name']); ?></strong>
                        <span><?php echo htmlspecialchars($t['reviewer_institution']); ?></span>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>

        <!-- CTA -->
        <div style="text-align: center; margin-top: 60px; padding: 50px; background: linear-gradient(135deg, #1d4ed8, #2563eb); border-radius: 16px; color: white;">
            <h2 style="font-family: var(--font-serif); font-size: 2rem; color: white; margin-bottom: 12px;">Ready to Publish Your Research?</h2>
            <p style="color: rgba(255,255,255,0.85); margin-bottom: 28px; font-size: 1.05rem;">Join thousands of researchers who have published with Probe Journals.</p>
            <a href="<?php echo SITE_URL; ?>/submissions.php" class="btn btn-primary" style="background: white; color: #1d4ed8; font-weight: 700; padding: 14px 36px; font-size: 1rem;">
                Submit Your Manuscript <i class="fas fa-arrow-right" style="margin-left: 8px;"></i>
            </a>
        </div>
    </div>
</section>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
