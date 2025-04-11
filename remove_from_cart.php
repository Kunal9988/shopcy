<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include 'includes/connection.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: user_login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['product_id'])) {
    $user_id = $_SESSION['user_id'];
    $product_id = $_POST['product_id'];

    $query = $conn->prepare("DELETE FROM cart WHERE user_id = ? AND product_id = ?");
    if (!$query) {
        die("Query error: " . $conn->error);
    }

    $query->bind_param("ii", $user_id, $product_id);

    if ($query->execute()) {
        header("Location: cart.php"); // Redirect back to cart
        exit();
    } else {
        echo "Failed to remove product from cart.";
    }
} else {
    header("Location: cart.php");
    exit();
}
?>
