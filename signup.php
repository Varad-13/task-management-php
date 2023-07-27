<?php
$page_title = 'Sign Up';

// Add your registration form here (similar to the login form)
$page_content = <<<EOT
    <h1 class="title">Sign Up</h1>
    <div class="columns is-centered">
        <div class="column is-half">
            <div class="box">
                <form action="process_signup.php" method="post">
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
                            <button class="button is-primary" type="submit">Sign Up</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
EOT;

include 'template.php';
?>
