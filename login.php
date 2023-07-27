<?php
$page_title = 'Login';

$page_content = <<<EOT
    <h1 class="title">Login</h1>
    <div class="columns is-centered">
        <div class="column is-half">
            <div class="box">
                <form action="process_login.php" method="post">
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
                        <div class="control">
                            <button class="button is-primary" type="submit">Login</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div> 
EOT;

include 'template.php';
?>
