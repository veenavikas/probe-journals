<?php
require_once __DIR__ . '/../includes/header.php';

$groupedJournals = getJournalsByCategory();
$testimonials    = getTestimonialsByJournal();
?>

<!-- ══════════════════════════════════════════════════
     HERO SECTION
══════════════════════════════════════════════════ -->
<section class="hp-hero">
    <div class="hp-hero__overlay"></div>
    <div class="hp-hero__content">
        <h1 class="hp-hero__title">Welcome to Probe Publisher</h1>
        <a href="<?php echo SITE_URL; ?>/submissions.php" class="hp-hero__btn">Submit Now</a>
    </div>
</section>

<!-- ══════════════════════════════════════════════════
     ABOUT US
══════════════════════════════════════════════════ -->
<section class="hp-section">
    <div class="container">
        <div class="hp-about-grid">

            <!-- Left: About text -->
            <div class="hp-about-text">
                <h2 class="hp-section-title">About Us</h2>
                <p>
                    <?php echo getPageContent('homepage_about') ?: 'Probe Journals is a global, independent, open-access publisher dedicated to disseminating high-quality peer-reviewed research across scientific, medical, engineering and social science disciplines. We are committed to the principles of open scholarship, ensuring knowledge is freely and permanently available to researchers, practitioners and the public worldwide.'; ?>
                </p>
                <p style="margin-top:16px;">
                    Our platform connects authors with a worldwide readership, providing rigorous peer review, fast processing times, and full compliance with international publishing standards. We support authors throughout the entire publication process from submission to post-publication indexing.
                </p>
            </div>

            <!-- Right: Image + Publishing Policies box -->
            <div class="hp-about-right">
                <img src="<?php echo SITE_URL; ?>/assets/img/about-us.jpg" alt="About Probe Journals" class="hp-about-img">

                <div class="hp-policy-box">
                    <h3 class="hp-policy-title">Publishing Policies and Ethics</h3>
                    <p>Probe Journals follows the COPE (Committee on Publication Ethics) guidelines for all editorial decisions. Our editorial team ensures the highest standards of integrity throughout the publishing process.</p>
                    <ul class="hp-policy-list">
                        <li><i class="fas fa-check-circle"></i> Strict double-blind peer review</li>
                        <li><i class="fas fa-check-circle"></i> Plagiarism detection on all submissions</li>
                        <li><i class="fas fa-check-circle"></i> Transparent correction and retraction policy</li>
                        <li><i class="fas fa-check-circle"></i> COPE & DOAJ compliant</li>
                    </ul>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- ══════════════════════════════════════════════════
     MISSION & VISIBILITY + OUR STORY
══════════════════════════════════════════════════ -->
<section class="hp-section hp-section--alt">
    <div class="container">
        <div class="hp-mission-grid">

            <div class="hp-mission-text">
                <h2 class="hp-section-title">Mission &amp; Visibility</h2>
                <p><?php echo getPageContent('homepage_mission') ?: 'Our mission is to accelerate global scientific progress through open-access publishing. By removing financial and geographic barriers to knowledge, we ensure that the research of scientists, clinicians, and engineers around the world receives the visibility it deserves.'; ?></p>
                <p style="margin-top:16px;">We are indexed in leading academic databases including Google Scholar, CrossRef, DOAJ, and more, ensuring maximum discoverability for every article we publish.</p>

                <div class="hp-mission-stats">
                    <div class="hp-stat">
                        <span class="hp-stat__num"><?php echo getSiteSetting('oa_journals_total', '9'); ?>+</span>
                        <span class="hp-stat__label">Active Journals</span>
                    </div>
                    <div class="hp-stat">
                        <span class="hp-stat__num"><?php echo getSiteSetting('oa_articles_total', '102'); ?>+</span>
                        <span class="hp-stat__label">OA Articles</span>
                    </div>
                    <div class="hp-stat">
                        <span class="hp-stat__num">150+</span>
                        <span class="hp-stat__label">Indexing Partners</span>
                    </div>
                </div>
            </div>

            <div class="hp-story-block">
                <h2 class="hp-section-title">Our Story</h2>
                <p><?php echo getPageContent('homepage_story') ?: 'Probe Journals was founded with a singular vision — to democratize scientific knowledge. Starting with a handful of journals in the medical sciences, we have grown into a trusted publisher recognized by academics globally.'; ?></p>
                <p style="margin-top:16px;">Every journal we publish is managed by a dedicated editorial board of subject-matter experts who uphold the highest scientific standards. Our story is one of community, expertise and an unwavering commitment to open science.</p>
                <img src="<?php echo SITE_URL; ?>/assets/img/our-story.jpg" alt="Our Story" class="hp-story-img">
            </div>

        </div>
    </div>
</section>

<!-- ══════════════════════════════════════════════════
     WHY PUBLISH WITH US
