<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title><?php echo $page_title; ?></title>
    <link rel="stylesheet" href="css/bulma.min.css">
</head>
<body>
    <nav class="navbar is-primary" role="navigation" aria-label="main navigation">
        <div class="navbar-start">
            <!-- Add your navigation links here -->
            <a class="navbar-item" href="index.php">
                Task Management System
            </a>
            <?php
            // Check if the user is logged in (based on the session variable user_id)
            if (isset($_SESSION['user_id'])) {
                // User is logged in, display "Sign out" with link to logout.php
                ?>
                <a class="navbar-item" href="logout.php">Sign out</a>
                <?php
            } else {
                // User is not logged in, display "Sign in" with link to login.php
                ?>
                <a class="navbar-item" href="login.php">Sign in</a>
                <?php
            }
            ?>
        </div>
    </nav>

    <section class="section">
        <div class="container">
            <?php echo $page_content; ?>
        </div>
    </section>

    <footer class="footer">
        <div class="content has-text-centered">
            <p>
                &copy; Task Management System.
            </p>
        </div>
    </footer>
</body>
</html>
