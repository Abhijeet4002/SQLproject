<?php
session_start(); // Start the session

// Include database connection
include("connection.php");

// Check if the faculty member is logged in
if (!isset($_SESSION['fid'])) {
    header("Location: fac_index.php"); // Redirect to login page if not logged in
    exit();
}

// Check if the course ID is provided in the POST data
if (!isset($_POST['cid'])) {
    header("Location: attendance.php"); // Redirect back to marks.php if cid is not set
    exit();
}

$cid = $_POST['cid'];

// Fetch course information
$course_query = "SELECT * FROM courses WHERE cid = $cid";
$course_result = mysqli_query($conn, $course_query);
$course = mysqli_fetch_assoc($course_result);

// Fetch students enrolled in the selected course taught by the logged-in faculty
$fid = $_SESSION['fid'];
$students_query = "SELECT s.sid, s.sname FROM students s JOIN instructor i ON s.sid = i.sid WHERE i.cid = $cid AND i.fid = $fid";
$students_result = mysqli_query($conn, $students_query);

// Handle form submission for taking attendance
$inserted = false;
$message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if status data is set and is an array
    if (isset($_POST['status']) && is_array($_POST['status']) && !empty($_POST['status'])) {
        // Loop through each student and insert attendance status
        foreach ($_POST['status'] as $sid => $status) {
            // Check if attendance entry already exists for this student, course, and date
            $check_query = "SELECT * FROM attendance WHERE sid = $sid AND cid = $cid AND date = CURDATE()";
            $check_result = mysqli_query($conn, $check_query);

            if (mysqli_num_rows($check_result) == 0) {
                // Insert attendance data into the database
                $insert_query = "INSERT INTO attendance (sid, cid, date, status) VALUES ($sid, $cid, CURDATE(), '$status')";
                $inserted = mysqli_query($conn, $insert_query);
            } else {
                // Display a message indicating that the attendance entry already exists
                $message = "Attendance entry already exists for Student ID $sid.";
            }
        }

        // Set confirmation message if attendance was inserted
        if ($inserted) {
            $message = "Attendance successfully recorded.";
            echo "<script>alert('$message'); window.location.href = 'attendance.php';</script>";
            exit();
        }
    } 
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Take Attendance</title>
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

        .item-logout{
            margin-left: auto;
            margin-right: 20px;
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
    <h1>Take Attendance for Course:
        <?php echo $course['cname']; ?>
    </h1>
    <form method="POST">
        <input type="hidden" name="cid" value="<?php echo $cid; ?>">
        <?php
        // Display input fields for each student
        while ($student = mysqli_fetch_assoc($students_result)) {
            echo "<label for='status_" . $student['sid'] . "'>Status for " . $student['sname'] . " (SID: " . $student['sid'] . "): </label>";
            echo "<select id='status_" . $student['sid'] . "' name='status[" . $student['sid'] . "]' required>";
            echo "<option value='Present'>Present</option>";
            echo "<option value='Absent'>Absent</option>";
            echo "</select><br><br>";
        }
        ?>
        <input type="submit" value="Submit">
    </form>
    <?php if (!empty($message)) : ?>
    <p>
        <?php echo $message; ?>
    </p>
    <?php endif; ?>
</body>

</html>