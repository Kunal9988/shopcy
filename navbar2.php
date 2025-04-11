<?php 
session_start(); 

// Get cart count
$cart_count = 0;
if (isset($_SESSION['cart']) && is_array($_SESSION['cart'])) {
    $cart_count = array_sum(array_column($_SESSION['cart'], 'quantity'));
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Navbar</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="./CSS/home.css">
    <link href="https://fonts.googleapis.com/css2?family=Young+Serif&display=swap" rel="stylesheet">
    <style>
        .container {
            font-family: "Young Serif", serif;
        }

        .news-ticker {
            background: rgb(182, 37, 93);
            color: white;
            padding: 8px;
            overflow: hidden;
            white-space: nowrap;
            position: relative;
            font-weight: bold;
        }

        .news-ticker .ticker-content {
            display: inline-block;
            white-space: nowrap;
            animation: ticker-scroll 15s linear infinite;
        }

        @keyframes ticker-scroll {
            from {
                transform: translateX(100%);
            }

            to {
                transform: translateX(-100%);
            }
        }
    </style>
</head>

<body>

    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <a class="navbar-brand" href="home.php">
                <img src="./assets/shopcylogo.png" alt="Shopcy Logo" width="170" height="100">
            </a>
            <h5>Buy.Style.Enjoy!</h5>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link fw-bold text-dark" href="home.php">Home</a></li>
                    <li class="nav-item"><a class="nav-link fw-bold text-dark" href="Men.php">Men</a></li>
                    <li class="nav-item"><a class="nav-link fw-bold text-dark" href="women.php">Women</a></li>

                    <?php if (isset($_SESSION['user_id'])): ?>
                        <li class="nav-item"><a class="nav-link fw-bold text-dark" href="profile.php">Profile</a></li>
                    <?php else: ?>
                        <li class="nav-item">
                            <a class="nav-link fw-bold text-dark" href="#" data-bs-toggle="modal" data-bs-target="#loginModal">Profile</a>
                        </li>
                    <?php endif; ?>

                    <li class="nav-item">
                        <a class="nav-link fw-bold text-dark" href="cart.php">
                            Cart (<?= $cart_count ?>)
                        </a>
                    </li>

                    <?php if (!isset($_SESSION['user_id'])): ?>
                        <li class="nav-item">
                            <a class="nav-link btn btn-primary ms-2 fw-bold text-dark" href="user_login.php">Login</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link btn btn-secondary ms-2 fw-bold text-dark" href="user_signup.php">Signup</a>
                        </li>
                    <?php else: ?>
                        <li class="nav-item">
                            <a class="nav-link btn btn-danger ms-2 fw-bold text-dark" href="user_logout.php">Logout</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Modal for Not Logged In -->
    <div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="loginModalLabel">Oops !!!</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p><strong>You need to log in to view your profile.</strong></p>
                </div>
                <div class="modal-footer">
                    <a href="user_login.php" class="btn btn-primary">Login</a>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <div class="news-ticker">
        <div class="ticker-content">
            All the Product are verified ✅ | Buy your Favourite Products! 🎵 | Buy now!! 📢
        </div>
    </div>

</body>

</html>
