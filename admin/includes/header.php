<?php
require_once 'auth.php';
requireAuth();
include 'includes/db.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            min-height: 100vh;
            display: flex;
        }
        .sidebar {
            width: 250px;
            background-color: #343a40;
            color: white;
            flex-shrink: 0;
        }
        .sidebar a {
            color: white;
        }
        .sidebar .nav-link.active {
            background-color: #495057;
        }
        .main-content {
            flex-grow: 1;
            background-color: #f8f9fa;
        }
        .navbar-brand {
            font-weight: bold;
        }
    </style>
</head>
<body>

    <!-- Sidebar -->
    <div class="sidebar d-flex flex-column p-3">
        <a href="dashboard.php" class="navbar-brand mb-4 text-white">Health Admin</a>

        <h6 class="text-uppercase text-muted small">Core</h6>
        <ul class="nav nav-pills flex-column mb-3">
            <li class="nav-item">
                <a href="dashboard.php" class="nav-link">
                    <i class="fas fa-tachometer-alt me-2"></i> Dashboard
                </a>
            </li>
   
            <li class="nav-item">
                <a href="users.php" class="nav-link">
                    <i class="fas fa-users me-2"></i> Users
                </a>
            </li>
            <li class="nav-item">
                <a href="health_data.php" class="nav-link">
                    <i class="fas fa-heartbeat me-2"></i> Health Data
                </a>
            </li>
        </ul>

        <div class="mt-auto">
            <div class="small text-white-50">Logged in as:</div>
            <div><?= htmlspecialchars($_SESSION['admin_username']) ?></div>
            <a href="logout.php" class="btn btn-outline-light btn-sm mt-2">Logout</a>
        </div>
    </div>

    <!-- Main content -->
    <div class="main-content d-flex flex-column w-100">
        <!-- Top Nav -->
        <nav class="navbar navbar-expand navbar-dark bg-dark">
            <div class="container-fluid">
                <button class="btn btn-dark d-md-none" type="button" data-bs-toggle="collapse" data-bs-target=".sidebar">
                    <i class="fas fa-bars"></i>
                </button>
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-user fa-fw"></i> <?= htmlspecialchars($_SESSION['admin_username']) ?>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                            <li><a class="dropdown-item" href="logout.php">Logout</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </nav>

        <!-- Page Content -->
        <main class="container-fluid p-4">