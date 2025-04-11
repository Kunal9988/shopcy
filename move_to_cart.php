<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include 'includes/connection.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$product_id = $_POST['product_id'];

// Add to cart logic
$cart_check = $conn->prepare("SELECT * FROM cart WHERE user_id = ? AND product_id = ?");
$cart_check->bind_param("ii", $user_id, $product_id);
$cart_check->execute();
$cart_result = $cart_check->get_result();

if ($cart_result->num_rows == 0) {
    $add_cart = $conn->prepare("INSERT INTO cart (user_id, product_id, quantity) VALUES (?, ?, 1)");
    $add_cart->bind_param("ii", $user_id, $product_id);
    $add_cart->execute();
}

// Remove from wishlist
$remove_wishlist = $conn->prepare("DELETE FROM wishlist WHERE user_id = ? AND product_id = ?");
$remove_wishlist->bind_param("ii", $user_id, $product_id);
$remove_wishlist->execute();

header("Location: wishlist.php");
exit();
?>
