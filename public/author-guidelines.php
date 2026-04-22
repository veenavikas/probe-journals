<?php
$page_title   = 'Author Guidelines';
$body_class   = 'page-author-guidelines';
require_once __DIR__ . '/../includes/header.php';
?>

<section class="pg-hero">
    <div class="pg-hero__overlay"></div>
    <div class="container pg-hero__content">
        <h1 class="pg-hero__title">Author Guidelines</h1>
        <p class="pg-hero__sub">Everything you need to know before submitting your manuscript</p>
    </div>
</section>

<section class="hp-section">
    <div class="container">
        <div class="ag-layout">

            <!-- ── Sidebar TOC ───────────────────────────────── -->
            <aside class="ag-toc">
                <div class="ag-toc__inner">
                    <h3 class="ag-toc__heading"><i class="fas fa-list-ul"></i> Contents</h3>
                    <ul>
                        <li><a href="#scope">1. Scope &amp; Coverage</a></li>
                        <li><a href="#originality">2. Originality &amp; Ethics</a></li>
                        <li><a href="#manuscript">3. Manuscript Preparation</a></li>
                        <li><a href="#submission">4. Submission Process</a></li>
                        <li><a href="#review">5. Peer Review</a></li>
                        <li><a href="#revisions">6. Revisions &amp; Acceptance</a></li>
                        <li><a href="#apc">7. Article Processing Charges</a></li>
                        <li><a href="#copyright">8. Copyright &amp; Licensing</a></li>
                        <li><a href="#contact">9. Contact Editorial Office</a></li>
                    </ul>
                </div>
            </aside>

            <!-- ── Main Content ──────────────────────────────── -->
            <div class="ag-body">

                <div class="ag-intro">
                    <p>Probe Journals is committed to publishing high-quality, peer-reviewed research across multiple disciplines. Please read these guidelines carefully before preparing your submission. Manuscripts that do not conform to these guidelines may be returned without review.</p>
                </div>

                <!-- 1. Scope -->
                <div class="ag-section" id="scope">
                    <h2 class="ag-section__title"><span class="ag-section__num">01</span> Scope &amp; Coverage</h2>
                    <p>We welcome original research articles, review articles, case studies, and short communications in the following broad domains:</p>
                    <ul class="ag-checklist">
                        <li><i class="fas fa-circle-check"></i> Life Sciences, Medicine &amp; Public Health</li>
                        <li><i class="fas fa-circle-check"></i> Engineering, Technology &amp; Applied Sciences</li>
                        <li><i class="fas fa-circle-check"></i> Social Sciences, Humanities &amp; Management</li>
                        <li><i class="fas fa-circle-check"></i> Natural Sciences &amp; Environmental Studies</li>
                        <li><i class="fas fa-circle-check"></i> Law, Economics &amp; Policy</li>
                    </ul>
                </div>

                <!-- 2. Originality -->
                <div class="ag-section" id="originality">
                    <h2 class="ag-section__title"><span class="ag-section__num">02</span> Originality &amp; Ethics</h2>
                    <p>Submissions must be original and must not have been previously published or be under consideration elsewhere. By submitting, authors confirm:</p>
                    <ul class="ag-checklist">
                        <li><i class="fas fa-circle-check"></i> All co-authors have approved the final version.</li>
                        <li><i class="fas fa-circle-check"></i> Appropriate ethical approval has been obtained for human/animal studies.</li>
                        <li><i class="fas fa-circle-check"></i> All data are accurate and have not been fabricated or manipulated.</li>
                        <li><i class="fas fa-circle-check"></i> Conflicts of interest are disclosed.</li>
                    </ul>
                    <div class="ag-alert ag-alert--warning">
                        <i class="fas fa-triangle-exclamation"></i>
                        <p>Plagiarism, including self-plagiarism, is strictly prohibited. All submissions are screened using industry-standard plagiarism detection software. Acceptable similarity index: <strong>&lt; 15%</strong>.</p>
                    </div>
                </div>

                <!-- 3. Manuscript Preparation -->
                <div class="ag-section" id="manuscript">
                    <h2 class="ag-section__title"><span class="ag-section__num">03</span> Manuscript Preparation</h2>

                    <div class="ag-grid-2">
                        <div class="ag-spec-card">
                            <h4><i class="fas fa-file-word"></i> File Format</h4>
                            <p>Microsoft Word (.docx) or LaTeX (.tex + PDF). Do not submit PDF-only manuscripts.</p>
                        </div>
                        <div class="ag-spec-card">
                            <h4><i class="fas fa-text-height"></i> Font &amp; Spacing</h4>
                            <p>Times New Roman 12pt or Arial 11pt, double-spaced, 2.5 cm margins on all sides.</p>
                        </div>
                        <div class="ag-spec-card">
                            <h4><i class="fas fa-ruler-horizontal"></i> Length</h4>
                            <p>Research articles: 4,000–8,000 words. Reviews: up to 12,000 words. Short communications: max 2,500 words.</p>
                        </div>
                        <div class="ag-spec-card">
                            <h4><i class="fas fa-image"></i> Figures &amp; Tables</h4>
                            <p>High-resolution images (≥ 300 dpi). Tables must be editable (not images). Captions are mandatory.</p>
                        </div>
                    </div>

                    <h3 class="ag-sub-heading">Recommended Structure</h3>
                    <ol class="ag-ordered">
                        <li><strong>Title Page</strong> — Title, author names, affiliations, ORCID IDs, and corresponding author email.</li>
                        <li><strong>Abstract</strong> — Structured (Background, Methods, Results, Conclusion), max 300 words.</li>
                        <li><strong>Keywords</strong> — 4–8 keywords, not repetitions of the title.</li>
                        <li><strong>Introduction</strong></li>
                        <li><strong>Materials &amp; Methods</strong></li>
                        <li><strong>Results</strong></li>
                        <li><strong>Discussion</strong></li>
                        <li><strong>Conclusion</strong></li>
                        <li><strong>Declarations</strong> — Funding, conflicts of interest, ethics approval, data availability.</li>
                        <li><strong>References</strong> — APA 7th edition or Vancouver style as required by the journal.</li>
                    </ol>
                </div>

                <!-- 4. Submission -->
                <div class="ag-section" id="submission">
                    <h2 class="ag-section__title"><span class="ag-section__num">04</span> Submission Process</h2>
                    <p>All manuscripts must be submitted through our online submission portal. Email submissions are not accepted.</p>
                    <ol class="ag-ordered">
                        <li>Register or log in to the <a href="<?php echo SITE_URL; ?>/submissions.php" class="ag-link">Submission Portal</a>.</li>
                        <li>Select the appropriate journal and article type.</li>
                        <li>Upload your manuscript, cover letter, and any supplementary files.</li>
                        <li>Provide details of all authors and suggest at least 3 potential reviewers (optional).</li>
                        <li>Confirm submission and note your manuscript reference number.</li>
                    </ol>
                    <a href="<?php echo SITE_URL; ?>/submissions.php" class="btn btn-primary" style="margin-top:16px;">
                        <i class="fas fa-upload"></i>&nbsp; Submit Your Manuscript
                    </a>
                </div>

                <!-- 5. Peer Review -->
                <div class="ag-section" id="review">
                    <h2 class="ag-section__title"><span class="ag-section__num">05</span> Peer Review</h2>
                    <p>All submissions undergo a rigorous <strong>double-blind peer review</strong> process. Typical timelines:</p>
                    <div class="ag-timeline">
                        <div class="ag-timeline-item">
                            <div class="ag-timeline-dot"></div>
                            <div><strong>Initial Editorial Check</strong><br><span>2–5 business days</span></div>
                        </div>
                        <div class="ag-timeline-item">
                            <div class="ag-timeline-dot"></div>
                            <div><strong>Peer Review</strong><br><span>3–6 weeks</span></div>
                        </div>
                        <div class="ag-timeline-item">
                            <div class="ag-timeline-dot"></div>
                            <div><strong>Author Revision</strong><br><span>2–4 weeks (author's time)</span></div>
                        </div>
                        <div class="ag-timeline-item">
                            <div class="ag-timeline-dot"></div>
                            <div><strong>Final Decision</strong><br><span>1–2 weeks post-revision</span></div>
                        </div>
                        <div class="ag-timeline-item ag-timeline-item--last">
                            <div class="ag-timeline-dot ag-timeline-dot--green"></div>
                            <div><strong>Publication</strong><br><span>Within 5 days of acceptance</span></div>
                        </div>
                    </div>
                </div>

                <!-- 6. Revisions -->
                <div class="ag-section" id="revisions">
                    <h2 class="ag-section__title"><span class="ag-section__num">06</span> Revisions &amp; Acceptance</h2>
                    <p>Authors will receive reviewer comments and are expected to submit a point-by-point response letter along with the revised manuscript. Revised submissions must be returned within the specified deadline; failure to respond will result in the manuscript being closed.</p>
                </div>

                <!-- 7. APC -->
                <div class="ag-section" id="apc">
                    <h2 class="ag-section__title"><span class="ag-section__num">07</span> Article Processing Charges</h2>
                    <p>Probe Journals operates on an open-access model. A one-time Article Processing Charge (APC) is payable <em>only upon acceptance</em>. Submission is always free.</p>
                    <p>Waivers and discounts are available for authors from low- and middle-income countries. See the <a href="<?php echo SITE_URL; ?>/apc.php" class="ag-link">APC page</a> for full details.</p>
                </div>

                <!-- 8. Copyright -->
                <div class="ag-section" id="copyright">
                    <h2 class="ag-section__title"><span class="ag-section__num">08</span> Copyright &amp; Licensing</h2>
                    <p>All articles are published under the <strong>Creative Commons Attribution 4.0 International (CC BY 4.0)</strong> license. Authors retain copyright and grant Probe Journals a perpetual, non-exclusive license to publish, distribute, and archive the work.</p>
                    <div class="ag-alert ag-alert--info">
                        <i class="fas fa-circle-info"></i>
                        <p>Third-party materials included in the manuscript must be properly licensed or in the public domain. Authors are responsible for obtaining permissions.</p>
                    </div>
                </div>

                <!-- 9. Contact -->
                <div class="ag-section" id="contact">
                    <h2 class="ag-section__title"><span class="ag-section__num">09</span> Contact Editorial Office</h2>
                    <p>For queries not addressed here, please reach out to our editorial team:</p>
                    <ul class="ag-contact-list">
                        <li><i class="fas fa-envelope"></i> <a href="mailto:<?php echo getSiteSetting('contact_email'); ?>" class="ag-link"><?php echo getSiteSetting('contact_email'); ?></a></li>
                        <li><i class="fas fa-phone"></i> <?php echo getSiteSetting('phone'); ?></li>
                        <li><i class="fas fa-clock"></i> Monday – Friday, 9:00 AM – 6:00 PM (IST)</li>
                    </ul>
                    <a href="<?php echo SITE_URL; ?>/contact.php" class="btn btn-primary" style="margin-top:14px;">
                        <i class="fas fa-paper-plane"></i>&nbsp; Send a Message
                    </a>
                </div>

            </div><!-- /.ag-body -->
        </div><!-- /.ag-layout -->
    </div>
</section>

<style>
/* ── Page Hero ─────────────────────────────────────── */
.pg-hero {
  position: relative;
  background: linear-gradient(135deg, #1e3a5f 0%, #0d9488 100%);
  padding: 72px 0;
  text-align: center;
  overflow: hidden;
}
.pg-hero__overlay {
  position: absolute; inset: 0;
  background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.04'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
}
.pg-hero__content { position: relative; z-index: 1; color: white; }
.pg-hero__title { font-size: clamp(1.8rem, 4vw, 2.6rem); font-family: var(--font-serif); margin-bottom: 12px; }
.pg-hero__sub { font-size: 1.05rem; color: rgba(255,255,255,0.78); }

/* ── Layout ────────────────────────────────────────── */
.ag-layout {
  display: grid;
  grid-template-columns: 240px 1fr;
  gap: 48px;
  align-items: start;
}
@media(max-width:900px) { .ag-layout { grid-template-columns: 1fr; } .ag-toc { display: none; } }

/* ── TOC ───────────────────────────────────────────── */
.ag-toc__inner {
  position: sticky;
  top: 90px;
  background: var(--card-bg);
  border: 1px solid var(--border);
  border-radius: 12px;
  padding: 20px;
  box-shadow: var(--shadow);
}
.ag-toc__heading {
  font-family: var(--font-sans);
  font-size: 0.82rem;
  text-transform: uppercase;
  letter-spacing: 0.09em;
  color: var(--muted);
  margin-bottom: 14px;
  display: flex; align-items: center; gap: 8px;
}
.ag-toc ul { display: flex; flex-direction: column; gap: 0; }
.ag-toc a {
  display: block;
  padding: 7px 10px;
  font-size: 0.87rem;
  color: var(--muted);
  border-radius: 6px;
  transition: var(--transition);
  font-weight: 500;
}
.ag-toc a:hover { color: var(--indigo); background: var(--bg-alt); }

/* ── Sections ──────────────────────────────────────── */
.ag-intro {
  background: var(--bg-alt);
  border-left: 4px solid var(--indigo);
  border-radius: 0 8px 8px 0;
  padding: 18px 22px;
  margin-bottom: 40px;
  font-size: 0.95rem;
  color: var(--muted);
}
.ag-section { margin-bottom: 52px; scroll-margin-top: 90px; }
.ag-section__title {
  display: flex; align-items: center; gap: 14px;
  font-size: 1.3rem;
  color: var(--text);
  margin-bottom: 18px;
  padding-bottom: 12px;
  border-bottom: 2px solid var(--border);
}
.ag-section__num {
  background: var(--primary-gradient);
  color: white;
  border-radius: 6px;
  padding: 3px 10px;
  font-family: var(--font-sans);
  font-size: 0.78rem;
  font-weight: 800;
  letter-spacing: 0.05em;
  flex-shrink: 0;
}
.ag-sub-heading { font-size: 1rem; font-family: var(--font-sans); color: var(--text); margin: 24px 0 12px; }
.ag-body p { font-size: 0.95rem; color: var(--muted); margin-bottom: 14px; }

/* ── Checklist ─────────────────────────────────────── */
.ag-checklist { display: flex; flex-direction: column; gap: 10px; margin: 14px 0; }
.ag-checklist li { display: flex; align-items: flex-start; gap: 10px; font-size: 0.93rem; color: var(--muted); }
.ag-checklist li i { color: #16a34a; margin-top: 2px; flex-shrink: 0; }

/* ── Ordered list ──────────────────────────────────── */
.ag-ordered { padding-left: 20px; display: flex; flex-direction: column; gap: 10px; margin: 14px 0; }
.ag-ordered li { font-size: 0.93rem; color: var(--muted); padding-left: 4px; }

/* ── Spec Cards ─────────────────────────────────────── */
.ag-grid-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin: 18px 0; }
@media(max-width:600px) { .ag-grid-2 { grid-template-columns: 1fr; } }
.ag-spec-card {
  background: var(--card-bg);
  border: 1px solid var(--border);
  border-radius: 10px;
  padding: 18px;
  transition: var(--transition);
}
.ag-spec-card:hover { box-shadow: var(--shadow); transform: translateY(-2px); }
.ag-spec-card h4 { font-size: 0.9rem; font-family: var(--font-sans); font-weight: 700; color: var(--indigo); margin-bottom: 8px; display: flex; align-items: center; gap: 8px; }
.ag-spec-card p { font-size: 0.87rem; color: var(--muted); margin: 0; }

/* ── Timeline ───────────────────────────────────────── */
.ag-timeline { display: flex; flex-direction: column; gap: 0; border-left: 2px solid var(--border); margin: 20px 0 0 10px; padding-left: 20px; }
.ag-timeline-item { display: flex; align-items: flex-start; gap: 14px; padding: 0 0 24px; position: relative; }
.ag-timeline-item:last-child { padding-bottom: 0; }
.ag-timeline-dot {
  width: 14px; height: 14px;
  border-radius: 50%;
  background: var(--indigo);
  border: 3px solid var(--bg);
  box-shadow: 0 0 0 2px var(--indigo);
  flex-shrink: 0;
  margin-left: -27px;
  margin-top: 3px;
}
.ag-timeline-dot--green { background: #16a34a; box-shadow: 0 0 0 2px #16a34a; }
.ag-timeline-item strong { font-family: var(--font-sans); font-size: 0.93rem; color: var(--text); }
.ag-timeline-item span { font-size: 0.85rem; color: var(--muted); }

/* ── Alerts ─────────────────────────────────────────── */
.ag-alert {
  display: flex; align-items: flex-start; gap: 14px;
  border-radius: 8px; padding: 16px 18px; margin: 18px 0;
  font-size: 0.9rem;
}
.ag-alert i { font-size: 1rem; flex-shrink: 0; margin-top: 2px; }
.ag-alert p { margin: 0; color: var(--muted); }
.ag-alert--warning { background: #fefce8; border: 1px solid #fde68a; }
.ag-alert--warning i { color: #d97706; }
.ag-alert--info { background: #eff6ff; border: 1px solid #bfdbfe; }
.ag-alert--info i { color: var(--indigo); }
[data-theme="dark"] .ag-alert--warning { background: #1c1600; border-color: #78350f; }
[data-theme="dark"] .ag-alert--info { background: #0f1e3c; border-color: #1e3a5f; }

/* ── Misc ───────────────────────────────────────────── */
.ag-link { color: var(--indigo); font-weight: 500; }
.ag-link:hover { text-decoration: underline; }
.ag-contact-list { display: flex; flex-direction: column; gap: 10px; margin-top: 14px; }
.ag-contact-list li { display: flex; align-items: center; gap: 12px; font-size: 0.93rem; color: var(--muted); }
.ag-contact-list i { color: var(--indigo); width: 16px; text-align: center; }
</style>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
