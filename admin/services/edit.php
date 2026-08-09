<?php
// admin/services/edit.php
require_once __DIR__ . '/../includes/header.php';

$id = $_GET['id'] ?? null;
if (!$id) {
    header('Location: ' . BASE_URL . 'admin/services/index.php');
    exit;
}

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $slug = trim($_POST['slug'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $icon = trim($_POST['icon'] ?? 'bx-briefcase');
    $status = $_POST['status'] ?? 'active';

    if (empty($name) || empty($slug)) {
        $error = 'Name and Slug are required.';
    } else {
        try {
            $stmt = $pdo->prepare("UPDATE services SET name = :name, slug = :slug, description = :description, icon = :icon, status = :status WHERE id = :id");
            $stmt->execute([
                ':name' => $name,
                ':slug' => $slug,
                ':description' => $description,
                ':icon' => $icon,
                ':status' => $status,
                ':id' => $id
            ]);
            $success = 'Service updated successfully!';
        } catch (PDOException $e) {
            $error = 'Database error: ' . $e->getMessage();
        }
    }
}

$stmt = $pdo->prepare("SELECT * FROM services WHERE id = :id LIMIT 1");
$stmt->execute([':id' => $id]);
$service = $stmt->fetch();

if (!$service) {
    echo "<p>Service not found.</p>";
    require_once __DIR__ . '/../includes/footer.php';
    exit;
}
?>

<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
    <h1 style="margin: 0;">Edit Service</h1>
    <a href="<?= BASE_URL ?>admin/services/index.php" class="btn btn-outline"><i class='bx bx-arrow-back'></i> Back to Services</a>
</div>

<?php if ($error): ?>
    <div style="background: rgba(239, 68, 68, 0.1); color: var(--danger); padding: 15px; border-radius: 8px; margin-bottom: 20px;">
        <?= htmlspecialchars($error) ?>
    </div>
<?php endif; ?>

<?php if ($success): ?>
    <div style="background: rgba(16, 185, 129, 0.1); color: var(--success); padding: 15px; border-radius: 8px; margin-bottom: 20px;">
        <?= htmlspecialchars($success) ?>
    </div>
<?php endif; ?>

<form method="POST" action="" class="app-card" style="max-width: 800px;">
    <div class="grid" style="grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px;">
        <div style="margin-bottom: 15px;">
            <label style="display: block; margin-bottom: 8px; color: var(--text-secondary);">Service Name *</label>
            <input type="text" name="name" value="<?= htmlspecialchars($service['name']) ?>" required style="width: 100%; padding: 12px; border-radius: 8px; border: 1px solid var(--glass-border); background: var(--bg-primary); color: var(--text-primary); outline: none;">
        </div>
        <div style="margin-bottom: 15px;">
            <label style="display: block; margin-bottom: 8px; color: var(--text-secondary);">Slug (URL) *</label>
            <input type="text" name="slug" value="<?= htmlspecialchars($service['slug']) ?>" required style="width: 100%; padding: 12px; border-radius: 8px; border: 1px solid var(--glass-border); background: var(--bg-primary); color: var(--text-primary); outline: none;">
        </div>
    </div>
    
    <div style="margin-bottom: 15px;">
        <label style="display: block; margin-bottom: 8px; color: var(--text-secondary);">Description</label>
        <textarea name="description" rows="3" style="width: 100%; padding: 12px; border-radius: 8px; border: 1px solid var(--glass-border); background: var(--bg-primary); color: var(--text-primary); outline: none;"><?= htmlspecialchars($service['description']) ?></textarea>
    </div>
    
    <div class="grid" style="grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px;">
        <div style="margin-bottom: 15px;">
            <label style="display: block; margin-bottom: 8px; color: var(--text-secondary);">Icon (Boxicons class)</label>
            <input type="text" name="icon" value="<?= htmlspecialchars($service['icon']) ?>" placeholder="bx-briefcase" style="width: 100%; padding: 12px; border-radius: 8px; border: 1px solid var(--glass-border); background: var(--bg-primary); color: var(--text-primary); outline: none;">
        </div>
        <div style="margin-bottom: 15px;">
            <label style="display: block; margin-bottom: 8px; color: var(--text-secondary);">Status</label>
            <select name="status" style="width: 100%; padding: 12px; border-radius: 8px; border: 1px solid var(--glass-border); background: var(--bg-primary); color: var(--text-primary); outline: none;">
                <option value="active" <?= $service['status'] === 'active' ? 'selected' : '' ?>>Active</option>
                <option value="inactive" <?= $service['status'] === 'inactive' ? 'selected' : '' ?>>Inactive</option>
            </select>
        </div>
    </div>

    <div style="margin-top: 30px;">
        <button type="submit" class="btn btn-primary" style="padding: 15px 30px; font-size: 1.1rem;">Update Service</button>
    </div>
</form>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
