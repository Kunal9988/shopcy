<?php
session_start();
include 'includes/connection.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch user details for displaying the confirmation message
$user_query = $conn->prepare("SELECT name, address FROM users WHERE id = ?");
$user_query->bind_param("i", $user_id);
$user_query->execute();
$user_result = $user_query->get_result();
$user = $user_result->fetch_assoc();

// Get form data with null coalescing to prevent undefined index
$billing_name = $_POST['billing_name'] ?? '';
$billing_address = $_POST['billing_address'] ?? '';
$billing_email = $_POST['billing_email'] ?? '';
$billing_phone = $_POST['billing_phone'] ?? '';
$shipping_method = $_POST['shipping_method'] ?? '';
$payment_method = $_POST['payment_method'] ?? '';

// Fetch cart items
$cart_query = $conn->prepare("SELECT c.*, p.name, p.price FROM cart c JOIN products p ON c.product_id = p.id WHERE c.user_id = ?");
$cart_query->bind_param("i", $user_id);
$cart_query->execute();
$cart_result = $cart_query->get_result();

$cart_items = [];
$total_price = 0;
while ($row = $cart_result->fetch_assoc()) {
    $subtotal = $row['price'] * $row['quantity'];
    $total_price += $subtotal;
    $cart_items[] = $row;
}

// Set default values
$status = 'Pending';
$shipping_fee = 50.00;
$tax = 0.00;
$final_amount = $total_price + $shipping_fee + $tax;

// Insert into orders table
$order_query = $conn->prepare("INSERT INTO orders (
    user_id, total_amount, shipping_fee, tax, status, payment_method,
    billing_name, billing_address, billing_email, billing_phone, created_at, updated_at
) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), NOW())");

$order_query->bind_param(
    "idddssssss",
    $user_id,
    $final_amount,
    $shipping_fee,
    $tax,
    $status,
    $payment_method,
    $billing_name,
    $billing_address,
    $billing_email,
    $billing_phone
);

$order_query->execute();
$order_id = $conn->insert_id;

// Insert order items
$order_item_query = $conn->prepare("INSERT INTO order_items (order_id, product_id, quantity, size, price) VALUES (?, ?, ?, ?, ?)");

foreach ($cart_items as $item) {
    $product_id = $item['product_id'];
    $quantity = $item['quantity'];
    $size = $item['size'];
    $price = $item['price'];

    $order_item_query->bind_param("iiisd", $order_id, $product_id, $quantity, $size, $price);
    $order_item_query->execute();
}

// Clear cart
$clear_cart_query = $conn->prepare("DELETE FROM cart WHERE user_id = ?");
$clear_cart_query->bind_param("i", $user_id);
$clear_cart_query->execute();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Order Confirmation | Shopcy</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f3f3f3;
        }
        .success-container {
            padding-top: 60px;
            padding-bottom: 80px;
        }
        .success-card {
            background: #fff;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
        }
        .success-checkmark {
            font-size: 60px;
            color: green;
        }



        .success-checkmark {
    font-size: 60px;
    color: green;
    animation: pop-in 0.5s ease-out;
}

@keyframes pop-in {
    0% {
        transform: scale(0);
        opacity: 0;
    }
    80% {
        transform: scale(1.2);
        opacity: 1;
    }
    100% {
        transform: scale(1);
    }
}

    </style>
</head>
<body>
<?php include 'navbar.php'; ?>

<div class="container success-container text-center">
    <div class="success-card mx-auto" style="max-width: 600px;">
        <!-- <div class="success-checkmark">&#10003;</div> -->
        <div class="success-checkmark">&#10004;</div>
        <h2 class="mt-3">Thank You for Your Order!</h2>
        <p>We're delivering to:</p>
        <p><strong><?= htmlspecialchars($user['name']); ?></strong></p>
        <p><?= htmlspecialchars($billing_address); ?></p>
        <p>Your order ID is <strong>#<?= $order_id; ?></strong>.</p>
        <p>We’ve received your order and will process it shortly.</p>
        <a href="order_details.php?order_id=<?= $order_id; ?>" class="btn mt-4" style="background-color:rgb(100, 85, 92); color: white; border: none;">View Order Details</a>
<a href="home.php" class="btn mt-4" style="background-color:rgb(160, 19, 85); color: white; border: none;">Continue Shopping</a>

    </div>
</div>

<?php include 'footer.php'; ?>
</body>
</html>
