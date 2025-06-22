<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Bookings - CiniBook</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: black;
            color: white;
            height: auto;
            width: auto;
            padding-top: 75px; 
        }
        header {
            display: flex;
            justify-content: space-around;
            align-items: center;
            background-color: black;
            height: 75px;
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 1000;
        }
        header h1 {
            color: white;
            margin: 0;
        }
        header a {
            text-decoration: none;
            color: inherit;
            transition-duration: 0.4s;
        }
        header a:hover {
            text-decoration: none;
            color: inherit;
        }
        nav a {
            text-decoration: none;
            text-align: center;
            color: white;
            padding-right: 20px;
        }
        nav a:hover {
            color: red;
        }
        .container {
            margin-top: 90px; /* Adjust this if necessary to account for fixed header */
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
        .btn-clear {
            background-color: #dc3545;
            color: white;
            border: none;
            border-radius: 5px;
            padding: 5px 10px;
            cursor: pointer;
        }
        .btn-clear:hover {
            text-decoration: none;
            color: white;
            background-color: #c82333;
        }
    </style>
</head>
<body>
    <?php
    session_start();

    // Initialize $isLoggedIn
    $isLoggedIn = isset($_SESSION['email']) ? true : false;

    // Redirect to login page if not logged in
    if (!$isLoggedIn) {
        header("Location: login_index.html");
        exit();
    }

    // Handle deletion request
    if (isset($_GET['delete'])) {
        // Retrieve parameters from URL
        $name = $_GET['name'];
        $phone_no = $_GET['phone_no'];
        $date = $_GET['date'];
        $seat_no = $_GET['seat_no'];
        $movie = $_GET['movie'];

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

        // Prepare SQL statement to delete the booking
        $sql = "DELETE FROM booking WHERE name = ? AND phone_no = ? AND date = ? AND seat_no = ? AND movie = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssss", $name, $phone_no, $date, $seat_no, $movie);

        if ($stmt->execute()) {
            // Redirect to the same page to refresh the booking list
            echo "<script>
                    alert('Booking deleted successfully');
                    window.location.href = 'my_book.php';
                  </script>";
        } else {
            echo "<script>alert('Error deleting record: " . $stmt->error . "');</script>";
        }

        // Close connection
        $stmt->close();
        $conn->close();
    }
    ?>

    <header class="bg-dark text-white p-3 d-flex justify-content-between align-items-center">
        <a href="index.php" class="text-decoration-none"><h1 class="m-0 text-white">CiniBook</h1></a>
        <nav>
            <?php if ($isLoggedIn): ?>
                <a href="index.php" class="text-white">Home</a>
                <a href="new.html" class="text-white">New Movies</a>
                <a href="my_book.php" class="text-white">My Bookings</a>
            <?php endif; ?>
        </nav>
        <div class="d-flex">
            <?php if ($isLoggedIn): ?>
                <a href="logout.php" class="btn btn-outline-light">Logout</a>
            <?php else: ?>
                <a href="login_index.html" class="btn btn-outline-light">Login</a>
            <?php endif; ?>
        </div>
    </header>
    
    <div class="container mt-4">
        <h1>My Bookings</h1>
        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Phone Number</th>
                    <th>Date</th>
                    <th>Seat Number</th>
                    <th>Movie</th>
                    <th>Action</th> <!-- New column for Clear -->
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

                // Prepare SQL statement to fetch bookings
                $email = $_SESSION['email']; // Get the logged-in user's email
                $sql = "SELECT name, phone_no, date, seat_no, movie FROM booking WHERE email = '$email'";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    // Output data of each row
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>".$row["name"]."</td>
                                <td>".$row["phone_no"]."</td>
                                <td>".$row["date"]."</td>
                                <td>".$row["seat_no"]."</td>
                                <td>".$row["movie"]."</td>
                                <td>
                                    <a href='?delete=true&name=".
                                    urlencode($row["name"])."&phone_no=".
                                    urlencode($row["phone_no"])."&date=".
                                    urlencode($row["date"])."&seat_no=".
                                    urlencode($row["seat_no"])."&movie=".
                                    urlencode($row["movie"])."' class='btn-clear' onclick='return confirm(\"Are you sure you want to clear this booking?\")'>Clear</a>
                                </td>
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
