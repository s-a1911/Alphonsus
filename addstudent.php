<?php
// Establish a connection to the MySQL database named "leassessment"
$link = mysqli_connect("localhost", "root", "", "leassessment");

// Check if the database connection was successful
if (!$link) {
    die("Connection failed: " . mysqli_connect_error());
}

$errors = "";

// Fetch class IDs from the "class" table in the database
$classQuery = "SELECT class_id, name FROM class";
$classResult = mysqli_query($link, $classQuery);

// Check if the class query was successful
if (!$classResult) {
    die("Class query failed: " . mysqli_error($link));
}

$classes = mysqli_fetch_all($classResult, MYSQLI_ASSOC);

// Fetch guardian IDs and names from the "parent_guardian" table in the database
$guardianQuery = "SELECT guardian_id, name FROM parent_guardian";
$guardianResult = mysqli_query($link, $guardianQuery);

// Check if the guardian query was successful
if (!$guardianResult) {
    die("Guardian query failed: " . mysqli_error($link));
}

$guardians = mysqli_fetch_all($guardianResult, MYSQLI_ASSOC);

// Check if the form has been submitted using the POST method
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve user-inputted data from the submitted form
    $pupil_id = $_POST["pupil_id"];
    $class_id = $_POST["class_id"];
    $guardian1_id = $_POST["guardian1_id"];
    $guardian2_id = $_POST["guardian2_id"];
    $name = $_POST["name"];
    $address = $_POST["address"];
    $medical_info = $_POST["medical_info"];

    // Validation: Check if any form fields are empty
    if (empty($pupil_id) || empty($class_id) || empty($guardian1_id) || empty($name) || empty($address) || empty($medical_info)) {
        $errors .= "All fields are required.<br>";
    }

    // Insert data into the "pupil" table if there are no validation errors
    if (empty($errors)) {
        $insert_query = "INSERT INTO pupil (pupil_id, class_id, guardian1_id, guardian2_id, name, address, medical_info) 
                        VALUES ('$pupil_id', '$class_id', '$guardian1_id', '$guardian2_id', '$name', '$address', '$medical_info')";

        // Check if the insertion query was successful
        if (mysqli_query($link, $insert_query)) {
            echo "Student added successfully!";
        } else {
            // Check for duplicate entry error
            $error_code = mysqli_errno($link);
            if ($error_code == 1062) {
                $errors .= "Error: Duplicate entry. The Pupil ID '$pupil_id' already exists in the database.";
            } else {
                $errors .= "Error: " . mysqli_error($link) . "<br>";
            }
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
    <link rel="stylesheet" type="text/css" href="styles.css">
    <title>Add Student - St Alphonsus R.C. Primary School</title>
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
            <a href="index.html" class="dropbtn" id="home-btn">Homepage</a>
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
        <h1>Add Student</h1>

        <?php
        // Display errors, if any
        if (!empty($errors)) {
            echo '<div style="color: red;">' . $errors . '</div>';
        }
        ?>

        <!-- Form for Adding a Student -->
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" class="styled-form">
            <label for="pupil_id">Pupil ID:</label>
            <input type="number" name="pupil_id" id="pupil_id" required>

            <label for="class_id">Class ID:</label>
            <select name="class_id" id="class_id" required>
                <?php foreach ($classes as $class) : ?>
                    <option value="<?php echo $class['class_id']; ?>"><?php echo $class['name']; ?></option>
                <?php endforeach; ?>
            </select>

            <label for="guardian1_id">Guardian 1 ID:</label>
            <select name="guardian1_id" id="guardian1_id" required>
                <?php foreach ($guardians as $guardian) : ?>
                    <option value="<?php echo $guardian['guardian_id']; ?>"><?php echo $guardian['name']; ?></option>
                <?php endforeach; ?>
            </select>

            <label for="guardian2_id">Guardian 2 ID:</label>
            <select name="guardian2_id" id="guardian2_id">
                <?php foreach ($guardians as $guardian) : ?>
                    <option value="<?php echo $guardian['guardian_id']; ?>"><?php echo $guardian['name']; ?></option>
                <?php endforeach; ?>
            </select>

            <label for="name">Name:</label>
            <input type="text" name="name" id="name" required>

            <label for="address">Address:</label>
            <input type="text" name="address" id="address" required>

            <label for="medical_info">Medical Info:</label>
            <input type="text" name="medical_info" id="medical_info" required>

            <button type="submit">Add Student</button>
        </form>
    </div>

    <div class="footer">
        <p>&copy; 2023 St Alphonsus R.C. Primary School</p>
    </div>

</body>

</html>
