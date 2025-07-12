<?php
// includes/auth.php

session_start(); // Always needed at the top of session-protected pages

function requireLogin() // Ensure user is logged in
{
    // Redirect if user is not logged in
    if (!isset($_SESSION['user_id'])) {
        header("Location: index.php");
        exit;
    }
}

function requireAdmin() // Ensure user is logged in and is an admin
{
    requireLogin();
    if ($_SESSION['role'] !== 'admin') {
        header("Location: index.php");
        exit;
    }
}
