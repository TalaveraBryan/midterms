<?php
// login.php

session_start(); // Start the session to store session variables

// Check if the user is already logged in
if (isset($_SESSION['email'])) {
    // If logged in, redirect to dashboard
    header('Location: dashboard.php');
    exit;
}

// Predefined users (email => password)
$users = [
    'user1@email.com' => 'password1', // password for user1
    'user2@email.com' => 'password2', // password for user2
    'user3@email.com' => 'password3', // password for user3
    'user4@email.com' => 'password4', // password for user4
    'user5@email.com' => 'password5'  // password for user5
];

// Initialize variables
$email = $password = '';
$emailErr = $passwordErr = '';
$errorDetails = [];
$loginError = '';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = trim($_POST['email']);  // Trim leading/trailing spaces
    $password = $_POST['password'];

    // Validate email
    if (empty($email)) {
        $emailErr = 'Email is required.';
        $errorDetails[] = $emailErr; // Add error to details array
    } else {
        // Sanitize and validate email format
        $email = filter_var($email, FILTER_SANITIZE_EMAIL);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $emailErr = 'Invalid email format.';
            $errorDetails[] = $emailErr;
        }
    }

    // Validate password
    if (empty($password)) {
        $passwordErr = 'Password is required.';
        $errorDetails[] = $passwordErr; // Add error to details array
    }

    // Check if both email and password are provided
    if (empty($emailErr) && empty($passwordErr)) {
        // Normalize email to lowercase (case-insensitive comparison)
        $normalizedEmail = strtolower($email);

        // Check if email exists in predefined users (case-insensitive)
        if (array_key_exists($normalizedEmail, $users)) {
            // Compare the entered password with the stored password
            if ($users[$normalizedEmail] !== $password) {
                $errorDetails[] = 'Password is incorrect.';
            } else {
                // If login is successful, store the user's email in the session
                $_SESSION['email'] = $email; // Save email in session
                header('Location: dashboard.php'); // Redirect to dashboard.php
                exit; // Stop further script execution to prevent page rendering
            }
        } else {
            $errorDetails[] = 'Email not found.';
        }
    }

    // If there are errors, set the login error message
    if (!empty($errorDetails)) {
        $loginError = 'System Errors:';
    }
}

// Include the HTML view file
include 'login_view.php';
