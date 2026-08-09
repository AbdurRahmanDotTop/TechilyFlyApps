<?php
// templates/header.php
require_once __DIR__ . '/../includes/config/database.php';
require_once __DIR__ . '/../includes/helpers/functions.php';

$pdo = getDBConnection();
$settings = get_website_settings($pdo);

// Determine active page for navigation
$current_page = basename($_SERVER['PHP_SELF'], ".php");
?>
<!DOCTYPE html>
<html lang="en" data-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($settings['site_name'] ?? 'Techily Fly Apps') ?></title>
    <!-- Boxicons for Icons -->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <!-- Main CSS -->
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/index.css">
</head>
<body>

<header class="header">
    <div class="container">
        <a href="<?= BASE_URL ?>index.php" class="logo">
            <?= htmlspecialchars($settings['site_name'] ?? 'Techily Fly Apps') ?>
        </a>
        
        <nav class="nav-links">
            <a href="<?= BASE_URL ?>index.php" class="<?= $current_page == 'index' ? 'active' : '' ?>">Home</a>
            <a href="<?= BASE_URL ?>modules/apps/index.php" class="<?= $current_page == 'apps' || $current_page == 'details' ? 'active' : '' ?>">Apps</a>
            <a href="<?= BASE_URL ?>services.php" class="<?= $current_page == 'services' ? 'active' : '' ?>">Services</a>
            <a href="<?= BASE_URL ?>page.php/portfolio" class="<?= $current_page == 'page' && ($_GET['slug'] ?? '') == 'portfolio' ? 'active' : '' ?>">Portfolio</a>
            <a href="<?= BASE_URL ?>contact.php" class="<?= $current_page == 'contact' ? 'active' : '' ?>">Contact</a>
        </nav>

        <div class="header-actions">
            <button id="theme-toggle" class="theme-toggle">
                <i class='bx bx-sun'></i>
            </button>
            <a href="<?= BASE_URL ?>contact.php" class="btn btn-primary">Request Quote</a>
            <button id="mobile-menu-btn" class="mobile-menu-btn">
                <i class='bx bx-menu'></i>
            </button>
        </div>
    </div>
</header>
