<?php
// Connecting to the database
$link = mysqli_connect("localhost", "root", "", "leassessment");

// Check if the connection was successful
if (!$link) {
    // Display an error message and terminate the script
    die("Connection failed: " . mysqli_connect_error());
}

// Fetch parent data from the database
$query = "SELECT * FROM parent_guardian";
$result = mysqli_query($link, $query);

// Check if the query was successful
if (!$result) {
    // Display an error message and terminate the script
    die("Query failed: " . mysqli_error($link));
}

// Fetch all parent data and store it in an associative array
$parents = mysqli_fetch_all($result, MYSQLI_ASSOC);

// Close the database connection
mysqli_close($link);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Set the viewport for responsive design -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Link to the external stylesheet -->
    <link rel="stylesheet" type="text/css" href="styles.css">
    <!-- Set the title of the HTML document -->
    <title>View Parents - St Alphonsus R.C. Primary School</title>
</head>

<body>

    <div class="navbar">
        <!-- Navigation buttons for various actions -->
        <div class="button">
            <a href="viewstudent.php" class="btn">View Students</a>
        </div>

        <div class="button">
            <a href="viewclass.php" class="btn">View Classes</a>
        </div>

        <div class="button">
            <a href="teacherindex.html" class="btn">Go to Homepage</a>
        </div>

        <!-- School logo and title -->
        <div class="logo">
            <img src="download.jpeg" alt="St Alphonsus R.C. Primary School">
        </div>

        <h1>St Alphonsus R.C. Primary School - TEACHER ACCESS</h1>
    </div>

    <div class="content">
        <!-- Page heading -->
        <h1>View Parents</h1>

        <!-- Display parent data in a table -->
        <table border="1">
            <tr>
                <th>Guardian ID</th>
                <th>Name</th>
                <th>Address</th>
                <th>Email</th>
                <th>Telephone Number</th>
            </tr>
            <!-- Loop through each parent and display their information -->
            <?php foreach ($parents as $parent) : ?>
                <tr>
                    <td><?php echo $parent['guardian_id']; ?></td>
                    <td><?php echo $parent['name']; ?></td>
                    <td><?php echo $parent['address']; ?></td>
                    <td><?php echo $parent['email']; ?></td>
                    <td><?php echo $parent['tel_number']; ?></td>
                </tr>
            <?php endforeach; ?>
        </table>

    </div>

    <div class="footer">
        <!-- Display the copyright information -->
        <p>&copy; 2023 St Alphonsus R.C. Primary School</p>
    </div>

</body>

</html>
