<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include 'includes/connection.php';
include 'navbar.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: user_login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch user details
$query = $conn->prepare("SELECT * FROM users WHERE id = ?");
$query->bind_param("i", $user_id);
$query->execute();
$user_result = $query->get_result();
$user = $user_result->fetch_assoc();

// Fetch cart items from DB
$cart_items = [];
$cart_query = $conn->prepare("SELECT products.*, cart.quantity, cart.size FROM cart JOIN products ON cart.product_id = products.id WHERE cart.user_id = ?");
$cart_query->bind_param("i", $user_id);
$cart_query->execute();
$cart_result = $cart_query->get_result();

while ($row = $cart_result->fetch_assoc()) {
    $cart_items[] = [
        'name' => $row['name'],
        'price' => $row['price'],
        'quantity' => $row['quantity'],
        'size' => $row['size']
    ];
}

$total_price = 0;
foreach ($cart_items as $item) {
    $total_price += $item['price'] * $item['quantity'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Checkout</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2 class="text-center">Checkout</h2>

    <!-- Cart Review Section -->
    <h4>Cart Summary</h4>
    <table class="table">
        <thead>
            <tr>
                <th>Product</th>
                <th>Size</th>
                <th>Quantity</th>
                <th>Price</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($cart_items as $item): ?>
                <tr>
                    <td><?= htmlspecialchars($item['name']); ?></td>
                    <td><?= htmlspecialchars($item['size']); ?></td>
                    <td><?= $item['quantity']; ?></td>
                    <td>₹<?= number_format($item['price'], 2); ?></td>
                    <td>₹<?= number_format($item['price'] * $item['quantity'], 2); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <!-- Shipping Information Section -->
    <h4>Shipping Information</h4>
    <form method="post" action="place_order.php">
        <div class="mb-3">
            <label for="billing_name" class="form-label">Full Name</label>
            <input type="text" class="form-control" id="billing_name" name="billing_name" value="<?= htmlspecialchars($user['name']); ?>" required>
        </div>
        <div class="mb-3">
            <label for="billing_address" class="form-label">Address</label>
            <textarea class="form-control" id="billing_address" name="billing_address" required><?= htmlspecialchars($user['address']); ?></textarea>
        </div>
        <div class="mb-3">
            <label for="billing_email" class="form-label">Email</label>
            <input type="email" class="form-control" id="billing_email" name="billing_email" value="<?= htmlspecialchars($user['email']); ?>" required>
        </div>
        <div class="mb-3">
            <label for="billing_phone" class="form-label">Phone Number</label>
            <input type="text" class="form-control" id="billing_phone" name="billing_phone" value="<?= htmlspecialchars($user['phone']); ?>" required>
        </div>

        <!-- Shipping Method -->
        <div class="mb-3">
            <label for="shipping_method" class="form-label">Shipping Method</label>
            <select class="form-control" id="shipping_method" name="shipping_method" required>
                <option value="Standard">Standard Shipping</option>
                <option value="Express">Express Shipping</option>
            </select>
        </div>

        <!-- Payment Method -->
        <h4>Payment Information</h4>
        <div class="mb-3">
            <label for="payment_method" class="form-label">Payment Method</label>
            <select class="form-control" id="payment_method" name="payment_method" required>
                <option value="Credit Card">Credit Card</option>
                <option value="PayPal">PayPal</option>
            </select>
        </div>

        <div class="d-flex justify-content-between">
            <p>Total: ₹<?= number_format($total_price, 2); ?></p>
            <button type="submit" class="btn btn-success">Place Order</button>
        </div>
    </form>
</div>

<?php include 'footer.php'; ?>
</body>
</html>
