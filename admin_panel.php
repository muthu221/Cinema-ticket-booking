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
    <title>Admin Dashboard</title>
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
    </style>
</head>
<body>
    <div class="header">
        <h1>Admin Dashboard</h1>
        <nav>
            <a href="admin_panel.php">Bookings</a>
            <a href="admin_user_details.php">User Details</a>
            <a href="movies.php">Movies</a> <!-- Added link for Movies -->
            <a href="logout.php" class="btn btn-outline-light">Logout</a>
        </nav>
    </div>
    <div class="container">
        <h2>All Bookings</h2>
        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Phone Number</th>
                    <th>Email</th>
                    <th>Date</th>
                    <th>Seat Number</th>
                    <th>Movie</th>
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

                // Prepare SQL statement to fetch all bookings
                $sql = "SELECT name, phone_no, email, date, seat_no, movie FROM booking";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    // Output data of each row
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>".$row["name"]."</td>
                                <td>".$row["phone_no"]."</td>
                                <td>".$row["email"]."</td>
                                <td>".$row["date"]."</td>
                                <td>".$row["seat_no"]."</td>
                                <td>".$row["movie"]."</td>
                            </tr>";
                    }
                } else {
                    echo "<tr><td colspan='6'>No bookings found</td></tr>";
                }

                // Close connection
                $conn->close();
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>
