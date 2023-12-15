<?php
// Establishing a connection to the MySQL database
$link = mysqli_connect("localhost", "root", "", "leassessment");

// Checking if the connection was successful
if (!$link) {
    die("Connection failed: " . mysqli_connect_error());
}

// Fetch class data from the database
$query = "SELECT * FROM class";
$result = mysqli_query($link, $query);

// Checking if the query was successful
if (!$result) {
    die("Query failed: " . mysqli_error($link));
}

// Fetching all class data into an associative array
$classes = mysqli_fetch_all($result, MYSQLI_ASSOC);

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
    <title>View Classes - St Alphonsus R.C. Primary School</title>
</head>

<body>

    <!-- Navigation bar for the web application -->
    <div class="navbar">
        <!-- Button to view students -->
        <div class="button">
            <a href="viewstudent.php" class="btn">View Students</a>
        </div>
        <!-- Button to go to homepage -->
        <div class="button">
            <a href="teacherindex.html" class="btn">Go to Homepage</a>
        </div>
        <!-- Button to view parents -->
        <div class="button">
            <a href="viewparent.php" class="btn">View Parents</a>
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
        <!-- Heading for viewing classes -->
        <h1>View Classes</h1>

        <!-- Displaying class data in a table -->
        <table border="1">
            <tr>
                <th>Class ID</th>
                <th>Name</th>
                <th>Capacity</th>
                <th>Class Limit</th>
                <th>Teacher ID</th>
            </tr>
            <!-- Looping through each class and displaying in a table row -->
            <?php foreach ($classes as $class) : ?>
                <tr>
                    <td><?php echo $class['class_id']; ?></td>
                    <td><?php echo $class['name']; ?></td>
                    <td><?php echo $class['capacity']; ?></td>
                    <td><?php echo $class['class_limit']; ?></td>
                    <td><?php echo $class['teacher_id']; ?></td>
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
