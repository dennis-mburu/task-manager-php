<?php
include 'includes/db.php';
include 'includes/auth.php';
// Ensure only admin can access this page
requireAdmin();

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo "Invalid task ID.";
    exit;
}

$taskId = intval($_GET['id']);

$delete = mysqli_query($conn, "DELETE FROM tasks WHERE id = $taskId");

if ($delete) {
    header("Location: admin_tasks.php?deleted=1");
    exit;
} else {
    echo "Failed to delete task.";
}
