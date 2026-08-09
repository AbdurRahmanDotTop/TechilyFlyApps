<?php
// admin/apps/index.php
require_once __DIR__ . '/../includes/header.php';

$apps = $pdo->query("SELECT a.*, c.name as category_name FROM apps a LEFT JOIN app_categories c ON a.category_id = c.id ORDER BY a.created_at DESC")->fetchAll();
?>

<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
    <h1 style="margin: 0;">Manage Apps</h1>
    <a href="<?= BASE_URL ?>admin/apps/create.php" class="btn btn-primary"><i class='bx bx-plus'></i> Add New App</a>
</div>

<div class="app-card" style="padding: 0; overflow-x: auto;">
    <table style="width: 100%; border-collapse: collapse; text-align: left;">
        <thead>
            <tr style="border-bottom: 1px solid var(--glass-border); background: rgba(0,0,0,0.2);">
                <th style="padding: 15px;">Logo</th>
                <th style="padding: 15px;">Name</th>
                <th style="padding: 15px;">Category</th>
                <th style="padding: 15px;">Status</th>
                <th style="padding: 15px;">Downloads</th>
                <th style="padding: 15px; text-align: right;">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($apps as $app): ?>
                <tr style="border-bottom: 1px solid var(--glass-border);">
                    <td style="padding: 15px;"><img src="<?= htmlspecialchars($app['logo_url']) ?>" alt="logo" style="width: 40px; height: 40px; border-radius: 8px; object-fit: cover;"></td>
                    <td style="padding: 15px; font-weight: 500;"><?= htmlspecialchars($app['name']) ?></td>
                    <td style="padding: 15px; color: var(--text-secondary);"><?= htmlspecialchars($app['category_name']) ?></td>
                    <td style="padding: 15px;">
                        <span class="badge" style="background: <?= $app['status'] == 'published' ? 'rgba(16, 185, 129, 0.2)' : 'rgba(245, 158, 11, 0.2)' ?>; color: <?= $app['status'] == 'published' ? 'var(--success)' : 'var(--warning)' ?>;">
                            <?= ucfirst(htmlspecialchars($app['status'])) ?>
                        </span>
                    </td>
                    <td style="padding: 15px; color: var(--text-secondary);"><?= number_format($app['downloads']) ?></td>
                    <td style="padding: 15px; text-align: right;">
                        <a href="<?= BASE_URL ?>admin/apps/edit.php?id=<?= $app['id'] ?>" class="btn btn-outline" style="padding: 5px 10px; font-size: 0.9rem;"><i class='bx bx-edit'></i> Edit</a>
                        <a href="<?= BASE_URL ?>admin/apps/delete.php?id=<?= $app['id'] ?>" class="btn btn-outline" style="padding: 5px 10px; font-size: 0.9rem; color: var(--danger); border-color: var(--danger);" onclick="return confirm('Are you sure you want to delete this app?');"><i class='bx bx-trash'></i></a>
                    </td>
                </tr>
            <?php endforeach; ?>
            <?php if (count($apps) === 0): ?>
                <tr>
                    <td colspan="6" style="padding: 30px; text-align: center; color: var(--text-secondary);">No apps found. Create one to get started!</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
