<?php
include 'includes/connection.php';

$query = isset($_GET['query']) ? trim($_GET['query']) : '';

if (empty($query)) {
    echo "<h2 style='text-align:center;'>No search term provided.</h2>";
    exit();
}

$stmt = $conn->prepare("SELECT * FROM products WHERE name LIKE ?");
$searchTerm = "%" . $query . "%";
$stmt->bind_param("s", $searchTerm);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Search Results for "<?php echo htmlspecialchars($query); ?>"</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .product-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 40px;
        }

        .product-detail {
            display: flex;
            flex-direction: row;
            gap: 40px;
            border: 1px solid #ddd;
            padding: 30px;
            border-radius: 12px;
            width: 80%;
            background-color: #fff;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            margin-bottom: 30px;
        }

        .product-detail img {
            width: 350px;
            height: 350px;
            object-fit: contain;
            border-radius: 10px;
        }

        .product-info {
            flex: 1;
        }

        .product-info h2 {
            font-size: 26px;
            margin-bottom: 10px;
        }

        .product-info p {
            font-size: 16px;
            margin: 8px 0;
        }

        .price {
            font-size: 22px;
            color: green;
            font-weight: bold;
            margin: 12px 0;
        }

        .add-to-cart-btn {
            padding: 10px 20px;
            background-color:rgb(203, 15, 78);
            color: white;
            border: none;
            font-size: 16px;
            border-radius: 6px;
            cursor: pointer;
        }

        .add-to-cart-btn:hover {
            background-color:rgb(230, 0, 119);
        }

        select[name="size"] {
            padding: 6px 10px;
            margin-right: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
            font-size: 14px;
        }
    </style>
</head>
<body>
<?php include 'navbar.php'; ?>
<h2 style="text-align:center;">Search Results for "<?php echo htmlspecialchars($query); ?>"</h2>

<div class="product-container">
    <?php
    if ($result->num_rows > 0) {
        while ($product = $result->fetch_assoc()) {
    ?>
        <div class="product-detail">
            <img src="<?php echo 'assets/product_images/' . htmlspecialchars($product['image']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>">
            <div class="product-info">
                <h2><?php echo htmlspecialchars($product['name']); ?></h2>
                <p class="price">₹<?php echo number_format($product['price'], 2); ?></p>
                <p><strong>Gender:</strong> <?php echo htmlspecialchars($product['gender']); ?></p>
                <p><strong>Category:</strong> <?php echo htmlspecialchars($product['category']); ?></p>
                <p><strong>Description:</strong> <?php echo htmlspecialchars($product['description']); ?></p>

                <!-- Size Selection (Shared for both Add to Cart and Wishlist) -->
                <form method="post" action="add_to_cart_or_wishlist.php" style="display:inline;">
                    <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                    
                    <!-- Size Selection Dropdown -->
                    <label for="size">Size:</label>
                    <select name="size" required>
                        <option value="">Select Size</option>
                        <option value="S">S</option>
                        <option value="M">M</option>
                        <option value="L">L</option>
                        <option value="XL">XL</option>
                    </select>
                    
                    <!-- Buttons for Cart and Wishlist Actions -->
                    <button type="submit" name="action" value="cart" class="add-to-cart-btn">Add to Cart</button>
                    <button type="submit" name="action" value="wishlist" class="add-to-cart-btn">Add to Wishlist</button>
                </form>
            </div>
        </div>
    <?php
        }
    } else {
        echo "<p style='text-align:center;'>No products found for \"$query\".</p>";
    }
    ?>
</div>

<?php include 'footer.php'; ?>
</body>
</html>
