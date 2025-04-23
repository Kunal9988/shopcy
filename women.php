<?php
include 'includes/connection.php';

$sql = "SELECT * FROM products WHERE gender = 'women'";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Women's Products | Shopcy</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f9f9f9;
        }
        .card {
            height: auto;
            transition: transform 0.2s ease;
        }
        .card:hover {
            transform: translateY(-5px);
        }
        .card-img-top {
            height: 400px;
            object-fit: cover;
            border-radius: 8px;
        }
        .card-text {
            font-size: 0.95rem;
        }
        .card-title {
            font-size: 1.1rem;
            font-weight: 600;
        }
        .price-tag {
            font-size: 1rem;
            font-weight: 600;
        }
        .custom-cart-btn {
            background-color: rgb(159, 40, 88); 
            color: white;
            font-weight: 600;
            border: none;
            border-radius: 7px;
            width: 100%;
            padding: 12px 0;
            margin-top: 10px;
        }
        .custom-cart-btn:hover {
            background-color: rgb(216, 40, 40);
            color: white;
        }

        .btn-outline-danger {
            font-weight: 600;
            border-radius: 7px;
            height: 40px;
            margin-top: 10px;
            width: 100%;
        }

        .btn-outline-danger:hover {
            background-color: rgb(197, 42, 70);
            color: white;
        }
    </style>
</head>
<body>

<?php include 'navbar.php'; ?>

<div class="container mt-5">
    <h2 class="text-center mb-4">Women's Collection</h2>
    <div class="row g-4">
        <?php while ($row = $result->fetch_assoc()): ?>
            <div class="col-sm-6 col-md-4 col-lg-3 d-flex align-items-stretch">
                <div class="card shadow-sm w-100">
                    <!-- Click to Product Details Page -->
                    <a href="product_flash.php?id=<?= $row['id'] ?>">
                        <img src="assets/product_images/<?= htmlspecialchars($row['image']) ?>" class="card-img-top" alt="<?= htmlspecialchars($row['name']) ?>">
                    </a>
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title"><?= htmlspecialchars($row['name']) ?></h5>
                        <p class="text-muted mb-1"><small>Category: <?= htmlspecialchars($row['category']) ?></small></p>
                        <p class="card-text"><?= htmlspecialchars(substr($row['description'], 0, 90)) ?>...</p>
                        <p class="text-primary price-tag mb-2">₹<?= number_format($row['price'], 2) ?></p>

                        <!-- Add to Cart Form -->
                        <form action="add_to_cart_or_wishlist.php" method="POST">
                            <input type="hidden" name="product_id" value="<?= $row['id'] ?>">
                            <input type="hidden" name="size" value="M">
                            <input type="hidden" name="action" value="cart">
                            <button type="submit" class="custom-cart-btn">Add to Cart</button>
                        </form>

                        <!-- Add to Wishlist Form -->
                        <form action="add_to_cart_or_wishlist.php" method="POST">
                            <input type="hidden" name="product_id" value="<?= $row['id'] ?>">
                            <input type="hidden" name="size" value="M">
                            <input type="hidden" name="action" value="wishlist">
                            <button type="submit" class="btn btn-outline-danger">❤️ Add to Wishlist</button>
                        </form>
                    </div>
                </div>
            </div>
        <?php endwhile; ?>
    </div>
</div>

<?php include 'footer.php'; ?>

</body>
</html>
