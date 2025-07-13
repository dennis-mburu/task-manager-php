<?php
include 'includes/db.php';
include 'includes/auth.php';
// Ensure only admin can access this page
requireAdmin();

// Fetch all tasks from the database
// This query joins tasks with users to get the assigned user's details
// It orders tasks by deadline for better management
$result = mysqli_query($conn, "
    SELECT tasks.id, tasks.title, tasks.deadline, tasks.status,
           users.username, users.email
    FROM tasks
    JOIN users ON tasks.assigned_to = users.id
    ORDER BY tasks.deadline ASC
");
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Manage Tasks – Task Manager</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="css/style.css">
</head>

<body>

    <?php include 'includes/header.php'; ?>
    <div class="manage-page-title">
        <h2><i class="fa-solid fa-list-check"></i>Manage Tasks</h2>
        <p class="subtext">Browse or delete all assigned tasks across the team.</p>
    </div>

    <?php if (isset($_GET['deleted'])): ?>
        <p class="success">✅ Task deleted successfully.</p>
    <?php endif; ?>

    <div class="table-wrapper">
        <table class="styled-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Task</th>
                    <th>Assigned To</th>
                    <th>Email</th>
                    <th>Deadline</th>
                    <th>Status</th>
                    <th>Delete</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $counter = 1;
                while ($task = mysqli_fetch_assoc($result)) {
                    $statusClass = str_replace(' ', '', $task['status']);
                    echo "<tr>";
                    echo "<td>{$counter}</td>";
                    echo "<td>" . htmlspecialchars($task['title']) . "</td>";
                    echo "<td>" . htmlspecialchars($task['username']) . "</td>";
                    echo "<td>" . htmlspecialchars($task['email']) . "</td>";
                    echo "<td>" . htmlspecialchars($task['deadline']) . "</td>";
                    echo "<td><span class='status {$statusClass}'>" . htmlspecialchars($task['status']) . "</span></td>";
                    echo "<td>
                        <button class='btn small danger' onclick='showDeleteTaskModal({$task['id']})'>
                            <i class='fa-solid fa-trash'></i>Delete
                        </button>
                      </td>";
                    echo "</tr>";
                    $counter++;
                }

                if ($counter === 1) {
                    echo "<tr><td colspan='7'>No tasks found.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <!-- Task Delete Modal -->
    <div id="deleteTaskModal" class="modal hidden">
        <div class="modal-content">
            <p><i class="fa-solid fa-triangle-exclamation" style="color: red"></i>Are you sure you want to delete this task?</p>
            <div class="modal-actions">
                <button onclick="confirmTaskDelete()" class="btn danger">Yes, Delete</button>
                <button onclick="closeTaskModal()" class="btn">Cancel</button>
            </div>
        </div>
    </div>

    <?php include 'includes/footer.php'; ?>
    <script src="js/scripts.js"></script>
</body>

</html>