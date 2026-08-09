<?php
// modules/apps/download.php
require_once __DIR__ . '/../../includes/config/database.php';

$id = $_GET['id'] ?? null;
$type = $_GET['type'] ?? '';

if (!$id || !in_array($type, ['apk', 'playstore', 'appstore', 'indus', 'amazon'])) {
    header('Location: ' . BASE_URL . 'modules/apps/index.php');
    exit;
}

$pdo = getDBConnection();

// Fetch app to check if link exists
$stmt = $pdo->prepare("SELECT id, apk_download_link, play_store_link, app_store_link, indus_store_link, amazon_store_link FROM apps WHERE id = :id LIMIT 1");
$stmt->execute([':id' => $id]);
$app = $stmt->fetch();

if (!$app) {
    header('Location: ' . BASE_URL . 'modules/apps/index.php');
    exit;
}

$redirect_url = '';

if ($type === 'apk' && !empty($app['apk_download_link'])) {
    $redirect_url = $app['apk_download_link'];
} elseif ($type === 'playstore' && !empty($app['play_store_link'])) {
    $redirect_url = $app['play_store_link'];
} elseif ($type === 'appstore' && !empty($app['app_store_link'])) {
    $redirect_url = $app['app_store_link'];
} elseif ($type === 'indus' && !empty($app['indus_store_link'])) {
    $redirect_url = $app['indus_store_link'];
} elseif ($type === 'amazon' && !empty($app['amazon_store_link'])) {
    $redirect_url = $app['amazon_store_link'];
}

if ($redirect_url) {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    
    if (!isset($_SESSION['downloaded_apps'])) {
        $_SESSION['downloaded_apps'] = [];
    }

    // Only increment if not already downloaded in this session
    if (!in_array($id, $_SESSION['downloaded_apps'])) {
        try {
            $updateStmt = $pdo->prepare("UPDATE apps SET downloads = downloads + 1 WHERE id = :id");
            $updateStmt->execute([':id' => $id]);
            // Mark as downloaded
            $_SESSION['downloaded_apps'][] = $id;
        } catch (PDOException $e) {
            // Silently fail if count update fails, still redirect
        }
    }
    
    // Redirect to the actual file or store link
    header('Location: ' . $redirect_url);
    exit;
} else {
    // Link empty, fallback to app list
    header('Location: ' . BASE_URL . 'modules/apps/index.php');
    exit;
}
