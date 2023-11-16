<?php
session_start();
$email=$_SESSION['email'];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
        .dropbtn {
            background-color: #4CAF50;
            color: white;
            padding: 14px 20px;
            font-size: 16px;
            border: none;
            cursor: pointer;
        }
        
        .dropdown-content {
            display: none;
            position: absolute;
            background-color: #f9f9f9;
            min-width: 160px;
            box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
            z-index: 1;
        }
        
        .dropdown:hover .dropdown-content {
            display: block;
        }
        
        .dropdown-content a {
            color: black;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
        }
        
        .dropdown-content a:hover {
            background-color: #f1f1f1;
        }
        .search-bar {
            
            width: 70%;
            height: 40px;
            font-size: 18px;
            
            padding: auto;
            display: flex;
            align-items: center;
        }
    </style>
</head>
<body>

<div class="navbar">
    <a href="#">Home</a>
    <a href="profile.php">Profile Details</a>
    <a href="addbook.php">Add Book</a>
    <a href="logout.php"> Logout</a>

    <div class="dropdown">
        <button class="dropbtn">Update User Details</button>
        <div class="dropdown-content">
            <?php
            // session_start();
            $_SESSION['email']=$email;
            echo '<a href="changeusername.php">Change UserName</a>';
            echo '<a href="changepassword.php">Change Password</a>';
            ?>
            <!-- <a href="#">Option 3</a> -->
    </div>
    
    </div>
    
    <div class="navbar">
    <div class="search-bar">
    <form method="post" action="searchlogin.php">
                <input type="text" name="search" placeholder="Search...">
                <button type="submit" name="submit">Search</button>
            </form>
    </div>
    
        </div>
        
        
    <!-- <a href="#">Contact</a> -->


<!-- Rest of your HTML content goes here -->

</body>
</html>


