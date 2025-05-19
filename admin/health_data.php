<?php
require_once 'includes/header.php';
require_once 'includes/functions.php'; // Add this line
$userid = isset($_GET['userid']) ? $_GET['userid'] : null;

// Delete record if requested
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $conn->query("DELETE FROM user_health_data WHERE id = $id");
    $_SESSION['message'] = "Record deleted successfully";
    header("Location: health_data.php?userid=".urlencode($userid));
    exit();
}

// Get user info
$user = null;
if ($userid) {
    $stmt = $conn->prepare("SELECT name FROM user_health_data WHERE userid = ? LIMIT 1");
    $stmt->bind_param("s", $userid);
    $stmt->execute();
    $user = $stmt->get_result()->fetch_assoc();
}

// Get health data
$data = [];
$query = $userid 
    ? "SELECT * FROM user_health_data WHERE userid = ? ORDER BY submission_date DESC"
    : "SELECT * FROM user_health_data ORDER BY submission_date DESC";

$stmt = $conn->prepare($query);
if ($userid) $stmt->bind_param("s", $userid);
$stmt->execute();
$result = $stmt->get_result();

while ($row = $result->fetch_assoc()) {
    $row['bmi'] = calculateBMI($row['weight'], $row['height']);
    $row['bmi_category'] = getBMICategory($row['bmi']);
    $data[] = $row;
}
?>

<div class="container-fluid px-4">
    <h1 class="mt-4">Health Data</h1>
    
    <?php if (isset($_SESSION['message'])): ?>
    <div class="alert alert-success"><?= $_SESSION['message'] ?></div>
    <?php unset($_SESSION['message']); endif; ?>
    
    <div class="card mb-4">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <span>
                    <i class="fas fa-heartbeat me-1"></i> 
                    <?= $userid ? 'Data for '.htmlspecialchars($user['name']) : 'All Health Data' ?>
                </span>
                <div>
                    <?php if ($userid): ?>
                    <a href="export.php?userid=<?= urlencode($userid) ?>" class="btn btn-sm btn-success">Export to Excel</a>
                    <?php else: ?>
                    <a href="export.php" class="btn btn-sm btn-success">Export All to Excel</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Name</th>
                            <th>Age</th>
                            <th>Gender</th>
                            <th>Height (cm)</th>
                            <th>Weight (kg)</th>
                            <th>BMI</th>
                            <th>Category</th>
                            <th>Oxygen</th>
                            <th>BP (S/D)</th>
                            <th>Steps</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($data as $row): ?>
                        <tr>
                            <td><?= date('M j, Y H:i', strtotime($row['submission_date'])) ?></td>
                            <td><?= htmlspecialchars($row['name']) ?></td>
                            <td><?= $row['age'] ?></td>
                            <td><?= htmlspecialchars($row['gender']) ?></td>
                            <td><?= $row['height'] ?></td>
                            <td><?= $row['weight'] ?></td>
                            <td><?= number_format($row['bmi'], 1) ?></td>
                            <td>
                                <?php 
                                $class = '';
                                switch($row['bmi_category']) {
                                    case 'Underweight': $class = 'text-info'; break;
                                    case 'Normal': $class = 'text-success'; break;
                                    case 'Overweight': $class = 'text-warning'; break;
                                    case 'Obese': $class = 'text-danger'; break;
                                }
                                ?>
                                <span class="<?= $class ?>"><?= $row['bmi_category'] ?></span>
                            </td>
                            <td><?= $row['oxygen'] ?>%</td>
                            <td><?= $row['systolic'] ?>/<?= $row['diastolic'] ?></td>
                            <td><?= $row['steps'] ?></td>
                            <td>
                                <a href="?delete=<?= $row['id'] ?>&userid=<?= urlencode($userid ?? '') ?>" 
                                   class="btn btn-sm btn-danger" 
                                   onclick="return confirm('Are you sure you want to delete this record?')">Delete</a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>