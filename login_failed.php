<?php
$page_title = 'Login Failed';

$page_content = <<<EOT
    <h1 class="title">Login Failed</h1>
    <div class="notification is-danger">Invalid username or password. Please try again.</div>
    <p><a href="login.php">Back to Login</a></p>
EOT;

include 'template.php';
?>
