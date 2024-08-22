<?php

$servername = "localhost";
$username = "root";
$password = "";
$database = "notes";

// Create a connection
try {
    $conn = mysqli_connect($servername, $username, $password, $database, 8111);
} catch (mysqli_sql_exception $exception) {
    die("Failed to Connect: " . $exception->getMessage());
} 


?>