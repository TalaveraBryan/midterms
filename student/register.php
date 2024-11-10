<?php
session_start(); // Start the session to store session variables

// Student data storage (In real-world scenario, use a database)
$studentsFile = 'students.json';
$students = [];

// Load existing students from the file
if (file_exists($studentsFile)) {
    $students = json_decode(file_get_contents($studentsFile), true);
}

// Initialize variables
$studentId = $firstName = $lastName = '';
$studentIdErr = $firstNameErr = $lastNameErr = '';
$errorDetails = [];
$successMessage = '';

// Handle form submission (Add new student)
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $studentId = trim($_POST['studentId']);
    $firstName = trim($_POST['firstName']);
    $lastName = trim($_POST['lastName']);

    // Validate Student ID (must be numeric)
    if (empty($studentId)) {
        $studentIdErr = 'Student ID is required.';
        $errorDetails[] = $studentIdErr;
    } elseif (!is_numeric($studentId)) {
        $studentIdErr = 'Student ID must be a numeric value.';
        $errorDetails[] = $studentIdErr;
    } elseif (array_key_exists($studentId, $students)) {
        $studentIdErr = 'Duplicate Student ID.';
        $errorDetails[] = $studentIdErr;
    }

    // Validate First Name
    if (empty($firstName)) {
        $firstNameErr = 'First Name is required.';
        $errorDetails[] = $firstNameErr;
    }

    // Validate Last Name
    if (empty($lastName)) {
        $lastNameErr = 'Last Name is required.';
        $errorDetails[] = $lastNameErr;
    }

    // If no errors, save the student data
    if (empty($errorDetails)) {
        // Add new student to the array
        $students[$studentId] = [
            'firstName' => $firstName,
            'lastName' => $lastName
        ];

        // Save to file (students.json)
        file_put_contents($studentsFile, json_encode($students));

        // Success message
       // $successMessage = 'Student added successfully!';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register a New Student</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h3 class="card-title">Register a New Student</h3><br>

        <div class="container">
        <nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid">
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <!-- Link to subject/dashboard.php, relative path to move out of student folder and into subject folder -->
                <li class="breadcrumb-item"><a href="../subject/dashboard.php">Dashboard</a></li> 
                <!-- Current page, Registration -->
                <li class="breadcrumb-item active" aria-current="page">Registration</li>
            </ol>
        </nav>
    </div>
</nav>

    </div>
</nav>


        </div><br>

        <!-- Error or Success Message -->
        <?php if (!empty($errorDetails)): ?>
            <div id="error-box" class="alert alert-danger" role="alert">
                <strong>System Errors:</strong>
                <ul>
                    <?php foreach ($errorDetails as $error): ?>
                        <li><?php echo $error; ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <?php if ($successMessage): ?>
            <div class="alert alert-success" role="alert"><?= $successMessage; ?></div>
        <?php endif; ?>

        <!-- Registration Form Card -->
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-body">
                <form method="POST" action="">
                    <!-- Student ID input -->
                    <div class="mb-3">
                        <label for="studentId" class="form-label">Student ID</label>
                        <input type="text" class="form-control" id="studentId" name="studentId" value="<?php echo htmlspecialchars($studentId); ?>" placeholder="Enter Student ID">
                    </div>

                    <!-- First Name input -->
                    <div class="mb-3">
                        <label for="firstName" class="form-label">First Name</label>
                        <input type="text" class="form-control" id="firstName" name="firstName" value="<?php echo htmlspecialchars($firstName); ?>" placeholder="Enter First Name">
                    </div>

                    <!-- Last Name input -->
                    <div class="mb-3">
                        <label for="lastName" class="form-label">Last Name</label>
                        <input type="text" class="form-control" id="lastName" name="lastName" value="<?php echo htmlspecialchars($lastName); ?>" placeholder="Enter Last Name">
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="btn btn-primary w-100">Register Student</button>
                </form>
            </div>
        </div>

        <!-- Student List Card -->
        <div class="card shadow-sm border-0">
            <div class="card-body">
                <h3 class="card-title">Student List</h3>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Student ID</th>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Options</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Display the students
                        foreach ($students as $id => $student) {
                            echo "<tr>
                                    <td>{$id}</td>
                                    <td>{$student['firstName']}</td>
                                    <td>{$student['lastName']}</td>
                                    <td>
                                        <a href='edit.php?id={$id}' class='btn btn-primary btn-sm'>Edit</a>
                                        <a href='delete.php?id={$id}' class='btn btn-danger btn-sm'>Delete</a>
                                        <button class='btn btn-warning btn-sm' disabled>Attach Subject</button> <!-- Empty button, no link, and disabled -->
                                    </td>
                                  </tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS (for interactive components like modals) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
