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

$secretKey = '6LdaOiEpAAAAACSc5Hzdgrh_aOHYrpR0YT_pdte7';

// Get the reCAPTCHA response from the submitted form
$captchaResponse = $_POST['g-recaptcha-response'];

// Make a POST request to the reCAPTCHA API
$url = 'https://www.google.com/recaptcha/api/siteverify';
$data = [
    'secret' => $secretKey,
    'response' => $captchaResponse,
];

$options = [
    'http' => [
        'header' => "Content-type: application/x-www-form-urlencoded\r\n",
        'method' => 'POST',
        'content' => http_build_query($data),
    ],
];

$context = stream_context_create($options);
$result = file_get_contents($url, false, $context);

// Decode the JSON result
$resultJson = json_decode($result,true);

// Get user input from the signin form
$email = $_POST['email'];
$password = $_POST['password'];

// SQL query to fetch user data based on the provided email
$sql = "SELECT * FROM signupuser WHERE email='$email'";
$result = $conn->query($sql);

if ($resultJson['success']){

if ($result->num_rows > 0){
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
    header("Location: login.html?error=2");
}
}else {
    // Handle reCAPTCHA verification failure
    echo 'reCAPTCHA verification failed. Please try again.';
    echo '
    <form action="login.html">
                <button type="submit" name="submit">Login</button>
            </form>
    ';
}

// Close the database connection
$conn->close();
?>
