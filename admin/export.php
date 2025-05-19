<?php
require_once 'includes/auth.php';
require_once 'includes/db.php';
require_once 'includes/functions.php';

$userid = isset($_GET['userid']) ? $_GET['userid'] : null;

// Get data to export
$data = [];
$query = $userid 
    ? "SELECT * FROM user_health_data WHERE userid = ? ORDER BY submission_date DESC"
    : "SELECT * FROM user_health_data ORDER BY submission_date DESC";

$stmt = $conn->prepare($query);
if ($userid) $stmt->bind_param("s", $userid);
$stmt->execute();
$result = $stmt->get_result();

while ($row = $result->fetch_assoc()) {
    $bmi = calculateBMI($row['weight'], $row['height']);
    $data[] = [
        'Date' => date('Y-m-d H:i:s', strtotime($row['submission_date'])),
        'User ID' => $row['userid'],
        'Name' => $row['name'],
        'Age' => $row['age'],
        'Gender' => $row['gender'],
        'Height (cm)' => $row['height'],
        'Weight (kg)' => $row['weight'],
        'BMI' => number_format($bmi, 2),
        'BMI Category' => getBMICategory($bmi),
        'Oxygen (%)' => $row['oxygen'],
        'BP Systolic' => $row['systolic'],
        'BP Diastolic' => $row['diastolic'],
        'Steps' => $row['steps']
    ];
}

// Generate filename
$filename = $userid ? 'health_data_user_'.$userid : 'all_health_data';
$filename .= '_'.date('Ymd_His');

// Export to Excel
exportToExcel($data, $filename);
?>