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

// Ensure product_id is set and valid
if (isset($_POST['product_id']) && is_numeric($_POST['product_id'])) {
    $product_id = (int)$_POST['product_id'];
    $user_id = (int)$_SESSION['user_id'];

    // Check if product is already in cart
    $stmt = $conn->prepare("SELECT quantity FROM cart WHERE user_id = ? AND product_id = ?");
    if ($stmt) {
        $stmt->bind_param("ii", $user_id, $product_id);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            // Update quantity if exists
            $update = $conn->prepare("UPDATE cart SET quantity = quantity + 1 WHERE user_id = ? AND product_id = ?");
            $update->bind_param("ii", $user_id, $product_id);
            $update->execute();
            $update->close();
        } else {
            // Insert if not exists
            $insert = $conn->prepare("INSERT INTO cart (user_id, product_id, quantity) VALUES (?, ?, 1)");
            $insert->bind_param("ii", $user_id, $product_id);
            $insert->execute();
            $insert->close();
        }
        $stmt->close();

        // 🗑 Remove from wishlist if exists
        $remove = $conn->prepare("DELETE FROM wishlist WHERE user_id = ? AND product_id = ?");
        $remove->bind_param("ii", $user_id, $product_id);
        $remove->execute();
        $remove->close();
    } else {
        die("SQL Error: " . $conn->error);
    }
}

// ✅ Optional: redirect where needed
header("Location: home.php"); // or home.php if you prefer
exit();
?>
