<?php
$host = 'localhost';
$db   = 'healtmatrix';
$user = 'codetrox';
$pass = 'Codetrox@360';
$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
