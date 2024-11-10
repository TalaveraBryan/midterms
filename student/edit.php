<?php
session_start();

// File where the student data is stored
$studentsFile = 'students.json';

// Check if the ID is set in the URL and if it's numeric
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $editId = $_GET['id'];

    // Check if the students file exists and load the data
    if (file_exists($studentsFile)) {
        // Load existing students
        $students = json_decode(file_get_contents($studentsFile), true);

        // Check if the student exists in the array
        if (isset($students[$editId])) {
            $student = $students[$editId]; // Fetch student details

            // Handle form submission to save edited student data
            if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['student_id'])) {
                $studentId = $_POST['student_id'];
                $firstName = $_POST['first_name'];
                $lastName = $_POST['last_name'];

                // Update the student data
                $students[$studentId]['firstName'] = $firstName;
                $students[$studentId]['lastName'] = $lastName;

                // Save the updated student data back to the file
                if (file_put_contents($studentsFile, json_encode($students))) {
                    //$_SESSION['success'] = 'Student information updated successfully.';
                    header("Location: register.php");  // Redirect after successful edit
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
    <title>Edit Student</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-4">
    <!-- Page Title (Left-aligned) -->
    <h1>Edit Student</h1>

    <!-- Breadcrumbs (Left-aligned) -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="register.php">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="register.php">Registration</a></li>
            <li class="breadcrumb-item active" aria-current="page">Edit Student</li>
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

    <!-- Panel with Edit Form -->
    <div class="card mt-4">
       
        <div class="card-body">
            <form action="edit.php?id=<?php echo $editId; ?>" method="POST">
                <input type="hidden" name="student_id" value="<?php echo $editId; ?>">

                <!-- Display Student ID (Uneditable) -->
                <div class="form-group">
                    <label for="student_id">Student ID</label>
                    <input type="text" class="form-control" id="student_id" name="student_id" value="<?php echo htmlspecialchars($editId); ?>" disabled>
                </div>

                <!-- First Name input -->
                <div class="form-group">
                    <label for="first_name">First Name</label>
                    <input type="text" class="form-control" id="first_name" name="first_name" value="<?php echo htmlspecialchars($student['firstName']); ?>" required>
                </div>

                <!-- Last Name input -->
                <div class="form-group">
                    <label for="last_name">Last Name</label>
                    <input type="text" class="form-control" id="last_name" name="last_name" value="<?php echo htmlspecialchars($student['lastName']); ?>" required>
                </div>

                <!-- Updated button label from Save Changes to Update -->
                <button type="submit" class="btn btn-primary">Update Student</button>
            </form>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
