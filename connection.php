<?php
// connection file - all other php files include this file

$host = "localhost";
$user = "root";      // default user in XAMPP
$pass = "";          // default password is empty in XAMPP
$dbname = "waste_db";

$conn = mysqli_connect($host, $user, $pass, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
