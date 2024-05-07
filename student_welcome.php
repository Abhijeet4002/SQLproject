<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Welcome</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
    <style>
        body {
            background-color: white;
        }

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

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table,
        th,
        td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: lightyellow;
        }
    </style>
</head>

<body>
    <div class="box gradient-background" style="position: sticky; top: 0; z-index: 2;">
        <div class="item">
            <a href="home.php">
                <button type="button" class="btn btn-primary">Home</button>
            </a>
        </div>
        <div class="item">
            <a href="http://localhost/phptutorial/faculty_welcome.php">
                <button type="button" class="btn btn-success" style="color: black;"><strong>Faculty Login</strong>
                </button>
            </a>
        </div>
        <div class="item">
            <a href="http://localhost/phptutorial/stud_index.php">
                <button type="button" class="btn btn-success" style="color: black"><strong>Student Login</strong>
                </button>
            </a>
        </div>
        <div class="item-logout">
            <a href="http://localhost/phptutorial/logout.php">
                <button type="button" class="btn btn-primary" style="color: black"><strong>Logout</strong>
                </button>
            </a>
        </div>
    </div>

    <?php
    // Include connection.php and start session
    include("connection.php");
    session_start();

    // Redirect to login page if not logged in
    if (!isset($_SESSION['sid'])) {
        header("Location: stud_index.php");
        exit();
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

    $sid = $_SESSION['sid'];

    // Fetch student details
    $student_query = "SELECT * FROM students WHERE sid = $sid";
    $student_result = mysqli_query($conn, $student_query);

    // Fetch attendance records
    $attendance_query = "SELECT * FROM attendance WHERE sid = $sid";
    $attendance_result = mysqli_query($conn, $attendance_query);

    // Fetch marks
    $marks_query = "SELECT m.cid, m.marks, m.grade, c.cname FROM marks m JOIN courses c ON c.cid = m.cid WHERE m.sid = $sid";
    $marks_result = mysqli_query($conn, $marks_query);

    // Fetch courses
    $courses_query = "SELECT c.cid, c.cname FROM takes t JOIN courses c ON t.cid = c.cid WHERE t.sid = $sid";
    $courses_result = mysqli_query($conn, $courses_query);

    // Initialize variables
    $result = 0;
    $total_credits = 0;

    // Check if there are any marks assigned
    if (mysqli_num_rows($marks_result) > 0) {
        while ($row = mysqli_fetch_assoc($marks_result)) {
            // Assuming marks table has fields: sid, cid, marks, grade
            $credit_query = "SELECT credit FROM courses WHERE cid = " . $row['cid'];
            $credit_result = mysqli_query($conn, $credit_query);
            $credit_row = mysqli_fetch_assoc($credit_result);
            $credit = $credit_row['credit'];
            $grade = $row['grade'];

            // Calculate grade points
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
                    $grade_points = 3;
                    break;
                default:
                    $grade_points = 0;
                    break;
            }

            $result += ($grade_points * $credit);
            $total_credits += $credit;
        }

        // Calculate result only if total credits is not zero
        if ($total_credits != 0) {
            $result /= $total_credits;
        } else {
            $message = "Marks have not been assigned yet.";
        }
    } else {
        $message = "Marks have not been assigned yet.";
    }

    // Fetch student details again to use later
    $row1 = mysqli_fetch_assoc($student_result);
    ?>

    <h1>Welcome, <?php echo $row1['sname']; ?>!</h1>

    <h2>Your Details:</h2>
    <table>
        <thead>
            <tr>
                <th>Student ID</th>
                <th>Name</th>
            </tr>
        </thead>
        <tbody>
            <?php
            mysqli_data_seek($student_result, 0); // Reset pointer to beginning of result set
            while ($row = mysqli_fetch_assoc($student_result)) {
                echo "<tr>";
                echo "<td>" . $row['sid'] . "</td>";
                echo "<td>" . $row['sname'] . "</td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>

    <h2>Your Courses:</h2>
    <table>
        <thead>
            <tr>
                <th>Course ID</th>
                <th>Course Name</th>
            </tr>
        </thead>
        <tbody>
            <?php
            while ($row = mysqli_fetch_assoc($courses_result)) {
                echo "<tr>";
                echo "<td>" . $row['cid'] . "</td>";
                echo "<td>" . $row['cname'] . "</td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>

    <h2>Your Attendance Records:</h2>
    <table>
        <thead>
            <tr>
                <th>Course ID</th>
                <th>Date</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php
            mysqli_data_seek($attendance_result, 0); // Reset pointer to beginning of result set
            while ($row = mysqli_fetch_assoc($attendance_result)) {
                echo "<tr>";
                echo "<td>" . $row['cid'] . "</td>";
                echo "<td>" . $row['date'] . "</td>";
                echo "<td>" . $row['status'] . "</td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>

    <h2>Your Marks:</h2>
    <table>
        <thead>
            <tr>
                <th>Course ID</th>
                <th>Course Name</th>
                <th>Marks</th>
                <th>Grade</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Fetch marks along with course name
            $marks_query = "SELECT m.cid, m.marks, m.grade, c.cname FROM marks m JOIN courses c ON m.cid = c.cid WHERE m.sid = $sid";
            $marks_result = mysqli_query($conn, $marks_query);

            while ($row = mysqli_fetch_assoc($marks_result)) {
                echo "<tr>";
                echo "<td>" . $row['cid'] . "</td>";
                echo "<td>" . $row['cname'] . "</td>";
                echo "<td>" . $row['marks'] . "</td>";
                echo "<td>" . $row['grade'] . "</td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>

    <h2>Your Result:</h2>
    <p>Your result is:
        <?php echo number_format($result, 2); ?>
    </p>
    <p>Your grade is:
        <?php echo getGrade($result); ?>
    </p>

</body>

</html>