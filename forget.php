<?php

if(isset($_POST['forget'])){
    // $oldpass = $_POST['oldpass'];
    // $email = $_POST['email'];
    // $message = $_POST['message'];
    session_start();
    $email=$_POST['email'];
    $newpass=$_POST['newpassword'];
    $conpass=$_POST['conpass'];
    // echo $email;

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
if($conpass!=$newpass){
    echo '<script>alret("password does not match each other");</script>';
}else{
    $hashed_password = password_hash($newpass, PASSWORD_DEFAULT);
 $sql="UPDATE signupuser SET password='$hashed_password' WHERE email='$email'";
 if ($conn->query($sql) === TRUE) {
     echo '<script> alert("Updated password susscefully");</script>';
    $userEmail=$email;
     $verificationCode = mt_rand(100000, 999999);
    $subject = 'Reset forget password';
    $message = 'Your new password is: ' . $newpass;
    
    $headers .= 'From: welabs448@gmail.com' . "\r\n";
        // // Send the email
    if(mail($userEmail, $subject, $message, $headers)) {
        echo '<script>
        alert("We have sent you Email for your new password conformtion");
        window.location="login.html";
        </script>';
        
        // header("Location: verified.php?");
    } else {
        echo 'Email sending failed';
    }
 } else {
 
     echo "Error updating record: " . $conn->error;
 }

    


 
}
}


?>

<style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            background-image:url("photo.png");
        }
        .signup-container {
            max-width: 400px;
            margin: 0 auto;
            background-color: #ffffff;
            padding: 20px;
            margin-top: 100px;
            border-radius: 5px;
            box-shadow: 0px 0px 10px 0px rgba(0,0,0,0.1);
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group input[type="text"], 
        .form-group input[type="email"],
        .form-group input[type="password"] {
            width: calc(100% - 20px);
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 5px;
            margin-bottom: 10px;
            display: inline-block;
        }
        .form-group input[type="submit"] {
            width: 100%;
            background-color: #4caf50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            padding: 10px;
            font-size: 16px;
        }
        .form-group input[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <div class="signup-container">
        <h2>Change Password</h2>
        <form action="forget.php" method="post">
            <div class="form-group">
                <label for="email">Registerd Email:</label>
                <input type="text" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="npassword">New password:</label>
                <input type="text" id="newpassword" name="newpassword" required>
            </div>
            <div class="form-group">
                <label for="username">Conform password:</label>
                <input type="text" id="conpass" name="conpass" required>
            </div>
            <div class="form-group">
                <input type="submit" name="forget" value="change password">
            </div>
        </form>
    </div>
</body>
</html>
