<?php include 'includes/connection.php'; ?>
<?php include 'navbar.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Shopcy Home</title>
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

<!-- Hero Banner -->
<section id="hero" style="background: url('./assets/banners/banner1.jpg') center/cover no-repeat; height: 90vh; display: flex; flex-direction: column; justify-content: center; padding: 0 80px; color: #fff; text-shadow: 1px 1px 3px rgba(0,0,0,0.7);">
    <h4>Trade In Offer</h4>
    <h2>Super Deals</h2>
    <h1>On All Events</h1>
    <p>Apply coupon & get up to 50% off!</p>
    <button class="btn btn-light">Shop Now</button>
</section>

<!-- Collections -->
<section class="py-5 bg-white">
    <div class="container">
        <h2 class="text-center mb-4">Our Collections</h2>
        <div class="row g-4 text-center">
            <?php
            $collections = [
                ["Traditional Collection", "traditional.jpg", "traditional_collection.php"],
                ["Casual Wear Collection", "Casual_Wear.jpg", "Casual_Wear_collection.php"],
                ["Suits-Formals Collection", "Suits-formals.jpg", "Suits-formals_collection.php"],
                ["Shadi Collection", "Shadi1.jpg", "Shadi_collection.php"]
            ];
            foreach ($collections as [$title, $img, $link]) {
                echo "
                <div class='col-6 col-md-3'>
                    <div class='card border-0'>
                        <img src='assets/features_banner/$img' class='card-img-top' style='height: 300px; object-fit: cover;'>
                        <div class='card-body'>
                            <h5 class='fw-bold'>$title</h5>
                            <p class='card-text'>Discover our $title.</p>
                            <a href='$link' class='btn btn-dark'>Explore Now</a>
                        </div>
                    </div>
                </div>";
            }
            ?>
        </div>
    </div>
</section>

<!-- Product Listing -->
<div class="container mt-5">
    <h2 class="text-center mb-4">Our Products</h2>
    <div class="row g-4">
        <?php
        $sql = "SELECT * FROM products";
        $result = $conn->query($sql);
        while($row = $result->fetch_assoc()):
        ?>
            <div class="col-sm-6 col-md-4 col-lg-3 d-flex align-items-stretch">
                <div class="card shadow-sm w-100">
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
