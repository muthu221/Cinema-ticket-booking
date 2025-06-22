<?php
session_start();
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: login_index.html");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Movie</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-image: url('2314950.webp');
            background-size: cover;
            background-attachment: fixed;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            flex-direction: column;
        }
        .header {
            background-color: #343a40;
            color: white;
            padding: 15px;
            text-align: center;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: fixed;
            width: 100%;
            top: 0;
            left: 0;
            z-index: 1000; /* Ensures the header stays on top of other content */
        }
        .header nav {
            display: flex;
            gap: 15px;
        }
        .header a {
            color: white;
            margin: 0 15px;
            padding-top: 7px;
            text-decoration: none;
        }
        .header a:hover {
            text-decoration: none;
        }
        .container {
            background-color: rgba(255, 255, 255, 0.9);
            padding: 30px;
            border-radius: 20px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.2);
            max-width: 400px;
            width: 100%;
            text-align: center;
            margin-top: 80px; /* Adjusted to provide space for the fixed header */
        }
        .container h1 {
            margin-bottom: 20px;
            font-size: 24px;
            color: #00695c;
        }
        .form-group {
            margin-bottom: 20px;
        }
        .form-group input {
            width: 100%;
            padding: 10px;
            border: none;
            border-radius: 25px;
            background-color: #f1f1f1;
            font-size: 16px;
        }
        .form-group input:focus {
            outline: none;
            background-color: #e1e1e1;
        }
        .btn-primary {
            width: 100%;
            padding: 15px;
            background-color: #00b4aa;
            color: black;
            border: none;
            border-radius: 25px;
            cursor: pointer;
            font-size: 18px;
            font-weight: bold;
            transition: background-color 0.3s;
        }
        .btn-primary:hover {
            background-color: #009688;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Create New Movie</h1>
        <nav>
            <a href="admin_panel.php">Bookings</a>
            <a href="admin_user_details.php">User Details</a>
            <a href="movies.php">Movies</a>
            <a href="logout.php" class="btn btn-outline-light">Logout</a>
        </nav>
    </div>
    <div class="container">
        <form action="process_create.php" method="post">
            <div class="form-group">
                <label for="movie_name">Movie Name:</label>
                <input type="text" class="form-control" id="movie_name" name="movie_name" placeholder="Movie Name" required>
            </div>
            <div class="form-group">
                <label for="date">Date:</label>
                <input type="date" class="form-control" id="date" name="date" required>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
</body>
</html>
