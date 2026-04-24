<?php
require_once __DIR__ . '/../includes/header.php';

$slug = $_GET['slug'] ?? '';
$journal = getJournalBySlug($slug);

if (!$journal) {
    echo "<div class='container' style='padding: 100px 0; text-align: center;'><h2>Journal not found.</h2><a href='" . SITE_URL . "' class='btn btn-primary'>Return Home</a></div>";
    require_once __DIR__ . '/../includes/footer.php';
    exit();
}

$page_title = $journal['name'];

// Dynamic data setup
$editors = getEditorsByJournal($journal['id']);
$latestArticles = getLatestArticles($journal['id']);
$groupedArticles = getArticlesGroupedByVolume($journal['id']);
$testimonials = getTestimonialsByJournal($journal['id']);
$partners = getAllIndexingPartners();
$journalsByCategory = getJournalsByCategory();

// Retrieve specific metrics dynamically, map fallbacks if null
$citeScore = htmlspecialchars($journal['cite_score'] ?? '2.45');
$impactFactor = htmlspecialchars($journal['impact_factor'] ?? '4.3');
$hIndex = htmlspecialchars($journal['h_index'] ?? '8');
$processingTime = htmlspecialchars($journal['processing_time'] ?? '10-20 days');
$acceptanceTime = htmlspecialchars($journal['acceptance_time'] ?? '7-25 days');
// Mock rates for the chart
$acceptanceRate = 28.41;
$rejectionRate = 40.89;
$submittedRate = 30.09;
$totalArticles = 102; 
?>

<style>
/* Precise Custom Styles to match the provided mockup */
.jb-hero {
    /* Using an abstract science/biology background */
    background: linear-gradient(rgba(17, 24, 39, 0.4), rgba(17, 24, 39, 0.6)), url('https://images.unsplash.com/photo-1532187863486-abf9dbad1b69?auto=format&fit=crop&w=1920&q=80') center/cover no-repeat;
    height: 380px;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    text-align: center;
    color: white;
}
.jb-hero h1 {
    font-family: 'Lora', serif;
    font-size: 3.2rem;
    font-weight: 700;
    margin-bottom: 12px;
    text-shadow: 2px 2px 8px rgba(0, 0, 0, 0.5);
}
.jb-hero .jb-breadcrumb {
    font-size: 1rem;
    color: #e2e8f0;
    letter-spacing: 0.05em;
}

