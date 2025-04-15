<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include 'includes/connection.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if (isset($_POST['product_id']) && isset($_POST['size'])) {
    $user_id = $_SESSION['user_id'];
    $product_id = $_POST['product_id'];
    $size = $_POST['size'];

    $stmt = $conn->prepare("DELETE FROM wishlist WHERE user_id = ? AND product_id = ? AND size = ?");
    $stmt->bind_param("iis", $user_id, $product_id, $size);
    $stmt->execute();
    $stmt->close();
}

header("Location: wishlist.php");
exit();
?>
