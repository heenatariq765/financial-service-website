<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.html");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Welcome</title>
    <meta http-equiv="refresh" content="5;url=stocks.html">
    <style>
        body {
            font-family: Arial;
            text-align: center;
            margin-top: 100px;
        }
    </style>
</head>
<body>

<h1>Welcome <?php echo $_SESSION['username']; ?></h1>
<p>You will be redirected to Stocks page in 5 seconds...</p>

</body>
</html>
