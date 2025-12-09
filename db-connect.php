<?php
$servername = 'localhost';
$username = 'root';
$password = '';
$dbname = 'mirchi';

// Create a connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check if the connection was successful
if (!$conn) {
    die('Could not connect to MySQL server: ' . mysqli_connect_error());
}

?>
