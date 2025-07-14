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
    $password = $_POST['password'];
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    $role = $_POST['role'];

    // Basic validation
    if (empty($username) || empty($email) || empty($password)) {
        $error = "All fields are required.";
    } else {
        // Insert user into DB
        $sql = "INSERT INTO users (username, email, password, role)
                VALUES ('$username', '$email', '$hashedPassword', '$role')";

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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="css/style.css">
    <title>Add User – Task Manager</title>
</head>

<body>
    <?php include 'includes/header.php'; ?>
    <div class="manage-page-title">
        <?php include 'includes/back_nav.php'; ?>
        <h2><i class="fa-solid fa-user-plus"></i>Add New User </h2>
        <p class="subtext">Create a new user account and assign their role in the team.</p>
    </div>


    <!-- 📝 The form submits to the same page (POST method) -->

    <div class="form-wrapper">
        <form method="POST" action="add_user.php">
            <?php if ($success): ?><p class="success"><?php echo $success; ?></p><?php endif; ?>
            <?php if ($error): ?><p class="error"><?php echo $error; ?></p><?php endif; ?>
            <label>
                Username:
                <input type="text" name="username" required>
            </label>
            <label>
                Email:
                <input type="email" name="email" required>
            </label>
            <label>
                Password:
                <input type="password" name="password" required>
            </label>
            <label>
                Role:
                <select name="role" required>
                    <option value="user">User</option>
                    <option value="admin">Admin</option>
                </select>
            </label>

            <button type="submit">Add User</button>

        </form>
    </div>



    <?php include 'includes/footer.php'; ?>
</body>

</html>