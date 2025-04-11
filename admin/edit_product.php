<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit();
}
include '../includes/connection.php';

$id = $_GET['id'];
$product = $conn->query("SELECT * FROM products WHERE id = $id")->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $desc = $_POST['description'];
    $price = $_POST['price'];
    $category = $_POST['category'];

    // Image update (optional)
    if (!empty($_FILES['image']['name'])) {
        $image = $_FILES['image']['name'];
        $target = "../assets/product_images/" . basename($image);
        move_uploaded_file($_FILES['image']['tmp_name'], $target);
        $sql = "UPDATE products SET name='$name', description='$desc', price='$price', category='$category', image='$image' WHERE id=$id";
    } else {
        $sql = "UPDATE products SET name='$name', description='$desc', price='$price', category='$category' WHERE id=$id";
    }

    $conn->query($sql);
    header("Location: manage_products.php");
}
?>
<!DOCTYPE html>
<html>
<head><title>Edit Product</title></head>
<body>
    <h2>Edit Product</h2>
    <form method="POST" enctype="multipart/form-data">
        <input type="text" name="name" value="<?= $product['name'] ?>" required><br><br>
        <textarea name="description" required><?= $product['description'] ?></textarea><br><br>
        <input type="text" name="price" value="<?= $product['price'] ?>" required><br><br>
        <input type="text" name="category" value="<?= $product['category'] ?>"><br><br>
        <p>Current Image:</p>
        <img src="../assets/product_images/<?= $product['image'] ?>" width="100"><br><br>
        <input type="file" name="image"><br><br>
        <button type="submit">Update Product</button>
    </form>
</body>
</html>
