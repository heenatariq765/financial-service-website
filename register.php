<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "financial_service_website";


$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {


    $user_id = trim($_POST['user_id']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone_number']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm-password'];

    if(empty($user_id) || empty($email) || empty($phone) || empty($password) || empty($confirm_password)){
        header("Location: register.html?status=error&message=All fields are required");
        exit;
    }

    if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        header("Location: register.html?status=error&message=Invalid email format");
        exit;
    }

    if($password !== $confirm_password){
        header("Location: register.html?status=error&message=Passwords do not match");
        exit;
    }

  
    $password_hash = password_hash($password, PASSWORD_DEFAULT);


    $profile_pic = null;
    if(isset($_FILES['profile_pic']) && $_FILES['profile_pic']['error'] == 0){
        $upload_dir = "uploads/";
        if(!is_dir($upload_dir)){
            mkdir($upload_dir, 0755, true);
        }
        $file_name = time() . "_" . basename($_FILES['profile_pic']['name']);
        $target_file = $upload_dir . $file_name;

        if(move_uploaded_file($_FILES['profile_pic']['tmp_name'], $target_file)){
            $profile_pic = $file_name;
        }
    }
    
    $stmt = $conn->prepare("INSERT INTO register_form (user_id, email, phone_number, password, profile_pic) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $user_id, $email, $phone, $password_hash, $profile_pic);

     if($stmt->execute()){
        echo "Thank you! You have been successfully registered.";
    } else {
        echo "Error: " . $stmt->error;
    }


    $stmt->close();
}

$conn->close();
?>
