<?php
// Establish a connection to the MySQL database
$link = mysqli_connect("localhost", "root", "", "leassessment");

// Check if the connection is successful
if (!$link) {
    die("Connection failed: " . mysqli_connect_error());
}

// Check if the form is submitted using the POST method and if the update_guardian_id is set
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["update_guardian_id"])) {
    // Retrieve and sanitize the values from the form
    $updateGuardianId = mysqli_real_escape_string($link, $_POST["update_guardian_id"]);
    $updateName = mysqli_real_escape_string($link, $_POST["update_name"]);
    $updateAddress = mysqli_real_escape_string($link, $_POST["update_address"]);
    $updateEmail = mysqli_real_escape_string($link, $_POST["update_email"]);
    $updateTelNumber = mysqli_real_escape_string($link, $_POST["update_tel_number"]);

    // Query to update the parent/guardian information in the database
    $updateQuery = "UPDATE parent_guardian SET name = '$updateName', address = '$updateAddress', email = '$updateEmail', tel_number = '$updateTelNumber' WHERE guardian_id = '$updateGuardianId'";

    // Execute the update query
    if (mysqli_query($link, $updateQuery)) {
        echo "<p>Parent/Guardian updated successfully.</p>";
    } else {
        echo "<p>Error updating Parent/Guardian: " . mysqli_error($link) . "</p>";
    }
}

// Query to fetch all parent/guardian records from the database
$query = "SELECT * FROM parent_guardian";
$result = mysqli_query($link, $query);

// Check if the query was successful
if (!$result) {
    die("Query failed: " . mysqli_error($link));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Manage Parents/Guardians</title>
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
    <h2>Manage Parents/Guardians</h2>

    <?php if (mysqli_num_rows($result) > 0): ?>
        <!-- Display a table of parent/guardian records if there are any -->
        <table id="parentTable">
            <tr>
                <th>Guardian ID</th>
                <th>Name</th>
                <th>Address</th>
                <th>Email</th>
                <th>Telephone Number</th>
                <th>Action</th>
            </tr>

            <?php while ($row = mysqli_fetch_assoc($result)) : ?>
                <tr>
                    <!-- Display individual fields for each parent/guardian -->
                    <td><?php echo $row['guardian_id']; ?></td>
                    <td contenteditable="true" class="editable" id="name_<?php echo $row['guardian_id']; ?>"><?php echo $row['name']; ?></td>
                    <td contenteditable="true" class="editable" id="address_<?php echo $row['guardian_id']; ?>"><?php echo $row['address']; ?></td>
                    <td contenteditable="true" class="editable" id="email_<?php echo $row['guardian_id']; ?>"><?php echo $row['email']; ?></td>
                    <td contenteditable="true" class="editable" id="tel_number_<?php echo $row['guardian_id']; ?>"><?php echo $row['tel_number']; ?></td>
                    <td>
                        <!-- Form to submit the update for a specific parent/guardian -->
                        <form id="edit-form-<?php echo $row['guardian_id']; ?>" class="edit-form" method="post" action="">
                            <input type="hidden" name="update_guardian_id" value="<?php echo $row['guardian_id']; ?>">
                            <input type="hidden" name="update_name" value="">
                            <input type="hidden" name="update_address" value="">
                            <input type="hidden" name="update_email" value="">
                            <input type="hidden" name="update_tel_number" value="">
                            <!-- Button to trigger the parent/guardian update -->
                            <button class="update-btn" type="button" onclick="updateParent(<?php echo $row['guardian_id']; ?>)">Update</button>
                        </form>
                    </td>
                </tr>
            <?php endwhile; ?>

        </table>
    <?php else: ?>
        <!-- Display a message if no parents/guardians are found -->
        <p>No parents/guardians found.</p>
    <?php endif; ?>

    <?php
    // Free the result set
    mysqli_free_result($result);
    // Close the MySQL connection
    mysqli_close($link);
    ?>

</div>

<!-- Footer section -->
<div class="footer">
    <p>&copy; 2023 St Alphonsus R.C. Primary School</p>
</div>

<!-- JavaScript for updating parent/guardian information -->
<script>
    // Function to update parent/guardian information using fetch API
    function updateParent(guardianId) {
        // Get elements by ID for parent/guardian information
        var nameElement = document.getElementById('name_' + guardianId);
        var addressElement = document.getElementById('address_' + guardianId);
        var emailElement = document.getElementById('email_' + guardianId);
        var telNumberElement = document.getElementById('tel_number_' + guardianId);

        // Get trimmed values for parent/guardian information
        var name = nameElement.innerText.trim();
        var address = addressElement.innerText.trim();
        var email = emailElement.innerText.trim();
        var telNumber = telNumberElement.innerText.trim();

        // Submit the form dynamically using fetch API
        fetch(window.location.href, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: 'update_guardian_id=' + guardianId +
                  '&update_name=' + encodeURIComponent(name) +
                  '&update_address=' + encodeURIComponent(address) +
                  '&update_email=' + encodeURIComponent(email) +
                  '&update_tel_number=' + encodeURIComponent(telNumber),
        })
        .then(response => response.text())
        .then(result => {
            console.log(result); 
        })
        .catch(error => {
            console.error('Error:', error);
        });
    }
</script>

</body>
</html>
