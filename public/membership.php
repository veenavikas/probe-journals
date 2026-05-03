<?php
require_once __DIR__ . '/../includes/header.php';
$page_title = "Membership";
?>

<!-- Hero -->
<section style="background: linear-gradient(135deg, rgba(37,99,235,0.08), rgba(29,78,216,0.04)); padding: 60px 0; border-bottom: 1px solid var(--border);">
    <div class="container">
        <h1 style="font-family: var(--font-serif); font-size: 2.5rem; margin-bottom: 15px; text-align: center;">Probe Publisher Membership</h1>
        <p style="text-align: center; color: var(--muted); max-width: 700px; margin: 0 auto; line-height: 1.7;">
            The Probe Publisher Membership Program provides an opportunity for academic institutions, corporations, and individuals to actively contribute to the advancement of Open Access in scholarly publishing, healthcare, and scientific information sharing. Membership is also available to a wide range of participants, including scientific societies, universities, research institutes, students etc.
        </p>
    </div>
</section>

<section style="padding: 80px 0;">
    <div class="container">

        <!-- Individual Membership -->
        <h2 style="font-family: var(--font-serif); font-size: 1.8rem; text-align: center; margin-bottom: 35px;">Individual Membership</h2>
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 30px; margin-bottom: 60px;">

            <!-- 6-Month Plan -->
            <div class="neumorphic" style="position: relative; overflow: hidden;">
                <div style="background: linear-gradient(135deg, #2563eb, #1d4ed8); padding: 24px 30px; color: white;">
                    <div style="font-size: 0.75rem; font-weight: 700; letter-spacing: 0.12em; text-transform: uppercase; opacity: 0.85; margin-bottom: 6px;">6 Month Plan</div>
                    <div style="font-size: 2.4rem; font-weight: 800; line-height: 1;">€2,500</div>
                </div>
                <div style="padding: 28px 30px;">
                    <ul style="list-style: none; padding: 0; margin: 0 0 28px; display: flex; flex-direction: column; gap: 12px;">
                        <li style="display: flex; gap: 12px; align-items: flex-start; font-size: 0.9rem; color: var(--text);">
                            <i class="fas fa-check-circle" style="color: #059669; margin-top: 2px; flex-shrink: 0;"></i>
                            Submit up to <strong style="margin: 0 4px;">3 articles</strong> during the 6-month period
                        </li>
                        <li style="display: flex; gap: 12px; align-items: flex-start; font-size: 0.9rem; color: var(--text);">
                            <i class="fas fa-check-circle" style="color: #059669; margin-top: 2px; flex-shrink: 0;"></i>
                            Official membership certificate issued
                        </li>
                        <li style="display: flex; gap: 12px; align-items: flex-start; font-size: 0.9rem; color: var(--text);">
                            <i class="fas fa-check-circle" style="color: #059669; margin-top: 2px; flex-shrink: 0;"></i>
                            Full open-access publication for all submissions
                        </li>
                    </ul>
                    <a href="<?php echo SITE_URL; ?>/contact.php" class="btn btn-primary" style="width: 100%; text-align: center; display: block; padding: 12px;">Enquire Now</a>
                </div>
            </div>

            <!-- Annual Plan -->
            <div class="neumorphic" style="position: relative; overflow: hidden; border: 2px solid #2563eb;">
                <div style="position: absolute; top: 16px; right: 16px; background: #2563eb; color: white; font-size: 0.7rem; font-weight: 700; padding: 4px 10px; border-radius: 20px; letter-spacing: 0.05em;">BEST VALUE</div>
                <div style="background: linear-gradient(135deg, #1d4ed8, #1e40af); padding: 24px 30px; color: white;">
                    <div style="font-size: 0.75rem; font-weight: 700; letter-spacing: 0.12em; text-transform: uppercase; opacity: 0.85; margin-bottom: 6px;">Annual Plan</div>
                    <div style="font-size: 2.4rem; font-weight: 800; line-height: 1;">€4,000</div>
                </div>
                <div style="padding: 28px 30px;">
                    <ul style="list-style: none; padding: 0; margin: 0 0 28px; display: flex; flex-direction: column; gap: 12px;">
                        <li style="display: flex; gap: 12px; align-items: flex-start; font-size: 0.9rem; color: var(--text);">
                            <i class="fas fa-check-circle" style="color: #059669; margin-top: 2px; flex-shrink: 0;"></i>
                            Submit up to <strong style="margin: 0 4px;">5 articles</strong> over 12 months
                        </li>
                        <li style="display: flex; gap: 12px; align-items: flex-start; font-size: 0.9rem; color: var(--text);">
                            <i class="fas fa-check-circle" style="color: #059669; margin-top: 2px; flex-shrink: 0;"></i>
                            Official membership certificate issued
                        </li>
                        <li style="display: flex; gap: 12px; align-items: flex-start; font-size: 0.9rem; color: var(--text);">
                            <i class="fas fa-check-circle" style="color: #059669; margin-top: 2px; flex-shrink: 0;"></i>
                            Full open-access publication for all submissions
                        </li>
                    </ul>
                    <a href="<?php echo SITE_URL; ?>/contact.php" class="btn btn-primary" style="width: 100%; text-align: center; display: block; padding: 12px;">Enquire Now</a>
                </div>
            </div>
        </div>

        <!-- University/Institute Membership -->
        <h2 style="font-family: var(--font-serif); font-size: 1.8rem; text-align: center; margin-bottom: 35px;">University / Institute Membership</h2>
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 30px; margin-bottom: 60px;">

            <div class="neumorphic" style="overflow: hidden;">
                <div style="background: linear-gradient(135deg, #0891b2, #0e7490); padding: 24px 30px; color: white;">
                    <div style="font-size: 0.75rem; font-weight: 700; letter-spacing: 0.12em; opacity: 0.85; margin-bottom: 6px;">6 MONTH PLAN</div>
                    <div style="font-size: 2.4rem; font-weight: 800;">€5,000</div>
                </div>
                <div style="padding: 28px 30px;">
                    <ul style="list-style: none; padding: 0; margin: 0 0 28px; display: flex; flex-direction: column; gap: 12px;">
                        <li style="display: flex; gap: 12px; align-items: flex-start; font-size: 0.9rem; color: var(--text);">
                            <i class="fas fa-check-circle" style="color: #059669; margin-top: 2px; flex-shrink: 0;"></i>
                            Submit up to <strong style="margin: 0 4px;">7 articles</strong> over 6 months
                        </li>
                        <li style="display: flex; gap: 12px; align-items: flex-start; font-size: 0.9rem; color: var(--text);">
                            <i class="fas fa-check-circle" style="color: #059669; margin-top: 2px; flex-shrink: 0;"></i>
                            Official membership certificate issued
                        </li>
                    </ul>
                    <a href="<?php echo SITE_URL; ?>/contact.php" class="btn btn-primary" style="width: 100%; text-align: center; display: block; padding: 12px; background: #0891b2;">Enquire Now</a>
                </div>
            </div>

            <div class="neumorphic" style="overflow: hidden; border: 2px solid #0891b2;">
                <div style="background: linear-gradient(135deg, #0e7490, #155e75); padding: 24px 30px; color: white;">
                    <div style="font-size: 0.75rem; font-weight: 700; letter-spacing: 0.12em; opacity: 0.85; margin-bottom: 6px;">ANNUAL PLAN</div>
                    <div style="font-size: 2.4rem; font-weight: 800;">€12,000</div>
                </div>
                <div style="padding: 28px 30px;">
                    <ul style="list-style: none; padding: 0; margin: 0 0 28px; display: flex; flex-direction: column; gap: 12px;">
                        <li style="display: flex; gap: 12px; align-items: flex-start; font-size: 0.9rem; color: var(--text);">
                            <i class="fas fa-check-circle" style="color: #059669; margin-top: 2px; flex-shrink: 0;"></i>
                            Submit up to <strong style="margin: 0 4px;">15 articles</strong> over 12 months
                        </li>
                        <li style="display: flex; gap: 12px; align-items: flex-start; font-size: 0.9rem; color: var(--text);">
                            <i class="fas fa-check-circle" style="color: #059669; margin-top: 2px; flex-shrink: 0;"></i>
                            Prestigious membership certificate issued
                        </li>
                    </ul>
                    <a href="<?php echo SITE_URL; ?>/contact.php" class="btn btn-primary" style="width: 100%; text-align: center; display: block; padding: 12px; background: #0e7490;">Enquire Now</a>
                </div>
            </div>
        </div>

        <!-- Organisation Membership -->
        <h2 style="font-family: var(--font-serif); font-size: 1.8rem; text-align: center; margin-bottom: 35px;">Organisation Membership</h2>
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 30px; margin-bottom: 60px;">

            <div class="neumorphic" style="overflow: hidden;">
                <div style="background: linear-gradient(135deg, #7c3aed, #6d28d9); padding: 24px 30px; color: white;">
                    <div style="font-size: 0.75rem; font-weight: 700; letter-spacing: 0.12em; opacity: 0.85; margin-bottom: 6px;">6 MONTH PLAN</div>
                    <div style="font-size: 2.4rem; font-weight: 800;">€10,000</div>
                </div>
                <div style="padding: 28px 30px;">
                    <ul style="list-style: none; padding: 0; margin: 0 0 28px; display: flex; flex-direction: column; gap: 12px;">
                        <li style="display: flex; gap: 12px; align-items: flex-start; font-size: 0.9rem; color: var(--text);">
                            <i class="fas fa-check-circle" style="color: #059669; margin-top: 2px; flex-shrink: 0;"></i>
                            Submit up to <strong style="margin: 0 4px;">12 articles</strong> over 6 months
                        </li>
                        <li style="display: flex; gap: 12px; align-items: flex-start; font-size: 0.9rem; color: var(--text);">
                            <i class="fas fa-check-circle" style="color: #059669; margin-top: 2px; flex-shrink: 0;"></i>
                            Membership certificate issued
                        </li>
                    </ul>
                    <a href="<?php echo SITE_URL; ?>/contact.php" class="btn btn-primary" style="width: 100%; text-align: center; display: block; padding: 12px; background: #7c3aed;">Enquire Now</a>
                </div>
            </div>

            <div class="neumorphic" style="overflow: hidden; border: 2px solid #7c3aed;">
                <div style="background: linear-gradient(135deg, #6d28d9, #5b21b6); padding: 24px 30px; color: white;">
                    <div style="font-size: 0.75rem; font-weight: 700; letter-spacing: 0.12em; opacity: 0.85; margin-bottom: 6px;">ANNUAL PLAN</div>
                    <div style="font-size: 2.4rem; font-weight: 800;">€15,000</div>
                </div>
                <div style="padding: 28px 30px;">
                    <ul style="list-style: none; padding: 0; margin: 0 0 28px; display: flex; flex-direction: column; gap: 12px;">
                        <li style="display: flex; gap: 12px; align-items: flex-start; font-size: 0.9rem; color: var(--text);">
                            <i class="fas fa-check-circle" style="color: #059669; margin-top: 2px; flex-shrink: 0;"></i>
                            Submit up to <strong style="margin: 0 4px;">18 articles</strong> over 12 months
                        </li>
                        <li style="display: flex; gap: 12px; align-items: flex-start; font-size: 0.9rem; color: var(--text);">
                            <i class="fas fa-check-circle" style="color: #059669; margin-top: 2px; flex-shrink: 0;"></i>
                            Membership certificate issued
                        </li>
                    </ul>
                    <a href="<?php echo SITE_URL; ?>/contact.php" class="btn btn-primary" style="width: 100%; text-align: center; display: block; padding: 12px; background: #6d28d9;">Enquire Now</a>
                </div>
            </div>
        </div>

        <!-- Footer note -->
        <div class="neumorphic" style="text-align: center; padding: 35px; background: rgba(37,99,235,0.04);">
            <i class="fas fa-info-circle" style="color: #2563eb; font-size: 1.5rem; margin-bottom: 12px; display: block;"></i>
            <p style="color: var(--muted); max-width: 650px; margin: 0 auto; line-height: 1.7; font-size: 0.95rem;">
                Probe Publisher is an independent, academic, open access, peer reviewed publisher formed to serve world-wide authors with low processing charges. All articles published are freely available online at no charge.
            </p>
            <div style="margin-top: 24px; display: flex; gap: 16px; justify-content: center; flex-wrap: wrap;">
                <a href="<?php echo SITE_URL; ?>/contact.php" class="btn btn-primary" style="padding: 12px 28px;">Contact Us for Details</a>
                <a href="<?php echo SITE_URL; ?>/submissions.php" class="btn" style="padding: 12px 28px; border: 2px solid #2563eb; color: #2563eb; background: transparent;">Submit a Manuscript</a>
            </div>
        </div>
    </div>
</section>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
