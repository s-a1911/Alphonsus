<?php
// Establishing a connection to the database
$link = mysqli_connect("localhost", "root", "", "leassessment");

// Check if the connection to the database failed
if (!$link) {
    die("Connection failed: " . mysqli_connect_error());
}

// Initialize variable for errors
$errors = "";

// Check if the user registration form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect form data
    $user_id = $_POST["user_id"];
    $username = $_POST["username"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $admin_id = $_POST["admin_id"];

    // Validation for required fields
    if (empty($user_id) || empty($username) || empty($email) || empty($password) || empty($admin_id)) {
        $errors .= "All fields are required.<br>";
    }

    // Additional validation for password length
    if (strlen($password) < 8) {
        $errors .= "Password must be at least 8 characters long.<br>";
    }

    // Insert data if no errors
    if (empty($errors)) {
        $insert_query = "INSERT INTO user (user_id, username, email, password, admin_id) 
                        VALUES ('$user_id', '$username', '$email', '$password', '$admin_id')";
        
        if (mysqli_query($link, $insert_query)) {
            echo "User registered successfully!";
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
    <title>User Registration</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>

    <!-- Navigation Bar -->
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

        <div class="dropdown">
            <a href="index.html" class="dropbtn" id="home-btn">Homepage</a>
        </div>

        <div class="logo">
            <img src="download.jpeg" alt="St Alphonsus R.C. Primary School">
        </div>
    </div>

    <!-- Content Section -->
    <div class="content">
        <h2>User Registration</h2>

        <?php
        // Display errors if any
        if (!empty($errors)) {
            echo '<div style="color: red;">' . $errors . '</div>';
        }
        ?>

        <!-- User Registration Form -->
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
            User ID: <input type="number" name="user_id" required><br>
            Username: <input type="text" name="username" required><br>
            Email: <input type="email" name="email" required><br>
            Password: <input type="password" name="password" required><br>
            Admin ID: <input type="number" name="admin_id" required><br>
            <input type="submit" value="Register">
        </form>
    </div>

    <!-- Footer Section -->
    <div class="footer">
        <p>&copy; 2023 St Alphonsus R.C. Primary School</p>
    </div>

</body>
</html>
