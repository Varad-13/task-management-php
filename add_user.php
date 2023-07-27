<?php
session_start();
require_once 'db/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if the form fields are set and not empty
    if (
        isset($_POST['username']) && !empty($_POST['username']) &&
        isset($_POST['password']) && !empty($_POST['password']) &&
        isset($_POST['role']) && !empty($_POST['role'])
    ) {
        // Sanitize and validate the input data
        $username = htmlspecialchars(trim($_POST['username']));
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $role = htmlspecialchars($_POST['role']);

        // Check if the username is already taken
        $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Username already exists
            $_SESSION['message'] = 'Username already taken. Please choose a different one.';
        } else {
            // Insert the new user into the database
            $stmt = $conn->prepare("INSERT INTO users (username, password, role) VALUES (?, ?, ?)");
            $stmt->bind_param('sss', $username, $password, $role);

            if ($stmt->execute()) {
                $_SESSION['message'] = 'User created successfully.';
            } else {
                $_SESSION['message'] = 'Error creating user. Please try again.';
            }
        }
    } else {
        $_SESSION['message'] = 'Please fill in all the required fields.';
    }

    // Redirect back to the sign-up page after processing the form
    header('Location: add_user.php');
    exit();
}

$page_title = 'Add User';

// Add your registration form here (similar to the login form)
$page_content = <<<EOT
    <h1 class="title">Add User</h1>
    <!-- Display any messages from the session, if set -->
    <?php if (isset(\$_SESSION['message'])): ?>
        <p class="has-text-danger"><?php echo \$_SESSION['message']; ?></p>
        <?php unset(\$_SESSION['message']); ?>
    <?php endif; ?>
    <div class="columns is-centered">
        <div class="column is-half">
            <div class="box">
                <form action="add_user.php" method="post">
                    <!-- Add your registration form fields here -->
                    <div class="field">
                        <label class="label">Username</label>
                        <div class="control">
                            <input class="input" type="text" name="username" required>
                        </div>
                    </div>
                    <div class="field">
                        <label class="label">Password</label>
                        <div class="control">
                            <input class="input" type="password" name="password" required>
                        </div>
                    </div>
                    <div class="field">
                        <label class="label">Role</label>
                        <div class="control">
                            <div class="select">
                                <select name="role" required>
                                    <option value="" disabled selected>Select role</option>
                                    <option value="admin">Admin</option>
                                    <option value="project_manager">Project Manager</option>
                                    <option value="employee">Employee</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="field">
                        <div class="control">
                            <button class="button is-primary" type="submit">Add User</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
EOT;

include 'template.php';
?>
