<?php
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/functions.php';

logoutUser();
header("Location: " . ADMIN_URL . "/login.php?logout=1");
exit();
