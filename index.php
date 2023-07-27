<?php
session_start();
require_once 'db/db.php';

$page_title = 'Home';

// Check if the user is logged in
if (isset($_SESSION['user_id'])) {
    // Fetch user details for the logged-in user
    $stmt = $conn->prepare("SELECT role FROM users WHERE id = ?");
    $stmt->bind_param('i', $_SESSION['user_id']);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    $user_role = $user['role'];

    // Redirect to the tasks.php page if the user is logged in
    header('Location: tasks.php');
    exit();
} else {
    // If the user is not logged in, display the homepage content
    header('Location: login.php');
}

include 'template.php';
?>
