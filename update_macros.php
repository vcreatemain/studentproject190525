<?php
// update_macros.php
header('Content-Type: application/json');

// Get JSON input from the fetch call
$data = json_decode(file_get_contents('php://input'), true);

// Basic input validation
if (!isset($data['id'], $data['protein'], $data['carbs'], $data['fats'])) {
    echo json_encode(['error' => 'Invalid input']);
    exit;
}

require 'db.php'; // This file should set up $conn (MySQLi)

// Sanitize inputs
$id = $data['id'];
$protein = intval($data['protein']);
$carbs = intval($data['carbs']);
$fats = intval($data['fats']);

// Fetch current progress JSON from `goals` table
$sql = "SELECT progress FROM goals WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

if (!$row) {
    echo json_encode(['error' => 'Goal not found']);
    exit;
}

$current = json_decode($row['progress'], true);

// Ensure defaults if keys are missing
$current['protein'] = isset($current['protein']) ? $current['protein'] : 0;
$current['carbs'] = isset($current['carbs']) ? $current['carbs'] : 0;
$current['fats'] = isset($current['fats']) ? $current['fats'] : 0;

// Update the values
$current['protein'] += $protein;
$current['carbs'] += $carbs;
$current['fats'] += $fats;

// Encode updated progress
$newProgress = json_encode($current);

// Update the progress column in the database
$update = $conn->prepare("UPDATE goals SET progress = ? WHERE id = ?");
$update->bind_param("ss", $newProgress, $id);
$update->execute();

// Return the updated values to the frontend
echo json_encode([
    'protein' => $current['protein'],
    'carbs' => $current['carbs'],
    'fats' => $current['fats']
]);
