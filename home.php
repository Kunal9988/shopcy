<?php include 'includes/connection.php'; ?>
<?php include 'navbar.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Our Products</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f9f9f9;
        }
        .card {
            height: 100%;
            transition: transform 0.2s ease;
        }
        .card:hover {
            transform: translateY(-5px);
        }
        .card-img-top {
            height: 200px;
            object-fit: cover;
        }
        .card-text {
            max-height: 60px;
            overflow: hidden;
            text-overflow: ellipsis;
            font-size: 0.95rem;
        }
        .card-title {
            font-size: 1.1rem;
            font-weight: 600;
        }
        .price-tag {
            font-size: 1rem;
            font-weight: 500;
        }
    </style>
</head>
<body>

<div class="container mt-5">
    <h2 class="text-center mb-4">Our Products</h2>
    <div class="row g-4">
        <?php
        $sql = "SELECT * FROM products";
        $result = $conn->query($sql);

        while($row = $result->fetch_assoc()) {
            echo '
            <div class="col-sm-6 col-md-4 col-lg-3">
                <div class="card h-100 shadow-sm">
                    <img src="assets/product_images/' . $row['image'] . '" class="card-img-top" alt="' . $row['name'] . '">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">' . $row['name'] . '</h5>
                        <p class="card-text">' . substr($row['description'], 0, 90) . '...</p>
                        <p class="text-primary price-tag mb-2">₹' . $row['price'] . '</p>
                        <a href="product_detail.php?id=' . $row['id'] . '" class="btn btn-success mt-auto">View Details</a>
                    </div>
                </div>
            </div>';
        }
        ?>
    </div>
</div>

</body>
</html>
