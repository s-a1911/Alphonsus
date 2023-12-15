<?php
// Establish a connection to the database
$link = mysqli_connect("localhost", "root", "", "leassessment");

// Check if the connection is successful; otherwise, display an error and terminate
if (!$link) {
    die("Connection failed: " . mysqli_connect_error());
}

$errors = "";

// Process the form data when the HTTP POST method is used
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $teacher_id = $_POST["teacher_id"];
    $name = $_POST["name"];
    $address = $_POST["address"];
    $phone_number = $_POST["phone_number"];
    $salary = $_POST["salary"];
    $bg_check_status = isset($_POST["bg_check_status"]) ? $_POST["bg_check_status"] : "No"; // Default to "No"
    $teacher_username = $_POST["teacher_username"];
    $teacher_password = $_POST["teacher_password"];

    // Validate form fields
    if (empty($teacher_id) || empty($name) || empty($address) || empty($phone_number) || empty($salary) || empty($teacher_username) || empty($teacher_password)) {
        $errors .= "All fields are required.<br>";
    }

    // Insert data into the database if there are no errors
    if (empty($errors)) {
        $insert_query = "INSERT INTO teacher (teacher_id, name, address, phone_number, salary, bg_check_status, teacher_username, teacher_password) 
                        VALUES ('$teacher_id', '$name', '$address', '$phone_number', '$salary', '$bg_check_status', '$teacher_username', '$teacher_password')";
        
        // Execute the query and provide feedback
        if (mysqli_query($link, $insert_query)) {
            echo "Teacher added successfully!";
        } else {
            // Handle errors, including duplicate entry error
            $errors .= "Error: " . $insert_query . "<br>" . mysqli_error($link);
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
    <title>Add Teacher</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>

<body>

<div class="navbar">
    <!-- Navigation dropdowns for Add, Update, Delete, and Homepage -->
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

    <div class="dropdown">
        <a href="#" class="dropbtn">Update</a>
        <div class="dropdown-content">
            <a href="updatestudent.php">Update Student</a>
            <a href="updateteacher.php">Update Teacher</a>
            <a href="updateparent.php">Update Parent</a>
            <a href="updateclass.php">Update Class</a>
            <a href="updateuser.php">Update User</a>
        </div>
    </div>

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

    <!-- Homepage link and school logo -->
    <div class="dropdown">
        <a href="index.html" class="dropbtn" id="home-btn">Homepage</a>
    </div>

    <div class="logo">
        <img src="download.jpeg" alt="St Alphonsus R.C. Primary School">
    </div>
</div>

<div class="content">
    <h2>Add Teacher</h2>

    <?php
    // Display errors, if any
    if (!empty($errors)) {
        echo '<div style="color: red;">' . $errors . '</div>';
    }
    ?>

    <!-- Teacher information form -->
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        <label for="teacher_id">Teacher ID:</label>
        <input type="number" name="teacher_id" required><br>

        <label for="name">Name:</label>
        <input type="text" name="name" required><br>

        <label for="address">Address:</label>
        <input type="text" name="address" required><br>

        <label for="phone_number">Phone Number:</label>
        <input type="number" name="phone_number" required><br>

        <label for="salary">Salary:</label>
        <input type="number" name="salary" step="0.01" required><br>

        <label for="bg_check_status">BG Check Status:</label>
        <input type="radio" name="bg_check_status" value="Yes"> Yes
        <input type="radio" name="bg_check_status" value="No" checked> No
        <br>

        <label for="teacher_username">Teacher Username:</label>
        <input type="text" name="teacher_username" required><br>

        <label for="teacher_password">Teacher Password:</label>
        <input type="password" name="teacher_password" required><br>

        <input type="submit" value="Add Teacher">
    </form>
</div>

<div class="footer">
    <p>&copy; 2023 St Alphonsus R.C. Primary School</p>
</div>

</body>

</html>
