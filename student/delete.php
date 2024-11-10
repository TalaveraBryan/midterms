<?php
session_start();

// File where the student data is stored
$studentsFile = 'students.json';

// Check if the ID is set in the URL and if it's numeric
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $deleteId = $_GET['id'];

    // Check if the students file exists and load the data
    if (file_exists($studentsFile)) {
        // Load existing students
        $students = json_decode(file_get_contents($studentsFile), true);

        // Check if the student exists in the array
        if (isset($students[$deleteId])) {
            $student = $students[$deleteId]; // Fetch student details

            // Handle deletion after form submission
            if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['student_id'])) {
                // Handle deletion if the form is submitted
                $deleteId = $_POST['student_id'];

                // Remove the student from the array
                unset($students[$deleteId]);

                // Save the updated student data back to the file
                if (file_put_contents($studentsFile, json_encode($students))) {
                    header("Location: register.php");  // Redirect after deletion
                    exit();
                } else {
                    $_SESSION['error'] = 'Failed to update student data.';
                }
            }
        } else {
            $_SESSION['error'] = 'Student not found.';
            header("Location: register.php");
            exit();
        }
    } else {
        $_SESSION['error'] = 'Failed to load student data.';
        header("Location: register.php");
        exit();
    }
} else {
    $_SESSION['error'] = 'Invalid student ID.';
    header("Location: register.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Student</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-4">
    <!-- Page Title (Left-aligned) -->
    <h1>Delete a Student</h1>

    <!-- Breadcrumbs (Left-aligned) -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="register.php">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="register.php">Registration</a></li>
            <li class="breadcrumb-item active" aria-current="page">Delete Student</li>
        </ol>
    </nav>

    <!-- Error or Success Messages -->
    <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success" role="alert">
            <?php echo $_SESSION['success']; ?>
        </div>
        <?php unset($_SESSION['success']); ?>
    <?php elseif (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger" role="alert">
            <?php echo $_SESSION['error']; ?>
        </div>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>

    <!-- Panel with Delete Confirmation -->
    <div class="card mt-4">
        <div class="card-header">
            <h4>Are you sure you want to delete the following student record?</h4>
        </div>
        <div class="card-body">
            <p><strong>Student ID:</strong> <?php echo $deleteId; ?></p>
            <p><strong>First Name:</strong> <?php echo htmlspecialchars($student['firstName']); ?></p>
            <p><strong>Last Name:</strong> <?php echo htmlspecialchars($student['lastName']); ?></p>
        </div>
        <div class="card-footer">
            <!-- Cancel Button -->
            <button class="btn btn-secondary" onclick="window.location.href='register.php';">Cancel</button>
            
          
            <!-- Delete Form -->
<form action="delete.php?id=<?php echo $deleteId; ?>" method="POST" style="display:inline;">
    <input type="hidden" name="student_id" value="<?php echo $deleteId; ?>">
    <button type="submit" class="btn btn-primary">Delete student record</button> <!-- Changed btn-danger to btn-primary -->
</form>

        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
