<?php
// admin/messages/delete.php
require_once __DIR__ . '/../includes/auth.php';
require_login();
require_once __DIR__ . '/../../includes/config/database.php';
$pdo = getDBConnection();

$id = $_GET['id'] ?? null;
if ($id) {
    $stmt = $pdo->prepare("DELETE FROM contact_messages WHERE id = ?");
    $stmt->execute([$id]);
}

header("Location: " . BASE_URL . "admin/messages/index.php?msg=deleted");
exit;
