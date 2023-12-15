<?php
// Establish a connection to the MySQL database
$link = mysqli_connect("localhost", "root", "", "leassessment");

// Check if the connection is successful
if (!$link) {
    die("Connection failed: " . mysqli_connect_error());
}

// Check if the form is submitted using the POST method and if the update_class_id is set
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["update_class_id"])) {
    // Retrieve and sanitize the values from the form
    $updateClassId = mysqli_real_escape_string($link, $_POST["update_class_id"]);
    $updateClassName = mysqli_real_escape_string($link, $_POST["update_class_name"]);
    $updateCapacity = mysqli_real_escape_string($link, $_POST["update_capacity"]);
    $updateClassLimit = mysqli_real_escape_string($link, $_POST["update_class_limit"]);
    $updateTeacherName = mysqli_real_escape_string($link, $_POST["update_teacher_id"]);

    // Query to fetch the teacher_id based on the teacher's name
    $teacherQuery = "SELECT teacher_id FROM teacher WHERE name = '$updateTeacherName'";
    $teacherResult = mysqli_query($link, $teacherQuery);

    // Check if the teacher query was successful
    if ($teacherResult) {
        // Fetch the teacher data
        $teacherData = mysqli_fetch_assoc($teacherResult);
        $updateTeacherId = $teacherData['teacher_id'];

        // Query to update the class information in the database
        $updateQuery = "UPDATE class SET 
                        name = '$updateClassName', 
                        capacity = '$updateCapacity', 
                        class_limit = '$updateClassLimit', 
                        teacher_id = '$updateTeacherId' 
                        WHERE class_id = '$updateClassId'";

        // Execute the update query
        if (mysqli_query($link, $updateQuery)) {
            echo "<p>Class updated successfully.</p>";
        } else {
            echo "<p>Error updating class: " . mysqli_error($link) . "</p>";
        }
    } else {
        echo "<p>Error fetching teacher data: " . mysqli_error($link) . "</p>";
    }
}

// Query to fetch all classes from the database
$query = "SELECT * FROM class";
$result = mysqli_query($link, $query);

// Check if the query was successful
if (!$result) {
    die("Query failed: " . mysqli_error($link));
}

// Query to fetch all teacher names
$teacherQuery = "SELECT name FROM teacher";
$teacherResult = mysqli_query($link, $teacherQuery);
$teachers = mysqli_fetch_all($teacherResult, MYSQLI_ASSOC);

// Close the database connection
mysqli_close($link);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Update Class - St Alphonsus R.C. Primary School</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>

<!-- Navigation bar for different actions -->
<div class="navbar">
    <div class="dropdown">
        <a href="#" class="dropbtn">Add</a>
        <div class="dropdown-content">
            <!-- Links to add different entities -->
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
            <!-- Links to update different entities -->
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
            <!-- Links to delete different entities -->
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

    <!-- School logo -->
    <div class="logo">
        <img src="download.jpeg" alt="St Alphonsus R.C. Primary School">
    </div>
</div>

<!-- Main content area -->
<div class="content">
    <h2>Update Class</h2>

    <?php if (mysqli_num_rows($result) > 0): ?>
        <!-- Display a table of classes if there are any -->
        <table id="classTable">
            <tr>
                <th>Class ID</th>
                <th>Class Name</th>
                <th>Capacity</th>
                <th>Class Limit</th>
                <th>Teacher Name</th>
                <th>Action</th>
            </tr>

            <?php while ($row = mysqli_fetch_assoc($result)) : ?>
                <tr>
                    <!-- Display class information in editable fields -->
                    <td><?php echo $row['class_id']; ?></td>
                    <td contenteditable="true" class="editable" id="classname_<?php echo $row['class_id']; ?>"><?php echo $row['name']; ?></td>
                    <td contenteditable="true" class="editable" id="capacity_<?php echo $row['class_id']; ?>"><?php echo $row['capacity']; ?></td>
                    <td contenteditable="true" class="editable" id="classlimit_<?php echo $row['class_id']; ?>"><?php echo $row['class_limit']; ?></td>
                    <td>
                        <!-- Dropdown for selecting a teacher -->
                        <select class="editable" id="teacherid_<?php echo $row['class_id']; ?>">
                            <?php foreach ($teachers as $teacher) : ?>
                                <option value="<?php echo $teacher['name']; ?>" <?php echo ($teacher['name'] == $row['teacher_id']) ? 'selected' : ''; ?>>
                                    <?php echo $teacher['name']; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </td>
                    <td>
                        <!-- Form for updating class information -->
                        <form id="edit-form-<?php echo $row['class_id']; ?>" class="edit-form" method="post" action="">
                            <input type="hidden" name="update_class_id" value="<?php echo $row['class_id']; ?>">
                            <input type="hidden" name="update_class_name" value="">
                            <input type="hidden" name="update_capacity" value="">
                            <input type="hidden" name="update_class_limit" value="">
                            <input type="hidden" name="update_teacher_id" value="">
                            <!-- Button to trigger the class update -->
                            <button class="update-btn" type="button" onclick="updateClass(<?php echo $row['class_id']; ?>)">Update</button>
                        </form>
                    </td>
                </tr>
            <?php endwhile; ?>

        </table>
    <?php else: ?>
        <!-- Display a message if no classes are found -->
        <p>No classes found.</p>
    <?php endif; ?>

    <?php
    // Free the result set
    mysqli_free_result($result);
    ?>

</div>

<!-- Footer section -->
<div class="footer">
    <p>&copy; 2023 St Alphonsus R.C. Primary School</p>
</div>

<!-- JavaScript for updating class information -->
<script>
function updateClass(classId) {
    // Get elements by ID for class information
    var classNameElement = document.getElementById('classname_' + classId);
    var capacityElement = document.getElementById('capacity_' + classId);
    var classLimitElement = document.getElementById('classlimit_' + classId);
    var teacherNameElement = document.getElementById('teacherid_' + classId);

    // Get trimmed values for class information
    var className = classNameElement.innerText.trim();
    var capacity = capacityElement.innerText.trim();
    var classLimit = classLimitElement.innerText.trim();
    var teacherName = teacherNameElement.value.trim();

    // Set the values of hidden input fields in the update form
    var form = document.getElementById('edit-form-' + classId);
    form.querySelector('[name="update_class_name"]').value = className;
    form.querySelector('[name="update_capacity"]').value = capacity;
    form.querySelector('[name="update_class_limit"]').value = classLimit;
    form.querySelector('[name="update_teacher_id"]').value = teacherName;

    form.submit();  // Submit the form directly
}
</script>

</body>
</html>
