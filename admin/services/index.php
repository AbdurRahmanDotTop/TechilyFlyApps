<?php
// admin/services/index.php
require_once __DIR__ . '/../includes/header.php';

$stmt = $pdo->query("SELECT * FROM services ORDER BY id DESC");
$services = $stmt->fetchAll();
?>

<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
    <h1 style="margin: 0;">Manage Services</h1>
    <a href="<?= BASE_URL ?>admin/services/create.php" class="btn btn-primary"><i class='bx bx-plus'></i> Add New Service</a>
</div>

<div class="app-card" style="padding: 0; overflow: hidden;">
    <table style="width: 100%; border-collapse: collapse;">
        <thead>
            <tr style="background: rgba(255, 255, 255, 0.05); border-bottom: 1px solid var(--glass-border); text-align: left;">
                <th style="padding: 15px 20px; font-weight: 600;">ID</th>
                <th style="padding: 15px 20px; font-weight: 600;">Icon</th>
                <th style="padding: 15px 20px; font-weight: 600;">Name</th>
                <th style="padding: 15px 20px; font-weight: 600;">Slug</th>
                <th style="padding: 15px 20px; font-weight: 600;">Status</th>
                <th style="padding: 15px 20px; font-weight: 600; text-align: right;">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (count($services) > 0): ?>
                <?php foreach ($services as $srv): ?>
                    <tr style="border-bottom: 1px solid var(--glass-border);">
                        <td style="padding: 15px 20px; color: var(--text-secondary);">#<?= $srv['id'] ?></td>
                        <td style="padding: 15px 20px; font-size: 1.5rem;"><i class='bx <?= htmlspecialchars($srv['icon']) ?>'></i></td>
                        <td style="padding: 15px 20px; font-weight: 500; color: var(--text-primary);"><?= htmlspecialchars($srv['name']) ?></td>
                        <td style="padding: 15px 20px; color: var(--text-secondary);"><?= htmlspecialchars($srv['slug']) ?></td>
                        <td style="padding: 15px 20px;">
                            <?php if ($srv['status'] === 'active'): ?>
                                <span style="background: rgba(16, 185, 129, 0.1); color: var(--success); padding: 5px 10px; border-radius: 20px; font-size: 0.8rem; font-weight: 600;">Active</span>
                            <?php else: ?>
                                <span style="background: rgba(107, 114, 128, 0.1); color: var(--text-secondary); padding: 5px 10px; border-radius: 20px; font-size: 0.8rem; font-weight: 600;">Inactive</span>
                            <?php endif; ?>
                        </td>
                        <td style="padding: 15px 20px; text-align: right;">
                            <div style="display: flex; justify-content: flex-end; gap: 10px;">
                                <a href="<?= BASE_URL ?>admin/services/edit.php?id=<?= $srv['id'] ?>" class="btn btn-outline" style="padding: 5px 10px; font-size: 0.9rem;"><i class='bx bx-edit'></i> Edit</a>
                                <a href="<?= BASE_URL ?>admin/services/delete.php?id=<?= $srv['id'] ?>" class="btn btn-outline" style="padding: 5px 10px; font-size: 0.9rem; color: var(--danger); border-color: var(--danger);" onclick="return confirm('Are you sure you want to delete this service?');"><i class='bx bx-trash'></i></a>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6" style="padding: 30px; text-align: center; color: var(--text-secondary);">No services found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
