<?php
// dashboard.php

session_start();
include 'db.php';

// Redirect if user is not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

// Get session details
$username = $_SESSION['username'];
$role = $_SESSION['role'];
$user_id = $_SESSION['user_id'];
?>

<!DOCTYPE html>
<html>

<head>
    <title>Dashboard – Task Manager</title>
    <meta charset="UTF-8">
</head>

<body>

    <h2>Welcome, <?php echo htmlspecialchars($username); ?>!</h2> 
    <p>Role: <?php echo $role; ?></p>
    <p><a href="logout.php">Logout</a></p>

    <?php if ($role === 'admin'): ?>
        <h3>Admin Controls</h3>
        <ul>
            <li><a href="add_user.php">Add User</a></li>
            <li><a href="add_task.php">Assign Task</a></li>
        </ul>

        <h4>All Users</h4>
        <ul>
            <?php
            $result = mysqli_query($conn, "SELECT id, username, email FROM users");
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<li>{$row['username']} ({$row['email']})</li>";
            }
            ?>
        </ul>

    <?php else: ?>
        <h3>Your Tasks</h3>
        <ul>
            <?php
            $result = mysqli_query($conn, "SELECT * FROM tasks WHERE assigned_to = $user_id");
            while ($task = mysqli_fetch_assoc($result)) {
                echo "<li><strong>{$task['title']}</strong> – {$task['status']} (Due: {$task['deadline']})</li>";
            }
            ?>
        </ul>
    <?php endif; ?>

</body>

</html>