<?php
// Establish a connection to the MySQL database named "leassessment"
$link = mysqli_connect("localhost", "root", "", "leassessment");

// Check if the connection was successful
if (!$link) {
    die("Connection failed: " . mysqli_connect_error());
}

$errors = "";

// Fetch teacher IDs and names from the database
$teacherQuery = "SELECT teacher_id, name FROM teacher";
$teacherResult = mysqli_query($link, $teacherQuery);

// Check if the query to fetch teachers was successful
if (!$teacherResult) {
    die("Query failed: " . mysqli_error($link));
}

// Fetch all teachers and their IDs
$teachers = mysqli_fetch_all($teacherResult, MYSQLI_ASSOC);

// Check if the form has been submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve data from the submitted form
    $teacher_id = $_POST["teacher_id"];
    $class_id = $_POST["class_id"];
    $name = $_POST["name"];
    $class_limit = $_POST["class_limit"];

    // Validation: Check if any form fields are empty
    if (empty($teacher_id) || empty($class_id) || empty($name) || empty($class_limit)) {
        $errors .= "All fields are required.<br>";
    }

    // Fetch teacher name based on the selected Teacher ID
    $teacherQuery = "SELECT name FROM teacher WHERE teacher_id = '$teacher_id'";
    $teacherResult = mysqli_query($link, $teacherQuery);

    // Check if the query to fetch the teacher name was successful
    if (!$teacherResult) {
        die("Query failed: " . mysqli_error($link));
    }

    // Fetch the teacher's name
    $teacher = mysqli_fetch_assoc($teacherResult);

    // Insert data into the "class" table if there are no validation errors
    if (empty($errors)) {
        $insert_query = "INSERT INTO class (teacher_id, class_id, name, class_limit) 
                        VALUES ('$teacher_id', '$class_id', '$name', '$class_limit')";
        
        // Check if the insertion query was successful
        if (mysqli_query($link, $insert_query)) {
            echo "Class added successfully!";
        } else {
            $errors .= "Error: " . mysqli_error($link) . "<br>";
        }
    }

    // Close the database connection
    mysqli_close($link);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Add Class</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>

    <!-- Navigation Bar -->
    <div class="navbar">
        <!-- School Logo -->
        <div class="logo">
            <img src="download.jpeg" alt="St Alphonsus R.C. Primary School">
        </div>

        <!-- Dropdown Menu for Adding, Updating, and Deleting -->
        <div class="dropdown">
            <a href="#" class="dropbtn">Add</a>
            <div class="dropdown-content">
                <a href="addstudent.php">Add Student</a>
                <a href="addteacher.php">Add Teacher</a>
                <a href="addparent.php">Add Parent</a>
                <a href="addclass.php">Add Class</a>
                <a href="register.php">Add User</a>
            </div>
        </div>

        <!-- Dropdown Menu for Updating -->
        <div class="dropdown">
            <a href="#" class="dropbtn">Update</a>
            <div class="dropdown-content">
                <a href="updatestudent.php">Update Student</a>
                <a href="updateteacher.php">Update Teacher</a>
                <a href="updateparent.php">Update Parent</a>
                <a href="updateclass.php">Update Class</a>
                <a href="updateuser.php">Update Users</a>
            </div>
        </div>

        <!-- Dropdown Menu for Deleting -->
        <div class="dropdown">
            <a href="#" class="dropbtn">Delete</a>
            <div class="dropdown-content">
                <a href="deletestudent.php">Delete Student</a>
                <a href="deleteuser.php">Delete User</a>
                <a href="deleteteacher.php">Delete Teacher</a>
                <a href="deleteparent.php">Delete Parent</a>
                <a href="deleteclass.php">Delete Class</a>
            </div>
        </div>

        <!-- Button for Returning to Homepage -->
        <div class="dropdown">
            <a href="index.html" class="dropbtn" id="home-btn">Homepage</a>
        </div>
    </div>

    <!-- Main Content Area -->
    <div class="content">
        <h2>Add Class</h2>

        <?php
        // Display errors, if any
        if (!empty($errors)) {
            echo '<div style="color: red;">' . $errors . '</div>';
        }
        ?>

        <!-- Form for Adding a Class -->
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
            <!-- Dropdown for Selecting a Teacher -->
            Teacher: 
            <select name="teacher_id" id="teacher_id" required>
                <?php 
                // Display teacher options
                foreach ($teachers as $teacher) : ?>
                    <option value="<?php echo $teacher['teacher_id']; ?>"><?php echo $teacher['name']; ?></option>
                <?php endforeach; ?>
            </select><br>

            <!-- Input Fields for Class ID, Name, and Class Limit -->
            Class ID: <input type="number" name="class_id" required><br>
            Name: <input type="text" name="name" required><br>
            Class Limit: <input type="number" name="class_limit" required><br>

            <!-- Submit Button -->
            <input type="submit" value="Add Class">
        </form>
    </div>

    <!-- Footer -->
    <div class="footer">
        <p>&copy; 2023 St Alphonsus R.C. Primary School</p>
    </div>

</body>
</html>
