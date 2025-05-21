<?php
session_start();
require 'db.php';

$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';

if ($email && $password) {
    $stmt = $conn->prepare("SELECT id, password FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    
    $stmt->store_result();
    if ($stmt->num_rows === 1) {
        $stmt->bind_result($id, $hashedPassword);
        $stmt->fetch();
        
        if (password_verify($password, $hashedPassword)) {
            $_SESSION['user_id'] = $id;
            setcookie("user_id", $id, time() + (7 * 24 * 60 * 60), "/");
            header("Location: index.php");
        } else {
            echo "Invalid credentials.";
        }
    } else {
        echo "No user found.";
    }
    $stmt->close();
} else {
    echo "Please fill in all fields.";
}
?>
