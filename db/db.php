<?php

// Replace these variables with your actual database credentials
$host = 'localhost';
$port = 3306; // Change to your actual port if different from the default 3306
$username = 'user1';
$password = 'sql';
$database = 'task_manager';

$conn = new mysqli($host, $username, $password, $database, $port);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Set character set to UTF-8 (optional, but recommended)
$conn->set_charset("utf8");
