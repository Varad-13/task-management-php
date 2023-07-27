<?php
session_start();
require_once 'db/db.php';

// Check if the user is logged in
if (isset($_SESSION['user_id'])) {
    // Fetch user details for the logged-in user
    $stmt = $conn->prepare("SELECT role FROM users WHERE id = ?");
    $stmt->bind_param('i', $_SESSION['user_id']);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    $user_role = $user['role'];

    // Check if the user is an admin (only admins can access this page)
    if ($user_role !== 'admin') {
        // Redirect to the tasks page if the user is not an admin
        header('Location: tasks.php');
        exit();
    }

    $page_title = 'Manage Users';
    $page_content = '<h1 class="title">Manage Users</h1>';

    // Display a list of all users
    $stmt = $conn->prepare("SELECT * FROM users");
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $page_content .= '<div class="table-container">';
        $page_content .= '<table class="table is-fullwidth">';
        $page_content .= '<thead><tr><th>ID</th><th>Username</th><th>Role</th><th>Actions</th></tr></thead>';
        $page_content .= '<tbody>';

        while ($user = $result->fetch_assoc()) {
            $page_content .= '<tr>';
            $page_content .= '<td>' . htmlspecialchars($user['id']) . '</td>';
            $page_content .= '<td>' . htmlspecialchars($user['username']) . '</td>';
            $page_content .= '<td>' . htmlspecialchars($user['role']) . '</td>';
            $page_content .= '<td>';
            // Add edit and delete buttons for each user
            $page_content .= '<a class="button is-primary" href="edit_user.php?id=' . $user['id'] . '">Edit</a>';
            $page_content .= '&nbsp;'; // Add a non-breaking space for spacing
            $page_content .= '<a class="button is-danger" href="delete_user.php?id=' . $user['id'] . '">Delete</a>';
            $page_content .= '</td>';
            $page_content .= '</tr>';
        }

        $page_content .= '</tbody>';
        $page_content .= '</table>';
        $page_content .= '</div>';
    } else {
        $page_content .= '<p>No users found.</p>';
    }

    // Add a button to add a new user
    $page_content .= '<a class="button is-primary" href="add_user.php">Add New User</a>';

} else {
    // If the user is not logged in, redirect to the login page
    header('Location: login.php');
    exit();
}

include 'template.php';
?>
