<?php
// Establish a connection to the MySQL database
$link = mysqli_connect("localhost", "root", "", "leassessment");

// Check if the connection is successful
if (!$link) {
    die("Connection failed: " . mysqli_connect_error());
}

// Initialize variables to store errors and login success status
$errors = "";
$loginSuccess = false;
$redirectUrl = "";

// Check if the form is submitted using the POST method
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve username and password from the form
    $teacherUsername = $_POST["teacher_username"];
    $teacherPassword = $_POST["teacher_password"];

    // Validation
    if (empty($teacherUsername) || empty($teacherPassword)) {
        $errors .= "Teacher username and password are required fields.<br>";
    }

    // Check login credentials if no errors
    if (empty($errors)) {
        // SQL query to check if the provided credentials match a teacher record
        $login_query = "SELECT * FROM teacher WHERE teacher_username = '$teacherUsername' AND teacher_password = '$teacherPassword'";
        $login_result = mysqli_query($link, $login_query);

        // Check if the query was successful
        if ($login_result !== false) {
            // Check the number of rows returned
            $num_rows = mysqli_num_rows($login_result);

            // If there is a match, set loginSuccess to true
            if ($num_rows > 0) {
                $user = mysqli_fetch_assoc($login_result);
                $loginSuccess = true;
                $redirectUrl = 'teacherindex.html'; // Redirect URL for successful login
            } else {
                $errors .= "Invalid teacher username or password.<br>";
            }
        } else {
            // Display the MySQL error for debugging purposes
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
    <link rel="stylesheet" type="text/css" href="styles.css">
    <style>
        /* Styles for the HTML document */
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f2f2f2;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            margin: 0;
        }

        .content {
            flex: 1;
            padding: 20px;
        }

        form {
            margin-top: 20px;
        }

        form input {
            margin-bottom: 10px;
        }

        form input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        form input[type="submit"]:hover {
            background-color: #45a049;
        }

        .footer {
            text-align: center;
            padding: 20px;
            background-color: #333;
            color: white;
        }

        .admin-login {
            text-align: center;
            margin-bottom: 20px;
        }

        .admin-login label {
            font-weight: bold;
        }

        .admin-login button {
            background-color: #3498db;
            color: white;
            padding: 8px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 5px;
        }

        .admin-login button:hover {
            background-color: #2980b9;
        }

        .teacher-login {
            text-align: center;
            margin-top: 20px;
        }

        .teacher-login label {
            font-weight: bold;
        }

        .teacher-login button {
            background-color: #e74c3c;
            color: white;
            padding: 8px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 5px;
        }

        .teacher-login button:hover {
            background-color: #c0392b;
        }
    </style>
    <title>Teacher Login</title>
</head>

<body>

    <div class="content">
        <div class="admin-login">
            <label>Admin Login</label>
            <!-- Button to redirect to the admin login page -->
            <button onclick="location.href='login.php'">Login</button>
        </div>

        <h2>Teacher Login</h2>

        <?php
        // Display success message and redirect if login is successful
        if ($loginSuccess) {
            echo '<p id="successMessage">Login successful!</p>';
        ?>
            <script>
                setTimeout(function() {
                    window.location.href = "<?php echo $redirectUrl; ?>";
                }, 2000); // Redirect after 2 seconds
            </script>
        <?php
        } else {
            // Display errors or login form
            if (!empty($errors)) {
                echo '<div style="color: red;">' . $errors . '</div>';
            }
        ?>
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                <!-- Input fields for teacher username and password -->
                Teacher Username: <input type="text" name="teacher_username" required><br>
                Teacher Password: <input type="password" name="teacher_password" required><br>
                <!-- Submit button for the login form -->
                <input type="submit" value="Login">
            </form>
        <?php
        }
        ?>

    </div>

    <div class="footer">
        <p>&copy; 2023 St Alphonsus R.C. Primary School</p>
    </div>

</body>
</html>
