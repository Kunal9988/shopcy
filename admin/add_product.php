<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit();
}
include '../includes/connection.php';

$message = '';

// Show success message
if (isset($_GET['msg']) && $_GET['msg'] === 'success') {
    $message = "✅ Product added successfully!";
}

// Handle product submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $category = $_POST['category'];
    $gender = $_POST['gender'];
    $description = $_POST['description'];

    // Image handling
    $image = $_FILES['image']['name'];
    $image_tmp = $_FILES['image']['tmp_name'];
    $image_path = "../assets/product_images/" . basename($image);

    if (move_uploaded_file($image_tmp, $image_path)) {
        $stmt = $conn->prepare("INSERT INTO products (name, price, category, gender, image, description) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sdssss", $name, $price, $category, $gender, $image, $description);

        if ($stmt->execute()) {
            header("Location: add_product.php?msg=success");
            exit();
        } else {
            $message = "❌ Failed to add product!";
        }
    } else {
        $message = "❌ Failed to upload image!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Product</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f7f7f7;
        }
        .form-container {
            max-width: 650px;
            background: #fff;
            padding: 35px;
            margin: 60px auto;
            box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.1);
            border-radius: 12px;
        }
        h2 {
            font-weight: 600;
        }
    </style>
</head>
<body>
<div class="container form-container">
    <h2 class="mb-4 text-center">Add New Product</h2>

    <?php if ($message): ?>
        <div class="alert alert-info"><?= $message ?></div>
    <?php endif; ?>

    <form method="post" enctype="multipart/form-data">
        <div class="mb-3">
            <label class="form-label">Product Name</label>
            <input type="text" name="name" class="form-control" placeholder="Enter product name" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Price (₹)</label>
            <input type="number" step="0.01" name="price" class="form-control" placeholder="Enter price" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Gender</label>
            <select name="gender" class="form-control" required>
                <option value="">Select Gender</option>
                <option value="men">Men</option>
                <option value="women">Women</option>
                <option value="unisex">Unisex</option>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Category</label>
            <select name="category" class="form-control" required>
                <option value="">Select Category</option>
                <option value="shirts">Shirts</option>
                <option value="pants">Pants</option>
                <option value="tshirts">T-Shirts</option>
                <option value="jeans">Jeans</option>
                <option value="suit">Suit</option>
                <option value="shirt and pants">Shirt and Pants</option>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Product Description</label>
            <textarea name="description" class="form-control" rows="4" placeholder="Write product description..." required></textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Product Image</label>
            <input type="file" name="image" class="form-control" accept="image/*" required>
        </div>

        <div class="d-grid gap-2 d-md-flex justify-content-md-between">
            <button type="submit" class="btn btn-success px-4">Add Product</button>
            <a href="manage_products.php" class="btn btn-secondary">Back to Products</a>
        </div>
    </form>
</div>
</body>
</html>
