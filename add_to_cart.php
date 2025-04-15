<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include 'includes/connection.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: user_login.php");
    exit();
}

if (isset($_POST['product_id']) && isset($_POST['size'])) {
    $product_id = $_POST['product_id'];
    $size = $_POST['size'];
    $user_id = $_SESSION['user_id'];

    // Check if the product with the same size is already in the cart
    $check = $conn->prepare("SELECT * FROM cart WHERE user_id = ? AND product_id = ? AND size = ?");
    $check->bind_param("iis", $user_id, $product_id, $size);
    $check->execute();
    $result = $check->get_result();

    if ($result->num_rows == 0) {
        // Insert into cart with size
        $insert = $conn->prepare("INSERT INTO cart (user_id, product_id, size) VALUES (?, ?, ?)");
        $insert->bind_param("iis", $user_id, $product_id, $size);
        $insert->execute();
    }
}

header("Location: cart.php");
exit();
?>
