<?php
// dashboard.php

include 'includes/db.php';
include 'includes/auth.php';

requireLogin();

// Get session details
$username = $_SESSION['username'];
$role = $_SESSION['role'];
$userId = $_SESSION['user_id'];

// Fetch tasks
if ($role === 'admin') {
    $taskQuery = "SELECT tasks.*, users.email AS user_email 
                  FROM tasks 
                  JOIN users ON tasks.assigned_to = users.id 
                  ORDER BY deadline ASC";
} else {
    $taskQuery = "SELECT tasks.*, users.email AS user_email 
                  FROM tasks 
                  JOIN users ON tasks.assigned_to = users.id 
                  WHERE assigned_to = $userId 
                  ORDER BY deadline ASC";
}

$taskResult = mysqli_query($conn, $taskQuery);

// If admin, also fetch all users
if ($role === 'admin') {
    $userResult = mysqli_query($conn, "SELECT id, email, username, role FROM users ORDER BY id ASC");
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
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
        <div class="table-wrapper">
            <table class="styled-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>User Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Edit</th>
                        <th>Delete</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $ucount = 1;
                    while ($user = mysqli_fetch_assoc($userResult)) {
                        echo "<tr>";
                        echo "<td>" . $ucount++ . "</td>";
                        echo "<td>" . htmlspecialchars($user['username']) . "</td>";
                        echo "<td>" . htmlspecialchars($user['email']) . "</td>";
                        echo "<td>" . htmlspecialchars($user['role']) . "</td>";
                        // echo "<td>" . "<a href='edit_user.php?id=" . $user['id'] . "' class='btn small'>Edit</a>" . "</td>";
                        echo '<td><a href="edit_user.php?id=' . $user['id'] . '" class="btn small"><i class="fa-solid fa-pen-to-square"></i>Edit</a></td>';
                        // echo "<td>" . "<a href='delete_user.php?id=" . $user['id'] . "' class='btn small danger'>Delete</a>" . "</td>";
                        echo '<td><a href="delete_user.php?id=' . $user['id'] . '" class="btn small danger"><i class="fa-solid fa-trash"></i>Delete</a></td>';
                        echo "</tr>";
                    }


                    if ($ucount === 1) {
                        echo "<tr><td colspan='4'>No users found.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>

    <!-- This section is for all users, including admin -->
    <h3>Your Tasks</h3>
    <div class="table-wrapper">
        <table class="styled-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Task</th>
                    <th>Assigned To</th>
                    <th>Deadline</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $counter = 1;
                while ($row = mysqli_fetch_assoc($taskResult)) {
                    $status = $row['status'];
                    $className = str_replace(' ', '', $status); // e.g. "In Progress" → "InProgress"

                    echo "<tr>";
                    echo "<td>" . $counter++ . "</td>";
                    echo "<td>" . htmlspecialchars($row['title']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['user_email']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['deadline']) . "</td>";
                    echo "<td><span class='status $className'>" . htmlspecialchars($status) . "</span></td>";
                    echo "<td>
                        <a href='update_task.php?id=" . $row['id'] . "' class='btn small'>Update</a>";
                    if ($role === 'admin') {
                        echo "<a href='delete_task.php?id=" . $row['id'] . "' class='btn small danger'>Delete</a>";
                    }
                    echo "</td>";
                    echo "</tr>";
                }

                if ($counter === 1) {
                    echo "<tr><td colspan='6'>No tasks found.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <?php include 'includes/footer.php'; ?>
</body>

</html>