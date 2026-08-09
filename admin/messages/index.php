<?php
// admin/messages/index.php
require_once __DIR__ . '/../includes/header.php';

$stmt = $pdo->query("SELECT * FROM contact_messages ORDER BY created_at DESC");
$messages = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
    <h2>Manage Messages</h2>
</div>

<?php if (isset($_GET['msg']) && $_GET['msg'] === 'deleted'): ?>
    <div style="background: rgba(16, 185, 129, 0.1); color: var(--success); padding: 15px; border-radius: 8px; border: 1px solid var(--success); margin-bottom: 20px;">
        <i class='bx bx-check-circle' style="margin-right: 5px;"></i> Message deleted successfully.
    </div>
<?php endif; ?>

<div class="app-card" style="padding: 20px; overflow-x: auto;">
    <?php if (count($messages) > 0): ?>
        <table style="width: 100%; border-collapse: collapse; text-align: left;">
            <thead>
                <tr style="border-bottom: 1px solid var(--glass-border);">
                    <th style="padding: 15px; color: var(--text-secondary);">Name</th>
                    <th style="padding: 15px; color: var(--text-secondary);">Subject</th>
                    <th style="padding: 15px; color: var(--text-secondary);">Date</th>
                    <th style="padding: 15px; color: var(--text-secondary);">Status</th>
                    <th style="padding: 15px; color: var(--text-secondary);">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($messages as $msg): ?>
                    <tr style="border-bottom: 1px solid rgba(255,255,255,0.05); <?= $msg['status'] === 'unread' ? 'background: rgba(255,255,255,0.02); font-weight: bold;' : '' ?>">
                        <td style="padding: 15px;">
                            <?= htmlspecialchars($msg['name']) ?><br>
                            <small style="color: var(--text-secondary); font-weight: normal;"><?= htmlspecialchars($msg['email']) ?></small>
                        </td>
                        <td style="padding: 15px;"><?= htmlspecialchars($msg['subject']) ?></td>
                        <td style="padding: 15px;"><?= date('M j, Y g:i A', strtotime($msg['created_at'])) ?></td>
                        <td style="padding: 15px;">
                            <?php if ($msg['status'] === 'unread'): ?>
                                <span style="background: var(--warning); color: #fff; padding: 3px 8px; border-radius: 12px; font-size: 0.8rem;">Unread</span>
                            <?php else: ?>
                                <span style="background: var(--success); color: #fff; padding: 3px 8px; border-radius: 12px; font-size: 0.8rem;">Read</span>
                            <?php endif; ?>
                        </td>
                        <td style="padding: 15px; display: flex; gap: 10px;">
                            <a href="<?= BASE_URL ?>admin/messages/view.php?id=<?= $msg['id'] ?>" class="btn btn-outline" style="padding: 5px 10px; font-size: 0.9rem;">View</a>
                            <a href="<?= BASE_URL ?>admin/messages/delete.php?id=<?= $msg['id'] ?>" class="btn" style="padding: 5px 10px; font-size: 0.9rem; background: var(--danger); color: white; border: none; cursor: pointer;" onclick="return confirm('Are you sure you want to delete this message?');">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p style="text-align: center; color: var(--text-secondary); margin: 20px 0;">No messages found.</p>
    <?php endif; ?>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
