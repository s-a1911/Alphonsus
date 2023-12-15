<?php
// Establishing a connection to the MySQL database
$link = mysqli_connect("localhost", "root", "", "leassessment");

// Checking if the connection was successful
if (!$link) {
    die("Connection failed: " . mysqli_connect_error());
}

// Fetch pupil data from the database
$query = "SELECT * FROM pupil";
$result = mysqli_query($link, $query);

// Checking if the query was successful
if (!$result) {
    die("Query failed: " . mysqli_error($link));
}

// Fetching all pupil data into an associative array
$pupils = mysqli_fetch_all($result, MYSQLI_ASSOC);

// Closing the database connection
mysqli_close($link);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Setting the viewport for the HTML document -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Linking to the external stylesheet -->
    <link rel="stylesheet" type="text/css" href="styles.css">
    <!-- Setting the title of the HTML document -->
    <title>View Students - St Alphonsus R.C. Primary School</title>
</head>

<body>

    <!-- Navigation bar for the web application -->
    <div class="navbar">
        <!-- Dropdown menu for various actions -->
        <div class="dropdown"></div>
        <!-- Dropdown menu for navigating to homepage -->
        <div class="dropdown">
            <a href="teacherindex.html" class="dropbtn" id="home-btn">Go to Homepage</a>
        </div>
        <!-- Dropdown menu for viewing parents -->
        <div class="dropdown">
            <a href="viewparent.php" class="dropbtn">View Parent</a>
        </div>
        <!-- Dropdown menu for viewing classes -->
        <div class="dropdown">
            <a href="viewclass.php" class="dropbtn">View Classes</a>
        </div>
        <!-- Logo of the school -->
        <div class="logo">
            <img src="download.jpeg" alt="St Alphonsus R.C. Primary School">
        </div>
        <!-- Heading for the web application -->
        <h1>St Alphonsus R.C. Primary School - TEACHER ACCESS</h1>
    </div>

    <!-- Main content of the web page -->
    <div class="content">
        <!-- Heading for viewing students -->
        <h1>View Students</h1>

        <!-- Displaying pupil data in a table -->
        <table border="1">
            <tr>
                <th>Pupil ID</th>
                <th>Name</th>
                <th>Address</th>
                <th>Medical Info</th>
                <th>Class ID</th>
                <th>Guardian 1 ID</th>
                <th>Guardian 2 ID</th>
            </tr>
            <!-- Looping through each pupil and displaying in a table row -->
            <?php foreach ($pupils as $pupil) : ?>
                <tr>
                    <td><?php echo $pupil['pupil_id']; ?></td>
                    <td><?php echo $pupil['name']; ?></td>
                    <td><?php echo $pupil['address']; ?></td>
                    <td><?php echo $pupil['medical_info']; ?></td>
                    <td><?php echo $pupil['class_id']; ?></td>
                    <td><?php echo $pupil['guardian1_id']; ?></td>
                    <td><?php echo $pupil['guardian2_id']; ?></td>
                </tr>
            <?php endforeach; ?>
        </table>

    </div>

    <!-- Footer section of the web page -->
    <div class="footer">
        <!-- Display the copyright information -->
        <p>&copy; 2023 St Alphonsus R.C. Primary School</p>
    </div>

</body>

</html>
