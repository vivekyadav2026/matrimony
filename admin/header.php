<?php
require_once __DIR__ . '/../config.php';

if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: login.php");
    exit;
}

$current_page = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($page_title) ? $page_title . ' - Admin' : 'Admin Panel - ' . SITE_NAME; ?></title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
<div class="admin-layout">
    
    <!-- Sidebar -->
    <aside class="sidebar">
        <div class="sidebar-brand">
            Sain<span style="color: var(--primary-red);">matrimony</span>
        </div>
        <ul class="sidebar-menu">
            <li><a href="index.php" class="<?php echo ($current_page == 'index.php') ? 'active' : ''; ?>"><i class="fa fa-tachometer-alt"></i> Dashboard</a></li>
            <li><a href="profiles.php" class="<?php echo ($current_page == 'profiles.php' || $current_page == 'add-profile.php' || $current_page == 'edit-profile.php') ? 'active' : ''; ?>"><i class="fa fa-users"></i> Manage Profiles</a></li>
            <li><a href="add-profile.php" class="<?php echo ($current_page == 'add-profile.php') ? 'active' : ''; ?>"><i class="fa fa-user-plus"></i> Add New Profile</a></li>
            <li><a href="inquiries.php" class="<?php echo ($current_page == 'inquiries.php') ? 'active' : ''; ?>"><i class="fa fa-envelope"></i> User Inquiries</a></li>
            <li><a href="stories.php" class="<?php echo ($current_page == 'stories.php') ? 'active' : ''; ?>"><i class="fa fa-heart"></i> Success Stories</a></li>
            <li><a href="settings.php" class="<?php echo ($current_page == 'settings.php') ? 'active' : ''; ?>"><i class="fa fa-user-cog"></i> Account Settings</a></li>
            <li style="margin-top: 30px;"><a href="../index.php" target="_blank"><i class="fa fa-globe"></i> View Main Site</a></li>
            <li><a href="logout.php" style="color: #ff6b6b;"><i class="fa fa-sign-out-alt"></i> Logout</a></li>
        </ul>
    </aside>

    <!-- Main Content Area -->
    <main class="admin-main">
        <header class="admin-header">
            <div style="display: flex; align-items: center;">
                <button type="button" id="sidebarToggle" class="sidebar-toggle-btn" title="Toggle Sidebar Hide/Show">
                    <i class="fa fa-bars"></i>
                </button>
                <h2 style="margin: 0; font-size: 22px; color: var(--dark-navy); font-weight: 800;"><?php echo isset($page_title) ? $page_title : 'Dashboard'; ?></h2>
            </div>
            <div>
                <span style="font-size: 14px; color: #666; margin-right: 12px;"><i class="fa fa-user-circle"></i> Logged as <strong><?php echo htmlspecialchars($_SESSION['admin_username']); ?></strong></span>
                <a href="settings.php" class="btn-outline btn-sm" style="color: #334155 !important; border-color: #cbd5e1; margin-right: 8px;"><i class="fa fa-key"></i> Password</a>
                <a href="logout.php" class="btn-red btn-sm"><i class="fa fa-power-off"></i> Logout</a>
            </div>
        </header>
