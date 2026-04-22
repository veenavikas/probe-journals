<?php
require_once __DIR__ . '/../includes/header.php';

$message_sent = false;
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!verifyCSRFToken($_POST['csrf_token'] ?? '')) {
        $error = "Security token mismatch. Please try submitting again.";
    } else {
        $first_name = sanitize($_POST['first_name'] ?? '');
        $last_name = sanitize($_POST['last_name'] ?? '');
        $email = sanitize($_POST['email'] ?? '');
        $subject = sanitize($_POST['subject'] ?? '');
        $message_text = $_POST['message'] ?? '';
        
        $db = getDB();
        $stmt = $db->prepare("INSERT INTO contact_messages (first_name, last_name, email, subject, message) VALUES (?, ?, ?, ?, ?)");
        if ($stmt->execute([$first_name, $last_name, $email, $subject, $message_text])) {
            $message_sent = true;
            // In real world, sendEmail notification here.
        } else {
            $error = "Failed to send message. Please try again later.";
        }
    }
}

$page_title = "Contact Us";
?>

<section style="background: rgba(79, 70, 229, 0.05); padding: 60px 0;">
    <div class="container">
        <h1 style="font-family: var(--font-serif); font-size: 2.5rem; margin-bottom: 15px; text-align: center;">Get in Touch</h1>
        <p style="text-align: center; color: var(--muted); max-width: 600px; margin: 0 auto;">
            Have questions about submission, peer-review, or publication? We're here to help.
        </p>
    </div>
</section>

<section style="padding: 80px 0;">
    <div class="container">
        <div style="display: grid; grid-template-columns: 1fr 2fr; gap: 50px;">
            <div>
                <div class="neumorphic" style="margin-bottom: 25px;">
                    <h3 style="margin-bottom: 20px; font-size: 1.1rem; color: var(--indigo);"><i class="fas fa-map-marker-alt"></i> Our Address</h3>
                    <p style="font-size: 0.9rem; color: var(--muted); line-height: 1.6;">
                        <strong>Registered:</strong><br>
                        <?php echo nl2br(getSiteSetting('address_registered')); ?>
                    </p>
                    <p style="font-size: 0.9rem; color: var(--muted); line-height: 1.6; margin-top: 15px;">
                        <strong>Main Office:</strong><br>
                        <?php echo nl2br(getSiteSetting('address_main')); ?>
                    </p>
                </div>
                
                <div class="neumorphic" style="margin-bottom: 25px;">
                    <h3 style="margin-bottom: 20px; font-size: 1.1rem; color: var(--indigo);"><i class="fas fa-headset"></i> Contact Info</h3>
                    <p style="font-size: 0.9rem; color: var(--muted); margin-bottom: 10px;">
                        <i class="fas fa-phone"></i> <?php echo getSiteSetting('phone'); ?>
                    </p>
                    <p style="font-size: 0.9rem; color: var(--muted);">
                        <i class="fas fa-envelope"></i> <?php echo getSiteSetting('contact_email'); ?>
                    </p>
                </div>

                <div class="neumorphic" style="background: #1e293b; color: white;">
                    <h3 style="margin-bottom: 15px; font-size: 1rem;">Working Hours</h3>
                    <p style="font-size: 0.85rem; color: #94a3b8;">Mon - Fri: 9:00 AM - 6:00 PM (GMT)</p>
                    <p style="font-size: 0.85rem; color: #94a3b8;">Sat - Sun: Closed</p>
                </div>
            </div>

            <div class="neumorphic" style="padding: 40px;">
                <?php if ($message_sent): ?>
                    <div style="text-align: center; padding: 40px;">
                        <i class="fas fa-check-circle fa-4x" style="color: #059669; margin-bottom: 20px;"></i>
                        <h2 style="margin-bottom: 10px;">Message Sent!</h2>
                        <p style="color: var(--muted);">Thank you for contacting us. We will get back to you within 2 business days.</p>
                        <a href="contact.php" class="btn btn-primary" style="margin-top: 20px;">Send Another Message</a>
                    </div>
                <?php else: ?>
                    <h3 style="margin-bottom: 30px; font-size: 1.5rem;">Send a Message</h3>
                    <?php if ($error) echo "<p style='color: #dc2626; margin-bottom: 20px;'>$error</p>"; ?>
                    
                    <form action="contact.php" method="POST">
                        <input type="hidden" name="csrf_token" value="<?php echo generateCSRFToken(); ?>">
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
                            <div class="form-group">
                                <label>First Name</label>
                                <input type="text" name="first_name" required>
                            </div>
                            <div class="form-group">
                                <label>Last Name</label>
                                <input type="text" name="last_name" required>
                            </div>
                        </div>
                        <div class="form-group" style="margin-bottom: 20px;">
                            <label>Email Address</label>
                            <input type="email" name="email" required>
                        </div>
                        <div class="form-group" style="margin-bottom: 20px;">
                            <label>Subject</label>
                            <input type="text" name="subject" required>
                        </div>
                        <div class="form-group" style="margin-bottom: 30px;">
                            <label>Your Message</label>
                            <textarea name="message" rows="6" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary" style="width: 100%; padding: 15px;">Send Message</button>
                    </form>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
