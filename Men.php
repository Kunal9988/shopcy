<?php
include 'includes/connection.php';

// Fetch only men's products
$sql = "SELECT * FROM products WHERE gender = 'men'";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Men's Products</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .product-card {
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
            border-radius: 10px;
            padding: 15px;
            margin-bottom: 20px;
            text-align: center;
            height: auto%;
        }
        .product-card:hover {
            transform: translateY(-5px);
        }
        .product-image {
            height: 400px;
            /* width: 100%; */
            object-fit: cover;
            border-radius: 8px;
        }
        .product-card:hover {
            transform: translateY(-5px);
        }
        .product-card-text {
            font-size: 0.95rem;
        }
        .product-card-title {
            font-size: 1.1rem;
            font-weight: 600;
        }
        .price-tag {
            font-size: 1rem;
        }
        .custom-cart-btn {
            background-color: rgb(159, 40, 88); 
            color: white;
            font-weight: 600;
            border: none;
            border-radius: 7px;
            width: 100%;
            padding: 10px 0;
            margin-top: 10px;
        }
        .custom-cart-btn:hover {
            background-color: rgb(216, 40, 40);
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
    <h2 class="text-center mb-4">Men's Collection</h2>
    <div class="row">
        <?php while ($row = $result->fetch_assoc()): ?>
            <div class="col-md-4 d-flex align-items-stretch">
                <div class="product-card w-100 d-flex flex-column justify-content-between">
                    <img src="assets/product_images/<?= htmlspecialchars($row['image']) ?>" class="product-image" alt="<?= htmlspecialchars($row['name']) ?>">
                    <div class="mt-3">
                        <h5><?= htmlspecialchars($row['name']) ?></h5>
                        <p>₹<?= number_format($row['price'], 2) ?></p>
                        <p class="text-muted"><?= htmlspecialchars($row['category']) ?></p>

                        <form action="add_to_cart.php" method="POST">
                            <input type="hidden" name="product_id" value="<?= $row['id'] ?>">
                            <button type="submit" class="custom-cart-btn">Add to Cart</button>
                        </form>

                        <form action="add_to_wishlist.php" method="POST">
                            <input type="hidden" name="product_id" value="<?= $row['id'] ?>">
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
