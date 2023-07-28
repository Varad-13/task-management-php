<?php
session_start();
require_once 'db/db.php';

// Function to mark a task as completed
function markTaskAsCompleted($task_id) {
    global $conn;
    $stmt = $conn->prepare("UPDATE tasks SET status = 'completed', completed_at = CURRENT_TIMESTAMP WHERE id = ?");
    $stmt->bind_param('i', $task_id);
    $stmt->execute();
}

// Function to delete a task
function deleteTask($task_id) {
    global $conn;
    $stmt = $conn->prepare("UPDATE tasks SET status = 'deleted', deleted_at = CURRENT_TIMESTAMP WHERE id = ?");
    $stmt->bind_param('i', $task_id);
    $stmt->execute();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['mark_completed']) && isset($_POST['task_id']) && is_numeric($_POST['task_id'])) {
        $task_id = $_POST['task_id'];
        markTaskAsCompleted($task_id);
        // Reload the page after marking the task as completed
        header('Location: tasks.php');
        exit();
    } elseif (isset($_POST['delete_task']) && isset($_POST['task_id']) && is_numeric($_POST['task_id'])) {
        $task_id = $_POST['task_id'];
        deleteTask($task_id);
        // Reload the page after deleting the task
        header('Location: tasks.php');
        exit();
    }
}

$page_title = 'Task Management';
$page_content = '';

// Check if the user is logged in
if (isset($_SESSION['user_id'])) {
    // Function to display tasks assigned to a specific user
    function displayTasks($user_id, $user_role)
    {
        global $conn;

        if ($user_role === 'employee') {
            $stmt = $conn->prepare("SELECT * FROM tasks WHERE assigned_to = ? AND status <> 'deleted' ORDER BY created_at DESC");
            $stmt->bind_param('i', $user_id);
        } elseif ($user_role === 'project_manager') {
            // Include deleted tasks for project managers
            $stmt = $conn->prepare("SELECT t.*, u.username as assigned_to_username 
                                    FROM tasks t 
                                    JOIN users u ON t.assigned_to = u.id 
                                    WHERE (t.assigned_by = ?) 
                                    ORDER BY t.created_at DESC");
            $stmt->bind_param('i', $user_id);
        } else {
            // Include deleted tasks for admins
            $stmt = $conn->prepare("SELECT t.*, u.username as assigned_to_username 
                                    FROM tasks t 
                                    JOIN users u ON t.assigned_to = u.id 
                                    ORDER BY t.created_at DESC");
        }

        $stmt->execute();
        $result = $stmt->get_result();

        $tasks = '<section class = "section"><div class="columns is-multiline is-centered">';

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $tasks .= '<div class="coulmn" style=" margin-right: 0.4rem; margin-left: 0.4rem; margin-top: 0.4rem; margin-bottom: 0.4rem; display: flex; flex-direction: column; justify-content: space-between; color:black;">';
                $tasks .= '<div class="box" style="box-shadow:0px 0px 57px 3px rgba(0,0,0,0.18); min-height:18rem; min-width:18rem; background-color:#FFFFFF; color:black; " >';
                $tasks .= '<h3 class="title" style="color:black;">' . htmlspecialchars($row['task_name']) . '</h3>';
                $tasks .= '<p class="content">' . htmlspecialchars($row['task_description']) . '</p>';
                $tasks .= '<p class="content">Status: ' . htmlspecialchars($row['status']) . '</p>';

                if ($row['status'] === 'completed') {
                    $tasks .= '<p class="content">Completed at: ' . htmlspecialchars($row['completed_at']) . '</p>';
                }

                if ($user_role !== 'employee' && $row['status'] === 'deleted') {
                    $tasks .= '<p class="content">Deleted at: ' . htmlspecialchars($row['deleted_at']) . '</p>';
                }

                // For marking completed tasks (available for employees only)
                if ($user_role === 'employee' && $row['status'] === 'pending') {
                    $tasks .= '<form action="tasks.php" method="post">';
                    $tasks .= '<input type="hidden" name="task_id" value="' . $row['id'] . '">';
                    $tasks .= '<input class="button is-primary" style="color:black; font-weight:bold;" type="submit" name="mark_completed" value="Mark Completed">';
                    $tasks .= '</form>';
                }

                // For deleting tasks (available for admins and project managers)
                if (($user_role === 'admin' || $user_role === 'project_manager') && $row['status'] !== 'deleted') {
                    $tasks .= '<form action="tasks.php" method="post">';
                    $tasks .= '<p class="content">Created by userid: ' . htmlspecialchars($row['assigned_by']) . '</p>';
                    $tasks .= '<input type="hidden" name="task_id" value="' . $row['id'] . '">';
                    $tasks .= '<input class="button is-danger" type="submit" name="delete_task" value="Delete">';
                    $tasks .= '</form>';
                }

                $tasks .= '</div></div>';
            }
        } else {
            $tasks = '<p>No tasks assigned.</p>';
        }

        $tasks .= '</div></section>';
        return $tasks;
    }

    // Fetch user details for the logged-in user
    $stmt = $conn->prepare("SELECT role FROM users WHERE id = ?");
    $stmt->bind_param('i', $_SESSION['user_id']);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    $user_role = $user['role'];

    // Display tasks based on user role
    if ($user_role === 'employee') {
        // For employees, display tasks assigned to them
        $page_content = '<h1 class="title" style="color:white;">Your Tasks</h1>';
        $page_content .= displayTasks($_SESSION['user_id'], $user_role);
    } else {
        // For admins and project managers, display all tasks
        $page_content = '<h1 class="title" style="color:white;">All Tasks</h1>';
        $page_content .= '<a href="add_task.php"> <button class="button is-primary" style="color:black; font-weight:bold;"">Add Task</button> </a>';
        if ($user_role == 'admin') 
            $page_content .= '<a href="manage_users.php"> <button class="button is-primary" style="color:black; font-weight:bold;">Manage Users</button> </a>';
        $page_content .= displayTasks($_SESSION['user_id'], $user_role);
    }
} else {
    // If the user is not logged in, redirect to the login page
    header('Location: login.php');
    exit();
}

include 'template.php';
?>