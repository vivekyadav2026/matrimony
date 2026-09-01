<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Environment Detection: Check if running on Local Server (localhost/127.0.0.1) or Live Production Server
$http_host = $_SERVER['HTTP_HOST'] ?? 'localhost';
$is_local = (
    $http_host === 'localhost' ||
    $http_host === '127.0.0.1' ||
    $http_host === '::1' ||
    strpos($http_host, 'localhost:') !== false ||
    strpos($http_host, '127.0.0.1:') !== false
);

if ($is_local) {
    // -------------------------------------------------------------
    // LOCAL DEVELOPMENT ENVIRONMENT (XAMPP / WAMP)
    // -------------------------------------------------------------
    $db_host = 'localhost';
    $db_user = 'root';
    $db_pass = '';
    $db_name = 'manglik_matrimony_db';
    $base_url = 'http://localhost/matrimony/';
} else {
    // -------------------------------------------------------------
    // LIVE PRODUCTION SERVER ENVIRONMENT (cPanel / VPS / Shared Hosting)
    // Local git pushes will automatically use these live server credentials on production!
    // -------------------------------------------------------------
    $db_host = getenv('DB_HOST') ?: 'localhost';
    $db_user = getenv('DB_USER') ?: 'live_matrimony_user';     // Update live DB user
    $db_pass = getenv('DB_PASS') ?: 'LIVE_DB_PASSWORD_HERE';   // Update live DB password
    $db_name = getenv('DB_NAME') ?: 'live_matrimony_db';       // Update live DB name
    
    // Auto-detect protocol (http vs https) & live host domain
    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https://' : 'http://';
    $base_url = getenv('BASE_URL') ?: ($protocol . $http_host . '/');
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
?>
