<?php
// Establishing a connection to the MySQL database
$link = mysqli_connect("localhost", "root", "", "leassessment");

// Checking if the connection was successful
if (!$link) {
    die("Connection failed: " . mysqli_connect_error());
}

// Handling the form submission and updating a teacher's information
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["update_teacher_id"])) {
    // Retrieving and sanitizing data from the form
    $updateTeacherId = mysqli_real_escape_string($link, $_POST["update_teacher_id"]);
    $updateName = mysqli_real_escape_string($link, $_POST["update_name"]);
    $updateAddress = mysqli_real_escape_string($link, $_POST["update_address"]);
    $updatePhoneNumber = mysqli_real_escape_string($link, $_POST["update_phone_number"]);
    $updateSalary = mysqli_real_escape_string($link, $_POST["update_salary"]);
    $updateBgCheckStatus = mysqli_real_escape_string($link, $_POST["update_bg_check_status"]);
    $updateUsername = mysqli_real_escape_string($link, $_POST["update_username"]);
    $updatePassword = mysqli_real_escape_string($link, $_POST["update_password"]);

    // Constructing the SQL query to update the teacher's record
    $updateQuery = "UPDATE teacher SET
                    name = '$updateName',
                    address = '$updateAddress',
                    phone_number = '$updatePhoneNumber',
                    salary = '$updateSalary',
                    bg_check_status = '$updateBgCheckStatus',
                    teacher_username = '$updateUsername',
                    teacher_password = '$updatePassword'
                    WHERE teacher_id = '$updateTeacherId'";

    // Executing the update query and displaying a success or error message
    if (mysqli_query($link, $updateQuery)) {
        echo "<p>Teacher updated successfully.</p>";
    } else {
        echo "<p>Error updating teacher: " . mysqli_error($link) . "</p>";
    }
}

// Fetching all teacher data from the database
$query = "SELECT * FROM teacher";
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
    <title>Manage Teachers</title>
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
</div>

<!-- Main content of the web page -->
<div class="content">
    <!-- Heading for the manage teachers section -->
    <h2>Manage Teachers</h2>

    <!-- Checking if there are teachers in the database -->
    <?php if (mysqli_num_rows($result) > 0): ?>
        <!-- Displaying a table for listing teachers -->
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

            <!-- Looping through each teacher record and displaying in a table row -->
            <?php while ($row = mysqli_fetch_assoc($result)) : ?>
                <tr>
                    <td><?php echo $row['teacher_id']; ?></td>
                    <!-- Enabling editing of teacher details -->
                    <td contenteditable="true" class="editable" id="name_<?php echo $row['teacher_id']; ?>"><?php echo $row['name']; ?></td>
                    <td contenteditable="true" class="editable" id="address_<?php echo $row['teacher_id']; ?>"><?php echo $row['address']; ?></td>
                    <td contenteditable="true" class="editable" id="phone_number_<?php echo $row['teacher_id']; ?>"><?php echo $row['phone_number']; ?></td>
                    <td contenteditable="true" class="editable" id="salary_<?php echo $row['teacher_id']; ?>"><?php echo $row['salary']; ?></td>
                    <td contenteditable="true" class="editable" id="bg_check_status_<?php echo $row['teacher_id']; ?>"><?php echo $row['bg_check_status']; ?></td>
                    <td contenteditable="true" class="editable" id="username_<?php echo $row['teacher_id']; ?>"><?php echo $row['teacher_username']; ?></td>
                    <td contenteditable="true" class="editable" id="password_<?php echo $row['teacher_id']; ?>"><?php echo $row['teacher_password']; ?></td>
                    <!-- Form for submitting the updated teacher information -->
                    <td>
                        <form id="edit-form-<?php echo $row['teacher_id']; ?>" class="edit-form" method="post" action="">
                            <input type="hidden" name="update_teacher_id" value="<?php echo $row['teacher_id']; ?>">
                            <input type="hidden" name="update_name" value="">
                            <input type="hidden" name="update_address" value="">
                            <input type="hidden" name="update_phone_number" value="">
                            <input type="hidden" name="update_salary" value="">
                            <input type="hidden" name="update_bg_check_status" value="">
                            <input type="hidden" name="update_username" value="">
                            <input type="hidden" name="update_password" value="">
                            <!-- Button for triggering the update of teacher information -->
                            <button class="update-btn" type="button" onclick="updateTeacher(<?php echo $row['teacher_id']; ?>)">Update</button>
                        </form>
                    </td>
                </tr>
            <?php endwhile; ?>

        </table>
    <?php else: ?>
        <!-- Display a message if no teachers are found -->
        <p>No teachers found.</p>
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

<!-- JavaScript script for updating teacher information -->
<script>
    // Function to update teacher information via AJAX
    function updateTeacher(teacherId) {
        // Get references to HTML elements containing teacher information
        var nameElement = document.getElementById('name_' + teacherId);
        var addressElement = document.getElementById('address_' + teacherId);
        var phoneNumberElement = document.getElementById('phone_number_' + teacherId);
        var salaryElement = document.getElementById('salary_' + teacherId);
        var bgCheckStatusElement = document.getElementById('bg_check_status_' + teacherId);
        var usernameElement = document.getElementById('username_' + teacherId);
        var passwordElement = document.getElementById('password_' + teacherId);

        // Get the trimmed text content of the elements
        var name = nameElement.innerText.trim();
        var address = addressElement.innerText.trim();
        var phoneNumber = phoneNumberElement.innerText.trim();
        var salary = salaryElement.innerText.trim();
        var bgCheckStatus = bgCheckStatusElement.innerText.trim();
        var username = usernameElement.innerText.trim();
        var password = passwordElement.innerText.trim();

        // Submit the form dynamically using Fetch API
        fetch(window.location.href, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: 'update_teacher_id=' + teacherId +
                  '&update_name=' + encodeURIComponent(name) +
                  '&update_address=' + encodeURIComponent(address) +
                  '&update_phone_number=' + encodeURIComponent(phoneNumber) +
                  '&update_salary=' + encodeURIComponent(salary) +
                  '&update_bg_check_status=' + encodeURIComponent(bgCheckStatus) +
                  '&update_username=' + encodeURIComponent(username) +
                  '&update_password=' + encodeURIComponent(password),
        })
    }
</script>

</body>
</html>
