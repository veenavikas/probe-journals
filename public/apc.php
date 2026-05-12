<?php
require_once __DIR__ . '/../includes/header.php';

$journals = getAllJournals();
$page_content = getPageContent('publication_fees');
$page_title = "Article Processing Charges (APC)";
?>

<section style="background: rgba(79, 70, 229, 0.05); padding: 60px 0;">
    <div class="container">
        <h1 style="font-family: var(--font-serif); font-size: 2.5rem; margin-bottom: 15px; text-align: center;">Publication Fees</h1>
        <p style="text-align: center; color: var(--muted); max-width: 600px; margin: 0 auto;">
            Probe Journals is committed to keeping research free for readers while maintaining sustainable publishing standards.
        </p>
    </div>
</section>

<section style="padding: 80px 0;">
    <div class="container">
        <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 40px;">
            <div>
                <div style="line-height: 1.8; color: var(--text); margin-bottom: 40px;">
                    <?php echo $page_content ?: '
<h3>Publication fee of the articles</h3>
<p>Our journals are not receiving any kind of financial support. The journal does not charge any kind of subscription or submission fee, but we charge a fee for the following:</p>
<ul style="margin: 15px 0 20px 20px; display: flex; flex-direction: column; gap: 10px;">
    <li>For website maintenance</li>
    <li>For processing of the articles</li>
    <li>To publish the articles on our website</li>
    <li>To provide other services</li>
    <li>To pay the third-party services</li>
</ul>
<p>The publication fee of the article varies based on the journal. The fee will be changed based on extra services, number of pages, etc. Articles will be published within <strong>20 to 25 days</strong> after acceptance.</p>
'; ?>
                </div>

                <h3 style="margin-bottom: 25px;">Journal APC List</h3>
                <div class="card-table">
                    <table>
                        <thead>
                            <tr>
                                <th>Journal Name</th>
                                <th>Category</th>
                                <th>APC (EUR)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($journals as $j): ?>
                            <tr>
                                <td><strong><?php echo sanitize($j['name']); ?></strong></td>
                                <td><?php echo $j['subject_category']; ?></td>
                                <td style="font-weight: 600; color: var(--indigo);"><?php echo number_format($j['apc_amount'], 2); ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <div style="margin-top: 40px; padding: 25px; background: #fffbeb; border: 1px solid #fde68a; border-radius: 12px; color: #92400e;">
                    <h4 style="margin-bottom: 10px;"><i class="fas fa-exclamation-triangle"></i> Withdrawal Policy</h4>
                    <p style="font-size: 0.9rem;">
                        We do not charge any kind of withdrawal fee if the author wishes to withdraw the article within 3–5 days of submission.
                        If withdrawal is requested after 5 days, a withdrawal fee of <strong>EUR 219</strong> will be applicable.
                        No withdrawal is permitted after the article has been accepted for publication.
                    </p>
                </div>
            </div>

            <aside>
                <div class="neumorphic" style="margin-bottom: 30px;">
                    <h3 style="font-size: 1.1rem; margin-bottom: 20px;">Fee Structure Includes:</h3>
                    <ul style="font-size: 0.9rem; color: var(--muted); display: flex; flex-direction: column; gap: 12px;">
                        <li><i class="fas fa-check" style="color: #059669;"></i> High-quality peer review</li>
                        <li><i class="fas fa-check" style="color: #059669;"></i> Professional layout &amp; formatting</li>
                        <li><i class="fas fa-check" style="color: #059669;"></i> Global indexing &amp; DOI assignment</li>
                        <li><i class="fas fa-check" style="color: #059669;"></i> Permanent archiving</li>
                        <li><i class="fas fa-check" style="color: #059669;"></i> Unlimited downloads &amp; views</li>
                    </ul>
                </div>
                
                <div class="neumorphic" style="background: var(--primary-gradient); color: white;">
                    <h3 style="font-size: 1.1rem; margin-bottom: 15px;">Waiver Policy</h3>
                    <p style="font-size: 0.85rem; line-height: 1.6;">
                        We offer partial waivers for authors from low-income countries designated by the World Bank. 
                        Contact our billing department for more info.
                    </p>
                    <a href="mailto:billing@probejournals.com" style="display: block; margin-top: 15px; color: white; text-decoration: underline; font-weight: 600;">billing@probejournals.com</a>
                </div>
            </aside>
        </div>
    </div>
</section>

