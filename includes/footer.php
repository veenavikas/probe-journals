</main>

<footer>
    <div class="container">
        <div class="footer-grid">
            <div class="footer-about">
                <img src="<?php echo SITE_URL; ?>/assets/img/probe_publisher_header_v1-removebg-preview.png" alt="<?php echo SITE_NAME; ?>" style="height: 180px; width: auto; margin-bottom: 20px;">
                <p style="color: #94a3b8; font-size: 0.9rem;">
                    <?php echo getSiteSetting('site_tagline'); ?>
                </p>
                <div style="margin-top: 20px; display: flex; gap: 15px;">
                    <a href="#"><i class="fab fa-facebook-square fa-2x"></i></a>
                    <a href="#"><i class="fab fa-twitter-square fa-2x"></i></a>
                    <a href="#"><i class="fab fa-linkedin fa-2x"></i></a>
                </div>
            </div>
            
            <div class="footer-links">
                <h3 style="color: white; margin-bottom: 20px;">Quick Links</h3>
                <ul style="color: #94a3b8; font-size: 0.9rem;">
                    <li><a href="<?php echo SITE_URL; ?>">Home</a></li>
                    <li><a href="<?php echo SITE_URL; ?>/about.php">About Us</a></li>
                    <li><a href="<?php echo SITE_URL; ?>/apc.php">APC & Policies</a></li>
                    <li><a href="<?php echo SITE_URL; ?>/contact.php">Contact Us</a></li>

                </ul>
            </div>
            
            <div class="footer-categories">
                <h3 style="color: white; margin-bottom: 20px;">Categories</h3>
                <ul style="color: #94a3b8; font-size: 0.9rem;">
                    <li><a href="#">Medical Sciences</a></li>
                    <li><a href="#">Clinical Sciences</a></li>
                    <li><a href="#">General Sciences</a></li>
                    <li><a href="#">Engineering</a></li>
                </ul>
            </div>
            
            <div class="footer-newsletter">
                <h3 style="color: white; margin-bottom: 20px;">Newsletter</h3>
                <p style="color: #94a3b8; font-size: 0.9rem; margin-bottom: 15px;">Subscribe to stay updated with latest research.</p>
                <form action="#" method="POST" style="display: flex;">
                    <input type="email" placeholder="Your Email" style="flex: 1; padding: 10px; border-radius: 5px 0 0 5px; border: none;">
                    <button type="submit" class="btn btn-primary" style="padding: 10px 15px; border-radius: 0 5px 5px 0;">Join</button>
                </form>
            </div>
        </div>
        
        <div class="footer-bottom">
            <p>&copy; <?php echo date('Y'); ?> <?php echo SITE_NAME; ?>. All Rights Reserved. | Registered Address: <?php echo getSiteSetting('address_registered'); ?></p>
        </div>
    </div>
</footer>

<script src="<?php echo SITE_URL; ?>/assets/js/main.js"></script>
<?php if (isset($extra_js)): ?>
<script src="<?php echo SITE_URL; ?>/assets/js/<?php echo $extra_js; ?>"></script>
<?php endif; ?>

</body>
</html>
