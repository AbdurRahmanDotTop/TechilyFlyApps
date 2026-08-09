<?php
// includes/helpers/functions.php

function sanitize_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
    return $data;
}

function calculate_dynamic_app_stats($app) {
    // Calculate Rating (Average of Play Store and Indus Store if both exist, else the one that exists)
    $play_rating = (float)($app['play_store_rating'] ?? 0);
    $indus_rating = (float)($app['indus_store_rating'] ?? 0);
    if ($play_rating > 0 && $indus_rating > 0) {
        $app['rating'] = ($play_rating + $indus_rating) / 2;
    } elseif ($play_rating > 0) {
        $app['rating'] = $play_rating;
    } elseif ($indus_rating > 0) {
        $app['rating'] = $indus_rating;
    } else {
        $app['rating'] = (float)($app['rating'] ?? 0); // fallback
    }

    // Calculate Version (Highest of Play Store and Indus Store)
    $play_version = trim($app['play_store_version'] ?? '');
    $indus_version = trim($app['indus_store_version'] ?? '');
    
    // Remove 'v' prefix if exists for comparison
    $clean_play = ltrim($play_version, 'vV');
    $clean_indus = ltrim($indus_version, 'vV');
    
    if (!empty($clean_play) && !empty($clean_indus)) {
        if (version_compare($clean_play, $clean_indus, '>=')) {
            $app['version'] = $play_version;
        } else {
            $app['version'] = $indus_version;
        }
    } elseif (!empty($play_version)) {
        $app['version'] = $play_version;
    } elseif (!empty($indus_version)) {
        $app['version'] = $indus_version;
    }

    // Calculate Downloads (Average of both)
    $play_dl = (int)($app['play_store_downloads'] ?? 0);
    $indus_dl = (int)($app['indus_store_downloads'] ?? 0);
    if ($play_dl > 0 && $indus_dl > 0) {
        $app['downloads'] = (int)(($play_dl + $indus_dl) / 2);
    } elseif ($play_dl > 0) {
        $app['downloads'] = $play_dl;
    } elseif ($indus_dl > 0) {
        $app['downloads'] = $indus_dl;
    }

    return $app;
}

function get_website_settings($pdo) {
    $stmt = $pdo->query("SELECT * FROM website_settings LIMIT 1");
    return $stmt->fetch();
}

function get_featured_apps($pdo, $limit = 6) {
    $stmt = $pdo->prepare("SELECT a.*, c.name as category_name FROM apps a LEFT JOIN app_categories c ON a.category_id = c.id WHERE a.is_featured = TRUE AND a.status = 'published' ORDER BY a.created_at DESC LIMIT :limit");
    $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
    $stmt->execute();
    $apps = $stmt->fetchAll();
    return array_map('calculate_dynamic_app_stats', $apps);
}

function get_all_services($pdo) {
    $stmt = $pdo->query("SELECT * FROM services WHERE status = 'active'");
    return $stmt->fetchAll();
}

function get_all_apps($pdo) {
    $stmt = $pdo->query("SELECT a.*, c.name as category_name FROM apps a LEFT JOIN app_categories c ON a.category_id = c.id WHERE a.status = 'published' ORDER BY a.created_at DESC");
    $apps = $stmt->fetchAll();
    return array_map('calculate_dynamic_app_stats', $apps);
}

function get_app_by_slug($pdo, $slug) {
    $stmt = $pdo->prepare("SELECT a.*, c.name as category_name FROM apps a LEFT JOIN app_categories c ON a.category_id = c.id WHERE a.slug = :slug AND a.status = 'published' LIMIT 1");
    $stmt->bindValue(':slug', $slug, PDO::PARAM_STR);
    $stmt->execute();
    $app = $stmt->fetch();
    return $app ? calculate_dynamic_app_stats($app) : false;
}

function get_active_categories($pdo) {
    $stmt = $pdo->query("SELECT * FROM app_categories WHERE status = 'active' ORDER BY name ASC");
    return $stmt->fetchAll();
}

function get_filtered_apps($pdo, $filters = []) {
    $query = "SELECT a.*, c.name as category_name, c.slug as category_slug FROM apps a LEFT JOIN app_categories c ON a.category_id = c.id WHERE a.status = 'published'";
    $params = [];
    
    if (!empty($filters['search'])) {
        $query .= " AND a.name LIKE :search";
        $params[':search'] = '%' . $filters['search'] . '%';
    }
    
    if (!empty($filters['category'])) {
        $query .= " AND c.slug = :category";
        $params[':category'] = $filters['category'];
    }
    
    // Sort handling might be tricky if we sort by rating or downloads since they are dynamic now.
    // We will leave the DB sort as is (using fallback DB fields), since fully dynamic sorting requires fetching all and sorting in PHP.
    
    if (!empty($filters['sort'])) {
        if ($filters['sort'] == 'latest') {
            $query .= " ORDER BY a.created_at DESC";
        } elseif ($filters['sort'] == 'popular') {
            $query .= " ORDER BY a.downloads DESC";
        } elseif ($filters['sort'] == 'rating') {
            $query .= " ORDER BY a.rating DESC";
        } else {
            $query .= " ORDER BY a.created_at DESC";
        }
    } else {
        $query .= " ORDER BY a.created_at DESC";
    }
    
    $stmt = $pdo->prepare($query);
    $stmt->execute($params);
    $apps = $stmt->fetchAll();
    
    // Apply dynamic stats
    $apps = array_map('calculate_dynamic_app_stats', $apps);
    
    // Re-sort in PHP if needed to ensure accurate sorting by dynamic values
    if (!empty($filters['sort'])) {
        if ($filters['sort'] == 'popular') {
            usort($apps, function($a, $b) { return $b['downloads'] <=> $a['downloads']; });
        } elseif ($filters['sort'] == 'rating') {
            usort($apps, function($a, $b) { return $b['rating'] <=> $a['rating']; });
        }
    }
    
    return $apps;
}
