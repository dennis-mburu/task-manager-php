<?php
session_start(); // Start/resume session for using $_SESSION variables

include 'includes/db.php'; // Include database connection settings

$error = ""; // Initialize error message variable

// Check if form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];       // Get email from the form
    $password = $_POST['password']; // Get password from the form

    // Sanitize email to prevent SQL injection
    $email = mysqli_real_escape_string($conn, $email);

    // Query to find user by email
    $sql = "SELECT * FROM users WHERE email = '$email'";
    $result = mysqli_query($conn, $sql);

    // Check if user exists
    if ($result && mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result); // Get user data as associative array

        // Compare entered password with stored password (plain text for now, will hash later
        if ($password === $user['password']) {
            // Store user data in session variables
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];

            // Redirect to dashboard
            header("Location: dashboard.php");
            exit;
        } else {
            $error = "❌ Incorrect password.";
        }
    } else {
        $error = "❌ User not found.";
    }
}
?>

<!DOCTYPE html>
<html>

<head lang="en">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>Login – Task Manager</title>
</head>

<body>
    <?php include 'includes/header.php'; ?>

    <h2>Login</h2>

    <!-- Display error message if any -->
    <?php if ($error): ?>
        <p style="color:red;"><?php echo $error; ?></p>
    <?php endif; ?>

    <!-- Login Form -->
    <form method="POST" action="index.php">
        <label>Email:</label><br>
        <input type="email" name="email" required><br><br>

        <label>Password:</label><br>
        <input type="password" name="password" required><br><br>

        <button type="submit">Login</button>
    </form>
    <?php include 'includes/footer.php'; ?>
</body>

</html>