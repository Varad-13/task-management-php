<?php
$page_title = 'Login';

$page_content = <<<EOT
    <div class="columns is-centered style="width: 100%; transform: translateY(50%);"">
        <div class="column is-4">
            <div class="box" style="box-shadow:0px 0px 57px 3px rgba(0,0,0,0.18); background-color:#FFFFFF;">
                <h1 class="title" style="color:black;">Login</h1>
                <form action="process_login.php"  method="post">
                    <div class="field">
                        <label class="label" style="color:black;">Username</label>
                        <div class="control">
                            <input class="input" type="text" name="username" required>
                        </div>
                    </div>
                    <div class="field">
                        <label class="label" style="color:black;">Password</label>
                        <div class="control">
                            <input class="input" type="password" name="password" required>
                        </div>
                    </div>
                    <div class="field">
                        <div class="control">
                            <button class="button is-primary" style="color:black; font-weight:bold;" type="submit">Login</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div> 
EOT;

include 'template.php';
?>
