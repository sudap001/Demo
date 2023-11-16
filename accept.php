<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Requests</title>
    <style>
        /* Add your CSS styles for the table here */
        /* Example styles for the table */
        body{
            background-image:url("photo.png"); 
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #4caf50;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        button {
            background-color: #4caf50;
            color: white;
            border: none;
            padding: 6px 12px;
            cursor: pointer;
        }
        button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>

<h2>User Requests</h2>

<!-- PHP code to generate the table -->
<?php
// Example user data (replace this with data from your database)
// $users = [
//     ["userid" => 1, "username" => "User1", "email" => "user1@example.com"],
//     ["userid" => 2, "username" => "User2", "email" => "user2@example.com"],
//     ["userid" => 3, "username" => "User3", "email" => "user3@example.com"]
// ];

echo "<table>";
echo "<tr><th>User ID</th><th>Username</th><th>Email</th><th>Action</th></tr>";
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
$stmt1 = "SELECT * FROM signupuser WHERE permission=0";
                    $result2 = $connect->query($stmt1);
//print_r($stmt1);exit;
                    foreach($result2 as $key1){?>
   <?php echo "<tr>";
//    $userid=$key['userid'];
    echo "<td>{$key1['userid']}</td>";
    echo "<td>{$key1['username']}</td>";
    echo "<td>{$key1['email']}</td>";?>
    <td><form action="updateregister.php" method="post">
        <?php
        $userid =$key1['userid']; // Example user ID
        echo '<input type="hidden" name="userid" value="' . $userid . '">';
        ?>
        <input type="submit" name="submit_button" value="Accept">
    </form></td>
<?php
    echo "</tr>";
}?>
<?php
echo "</table>";
?>

</body>
</html>
