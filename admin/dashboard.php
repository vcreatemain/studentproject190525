<?php
require_once 'includes/header.php';
require_once 'includes/functions.php';

// Get statistics
$stats = [
    'total_users' => 0,
    'total_records' => 0,
    'underweight' => 0,
    'normal' => 0,
    'overweight' => 0,
    'obese' => 0
];

// Get total users
$result = $conn->query("SELECT COUNT(DISTINCT userid) as count FROM user_health_data");
$stats['total_users'] = $result->fetch_assoc()['count'];

// Get total records
$result = $conn->query("SELECT COUNT(*) as count FROM user_health_data");
$stats['total_records'] = $result->fetch_assoc()['count'];

// Get BMI distribution
$result = $conn->query("SELECT weight, height FROM user_health_data");
while ($row = $result->fetch_assoc()) {
    $bmi = calculateBMI($row['weight'], $row['height']);
    $category = getBMICategory($bmi);
    
    switch ($category) {
        case 'Underweight': $stats['underweight']++; break;
        case 'Normal': $stats['normal']++; break;
        case 'Overweight': $stats['overweight']++; break;
        case 'Obese': $stats['obese']++; break;
    }
}
?>

<div class="container-fluid px-4">
    <h1 class="mt-4">Dashboard</h1>
    
    <div class="row mt-4">
        <div class="col-xl-3 col-md-6">
            <div class="card bg-primary text-white mb-4">
                <div class="card-body">
                    <h5 class="card-title">Total Users</h5>
                    <h2><?= $stats['total_users'] ?></h2>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card bg-success text-white mb-4">
                <div class="card-body">
                    <h5 class="card-title">Health Records</h5>
                    <h2><?= $stats['total_records'] ?></h2>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="col-xl-6">
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-chart-pie me-1"></i>
                    BMI Distribution
                </div>
                <div class="card-body">
                    <canvas id="bmiChart" width="100%" height="40"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // BMI Chart
    const ctx = document.getElementById('bmiChart').getContext('2d');
    const bmiChart = new Chart(ctx, {
        type: 'pie',
        data: {
            labels: ['Underweight', 'Normal', 'Overweight', 'Obese'],
            datasets: [{
                data: [
                    <?= $stats['underweight'] ?>,
                    <?= $stats['normal'] ?>,
                    <?= $stats['overweight'] ?>,
                    <?= $stats['obese'] ?>
                ],
                backgroundColor: [
                    'rgba(54, 162, 235, 0.7)',
                    'rgba(75, 192, 192, 0.7)',
                    'rgba(255, 206, 86, 0.7)',
                    'rgba(255, 99, 132, 0.7)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            const label = context.label || '';
                            const value = context.raw || 0;
                            const total = context.dataset.data.reduce((a, b) => a + b, 0);
                            const percentage = Math.round((value / total) * 100);
                            return `${label}: ${value} (${percentage}%)`;
                        }
                    }
                }
            }
        }
    });
</script>

<?php require_once 'includes/footer.php'; ?>