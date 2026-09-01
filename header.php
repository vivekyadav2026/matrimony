<?php
require_once __DIR__ . '/config.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($page_title) ? $page_title . ' - ' . SITE_NAME : SITE_NAME . ' | Search Profiles by Caste and Community'; ?></title>
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>

    <!-- Top Bar -->
    <div class="top-bar">
        <div class="container">
            <ul>
                <li><a href="<?php echo BASE_URL; ?>register.php"><i class="fa fa-user-plus"></i> Register Free</a></li>
                <li><a href="<?php echo BASE_URL; ?>search.php"><i class="fa fa-search"></i> Search Profiles</a></li>
            </ul>
        </div>
    </div>

    <!-- Main Header Navigation -->
    <header class="main-header">
        <div class="container">
            <a href="<?php echo BASE_URL; ?>" class="logo">
                <div class="logo-text">Sain<span>matrimony.in</span></div>
            </a>
            
            <button type="button" id="mobileNavToggle" class="mobile-nav-toggle" aria-label="Toggle Navigation Menu">
                <i class="fa fa-bars"></i>
            </button>

            <ul class="nav-links" id="mainNavLinks">
                <li><a href="<?php echo BASE_URL; ?>"><i class="fa fa-home"></i> Home</a></li>
                <li><a href="<?php echo BASE_URL; ?>search.php">Search Profiles</a></li>
                <li><a href="<?php echo BASE_URL; ?>stories.php">Success Stories</a></li>
                <li><a href="<?php echo BASE_URL; ?>register.php" class="btn-red"><i class="fa fa-pencil"></i> Register Free</a></li>
            </ul>
        </div>
    </header>
