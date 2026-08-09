<?php
require_once __DIR__ . '/includes/config/database.php';

try {
    $pdo = getDBConnection();
    
    // Add columns
    $pdo->exec("ALTER TABLE apps ADD COLUMN publish_date DATE NULL DEFAULT NULL AFTER status");
    $pdo->exec("ALTER TABLE apps ADD COLUMN app_update_date DATE NULL DEFAULT NULL AFTER publish_date");
    $pdo->exec("ALTER TABLE apps ADD COLUMN updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP AFTER created_at");
    
    echo "Successfully updated database schema.\n";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
