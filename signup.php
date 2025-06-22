<?php
$username = $_POST['username'];
$email = $_POST['email'];
$password = $_POST['password'];
$phone = $_POST['phone'];
$city = $_POST['city'];

$conn = new mysqli('localhost', 'root', '', 'ticket_booking');
if ($conn->connect_error) {
    die("Connection Failed: " . $conn->connect_error);
} else {
    $check_stmt = $conn->prepare("SELECT * FROM user_login WHERE email = ?");
    $check_stmt->bind_param("s", $email);
    $check_stmt->execute();
    $result = $check_stmt->get_result();

    if ($result->num_rows > 0) {
        echo "Error: Email already exists.";
    } else {
        $stmt = $conn->prepare("INSERT INTO user_login (username, email, password, phone, city) VALUES (?, ?, ?, ?, ?)");
        if ($stmt) {
            $stmt->bind_param("sssss", $username, $email, $password, $phone, $city);
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
    $check_stmt->close();
    $conn->close();
}
?>
