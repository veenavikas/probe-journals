<?php
require_once __DIR__ . '/functions.php';
$journals_nav = getAllJournals();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($page_title) ? $page_title . " | " . SITE_NAME : SITE_NAME; ?></title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,100..1000;1,9..40,100..1000&family=Lora:ital,wght@0,400..700;1,400..700&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <!-- CSS -->
    <link rel="stylesheet" href="<?php echo SITE_URL; ?>/assets/css/main.css">
    <?php if (isset($extra_css)): ?>
    <link rel="stylesheet" href="<?php echo SITE_URL; ?>/assets/css/<?php echo $extra_css; ?>">
    <?php endif; ?>

    <script>
        // Check for saved theme
        const savedTheme = localStorage.getItem('theme') || 'light';
        document.documentElement.setAttribute('data-theme', savedTheme);
    </script>
</head>
<body class="<?php echo isset($body_class) ? $body_class : ''; ?>">

<header>
    <div class="top-bar">
        <div class="container" style="display: flex; justify-content: space-between;">
            <div>
                <i class="fas fa-phone"></i> <?php echo getSiteSetting('phone'); ?> &nbsp;|&nbsp; 
                <i class="fas fa-envelope"></i> <?php echo getSiteSetting('contact_email'); ?>
            </div>
            <div>
                Follow us: 
                <a href="#"><i class="fab fa-facebook"></i></a>
                <a href="#"><i class="fab fa-twitter"></i></a>
                <a href="#"><i class="fab fa-linkedin"></i></a>
            </div>
        </div>
    </div>
    
    <div class="container nav-container">
        <a href="<?php echo SITE_URL; ?>" class="logo">
            <h1 style="font-family: var(--font-serif); color: var(--indigo);"><?php echo SITE_NAME; ?></h1>
        </a>
        
        <nav id="main-nav">
            <ul>
                <!-- 1. Home (with Author Guidelines sub-menu) -->
                <li class="dropdown">
                    <a href="<?php echo SITE_URL; ?>">
                        Home <i class="fas fa-chevron-down dropdown-chevron"></i>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a href="<?php echo SITE_URL; ?>/author-guidelines.php"><i class="fas fa-book-open"></i> Author Guidelines</a></li>
                    </ul>
                </li>

                <!-- 2. List of Journals -->
                <li><a href="<?php echo SITE_URL; ?>/list-of-journals.php">List of Journals</a></li>

                <!-- 3. APC -->
                <li><a href="<?php echo SITE_URL; ?>/apc.php">APC</a></li>

                <!-- 4. Journals — Mega Menu -->
                <li class="dropdown mega-dropdown">
                    <a href="<?php echo SITE_URL; ?>/list-of-journals.php">
                        Journals <i class="fas fa-chevron-down dropdown-chevron"></i>
                    </a>
                    <div class="mega-menu">
                        <div class="mega-menu__inner">
                            <div class="mega-menu__header">
                                <span><i class="fas fa-layer-group"></i> Our Journals</span>
                                <a href="<?php echo SITE_URL; ?>/list-of-journals.php" class="mega-menu__view-all">View All <i class="fas fa-arrow-right"></i></a>
                            </div>
                            <div class="mega-menu__grid">
                                <?php if (!empty($journals_nav)): foreach ($journals_nav as $j): ?>
                                <a href="<?php echo SITE_URL; ?>/journal.php?slug=<?php echo htmlspecialchars($j['slug'] ?? ''); ?>" class="mega-menu__item">
                                    <span class="mega-menu__item-icon"><i class="fas fa-book"></i></span>
                                    <span class="mega-menu__item-title"><?php echo htmlspecialchars($j['name'] ?? 'Untitled'); ?></span>
                                </a>
                                <?php endforeach; endif; ?>
                            </div>
                        </div>
                    </div>
                </li>

                <!-- 5. Services -->
                <li><a href="<?php echo SITE_URL; ?>/services.php">Services</a></li>

                <!-- 6. Membership -->
                <li><a href="<?php echo SITE_URL; ?>/membership.php">Membership</a></li>

                <!-- 7. Contact Us -->
                <li><a href="<?php echo SITE_URL; ?>/contact.php">Contact Us</a></li>
            </ul>
        </nav>
        
        <div style="display: flex; align-items: center; gap: 20px;">
            <button class="theme-toggle" id="theme-toggle" title="Toggle Dark Mode">
                <i class="fas fa-moon"></i>
            </button>
            <a href="<?php echo SITE_URL; ?>/submissions.php" class="btn btn-primary">Submit Article</a>
        </div>
    </div>
</header>
<main>
