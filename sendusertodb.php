<!-- <?php 
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
 
 
 $email = $_POST['email'];
 $name=$_POST['username']; // Assuming you are using POST method to submit the form
 $phone=$_POST['phone']; // Assuming you are using POST method to submit the form
 $password=$_POST['password']; // Assuming you are using POST method to submit the form
 $apikey=generateRandomKey();

 // SQL query to check if the email exists in the database
 $sql = "SELECT email FROM signupuser WHERE email = '$email'";
 $result = $connect->query($sql);
 
 if ($result->num_rows > 0) {
     // Email already exists in the database
    //  echo '<script>alert("Email already exists!");</script>';
    session_start();
    $data=1;
    $_SESSION['data']=$data;
     header(
      "Location:signup1.php"
     );
 } else {
  $hashed_password = password_hash($password, PASSWORD_DEFAULT);

  $sql = "INSERT INTO signupuser (username, email, password,permission,phone,apikey) VALUES ('$username', '$email', '$hashed_password',0,'$phone','$apikey')";
 
  if ($connect->query($sql) == TRUE) {
    header("Location:login.html");
      // User registered successfully, you can redirect to a welcome page or show a success message
     //  header("Location: login.html");
  } else {
      // Error occurred, redirect back to the signup page with an error message
      header("Location: signup.html? error while updating to database");
  }
  $connect->close();


 }
 function generateRandomKey($length = 20) {
  $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
  $key = '';

  for ($i = 0; $i < $length; $i++) {
      $key .= $characters[rand(0, strlen($characters) - 1)];
  }

  return $key;
}

 ?> -->