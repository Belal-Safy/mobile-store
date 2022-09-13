<!DOCTYPE html>
<html lang="ar">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>mobile shop</title>
    <link rel="stylesheet" href="css/fonts/google-fonts.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.2.0/aos.css" />
    <link rel="stylesheet" href="css/all.min.css">
    <link rel="stylesheet" href="css/main.css">
    <link rel="icon" href="favicon.ico?v=2" type="image/x-icon" />
</head>

<body>
    <?php include "loader.php" ?>
    <header class="fixed-top">
        <nav class="navbar navbar-expand-lg bg-light">
            <div class="container bg-light">
                <div class="logo">
                    <a class="navbar-brand" href="index.php">
                        <img id="logo-img" src="images/logo.png" alt="logo">
                    </a>
                    <a class="navbar-brand logo-p" href="index.php">Mobile Shop</a>
                </div>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0 text-center">
                        <li class="nav-item">
                            <a class="nav-link a-scale" aria-current="page" href="index.php#intro"
                                data-link="intro">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link a-scale" href="index.php#features" data-link="features">Our Features</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link a-scale" href="index.php#last-phones" data-link="last-phones">Latest
                                phones</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                Categories
                            </a>
                            <!-- brands  -->
                            <ul class="dropdown-menu dropdown-menu-light">
                                <li><a class="dropdown-item" href="category.php?brand=Huawei">Huawei</a></li>
                                <li><a class="dropdown-item" href="category.php?brand=Xiaomi">Xiaomi</a></li>
                                <li><a class="dropdown-item" href="category.php?brand=Samsung">Samsung</a></li>
                                <li><a class="dropdown-item" href="category.php?brand=Nokia">Nokia</a></li>
                                <li><a class="dropdown-item" href="category.php?brand=Realme">Realme</a></li>
                            </ul>
                        </li>
                    </ul>
                    <div class="d-flex justify-content-center">
                        <a href="cart.php" data-bs-toggle="tooltip" data-bs-placement="bottom"
                            data-bs-title="Go to Cart">
                            <i class="fa-solid fa-cart-shopping text-dark"></i>
                        </a>
                        <div>
                            <a id="profile-btn" <?php if(!isset($_SESSION["user_id"])) echo 'class="d-none"' ?>
                                href="profile.php">
                                <i class="fa-solid fa-user text-dark"></i>
                            </a>
                            <a id="login-btn" <?php if(isset($_SESSION["user_id"])) echo 'class="d-none"' ?>
                                href="login.php">
                                <button type="button" class="btn btn-warning">Login</button>
                            </a>
                        </div>

                    </div>
                </div>
            </div>
        </nav>
    </header>