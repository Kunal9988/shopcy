<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include 'includes/connection.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: user_login.php");
    exit();
}

if (isset($_POST['product_id'])) {
    $product_id = $_POST['product_id'];
    $user_id = $_SESSION['user_id'];

    $check = $conn->prepare("SELECT * FROM wishlist WHERE user_id = ? AND product_id = ?");
    $check->bind_param("ii", $user_id, $product_id);
    $check->execute();
    $result = $check->get_result();

    if ($result->num_rows == 0) {
        $insert = $conn->prepare("INSERT INTO wishlist (user_id, product_id) VALUES (?, ?)");
        $insert->bind_param("ii", $user_id, $product_id);
        $insert->execute();
    }
}

header("Location: wishlist.php");
exit();
?>
