<?php

session_start();
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require 'vendor/autoload.php';
$userEmail=$_SESSION['email'];

$verificationCode = mt_rand(100000, 999999);
$subject = 'Verification Code';
    $message = 'Your verification code is: ' . $verificationCode;
$mail = new PHPMailer(true);
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'testwebsiteproject316@gmail.com'; //host email 
        $mail->Password = 'durm bjdi qlor zvxy'; // app password of your host email
        $mail->Port = 465;
        $mail->SMTPSecure = 'ssl';
        $mail->isHTML(true);
        $mail->setFrom('testwebsiteproject316@gmail.com', 'Digital Library');//Sender's Email & Name
        $mail->addAddress($userEmail); //Receiver's Email and Name
        $mail->Subject = ("$subject");
        $mail->Body = $message;
        $mail->send();



 
 

    

    
    
        
    $_SESSION['otp'] =$verificationCode;
    // header("Location: signup.php");
        header("Location: verified.php?");
    //} else {
      //  echo 'Email sending failed';
    //}



?>

 $localhost = "localhost";
 $username = "sudap001";
 $password = "WebProjectUser";
 $dbname = "librarymanagment";
 //$store_url = "http://localhost/phpinventory/";
 // db connection
 $connect = new mysqli($localhost, $username, $password, $dbname);
 // check connection
 if($connect->connect_error) {
   die("Connection Failed : " . $connect->connect_error);
 } 

 $username = $_POST['username'];
 $email = $_POST['email'];
 $password = $_POST['password'];
 $phone=$_POST['phone'];
 
 // Hash the password before storing it in the database (for security)
 $hashed_password = password_hash($password, PASSWORD_DEFAULT);
 
 // SQL query to insert data into the users table
 $sql = "INSERT INTO signupuser (username, email, password,permission,phone) VALUES ('$username', '$email', '$hashed_password',0,'$phone')";
 
 if ($connect->query($sql) == TRUE) {
     // User registered successfully, you can redirect to a welcome page or show a success message
     header("Location: login.html");
 } else {
     // Error occurred, redirect back to the signup page with an error message
     header("Location: signup.html?error=1");
 }
 
 // Close the database connection
 $conn->close();
 ?>
