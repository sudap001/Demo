<?php
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
if(isset($_POST['userid'])){
    $userid = $_POST['userid'];
$sql="UPDATE signupuser SET permission='1' WHERE userid=$userid";
if ($conn->query($sql) === TRUE) {
    echo "Record updated successfully";
} else {
    echo "Error updating record: " . $conn->error;
}
}

?>
<!-- if(isset($_POST['userid'])){
    $userid = $_POST['userid'];
    echo "User ID received from the first page: $userid";
} else {
    echo "User ID not found.";
} -->