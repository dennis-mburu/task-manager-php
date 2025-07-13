<?php
include 'includes/db.php';
include 'includes/auth.php';
requireLogin();

$userId = $_SESSION['user_id'];
$role = $_SESSION['role'];

// Fetch only the logged-in user's tasks
$taskResult = mysqli_query($conn, "
    SELECT tasks.*, users.email AS user_email 
    FROM tasks 
    JOIN users ON tasks.assigned_to = users.id 
    WHERE assigned_to = $userId 
    ORDER BY deadline ASC
");
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Dashboard – Task Manager</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>

    <?php include 'includes/header.php'; ?>

    <h2>Dashboard</h2>

    <?php if ($role === 'admin'): ?>
        <div class="admin-nav">
            <a href="add_user.php" class="btn"><i class="fa-solid fa-user-plus"></i>Add New User</a>
            <a href="add_task.php" class="btn"><i class="fa-solid fa-list-check"></i>Assign Task</a>
            <a href="admin_users.php" class="btn"><i class="fa-solid fa-wrench"></i>Manage All Users</a>
            <a href="admin_tasks.php" class="btn"><i class="fa-solid fa-pen-to-square"></i>Manage All Tasks</a>
        </div>
    <?php endif; ?>

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
                while ($task = mysqli_fetch_assoc($taskResult)) {
                    $status = $task['status'];
                    $className = str_replace(' ', '', $status);

                    // If task is completed, strike through the row
                    $rowClass = ($status === 'Completed') ? 'task-completed' : '';

                    echo "<tr class='{$rowClass}'>";
                    echo "<td>{$counter}</td>";
                    echo "<td>" . htmlspecialchars($task['title']) . "</td>";
                    echo "<td>" . htmlspecialchars($task['user_email']) . "</td>";
                    echo "<td>" . htmlspecialchars($task['deadline']) . "</td>";
                    echo "<td><span class='status {$className}'>" . htmlspecialchars($status) . "</span></td>";
                    echo "<td>";

                    // Show status update form (disabled if completed)
                    $nextStatus = match ($status) {
                        'Pending' => 'In Progress',
                        'In Progress' => 'Completed',
                        default => null
                    };

                    if ($nextStatus) {
                        echo "<form method='POST' action='update_task.php' style='display:inline'>";
                        echo "<input type='hidden' name='task_id' value='{$task['id']}'>";
                        echo "<input type='hidden' name='new_status' value='{$nextStatus}'>";
                        echo "<button type='submit'>Mark as {$nextStatus}</button>";
                        echo "</form>";
                    } else {
                        // Completed: show disabled button
                        echo "<button type='button' disabled>Completed</button>";
                    }

                    echo "</td></tr>";
                    $counter++;
                }
                ?>
            </tbody>
        </table>
    </div>

    <?php include 'includes/footer.php'; ?>
</body>

</html>