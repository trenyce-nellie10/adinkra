<?php
// core.php
error_reporting(E_ALL);
ini_set('display_errors', '1');

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/**
 * Auth helpers using schema-compliant field names
 */
function is_logged_in(): bool {
    return isset($_SESSION['user_id']);
}

function current_user_name(): string {
    return $_SESSION['full_name'] ?? '';
}

function current_user_role(): int {
    return (int)($_SESSION['user_role'] ?? 0);
}

function require_login() {
    if (!is_logged_in()) {
        header("Location: login.php");
        exit;
    }
}
