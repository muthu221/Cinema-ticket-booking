<?php
session_start();
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: login_index.html");
    exit();
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $movie_name = $_POST['movie_name'];
    $date = $_POST['date'];

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

    // Prepare SQL statement to insert new movie
    $sql = "INSERT INTO movies (date, movie) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $date, $movie_name);

    if ($stmt->execute()) {
        echo "<p>New movie added successfully.</p>";
    } else {
        echo "<p>Error: " . $stmt->error . "</p>";
    }

    // Close connection
    $stmt->close();
    $conn->close();

    // Redirect back to movies page
    header("Location: movies.php");
    exit();
}
?>
