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

// Validate product_id
if (isset($_POST['product_id']) && is_numeric($_POST['product_id'])) {
    $product_id = (int)$_POST['product_id'];
    $user_id = (int)$_SESSION['user_id'];

    // Check if already in wishlist
    $check = $conn->prepare("SELECT 1 FROM wishlist WHERE user_id = ? AND product_id = ?");
    if ($check) {
        $check->bind_param("ii", $user_id, $product_id);
        $check->execute();
        $check->store_result();

        if ($check->num_rows === 0) {
            // Not in wishlist, insert it
            $insert = $conn->prepare("INSERT INTO wishlist (user_id, product_id) VALUES (?, ?)");
            if ($insert) {
                $insert->bind_param("ii", $user_id, $product_id);
                $insert->execute();
                $insert->close();
            }
        }
        $check->close();
    } else {
        die("SQL Error: " . $conn->error);
    }
}

// ✅ You can change this redirect to 'wishlist.php' if preferred
header("location: wishlist.php");
exit();
?>
