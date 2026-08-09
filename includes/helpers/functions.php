<?php
// includes/helpers/functions.php

function sanitize_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
    return $data;
}

function get_website_settings($pdo) {
    $stmt = $pdo->query("SELECT * FROM website_settings LIMIT 1");
    return $stmt->fetch();
}

function get_featured_apps($pdo, $limit = 6) {
    $stmt = $pdo->prepare("SELECT a.*, c.name as category_name FROM apps a LEFT JOIN app_categories c ON a.category_id = c.id WHERE a.is_featured = TRUE AND a.status = 'published' ORDER BY a.created_at DESC LIMIT :limit");
    $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll();
}

function get_all_services($pdo) {
    $stmt = $pdo->query("SELECT * FROM services WHERE status = 'active'");
    return $stmt->fetchAll();
}

function get_all_apps($pdo) {
    $stmt = $pdo->query("SELECT a.*, c.name as category_name FROM apps a LEFT JOIN app_categories c ON a.category_id = c.id WHERE a.status = 'published' ORDER BY a.created_at DESC");
    return $stmt->fetchAll();
}

function get_app_by_slug($pdo, $slug) {
    $stmt = $pdo->prepare("SELECT a.*, c.name as category_name FROM apps a LEFT JOIN app_categories c ON a.category_id = c.id WHERE a.slug = :slug AND a.status = 'published' LIMIT 1");
    $stmt->bindValue(':slug', $slug, PDO::PARAM_STR);
    $stmt->execute();
    return $stmt->fetch();
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
    return $stmt->fetchAll();
}
