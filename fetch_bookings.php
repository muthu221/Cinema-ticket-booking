<?php
session_start();

// Database connection
$conn = new mysqli('localhost', 'root', '', 'ticket_booking');
if ($conn->connect_error) {
    die("Connection Failed: " . $conn->connect_error);
}

// Get email from session
$email = isset($_SESSION['email']) ? $_SESSION['email'] : '';

if (empty($email)) {
    echo json_encode([]);
    exit();
}

// Query to fetch bookings for the provided email
$sql = "SELECT name, phone_no, date, seat_no, movie FROM booking WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

$bookings = [];
while ($row = $result->fetch_assoc()) {
    $bookings[] = $row;
}

$stmt->close();
$conn->close();

// Return bookings as JSON
header('Content-Type: application/json');
echo json_encode($bookings);
?>
