<?php
// connect.php

define('DB_HOST', 'miz2u-db.cbyme8yi00wr.us-east-1.rds.amazonaws.com');
define('DB_NAME', 'miz2u_db');
define('DB_USER', 'admin');
define('DB_PASS', 'kaungmyat71#');

try {
    $pdo = new PDO(
        "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4",
        DB_USER,
        DB_PASS,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]
    );
    // Connection successful
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Database connection failed']);
    error_log($e->getMessage());
    exit;
}
