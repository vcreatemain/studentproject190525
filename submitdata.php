<?php
// Include database connection
require_once 'db.php';

// Get the raw POST data
$json = file_get_contents('php://input');
$data = json_decode($json, true);

// Validate required fields
if (!isset($data['userid'], $data['name'], $data['age'], $data['gender'], 
    $data['height'], $data['weight'], $data['oxygen'], 
    $data['systolic'], $data['diastolic'], $data['steps'])) {
    http_response_code(400);
    exit('Missing required fields');
}

try {
    // Prepare SQL statement
    $stmt = $conn->prepare("INSERT INTO user_health_data 
        (userid, name, age, gender, height, weight, oxygen, systolic, diastolic, steps) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    
    // Bind parameters
    $stmt->bind_param("ssisddiiii", 
        $data['userid'],
        $data['name'],
        $data['age'],
        $data['gender'],
        $data['height'],
        $data['weight'],
        $data['oxygen'],
        $data['systolic'],
        $data['diastolic'],
        $data['steps']
    );
    
    // Execute the statement
    if ($stmt->execute()) {
        http_response_code(200);
    } else {
        http_response_code(500);
    }
    
    $stmt->close();
} catch (Exception $e) {
    http_response_code(500);
    error_log("Database error: " . $e->getMessage());
}

$conn->close();
?>