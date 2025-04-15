<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include 'includes/connection.php';

if (!isset($_SESSION['user_id'])) {
    $notLoggedIn = true;
} else {
    $notLoggedIn = false;
    $user_id = $_SESSION['user_id'];

    // Modified: Added size support in query and error handling
    $query = $conn->prepare("SELECT products.*, wishlist.size 
                             FROM wishlist 
                             JOIN products ON wishlist.product_id = products.id 
                             WHERE wishlist.user_id = ?");
    if ($query === false) {
        die('MySQL Error: ' . $conn->error);  // This will show any MySQL error if the query fails
    }

    $query->bind_param("i", $user_id);
    $query->execute();
    $result = $query->get_result();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Wishlist</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .wishlist-img {
            width: 80px;
            height: 80px;
            object-fit: cover;
        }
    </style>
</head>
<body>

<?php include 'navbar.php'; ?>

<div class="container mt-5">
    <h2 class="mb-4 text-center">My Wishlist</h2>

    <?php if ($notLoggedIn): ?>
        <div class="alert alert-warning text-center">
            You need to log in to view your wishlist.<br><br>
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
                            <th style="width: 150px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($product = $result->fetch_assoc()): ?>
                            <tr>
                                <td><img src="assets/product_images/<?= htmlspecialchars($product['image']) ?>" class="wishlist-img" alt="<?= htmlspecialchars($product['name']) ?>"></td>
                                <td><?= htmlspecialchars($product['name']) ?></td>
                                <td><?= htmlspecialchars($product['size']) ?></td>
                                <td>₹<?= htmlspecialchars($product['price']) ?></td>
                                <td>
                                    <form action="move_to_cart.php" method="post" class="d-inline">
                                        <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                                        <input type="hidden" name="size" value="<?= $product['size'] ?>">
                                        <button type="submit" class="btn btn-sm btn-success mb-1">🛒 Move to Cart</button>
                                    </form>
                                    <form action="remove_from_wishlist.php" method="post" class="d-inline">
                                        <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                                        <input type="hidden" name="size" value="<?= $product['size'] ?>">
                                        <button type="submit" class="btn btn-sm btn-danger">❌ Remove</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div class="alert alert-info text-center">Your wishlist is currently empty.</div>
        <?php endif; ?>
    <?php endif; ?>
</div>

<?php include 'footer.php'; ?>
</body>
</html>
