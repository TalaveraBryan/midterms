<?php
session_start(); // Start the session to access session variables

// Check if the user is logged in by checking the session variable
if (!isset($_SESSION['email'])) {
    // Redirect to login page if user is not logged in
    header('Location: index.php');
    exit;
}

// Get the logged-in user's email
$userEmail = $_SESSION['email'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to the System</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <style>
        .card-body {
            padding: 1.5rem;
        }

        /* Divider style */
        .card-divider {
            border-top: 2px solid #ddd; /* Light gray line */
            margin: 1rem 0; /* Spacing between the title and the divider */
        }

        .card-title {
            font-size: 1.25rem;
            font-weight: bold;
            margin-bottom: 0.5rem;
        }

        .card-text {
            font-size: 1rem;
            color: #555;
            margin-bottom: 1rem;
        }

        .card-footer {
            background-color: #f8f9fa;
            border-top: 1px solid #ddd;
            text-align: center;
            padding: 0.75rem;
        }

        .card {
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            margin-bottom: 1.5rem;
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #004085;
        }

        /* Card hover effect for better UI */
        .card:hover {
            box-shadow: 0 8px 12px rgba(0, 0, 0, 0.2);
        }

        /* Container for the page */
        .container {
            max-width: 1200px;
            margin-top: 50px;
        }

        .top {
            font-size: 1.5rem;
            font-weight: 600;
        }
    </style>
</head>
<body>

    <div class="container">
        <!-- Row for the heading and logout button -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="top text-center">Welcome to the System, <?php echo htmlspecialchars($userEmail); ?>!</h2>
            <a href="logout.php" class="btn btn-danger">Logout</a>
        </div>

        <div class="row mt-4">
            <!-- Card 1: Add a Subject -->
            <div class="col-md-6 mb-4">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">Add a Subject</h5>
                        <div class="card-divider"></div> <!-- Divider between title and description -->
                        <p class="card-text">This section allows you to add a new subject in the system. Click the button below to proceed with the adding process.</p>
                        
                        <!-- Button that submits the form and stays empty for now -->
                        <form action="" method="get">
                            <button type="submit" class="btn btn-primary w-100">Add Subject</button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Card 2: Register a Student -->
            <div class="col-md-6 mb-4">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">Register a Student</h5>
                        <div class="card-divider"></div> <!-- Divider between title and description -->
                        <p class="card-text">This section allows you to register a new student in the system. Click the button below to proceed with the registration process.</p>
                        
                        <!-- Button that submits the form and redirects to student/register.php -->
                        <form action="student/register.php" method="get">
                            <button type="submit" class="btn btn-primary w-100">Register</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
