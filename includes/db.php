<?php
// db.php
// This file connects your PHP code to the MySQL database

// Load database credentials from config file (to avoid hardcoding sensitive information)
$config = parse_ini_file("config.ini");

// Define DB connection variables
$host = $config['host'];    // Where your DB server is (localhost if running locally)
$db_user = $config['db_user'];  // MySQL username (you created this)
$db_pass = $config['db_pass'];  // MySQL password (leave empty if you haven't set one)
$db_name = $config['db_name'];  // The name of your database

// Connect to the database
$conn = mysqli_connect($host, $db_user, $db_pass, $db_name);    //Using MySQLi since it's lightweight, built into PHP, and works well for procedural-style apps like this.

// If the connection fails, show error and kill script
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// To verify connection:
// echo "Connected successfully to database."; // Uncomment this line to test the connection. Do not leave it uncommented in production code as it may expose sensitive information.
?>
