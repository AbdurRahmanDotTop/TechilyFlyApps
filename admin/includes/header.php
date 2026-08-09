<?php
// admin/includes/header.php
require_once __DIR__ . '/auth.php';
require_login();
require_once __DIR__ . '/../../includes/config/database.php';
$pdo = getDBConnection();

// Get unread messages count
try {
    $unread_messages = $pdo->query("SELECT COUNT(*) FROM contact_messages WHERE status = 'unread'")->fetchColumn();
} catch (PDOException $e) {
    $unread_messages = 0;
}
?>
<!DOCTYPE html>
<html lang="en" data-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Techily Fly Apps</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/index.css">
    <style>
        .admin-layout { display: flex; min-height: 100vh; position: relative; }
        .sidebar { width: 250px; background: var(--bg-secondary); border-right: 1px solid var(--glass-border); padding: 20px; transition: transform var(--transition-normal); z-index: 1000; }
        .main-content { flex: 1; padding: 40px; width: 100%; overflow-x: hidden; }
        .sidebar-logo { font-size: 1.5rem; font-weight: 800; background: var(--accent-gradient); -webkit-background-clip: text; -webkit-text-fill-color: transparent; margin-bottom: 30px; display: block; }
        .sidebar-menu { list-style: none; padding: 0; }
        .sidebar-menu li { margin-bottom: 10px; }
        .sidebar-menu a { display: flex; align-items: center; gap: 10px; padding: 12px 15px; border-radius: 8px; color: var(--text-secondary); font-weight: 500; transition: all var(--transition-fast); }
        .sidebar-menu a:hover, .sidebar-menu a.active { background: rgba(59, 130, 246, 0.1); color: var(--accent-primary); }
        .mobile-header { display: none; padding: 15px 20px; background: var(--bg-secondary); border-bottom: 1px solid var(--glass-border); align-items: center; justify-content: space-between; }
        .mobile-toggle { background: none; border: none; color: var(--text-primary); font-size: 1.5rem; cursor: pointer; display: flex; align-items: center; justify-content: center; }
        
        .badge-unread { background: var(--danger); color: white; padding: 2px 6px; border-radius: 10px; font-size: 0.75rem; margin-left: auto; }

        @media (max-width: 768px) {
            .sidebar { position: fixed; top: 0; left: 0; height: 100vh; transform: translateX(-100%); }
            .sidebar.active { transform: translateX(0); }
            .main-content { padding: 20px; }
            .mobile-header { display: flex; }
            .admin-layout { flex-direction: column; }
            .overlay { display: none; position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,0.5); z-index: 999; }
            .overlay.active { display: block; }
        }
    </style>
</head>
<body>

<div class="admin-layout">
    <div class="overlay" id="sidebar-overlay"></div>
    <aside class="sidebar" id="admin-sidebar">
        <a href="<?= BASE_URL ?>admin/index.php" class="sidebar-logo">Techily Admin</a>
        <ul class="sidebar-menu">
            <li><a href="<?= BASE_URL ?>admin/index.php"><i class='bx bx-grid-alt'></i> Dashboard</a></li>
            <li><a href="<?= BASE_URL ?>admin/apps/index.php"><i class='bx bx-mobile-alt'></i> Manage Apps</a></li>
            <li><a href="<?= BASE_URL ?>admin/categories/index.php"><i class='bx bx-category'></i> Manage Categories</a></li>
            <li><a href="<?= BASE_URL ?>admin/services/index.php"><i class='bx bx-briefcase'></i> Manage Services</a></li>
            <li>
                <a href="<?= BASE_URL ?>admin/messages/index.php">
                    <i class='bx bx-envelope'></i> Manage Messages 
                    <?php if ($unread_messages > 0): ?>
                        <span class="badge-unread"><?= $unread_messages ?></span>
                    <?php endif; ?>
                </a>
            </li>
            <li><a href="<?= BASE_URL ?>admin/settings.php"><i class='bx bx-cog'></i> Website Settings</a></li>
            <li><a href="<?= BASE_URL ?>admin/logout.php"><i class='bx bx-log-out'></i> Logout</a></li>
        </ul>
    </aside>
    <div style="flex: 1; display: flex; flex-direction: column; width: 100%;">
        <div class="mobile-header">
            <span class="sidebar-logo" style="margin: 0; font-size: 1.2rem;">Techily Admin</span>
            <button class="mobile-toggle" id="mobile-menu-toggle"><i class='bx bx-menu'></i></button>
        </div>
        <main class="main-content">
