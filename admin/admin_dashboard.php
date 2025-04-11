<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            margin: 0;
            background-color: #f8f9fa;
        }

        .sidebar {
            height: 100vh;
            background-color: #343a40;
            padding-top: 1rem;
        }

        .sidebar a {
            color: white;
            display: block;
            padding: 15px 20px;
            text-decoration: none;
            transition: 0.3s;
        }

        .sidebar a:hover, .sidebar a.active {
            background-color: #495057;
        }

        .content {
            padding: 2rem;
        }

        .navbar-brand {
            color: white;
            font-weight: bold;
            padding: 0 20px;
        }

        .logout-btn {
            position: absolute;
            bottom: 1rem;
            left: 1rem;
            right: 1rem;
        }
    </style>
</head>
<body>

<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <nav class="col-md-2 sidebar d-flex flex-column">
            <div class="navbar-brand mb-4">Admin Panel</div>
            <a href="admin_dashboard.php" class="active">Dashboard</a>
            <a href="manage_products.php">Manage Products</a>
            <a href="manage_user.php">Manage Users</a>
            <a href="admin_setting.php">Settings</a>
            <a href="admin_logout.php" class="logout-btn text-danger">Logout</a>
        </nav>

        <!-- Main content -->
        <main class="col-md-10 content">
            <h2>Welcome, Admin 👋</h2>
            <p>Use the sidebar to navigate between different management features.</p>

            <div class="row mt-4">
                <div class="col-md-6">
                    <div class="card shadow-sm border-0">
                        <div class="card-body">
                            <h5 class="card-title">Product Management</h5>
                            <p class="card-text">Add, edit, delete, and view all products.</p>
                            <a href="manage_products.php" class="btn btn-primary">Manage Products</a>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card shadow-sm border-0">
                        <div class="card-body">
                            <h5 class="card-title">User Management</h5>
                            <p class="card-text">View and manage all registered users.</p>
                            <a href="manage_user.php" class="btn btn-primary">Manage Users</a>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>

</body>
</html>
