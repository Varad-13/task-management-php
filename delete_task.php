<?php
session_start();
require_once 'db/db.php';

// Check if the user is logged in and has Employee role
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'employee') {
    // Redirect to the tasks.php page if not authorized
    header('Location: tasks.php');
    exit();
}

// Check if the task_id is provided in the query parameters and is numeric
if (isset($_GET['task_id']) && is_numeric($_GET['task_id'])) {
    $task_id = $_GET['task_id'];

    // Verify that the task exists in the database
    $stmt = $conn->prepare("SELECT id FROM tasks WHERE id = ?");
    $stmt->bind_param('i', $task_id);
    $stmt->execute();
    $result = $stmt->get_result();

    // If the task exists, mark it as deleted
    if ($result->num_rows > 0) {
        $stmt = $conn->prepare("UPDATE tasks SET status = 'deleted' WHERE id = ?");
        $stmt->bind_param('i', $task_id);
        $stmt->execute();
    } else {
        // If the task does not exist, display an error message
        echo "Error: Task not found.";
    }
} else {
    // If task_id is not provided or not numeric, display an error message
    echo "Error: Invalid task ID.";
}
?>
