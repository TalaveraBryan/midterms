<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register a New Student</title>
    
    <!-- Link to Bootstrap CSS (from CDN) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    
    <div class="container mt-5">
        <h3 class="card-title">Register a New Student</h3><br>
        
        <div class="container">
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Registration</li>
                </ol>
            </nav>
        </div>
    </nav>
</div><br>

        
        <!-- Registration Form Card -->
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-body">
                <!-- Form to Register Student -->
                <form id="registrationForm" onsubmit="return handleRegister(event)">
                    <!-- Student ID input -->
                    <div class="mb-3">
                        <label for="studentId" class="form-label">Student ID</label>
                        <input type="text" class="form-control" id="studentId" placeholder="Enter Student ID" required>
                    </div>

                    <!-- First Name input -->
                    <div class="mb-3">
                        <label for="firstName" class="form-label">First Name</label>
                        <input type="text" class="form-control" id="firstName" placeholder="Enter First Name" required>
                    </div>

                    <!-- Last Name input -->
                    <div class="mb-3">
                        <label for="lastName" class="form-label">Last Name</label>
                        <input type="text" class="form-control" id="lastName" placeholder="Enter Last Name" required>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="btn btn-primary w-100">Add Student</button>
                </form>
            </div>
        </div>
 
        <!-- Student List Card -->
        <div class="card shadow-sm border-0">
            <div class="card-body">
                <h3 class="card-title">Student List</h3>

                <!-- Table to Display Registered Students -->
                <table class="table table-striped" id="studentListTable">
                    <thead>
                        <tr>
                            <th>Student ID</th>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Option</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Student rows will be added here dynamically -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS (for interactive components like modals) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Custom JavaScript -->
    <script>
        // Array to store the student data
        let studentList = [];

        // Handle student registration form submission
        function handleRegister(event) {
            event.preventDefault();

            const studentId = document.getElementById('studentId').value;
            const firstName = document.getElementById('firstName').value;
            const lastName = document.getElementById('lastName').value;

            // Create student object
            const student = {
                studentId,
                firstName,
                lastName
            };

            // Add the student to the list
            studentList.push(student);

            // Reset the form after submission
            document.getElementById('registrationForm').reset();

            // Display the updated student list in the table
            displayStudentList();
        }

        // Function to display the student list in the table
        function displayStudentList() {
            const tableBody = document.getElementById('studentListTable').getElementsByTagName('tbody')[0];
            tableBody.innerHTML = ''; // Clear existing rows

            studentList.forEach(student => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>${student.studentId}</td>
                    <td>${student.firstName}</td>
                    <td>${student.lastName}</td>
                    <td>
                        <button class="btn btn-primary btn-sm" onclick="editStudent('${student.studentId}')">Edit</button>
                        <button class="btn btn-danger btn-sm" onclick="removeStudent('${student.studentId}')">Delete</button>
                        <button class="btn btn-warning btn-sm" onclick="attachStudent('${student.studentId}')">Attach</button>
                    </td>
                `;
                tableBody.appendChild(row);
            });
        }

        // Function to remove a student from the list
        function removeStudent(studentId) {
            // Filter out the student by ID
            studentList = studentList.filter(student => student.studentId !== studentId);

            // Update the table after removal
            displayStudentList();
        }

        // Function to handle student editing (for future implementation)
        function editStudent(studentId) {
            // You can add logic to edit the student details (e.g., show a form with existing details)
            alert('Edit student with ID: ' + studentId);
        }

        // Function to attach a student (for future implementation)
        function attachStudent(studentId) {
            // You can add logic to attach the student to another system/resource
            alert('Attach student with ID: ' + studentId);
        }
    </script>
</body>
</html> 
