<?php
include 'includes/db.php';

$success = $error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Get and sanitize inputs
  $username = trim($_POST['username']);
  $email = trim($_POST['email']);
  $password = $_POST['password'];
  $role = $_POST['role'];

  // Check if user already exists
  $check = mysqli_query($conn, "SELECT id FROM users WHERE email = '$email'");
  if (mysqli_num_rows($check) > 0) {
    $error = "⚠️ A user with that email already exists.";
  } else {
    // Hash password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Insert new user
    $insert = mysqli_query($conn, "
            INSERT INTO users (username, email, password, role)
            VALUES ('$username', '$email', '$hashedPassword', '$role')
        ");

    if ($insert) {
      $success = "✅ Account created successfully.<p class='form-helper'>You can now <a href='index.php'>log in</a>.</p>";
    } else {
      $error = "❌ Failed to create account. Please try again.";
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
  <title>Sign Up</title>
</head>

<body>
  <?php include 'includes/header.php'; ?>

  <div class="manage-page-title">
    <h2><i class="fa-solid fa-id-card"></i>Sign Up</h2>
    <p class="subtext">Fill in your details below to sign up and get started.</p>
  </div>

  <div class="form-wrapper">
    <form method="POST" action="signup.php">
      <?php if ($error): ?>
        <div class="error"><?php echo $error; ?></div>
      <?php elseif ($success): ?>
        <div class="success"><?php echo $success; ?></div>
      <?php endif; ?>
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
          <option value="admin">Admin</option>
          <option value="user">User</option>
        </select>
      </label>

      <button type="submit">Sign Up</button>

      <p class="form-helper" style="margin-top: 1rem;">Already have an account? <a href="index.php">Log in here</a></p>

    </form>

  </div>

  <?php include 'includes/footer.php'; ?>
</body>

</html>