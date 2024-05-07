<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Student Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous"></script>

    <style>
        .gradient-background {
            background: linear-gradient(300deg, #00bfff, #ff4c68, #ef8172);
            background-size: 180% 180%;
            animation: gradient-animation 18s ease infinite;
        }

        @keyframes gradient-animation {
            0% {
                background-position: 0% 50%;
            }

            50% {
                background-position: 100% 50%;
            }

            100% {
                background-position: 0% 50%;
            }
        }

        .box {
            width: 100%;
            height: 80px;
            display: flex;
            color: white;
            align-items: center;
        }

        .item {
            margin-left: 2%;
        }

        .item-logout {
            margin-left: auto;
            margin-right: 20px;
        }
    </style>
</head>
<body>
    <div class="box gradient-background" style="position: sticky; top: 0; z-index: 2;">
        <!-- Navigation buttons -->
        <div class="item">
            <a href="http://localhost/phptutorial/admin/admin_dash.php">
                <button type="button" class="btn btn-primary">Admin dashboard</button>
            </a>
        </div>
    </div>
    <div class="container mt-4">
        <h1>View Student Details</h1>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <label for="sid">Enter Student ID:</label><br>
            <input type="text" id="sid" name="sid" required><br>
            <input type="submit" value="View Details" class="btn btn-primary mt-2">
        </form>

        <?php
        session_start(); // Start the session

        // Include database connection
        include("../connection.php");

        // Function to fetch and display data in tabular form
        function displayDataInTable($conn, $query, $tableName) {
            $result = mysqli_query($conn, $query);
            if (mysqli_num_rows($result) > 0) {
                echo "<h3>$tableName</h3>";
                echo "<table class='table'>";
                // Fetch column names
                echo "<tr>";
                while ($fieldinfo = mysqli_fetch_field($result)) {
                    echo "<th>" . $fieldinfo->name . "</th>";
                }
                echo "</tr>";
                // Fetch data rows
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    foreach ($row as $value) {
                        echo "<td>$value</td>";
                    }
                    echo "</tr>";
                }
                echo "</table>";
            } else {
                echo "<p>No data found for $tableName.</p>";
            }
        }

        // Function to get corresponding grade based on the result
        function getGrade($result) {
            if ($result >= 9.51) return 'AA';
            elseif ($result >= 9) return 'AB';
            elseif ($result >= 8) return 'BB';
            elseif ($result >= 7) return 'BC';
            elseif ($result >= 6) return 'CC';
            elseif ($result >= 5) return 'CD';
            elseif ($result >= 4) return 'DD';
            else return 'F';
        }

        // Check if the form is submitted
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Retrieve student ID from the form
            $sid = $_POST['sid'];

            // Query to fetch student details
            $query = "SELECT * FROM students WHERE sid = '$sid'";
            $result = mysqli_query($conn, $query);

            // Check if student exists
            if (mysqli_num_rows($result) > 0) {
                // Fetch student details and display
                echo "<h2>Student Details</h2>";
                displayDataInTable($conn, $query, "Student");

                // Query to fetch attendance records
                $query = "SELECT * FROM attendance WHERE sid = '$sid'";
                displayDataInTable($conn, $query, "Attendance Records");

                // Query to fetch marks and calculate grade
                $query = "SELECT m.cid, m.marks, c.cname FROM marks m JOIN courses c ON m.cid = c.cid WHERE m.sid = '$sid'";
                displayDataInTable($conn, $query, "Marks");

                // Fetch marks to calculate grade
                $marks_query = "SELECT m.cid, m.marks, m.grade, c.credit FROM marks m JOIN courses c ON m.cid = c.cid WHERE m.sid = '$sid'";
                $marks_result = mysqli_query($conn, $marks_query);

                // Initialize variables for grade calculation
                $total_grade_points = 0;
                $total_credits = 0;

                // Calculate grade points for each course
                while ($row = mysqli_fetch_assoc($marks_result)) {
                    $credit = $row['credit'];
                    $grade = $row['grade'];

                    // Calculate grade points for the grade obtained
                    switch ($grade) {
                        case 'AA':
                            $grade_points = 10;
                            break;
                        case 'AB':
                            $grade_points = 9;
                            break;
                        case 'BB':
                            $grade_points = 8;
                            break;
                        case 'BC':
                            $grade_points = 7;
                            break;
                        case 'CC':
                            $grade_points = 6;
                            break;
                        case 'CD':
                            $grade_points = 5;
                            break;
                        case 'DD':
                            $grade_points = 4;
                            break;
                        case 'F':
                            $grade_points = 0;
                            break;
                        default:
                            $grade_points = 0;
                            break;
                    }

                    // Calculate total grade points and total credits
                    $total_grade_points += ($grade_points * $credit);
                    $total_credits += $credit;
                }

                // Calculate result only if total credits is not zero
                if ($total_credits != 0) {
                    $result = $total_grade_points / $total_credits;
                    $grade = getGrade($result);

                    // Display result and grade
                    echo "<h2>Result and Grade</h2>";
                    echo "<p>Result: " . number_format($result, 2) . "</p>";
                    echo "<p>Grade: $grade</p>";
                } else {
                    $message = "Marks have not been assigned yet.";
                }
            } else {
                echo "<p>No student found with ID: $sid</p>";
            }
        }
        ?>

    </div>
</body>
</html>