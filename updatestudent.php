<?php
// Establish a connection to the MySQL database
$link = mysqli_connect("localhost", "root", "", "leassessment");

// Check if the connection is successful
if (!$link) {
    die("Connection failed: " . mysqli_connect_error());
}

// Check if the form is submitted and the student ID is set for updating
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["update_student_id"])) {
    // Get and sanitize the data from the form
    $updateStudentId = mysqli_real_escape_string($link, $_POST["update_student_id"]);
    $updateName = mysqli_real_escape_string($link, $_POST["update_name"]);
    $updateAddress = mysqli_real_escape_string($link, $_POST["update_address"]);
    $updateParentId = mysqli_real_escape_string($link, $_POST["update_parent_id"]);
    $updateClassId = mysqli_real_escape_string($link, $_POST["update_class_id"]);

    // Construct the SQL query to update the student record
    $updateQuery = "UPDATE pupil SET 
                    name = '$updateName', 
                    address = '$updateAddress', 
                    guardian1_id = '$updateParentId', 
                    class_id = '$updateClassId' 
                    WHERE pupil_id = '$updateStudentId'";

    // Execute the update query and display a success or error message
    if (mysqli_query($link, $updateQuery)) {
        echo "<p>Student updated successfully.</p>";
    } else {
        echo "<p>Error updating Student: " . mysqli_error($link) . "</p>";
    }
}

// Fetch all student data from the database
$query = "SELECT * FROM pupil";
$result = mysqli_query($link, $query);

// Check if the query was successful
if (!$result) {
    die("Query failed: " . mysqli_error($link));
}

// Fetch parent data from the database
$parentQuery = "SELECT guardian_id, name FROM parent_guardian";
$parentResult = mysqli_query($link, $parentQuery);
$parents = mysqli_fetch_all($parentResult, MYSQLI_ASSOC);

// Fetch class data from the database
$classQuery = "SELECT class_id, name FROM class";
$classResult = mysqli_query($link, $classQuery);
$classes = mysqli_fetch_all($classResult, MYSQLI_ASSOC);

// Close the database connection
mysqli_close($link);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Set the character set and viewport for the HTML document -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Update Student - St Alphonsus R.C. Primary School</title>
    <!-- Link to the external stylesheet -->
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
    <!-- Heading for the update student section -->
    <h2>Update Student</h2>

    <!-- Check if there are students in the database -->
    <?php if (mysqli_num_rows($result) > 0): ?>
        <!-- Display a table for listing students -->
        <table id="studentTable">
            <tr>
                <th>Student ID</th>
                <th>Name</th>
                <th>Address</th>
                <th>Parent</th>
                <th>Class</th>
                <th>Action</th>
            </tr>

            <!-- Loop through each student record and display in a table row -->
            <?php while ($row = mysqli_fetch_assoc($result)) : ?>
                <tr>
                    <td><?php echo $row['pupil_id']; ?></td>
                    <!-- Enable editing of student name and address -->
                    <td contenteditable="true" class="editable" id="name_<?php echo $row['pupil_id']; ?>"><?php echo $row['name']; ?></td>
                    <td contenteditable="true" class="editable" id="address_<?php echo $row['pupil_id']; ?>"><?php echo $row['address']; ?></td>
                    <!-- Dropdown for selecting the parent of the student -->
                    <td>
                        <select class="editable" id="parent_id_<?php echo $row['pupil_id']; ?>">
                            <!-- Loop through each parent and display in the dropdown -->
                            <?php foreach ($parents as $parent) : ?>
                                <option value="<?php echo $parent['guardian_id']; ?>" <?php echo ($parent['guardian_id'] == $row['guardian1_id']) ? 'selected' : ''; ?>>
                                    <?php echo $parent['name']; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </td>
                    <!-- Dropdown for selecting the class of the student -->
                    <td>
                        <select class="editable" id="class_id_<?php echo $row['pupil_id']; ?>">
                            <!-- Loop through each class and display in the dropdown -->
                            <?php foreach ($classes as $class) : ?>
                                <option value="<?php echo $class['class_id']; ?>" <?php echo ($class['class_id'] == $row['class_id']) ? 'selected' : ''; ?>>
                                    <?php echo $class['name']; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </td>
                    <!-- Form for submitting the updated student information -->
                    <td>
                        <form id="edit-form-<?php echo $row['pupil_id']; ?>" class="edit-form" method="post" action="">
                            <input type="hidden" name="update_student_id" value="<?php echo $row['pupil_id']; ?>">
                            <input type="hidden" name="update_name" value="">
                            <input type="hidden" name="update_address" value="">
                            <input type="hidden" name="update_parent_id" value="">
                            <input type="hidden" name="update_class_id" value="">
                            <!-- Button for triggering the update of student information -->
                            <button class="update-btn" type="button" onclick="updateStudent(<?php echo $row['pupil_id']; ?>)">Update</button>
                        </form>
                    </td>
                </tr>
            <?php endwhile; ?>

        </table>
    <?php else: ?>
        <!-- Display a message if no students are found -->
        <p>No students found.</p>
    <?php endif; ?>

    <?php
    // Free the result set and close the database connection
    mysqli_free_result($result);
    ?>

</div>

<!-- Footer section of the web page -->
<div class="footer">
    <!-- Display the copyright information -->
    <p>&copy; 2023 St Alphonsus R.C. Primary School</p>
</div>

<!-- JavaScript script for updating student information -->
<script>
function updateStudent(studentId) {
    // Get references to HTML elements containing student information
    var nameElement = document.getElementById('name_' + studentId);
    var addressElement = document.getElementById('address_' + studentId);
    var parentIdElement = document.getElementById('parent_id_' + studentId);
    var classIdElement = document.getElementById('class_id_' + studentId);

    // Get the trimmed text content of the elements
    var name = nameElement.innerText.trim();
    var address = addressElement.innerText.trim();
    var parentId = parentIdElement.value.trim();
    var classId = classIdElement.value.trim();

    // Set the values of hidden input fields in the form
    var form = document.getElementById('edit-form-' + studentId);
    form.querySelector('[name="update_name"]').value = name;
    form.querySelector('[name="update_address"]').value = address;
    form.querySelector('[name="update_parent_id"]').value = parentId;
    form.querySelector('[name="update_class_id"]').value = classId;

    // Submit the form dynamically
    form.submit();
}
</script>

</body>
</html>