<!-- FAQ Section -->
<section style="padding: 80px 0; background: rgba(79, 70, 229, 0.03);">
    <div class="container">
        <div style="text-align: center; margin-bottom: 50px;">
            <h2 style="font-family: var(--font-serif); font-size: 2rem; margin-bottom: 12px;">Frequently Asked Questions</h2>
            <p style="color: var(--muted); max-width: 560px; margin: 0 auto;">Common questions about publication fees and our editorial process.</p>
        </div>

        <div style="max-width: 820px; margin: 0 auto;" id="apc-faq">

            <style>
                .faq-item { border: 1px solid rgba(79,70,229,0.15); border-radius: 12px; margin-bottom: 14px; overflow: hidden; background: #fff; transition: box-shadow 0.2s; }
                .faq-item:hover { box-shadow: 0 4px 20px rgba(79,70,229,0.08); }
                .faq-question { display: flex; justify-content: space-between; align-items: center; padding: 20px 24px; cursor: pointer; gap: 16px; }
                .faq-question h4 { font-size: 1rem; font-weight: 600; color: var(--text); margin: 0; line-height: 1.5; }
                .faq-icon { width: 30px; height: 30px; flex-shrink: 0; background: rgba(79,70,229,0.08); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: var(--indigo); transition: transform 0.3s, background 0.2s; }
                .faq-item.open .faq-icon { transform: rotate(45deg); background: var(--indigo); color: #fff; }
                .faq-answer { max-height: 0; overflow: hidden; transition: max-height 0.35s ease, padding 0.25s ease; }
                .faq-answer-inner { padding: 0 24px 20px; font-size: 0.93rem; color: var(--muted); line-height: 1.8; }
                .faq-answer-inner ul { margin: 10px 0 0 18px; display: flex; flex-direction: column; gap: 6px; }
                .faq-item.open .faq-answer { max-height: 400px; }
            </style>

            <!-- Q1 -->
            <div class="faq-item">
                <div class="faq-question" onclick="toggleFaq(this)">
                    <h4>What is an Article Processing Charge (APC)?</h4>
                    <span class="faq-icon"><i class="fas fa-plus" style="font-size:0.75rem;"></i></span>
                </div>
                <div class="faq-answer">
                    <div class="faq-answer-inner">
                        An APC is a fee paid by the author (or their institution/funder) to publish an article, especially in open-access journals. It ensures the article is freely available to all readers without any subscription barrier.
                    </div>
                </div>
            </div>

            <!-- Q2 -->
            <div class="faq-item">
                <div class="faq-question" onclick="toggleFaq(this)">
                    <h4>Can I request a waiver or discount on the publication fee?</h4>
                    <span class="faq-icon"><i class="fas fa-plus" style="font-size:0.75rem;"></i></span>
                </div>
                <div class="faq-answer">
                    <div class="faq-answer-inner">
                        Yes. Many publishers offer fee waivers or discounts for authors from low- and middle-income countries or for those with limited funding. Please contact our billing department at <a href="mailto:billing@probejournals.com" style="color: var(--indigo); font-weight: 600;">billing@probejournals.com</a> to enquire about eligibility.
                    </div>
                </div>
            </div>

            <!-- Q3 -->
            <div class="faq-item">
                <div class="faq-question" onclick="toggleFaq(this)">
                    <h4>Is paying a fee a guarantee that my article will be published?</h4>
                    <span class="faq-icon"><i class="fas fa-plus" style="font-size:0.75rem;"></i></span>
                </div>
                <div class="faq-answer">
                    <div class="faq-answer-inner">
                        No. Payment is made <strong>only after</strong> the article passes peer review and is accepted for publication. Our journals follow strict editorial and peer-review standards regardless of payment. Acceptance is based entirely on scientific merit.
                    </div>
                </div>
            </div>

            <!-- Q4 -->
            <div class="faq-item">
                <div class="faq-question" onclick="toggleFaq(this)">
                    <h4>How can I avoid predatory publishers charging unethical fees?</h4>
                    <span class="faq-icon"><i class="fas fa-plus" style="font-size:0.75rem;"></i></span>
                </div>
                <div class="faq-answer">
                    <div class="faq-answer-inner">
                        Check if the journal is listed in trusted databases like Scopus, Web of Science, or DOAJ. Look for clear editorial boards, transparent peer-review policies, and openly stated fee structures. If in doubt, consult with a librarian or academic advisor before submitting.
                    </div>
                </div>
            </div>

            <!-- Q5 -->
            <div class="faq-item">
                <div class="faq-question" onclick="toggleFaq(this)">
                    <h4>What does the publication fee usually include?</h4>
                    <span class="faq-icon"><i class="fas fa-plus" style="font-size:0.75rem;"></i></span>
                </div>
                <div class="faq-answer">
                    <div class="faq-answer-inner">
                        The publication fee typically covers:
                        <ul>
                            <li>Editorial handling and peer review process</li>
                            <li>Professional typesetting and formatting</li>
                            <li>DOI assignment</li>
                            <li>Online hosting and long-term archiving</li>
                            <li>Indexing submission and third-party service costs</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Q6 -->
            <div class="faq-item">
                <div class="faq-question" onclick="toggleFaq(this)">
                    <h4>Are publication fees refundable if my article is withdrawn or rejected?</h4>
                    <span class="faq-icon"><i class="fas fa-plus" style="font-size:0.75rem;"></i></span>
                </div>
                <div class="faq-answer">
                    <div class="faq-answer-inner">
                        <ul style="list-style: none; margin: 0; padding: 0; gap: 10px;">
                            <li style="padding: 6px 0; border-bottom: 1px solid #f3f4f6;">
                                <strong>If your article is rejected:</strong> No fee is charged, as fees are only due after acceptance.
                            </li>
                            <li style="padding: 6px 0 6px; border-bottom: 1px solid #f3f4f6;">
                                <strong>Withdrawal within 3–5 days:</strong> We do not charge any withdrawal fee.
                            </li>
                            <li style="padding: 6px 0;">
                                <strong>Withdrawal after 5 days:</strong> A withdrawal fee of <strong>EUR 219</strong> will be applicable.
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

<script>
function toggleFaq(btn) {
    const item = btn.closest('.faq-item');
    const isOpen = item.classList.contains('open');
    // Close all
    document.querySelectorAll('#apc-faq .faq-item').forEach(el => el.classList.remove('open'));
    // Open clicked (if it was not already open)
    if (!isOpen) item.classList.add('open');
}
</script>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
