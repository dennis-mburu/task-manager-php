<?php
// add_task.php

include 'includes/db.php';
include 'includes/auth.php';
include 'utils/mail.php';

// ✅ Only allow admins
requireAdmin();

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

            // Get the assigned user's email
            $userResult = mysqli_query($conn, "SELECT email FROM users WHERE id = $assigned_to");
            $userRow = mysqli_fetch_assoc($userResult);
            $userEmail = $userRow['email'];

            // Send email notification
            if (sendTaskEmail($userEmail, $title, $deadline)) {
                $success .= " Email sent to user.";
            } else {
                $error = "Task was created, but failed to send email.";
            }
        } else {
            $error = "❌ Failed to assign task: " . mysqli_error($conn);
        }
    }
}
?>

<!DOCTYPE html>
<html>

<head lang="en">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="css/style.css">
    <title>Assign Task – Task Manager</title>
</head>

<body>
    <?php include 'includes/header.php'; ?>
    <div class="manage-page-title">
        <?php include 'includes/back_nav.php'; ?>
        <h2><i class="fa-solid fa-pen-to-square"></i>Assign New task </h2>
        <p class="subtext">Assign a new task to a team member and set a deadline.</p>
    </div>
    <?php if ($error): ?>
        <p style="color:red;"><?php echo $error; ?></p>
    <?php elseif ($success): ?>
        <p class="success-message"><?php echo $success; ?></p>
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
    <?php include 'includes/footer.php'; ?>
</body>

</html>