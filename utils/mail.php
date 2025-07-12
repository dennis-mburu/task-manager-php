<?php
// utils/mail.php
// Simple wrapper for sending notification emails

function sendTaskEmail($to_email, $task_title, $deadline) {
    $subject = "📌 New Task Assigned: $task_title";

    $message = "Hello,\n\n";
    $message .= "A new task has been assigned to you:\n";
    $message .= "Task: $task_title\n";
    $message .= "Deadline: $deadline\n\n";
    $message .= "Please log in to your dashboard to view details.\n\n";
    $message .= "Thanks,\nTask Manager App";

    $headers = "From: no-reply@taskmanager.local";

    // 🔧 You can customize this domain name for local or real SMTP

    // ✅ Send the email using PHP's built-in function
    return mail($to_email, $subject, $message, $headers);
}
?>
