<?php

# Setup connection
$host = "localhost";
$username = "root";
$password = "";
$dbname = "student-club";

# Create connection
$conn = mysqli_connect($host, $username, $password, $dbname);

# Check connection
if (!$conn){
    die("Connection failed: " . mysqli_connect_error());
}

?>