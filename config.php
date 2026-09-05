<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Disable HTML Caching so users always get live updates instantly
if (!headers_sent()) {
    header("Cache-Control: no-cache, no-store, must-revalidate");
    header("Pragma: no-cache");
    header("Expires: 0");
}

// -------------------------------------------------------------
// SECURE DATABASE CONFIGURATION
// -------------------------------------------------------------
// 1. Detect if we are running on a local development server
$http_host = $_SERVER['HTTP_HOST'] ?? 'localhost';
$is_local = (
    strpos($http_host, 'localhost') !== false ||
    strpos($http_host, '127.0.0.1') !== false ||
    $http_host === '::1'
);

// 2. Only use local config if we are ACTUALLY on localhost
// This prevents breaking the live site if config.local.php is uploaded by mistake!
if ($is_local && file_exists(__DIR__ . '/config.local.php')) {
    require_once __DIR__ . '/config.local.php';
} else {
    // -------------------------------------------------------------
    // LIVE PRODUCTION SERVER ENVIRONMENT
    // Enter your live server details here. When you push this file 
    // to the live server, it will not be overwritten by your local DB details.
    // -------------------------------------------------------------
    $db_host = 'localhost';
    $db_user = 'live_matrimony_user';     // Update this once on the live server
    $db_pass = 'LIVE_DB_PASSWORD_HERE';   // Update this once on the live server
    $db_name = 'live_matrimony_db';       // Update this once on the live server
    
    // Auto-detect protocol (http vs https) & live host domain
    $http_host = $_SERVER['HTTP_HOST'] ?? 'localhost';
    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https://' : 'http://';
    $base_url = $protocol . $http_host . '/';
}

try {
    $pdo = new PDO("mysql:host=$db_host;dbname=$db_name;charset=utf8mb4", $db_user, $db_pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Database Connection Error: " . $e->getMessage());
}

// Global Site Constants
define('SITE_NAME', 'Sainmatrimony.in');
define('BASE_URL', $base_url);
define('ADMIN_WHATSAPP', '918528600100'); // Central Admin WhatsApp Number

if (!function_exists('build_whatsapp_link')) {
    function build_whatsapp_link($message) {
        $clean_phone = preg_replace('/[^0-9]/', '', ADMIN_WHATSAPP);
        return "https://wa.me/" . $clean_phone . "?text=" . rawurlencode($message);
    }
}

if (!function_exists('get_profile_photo_url')) {
    function get_profile_photo_url($photo, $is_admin = false) {
        $photo = trim($photo ?? '');
        $prefix = $is_admin ? '../' : '';
        if (empty($photo)) {
            return $prefix . 'images/default.jpg';
        }
        if (file_exists(__DIR__ . '/images/' . $photo)) {
            return $prefix . 'images/' . $photo;
        }
        if (file_exists(__DIR__ . '/uploads/' . $photo)) {
            return $prefix . 'uploads/' . $photo;
        }
        return $prefix . 'images/default.jpg';
    }
}
?>
