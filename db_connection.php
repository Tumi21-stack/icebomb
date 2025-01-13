<?php
$servername = "localhost"; // Replace with your server name
$username = "root";        // Replace with your database username
$password = ""; // Replace with your database password
$database = "icebombs_db"; // Replace with your database name

// Create connection using MySQLi
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    echo "<p>Connection failed: " . $conn->connect_error . "</p>";
} else {
    echo "<p>Connected successfully</p>";
}

$conn->close();
?>
