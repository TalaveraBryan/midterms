<?php
// Predefined users (email => password)
$users = [
    'user1@email.com' => 'password1',
    'user2@email.com' => 'password2',
    'user3@email.com' => 'password3',
    'user4@email.com' => 'password4',
    'user5@email.com' => 'password5',
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
    }

    // Validate password
    if (empty($password)) {
        $passwordErr = 'Password is required.';
        $errorDetails[] = $passwordErr; // Add error to details array
    }

    // Check if both email and password are provided
    if (empty($emailErr) && empty($passwordErr)) {
        // Check if email exists in predefined users (case-insensitive comparison)
        $emailExists = array_key_exists(strtolower($email), array_change_key_case($users, CASE_LOWER));

        if ($emailExists) {
            // Check if password matches the one in the array (case-sensitive)
            $storedPassword = $users[strtolower($email)];
            if ($storedPassword !== $password) {
                $errorDetails[] = 'Password is incorrect.';
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
