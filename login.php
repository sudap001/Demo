<?php
// Database connection parameters
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

// Get user input from the signin form
$email = $_POST['email'];
$password = $_POST['password'];

// SQL query to fetch user data based on the provided email
$sql = "SELECT * FROM signupuser WHERE email='$email'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // User found, verify the password
    $row = $result->fetch_assoc();
    $hashed_password = $row['password'];

     if($row['permission']!=1){
        echo "<script>alert('Admin not Accepted ur Request at');</script>";
      header("Location: demo.php");
    }else if (password_verify($password, $hashed_password)) {
        // Password is correct, redirect to a welcome page or perform other actions
        // session_start();
        $adminemail="admin12@gmail.com";
        if($email==$adminemail){
            header("Location: requests.php");
        }
        else{
            session_start();
        $_SESSION['email'] =$email;
        header("Location: verifiy.php");
        }
    } 
    else {
        // Password is incorrect, redirect back to the login page with an error message
        header("Location: login.html?error=1");
    }
} else {
    // User not found, redirect back to the login page with an error message
    header("Location: login.html?error=1");
}

// Close the database connection
$conn->close();
?>
