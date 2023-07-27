<?php
// Database connection setup
require_once 'db/db.php';

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve user input from the form
    $username = $_POST['username'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    // TODO: Perform validation and sanitization on user input
    // TODO: Implement additional validation checks (e.g., unique username, strong password requirements)

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Insert user data into the database
    $sql = "INSERT INTO users (username, password, role) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('sss', $username, $hashed_password, $role);
    $stmt->execute();

    // Redirect the user to a confirmation page or any other desired destination
    header('Location: signup_success.php');
    exit();
} else {
    // If the form was not submitted through POST, redirect to the signup page
    header('Location: signup.php');
    exit();
}
?>
