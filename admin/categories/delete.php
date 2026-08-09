<?php
// admin/categories/delete.php
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../../includes/config/database.php';
require_login();

$pdo = getDBConnection();
$id = $_GET['id'] ?? null;

if ($id) {
    try {
        $stmt = $pdo->prepare("DELETE FROM app_categories WHERE id = :id");
        $stmt->execute([':id' => $id]);
    } catch (PDOException $e) {
        // Handle error if needed
    }
}

header('Location: ' . BASE_URL . 'admin/categories/index.php');
exit;
