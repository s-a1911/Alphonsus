<?php
// Establish a connection to the MySQL database named "leassessment"
$link = mysqli_connect("localhost", "root", "", "leassessment");

// Check if the database connection was successful
if (!$link) {
    die("Connection failed: " . mysqli_connect_error());
}

$errors = "";

// Check if the form has been submitted using the POST method
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve user-inputted data from the submitted form
    $guardian_id = $_POST["guardian_id"];
    $name = $_POST["name"];
    $tel_number = $_POST["tel_number"]; // Update to the correct column name
    $email = $_POST["email"];
    $address = $_POST["address"];

    // Validation: Check if any form fields are empty
    if (empty($guardian_id) || empty($name) || empty($tel_number) || empty($email) || empty($address)) {
        $errors .= "All fields are required.<br>";
    }

    // Insert data into the "parent_guardian" table if there are no validation errors
    if (empty($errors)) {
        $insert_query = "INSERT INTO parent_guardian (guardian_id, name, tel_number, email, address) 
                        VALUES ('$guardian_id', '$name', '$tel_number', '$email', '$address')";
        
        // Check if the insertion query was successful
        if (mysqli_query($link, $insert_query)) {
            echo "Parent/Guardian added successfully!";
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
    <title>Add Parent/Guardian</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>

<div class="navbar">
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

        <div class="logo">
            <img src="download.jpeg" alt="St Alphonsus R.C. Primary School">
        </div>

        <h1>St Alphonsus R.C. Primary School - ADMINISTRATOR ACCESS</h1>
    </div>

<div class="content">
    <h2>Add Parent/Guardian</h2>

    <?php
    // Display errors, if any
    if (!empty($errors)) {
        echo '<div style="color: red;">' . $errors . '</div>';
    }
    ?>

    <!-- Form for Adding a Parent/Guardian -->
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        <label for="guardian_id">Parent/Guardian ID:</label>
        <input type="text" name="guardian_id" id="guardian_id" required>

        <label for="name">Name:</label>
        <input type="text" name="name" id="name" required>

        <label for="tel_number">Telephone Number:</label>
        <input type="text" name="tel_number" id="tel_number" required>

        <label for="email">Email:</label>
        <input type="email" name="email" id="email" required>

        <label for="address">Address:</label>
        <input type="text" name="address" id="address" required>

        <input type="submit" value="Add Parent/Guardian">
    </form>
</div>

</body>
</html>
