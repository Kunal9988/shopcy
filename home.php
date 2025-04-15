<?php include 'includes/connection.php'; ?>
<?php include 'navbar.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Shopcy Home</title>
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
        #hero {
            background-image: url("./assets/banners/banner1.jpg");
            height: 90vh;
            width: 100%;
            background-size: cover;
            background-position: center;
            padding: 0 80px;
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            justify-content: center;
            color: #fff;
            text-shadow: 1px 1px 3px rgba(0,0,0,0.7);
        }
        #hero h1, #hero h2, #hero h4, #hero p {
            margin: 0;
        }
        #hero button {
            background-color: rgba(236, 228, 228, 0.8);
            color: #333;
            border: none;
            padding: 12px 30px;
            margin-top: 20px;
            font-weight: 600;
            border-radius: 5px;
            transition: background 0.3s ease;
        }
        #hero button:hover {
            background-color: rgb(141, 109, 115);
            color: #000;
        }
        #hero2 {
            background-image: url("./assets/banners/banner2.jpg");
            height: 90vh;
            width: 100%;
            background-size: cover;
            background-position: center;
            padding: 0 80px;
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            justify-content: center;
            color: #fff;
            text-shadow: 1px 1px 3px rgba(0,0,0,0.7);
        }
        #hero2 h1, #hero h2, #hero h4, #hero p {
            margin: 0;
        }
        #hero2 button {
            background-color: rgba(236, 228, 228, 0.8);
            color: #333;
            border: none;
            padding: 12px 30px;
            margin-top: 20px;
            font-weight: 600;
            border-radius: 5px;
            transition: background 0.3s ease;
        }
        #hero2 button:hover {
            background-color: rgb(141, 109, 115);
            color: #000;
        }

        .custom-cart-btn {
            background-color: rgb(159, 40, 88); 
            color: white;
            font-weight: 600;
            border: none;
            border-radius: 7px;
            text-align: center;
            display: inline-block;
            width: 100%;
            padding: 12px 0;
            margin-top: 10px;
            height: 40px;
            text-decoration: none;
        }

        .custom-cart-btn:hover {
            background-color: rgb(216, 40, 40);
            color: white;
        }

        .custom-viewdetails-btn {
            background-color: rgb(197, 42, 70);
            color: white;
            font-weight: 600;
            border: none;
            border-radius: 7px;
            text-align: center;
            display: inline-block;
            width: 100%;
            padding: 10px 0;
            height: 40px;
            text-decoration: none;
        }

        .custom-viewdetails-btn:hover {
            background-color: rgb(232, 80, 80);
            color: white;
        }

        .btn-outline-danger {
            font-weight: 600;
            border-radius: 7px;
            height: 40px;
            margin-top: 10px;
        }

        .btn-outline-danger:hover {
            background-color: rgb(197, 42, 70);
            color: white;
        }
    </style>
</head>
<body>

<!-- Hero Section -->
<section id="hero">
    <h4>Trade In Offer</h4>
    <h2>Super Deals</h2>
    <h1>On All Events</h1>
    <p>Apply coupon & get up to 50% off!</p>
    <button>Shop Now</button>
</section>

<!-- Feature Block Section -->
<section class="feature-block py-5" style="background-color: #fff; padding-left: 40px; padding-right: 40px;">
  <div class="container">
    <h2 class="text-center mb-4">Our Collections</h2>
    <div class="row g-4 text-center">
      
      <!-- Traditional Wear Collection -->
      <div class="col-6 col-md-3">
        <div class="card border-0">
          <img src="assets/features_banner/traditional.jpg" class="card-img-top" alt="Traditional Collection" style="height: 300px; object-fit: cover;">
          <div class="card-body">
            <h5 class="card-title fw-bold">Traditional Collection</h5>
            <p class="card-text">Grab our traditional wear for every occasion.</p>
            <a href="traditional_collection.php" class="btn btn-dark">Explore Now</a>
          </div>
        </div>
      </div>
      
      <!-- Casual Wear Collection -->
      <div class="col-6 col-md-3">
        <div class="card border-0">
          <img src="assets/features_banner/Casual_Wear.jpg" class="card-img-top" alt="Casual Wear Collection" style="height: 300px; object-fit: cover;">
          <div class="card-body">
            <h5 class="card-title fw-bold">Casual Wear Collection</h5>
            <p class="card-text">Perfect for outings.</p>
            <a href="Casual_Wear_collection.php" class="btn btn-dark">Explore Now</a>
          </div>
        </div>
      </div>
      
      <!-- Suits-Formals Collection -->
      <div class="col-6 col-md-3">
        <div class="card border-0">
          <img src="assets/features_banner/Suits-formals.jpg" class="card-img-top" alt="Suits-Formals Collection" style="height: 300px; object-fit: cover;">
          <div class="card-body">
            <h5 class="card-title fw-bold">Suits-Formals Collection</h5>
            <p class="card-text">Elevate your style with suits and formals.</p>
            <a href="Suits-formals_collection.php" class="btn btn-dark">Explore Now</a>
          </div>
        </div>
      </div>
      
      <!-- Shadi Collection -->
      <div class="col-6 col-md-3">
        <div class="card border-0">
          <img src="assets/features_banner/Shadi1.jpg" class="card-img-top" alt="Shadi Collection" style="height: 300px; object-fit: cover;">
          <div class="card-body">
            <h5 class="card-title fw-bold">Shadi Collection</h5>
            <p class="card-text">Elegant or extravagant, our Shadi Collection ensures you shine on your special day.</p>
            <a href="Shadi_collection.php" class="btn btn-dark">Explore Now</a>
          </div>
        </div>
      </div>
      
    </div>
  </div>
</section>

<section id="hero2">
    <!-- <h4>Trade In Offer</h4>
    <h2>Super Deals</h2>
    <h1>On All Events</h1>
    <p>Apply coupon & get up to 50% off!</p>
    <button>Shop Now</button> -->
</section>



<!-- Product Listing -->
<div class="container mt-5">
    <h2 class="text-center mb-4">Our Products</h2>
    <div class="row g-4">
        <?php
        $sql = "SELECT * FROM products";
        $result = $conn->query($sql);

        while($row = $result->fetch_assoc()) {
            echo '
            <div class="col-sm-6 col-md-4 col-lg-3 d-flex align-items-stretch" style="padding-block-end: 50px">
                <div class="card shadow-sm w-100">
                
<a href="product_page.php?id=' . $row['id'] . '">
    <img src="assets/product_images/' . $row['image'] . '" class="card-img-top" alt="' . htmlspecialchars($row['name']) . '">
</a>


                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">' . htmlspecialchars($row['name']) . '</h5>
                        <p class="text-muted mb-1"><small>Category: ' . htmlspecialchars($row['category']) . '</small></p>
                        <p class="card-text">' . htmlspecialchars(substr($row['description'], 0, 90)) . '...</p>
                        <p class="text-primary price-tag mb-2">₹' . htmlspecialchars($row['price']) . '</p>
                        
                        <form action="add_to_cart.php" method="POST">
                            <input type="hidden" name="product_id" value="' . $row['id'] . '">
                            <button type="submit" class="custom-cart-btn">Add to Cart</button>
                        </form>

                        <form action="add_to_wishlist.php" method="POST" style="margin-top: 5px;">
                            <input type="hidden" name="product_id" value="' . $row['id'] . '">
                            <button type="submit" class="btn btn-outline-danger w-100">❤️ Add to Wishlist</button>
                        </form>
                    </div>
                </div>
            </div>';
        }
        ?>
    </div>
</div>

<?php include 'footer.php'; ?>
</body>
</html>
