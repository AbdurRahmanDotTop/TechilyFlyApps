<?php
// admin/apps/duplicate.php
require_once __DIR__ . '/../includes/auth.php';
require_login();
require_once __DIR__ . '/../../includes/config/database.php';
$pdo = getDBConnection();

$id = $_GET['id'] ?? null;
if (!$id) {
    header("Location: " . BASE_URL . "admin/apps/index.php");
    exit;
}

try {
    // Get the original app
    $stmt = $pdo->prepare("SELECT * FROM apps WHERE id = ?");
    $stmt->execute([$id]);
    $app = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($app) {
        // Create new values
        $newName = $app['name'] . ' (Copy)';
        
        // Generate a unique slug
        $baseSlug = $app['slug'] . '-copy';
        $newSlug = $baseSlug;
        $counter = 1;
        while (true) {
            $checkStmt = $pdo->prepare("SELECT id FROM apps WHERE slug = ?");
            $checkStmt->execute([$newSlug]);
            if (!$checkStmt->fetch()) {
                break;
            }
            $newSlug = $baseSlug . '-' . $counter;
            $counter++;
        }

        // Insert duplicate
        $insertStmt = $pdo->prepare("
            INSERT INTO apps (
                category_id, name, slug, developer, version, play_store_rating, indus_store_rating, 
                play_store_version, indus_store_version, play_store_downloads, indus_store_downloads, 
                logo_url, banner_url, description, requirements, apk_download_link, is_apk_active, 
                play_store_link, is_play_store_active, app_store_link, is_app_store_active, 
                indus_store_link, is_indus_store_active, amazon_store_link, is_amazon_store_active, 
                status, is_featured, publish_date, app_update_date, downloads, rating
            ) VALUES (
                :category_id, :name, :slug, :developer, :version, :play_store_rating, :indus_store_rating, 
                :play_store_version, :indus_store_version, :play_store_downloads, :indus_store_downloads, 
                :logo_url, :banner_url, :description, :requirements, :apk_download_link, :is_apk_active, 
                :play_store_link, :is_play_store_active, :app_store_link, :is_app_store_active, 
                :indus_store_link, :is_indus_store_active, :amazon_store_link, :is_amazon_store_active, 
                'draft', 0, :publish_date, :app_update_date, :downloads, :rating
            )
        ");

        $insertStmt->execute([
            ':category_id' => $app['category_id'],
            ':name' => $newName,
            ':slug' => $newSlug,
            ':developer' => $app['developer'],
            ':version' => $app['version'],
            ':play_store_rating' => $app['play_store_rating'],
            ':indus_store_rating' => $app['indus_store_rating'],
            ':play_store_version' => $app['play_store_version'],
            ':indus_store_version' => $app['indus_store_version'],
            ':play_store_downloads' => $app['play_store_downloads'],
            ':indus_store_downloads' => $app['indus_store_downloads'],
            ':logo_url' => $app['logo_url'],
            ':banner_url' => $app['banner_url'] ?? null,
            ':description' => $app['description'],
            ':requirements' => $app['requirements'],
            ':apk_download_link' => $app['apk_download_link'],
            ':is_apk_active' => $app['is_apk_active'],
            ':play_store_link' => $app['play_store_link'],
            ':is_play_store_active' => $app['is_play_store_active'],
            ':app_store_link' => $app['app_store_link'],
            ':is_app_store_active' => $app['is_app_store_active'],
            ':indus_store_link' => $app['indus_store_link'],
            ':is_indus_store_active' => $app['is_indus_store_active'],
            ':amazon_store_link' => $app['amazon_store_link'],
            ':is_amazon_store_active' => $app['is_amazon_store_active'],
            ':publish_date' => $app['publish_date'],
            ':app_update_date' => $app['app_update_date'],
            ':downloads' => $app['downloads'],
            ':rating' => $app['rating']
        ]);

        $newId = $pdo->lastInsertId();
        
        // Redirect to edit page of the new app
        header("Location: " . BASE_URL . "admin/apps/edit.php?id=" . $newId . "&duplicated=1");
        exit;
    }
} catch (Exception $e) {
    // If something goes wrong, just redirect back
}

header("Location: " . BASE_URL . "admin/apps/index.php");
exit;
