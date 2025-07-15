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

        // verify the hashed password
        if (password_verify($password, $user['password'])) {
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="css/style.css">
    <title>Login – Task Manager</title>
</head>

<body>
    <?php include 'includes/header.php'; ?>

    <div class="manage-page-title">
        <h2><i class="fa-solid fa-lock"></i>Log In</h2>
        <p class="subtext">Use your existing credentials to log in.</p>
    </div>

    <!-- Login form -->
    <div class="form-wrapper">
        <form method="POST" action="index.php" class="form-auth">

            <!-- Display error message if any -->
            <?php if ($error): ?>
                <p class="error"><?php echo $error; ?></p>
            <?php endif; ?>
            <label>
                Email
                <input type="email" name="email" required>
            </label>

            <label>
                Password
                <input type="password" name="password" required>
            </label>

            <button type="submit">Login</button>

            <p class="form-helper">
                Don't have an account? <a href="signup.php">Sign Up</a>
            </p>
        </form>
    </div>


    <?php include 'includes/footer.php'; ?>
</body>

</html>