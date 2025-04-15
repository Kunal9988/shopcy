<?php
include 'includes/connection.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (isset($_POST['product_id'], $_POST['size'], $_POST['action'])) {
    $product_id = $_POST['product_id'];
    $size = $_POST['size'];
    $action = $_POST['action'];

    if (!isset($_SESSION['user_id'])) {
        header("Location: user_login.php");
        exit();
    }
    
    $user_id = $_SESSION['user_id'];

    if ($action == 'cart') {
        // Add to Cart
        $stmt = $conn->prepare("INSERT INTO cart (user_id, product_id, size) VALUES (?, ?, ?)");
        $stmt->bind_param("iis", $user_id, $product_id, $size);
        $stmt->execute();
        header("Location: cart.php");
        exit();
    } elseif ($action == 'wishlist') {
        // Add to Wishlist
        $stmt = $conn->prepare("SELECT * FROM wishlist WHERE user_id = ? AND product_id = ? AND size = ?");
        $stmt->bind_param("iis", $user_id, $product_id, $size);
        $stmt->execute();
        $result = $stmt->get_result();

        // Only add if not already in the wishlist
        if ($result->num_rows == 0) {
            $stmt = $conn->prepare("INSERT INTO wishlist (user_id, product_id, size) VALUES (?, ?, ?)");
            $stmt->bind_param("iis", $user_id, $product_id, $size);
            $stmt->execute();
        }

        header("Location: wishlist.php");
        exit();
    }
}
