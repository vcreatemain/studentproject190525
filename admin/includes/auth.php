<?php
session_start();

// Redirect to login if not authenticated
function requireAuth() {
    if (!isset($_SESSION['admin_logged_in'])) {
        header('Location: index.php');
        exit();
    }
}

// Password verification helper
function verifyPassword($password, $hash) {
    return password_verify($password, $hash);
}
?>