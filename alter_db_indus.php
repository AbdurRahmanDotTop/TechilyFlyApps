<?php
require_once __DIR__ . '/includes/config/database.php';

try {
    $pdo = getDBConnection();
    
    // Add columns
    $pdo->exec("ALTER TABLE apps ADD COLUMN indus_store_link VARCHAR(255) NULL DEFAULT NULL AFTER app_store_link");
    
    echo "Successfully updated database schema with Indus Appstore link.\n";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
