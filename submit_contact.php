<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "financial_service_website";

$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name    = trim($_POST['name']);
    $email   = trim($_POST['email']);
    $phone   = trim($_POST['phoneNumber']);
    $message = trim($_POST['message']);

    if(empty($name) || empty($email) || empty($phone) || empty($message)){
        die("All fields are required.");
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("Invalid email format.");
    }

    $stmt = $conn->prepare("INSERT INTO contact_form (Name, Email, Phone, Message) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $name, $email, $phone, $message);

    if($stmt->execute()){
        echo "Thank you! Your message has been submitted successfully.";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>
