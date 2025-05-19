<?php
function calculateBMI($weight, $height) {
    if ($height <= 0) return 0;
    return $weight / (($height/100) * ($height/100));
}

function getBMICategory($bmi) {
    if ($bmi < 18.5) return 'Underweight';
    if ($bmi < 25) return 'Normal';
    if ($bmi < 30) return 'Overweight';
    return 'Obese';
}

function exportToExcel($data, $filename) {
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment; filename="'.$filename.'.xls"');
    
    echo '<table border="1">';
    // Header row
    echo '<tr>';
    foreach(array_keys($data[0]) as $col) {
        echo '<th>'.htmlspecialchars($col).'</th>';
    }
    echo '</tr>';
    
    // Data rows
    foreach($data as $row) {
        echo '<tr>';
        foreach($row as $cell) {
            echo '<td>'.htmlspecialchars($cell).'</td>';
        }
        echo '</tr>';
    }
    echo '</table>';
    exit();
}
?>