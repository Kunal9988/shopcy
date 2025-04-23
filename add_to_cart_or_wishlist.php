<?php
include 'includes/connection.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (isset($_POST['product_id'], $_POST['size'], $_POST['action'])) {
    $product_id = (int) $_POST['product_id'];
    $size = trim($_POST['size']);
    $action = $_POST['action'];

    if (!isset($_SESSION['user_id'])) {
        header("Location: user_login.php");
        exit();
    }

    $user_id = $_SESSION['user_id'];

    if ($action === 'cart') {
        // Check if product with size already in cart
        $check = $conn->prepare("SELECT quantity FROM cart WHERE user_id = ? AND product_id = ? AND size = ?");
        $check->bind_param("iis", $user_id, $product_id, $size);
        $check->execute();
        $check_result = $check->get_result();

        if ($check_result->num_rows > 0) {
            // Already in cart - update quantity
            $update = $conn->prepare("UPDATE cart SET quantity = quantity + 1 WHERE user_id = ? AND product_id = ? AND size = ?");
            $update->bind_param("iis", $user_id, $product_id, $size);
            $update->execute();
        } else {
            // Insert new
            $insert = $conn->prepare("INSERT INTO cart (user_id, product_id, size, quantity) VALUES (?, ?, ?, 1)");
            $insert->bind_param("iis", $user_id, $product_id, $size);
            $insert->execute();
        }

        header("Location: cart.php");
        exit();

    } elseif ($action === 'wishlist') {
        // Wishlist - check and insert if not exist
        $stmt = $conn->prepare("SELECT * FROM wishlist WHERE user_id = ? AND product_id = ? AND size = ?");
        $stmt->bind_param("iis", $user_id, $product_id, $size);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 0) {
            $stmt = $conn->prepare("INSERT INTO wishlist (user_id, product_id, size) VALUES (?, ?, ?)");
            $stmt->bind_param("iis", $user_id, $product_id, $size);
            $stmt->execute();
        }

        header("Location: wishlist.php");
        exit();
    }
} else {
    echo "Invalid request.";
}
?>
