# Probe Journals — Complete PHP Application

This is a custom-built academic publishing platform for Probe Journals (probejournals.com). It features a high-performance PHP 8.2 backend, a neumorphic design system, and a comprehensive administrative panel for total content control.

## Deployment to Hostinger (Production)

Follow these steps exactly to deploy the application successfully:

1.  **File Upload**:
    -   Upload all files inside the `public/` directory to the Hostinger `public_html/` folder.
    -   Upload the `admin/` directory into `public_html/admin/`.
    -   **CRITICAL**: Move the `includes/`, `config/`, and `database/` directories to the level **OUTSIDE** `public_html` for maximum security.

2.  **Database Setup**:
    -   Create a new MySQL database in the Hostinger hPanel.
    -   Open phpMyAdmin and import the `database/schema.sql` file.
    -   Verify that all 10 tables are created and seed data (journals, admin user) is populated.

3.  **Configuration**:
    -   Edit `config/config.php`.
    -   Update `DB_HOST`, `DB_NAME`, `DB_USER`, and `DB_PASS` with your Hostinger credentials.
    -   Update `SITE_URL` to your production domain (e.g., `https://probejournals.com`).
    -   Configure the `MAIL_` settings with your Hostinger SMTP details for form notifications.

4.  **Security Protocol**:
    -   Navigate to `yourdomain.com/admin`.
    -   Login with:
        -   Username: `admin`
        -   Password: `Admin@123`
    -   **IMMEDIATELY** go to Site Settings and change the administrator password.

5.  **Final Checks**:
    -   Visit the homepage and toggle Dark Mode to ensure localStorage is working.
    -   Test a journal page and ensure all 8 tabs load correctly.
    -   Upload a test article PDF via the admin panel to verify folder permissions (`assets/uploads/pdfs/` must be writable).

## Local Development
- Requirement: PHP 8.2+, MySQL 8.0+
- Root Directory: Point your local server to the `public/` directory.
- Database: Import `schema.sql` to a database named `probe_journals`.

## Security Features
- **PDO Prepared Statements**: Zero raw SQL usage to prevent injections.
- **CSRF Protection**: Tokens enforced on all public and admin forms.
- **Credential Hashing**: `password_hash()` for all administrative accounts.
- **MIME Validation**: Strict check for PDF and image file uploads.
- **URL Rewriting**: Pretty URLs for journals via `.htaccess`.
