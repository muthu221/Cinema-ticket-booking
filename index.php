<?php
session_start();
$isLoggedIn = isset($_SESSION['email']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CiniBook</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <header class="bg-dark text-white p-3 d-flex justify-content-between align-items-center">
        <a href="index.php" class="text-decoration-none"><h1 class="m-0 text-white">CiniBook</h1></a>
        <nav>
            <?php if ($isLoggedIn): ?>
                <a href="index.php" class="text-white">Home</a>
                <a href="new.html" class="text-white">New Movies</a>
                <a href="my_book.php" class="text-white">My Booking</a>
            <?php endif; ?>
        </nav>
        <div class="d-flex">
            <?php if ($isLoggedIn): ?>
                <a href="logout.php" class="btn btn-outline-light">Logout</a>
            <?php else: ?>
                <a href="login.html" class="btn btn-outline-light">Login</a>
            <?php endif; ?>
        </div>
    </header>

    <div class="hero-section">
        <img src="cara.jpg" alt="Cars Mart" class="responsive-image">
        <div class="hero-text">
            <h1>CiniBook</h1>
            <p>Your premier destination for the best selection of movies from around the world.</p>
            <?php if ($isLoggedIn): ?>
                <a href="book_now.html" class="btn btn-primary">Book Now!</a>
                <a href="new.html" class="btn btn-outline-light">Explore Movies</a>
            <?php else: ?>
                <a href="login_index.html" class="btn btn-primary">Login to Book</a>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
