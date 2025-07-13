<?php
include 'includes/db.php';
include 'includes/auth.php';
// Ensure only admin can access this page
requireAdmin();

// Validate the ID
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo "Invalid user ID.";
    exit;
}

$userId = intval($_GET['id']);

// Prevent admin from deleting their own account
if ($_SESSION['user_id'] == $userId) {
    echo "⚠️ You cannot delete your own account.";
    exit;
}

// Step 1: Delete all tasks assigned to this user
$deleteTasks = mysqli_query($conn, "DELETE FROM tasks WHERE assigned_to = $userId");

if (!$deleteTasks) {
    echo "❌ Failed to delete associated tasks.";
    exit;
}


// Step 2: Delete the user from the database
$delete = mysqli_query($conn, "DELETE FROM users WHERE id = $userId");

if ($delete) {
    header("Location: admin_users.php?deleted=1");
    exit;
} else {
    echo "Failed to delete user.";
}
