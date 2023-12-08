<?php
session_start();
$_SESSION['data']=0;

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
/*$countrow="select * from bookdata";
$result=$conn->query($countrow);
$numrows=$result->num_rows;
// echo "<br>";

$itemsPerPage = 5;
$totalItems = $numrows;
$totalPages = ceil($totalItems / $itemsPerPage);

// Get the current page
if (isset($_GET['page']) && is_numeric($_GET['page'])) {
    $currentPage = min(max(1, $_GET['page']), $totalPages);
} else {
    $currentPage = 1;
}

// Calculate the offset for the query
$offset = ($currentPage - 1) * $itemsPerPage;
*/
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" sizes="16x16" href="logo.jpg">

    <title>Library Mangement System</title>
    <style>
        /* Add your CSS styles for the navigation bar here */
        /* Example styles for the navigation bar */
        body{
            background-image:url("photo.png"); 
        }
        .navbar {
            overflow: hidden;
            background-color: #333;
        }
        .navbar a {
            float: left;
            display: block;
            color: white;
            text-align: center;
            padding: 14px 16px;
            text-decoration: none;
        }
        .navbar a:hover {
            background-color: #ddd;
            color: black;
        }
        .container {
            max-width: 800px;
            margin: 20px auto;
            background-color: #f1fffe;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .author-row {
            margin-bottom: 20px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .pagination {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
        }
        .pagination button {
            background-color: #4caf50;
            color: white;
            padding: 8px 12px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .pagination button:hover {
            background-color: #45a049;
        }
        .search-bar {
            
            width: 70%;
            height: 40px;
            font-size: 18px;
            padding-top:5px;
            display: flex;
            align-items: center;
        }
        
        input[type="text"] {
            padding: 5px;
            border: none;
            border-radius: 4px;
            margin-right: 10px;
        }

        button {
            padding: 5px 10px;
            background-color: #4CAF50;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
    </style>
</head>
<body>

<div class="navbar">
    <a href="#">Home</a>
    <a href="signup.php">SignUp</a>
    <a href="login.html">SignIn</a>
    <a href="#contact">Contact</a>
    <div class="search-bar">
    <form method="post" action="search.php">
                <input type="text" name="search" placeholder="Search...">
                <button type="submit" name="submit">Search</button>
            </form>
            
        </div>
</div>


</body>
</html>

