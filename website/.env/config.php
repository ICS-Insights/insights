<?php
// config.php - MUST be protected and NOT world-readable.
// Recommended: move this file outside public_html; otherwise protect via .htaccess

// Replace these placeholders with your DB credentials on the server:
define('DB_HOST', 'sql101.infinityfree.com');
define('DB_NAME', 'if0_38327880_insights');
define('DB_USER', 'if0_38327880');
define('DB_PASS', 'ICSInsights24'); // <<< paste the real one on the server

// DSN for PDO
define('DB_DSN', 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8mb4');

session_start();

// Helper: connect to DB
function db_connect(){
    static $pdo;
    if ($pdo === null) {
        $pdo = new PDO(DB_DSN, DB_USER, DB_PASS, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]);
    }
    return $pdo;
}

// Basic auth helper
function is_logged_in(){
    return !empty($_SESSION['user_id']);
}
