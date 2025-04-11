<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (isset($_GET['id']) && isset($_GET['action'])) {
    $id = $_GET['id'];
    $action = $_GET['action'];

    // Loop through the cart to find the product by ID
    foreach ($_SESSION['cart'] as $key => $item) {
        if ($item['id'] == $id) {
            if ($action == 'add') {
                $_SESSION['cart'][$key]['quantity'] += 1;
            } elseif ($action == 'subtract') {
                if ($_SESSION['cart'][$key]['quantity'] > 1) {
                    $_SESSION['cart'][$key]['quantity'] -= 1;
                } else {
                    unset($_SESSION['cart'][$key]);
                }
            }
            break;
        }
    }
}

header("Location: cart.php");
exit();
