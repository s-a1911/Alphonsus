<?php
// Establishing a connection to the MySQL database
$link = mysqli_connect("localhost", "root", "", "leassessment");

// Checking if the connection was successful
if (!$link) {
    die("Connection failed: " . mysqli_connect_error());
}

// Handling the form submission and updating a user's information
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["update_user_id"])) {
    // Retrieving and sanitizing data from the form
    $updateUserId = mysqli_real_escape_string($link, $_POST["update_user_id"]);
    $updateUsername = mysqli_real_escape_string($link, $_POST["update_username"]);
    $updateEmail = mysqli_real_escape_string($link, $_POST["update_email"]);
    $updatePassword = mysqli_real_escape_string($link, $_POST["update_password"]);

    // Constructing the SQL query to update the user's record
    $updateQuery = "UPDATE user SET
                    username = '$updateUsername',
                    email = '$updateEmail',
                    password = '$updatePassword'
                    WHERE user_id = '$updateUserId'";

    // Executing the update query and displaying a success or error message
    if (mysqli_query($link, $updateQuery)) {
        echo "<p>User updated successfully.</p>";
    } else {
        echo "<p>Error updating user: " . mysqli_error($link) . "</p>";
    }
}

// Fetching all user data from the database
$query = "SELECT * FROM user";
$result = mysqli_query($link, $query);

// Checking if the query was successful
if (!$result) {
    die("Query failed: " . mysqli_error($link));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Setting the character set and viewport for the HTML document -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Manage Users</title>
    <!-- Linking to the external stylesheet -->
    <link rel="stylesheet" href="styles.css">
</head>
<body>

<!-- Navigation bar for the web application -->
<div class="navbar">
    <!-- Dropdown menu for adding various entities -->
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

    <!-- Dropdown menu for updating various entities -->
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

    <!-- Dropdown menu for deleting various entities -->
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

    <!-- Dropdown menu for navigating to the homepage -->
    <div class="dropdown">
        <a href="index.html" class="dropbtn" id="home-btn">Homepage</a>
    </div>

    <!-- Logo of the school -->
    <div class="logo">
        <img src="download.jpeg" alt="St Alphonsus R.C. Primary School">
    </div>

    <!-- Heading for the administrator access -->
    <h1>St Alphonsus R.C. Primary School - ADMINISTRATOR ACCESS</h1>
</div>

<!-- Main content of the web page -->
<div class="content">
    <!-- Heading for the manage users section -->
    <h2>Manage Users</h2>

    <!-- Checking if there are users in the database -->
    <?php if (mysqli_num_rows($result) > 0): ?>
        <!-- Displaying a table for listing users -->
        <table id="userTable">
            <tr>
                <th>User ID</th>
                <th>Username</th>
                <th>Email</th>
                <th>Password</th>
                <th>Action</th>
            </tr>

            <!-- Looping through each user record and displaying in a table row -->
            <?php while ($row = mysqli_fetch_assoc($result)) : ?>
                <tr>
                    <td><?php echo $row['user_id']; ?></td>
                    <!-- Enabling editing of user details -->
                    <td contenteditable="true" class="editable" id="username_<?php echo $row['user_id']; ?>"><?php echo $row['username']; ?></td>
                    <td contenteditable="true" class="editable" id="email_<?php echo $row['user_id']; ?>"><?php echo $row['email']; ?></td>
                    <td contenteditable="true" class="editable" id="password_<?php echo $row['user_id']; ?>" onclick="updatePassword(<?php echo $row['user_id']; ?>)" data-value="<?php echo htmlspecialchars($row['password']); ?>"><?php echo htmlspecialchars($row['password']); ?></td>
                    <!-- Form for submitting the updated user information -->
                    <td>
                        <form id="edit-form" class="edit-form" method="post" action="">
                            <input type="hidden" name="update_user_id" value="<?php echo $row['user_id']; ?>">
                            <input type="hidden" name="update_username" value="">
                            <input type="hidden" name="update_email" value="">
                            <input type="hidden" name="update_password" value="">
                            <!-- Button for triggering the update of user information -->
                            <button class="update-btn" type="button" onclick="updateUser(<?php echo $row['user_id']; ?>)">Update</button>
                        </form>
                    </td>
                </tr>
            <?php endwhile; ?>

        </table>
    <?php else: ?>
        <!-- Display a message if no users are found -->
        <p>No users found.</p>
    <?php endif; ?>

    <?php
    // Free the result set and close the database connection
    mysqli_free_result($result);
    mysqli_close($link);
    ?>

</div>

<!-- Footer section of the web page -->
<div class="footer">
    <!-- Display the copyright information -->
    <p>&copy; 2023 St Alphonsus R.C. Primary School</p>
</div>

<!-- JavaScript script for updating user information -->
<script>
    // Function to update user information via AJAX
    function updateUser(userId) {
        // Get references to HTML elements containing user information
        var usernameElement = document.getElementById('username_' + userId);
        var emailElement = document.getElementById('email_' + userId);
        var passwordElement = document.getElementById('password_' + userId);

        // Get the trimmed text content of the elements
        var username = usernameElement.innerText.trim();
        var email = emailElement.innerText.trim();
        var password = passwordElement.innerText.trim();

        // Submit the form dynamically using Fetch API
        fetch(window.location.href, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: 'update_user_id=' + userId +
                  '&update_username=' + encodeURIComponent(username) +
                  '&update_email=' + encodeURIComponent(email) +
                  '&update_password=' + encodeURIComponent(password),
        })
    }

    // Function to update password interactively
    function updatePassword(userId) {
        // Prompt the user for a new password
        var newPassword = prompt("Enter the new password:", document.getElementById('password_' + userId).textContent);
        if (newPassword !== null) {
            // Set the new password in the table cell
            document.getElementById('password_' + userId).textContent = newPassword;
        }
    }

    // Ensure contenteditable fields are updated before submitting the form
    document.addEventListener('click', function (event) {
        var target = event.target;

        if (target.classList.contains('editable')) {
            target.addEventListener('blur', function () {
                updateUser(target.dataset.userId);
            });
        }
    });
</script>

</body>
</html>
