<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../../../favicon.ico">
 
<?php
$conn= mysqli_connect("localhost","sudap001","WebProjectUser","projectdb") ;
$result = mysqli_query($conn,"SELECT first_name,last_name,username,email,role FROM users ");
echo "<table border='1'>
<tr>
<th>First name</th>
<th>Last Name</th>
<th>Email</th>
<th>Username</th>
<th>Role</th>
</tr>";
 
while($row = mysqli_fetch_array($result))
{
echo "<tr>";
echo "<td>" . $row['first_name'] . "</td>";
echo "<td>" . $row['last_name'] . "</td>";
echo "<td>" . $row['email'] . "</td>";
echo "<td>" . $row['username'] . "</td>";
echo "<td>" . $row['role'] . "</td>";

echo "</tr>";
}
echo "</table>";

 


?>
    </main>



</html>