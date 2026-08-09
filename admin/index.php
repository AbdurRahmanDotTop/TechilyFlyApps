<?php
// admin/index.php
require_once __DIR__ . '/includes/header.php';

// Quick stats queries
$total_apps = $pdo->query("SELECT COUNT(*) FROM apps")->fetchColumn();
$total_downloads = $pdo->query("SELECT SUM(downloads) FROM apps")->fetchColumn();
$published_apps = $pdo->query("SELECT COUNT(*) FROM apps WHERE status = 'published'")->fetchColumn();

// Fetch admin username dynamically
$stmt = $pdo->prepare("SELECT username FROM admins WHERE id = :id LIMIT 1");
$stmt->execute([':id' => $_SESSION['admin_id']]);
$admin_user = $stmt->fetchColumn() ?: 'Admin';
?>

<h1 style="margin-bottom: 30px; font-size: 2.5rem;" class="text-gradient">Welcome back, <?= htmlspecialchars($admin_user) ?>!</h1>

<div class="grid" style="grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px;">
    <div class="app-card" style="display: flex; align-items: center; gap: 20px;">
        <i class='bx bx-mobile-alt' style="font-size: 3rem; color: var(--accent-primary);"></i>
        <div>
            <h3 style="font-size: 2rem; margin: 0;"><?= number_format($total_apps) ?></h3>
            <p style="color: var(--text-secondary); margin: 0;">Total Apps</p>
        </div>
    </div>
    
    <div class="app-card" style="display: flex; align-items: center; gap: 20px;">
        <i class='bx bx-download' style="font-size: 3rem; color: var(--success);"></i>
        <div>
            <h3 style="font-size: 2rem; margin: 0;"><?= number_format($total_downloads) ?></h3>
            <p style="color: var(--text-secondary); margin: 0;">Total Downloads</p>
        </div>
    </div>
    
    <div class="app-card" style="display: flex; align-items: center; gap: 20px;">
        <i class='bx bx-check-circle' style="font-size: 3rem; color: var(--warning);"></i>
        <div>
            <h3 style="font-size: 2rem; margin: 0;"><?= number_format($published_apps) ?></h3>
            <p style="color: var(--text-secondary); margin: 0;">Published Apps</p>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
