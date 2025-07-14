<?php
include 'includes/db.php';

// ✅ Define user emails and their current plaintext passwords
$users = [
    'alice@example.com' => 'alice123',
    'bob@example.com'   => 'bob123',
    'charlie@example.com'  => 'charlie123',
    'daisy@example.com' => 'daisy123'
];

// ✅ Loop through each user and update their password
foreach ($users as $email => $plainPassword) {
    $hashedPassword = password_hash($plainPassword, PASSWORD_DEFAULT);

    $update = mysqli_query($conn, "
        UPDATE users 
        SET password = '$hashedPassword' 
        WHERE email = '$email'
    ");

    if ($update) {
        echo "✅ Password updated for $email<br>";
    } else {
        echo "❌ Failed to update password for $email<br>";
    }
}
?>
