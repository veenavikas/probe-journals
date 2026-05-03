<?php
require_once __DIR__ . '/../includes/header.php';

$message_sent = false;
$error = '';
$page_title = "Contact Us";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!verifyCSRFToken($_POST['csrf_token'] ?? '')) {
        $error = "Security token mismatch. Please try submitting again.";
    } else {
        $first_name   = sanitize($_POST['first_name']   ?? '');
        $last_name    = sanitize($_POST['last_name']    ?? '');
        $email        = sanitize($_POST['email']        ?? '');
        $subject      = sanitize($_POST['subject']      ?? '');
        $message_text = sanitize($_POST['message']      ?? '');

        $db   = getDB();
        $stmt = $db->prepare("INSERT INTO contact_messages (first_name, last_name, email, subject, message) VALUES (?, ?, ?, ?, ?)");
        if ($stmt->execute([$first_name, $last_name, $email, $subject, $message_text])) {
            $message_sent = true;
        } else {
            $error = "Failed to send message. Please try again later.";
        }
    }
}
?>

<style>
/* ── Contact Page Styles ─────────────────────────────── */
.contact-hero {
    background: linear-gradient(135deg, #0f172a 0%, #1e3a5f 50%, #1d4ed8 100%);
    padding: 80px 0 100px;
    position: relative;
    overflow: hidden;
}
.contact-hero::before {
    content: '';
    position: absolute;
    inset: 0;
    background:
        radial-gradient(ellipse 600px 400px at 20% 50%, rgba(37,99,235,0.15), transparent),
        radial-gradient(ellipse 400px 300px at 80% 20%, rgba(96,165,250,0.1), transparent);
    pointer-events: none;
}
.contact-hero__grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 60px;
    align-items: center;
    position: relative;
    z-index: 1;
}
.contact-hero__tag {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: rgba(255,255,255,0.1);
    border: 1px solid rgba(255,255,255,0.2);
    color: #93c5fd;
    font-size: 0.8rem;
    font-weight: 700;
    letter-spacing: 0.1em;
    text-transform: uppercase;
    padding: 6px 14px;
    border-radius: 50px;
    margin-bottom: 20px;
}
.contact-hero__title {
    font-family: var(--font-serif);
    font-size: clamp(2rem, 4vw, 3rem);
    color: white;
    line-height: 1.2;
    margin-bottom: 16px;
}
.contact-hero__title span {
    background: linear-gradient(90deg, #60a5fa, #a5b4fc);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}
.contact-hero__sub {
    color: rgba(255,255,255,0.65);
    font-size: 1rem;
    line-height: 1.7;
    max-width: 420px;
}
/* Hero info cards */
.contact-info-stack {
    display: flex;
    flex-direction: column;
    gap: 14px;
}
.contact-info-card {
    background: rgba(255,255,255,0.07);
    border: 1px solid rgba(255,255,255,0.12);
    border-radius: 14px;
    padding: 20px 24px;
    display: flex;
    align-items: center;
    gap: 18px;
    transition: all 0.3s ease;
    backdrop-filter: blur(10px);
}
.contact-info-card:hover {
    background: rgba(255,255,255,0.13);
    border-color: rgba(255,255,255,0.22);
    transform: translateX(4px);
}
.contact-info-card__icon {
    width: 46px;
    height: 46px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.1rem;
    flex-shrink: 0;
}
.contact-info-card__icon--blue   { background: rgba(59,130,246,0.25); color: #60a5fa; }
.contact-info-card__icon--teal   { background: rgba(20,184,166,0.2);  color: #2dd4bf; }
.contact-info-card__icon--green  { background: rgba(34,197,94,0.2);   color: #4ade80; }
.contact-info-card__icon--amber  { background: rgba(251,191,36,0.2);  color: #fbbf24; }
.contact-info-card__label {
    font-size: 0.72rem;
    font-weight: 700;
    letter-spacing: 0.1em;
    text-transform: uppercase;
    color: rgba(255,255,255,0.45);
    margin-bottom: 3px;
}
.contact-info-card__value {
    font-size: 0.92rem;
    font-weight: 600;
    color: rgba(255,255,255,0.9);
    line-height: 1.4;
}
.contact-info-card__value a {
    color: #93c5fd;
    transition: color 0.2s;
}
.contact-info-card__value a:hover { color: white; }

/* ── Form Panel (floats below hero) ──────────────────── */
.contact-body {
    padding: 0 0 90px;
    background: var(--bg-alt);
}
.contact-form-wrapper {
    max-width: 820px;
    margin: 0 auto;
    margin-top: -60px;
    position: relative;
    z-index: 10;
    padding: 0 24px;
}
.contact-form-card {
    background: var(--card-bg);
    border-radius: 20px;
    box-shadow: 0 20px 60px rgba(0,0,0,0.12);
    border: 1px solid var(--border);
    overflow: hidden;
}
.contact-form-card__header {
    padding: 32px 40px 28px;
    border-bottom: 1px solid var(--border);
    display: flex;
    align-items: center;
    gap: 16px;
}
.contact-form-card__header-icon {
    width: 48px;
    height: 48px;
    background: var(--primary-gradient);
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.2rem;
    flex-shrink: 0;
    box-shadow: 0 4px 12px rgba(37,99,235,0.35);
}
.contact-form-card__header h2 {
    font-size: 1.4rem;
    color: var(--text);
    margin-bottom: 2px;
}
.contact-form-card__header p {
    font-size: 0.88rem;
    color: var(--muted);
    font-family: var(--font-sans);
}
.contact-form-card__body {
    padding: 36px 40px;
}

/* ── Refined Input Styles ────────────────────────────── */
.cf-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
    margin-bottom: 20px;
}
.cf-group {
    display: flex;
    flex-direction: column;
    gap: 7px;
}
.cf-group label {
    font-size: 0.82rem;
    font-weight: 700;
    color: var(--text);
    letter-spacing: 0.03em;
    text-transform: uppercase;
}
.cf-group label .required {
    color: #ef4444;
    margin-left: 2px;
}
.cf-input,
.cf-textarea,
.cf-select {
    width: 100%;
    padding: 13px 16px;
    border: 1.5px solid var(--border);
    border-radius: 10px;
    font-family: var(--font-sans);
    font-size: 0.95rem;
    color: var(--text);
    background: var(--bg-alt);
    transition: border-color 0.2s ease, box-shadow 0.2s ease, background 0.2s ease;
    outline: none;
    appearance: none;
}
.cf-input:focus,
.cf-textarea:focus,
.cf-select:focus {
    border-color: var(--indigo);
    box-shadow: 0 0 0 4px rgba(37,99,235,0.1);
    background: var(--bg);
}
.cf-input::placeholder,
.cf-textarea::placeholder { color: #94a3b8; }
.cf-input:hover,
.cf-textarea:hover,
.cf-select:hover { border-color: #93c5fd; }

.cf-textarea { resize: vertical; min-height: 150px; line-height: 1.7; }

/* Input icon wrapper */
.cf-input-wrap {
    position: relative;
}
.cf-input-wrap .cf-icon {
    position: absolute;
    left: 14px;
    top: 50%;
    transform: translateY(-50%);
    color: #94a3b8;
    font-size: 0.9rem;
    pointer-events: none;
    transition: color 0.2s;
}
.cf-input-wrap .cf-input { padding-left: 40px; }
.cf-input-wrap:focus-within .cf-icon { color: var(--indigo); }

/* ── Submit button ───────────────────────────────────── */
.cf-submit {
    width: 100%;
    padding: 15px 24px;
    background: var(--primary-gradient);
    color: white;
    border: none;
    border-radius: 10px;
    font-family: var(--font-sans);
    font-size: 1rem;
    font-weight: 700;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    box-shadow: 0 4px 16px rgba(37,99,235,0.4);
    transition: transform 0.2s, box-shadow 0.2s;
    margin-top: 8px;
    letter-spacing: 0.02em;
}
.cf-submit:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 24px rgba(37,99,235,0.5);
}
.cf-submit:active { transform: translateY(0); }

/* ── Alert banners ───────────────────────────────────── */
.cf-alert {
    display: flex;
    align-items: flex-start;
    gap: 14px;
    padding: 16px 20px;
    border-radius: 10px;
    font-size: 0.9rem;
    margin-bottom: 24px;
}
.cf-alert--error {
    background: #fef2f2;
    border: 1px solid #fecaca;
    color: #991b1b;
}
.cf-alert--error i { color: #dc2626; margin-top: 2px; flex-shrink: 0; }
[data-theme="dark"] .cf-alert--error {
    background: rgba(220,38,38,0.1);
    border-color: rgba(220,38,38,0.3);
    color: #fca5a5;
}

/* ── Success state ───────────────────────────────────── */
.cf-success {
    text-align: center;
    padding: 50px 40px;
}
.cf-success__circle {
    width: 80px;
    height: 80px;
    border-radius: 50%;
    background: linear-gradient(135deg, #059669, #10b981);
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 24px;
    box-shadow: 0 8px 24px rgba(5,150,105,0.35);
    animation: popIn 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
}
@keyframes popIn {
    0%   { transform: scale(0); opacity: 0; }
    100% { transform: scale(1); opacity: 1; }
}
.cf-success__circle i { font-size: 2rem; color: white; }
.cf-success h2 { font-size: 1.6rem; color: var(--text); margin-bottom: 10px; }
.cf-success p  { color: var(--muted); font-size: 0.95rem; max-width: 360px; margin: 0 auto 28px; line-height: 1.7; }

/* ── Divider ─────────────────────────────────────────── */
.cf-divider {
    display: flex;
    align-items: center;
    gap: 12px;
    margin: 24px 0;
    color: var(--muted);
    font-size: 0.8rem;
    font-weight: 600;
    letter-spacing: 0.05em;
    text-transform: uppercase;
}
.cf-divider::before,
.cf-divider::after {
    content: '';
    flex: 1;
    height: 1px;
    background: var(--border);
}

/* ── Quick note bar ──────────────────────────────────── */
.cf-note {
    display: flex;
    align-items: center;
    gap: 10px;
    background: #f0f7ff;
    border: 1px solid #dbeafe;
    border-left: 4px solid var(--indigo);
    border-radius: 8px;
    padding: 12px 16px;
    font-size: 0.84rem;
    color: #1e40af;
    margin-top: 20px;
}
[data-theme="dark"] .cf-note {
    background: rgba(37,99,235,0.1);
    border-color: rgba(37,99,235,0.3);
    color: #93c5fd;
}

/* ── Responsive ──────────────────────────────────────── */
@media (max-width: 900px) {
    .contact-hero__grid { grid-template-columns: 1fr; gap: 36px; }
    .contact-info-stack { flex-direction: row; flex-wrap: wrap; }
    .contact-info-card  { flex: 1; min-width: 200px; }
}
@media (max-width: 640px) {
    .cf-row { grid-template-columns: 1fr; }
    .contact-form-card__header,
    .contact-form-card__body { padding: 24px 20px; }
    .contact-hero { padding: 60px 0 90px; }
    .contact-info-stack { flex-direction: column; }
}
</style>

<!-- ── Hero ────────────────────────────────────────────────── -->
<section class="contact-hero">
    <div class="container">
        <div class="contact-hero__grid">

            <!-- Left: headline -->
            <div>
                <div class="contact-hero__tag">
                    <i class="fas fa-paper-plane"></i> Get in Touch
                </div>
                <h1 class="contact-hero__title">
                    We'd love to<br><span>hear from you</span>
                </h1>
                <p class="contact-hero__sub">
                    Have questions about submission, peer review, publication fees, or editorial decisions?
                    Our team typically responds within 2 business days.
                </p>
            </div>

            <!-- Right: info cards -->
            <div class="contact-info-stack">

                <div class="contact-info-card">
                    <div class="contact-info-card__icon contact-info-card__icon--blue">
                        <i class="fas fa-envelope"></i>
                    </div>
                    <div>
                        <div class="contact-info-card__label">Email Us</div>
                        <div class="contact-info-card__value">
                            <a href="mailto:<?php echo getSiteSetting('contact_email'); ?>">
                                <?php echo getSiteSetting('contact_email'); ?>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="contact-info-card">
                    <div class="contact-info-card__icon contact-info-card__icon--teal">
                        <i class="fas fa-phone"></i>
                    </div>
                    <div>
                        <div class="contact-info-card__label">Call Us</div>
                        <div class="contact-info-card__value">
                            <a href="tel:<?php echo preg_replace('/[^+\d]/', '', getSiteSetting('phone')); ?>">
                                <?php echo getSiteSetting('phone'); ?>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="contact-info-card">
                    <div class="contact-info-card__icon contact-info-card__icon--green">
                        <i class="fas fa-map-marker-alt"></i>
                    </div>
                    <div>
                        <div class="contact-info-card__label">Main Office</div>
                        <div class="contact-info-card__value">
                            <?php echo getSiteSetting('address_main'); ?>
                        </div>
                    </div>
                </div>

                <div class="contact-info-card">
                    <div class="contact-info-card__icon contact-info-card__icon--amber">
                        <i class="fas fa-clock"></i>
                    </div>
                    <div>
                        <div class="contact-info-card__label">Working Hours</div>
                        <div class="contact-info-card__value">
                            Mon – Fri &nbsp;·&nbsp; 9:00 AM – 6:00 PM GMT
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>

<!-- ── Form ─────────────────────────────────────────────────── -->
<div class="contact-body">
    <div class="contact-form-wrapper">
        <div class="contact-form-card">

            <?php if ($message_sent): ?>
            <!-- Success -->
            <div class="cf-success">
                <div class="cf-success__circle">
                    <i class="fas fa-check"></i>
                </div>
                <h2>Message Sent!</h2>
                <p>Thank you for reaching out. A member of our editorial team will get back to you within 2 business days.</p>
                <a href="contact.php" class="btn btn-primary">
                    <i class="fas fa-redo" style="margin-right:8px;"></i> Send Another Message
                </a>
            </div>

            <?php else: ?>
            <!-- Header -->
            <div class="contact-form-card__header">
                <div class="contact-form-card__header-icon">
                    <i class="fas fa-comment-dots"></i>
                </div>
                <div>
                    <h2>Send us a Message</h2>
                    <p>Fill in the form below and we'll be in touch shortly.</p>
                </div>
            </div>

            <!-- Body -->
            <div class="contact-form-card__body">

                <?php if ($error): ?>
                <div class="cf-alert cf-alert--error">
                    <i class="fas fa-exclamation-circle"></i>
                    <span><?php echo htmlspecialchars($error); ?></span>
                </div>
                <?php endif; ?>

                <form action="contact.php" method="POST" id="contact-form" novalidate>
                    <input type="hidden" name="csrf_token" value="<?php echo generateCSRFToken(); ?>">

                    <!-- Name row -->
                    <div class="cf-row">
                        <div class="cf-group">
                            <label for="first_name">First Name <span class="required">*</span></label>
                            <div class="cf-input-wrap">
                                <i class="fas fa-user cf-icon"></i>
                                <input id="first_name" class="cf-input" type="text" name="first_name"
                                       placeholder="Jane" required
                                       value="<?php echo htmlspecialchars($_POST['first_name'] ?? ''); ?>">
                            </div>
                        </div>
                        <div class="cf-group">
                            <label for="last_name">Last Name <span class="required">*</span></label>
                            <div class="cf-input-wrap">
                                <i class="fas fa-user cf-icon"></i>
                                <input id="last_name" class="cf-input" type="text" name="last_name"
                                       placeholder="Smith" required
                                       value="<?php echo htmlspecialchars($_POST['last_name'] ?? ''); ?>">
                            </div>
                        </div>
                    </div>

                    <!-- Email -->
                    <div class="cf-group" style="margin-bottom:20px;">
                        <label for="email">Email Address <span class="required">*</span></label>
                        <div class="cf-input-wrap">
                            <i class="fas fa-envelope cf-icon"></i>
                            <input id="email" class="cf-input" type="email" name="email"
                                   placeholder="jane.smith@university.edu" required
                                   value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>">
                        </div>
                    </div>

                    <!-- Subject as select + free text row -->
                    <div class="cf-group" style="margin-bottom:20px;">
                        <label for="subject">Subject <span class="required">*</span></label>
                        <div class="cf-input-wrap">
                            <i class="fas fa-tag cf-icon"></i>
                            <input id="subject" class="cf-input" type="text" name="subject"
                                   placeholder="e.g. Article Submission Enquiry, APC Waiver Request…" required
                                   value="<?php echo htmlspecialchars($_POST['subject'] ?? ''); ?>">
                        </div>
                    </div>

                    <div class="cf-divider">Your message</div>

                    <!-- Message -->
                    <div class="cf-group" style="margin-bottom:24px;">
                        <label for="message">Message <span class="required">*</span></label>
                        <textarea id="message" class="cf-textarea" name="message"
                                  placeholder="Please describe your enquiry in as much detail as possible…" required><?php echo htmlspecialchars($_POST['message'] ?? ''); ?></textarea>
                    </div>

                    <!-- Submit -->
                    <button type="submit" class="cf-submit" id="submit-btn">
                        <i class="fas fa-paper-plane"></i>
                        Send Message
                    </button>

                    <!-- Note -->
                    <div class="cf-note">
                        <i class="fas fa-shield-alt" style="flex-shrink:0;"></i>
                        <span>Your information is protected and will only be used to respond to your enquiry.</span>
                    </div>
                </form>
            </div>
            <?php endif; ?>

        </div><!-- /.contact-form-card -->
    </div><!-- /.contact-form-wrapper -->
</div><!-- /.contact-body -->

<script>
// Subtle submit animation
document.getElementById('contact-form')?.addEventListener('submit', function () {
    const btn = document.getElementById('submit-btn');
    if (btn) {
        btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Sending…';
        btn.disabled = true;
    }
});
</script>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
