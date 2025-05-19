<?php
require_once 'includes/header.php';

// Pagination
$per_page = 10;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$start = ($page > 1) ? ($page * $per_page) - $per_page : 0;

// Get total users
$total = $conn->query("SELECT COUNT(DISTINCT userid) as total FROM user_health_data")->fetch_assoc()['total'];
$pages = ceil($total / $per_page);

// Get users
$users = [];
$query = "SELECT userid, name, COUNT(*) as records, MAX(submission_date) as last_submission 
          FROM user_health_data 
          GROUP BY userid, name 
          LIMIT $start, $per_page";
$result = $conn->query($query);

while ($row = $result->fetch_assoc()) {
    $users[] = $row;
}
?>

<div class="container-fluid px-4">
    <h1 class="mt-4">Users</h1>
    
    <div class="card mb-4">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <span><i class="fas fa-users me-1"></i> User List</span>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>User ID</th>
                            <th>Name</th>
                            <th>Records</th>
                            <th>Last Submission</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($users as $user): ?>
                        <tr>
                            <td><?= htmlspecialchars($user['userid']) ?></td>
                            <td><?= htmlspecialchars($user['name']) ?></td>
                            <td><?= $user['records'] ?></td>
                            <td><?= date('M j, Y H:i', strtotime($user['last_submission'])) ?></td>
                            <td>
                                <a href="health_data.php?userid=<?= urlencode($user['userid']) ?>" class="btn btn-sm btn-primary">View Data</a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            <nav>
                <ul class="pagination justify-content-center">
                    <?php if ($page > 1): ?>
                    <li class="page-item">
                        <a class="page-link" href="?page=<?= $page-1 ?>">Previous</a>
                    </li>
                    <?php endif; ?>
                    
                    <?php for ($i = 1; $i <= $pages; $i++): ?>
                    <li class="page-item <?= ($page == $i) ? 'active' : '' ?>">
                        <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
                    </li>
                    <?php endfor; ?>
                    
                    <?php if ($page < $pages): ?>
                    <li class="page-item">
                        <a class="page-link" href="?page=<?= $page+1 ?>">Next</a>
                    </li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>