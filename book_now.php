<?php
// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ticket_booking";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection Failed: " . $conn->connect_error);
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $phone_no = $_POST['phone_no'];
    $email = $_POST['email'];
    $date = $_POST['date'];
    $seat_no = $_POST['seat_no'];
    $movie_id = $_POST['movie'];

    // Get the movie name using the movie_id
    $movieStmt = $conn->prepare("SELECT movie FROM movies WHERE id = ?");
    $movieStmt->bind_param("s", $movie_id);
    $movieStmt->execute();
    $movieStmt->bind_result($movie_name);
    $movieStmt->fetch();
    $movieStmt->close();

    if ($movie_name) {
        // Check if seat is already booked for the given date and movie
        $checkSeatStmt = $conn->prepare("SELECT COUNT(*) FROM booking WHERE seat_no = ? AND date = ? AND movie = ?");
        $checkSeatStmt->bind_param("sss", $seat_no, $date, $movie_name);
        $checkSeatStmt->execute();
        $checkSeatStmt->bind_result($seatCount);
        $checkSeatStmt->fetch();
        $checkSeatStmt->close();

        if ($seatCount > 0) {
            echo "Error: Seat $seat_no is already booked for $movie_id on $date.";
        } else {
            // Prepare and bind statement to insert new booking
            $stmt = $conn->prepare("INSERT INTO booking (name, phone_no, email, date, seat_no, movie) VALUES (?, ?, ?, ?, ?, ?)");
            if ($stmt) {
                $stmt->bind_param("ssssss", $name, $phone_no, $email, $date, $seat_no, $movie_name);
                $execval = $stmt->execute();
                if ($execval) {
                    header("Location: index.php");
                    exit();
                } else {
                    echo "Error: " . $stmt->error;
                }
                $stmt->close();
            } else {
                echo "Error preparing statement: " . $conn->error;
            }
        }
    } 
    else {
        echo "Error: Movie not found.";
    }
}

// Handle movie fetching
if (isset($_GET['date'])) {
    $date = $_GET['date'];

    // Fetch movies based on date
    $query = $conn->prepare("SELECT id, movie FROM movies WHERE date = ?");
    $query->bind_param("s", $date);
    $query->execute();
    $result = $query->get_result();

    $movies = [];
    while ($row = $result->fetch_assoc()) {
        $movies[] = $row;
    }

    $query->close();

    header('Content-Type: application/json');
    echo json_encode($movies);
    $conn->close();
    exit();
}
?>