<?php include 'includes/connection.php'; ?>
<?php include 'navbar.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Men's Products</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f9f9f9; }
        .card { transition: transform 0.2s ease; }
        .card:hover { transform: translateY(-5px); }
        .card-img-top {
            height: 400px;
            object-fit: cover;
            border-radius: 8px;
        }
        .price-tag { font-weight: 600; }
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
        }
        .btn-outline-danger {
            font-weight: 600;
            border-radius: 7px;
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


<!-- Product Listing -->
<div class="container mt-5">
    <h2 class="text-center mb-4">Men's Collection</h2>
    <div class="row g-4">
        <?php
        $sql = "SELECT * FROM products WHERE gender = 'men'";
        $result = $conn->query($sql);
        while($row = $result->fetch_assoc()):
        ?>
            <div class="col-sm-6 col-md-4 col-lg-3 d-flex align-items-stretch">
                <div class="card shadow-sm w-100">
                    <!-- Link image to the flash screen page with product details -->
                    <a href="product_flash.php?id=<?= $row['id'] ?>">
                        <img src="assets/product_images/<?= $row['image'] ?>" class="card-img-top" alt="<?= htmlspecialchars($row['name']) ?>">
                    </a>
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title"><?= htmlspecialchars($row['name']) ?></h5>
                        <p class="text-muted mb-1"><small>Category: <?= htmlspecialchars($row['category']) ?></small></p>
                        <p class="card-text"><?= htmlspecialchars(substr($row['description'], 0, 90)) ?>...</p>
                        <p class="text-primary price-tag">₹<?= number_format($row['price']) ?></p>

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
