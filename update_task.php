<?php
// update_task.php

include 'includes/db.php';
include 'includes/auth.php';

// ✅ Check if user is logged in
requireLogin();

$user_id = $_SESSION['user_id'];

// ✅ Make sure it's a POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $task_id = (int) $_POST['task_id'];
    $new_status = $_POST['new_status'];

    // ✅ Verify the task belongs to this user
    $query = "SELECT * FROM tasks WHERE id = $task_id AND assigned_to = $user_id";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) === 1) {
        // ✅ Update the task status
        $update = "UPDATE tasks SET status = '$new_status' WHERE id = $task_id";
        mysqli_query($conn, $update);
    }
}

// Redirect back to dashboard after update
header("Location: dashboard.php");
exit;
