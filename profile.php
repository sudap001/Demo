<?php
session_start();
$email=$_SESSION['email'];
$servername = "localhost";
$username = "sudap001";
$password = "WebProjectUser";
$database = "librarymanagment";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// $userid=$_SESSION['userId'];

// $userid=$_POST['name'];
// $userid = $_POST['userid'];
$sql="SELECT * FROM signupuser WHERE email='$email'";
$result=mysqli_query($conn,$sql);
$row=mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Information</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <div class="user-info-container">
        <?php

        $username = $row['username'];
        $email = $row['email'];
        $phoneNumber = $row['phone'];
        $userId = $row['userid'];

        // Display user information
        echo "<div class='user-info'>";
        echo "<p><strong>Username:</strong> $username</p>";
        echo "<p><strong>Email:</strong> $email</p>";
        echo "<p><strong>Phone Number:</strong> $phoneNumber</p>";
        echo "<p><strong>User ID:</strong> $userId</p>";
        echo "</div>";
        echo "<div class='user-info'>";
        echo '<a href="edit.php">Edit Profile<a>';
        echo '<br>';
        echo '<a href="index.php">Home<a>';
        echo "</div>";
        ?>
    </div>
</body>

</html>

<style>
    body {
    font-family: Arial, sans-serif;
    background-color: #f0f0f0;
    margin: 0;
    padding: 0;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    background-image:url("photo.png");
}

.user-info-container {
    background-color: #fff;
    border-radius: 10px;
    box-shadow: 0px 0px 10px 0px rgba(0, 0, 0, 0.1);
    padding: 20px;
}

.user-info {
    font-size: 18px;
    margin: 0;
    padding: 0;
}

.user-info p {
    margin: 10px 0;
}
</style>