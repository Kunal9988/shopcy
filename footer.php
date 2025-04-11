<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        

        .fa-instagram {
            padding: 20px;
            font-size: 30px;
            width: 70px;
            text-align: center;
            text-decoration: none;
            border-radius: 70%;
            background: radial-gradient(circle at 30% 110%,
                    #ffdb8b 0%,
                    #ee653d 25%,
                    #d42e81 50%,    
                    #a237b6 75%,
                    #3e57bc 100%);
            color: white;
        }
        .fa-youtube{
            padding: 20px;
            font-size: 30px;
            width: 70px;
            text-align: center;
            text-decoration: none;
            border-radius: 70%;
            background:rgb(219, 17, 17);
            color: white;
        }
    </style>
</head>

<body>
    <footer class="bg-dark text-light pt-4" style=" bottom: 0; width: 100%;">
        <div class="container">
            <div class="row mb-4">
                <div class="col-12 mb-3">
                    <h5>Shop Style Enjoy.</h5>
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <a href="home.php" class="btn btn-outline-light">Get Started</a>
                    <?php else: ?>
                        <!-- <button class="btn btn-outline-light" onclick="alert('Please log in to create a community!');">Create Community</button> -->
                    <?php endif; ?>
                </div>
            </div>
            <div class="row">

                <!-- Your Account Column -->
                <div class="col-6 col-md-3 mb-3">
                    <h6><a href="#" class="text-light text-decoration-none">Your Account</a></h6>
                    <ul class="list-unstyled">
                        <?php if (isset($_SESSION['user_id'])): ?>
                            <li><a href="user_login.php" class="text-light text-decoration-none">Logout</a></li>
                        <?php else: ?>
                            <li><a href="user_signup.php" class="text-light text-decoration-none">Sign up</a></li>
                            <li><a href="user_login.php" class="text-light text-decoration-none">Log in</a></li>
                        <?php endif; ?>
                    </ul>
                </div>

                

                <!-- Meetup Column -->
                <div class="col-6 col-md-3 mb-3">
                <a href="home.php" class="text-light text-decoration-none">Shopcy</a>
                    
                </div>

                <!-- Social and App Links Column -->
                <!-- Social and App Links Column -->
                <div class="col-6 col-md-3 text-center">
                    <h6>Follow us</h6>
                    <div class="d-flex justify-content-center gap-2 mb-3">
                        <ul class="list-inline">
                            
                            <li class="list-inline-item"><a href="#" class="text-light"><i class="fa fa-instagram"></i></a></li>
                            <li class="list-inline-item"><a href="#" class="text-light"><i class="fa fa-youtube"></i></a></li>
                        </ul>

                    </div>

            </div>

                </div>
            </div>
            <div class="row mt-4 border-top pt-3">
                <div class="col-12 text-center">
                    <p>&copy; 2025 Shopcy | <a href="#" class="text-light text-decoration-none">Terms of Service</a> | <a href="#" class="text-light text-decoration-none">Privacy Policy</a> | <a href="#" class="text-light text-decoration-none">Cookie Policy</a></p>
                </div>
            </div>
        </div>
    </footer>

</body>

</html>