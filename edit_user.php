<?php
include 'includes/db.php';
include 'includes/auth.php';

requireAdmin(); // Ensure only admin can access this page

if (!isset($_GET['id'])) {
    echo "User ID missing.";
    exit;
}

$userId = intval($_GET['id']);

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $newUsername = mysqli_real_escape_string($conn, $_POST['username']);
    $newEmail = mysqli_real_escape_string($conn, $_POST['email']);
    $newRole = $_POST['role'];

    $update = mysqli_query($conn, "UPDATE users SET username = '$newUsername', email = '$newEmail', role = '$newRole' WHERE id = $userId");

    if ($update) {
        header("Location: admin_users.php?updated=1");
        exit;
    } else {
        $error = "Failed to update user.";
    }
}

// Fetch user data to pre-fill form
$result = mysqli_query($conn, "SELECT username, email, role FROM users WHERE id = $userId");
$user = mysqli_fetch_assoc($result);

if (!$user) {
    echo "User not found.";
    exit;
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Edit User – Task Manager</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>

    <?php include 'includes/header.php'; ?>

    <div class="manage-page-title">
        <?php include 'includes/back_nav.php'; ?>
        <h2><i class="fa-solid fa-user-gear"></i>Edit User</h2>
        <p class="subtext">Update user's personal info.</p>
    </div>

    <?php if (isset($error)): ?>
        <p class="error"><?php echo $error; ?></p>
    <?php endif; ?>

    <form method="POST" class="form-card">
        <label>Username:
            <input type="text" name="username" value="<?php echo htmlspecialchars($user['username']); ?>" required>
        </label>
        <label>Email:
            <input type="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
        </label>

        <label>Role:
            <select name="role">
                <option value="user" <?php if ($user['role'] === 'user') echo 'selected'; ?>>User</option>
                <option value="admin" <?php if ($user['role'] === 'admin') echo 'selected'; ?>>Admin</option>
            </select>
        </label>

        <button type="submit" class="btn">💾 Update User</button>
    </form>

    <?php include 'includes/footer.php'; ?>
</body>

</html>