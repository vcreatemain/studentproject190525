<?php
// Set response header
header('Content-Type: application/json');
include 'db.php';
// Database connection
$mysqli = $conn;

// Get JSON input
$input = file_get_contents('php://input');
$data = json_decode($input, true);
$data['userid']=5;
// Validate input
if (!isset($data['userid']) || !isset($data['mealType']) || !isset($data['foodItems']) || !is_array($data['foodItems'])) {
    echo json_encode(['success' => false, 'error' => 'Invalid input data']);
    exit;
}

$userid = (int)$data['userid'];
$mealType = $data['mealType'];
$foodItems = $data['foodItems'];

// Validate userid and mealType
if ($userid <= 0 || empty($mealType)) {
    echo json_encode(['success' => false, 'error' => "$userid Invalid userid or meal type"]);
    exit;
}

// Validate food items
foreach ($foodItems as $item) {
    if (!isset($item['name']) || !isset($item['calories']) || !isset($item['portion']) ||
        empty($item['name']) || !is_numeric($item['calories']) || empty($item['portion'])) {
        echo json_encode(['success' => false, 'error' => 'Invalid food item data']);
        exit;
    }
}

// Start transaction
$mysqli->begin_transaction();

try {
    // Insert into meals table
    $query = "INSERT INTO meals (userid, meal_type, submission_date) VALUES (?, ?, NOW())";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("is", $userid, $mealType);
    $stmt->execute();
    $mealId = $mysqli->insert_id; // Get the inserted meal_id
    $stmt->close();

    // Insert food items
    $query = "INSERT INTO meal_food_items (meal_id, food_name, calories, portion) VALUES (?, ?, ?, ?)";
    $stmt = $mysqli->prepare($query);
    foreach ($foodItems as $item) {
        $foodName = $item['name'];
        $calories = (float)$item['calories'];
        $portion = $item['portion'];
        $stmt->bind_param("isds", $mealId, $foodName, $calories, $portion);
        $stmt->execute();
    }
    $stmt->close();

    // Commit transaction
    $mysqli->commit();
    echo json_encode(['success' => true]);

} catch (Exception $e) {
    // Rollback on error
    $mysqli->rollback();
    echo json_encode(['success' => false, 'error' => 'Database error: ' . $e->getMessage()]);
}

// Close connection
$mysqli->close();
?>