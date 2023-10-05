<?php
$con = mysqli_connect('localhost', 'sudap001', 'WebProjectUser', 'projectdb');
$url = "http://localhost/";
function createTabel(){
    global $con;
    $query =    "CREATE TABLE users(
                id INT(11) AUTO_INCREMENT PRIMARY KEY,
                first_name VARCHAR(255) NOT NULL,
                last_name VARCHAR(255) NOT NULL,
                username VARCHAR(255) NOT NULL,
                email VARCHAR(255) NOT NULL,
                password TEXT NOT NULL,
                token TEXT NOT NULL,
                activition tinyint(4)  NOT NULL Default 0)";
    $con->query($query);
}
createTabel();

function otpvalidation(){
    global $con;
    $query =    "CREATE TABLE otp_expiry(
                id INT(11) NOT NULL,
                otp VARCHAR(10) NOT NULL,
                is_expired VARCHAR(255) NOT NULL,
                username INT(11) NOT NULL,
                created_at datetime NOT NULL)";
    $con->query($query);
}
otpvalidation();
function escape($string)
{
    global $con;
    return mysqli_real_escape_string($con, $string);
}


function row_count($result)
{
    return mysqli_num_rows($result);
}

function query($query)
{
    global $con;
    return mysqli_query($con, $query);
}

function confirm($result)
{
    global $con;
    if (!$result) {
        die("QUERY FAILED " . mysqli_error($con));
    }
}