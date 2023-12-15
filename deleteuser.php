<?php
$link = mysqli_connect("localhost", "root", "", "leassessment");

if (!$link) {
    die("Connection failed: " . mysqli_connect_error());
}

// Check if the form is submitted for row deletion
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["delete_user_id"])) {
    $deleteUserId = mysqli_real_escape_string($link, $_POST["delete_user_id"]);

    // Delete the user from the database
    $deleteQuery = "DELETE FROM user WHERE user_id = '$deleteUserId'";
    if (mysqli_query($link, $deleteQuery)) {
        echo "<p>User deleted successfully.</p>";
    } else {
        echo "<p>Error deleting user: " . mysqli_error($link) . "</p>";
    }
}

// Fetch user data from the database
$query = "SELECT * FROM user";
$result = mysqli_query($link, $query);

if (!$result) {
    die("Query failed: " . mysqli_error($link));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Delete Users</title>
    <link rel="stylesheet" href="styles.css">
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

    <div class="dropdown">
        <a href="index.html" class="dropbtn" id="home-btn">Homepage</a>
    </div>

    <div class="logo">
        <img src="download.jpeg" alt="St Alphonsus R.C. Primary School">
    </div>

    <h1>St Alphonsus R.C. Primary School - ADMINISTRATOR ACCESS</h1>
</div>

<div class="content">
    <h2>Delete Users</h2>

    <!-- Display user data in an HTML table with delete buttons -->
    <?php if (mysqli_num_rows($result) > 0): ?>
        <table id="userTable">
            <tr>
                <th>User ID</th>
                <th>Username</th>
                <th>Email</th>
                <th>Password</th>
                <th>Action</th>
            </tr>

            <?php while ($row = mysqli_fetch_assoc($result)) : ?>
                <tr>
                    <td><?php echo $row['user_id']; ?></td>
                    <td><?php echo $row['username']; ?></td>
                    <td><?php echo $row['email']; ?></td>
                    <td><?php echo $row['password']; ?></td>
                    <td>
                        <!-- Add a unique ID to each form and hidden field dynamically -->
                        <form class="delete-form" method="post" action="">
                            <input type="hidden" name="delete_user_id" value="<?php echo $row['user_id']; ?>">
                            <button class="delete-btn" type="submit">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php endwhile; ?>

        </table>
    <?php else: ?>
        <p>No users found.</p>
    <?php endif; ?>

    <?php
    mysqli_free_result($result); // Free up the result set
    mysqli_close($link);
    ?>

</div>

<div class="footer">
    <p>&copy; 2023 St Alphonsus R.C. Primary School</p>
</div>

</body>
</html>