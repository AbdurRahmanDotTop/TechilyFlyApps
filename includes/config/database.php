<?php
// includes/config/database.php

// Dynamic Base URL Configuration
$script_name = str_replace('\\', '/', $_SERVER['SCRIPT_NAME']);
$script_filename = str_replace('\\', '/', $_SERVER['SCRIPT_FILENAME']);
$doc_root = str_replace('\\', '/', $_SERVER['DOCUMENT_ROOT'] ?? '');
$project_root = str_replace('\\', '/', dirname(dirname(__DIR__)));

$doc_root = rtrim($doc_root, '/');
$base_path = '';

// Method 1: Check if project root is directly under document root (standard setup)
if (!empty($doc_root) && strpos($project_root, $doc_root) === 0) {
    $base_path = substr($project_root, strlen($doc_root));
} else {
    // Method 2: Resolve symlinks (common on Hostinger/cPanel)
    $doc_root_real = !empty($doc_root) ? str_replace('\\', '/', realpath($doc_root)) : '';
    $project_root_real = str_replace('\\', '/', realpath($project_root));
    
    if (!empty($doc_root_real) && !empty($project_root_real) && strpos($project_root_real, $doc_root_real) === 0) {
        $base_path = substr($project_root_real, strlen($doc_root_real));
    } else {
        // Method 3: Fallback using script execution path
        $project_root_real = $project_root_real ?: $project_root;
        $script_filename_real = str_replace('\\', '/', realpath($script_filename)) ?: $script_filename;
        
        $relative_script_path = str_ireplace($project_root_real, '', $script_filename_real);
        if ($relative_script_path !== $script_filename_real) {
            $base_path = substr($script_name, 0, strlen($script_name) - strlen($relative_script_path));
        }
    }
}

$base_url = rtrim($base_path, '/') . '/';
if (empty($base_url) || $base_url === '/') {
    $base_url = '/';
} elseif (strpos($base_url, '/') !== 0) {
    $base_url = '/' . $base_url;
}

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
