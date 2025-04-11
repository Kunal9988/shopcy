<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include 'includes/connection.php';

// Redirect if user is not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: user_login.php");
    exit();
}

// Ensure product_id is set and is a valid integer
if (isset($_POST['product_id']) && is_numeric($_POST['product_id'])) {
    $product_id = (int)$_POST['product_id'];
    $user_id = (int)$_SESSION['user_id'];

    // Check if product already exists in cart
    $stmt = $conn->prepare("SELECT quantity FROM cart WHERE user_id = ? AND product_id = ?");
    if ($stmt) {
        $stmt->bind_param("ii", $user_id, $product_id);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            // If exists, update quantity
            $update = $conn->prepare("UPDATE cart SET quantity = quantity + 1 WHERE user_id = ? AND product_id = ?");
            $update->bind_param("ii", $user_id, $product_id);
            $update->execute();
            $update->close();
        } else {
            // If not exists, insert into cart
            $insert = $conn->prepare("INSERT INTO cart (user_id, product_id, quantity) VALUES (?, ?, 1)");
            $insert->bind_param("ii", $user_id, $product_id);
            $insert->execute();
            $insert->close();
        }
        $stmt->close();
    } else {
        // Handle SQL error gracefully (optional)
        die("Error preparing statement: " . $conn->error);
    }
}

// Redirect to cart
header("Location: home.php");
exit();
?>
