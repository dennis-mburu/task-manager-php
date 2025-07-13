<?php
include 'includes/db.php';

$adminEmail = 'admin@email.com';
$currentPlainPassword = 'admin123'; 
$newHashedPassword = password_hash($currentPlainPassword, PASSWORD_DEFAULT);

// Update password in DB
$update = mysqli_query($conn, "
    UPDATE users 
    SET password = '$newHashedPassword' 
    WHERE email = '$adminEmail' 
");

if ($update) {
    echo "✅ Admin password rehashed successfully.<br>";
    echo "You can now log in securely.";
} else {
    echo "❌ Failed to update admin password.";
}
?>
