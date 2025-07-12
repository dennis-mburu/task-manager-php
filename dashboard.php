<?php
// dashboard.php

include 'includes/db.php';
include 'includes/auth.php';

requireLogin();

// Get session details
$username = $_SESSION['username'];
$role = $_SESSION['role'];
$user_id = $_SESSION['user_id'];
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>Dashboard – Task Manager</title>
</head>

<body>
    <?php include 'includes/header.php'; ?>

    <!-- Show this section only if user is admin -->
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
                echo "<li>" . htmlspecialchars($row['username']) . " (" . htmlspecialchars($row['email']) . ")</li>";
            }
            ?>
        </ul>
    <?php endif; ?>

    <!-- This section is for all users, including admin -->
    <h3>Your Tasks</h3>
    <ul>
        <?php
        $result = mysqli_query($conn, "SELECT * FROM tasks WHERE assigned_to = $user_id");
        while ($task = mysqli_fetch_assoc($result)) {
            echo "<li>";
            echo "<strong>{$task['title']}</strong> – {$task['status']} (Due: {$task['deadline']})";

            // 🎯 Only show status update form (button) if task is not Completed
            if ($task['status'] !== 'Completed') {
                echo "<form method='POST' action='update_task.php' style='display:inline; margin-left:10px;'>";
                echo "<input type='hidden' name='task_id' value='{$task['id']}'>";

                // Set next status
                $nextStatus = match ($task['status']) {
                    'Pending' => 'In Progress',
                    'In Progress' => 'Completed',
                    default => null
                };

                if ($nextStatus) {
                    echo "<input type='hidden' name='new_status' value='{$nextStatus}'>";
                    echo "<button type='submit'>Mark as {$nextStatus}</button>";
                }

                echo "</form>";
            }

            echo "</li>";
        }
        ?>
    </ul>
    <?php include 'includes/footer.php'; ?>
</body>

</html>