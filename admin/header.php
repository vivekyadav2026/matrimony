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
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">
    <title><?php echo isset($page_title) ? $page_title . ' - Admin' : 'Admin Panel - ' . SITE_NAME; ?></title>
    <link rel="icon" type="image/png" href="../images/favicon.png?v=<?php echo filemtime(__DIR__ . '/../images/favicon.png'); ?>">
    <link rel="stylesheet" href="../css/style.css?v=<?php echo filemtime(__DIR__ . '/../css/style.css'); ?>">
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
            <li><a href="profiles.php" class="<?php echo ($current_page == 'profiles.php' || $current_page == 'edit-profile.php') ? 'active' : ''; ?>"><i class="fa fa-users"></i> Manage Profiles</a></li>
            <li><a href="add-profile.php" class="<?php echo ($current_page == 'add-profile.php') ? 'active' : ''; ?>"><i class="fa fa-user-plus"></i> Add New Profile</a></li>
            <li><a href="inquiries.php" class="<?php echo ($current_page == 'inquiries.php') ? 'active' : ''; ?>"><i class="fa fa-envelope"></i> User Inquiries</a></li>
            <li><a href="stories.php" class="<?php echo ($current_page == 'stories.php') ? 'active' : ''; ?>"><i class="fa fa-heart"></i> Success Stories</a></li>
            <li><a href="settings.php" class="<?php echo ($current_page == 'settings.php') ? 'active' : ''; ?>"><i class="fa fa-user-cog"></i> Account Settings</a></li>
            <li style="margin-top: 15px;"><a href="../index.php" target="_blank"><i class="fa fa-globe"></i> View Main Site</a></li>
        </ul>

        <!-- User Profile inside Sidebar -->
        <div style="margin-top: auto; padding: 20px; border-top: 1px solid rgba(255,255,255,0.1); display: flex; flex-direction: column; gap: 10px;">
            <div style="display: flex; align-items: center; gap: 10px; color: #fff;">
                <div style="width: 35px; height: 35px; background: var(--primary-red); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 16px; font-weight: bold;">
                    <?php echo strtoupper(substr($_SESSION['admin_username'], 0, 1)); ?>
                </div>
                <div>
                    <div style="font-size: 14px; font-weight: 700;"><?php echo htmlspecialchars($_SESSION['admin_username']); ?></div>
                    <div style="font-size: 11px; color: #94a3b8;">Administrator</div>
                </div>
            </div>
            <div style="display: flex; gap: 8px; margin-top: 5px;">
                <a href="settings.php" class="btn-outline btn-sm" style="flex: 1; border-color: rgba(255,255,255,0.2); color: #fff !important; text-align: center; justify-content: center; padding: 6px;"><i class="fa fa-key"></i> Pass</a>
                <a href="logout.php" class="btn-red btn-sm" style="flex: 1; text-align: center; justify-content: center; padding: 6px;"><i class="fa fa-power-off"></i> Logout</a>
            </div>
        </div>
    </aside>

    <!-- Main Content Area -->
    <main class="admin-main">
        <header class="admin-header">
            <div style="display: flex; align-items: center; width: 100%;">
                <button type="button" id="sidebarToggle" class="sidebar-toggle-btn" title="Toggle Sidebar Hide/Show" style="margin-right: 15px;">
                    <i class="fa fa-bars"></i>
                </button>
                <h2 style="margin: 0; font-size: 22px; color: var(--dark-navy); font-weight: 800;"><?php echo isset($page_title) ? $page_title : 'Dashboard'; ?></h2>
            </div>
        </header>
