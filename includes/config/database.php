<?php
// includes/config/database.php

// Dynamic Base URL Configuration
$project_root = str_replace('\\', '/', dirname(dirname(__DIR__)));
$document_root = str_replace('\\', '/', $_SERVER['DOCUMENT_ROOT']);
$base_path = str_replace($document_root, '', $project_root);
$base_url = rtrim($base_path, '/') . '/';
define('BASE_URL', $base_url);

define('DB_HOST', 'localhost');
define('DB_NAME', 'techilyfly_app');
define('DB_USER', 'root');
define('DB_PASS', '');

function getDBConnection() {
    try {
        $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4";
        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];
        return new PDO($dsn, DB_USER, DB_PASS, $options);
    } catch (PDOException $e) {
        die("Database connection failed: " . $e->getMessage());
    }
}
