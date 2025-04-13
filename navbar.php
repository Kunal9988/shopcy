    <?php 
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    // Count cart items
    $cart_count = isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0;

    // Count wishlist items
    $wishlist_count = isset($_SESSION['wishlist']) ? count($_SESSION['wishlist']) : 0;
    ?> 
    <!DOCTYPE html>
    <html lang="en">
    <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopcy</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    
    <!-- jQuery & jQuery UI (for autocomplete) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    
    <!-- Google Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Young+Serif&display=swap" rel="stylesheet">
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="./CSS/home.css">
    
    <style>
        .container { font-family: "Young Serif", serif; }
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
        from { transform: translateX(100%); }
        to { transform: translateX(-100%); }
        }
        .badge { font-size: 0.7rem; }
        
        /* Style for the search input in the navbar */
        .navbar .form-inline {
        margin-left: 20px;
        }
        #searchInput {
        border: 1px solid #ccc;
        border-radius: 4px;
        padding: 5px 10px;
        }
        /* Adjust jQuery UI Autocomplete width */
        .ui-autocomplete {
        max-height: 300px;
        overflow-y: auto;
        /* prevent horizontal scrollbar */
        overflow-x: hidden;
        z-index: 1051; /* higher than Bootstrap modal */
        }

        #searchForm {
    margin-left: auto;
    margin-right: auto;
    width: 300px;
    }

    </style>
    
    <!-- jQuery UI Autocomplete Script -->
    <script>
        $(document).ready(function(){
        $("#searchInput").autocomplete({
            source: function(request, response) {
            $.ajax({
                url: "search.php", // <-- Create this file to search the DB
                type: "GET",
                dataType: "json",
                data: { term: request.term },
                success: function(data) {
                response(data);
                }
            });
            },
            select: function(event, ui) {
            // Redirect to product detail page or search results page if desired:
            window.location.href = "product_page.php?query=" + ui.item.value;
            },
            minLength: 2
        });
        });
    </script>
    </head>
    <body>
    <nav class="navbar navbar-expand-lg">
        <div class="container">
        <a class="navbar-brand" href="home.php">
            <img src="./assets/shopcylogo.png" alt="Shopcy Logo" width="170" height="100">
        </a>
        <h5><br>Buy.Style.Enjoy!</h5>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
        <form class="d-flex ms-4 me-auto" role="search" id="searchForm">
    <input id="searchInput" class="form-control me-2" type="search" placeholder="Search products..." aria-label="Search">
    </form>


    </div>


        
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto align-items-center">
            <!-- <li class="nav-item mx-2">
                <a class="nav-link text-dark fs-4" href="home.php" title="Home">
                <i class="bi bi-house-door-fill"></i>
                </a>
            </li> -->
            <li class="nav-item mx-2">
                <a class="nav-link text-dark fs-4" href="men.php" title="Men">
                <i class="bi bi-gender-male"></i>
                </a>
            </li>
            <li class="nav-item mx-2">
                <a class="nav-link fs-4" href="women.php" title="Women">
                <i class="bi bi-gender-female"></i>
                </a>
            </li>
            
            <!-- Cart with badge -->
            <li class="nav-item mx-2 position-relative">
                <a class="nav-link text-dark fs-4" href="cart.php" title="Cart">
                <i class="bi bi-cart3"></i>
                <?php if ($cart_count > 0): ?>
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                    <?= $cart_count ?>
                    </span>
                <?php endif; ?>
                </a>
            </li>
            <!-- Wishlist with badge -->
            <li class="nav-item mx-2 position-relative">
                <a class="nav-link text-dark fs-4" href="wishlist.php" title="Wishlist">
                <i class="bi bi-heart"></i>
                <?php if ($wishlist_count > 0): ?>
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-success">
                    <?= $wishlist_count ?>
                    </span>
                <?php endif; ?>
                </a>
            </li>
            <!-- Profile -->
            <li class="nav-item mx-2">
                <a class="nav-link text-dark fs-4" href="<?= isset($_SESSION['user_id']) ? 'profile.php' : '#' ?>" 
                title="Profile" 
                <?= !isset($_SESSION['user_id']) ? 'data-bs-toggle="modal" data-bs-target="#loginModal"' : '' ?>>
                <i class="bi bi-person-circle"></i>
                </a>
            </li>
            <!-- Auth Buttons -->
            <?php if (!isset($_SESSION['user_id'])): ?>
                <li class="nav-item mx-1">
                <a class="nav-link btn btn-primary ms-2 fw-bold" href="user_login.php">Login</a>
                </li>
                <li class="nav-item mx-1">
                <a class="nav-link btn btn-secondary ms-2 fw-bold" href="user_signup.php">Signup</a>
                </li>
            <?php else: ?>
                <li class="nav-item mx-1">
                <a class="nav-link btn btn-danger ms-2 fw-bold" href="user_logout.php">Logout</a>
                </li>
            <?php endif; ?>
            </ul>
        </div>
        </div>
    </nav>
    
    <!-- Login Modal -->
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
    
    <!-- News Ticker -->
    <div class="news-ticker">
        <div class="ticker-content">
        All the Product are verified ✅ | Buy your Favourite Products! 🎵 | Buy now!! 📢
        </div>
    </div>
    
    <!-- Bootstrap Bundle JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    </body>
    </html>
