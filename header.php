<?php
require_once __DIR__ . '/config.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">
    <title><?php echo isset($page_title) ? $page_title . ' - ' . SITE_NAME : SITE_NAME . ' | Search Profiles by Caste and Community'; ?></title>
    <link rel="icon" type="image/png" href="<?php echo BASE_URL; ?>images/favicon.png?v=<?php echo filemtime(__DIR__ . '/images/favicon.png'); ?>">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>css/style.css?v=<?php echo filemtime(__DIR__ . '/css/style.css'); ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>

    <!-- Top Bar -->
    <div class="top-bar">
        <div class="container">
            <ul>
                <li><a href="<?php echo BASE_URL; ?>register.php"><i class="fa fa-paper-plane"></i> Submit Biodata</a></li>
                <li><a href="<?php echo BASE_URL; ?>search.php"><i class="fa fa-search"></i> Search Profiles</a></li>
            </ul>
        </div>
    </div>

    <!-- Main Header Navigation -->
    <header class="main-header">
        <div class="container">
            <a href="<?php echo BASE_URL; ?>" class="logo" style="display: flex; align-items: center; gap: 10px; text-decoration: none;">
                <img src="<?php echo BASE_URL; ?>images/favicon.png" alt="Sain Matrimony Logo" style="width: 36px; height: 36px; border-radius: 50%; object-fit: cover; border: 2px solid #fee2e2; background: #fff;">
                <div class="logo-text">Sain<span>matrimony.in</span></div>
            </a>
            
            <button type="button" id="mobileNavToggle" class="mobile-nav-toggle" aria-label="Toggle Navigation Menu">
                <i class="fa fa-bars"></i>
            </button>

            <ul class="nav-links" id="mainNavLinks">
                <li><a href="<?php echo BASE_URL; ?>"><i class="fa fa-home"></i> Home</a></li>
                <li><a href="<?php echo BASE_URL; ?>search.php"><i class="fa fa-search"></i> Profiles</a></li>
                <li><a href="<?php echo BASE_URL; ?>about.php"><i class="fa fa-info-circle"></i> About Us</a></li>
                <li><a href="<?php echo BASE_URL; ?>services.php"><i class="fa fa-cogs"></i> Services</a></li>
                <li><a href="<?php echo BASE_URL; ?>stories.php"><i class="fa fa-heart"></i> Stories</a></li>
                <li><a href="<?php echo BASE_URL; ?>contact.php"><i class="fa fa-envelope"></i> Contact</a></li>
                <li><a href="<?php echo BASE_URL; ?>register.php" class="btn-red"><i class="fa fa-paper-plane"></i> Submit Biodata</a></li>
            </ul>
        </div>
    </header>

    <!-- Rishta Sangam Style Mobile Navigation Drawer & Overlay -->
    <div class="mobile-drawer-overlay" id="mobileDrawerOverlay"></div>
    <div class="mobile-drawer" id="mobileDrawer">
        <!-- Drawer Header -->
        <div class="mobile-drawer-header">
            <div class="mobile-drawer-brand">
                <div class="brand-heart-icon"><i class="fa fa-heart"></i></div>
                <div>
                    <div class="brand-name">SAIN MATRIMONY</div>
                    <div class="brand-sub">COMMUNITY MATRIMONY</div>
                </div>
            </div>
            <button type="button" class="drawer-close-btn" id="closeMobileDrawer" aria-label="Close Menu">
                <i class="fa fa-times"></i>
            </button>
        </div>

        <!-- Drawer Body -->
        <div class="mobile-drawer-body">
            <div class="drawer-section-label">MENU</div>
            
            <div class="drawer-menu-list">
                <a href="<?php echo BASE_URL; ?>" class="drawer-menu-card">
                    <div class="drawer-card-icon"><i class="fa fa-home"></i></div>
                    <span class="drawer-card-text">Home</span>
                    <i class="fa fa-arrow-right drawer-card-arrow"></i>
                </a>
                
                <a href="<?php echo BASE_URL; ?>search.php" class="drawer-menu-card">
                    <div class="drawer-card-icon"><i class="fa fa-users"></i></div>
                    <span class="drawer-card-text">Browse Profiles</span>
                    <i class="fa fa-arrow-right drawer-card-arrow"></i>
                </a>

                <a href="<?php echo BASE_URL; ?>about.php" class="drawer-menu-card">
                    <div class="drawer-card-icon"><i class="fa fa-info-circle"></i></div>
                    <span class="drawer-card-text">About</span>
                    <i class="fa fa-arrow-right drawer-card-arrow"></i>
                </a>

                <a href="<?php echo BASE_URL; ?>services.php" class="drawer-menu-card">
                    <div class="drawer-card-icon"><i class="fa fa-hand-holding-heart"></i></div>
                    <span class="drawer-card-text">Services</span>
                    <i class="fa fa-arrow-right drawer-card-arrow"></i>
                </a>

                <a href="<?php echo BASE_URL; ?>stories.php" class="drawer-menu-card">
                    <div class="drawer-card-icon"><i class="fa fa-heart"></i></div>
                    <span class="drawer-card-text">Success Stories</span>
                    <i class="fa fa-arrow-right drawer-card-arrow"></i>
                </a>

                <a href="<?php echo BASE_URL; ?>contact.php" class="drawer-menu-card">
                    <div class="drawer-card-icon"><i class="fa fa-envelope"></i></div>
                    <span class="drawer-card-text">Contact Desk</span>
                    <i class="fa fa-arrow-right drawer-card-arrow"></i>
                </a>
            </div>
        </div>

        <!-- Drawer Footer Buttons -->
        <div class="mobile-drawer-footer">
            <a href="<?php echo BASE_URL; ?>register.php" class="drawer-btn-primary">
                Submit Biodata
            </a>
            <div class="drawer-dual-btns">
                <a href="tel:8528600100" class="drawer-btn-call">
                    <i class="fa fa-phone-alt"></i> Call
                </a>
                <a href="https://wa.me/918528600100?text=Hello%20Sainmatrimony,%20I%20want%20to%20inquire%20about%20matrimonial%20profiles" target="_blank" class="drawer-btn-whatsapp">
                    <i class="fab fa-whatsapp"></i> WhatsApp
                </a>
            </div>
        </div>
    </div>
