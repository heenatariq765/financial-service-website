<?php
session_start();

$conn = new mysqli("localhost", "root", "", "financial_service_website");
if ($conn->connect_error) {
    die("Connection failed");
}

$email = $_POST['email'];
$password = $_POST['password'];

$sql = "SELECT user_id, password FROM register_form WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();

$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $row = $result->fetch_assoc();


    if (password_verify($password, $row['password'])) {
        $_SESSION['username'] = $row['user_id'];

        header("Location: welcome.php");
        exit();
    } else {
        echo "Invalid email or password";
    }
} else {
    echo "Invalid email or password";
}

$stmt->close();
$conn->close();
?>