══════════════════════════════════════════════════ -->
<section class="hp-why">
    <div class="container">
        <h2 class="hp-why__title">Why Publish With Us?</h2>
        <p class="hp-why__sub">We offer a seamless, transparent and impactful publishing experience for every author.</p>

        <div class="hp-why-grid">
            <div class="hp-why-card">
                <i class="fas fa-microscope hp-why-card__icon"></i>
                <h3>Rigorous peer<br>process</h3>
            </div>
            <div class="hp-why-card">
                <i class="fas fa-users hp-why-card__icon"></i>
                <h3>Top-class<br>editorial boards</h3>
            </div>
            <div class="hp-why-card">
                <i class="fas fa-trophy hp-why-card__icon"></i>
                <h3>The best-in-peer<br>review process</h3>
            </div>
            <div class="hp-why-card">
                <i class="fas fa-globe hp-why-card__icon"></i>
                <h3>Publish in<br>popular media</h3>
            </div>
            <div class="hp-why-card">
                <i class="fas fa-graduation-cap hp-why-card__icon"></i>
                <h3>Serve post globally<br>scholars</h3>
            </div>
            <div class="hp-why-card">
                <i class="fas fa-chart-line hp-why-card__icon"></i>
                <h3>Widely recognized in<br>100+ journals</h3>
            </div>
        </div>
    </div>
</section>

<!-- ══════════════════════════════════════════════════
     JOURNALS BY SUBJECT
══════════════════════════════════════════════════ -->
<section class="hp-section">
    <div class="container">
        <h2 class="hp-section-title text-center" style="margin-bottom:40px;">Journals By Subject</h2>

        <div class="hp-journals-grid">
            <?php foreach ($groupedJournals as $category => $catJournals): ?>
            <div class="hp-journal-cat">
                <h3 class="hp-journal-cat__name"><?php echo htmlspecialchars($category); ?></h3>
                <ul class="hp-journal-cat__list">
                    <?php foreach ($catJournals as $j): ?>
                    <li>
                        <a href="<?php echo SITE_URL; ?>/journals/<?php echo $j['slug']; ?>" style="display: flex; align-items: center; gap: 10px; text-decoration: none;">
                            <img src="<?php echo $j['cover_image'] ? '/assets/uploads/' . $j['cover_image'] : '/assets/img/default-journal.jpg'; ?>" 
                                 style="width: 40px; height: 55px; object-fit: cover; border-radius: 4px; flex-shrink: 0;">
                            <span><?php echo htmlspecialchars($j['name']); ?></span>
                        </a>
                    </li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <?php endforeach; ?>

            <!-- Decorative journal stack image -->
            <div class="hp-journals-img-col">
                <div class="hp-journal-stack">
                    <div class="hp-journal-stack__book hp-journal-stack__book--1">Medical<br>Sciences</div>
                    <div class="hp-journal-stack__book hp-journal-stack__book--2">Clinical<br>Research</div>
                    <div class="hp-journal-stack__book hp-journal-stack__book--3">Engineering<br>Journal</div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ══════════════════════════════════════════════════
     TESTIMONIALS
══════════════════════════════════════════════════ -->
<section class="hp-section hp-section--alt">
    <div class="container">
        <h2 class="hp-section-title text-center" style="margin-bottom:40px;">Testimonials</h2>

        <div class="hp-testimonials-grid">
            <?php
            $displayTestimonials = !empty($testimonials) ? $testimonials : [
                ['reviewer_name' => 'Prof. Sarah Mitchell', 'reviewer_institution' => 'University of Edinburgh', 'reviewer_title' => 'Associate Professor', 'review_text' => 'The editorial process was smooth and the peer-review feedback was genuinely constructive. Our research reached a global audience within weeks of acceptance.'],
                ['reviewer_name' => 'Dr. James Thornton',   'reviewer_institution' => 'Johns Hopkins University', 'reviewer_title' => 'Research Scientist',     'review_text' => 'Probe Journals provided an excellent platform for our clinical study. The team was professional, responsive and the turnaround was impressively fast.'],
                ['reviewer_name' => 'Dr. Priya Nair',       'reviewer_institution' => 'IIT Mumbai',              'reviewer_title' => 'Senior Researcher',       'review_text' => 'I was impressed by the transparency and efficiency of the submission process. The indexing coverage means our work genuinely has impact.'],
            ];
            foreach ($displayTestimonials as $t):
            ?>
            <div class="hp-testimonial-card">
                <div class="hp-testimonial-stars">
                    <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                </div>
                <p class="hp-testimonial-text">"<?php echo htmlspecialchars($t['review_text']); ?>"</p>
                <div class="hp-testimonial-author">
                    <div class="hp-testimonial-avatar">
                        <?php echo strtoupper(substr($t['reviewer_name'], 0, 1)); ?>
                    </div>
                    <div>
                        <strong><?php echo htmlspecialchars($t['reviewer_name']); ?></strong>
                        <span><?php echo htmlspecialchars($t['reviewer_institution']); ?></span>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
