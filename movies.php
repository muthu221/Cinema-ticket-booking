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
    <title>Movies</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
        }
        .header {
            background-color: #343a40;
            color: white;
            padding: 15px;
            text-align: center;
            display: flex;
            justify-content: space-between;
            align-items: center;
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
            margin-top: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            background-color: #fff;
            color: black;
        }
        table, th, td {
            border: 1px solid #ccc;
        }
        th, td {
            text-align: center;
            padding: 10px;
        }
        th {
            background-color: #f2f2f2;
        }
        .btn-create {
            margin-bottom: 20px;
        }
        .btn-delete {
            background-color: #dc3545;
            color: white;
            border: none;
            border-radius: 5px;
            padding: 5px 10px;
            cursor: pointer;
            font-size: 14px;
        }
        .btn-delete:hover {
            background-color: #c82333;
            color: white;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Movies List</h1>
        <nav>
            <a href="admin_panel.php">Bookings</a>
            <a href="admin_user_details.php">User Details</a>
            <a href="movies.php">Movies</a>
            <a href="logout.php" class="btn btn-outline-light">Logout</a>
        </nav>
    </div>
    <div class="container">
        <div class="text-right">
            <a href="create_movie.php" class="btn btn-primary btn-create">Create New Movie</a>
        </div>
        <h2>All Movies</h2>
        <table>
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Movie</th>
                    <th>Action</th> <!-- New column for actions -->
                </tr>
            </thead>
            <tbody>
                <?php
                // Database connection parameters
                $servername = "localhost";
                $username = "root"; // Replace with your database username
                $password = ""; // Replace with your database password
                $dbname = "ticket_booking"; // Replace with your database name

                // Create connection
                $conn = new mysqli($servername, $username, $password, $dbname);

                // Check connection
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                // Prepare SQL statement to fetch all movies
                $sql = "SELECT id, date, movie FROM movies";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    // Output data of each row
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>".$row["date"]."</td>
                                <td>".$row["movie"]."</td>
                                <td>
                                    <a href='delete_movie.php?id=".$row["id"]."' class='btn btn-delete'>Delete</a>
                                </td>
                            </tr>";
                    }
                } else {
                    echo "<tr><td colspan='3'>No movies found</td></tr>";
                }

                // Close connection
                $conn->close();
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>
