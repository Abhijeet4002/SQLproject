<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Courses</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        .table-container {
            max-width: 800px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <div class="container mt-4">
        <h1>View Courses</h1>
        <div class="table-container">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Course ID</th>
                        <th>Course Name</th>
                        <th>Credit</th>
                        <th>Department ID</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    session_start(); // Start the session

                    // Include database connection
                    include("../connection.php");

                    // Query to fetch courses
                    $query = "SELECT * FROM courses";
                    $result = mysqli_query($conn, $query);

                    // Check if there are any courses
                    if (mysqli_num_rows($result) > 0) {
                        // Output data of each row
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<tr>";
                            echo "<td>" . $row['cid'] . "</td>";
                            echo "<td>" . $row['cname'] . "</td>";
                            echo "<td>" . $row['credit'] . "</td>";
                            echo "<td>" . $row['did'] . "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='4'>No courses found.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>