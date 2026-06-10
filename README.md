# Probe Journals — Complete PHP Application

This is a custom-built academic publishing platform for Probe Journals (probejournals.com). It features a high-performance PHP 8.2 backend, a neumorphic design system, and a comprehensive administrative panel for total content control.

## Deployment (Production)

This application is designed to be "server-ready" with environment variable support.

1.  **File Upload**:
    -   Upload the entire project to your server.
    -   If your server allows pointing the web root to a specific folder, point it to `public/`.
    -   If not, the root `index.php` will automatically handle routing from the project root.

2.  **Configuration**:
    -   Copy `.env.example` to `.env` in the project root.
    -   Update the database credentials and `SITE_URL`.
    -   Configure the `MAIL_` settings with your SMTP details for email functionality.

3.  **Database Setup**:
    -   Import `database/schema.sql` into your MySQL database via phpMyAdmin or command line.

4.  **Security**:
    -   Log in to `/admin` (admin / Admin@123).
    -   Change the admin password immediately.
    -   Ensure `public/assets/uploads/` is writable (755 or 775).

## Local Development
- Run `./start.sh` to launch a local dev server with pre-configured environment variables.
- Or use `php -S localhost:8080 router.php`.


## Security Features
- **PDO Prepared Statements**: Zero raw SQL usage to prevent injections.
- **CSRF Protection**: Tokens enforced on all public and admin forms.
- **Credential Hashing**: `password_hash()` for all administrative accounts.
- **MIME Validation**: Strict check for PDF and image file uploads.
- **URL Rewriting**: Pretty URLs for journals via `.htaccess`.
