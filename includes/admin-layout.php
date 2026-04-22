<?php
require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/functions.php';

requireLogin();
checkSessionTimeout();

function renderAdminLayout(string $title, string $content, string $activeNav = ''): void {
    $unreadMessages = getUnreadMessageCount();
    $newSubmissions = getNewSubmissionsCount();
    ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title; ?> | Admin Panel</title>
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;700&display=swap" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <!-- CSS -->
    <link rel="stylesheet" href="<?php echo SITE_URL; ?>/assets/css/admin.css">
</head>
<body class="admin-body">

    <!-- Sidebar -->
    <aside class="sidebar">
        <div class="sidebar-header">
            <h2 style="color: white; font-family: 'DM Sans'; font-size: 1.2rem;"><?php echo SITE_NAME; ?></h2>
        </div>
        
        <nav class="sidebar-nav">
            <a href="<?php echo ADMIN_URL; ?>/index.php" class="nav-item <?php echo $activeNav == 'dashboard' ? 'active' : ''; ?>">
                <i class="fas fa-chart-line"></i> Dashboard
            </a>
            <a href="<?php echo ADMIN_URL; ?>/journals.php" class="nav-item <?php echo $activeNav == 'journals' ? 'active' : ''; ?>">
                <i class="fas fa-book"></i> Journals
            </a>
            <a href="<?php echo ADMIN_URL; ?>/articles.php" class="nav-item <?php echo $activeNav == 'articles' ? 'active' : ''; ?>">
                <i class="fas fa-file-alt"></i> Articles
            </a>
            <a href="<?php echo ADMIN_URL; ?>/editors.php" class="nav-item <?php echo $activeNav == 'editors' ? 'active' : ''; ?>">
                <i class="fas fa-users"></i> Editorial Board
            </a>
            <a href="<?php echo ADMIN_URL; ?>/submissions-inbox.php" class="nav-item <?php echo $activeNav == 'submissions' ? 'active' : ''; ?>">
                <i class="fas fa-paper-plane"></i> Submissions
                <?php if ($newSubmissions > 0): ?>
                    <span class="nav-badge"><?php echo $newSubmissions; ?></span>
                <?php endif; ?>
            </a>
            <a href="<?php echo ADMIN_URL; ?>/pages.php" class="nav-item <?php echo $activeNav == 'pages' ? 'active' : ''; ?>">
                <i class="fas fa-copy"></i> Pages Content
            </a>
            <a href="<?php echo ADMIN_URL; ?>/testimonials.php" class="nav-item <?php echo $activeNav == 'testimonials' ? 'active' : ''; ?>">
                <i class="fas fa-star"></i> Testimonials
            </a>
            <a href="<?php echo ADMIN_URL; ?>/indexing.php" class="nav-item <?php echo $activeNav == 'indexing' ? 'active' : ''; ?>">
                <i class="fas fa-link"></i> Indexing Partners
            </a>
            <a href="<?php echo ADMIN_URL; ?>/contact-messages.php" class="nav-item <?php echo $activeNav == 'messages' ? 'active' : ''; ?>">
                <i class="fas fa-envelope"></i> Contact Messages
                <?php if ($unreadMessages > 0): ?>
                    <span class="nav-badge"><?php echo $unreadMessages; ?></span>
                <?php endif; ?>
            </a>
            <a href="<?php echo ADMIN_URL; ?>/settings.php" class="nav-item <?php echo $activeNav == 'settings' ? 'active' : ''; ?>">
                <i class="fas fa-cog"></i> Site Settings
            </a>
            <div style="margin-top: 40px; border-top: 1px solid #1e293b; padding-top: 10px;">
                <a href="<?php echo ADMIN_URL; ?>/logout.php" class="nav-item">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </a>
            </div>
        </nav>
    </aside>

    <!-- Main Wrapper -->
    <div class="main-wrapper">
        <header class="topbar">
            <h1 class="page-title"><?php echo $title; ?></h1>
            <div class="user-menu">
                <span style="color: #64748b;">Welcome, <strong><?php echo $_SESSION['admin_username']; ?></strong></span>
                <a href="<?php echo SITE_URL; ?>" target="_blank" class="btn-admin" style="background: #e2e8f0; color: #1e293b; text-decoration: none; font-size: 0.8rem;">
                    <i class="fas fa-external-link-alt"></i> View Site
                </a>
            </div>
        </header>

        <main class="admin-content">
            <?php echo $content; ?>
        </main>
    </div>

    <script src="<?php echo SITE_URL; ?>/assets/js/admin.js"></script>
</body>
</html>
    <?php
}
