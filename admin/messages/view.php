<?php
// admin/messages/view.php
require_once __DIR__ . '/../includes/header.php';

$id = $_GET['id'] ?? null;
if (!$id) {
    echo "<script>window.location.href = '" . BASE_URL . "admin/messages/index.php';</script>";
    exit;
}

// Mark as read
$pdo->prepare("UPDATE contact_messages SET status = 'read' WHERE id = ?")->execute([$id]);

// Fetch message
$stmt = $pdo->prepare("SELECT * FROM contact_messages WHERE id = ?");
$stmt->execute([$id]);
$message = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$message) {
    echo "<script>window.location.href = '" . BASE_URL . "admin/messages/index.php';</script>";
    exit;
}
?>

<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
    <h2>View Message</h2>
    <a href="<?= BASE_URL ?>admin/messages/index.php" class="btn btn-outline">Back to Messages</a>
</div>

<div class="app-card" style="padding: 30px; max-width: 800px;">
    <div style="margin-bottom: 20px; border-bottom: 1px solid var(--glass-border); padding-bottom: 20px;">
        <h3 style="margin: 0 0 10px 0;"><?= htmlspecialchars($message['subject']) ?></h3>
        <p style="color: var(--text-secondary); margin: 0; display: flex; justify-content: space-between; flex-wrap: wrap; gap: 10px;">
            <span><strong>From:</strong> <?= htmlspecialchars($message['name']) ?> &lt;<?= htmlspecialchars($message['email']) ?>&gt;</span>
            <span><strong>Date:</strong> <?= date('F j, Y, g:i a', strtotime($message['created_at'])) ?></span>
        </p>
    </div>
    
    <div style="white-space: pre-wrap; line-height: 1.8; font-size: 1.05rem;">
<?= htmlspecialchars($message['message']) ?>
    </div>
    
    <div style="margin-top: 40px; display: flex; gap: 15px;">
        <a href="mailto:<?= htmlspecialchars($message['email']) ?>" class="btn btn-primary" style="padding: 10px 20px;"><i class='bx bx-reply'></i> Reply via Email</a>
        <a href="<?= BASE_URL ?>admin/messages/delete.php?id=<?= $message['id'] ?>" class="btn btn-outline" style="padding: 10px 20px; color: var(--danger); border-color: var(--danger);" onclick="return confirm('Are you sure you want to delete this message?');"><i class='bx bx-trash'></i> Delete Message</a>
    </div>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
