<?php
include 'includes/db.php';
include 'includes/auth.php';
requireLogin();

$userId = $_SESSION['user_id'];

$result = mysqli_query($conn, "SELECT username, email FROM users WHERE id = $userId");
$user = mysqli_fetch_assoc($result);

$success = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $newUsername = mysqli_real_escape_string($conn, $_POST['username']);
    $newEmail = mysqli_real_escape_string($conn, $_POST['email']);
    $currentPassword = $_POST['current_password'];
    $newPassword = $_POST['new_password'];

    // Get current hashed password
    $pwResult = mysqli_query($conn, "SELECT password FROM users WHERE id = $userId");
    $pwRow = mysqli_fetch_assoc($pwResult);

    // Verify current password
    if (!password_verify($currentPassword, $pwRow['password'])) {
        $error = "❌ Current password is incorrect.";
    } else {
        // Update password if provided
        $updatePasswordQuery = "";
        if (!empty($newPassword)) {
            $hashedNew = password_hash($newPassword, PASSWORD_DEFAULT);
            $updatePasswordQuery = ", password = '$hashedNew'";
        }

        $update = mysqli_query($conn, "
            UPDATE users 
            SET username = '$newUsername', email = '$newEmail' $updatePasswordQuery 
            WHERE id = $userId
        ");

        if ($update) {
            $_SESSION['username'] = $newUsername;
            $success = "✅ Profile updated successfully.";
        } else {
            $error = "❌ Failed to update profile.";
        }
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Manage Profile</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <?php include 'includes/header.php'; ?>
    <div class="manage-page-title">
        <?php include 'includes/back_nav.php'; ?>
        <h2><i class="fa-solid fa-user-gear"></i>Manage Your Profile</h2>
        <p class="subtext">Update your personal info and change your password securely.</p>
    </div>


    <div class="form-wrapper">


        <form method="POST">
            <?php if ($success): ?><p class="success"><?php echo $success; ?></p><?php endif; ?>
            <?php if ($error): ?><p class="error"><?php echo $error; ?></p><?php endif; ?>

            <label>Username:
                <input type="text" name="username" value="<?php echo htmlspecialchars($user['username']); ?>" required>
            </label>
            <label>Email:
                <input type="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
            </label>
            <label>Current Password:
                <input type="password" name="current_password" required>
            </label>
            <label>New Password (leave blank to keep current password):
                <input type="password" name="new_password">
            </label>
            <button type="submit" class="btn">Update Profile</button>
        </form>
    </div>

    <?php include 'includes/footer.php'; ?>
    <script src="js/scripts.js"></script>
</body>

</html>