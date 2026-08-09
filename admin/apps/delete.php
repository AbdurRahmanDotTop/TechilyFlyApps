<?php
// admin/apps/delete.php
require_once __DIR__ . '/../includes/auth.php';
require_login();
require_once __DIR__ . '/../../includes/config/database.php';

$pdo = getDBConnection();
$id = $_GET['id'] ?? null;

if ($id) {
    try {
        $stmt = $pdo->prepare("DELETE FROM apps WHERE id = :id");
        $stmt->execute([':id' => $id]);
    } catch (PDOException $e) {
        // Handle error if needed
    }
}

header('Location: ' . BASE_URL . 'admin/apps/index.php');
exit;
