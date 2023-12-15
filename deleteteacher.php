<?php
// Establishing a connection to the database
$link = mysqli_connect("localhost", "root", "", "leassessment");

// Checking the connection status
if (!$link) {
    die("Connection failed: " . mysqli_connect_error());
}

// Handling form submission for teacher deletion
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["delete_teacher_id"])) {
    $deleteTeacherId = mysqli_real_escape_string($link, $_POST["delete_teacher_id"]);

    // Constructing the query to delete the teacher from the database
    $deleteQuery = "DELETE FROM teacher WHERE teacher_id = '$deleteTeacherId'";

    // Executing the query
    if (mysqli_query($link, $deleteQuery)) {
        echo "<p>Teacher deleted successfully.</p>";
    } else {
        echo "<p>Error deleting teacher: " . mysqli_error($link) . "</p>";
    }
}

// Fetching teacher data from the database
$query = "SELECT * FROM teacher";
$result = mysqli_query($link, $query);

// Checking if the query execution was successful
if (!$result) {
    die("Query failed: " . mysqli_error($link));
}

// Closing the database connection
mysqli_close($link);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Delete Teacher - St Alphonsus R.C. Primary School</title>
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
</div>

<div class="content">
    <h2>Delete Teacher</h2>

    <?php if (mysqli_num_rows($result) > 0): ?>
        <table id="teacherTable">
            <tr>
                <th>Teacher ID</th>
                <th>Name</th>
                <th>Address</th>
                <th>Phone Number</th>
                <th>Salary</th>
                <th>Background Check Status</th>
                <th>Username</th>
                <th>Password</th>
                <th>Action</th>
            </tr>

            <?php while ($row = mysqli_fetch_assoc($result)) : ?>
                <tr>
                    <td><?php echo $row['teacher_id']; ?></td>
                    <td><?php echo $row['name']; ?></td>
                    <td><?php echo $row['address']; ?></td>
                    <td><?php echo $row['phone_number']; ?></td>
                    <td><?php echo $row['salary']; ?></td>
                    <td><?php echo $row['bg_check_status']; ?></td>
                    <td><?php echo $row['teacher_username']; ?></td>
                    <td><?php echo $row['teacher_password']; ?></td>
                    <td>
                        <form id="delete-form-<?php echo $row['teacher_id']; ?>" class="delete-form" method="post" action="">
                            <input type="hidden" name="delete_teacher_id" value="<?php echo $row['teacher_id']; ?>">
                            <button class="delete-btn" type="button" onclick="deleteTeacher(<?php echo $row['teacher_id']; ?>)">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php endwhile; ?>

        </table>
    <?php else: ?>
        <p>No teachers found.</p>
    <?php endif; ?>

    <?php
    // Freeing up the result set
    mysqli_free_result($result);
    ?>

</div>

<div class="footer">
    <p>&copy; 2023 St Alphonsus R.C. Primary School</p>
</div>

<script>
// JavaScript function to confirm and submit the delete form
function deleteTeacher(teacherId) {
    var confirmDelete = confirm("Are you sure you want to delete this teacher?");
    if (confirmDelete) {
        var form = document.getElementById('delete-form-' + teacherId);
        form.submit();
    }
}
</script>

</body>
</html>