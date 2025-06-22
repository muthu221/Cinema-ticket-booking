<?php
session_start();

// Check if form data is set
if (isset($_POST['email']) && isset($_POST['password'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Database connection
    $conn = new mysqli('localhost', 'root', '', 'ticket_booking');
    
    // Check connection
    if ($conn->connect_error) {
        die("Connection Failed: " . $conn->connect_error);
    }

    // Prepare and execute statement
    $stmt = $conn->prepare("SELECT * FROM user_login WHERE email = ? AND password = ?");
    $stmt->bind_param("ss", $email, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Set session variables
        $_SESSION['email'] = $email;
        header("Location: index.php");
        exit();
    } else {
        echo "Error: Invalid email or password.";
    }

    // Close connections
    $stmt->close();
    $conn->close();
} else {
    echo "Error: Email and Password are required.";
}
?>
