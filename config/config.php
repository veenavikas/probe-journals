<?php
/**
 * ============================================================
 *  Probe Journals — Configuration
 * ============================================================
 *  LOCAL DEV:  php -S localhost:8080 router.php  (from project root)
 *  PRODUCTION: Update DB_*, SITE_URL, ADMIN_URL, MAIL_* below
 * ============================================================
 */
require_once __DIR__ . '/../vendor/autoload.php';

// Load .env if it exists
if (file_exists(__DIR__ . '/../.env')) {
    $dotenv = Dotenv\Dotenv::createUnsafeImmutable(__DIR__ . '/../');
    $dotenv->safeLoad();
}

// ── Database ────────────────────────────────────────────────
define('DB_HOST',    getenv('DB_HOST')    ?: 'localhost');
define('DB_NAME',    getenv('DB_NAME')    ?: 'probe_journals');
define('DB_USER',    getenv('DB_USER')    ?: 'root');          // Change for production
define('DB_PASS',    getenv('DB_PASS')    ?: '');               // Change for production
define('DB_CHARSET', 'utf8mb4');

// Load local overrides if they exist (for production/hostinger)
if (file_exists(__DIR__ . '/config.local.php')) {
    include __DIR__ . '/config.local.php';
}

// ── URLs ─────────────────────────────────────────────────────
// Local dev (php -S localhost:8080 router.php) → http://localhost:8080
// Production                                   → https://probejournals.com
$_detected_host = getenv('SITE_URL') ?: 'http://localhost:8080';
define('SITE_URL',  rtrim($_detected_host, '/'));
define('ADMIN_URL', SITE_URL . '/admin');
define('SITE_NAME', 'Probe Journals');

// ── File Uploads ─────────────────────────────────────────────
define('UPLOAD_PATH', __DIR__ . '/../public/assets/uploads/');
define('UPLOAD_URL',  '/assets/uploads/');

define('MAX_PDF_SIZE', 10 * 1024 * 1024);    // 10 MB
define('MAX_IMG_SIZE',  2 * 1024 * 1024);    //  2 MB
define('ALLOWED_PDF', ['application/pdf']);
define('ALLOWED_IMG', ['image/jpeg', 'image/png', 'image/webp']);

// ── Mail (Hostinger SMTP) ────────────────────────────────────
define('MAIL_HOST',      getenv('MAIL_HOST')      ?: 'smtp.hostinger.com');
define('MAIL_PORT',      (int)(getenv('MAIL_PORT') ?: 587));
define('MAIL_USER',      getenv('MAIL_USER')      ?: 'noreply@probejournals.com');
define('MAIL_PASS',      getenv('MAIL_PASS')      ?: 'your_email_password');  // Change!
define('MAIL_FROM',      getenv('MAIL_FROM')      ?: 'noreply@probejournals.com');
define('MAIL_FROM_NAME', 'Probe Journals');
define('MAIL_ADMIN',     getenv('MAIL_ADMIN')     ?: 'contact@probejournals.com');