.jb-submit-bar {
    background: #ffffff;
    padding: 10px 0;
    border-bottom: 1px solid #e2e8f0;
}
.jb-submit-inner {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 24px;
    display: flex;
    justify-content: flex-end;
}
.jb-submit-btn {
    background: #3b82f6;
    color: white;
    padding: 8px 24px;
    border-radius: 4px;
    font-size: 0.9rem;
    font-weight: 600;
    border: none;
    cursor: pointer;
    box-shadow: 0 4px 6px rgba(59, 130, 246, 0.3);
    transition: all 0.2s;
}
.jb-submit-btn:hover { background: #2563eb; }

.jb-tabs-bar {
    background: linear-gradient(to right, #3b82f6, #1d4ed8); /* Blue to Dark Blue */
    position: sticky;
    top: 60px; /* offset for global header */
    z-index: 100;
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
}
.jb-tabs-container {
    max-width: 1200px;
    margin: 0 auto;
    display: flex;
    overflow-x: auto;
    scrollbar-width: none; /* Firefox */
}
.jb-tabs-container::-webkit-scrollbar { display: none; } /* Chrome */
.jb-tab {
    padding: 14px 20px;
    color: white;
    background: transparent;
    border: none;
    font-family: 'Inter', sans-serif;
    font-size: 0.95rem;
    font-weight: 500;
    display: flex;
    align-items: center;
    gap: 8px;
    white-space: nowrap;
    cursor: pointer;
    transition: background 0.2s;
}
.jb-tab:hover, .jb-tab.active {
    background: rgba(255, 255, 255, 0.15);
}

.jb-page-wrap {
    background: #f8fafc;
    padding: 40px 24px;
}
.jb-main-card {
    max-width: 1200px;
    margin: 0 auto;
    background: #f0f4f8; /* Soft blue-gray neumorphic base */
    border-radius: 16px;
    padding: 40px;
    box-shadow: 
        10px 10px 20px rgba(0,0,0,0.05),
        -10px -10px 20px rgba(255,255,255,0.8),
        inset 1px 1px 2px rgba(255,255,255,0.8);
    border: 1px solid #e2e8f0;
}

.jb-grid {
    display: grid;
    grid-template-columns: 1fr 340px;
    gap: 40px;
}
@media (max-width: 900px) {
    .jb-grid { grid-template-columns: 1fr; }
}

/* Left Column Specifics */
.jb-metrics-stack {
    display: flex;
    flex-direction: column;
    gap: 12px;
    margin-bottom: 40px;
}
.jb-metric-pill {
    background: #1d4ed8;
    color: white;
    padding: 8px 16px;
    border-radius: 4px;
    font-size: 0.95rem;
    font-weight: 500;
    width: fit-content;
    box-shadow: 0 4px 6px rgba(29, 78, 216, 0.2);
}
.jb-metric-pill--large {
    font-size: 1.1rem;
    font-weight: 700;
}
.jb-metric-pill a { color: white; text-decoration: underline; }

.jb-section-title {
    font-family: 'Lora', serif;
    font-size: 1.6rem;
    font-weight: 700;
    color: #1e293b;
    margin-bottom: 20px;
    margin-top: 40px;
}
.jb-metrics-stack + .jb-section-title { margin-top: 0; }

.jb-editor-card {
    background: white;
    border-radius: 12px;
    padding: 20px;
    display: flex;
    gap: 20px;
    align-items: flex-start;
    margin-bottom: 16px;
    box-shadow: 0 4px 10px rgba(0,0,0,0.03);
    border: 1px solid #e2e8f0;
}
.jb-editor-img {
    width: 90px;
    height: 90px;
    border-radius: 6px;
    object-fit: cover;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}
.jb-editor-info h4 {
    font-family: 'Inter', sans-serif;
    font-size: 1.1rem;
    font-weight: 700;
    color: #0f172a;
    margin-bottom: 4px;
}
.jb-editor-info .jb-role {
    font-size: 0.85rem;
    font-weight: 600;
    color: #64748b;
    margin-bottom: 6px;
}
.jb-editor-info .jb-desc {
    font-size: 0.85rem;
    color: #475569;
    line-height: 1.5;
}

.jb-prose {
    font-size: 1rem;
    color: #334155;
    line-height: 1.8;
}
.jb-prose p { margin-bottom: 16px; }
.jb-prose ul { list-style: disc; padding-left: 20px; margin-bottom: 16px; }
.jb-prose li { margin-bottom: 8px; }

/* Right Column Widgets */
.jb-widget {
    background: white;
    border-radius: 12px;
    padding: 24px;
    margin-bottom: 24px;
    box-shadow: 0 4px 10px rgba(0,0,0,0.03);
    border: 1px solid #e2e8f0;
}
.jb-widget-title {
    font-size: 1.1rem;
    font-weight: 700;
    color: #0f172a;
    margin-bottom: 16px;
    border-bottom: 1px solid #e2e8f0;
    padding-bottom: 12px;
}

/* Pie Chart Container */
.jb-pie-container {
    width: 200px;
    height: 200px;
    margin: 0 auto;
    position: relative;
}
.jb-pie-legend {
    margin-top: 20px;
    font-size: 0.85rem;
    color: #475569;
}
.jb-pie-legend-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 8px;
}
.jb-pie-legend-item span:first-child {
    display: flex;
    align-items: center;
    gap: 8px;
}
.jb-pie-dot {
    width: 10px;
    height: 10px;
    border-radius: 50%;
}

/* Latest Articles Widget Details */
.jb-highlight-item {
    margin-bottom: 16px;
}
.jb-highlight-item:last-child { margin-bottom: 0; }
.jb-highlight-authors {
    font-size: 0.8rem;
    color: #64748b;
    margin-bottom: 4px;
    line-height: 1.4;
}
.jb-highlight-title {
    font-size: 0.95rem;
    font-weight: 600;
    color: #2563eb;
    line-height: 1.4;
    transition: color 0.2s;
}
.jb-highlight-title:hover { color: #1d4ed8; text-decoration: underline; }

/* Lower Sections inside main wrapper */
.jb-testimonials {
    margin-top: 50px;
    border-top: 1px solid #cbd5e1;
    padding-top: 50px;
}
.jb-testimonials-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 24px;
}
@media (max-width: 900px) {
    .jb-testimonials-grid { grid-template-columns: 1fr; }
}
.jb-testimonial-card {
    background: white;
    border-radius: 12px;
    padding: 30px;
    box-shadow: 0 4px 10px rgba(0,0,0,0.03);
    border: 1px solid #e2e8f0;
}
.jb-stars {
    color: #eab308;
    margin-bottom: 16px;
    font-size: 1.1rem;
    letter-spacing: 2px;
}
.jb-quote {
    font-size: 0.9rem;
    color: #475569;
    line-height: 1.6;
    margin-bottom: 20px;
    font-style: italic;
}
.jb-author h5 {
    font-size: 0.95rem;
    font-weight: 700;
    color: #0f172a;
}
.jb-author p {
    font-size: 0.8rem;
    color: #64748b;
}

.jb-partners {
    margin-top: 50px;
    background: white;
    border-radius: 12px;
    padding: 30px;
    box-shadow: 0 4px 10px rgba(0,0,0,0.03);
    border: 1px solid #e2e8f0;
    text-align: center;
}
.jb-partners h3 {
    font-size: 1.2rem;
    font-weight: 700;
    color: #1e293b;
    margin-bottom: 24px;
}
.jb-partners-scroll {
    display: flex;
    justify-content: center;
    flex-wrap: wrap;
    gap: 30px;
}
.jb-partners-scroll img {
    height: 35px;
    object-fit: contain;
    filter: grayscale(100%);
    opacity: 0.6;
    transition: all 0.3s;
}
.jb-partners-scroll img:hover {
    filter: grayscale(0%);
    opacity: 1;
}

/* Specific styling for Archive items */
.archive-volume {
  background: white;
  border: 1px solid #e2e8f0;
  border-radius: 8px;
  margin-bottom: 16px;
  overflow: hidden;
  box-shadow: 0 2px 5px rgba(0,0,0,0.02);
}
.archive-header {
  padding: 16px 24px;
  display: flex;
  justify-content: space-between;
  align-items: center;
  cursor: pointer;
  background: #f8fafc;
  font-weight: 700;
  font-size: 1.1rem;
  transition: background 0.3s;
}
.archive-header:hover { background: #e2e8f0; }
.archive-header i { transition: transform 0.3s ease; color: #64748b; }
.archive-volume.active .archive-header i { transform: rotate(180deg); }
.archive-body { max-height: 0; overflow: hidden; transition: max-height 0.4s ease, padding 0.4s ease; }
.archive-volume.active .archive-body { max-height: 3000px; }
.archive-issue { padding: 24px; border-top: 1px solid #e2e8f0; }
.archive-issue-title { font-size: 1.1rem; font-weight: 700; color: #1e293b; margin-bottom: 16px; text-align: center;}
.archive-article { padding: 16px; border: 1px solid #e2e8f0; border-radius: 8px; margin-bottom: 12px; transition: background 0.2s;}
.archive-article:hover { background: #f8fafc; border-color: #cbd5e1; }
.archive-article-type { font-size: 0.75rem; text-transform: uppercase; font-weight: 700; color: #ea580c; margin-bottom: 8px; display: block; }
.archive-article-title { font-size: 1.05rem; font-weight: 600; color: #2563eb; margin-bottom: 8px; line-height: 1.5; }
.archive-article-authors { color: #64748b; font-size: 0.85rem; margin-bottom: 12px; }
.archive-article-actions { display: flex; gap: 15px; }

</style>

<!-- Top Hero Image -->
<div class="jb-hero">
    <h1><?php echo htmlspecialchars($journal['name'] ?? ''); ?></h1>
    <div class="jb-breadcrumb">Home > Journals > <?php echo htmlspecialchars($journal['name'] ?? ''); ?></div>
</div>

<!-- Submit Article Bar -->
<div class="jb-submit-bar">
    <div class="jb-submit-inner">
        <button class="jb-submit-btn" onclick="document.querySelector('[data-tab=\'submission\']').click(); window.scrollTo({top: 400, behavior: 'smooth'});">Submit Article</button>
    </div>
</div>

<!-- Blue Nav Tabs -->
<div class="jb-tabs-bar">
    <div class="jb-tabs-container" id="jb-tabs">
        <button class="jb-tab active" data-tab="home"><i class="fas fa-home"></i> Home</button>
        <button class="jb-tab" data-tab="editorial"><i class="fas fa-users"></i> Editorial Board</button>
        <button class="jb-tab" data-tab="guidelines"><i class="fas fa-book-open"></i> Author Guidelines</button>
        <button class="jb-tab" data-tab="ethics"><i class="fas fa-balance-scale"></i> Publication Ethics</button>
        <button class="jb-tab" data-tab="submission"><i class="fas fa-upload"></i> Submission</button>
        <button class="jb-tab" data-tab="archive"><i class="fas fa-box-archive"></i> Archive</button>
        <button class="jb-tab" data-tab="articles"><i class="fas fa-newspaper"></i> Articles in Press</button>
        <button class="jb-tab" data-tab="contact"><i class="fas fa-envelope"></i> Contact Us</button>
    </div>
</div>

<!-- Main Neumorphic Card Layout -->
<div class="jb-page-wrap">
    <div class="jb-main-card">
        
       <div class="jb-grid">
           <!-- Left Column (Content Panes) -->
           <div class="jb-main-col">
               
               <!-- HOME TAB -->
               <div id="jb-pane-home" class="jb-pane">
                   <div class="jb-metrics-stack">
                       <div class="jb-metric-pill jb-metric-pill--large"><?php echo htmlspecialchars($journal['name'] ?? ''); ?></div>
                       <div class="jb-metric-pill">Journal Cite Score: <?php echo $citeScore; ?></div>
                       <div class="jb-metric-pill">Journal Impact Factor: <?php echo $impactFactor; ?></div>
                       <div class="jb-metric-pill">Overall acceptance and publication time: <?php echo $acceptanceTime; ?></div>
                       <div class="jb-metric-pill">Average article processing time: <?php echo $processingTime; ?></div>
                       <div class="jb-metric-pill">Journal H-Index: <?php echo $hIndex; ?></div>
                       <div class="jb-metric-pill">Please submit article at <a href="mailto:<?php echo htmlspecialchars($journal['submission_email'] ?? ''); ?>"><?php echo htmlspecialchars($journal['submission_email'] ?? ''); ?></a></div>
                   </div>

                   <h2 class="jb-section-title">Our Editors</h2>
                   <?php if (!empty($editors)): ?>
                       <?php foreach (array_slice($editors, 0, 3) as $e): ?>
                       <div class="jb-editor-card">
                           <img src="<?php echo $e['photo'] ? UPLOAD_URL . $e['photo'] : 'https://placehold.co/128x128/f0f4f8/1e293b?text=ED'; ?>" alt="<?php echo htmlspecialchars($e['full_name'] ?? ''); ?>" class="jb-editor-img">
                           <div class="jb-editor-info">
                               <h4><?php echo htmlspecialchars($e['full_name'] ?? ''); ?></h4>
                               <div class="jb-role"><?php echo htmlspecialchars($e['role'] ?? ''); ?></div>
                               <div class="jb-desc"><?php echo nl2br(htmlspecialchars(($e['institution'] ?? '') . "\n" . ($e['country'] ?? ''))); ?></div>
                           </div>
                       </div>
                       <?php endforeach; ?>
                   <?php endif; ?>

                   <h2 class="jb-section-title">Aim and scope</h2>
                   <div class="jb-prose">
                       <?php echo nl2br(htmlspecialchars($journal['aim_and_scope'] ?? '')); ?>
                   </div>

                   <h2 class="jb-section-title" style="margin-top: 40px;">Privacy Statement</h2>
                   <div class="jb-prose">
                       <p>The names and email addresses entered in this journal site will be used exclusively for the stated purposes of this journal and will not be made available for any other purpose or to any other party.</p>
                   </div>
               </div>

               <!-- EDITORIAL BOARD TAB -->
               <div id="jb-pane-editorial" class="jb-pane" style="display: none;">
                   <h2 class="jb-section-title" style="margin-top: 0;">Editorial Board</h2>
                   <?php if (empty($editors)): ?>
                       <p>Editorial board to be announced.</p>
                   <?php else: ?>
                       <?php foreach ($editors as $e): ?>
                       <div class="jb-editor-card">
                           <img src="<?php echo $e['photo'] ? UPLOAD_URL . $e['photo'] : 'https://placehold.co/128x128/f0f4f8/1e293b?text=ED'; ?>" alt="<?php echo htmlspecialchars($e['full_name'] ?? ''); ?>" class="jb-editor-img">
                           <div class="jb-editor-info">
                               <h4><?php echo htmlspecialchars($e['full_name'] ?? ''); ?></h4>
                               <div class="jb-role"><?php echo htmlspecialchars($e['role'] ?? ''); ?></div>
                               <div class="jb-desc"><?php echo nl2br(htmlspecialchars(($e['institution'] ?? '') . "\n" . ($e['country'] ?? ''))); ?></div>
                           </div>
                       </div>
                       <?php endforeach; ?>
                   <?php endif; ?>
               </div>
               
               <!-- AUTHOR GUIDELINES TAB -->
               <div id="jb-pane-guidelines" class="jb-pane" style="display: none;">
                   <h2 class="jb-section-title" style="margin-top: 0;">Author Guidelines</h2>
                   <div class="jb-prose">
                       <p><strong>Covered Areas:</strong> <?php echo htmlspecialchars($journal['subject_category'] ?? ''); ?></p>
                       <p><strong>Issue release frequency:</strong> <?php echo htmlspecialchars($journal['issue_frequency'] ?? ''); ?></p>
                       <p>The Journal accepts papers of high quality in any area of its scope. After submitting articles, authors will get all regular updates of the articles. Updates will include preliminary quality analysis, reviewer comments, editor decision, publishing of the article etc.</p>
                       <br>
                       <h3>Article Processing Charges (APC)</h3>
                       <p>Our journals are not receiving any kind of financial support. The journal not charging any kind of subscription/submission fee, but we charge the fee.</p>
                       <p>For all kind of articles, the Article Processing Charges (APC) would be <strong><?php echo htmlspecialchars(($journal['apc_currency'] ?? '') . ' ' . ($journal['apc_amount'] ?? '')); ?></strong>.</p>
                       <br>
                       <h3>Author Withdrawal Policy</h3>
                       <p>We are not charging any kind of withdrawal fee if the authors want to withdraw the article within <?php echo htmlspecialchars($journal['withdrawal_days'] ?? 5); ?> days. If the authors want to withdraw the article after <?php echo htmlspecialchars($journal['withdrawal_days'] ?? 5); ?> days, we will charge <?php echo htmlspecialchars(($journal['apc_currency'] ?? '') . ' ' . ($journal['withdrawal_fee'] ?? 200)); ?> as a withdrawal fee.</p>
                       <br>
                       <h3>Copyrights</h3>
                       <p>The journal retains the copyright and any extensions or renewals thereof worldwide. This includes, but is not limited to, the rights to publish, disseminate, transmit, store, translate, distribute, sell, republish, and use the contribution and its contents in both print and electronic formats.</p>
                   </div>
               </div>

               <!-- PUBLICATION ETHICS TAB -->
               <div id="jb-pane-ethics" class="jb-pane" style="display: none;">
                   <h2 class="jb-section-title" style="margin-top: 0;">Publication Ethics & Malpractice</h2>
                   <div class="jb-prose">
                       <h3>Responsibilities of the editors</h3>
                       <p>This Journal is always a collaborative effort. Managing challenges of research integrity and publishing ethics in the journal is no exception. Legal concerns may arise as a result of these issues.</p>
                       <h3>Confidentiality</h3>
                       <p>The corresponding author, reviewers, potential reviewers, other editorial advisers, and the publisher, as appropriate, are the only people who should know about a manuscript that has been submitted to them.</p>
                       <h3>Responsibilities of reviewers</h3>
                       <p>The peer-reviewing process helps the editor and editorial board make editorial judgments, and it may also help the author improve their manuscript. Manuscripts submitted for review must be treated as private papers.</p>
                   </div>
               </div>
               
               <!-- SUBMISSION TAB -->
               <div id="jb-pane-submission" class="jb-pane" style="display: none;">
                   <h2 class="jb-section-title" style="margin-top: 0;">Submit Manuscript</h2>
                   <div class="jb-prose" style="margin-bottom: 24px;">
                       <p>Submit manuscript via the form below or send as an e-mail attachment to the Editorial Office at <a href="mailto:<?php echo htmlspecialchars($journal['submission_email'] ?? ''); ?>" style="color: #2563eb;"><?php echo htmlspecialchars($journal['submission_email'] ?? ''); ?></a></p>
                       <p>Accepted articles will be published approximately in <?php echo htmlspecialchars($journal['publishing_time'] ?? '15-25 days'); ?>.</p>
                   </div>
                   
                   <div style="background: white; border: 1px solid #e2e8f0; border-radius: 8px; padding: 24px; box-shadow: 0 4px 6px rgba(0,0,0,0.02);">
                       <form action="<?php echo SITE_URL; ?>/submit-article.php" method="POST" enctype="multipart/form-data">
                           <input type="hidden" name="csrf_token" value="<?php echo generateCSRFToken(); ?>">
                           <input type="hidden" name="journal_id" value="<?php echo $journal['id']; ?>">
                           <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 16px;">
                               <div>
                                   <label style="display: block; font-weight: 600; margin-bottom: 8px; font-size: 0.9rem;">Author Name</label>
                                   <input type="text" name="author_name" required style="width: 100%; padding: 10px; border: 1px solid #cbd5e1; border-radius: 4px; background: #f8fafc;">
                               </div>
                               <div>
                                   <label style="display: block; font-weight: 600; margin-bottom: 8px; font-size: 0.9rem;">Author Email</label>
                                   <input type="email" name="author_email" required style="width: 100%; padding: 10px; border: 1px solid #cbd5e1; border-radius: 4px; background: #f8fafc;">
                               </div>
                           </div>
                           <div style="margin-bottom: 16px;">
                               <label style="display: block; font-weight: 600; margin-bottom: 8px; font-size: 0.9rem;">Article Title</label>
                               <input type="text" name="article_title" required style="width: 100%; padding: 10px; border: 1px solid #cbd5e1; border-radius: 4px; background: #f8fafc;">
                           </div>
                           <div style="margin-bottom: 16px;">
                               <label style="display: block; font-weight: 600; margin-bottom: 8px; font-size: 0.9rem;">Manuscript PDF</label>
                               <input type="file" name="manuscript" accept=".pdf" required style="width: 100%; padding: 10px; border: 1px solid #cbd5e1; border-radius: 4px; background: #f8fafc; padding-bottom: 30px;">
                           </div>
                           <div style="margin-bottom: 20px;">
                               <label style="display: block; font-weight: 600; margin-bottom: 8px; font-size: 0.9rem;">Abstract</label>
                               <textarea name="abstract" rows="4" style="width: 100%; padding: 10px; border: 1px solid #cbd5e1; border-radius: 4px; background: #f8fafc;"></textarea>
                           </div>
                           <button type="submit" style="background: #3b82f6; color: white; padding: 12px 24px; border: none; border-radius: 4px; font-weight: 600; cursor: pointer; width: 100%; transition: background 0.2s;">Submit Online</button>
                       </form>
                   </div>
               </div>
               
               <!-- ARCHIVE TAB -->
               <div id="jb-pane-archive" class="jb-pane" style="display: none;">
                   <h2 class="jb-section-title" style="margin-top: 0;">Journal Archives</h2>
                   <?php if(empty($groupedArticles)): ?>
                       <p>No published articles yet in the archive.</p>
                   <?php else: ?>
                       <?php foreach($groupedArticles as $vol => $issues): ?>
                           <div class="archive-volume">
                               <div class="archive-header" onclick="this.parentElement.classList.toggle('active')">
                                   <span>Volume <?php echo $vol; ?></span>
                                   <i class="fas fa-chevron-down"></i>
                               </div>
                               <div class="archive-body">
                                   <?php foreach($issues as $iss => $arts): ?>
                                       <div class="archive-issue">
                                           <div class="archive-issue-title">Issue <?php echo $iss; ?></div>
                                           <?php foreach($arts as $art): ?>
                                               <div class="archive-article">
                                                   <span class="archive-article-type"><?php echo htmlspecialchars($art['article_type'] ?? ''); ?></span>
                                                   <a href="<?php echo UPLOAD_URL . $art['pdf_file']; ?>" target="_blank" style="text-decoration: none;">
                                                       <h4 class="archive-article-title"><?php echo htmlspecialchars($art['title'] ?? ''); ?></h4>
                                                   </a>
                                                   <div class="archive-article-authors">AUTHORS: <?php echo htmlspecialchars($art['authors'] ?? ''); ?></div>
                                                   <div class="archive-article-actions">
                                                       <a href="<?php echo UPLOAD_URL . $art['pdf_file']; ?>" target="_blank" style="color: #2563eb; font-weight: 600; font-size: 0.85rem;"><i class="fas fa-file-pdf" style="color: #ef4444;"></i> PDF</a>
                                                       <span style="font-size: 0.85rem; color: #64748b;"><i class="fas fa-eye"></i> <?php echo $art['views_count']; ?></span>
                                                       <span style="font-size: 0.85rem; color: #64748b;"><i class="fas fa-download"></i> <?php echo $art['downloads_count']; ?></span>
                                                   </div>
                                               </div>
                                           <?php endforeach; ?>
                                       </div>
                                   <?php endforeach; ?>
                               </div>
                           </div>
                       <?php endforeach; ?>
                   <?php endif; ?>
               </div>

               <!-- ARTICLES IN PRESS TAB -->
               <div id="jb-pane-articles" class="jb-pane" style="display: none;">
                   <h2 class="jb-section-title" style="margin-top: 0;">Articles In Press</h2>
                   <p>There are currently no articles in press for this journal.</p>
               </div>

               <!-- CONTACT TAB -->
               <div id="jb-pane-contact" class="jb-pane" style="display: none;">
                   <h2 class="jb-section-title" style="margin-top: 0;">Contact Us</h2>
                   <div class="jb-prose">
                       <p>For inquiries regarding manuscript submissions, peer review process, or general questions, please contact the editorial office.</p>
                       <p><strong>Email:</strong> <a href="mailto:publish@probejournals.com" style="color: #2563eb;">publish@probejournals.com</a></p>
                       <p><strong>Address:</strong> Probe Publisher, 45 Highfield Road, London, UK</p>
                   </div>
               </div>

           </div>

           <!-- Right Column (Sidebar Widgets) -->
           <div class="jb-sidebar">
               
               <div class="jb-widget" style="background: white; text-align: center; padding: 15px;">
                   <a href="#" style="font-weight: 600; color: #1d4ed8; text-decoration: underline; margin-bottom: 5px; display: block;">Open Access Journals</a>
                   <a href="#" style="font-weight: 600; color: #1d4ed8; text-decoration: underline; display: block;">List Of All Journals</a>
               </div>

               <div class="jb-widget">
                   <h3 class="jb-widget-title" style="text-align: center;">Journals By Subject</h3>
                   <?php foreach ($journalsByCategory as $category => $jList): ?>
                       <div style="margin-bottom: 12px;">
                           <div style="font-size: 0.95rem; font-weight: 700; color: #1e293b; margin-bottom: 4px;"><?php echo htmlspecialchars($category ?? ''); ?></div>
                           <ul style="list-style: none; padding: 0;">
                               <?php foreach ($jList as $jItem): ?>
                               <li style="margin-bottom: 4px; font-size: 0.85rem; padding-left: 10px; position: relative;">
                                   <span style="position: absolute; left: 0; color: #2563eb; font-size: 0.6rem; top: 5px;"><i class="fas fa-chevron-right"></i></span>
                                   <a href="<?php echo SITE_URL; ?>/journal.php?slug=<?php echo $jItem['slug']; ?>" style="color: #2563eb; text-decoration: none;"><?php echo htmlspecialchars($jItem['name'] ?? ''); ?></a>
                               </li>
                               <?php endforeach; ?>
                           </ul>
                       </div>
                   <?php endforeach; ?>
               </div>

               <div class="jb-widget">
                   <h3 class="jb-widget-title" style="text-align: center;">Article Statistics</h3>
                   <div class="jb-pie-container">
                       <svg viewBox="0 0 260 260">
                           <path d="M 130,130 L 130.000,30.000 A 100,100 0 0,1 184.165,214.060 Z" fill="#ef4444" />
                           <path d="M 130,130 L 184.165,214.060 A 100,100 0 0,1 36.345,165.053 Z" fill="#10b981" />
                           <path d="M 130,130 L 36.345,165.053 A 100,100 0 0,1 126.168,30.073 Z" fill="#3b82f6" />
                           <g stroke="white" stroke-width="2">
                               <path d="M 130,130 L 130.000,30.000 A 100,100 0 0,1 184.165,214.060 Z" fill="none" />
                               <path d="M 130,130 L 184.165,214.060 A 100,100 0 0,1 36.345,165.053 Z" fill="none" />
                               <path d="M 130,130 L 36.345,165.053 A 100,100 0 0,1 126.168,30.073 Z" fill="none" />
                           </g>
                           <text x="187.56" y="113.06" text-anchor="middle" fill="#fff" font-size="20"><?php echo $rejectionRate; ?>%</text>
                           <text x="111.12" y="186.95" text-anchor="middle" fill="#fff" font-size="20"><?php echo $acceptanceRate; ?>%</text>
                           <text x="80.05" y="96.76" text-anchor="middle" fill="#fff" font-size="20"><?php echo $submittedRate; ?>%</text>
                           <circle cx="130" cy="130" r="30" fill="white" />
                       </svg>
                   </div>
                   <div class="jb-pie-legend">
                       <div class="jb-pie-legend-item">
                           <span><span class="jb-pie-dot" style="background:#10b981;"></span> Accepted Article</span>
                           <span><?php echo $acceptanceRate; ?>%</span>
                       </div>
                       <div class="jb-pie-legend-item">
                           <span><span class="jb-pie-dot" style="background:#ef4444;"></span> Rejected Article</span>
                           <span><?php echo $rejectionRate; ?>%</span>
                       </div>
                       <div class="jb-pie-legend-item">
                           <span><span class="jb-pie-dot" style="background:#3b82f6;"></span> Submitted Article</span>
                           <span><?php echo $submittedRate; ?>%</span>
                       </div>
                   </div>
               </div>

               <div class="jb-widget">
                   <h3 class="jb-widget-title" style="text-align: center;">Current Issue Highlights</h3>
                   <?php if (empty($latestArticles)): ?>
                       <p style="font-size: 0.85rem; color: #64748b;">No recent publications.</p>
                   <?php else: ?>
                       <?php foreach (array_slice($latestArticles, 0, 3) as $art): ?>
                       <div class="jb-highlight-item">
                           <div class="jb-highlight-authors">AUTHORS: <?php echo htmlspecialchars($art['authors'] ?? ''); ?></div>
                           <a href="<?php echo UPLOAD_URL . $art['pdf_file']; ?>" target="_blank" class="jb-highlight-title"><?php echo htmlspecialchars($art['title'] ?? ''); ?></a>
                       </div>
                       <?php endforeach; ?>
                   <?php endif; ?>
               </div>
           </div>
       </div>

       <!-- Testimonials Section -->
       <?php if (!empty($testimonials)): ?>
       <div class="jb-testimonials">
           <h3 style="text-align: center; font-size: 1.8rem; font-family: 'Lora', serif; color: #0f172a; margin-bottom: 30px;">Testimonials</h3>
           <div class="jb-testimonials-grid">
               <?php foreach($testimonials as $t): ?>
               <div class="jb-testimonial-card">
                   <div class="jb-stars">★★★★★</div>
                   <div class="jb-quote">"<?php echo htmlspecialchars($t['review_text'] ?? ''); ?>"</div>
                   <div class="jb-author">
                       <h5><?php echo htmlspecialchars($t['reviewer_name'] ?? ''); ?></h5>
                       <p><?php echo htmlspecialchars($t['reviewer_title'] ?? ''); ?></p>
                   </div>
               </div>
               <?php endforeach; ?>
           </div>
       </div>
       <?php endif; ?>

       <!-- Indexed Partners -->
       <?php if(!empty($partners)): ?>
       <div class="jb-partners">
           <h3>Associated and indexed with</h3>
           <div class="jb-partners-scroll">
               <?php foreach($partners as $p): ?>
               <img src="<?php echo UPLOAD_URL . $p['logo']; ?>" alt="Partner">
               <?php endforeach; ?>
           </div>
       </div>
       <?php endif; ?>

    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", () => {
    const tabs = document.querySelectorAll('.jb-tab');
    const panes = document.querySelectorAll('.jb-pane');

    tabs.forEach(tab => {
        tab.addEventListener('click', () => {
            const target = tab.getAttribute('data-tab');
            
            // Remove active state
            tabs.forEach(t => t.classList.remove('active'));
            panes.forEach(p => p.style.display = 'none');
            
            // Add active state
            tab.classList.add('active');
            const targetPane = document.getElementById('jb-pane-' + target);
            if(targetPane) {
                targetPane.style.display = 'block';
            }
        });
    });
});
</script>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
