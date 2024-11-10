<?php
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
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bootstrap Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container d-flex justify-content-center align-items-center min-vh-100">
        <div class="w-100" style="max-width: 400px;">
            <!-- Error Message -->
            <?php if (!empty($loginError)): ?>
                <div id="error-box" class="alert alert-danger" role="alert">
                    <strong><?php echo $loginError; ?></strong>
                    <ul>
                        <?php foreach ($errorDetails as $error): ?>
                            <li><?php echo $error; ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <!-- Login Form -->
            <div class="card shadow-sm">
                <div class="card-body">
                    <h3 class="card-title text-center mb-4">Login</h3>
                    <form method="POST" id="login-form">
                        <div class="mb-3">
                            <label for="email" class="form-label">Email address</label>
                            <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>" placeholder="Enter email">
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password" placeholder="Password">
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Login</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5 JS, Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
