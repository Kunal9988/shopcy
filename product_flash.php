<?php
include 'includes/connection.php';
include 'navbar.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo "<h2 style='text-align:center;'>Invalid product ID.</h2>";
    exit();
}

$product_id = $_GET['id'];

$stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
$stmt->bind_param("i", $product_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "<h2 style='text-align:center;'>Product not found.</h2>";
    exit();
}

$product = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($product['name']) ?> | Shopcy</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .product-container {
            display: flex;
            justify-content: center;
            align-items: flex-start;
            padding: 60px 20px;
        }
        .product-image {
            width: 400px;
            height: 400px;
            object-fit: contain;
            border-radius: 12px;
            border: 1px solid #ccc;
            margin-right: 50px;
            background-color: #fff;
            padding: 15px;
        }
        .product-info {
            max-width: 600px;
            background: #fff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
        }
        .product-info h2 {
            font-size: 28px;
            margin-bottom: 15px;
        }
        .product-info p {
            font-size: 16px;
            margin-bottom: 10px;
        }
        .price {
            font-size: 24px;
            color: #28a745;
            font-weight: bold;
        }
        .add-to-cart-btn {
            padding: 10px 20px;
            background-color: #b6255d;
            color: white;
            border: none;
            font-size: 16px;
            border-radius: 6px;
            cursor: pointer;
            margin-right: 10px;
        }
        .add-to-cart-btn:hover {
            background-color: #a51f50;
        }
        select[name="size"] {
            padding: 6px 12px;
            margin-bottom: 15px;
            margin-top: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
            font-size: 15px;
        }
    </style>
</head>
<body>

<div class="container product-container">
    <img src="assets/product_images/<?= htmlspecialchars($product['image']) ?>" alt="<?= htmlspecialchars($product['name']) ?>" class="product-image">

    <div class="product-info">
        <h2><?= htmlspecialchars($product['name']) ?></h2>
        <p class="price">₹<?= number_format($product['price'], 2) ?></p>
        <p><strong>Gender:</strong> <?= htmlspecialchars($product['gender']) ?></p>
        <p><strong>Category:</strong> <?= htmlspecialchars($product['category']) ?></p>
        <p><strong>Description:</strong><br> <?= htmlspecialchars($product['description']) ?></p>

        <form method="post" action="add_to_cart_or_wishlist.php">
            <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
            
            <label for="size"><strong>Select Size:</strong></label><br>
            <select name="size" required>
                <option value="">-- Select Size --</option>
                <option value="S">S</option>
                <option value="M">M</option>
                <option value="L">L</option>
                <option value="XL">XL</option>
            </select><br>

            <button type="submit" name="action" value="cart" class="add-to-cart-btn">Add to Cart</button>
            <button type="submit" name="action" value="wishlist" class="add-to-cart-btn">Add to Wishlist</button>
        </form>
    </div>
</div>

<?php include 'footer.php'; ?>
</body>
</html>
