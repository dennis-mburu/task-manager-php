<?php
// add_task.php

session_start();
include 'db.php';

// ✅ Only allow admins
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: index.php");
    exit;
}

$error = "";
$success = "";

// ✅ Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize and get input
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $assigned_to = (int) $_POST['assigned_to']; // Ensure it's an integer
    $raw_deadline = $_POST['deadline'];
    $deadline = date('Y-m-d H:i:s', strtotime($raw_deadline)); // converts to MySQL DATETIME format


    if (empty($title) || empty($assigned_to) || empty($deadline)) {
        $error = "All fields except description are required.";
    } else {
        // Insert task
        $sql = "INSERT INTO tasks (title, description, assigned_to, deadline)
                VALUES ('$title', '$description', $assigned_to, '$deadline')";

        if (mysqli_query($conn, $sql)) {
            $success = "✅ Task assigned successfully.";

            // 🚨 We'll trigger the email in the next step
        } else {
            $error = "❌ Failed to assign task: " . mysqli_error($conn);
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Assign Task – Task Manager</title>
</head>
<body>
    <h2>Assign New Task</h2>
    <p><a href="dashboard.php">← Back to Dashboard</a></p>

    <?php if ($error): ?>
        <p style="color:red;"><?php echo $error; ?></p>
    <?php elseif ($success): ?>
        <p style="color:green;"><?php echo $success; ?></p>
    <?php endif; ?>

    <!-- 📝 Task creation form -->
    <form method="POST" action="add_task.php">
        <label>Task Title:</label><br>
        <input type="text" name="title" required><br><br>

        <label>Description:</label><br>
        <textarea name="description" rows="4" cols="40"></textarea><br><br>

        <label>Assign To:</label><br>
        <select name="assigned_to" required>
            <option value="">-- Select User --</option>
            <?php
            // 🧠 Query all users to populate dropdown
            $users = mysqli_query($conn, "SELECT id, username FROM users");
            while ($user = mysqli_fetch_assoc($users)) {
                echo "<option value=\"{$user['id']}\">{$user['username']}</option>";
            }
            ?>
        </select><br><br>

        <label>Deadline:</label><br>
        <input type="datetime-local" name="deadline" required><br><br>

        <button type="submit">Assign Task</button>
    </form>
</body>
</html>
