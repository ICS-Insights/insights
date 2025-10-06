<?php
// Temporary script: run once, then delete it.

// Copy your DB credentials into protected config.php (see instructions) and then include:
require __DIR__ . '/config.php'; // config.php should define DB_DSN, DB_USER, DB_PASS

try {
    $pdo = new PDO(DB_DSN, DB_USER, DB_PASS, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);
} catch (Exception $e) {
    die("DB connection error: " . $e->getMessage());
}

// Change these values before running:
$username = 'sysadmin';
$password = 'AlexanderFelpa2020!'; // change before running
$display_name = 'Site Admin';
$role = 'admin';

// Create hash and insert
$hash = password_hash($password, PASSWORD_DEFAULT);

$stmt = $pdo->prepare("INSERT INTO users (username, password_hash, display_name, role) VALUES (?, ?, ?, ?)");
$stmt->execute([$username, $hash, $display_name, $role]);

echo "Admin created. Now delete create_admin.php from the server.";
