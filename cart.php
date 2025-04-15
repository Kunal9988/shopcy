<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include 'includes/connection.php';

$notLoggedIn = !isset($_SESSION['user_id']);

if (!$notLoggedIn) {
    $user_id = $_SESSION['user_id'];

    $query = $conn->prepare("SELECT products.*, cart.quantity, cart.size 
                             FROM cart 
                             JOIN products ON cart.product_id = products.id 
                             WHERE cart.user_id = ?");
    if (!$query) {
        die("Query preparation failed: " . $conn->error);
    }

    $query->bind_param("i", $user_id);
    $query->execute();
    $result = $query->get_result();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>My Cart</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .cart-img {
            width: 80px;
            height: 80px;
            object-fit: cover;
        }
        .action-buttons form {
            display: inline-block;
            margin-top: 5px;
        }
    </style>
</head>
<body>

<?php include 'navbar.php'; ?>

<div class="container mt-5">
    <h2 class="mb-4 text-center">My Cart</h2>

    <?php if ($notLoggedIn): ?>
        <div class="alert alert-warning text-center">
            You need to log in to view your cart.<br><br>
            <a href="user_login.php" class="btn btn-primary">Go to Login</a>
        </div>
    <?php else: ?>
        <?php if ($result->num_rows > 0): ?>
            <div class="table-responsive">
                <table class="table table-bordered align-middle text-center">
                    <thead class="table-dark">
                        <tr>
                            <th>Image</th>
                            <th>Name</th>
                            <th>Size</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Total</th>
                            <th style="width: 180px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $grandTotal = 0;
                        while ($product = $result->fetch_assoc()):
                            $total = $product['price'] * $product['quantity'];
                            $grandTotal += $total;
                        ?>
                        <tr>
                            <td><img src="assets/product_images/<?= htmlspecialchars($product['image']) ?>" class="cart-img" alt="<?= htmlspecialchars($product['name']) ?>"></td>
                            <td><?= htmlspecialchars($product['name']) ?></td>
                            <td><?= htmlspecialchars($product['size']) ?></td>
                            <td>₹<?= htmlspecialchars($product['price']) ?></td>
                            <td>
                                <form action="update_cart.php" method="post" class="d-flex justify-content-center align-items-center">
                                    <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                                    <input type="hidden" name="size" value="<?= htmlspecialchars($product['size']) ?>">
                                    <button type="submit" name="action" value="decrease" class="btn btn-sm btn-outline-secondary">−</button>
                                    <span class="mx-2"><?= htmlspecialchars($product['quantity']) ?></span>
                                    <button type="submit" name="action" value="increase" class="btn btn-sm btn-outline-secondary">+</button>
                                </form>
                            </td>
                            <td>₹<?= number_format($total, 2) ?></td>
                            <td class="action-buttons">
                                <!-- Remove from cart -->
                                <form action="remove_from_cart.php" method="post">
                                    <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                                    <input type="hidden" name="size" value="<?= htmlspecialchars($product['size']) ?>">
                                    <button type="submit" class="btn btn-sm btn-danger">❌ Remove</button>
                                </form>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>

                <div class="text-end">
                    <h5>Grand Total: ₹<?= number_format($grandTotal, 2) ?></h5>
                    <a href="checkout.php" class="btn btn-success mt-2">Proceed to Checkout</a>
                </div>
            </div>
        <?php else: ?>
            <div class="alert alert-info text-center">Your cart is currently empty.</div>
        <?php endif; ?>
    <?php endif; ?>
</div>

<?php include 'footer.php'; ?>
</body>
</html>
