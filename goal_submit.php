<?php
session_start();
require_once 'admin/includes/db.php';

header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'User not logged in']);
    exit;
}

$user_id = $_SESSION['user_id'];
$data = json_decode(file_get_contents('php://input'), true);

if (!$data || !isset($data['title']) || !isset($data['description']) || !isset($data['goal_type'])) {
    echo json_encode(['success' => false, 'message' => 'Invalid data']);
    exit;
}

$title = $data['title'];
$description = $data['description'];
$goal_type = $data['goal_type'];
$category = $data['category'] ?? 'custom';
$progress = $data['progress'] ?? '0';
$streak = $data['streak'] ?? 0;

try {
    $stmt = $conn->prepare("INSERT INTO goals (user_id, title, description, goal_type, progress, streak, category) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([$user_id, $title, $description, $goal_type, $progress, $streak, $category]);
    echo json_encode(['success' => true, 'message' => 'Goal added successfully']);
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
}
?>