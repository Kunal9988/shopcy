<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include 'includes/connection.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch user details
$user_query = $conn->prepare("SELECT * FROM users WHERE id = ?");
$user_query->bind_param("i", $user_id);
$user_query->execute();
$user_result = $user_query->get_result();
$user = $user_result->fetch_assoc();

// Fetch cart items with product info
$cart_query = $conn->prepare("SELECT c.*, p.name, p.price, p.image FROM cart c JOIN products p ON c.product_id = p.id WHERE c.user_id = ?");
$cart_query->bind_param("i", $user_id);
$cart_query->execute();
$cart_result = $cart_query->get_result();

$cart_items = [];
$total_price = 0;
while ($row = $cart_result->fetch_assoc()) {
    $row['subtotal'] = $row['price'] * $row['quantity'];
    $total_price += $row['subtotal'];
    $cart_items[] = $row;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Checkout | Shopcy</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f3f3f3;
        }
        .checkout-container {
            padding-top: 30px;
            padding-bottom: 50px;
        }
        .card {
            box-shadow: 0 0 10px rgba(0,0,0,0.08);
        }
        .card-header {
            background-color: #f8f9fa;
        }
        .sticky-summary {
            position: sticky;
            top: 80px;
        }
        .product-image {
            width: 60px;
            height: 60px;
            object-fit: cover;
        }
    </style>
</head>
<body>
<?php include 'navbar.php'; ?>
<div class="container checkout-container">
    <h2 class="text-center mb-5">Checkout</h2>
    <div class="row">
        <!-- Left Column -->
        <div class="col-md-8">
            <!-- Cart Summary -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5>Cart Summary</h5>
                </div>
                <div class="card-body">
                    <?php if (count($cart_items) > 0): ?>
                        <?php foreach ($cart_items as $item): ?>
                            <div class="d-flex align-items-center border-bottom py-3">
                                <img src="<?= htmlspecialchars($item['image']); ?>" alt="<?= htmlspecialchars($item['name']); ?>" class="me-3 product-image">
                                <div class="flex-grow-1">
                                    <h6 class="mb-1"><?= htmlspecialchars($item['name']); ?></h6>
                                    <p class="mb-0">Size: <?= $item['size']; ?> | Qty: <?= $item['quantity']; ?></p>
                                </div>
                                <div class="text-end">
                                    <p class="mb-0">₹<?= number_format($item['price'] * $item['quantity'], 2); ?></p>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p>Your cart is empty.</p>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Shipping Info -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5>Shipping Information</h5>
                </div>
                <div class="card-body">
                    <form method="post" action="place_order.php">
                        <div class="mb-3">
                            <label for="billing_name" class="form-label">Full Name</label>
                            <input type="text" class="form-control" name="billing_name" id="billing_name" value="<?= htmlspecialchars($user['name']); ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="billing_address" class="form-label">Address</label>
                            <textarea class="form-control" name="billing_address" id="billing_address" rows="2" required><?= htmlspecialchars($user['address']); ?></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="billing_email" class="form-label">Email</label>
                            <input type="email" class="form-control" name="billing_email" id="billing_email" value="<?= htmlspecialchars($user['email']); ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="billing_phone" class="form-label">Phone</label>
                            <input type="text" class="form-control" name="billing_phone" id="billing_phone" value="<?= htmlspecialchars($user['phone']); ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="shipping_method" class="form-label">Shipping Method</label>
                            <select class="form-select" name="shipping_method" id="shipping_method" required>
                                <option value="Standard">Standard</option>
                                <option value="Express">Express</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="payment_method" class="form-label">Payment Method</label>
                            <select class="form-select" name="payment_method" id="payment_method" required>
                                <option value="Credit Card">Credit Card</option>
                                <option value="UPI">UPI</option>
                                <option value="Cash on Delivery">Cash on Delivery</option>
                            </select>
                        </div>

                        <!-- Button visible only on small devices -->
                        <div class="d-block d-md-none mt-3">
                            <button type="submit" class="btn btn-success w-100">Place Order</button>
                        </div>
                </div>
            </div>
        </div>

        <!-- Right Column: Order Summary -->
        <div class="col-md-4">
            <div class="card sticky-summary">
                <div class="card-header">
                    <h5>Order Summary</h5>
                </div>
                <div class="card-body">
                    <?php foreach ($cart_items as $item): ?>
                        <div class="d-flex justify-content-between mb-2">
                            <span><?= htmlspecialchars($item['name']); ?> (x<?= $item['quantity']; ?>)</span>
                            <span>₹<?= number_format($item['subtotal'], 2); ?></span>
                        </div>
                    <?php endforeach; ?>
                    <hr>
                    <div class="d-flex justify-content-between fw-bold">
                        <span>Total:</span>
                        <span>₹<?= number_format($total_price, 2); ?></span>
                    </div>
                    <button type="submit" class="btn btn-success w-100 mt-3">Place Order</button>
                </div>
            </div>
            </form>
        </div>
    </div>
</div>

<?php include'footer.php'?>
</body>
</html>
