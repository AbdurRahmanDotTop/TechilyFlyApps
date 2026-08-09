<?php
// admin/includes/auth.php
require_once __DIR__ . '/../../includes/config/database.php';
session_start();

function is_logged_in() {
    return isset($_SESSION['admin_id']);
}

function require_login() {
    if (!is_logged_in()) {
        header('Location: ' . BASE_URL . 'admin/login.php');
        exit;
    }
}
