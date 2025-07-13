<?php
// add_user.php

include 'includes/db.php';
include 'includes/auth.php';

// ✅ Only allow admins
requireAdmin();

$error = "";
$success = "";

// If form was submitted via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Collect form input and sanitize
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password']; // Password is raw for now — will hash later
    $role = $_POST['role'];

    // Basic validation
    if (empty($username) || empty($email) || empty($password)) {
        $error = "All fields are required.";
    } else {
        // Insert user into DB
        $sql = "INSERT INTO users (username, email, password, role)
                VALUES ('$username', '$email', '$password', '$role')";

        if (mysqli_query($conn, $sql)) {
            $success = "✅ User added successfully.";
        } else {
            $error = "❌ Failed to add user: " . mysqli_error($conn);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>Add User – Task Manager</title>
</head>

<body>
    <?php include 'includes/header.php'; ?>
    <?php include 'includes/back_nav.php'; ?>
    <h2>Add New User</h2>
    <?php if ($error): ?>
        <p style="color:red;"><?php echo $error; ?></p>
    <?php elseif ($success): ?>
        <p style="color:green;"><?php echo $success; ?></p>
    <?php endif; ?>

    <!-- 📝 The form submits to the same page (POST method) -->
    <form method="POST" action="add_user.php">
        <label>Username:</label><br>
        <input type="text" name="username" required><br><br>

        <label>Email:</label><br>
        <input type="email" name="email" required><br><br>

        <label>Password:</label><br>
        <input type="password" name="password" required><br><br>

        <label>Role:</label><br>
        <select name="role" required>
            <option value="user">User</option>
            <option value="admin">Admin</option>
        </select><br><br>

        <button type="submit">Add User</button>
    </form>
    <?php include 'includes/footer.php'; ?>
</body>

</html>