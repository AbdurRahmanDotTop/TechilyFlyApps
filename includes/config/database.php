<?php
// includes/config/database.php

// Dynamic Base URL Configuration
$project_root = str_replace('\\', '/', dirname(dirname(__DIR__)));
$document_root = rtrim(str_replace('\\', '/', $_SERVER['DOCUMENT_ROOT']), '/');

$base_path = str_replace($document_root, '', $project_root);

// Fallback if str_replace failed due to symlinks on shared hosting
if ($base_path === $project_root) {
    // We can't rely on str_replace. Let's use SCRIPT_NAME to guess the base path.
    // If the script is /apps/index.php, and we know it's at the root of the project, base is /apps
    // If the script is /apps/modules/apps/index.php, we need to strip /modules/apps/index.php
    $script_name = $_SERVER['SCRIPT_NAME'];
    $script_filename = str_replace('\\', '/', $_SERVER['SCRIPT_FILENAME']);
    
    // We know project_root is the absolute path to the TechilyFlyApps directory.
    // script_filename is the absolute path to the executed script (e.g. .../TechilyFlyApps/modules/apps/index.php)
    // The relative path inside the project is:
    $relative_script_path = str_replace($project_root, '', $script_filename);
    
    // So if script_name is /apps/modules/apps/index.php, and relative_script_path is /modules/apps/index.php
    // We can subtract relative_script_path from script_name to get the base url!
    $base_path = substr($script_name, 0, strlen($script_name) - strlen($relative_script_path));
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
