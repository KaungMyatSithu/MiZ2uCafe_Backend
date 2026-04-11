<?php
// connect.php

define('DB_HOST', 'miz2u-db.cvu27ztcpdw4.us-east-1.rds.amazonaws.com');  
define('DB_NAME', 'miz2udb');
define('DB_USER', 'admin');
define('DB_PASS', 'kaungmyat714');

try {
    $pdo = new PDO(
        "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4",
        DB_USER,
        DB_PASS,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false
        ]
    );
    // Connection successful
} catch (PDOException $e) {
    error_log("Database Connection Failed: " . $e->getMessage());
    http_response_code(500);
    echo json_encode(['error' => 'Database connection failed']);
    error_log($e->getMessage());
    exit;
}