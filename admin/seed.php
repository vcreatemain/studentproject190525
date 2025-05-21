<?php
require_once 'includes/db.php';

$username = 'admin';
$password = 'Canara';
$hash = password_hash($password, PASSWORD_DEFAULT);

$stmt = $conn->prepare("INSERT INTO admin_users (username, password_hash) VALUES (?, ?)");
$stmt->bind_param("ss", $username, $hash);
$stmt->execute();

echo "Admin user created successfully";
?>