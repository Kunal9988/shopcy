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
    <title>Admin Settings</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2>Admin Settings</h2>
    <p>This page can be used to update profile, password, or admin information.</p>

    <!-- You can add update form here -->
    <form method="post" action="#">
        <div class="mb-3">
            <label class="form-label">Admin Name</label>
            <input type="text" class="form-control" value="Admin Name" disabled>
        </div>
        <div class="mb-3">
            <label class="form-label">Email ID</label>
            <input type="email" class="form-control" value="admin@example.com" disabled>
        </div>
        <a href="logout.php" class="btn btn-danger">Logout</a>
    </form>
</div>
</body>
</html>
