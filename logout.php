<?php
// Start or resume the session
session_start();

// Check if the user is logged in (based on the session variable user_id)
if (isset($_SESSION['user_id'])) {
    // User is logged in, so we destroy the session and unset the user_id variable
    session_destroy();
    unset($_SESSION['user_id']);
}

$page_title = 'Signed Out';
$page_content = <<<EOT
    <h1 class="title" style="color:white;">Successfully Signed out</h1>
    <div class="notification is-success" style="color:black; font-weight:bold;">You have been successfully signed out.</div>
    <p><a href="index.php" style="color:cyan;">Back to Login</a></p>
EOT;

include 'template.php';
?>
