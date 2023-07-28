<?php
session_start();
require_once 'db/db.php';

// Check if the user is logged in and has Admin or Project Manager role
if (!isset($_SESSION['user_id']) && ($_SESSION['role'] !== 'employee')) {
    // Redirect to the tasks.php page if not authorized
    header('Location: tasks.php');
    exit();
}

$page_title = 'Add Task';
$page_content = '';

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve task details from the form
    $task_name = $_POST['task_name'];
    $task_description = $_POST['task_description'];
    $assigned_to = $_POST['assigned_to'];

    // Insert the new task into the database
    $stmt = $conn->prepare("INSERT INTO tasks (assigned_by, assigned_to, task_name, task_description) VALUES (?, ?, ?, ?)");
    $stmt->bind_param('iiss', $_SESSION['user_id'], $assigned_to, $task_name, $task_description);
    $stmt->execute();

    // Redirect to the tasks.php page after adding the task
    header('Location: tasks.php');
    exit();
} else {
    // Fetch all employees to populate the drop-down list
    $stmt = $conn->prepare("SELECT id, username FROM users WHERE role = 'employee'");
    $stmt->execute();
    $result = $stmt->get_result();
    $employees = $result->fetch_all(MYSQLI_ASSOC);

    // Build the drop-down list of employees
    $employeeOptions = '';
    foreach ($employees as $employee) {
        $employeeOptions .= '<option value="' . $employee['id'] . '">' . htmlspecialchars($employee['username']) . '</option>';
    }

    // Form to add a new task
    $page_content = <<<EOT
        <div class="columns is-centered">
            <div class="column is-4">
                <div class="box" style="background-color:#666666;">
                    <h1 class="title" style="color:white;">Add Task</h1>
                    <form action="add_task.php" method="post">
                        <div class="field">
                            <label class="label" style="color:white;">Task Name</label>
                            <div class="control">
                                <input class="input" type="text" name="task_name" required>
                            </div>
                        </div>
                        <div class="field">
                            <label class="label" style="color:white;">Task Description</label>
                            <div class="control">
                                <textarea class="textarea" name="task_description" required></textarea>
                            </div>
                        </div>
                        <div class="field">
                            <label class="label" style="color:white;">Assign To</label>
                            <div class="control">
                                <div class="select">
                                    <select name="assigned_to" required>
                                        <option value="" disabled selected>Select an Employee</option>
                                        $employeeOptions
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="field">
                            <div class="control">
                                <button class="button is-primary" type="submit">Add Task</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
EOT;
}

include 'template.php';
?>
