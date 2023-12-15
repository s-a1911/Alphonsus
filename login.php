<?php
// Establishing a connection to the database
$link = mysqli_connect("localhost", "root", "", "leassessment");

// Check if the connection to the database failed
if (!$link) {
    die("Connection failed: " . mysqli_connect_error());
}

// Initialize variables
$errors = "";
$loginSuccess = false;
$redirectUrl = "";

// Check if the login form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Validation for username and password
    if (empty($username) || empty($password)) {
        $errors .= "Username and password are required fields.<br>";
    }

    // Check login credentials if no validation errors
    if (empty($errors)) {
        $login_query = "SELECT * FROM user WHERE username = '$username' AND password = '$password'";
        $login_result = mysqli_query($link, $login_query);

        // Check if the login query was successful
        if ($login_result !== false) {
            // Check the number of rows only if the query was successful
            $num_rows = mysqli_num_rows($login_result);

            // Process login result
            if ($num_rows > 0) {
                $user = mysqli_fetch_assoc($login_result);
                $loginSuccess = true;
                $redirectUrl = 'index.html'; // Updated to index.html
            } else {
                $errors .= "Invalid username or password.<br>";
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
        /* Global Styles */
        body {
            font-family: 'Arial', sans-serif; /* Set default font family */
            background-color: #f2f2f2; /* Set background color */
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            margin: 0;
        }

        .content {
            flex: 1;
            padding: 20px; /* Add padding to the main content area */
        }

        /* Form Styles */
        form {
            margin-top: 20px; /* Add margin to the top of the form */
        }

        form input {
            margin-bottom: 10px; /* Add margin to the bottom of form inputs */
        }

        form input[type="submit"] {
            background-color: #4CAF50; /* Green button color */
            color: white;
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        form input[type="submit"]:hover {
            background-color: #45a049; /* Darker green button color on hover */
        }

        /* Footer Styles */
        .footer {
            text-align: center;
            padding: 20px;
            background-color: #333; /* Dark background color for the footer */
            color: white;
        }

        /* Admin Login Styles */
        .admin-login {
            text-align: center;
            margin-bottom: 20px;
        }

        .admin-login label {
            font-weight: bold;
        }

        .admin-login button {
            background-color: #3498db; /* Blue button color for admin login */
            color: white;
            padding: 8px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 5px;
        }

        .admin-login button:hover {
            background-color: #2980b9; /* Darker blue button color on hover */
        }

        /* Teacher Login Styles */
        .teacher-login {
            text-align: center;
            margin-top: 20px;
        }

        .teacher-login label {
            font-weight: bold;
        }

        .teacher-login button {
            background-color: #e74c3c; /* Red button color for teacher login */
            color: white;
            padding: 8px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 5px;
        }

        .teacher-login button:hover {
            background-color: #c0392b; /* Darker red button color on hover */
        }
    </style>
    <title>Login</title>
</head>
<body>

    <div class="content">
        <div class="admin-login">
            <label>Admin Login</label>
        </div>

        <h2>Login</h2>

        <?php
        // Display success message and redirect using JavaScript
        if ($loginSuccess) {
            echo '<p id="successMessage">Login successful!</p>';
        ?>
            <script>
                // JavaScript to redirect the user based on the role
                setTimeout(function() {
                    window.location.href = "<?php echo $redirectUrl; ?>";
                }, 2000); // Redirect after 2 seconds
            </script>
        <?php
        } else {
            // Display errors if any
            if (!empty($errors)) {
                echo '<div style="color: red;">' . $errors . '</div>';
            }
        ?>
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                Username: <input type="text" name="username" required><br>
                Password: <input type="password" name="password" required><br>
                <input type="submit" value="Login">
            </form>

            <!-- Teacher Login Section -->
            <div class="teacher-login">
                <label>Teacher Login</label>
                <button onclick="location.href='teacherlogin.php'">Login</button>
            </div>
        <?php
        }
        ?>
    </div>

    <!-- Footer Section -->
    <div class="footer">
        <p>&copy; 2023 St Alphonsus R.C. Primary School</p>
    </div>

</body>
</html>