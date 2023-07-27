<?php
// Start or resume the session
session_start();

// Database connection setup
require_once 'db/db.php';

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve user input from the form
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Fetch the user from the database based on the username
    $sql = "SELECT id, username, password FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user) {
        // Verify the password
        if (password_verify($password, $user['password'])) {
            // Authentication successful
            // Store user ID and role in the session
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['role'] = $user['role'];
    
            // Redirect the user to a dashboard or any other protected page
            header('Location: index.php');
            exit();
        }
    }

    // Authentication failed
    // Redirect the user back to the login page with an error message
    header('Location: login_failed.php');
    exit();
} else {
    // If the form was not submitted through POST, redirect to the login page
    header('Location: login.php');
    exit();
}
?>
