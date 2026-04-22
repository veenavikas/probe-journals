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
                    <?php echo $page_content ?: '<h3>Why APC?</h3><p>To provide open access, Probe Journals has a business model where expenses are recovered by an Article Processing Charge (APC). This allows all articles published in our journals to be freely accessible to everyone, anywhere in the world.</p>'; ?>
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
                        If an author requests withdrawal after 5 days of submission, a withdrawal fee of 219.00 EUR will be applicable. 
                        No withdrawal is permitted after the article has been accepted for publication.
                    </p>
                </div>
            </div>

            <aside>
                <div class="neumorphic" style="margin-bottom: 30px;">
                    <h3 style="font-size: 1.1rem; margin-bottom: 20px;">Fee Structure Includes:</h3>
                    <ul style="font-size: 0.9rem; color: var(--muted); display: flex; flex-direction: column; gap: 12px;">
                        <li><i class="fas fa-check" style="color: #059669;"></i> High-quality peer review</li>
                        <li><i class="fas fa-check" style="color: #059669;"></i> Professional layout & formatting</li>
                        <li><i class="fas fa-check" style="color: #059669;"></i> Global indexing & DOI assignment</li>
                        <li><i class="fas fa-check" style="color: #059669;"></i> Permanent archiving</li>
                        <li><i class="fas fa-check" style="color: #059669;"></i> Unlimited downloads & views</li>
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

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
