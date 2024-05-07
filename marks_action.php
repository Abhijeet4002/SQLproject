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
    header("Location: marks.php"); // Redirect back to marks.php if cid is not set
    exit();
}

$cid = $_POST['cid'];

// Fetch course information
$course_query = "SELECT * FROM courses WHERE cid = $cid";
$course_result = mysqli_query($conn, $course_query);
$course = mysqli_fetch_assoc($course_result);

// Fetch students enrolled in the selected course based on the instructor table
$fid = $_SESSION['fid'];
$students_query = "SELECT s.sid, s.sname FROM students s JOIN instructor i ON s.sid = i.sid WHERE i.cid = $cid AND i.fid = $fid";
$students_result = mysqli_query($conn, $students_query);

// Handle form submission for inserting or updating marks
$inserted = false;
$message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if marks data is set and is an array
    if (isset($_POST['marks']) && is_array($_POST['marks']) && !empty($_POST['marks'])) {
        // Loop through each student and insert/update marks
        foreach ($_POST['marks'] as $sid => $marks) {
            $grade = $_POST['grade'][$sid];
            
            // Insert or update marks for the specified student and cid
            $check_query = "SELECT * FROM marks WHERE sid = $sid AND cid = $cid";
            $check_result = mysqli_query($conn, $check_query);

            if (mysqli_num_rows($check_result) == 0) {
                // Insert marks data into the database
                $insert_query = "INSERT INTO marks (sid, cid, marks, grade) VALUES ($sid, $cid, $marks, '$grade')";
                $inserted = mysqli_query($conn, $insert_query);
            } else {
                // Update marks data in the database
                $update_query = "UPDATE marks SET marks = $marks, grade = '$grade' WHERE sid = $sid AND cid = $cid";
                $updated = mysqli_query($conn, $update_query);
            }
        }

        // Set confirmation message if marks were inserted or updated
        if ($inserted || $updated) {
            $message = "Marks have been successfully inserted/updated.";
            echo "<script>alert('$message'); window.location.href = 'marks.php';</script>";
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
    <title>Insert/Update Marks</title>
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
    <h1>Insert/Update Marks for Course:
        <?php echo $course['cname']; ?>
    </h1>
    <form method="POST">
        <input type="hidden" name="cid" value="<?php echo $cid; ?>">
        <?php
        // Display input fields for each student
        while ($student = mysqli_fetch_assoc($students_result)) {
            echo "<label for='marks_" . $student['sid'] . "'>Marks for " . $student['sname'] . " (SID: " . $student['sid'] . "): </label>";
            echo "<input type='number' id='marks_" . $student['sid'] . "' name='marks[" . $student['sid'] . "]' required><br><br>";
            echo "<label for='grade_" . $student['sid'] . "'>Grade for " . $student['sname'] . " (SID: " . $student['sid'] . "): </label>";
            echo "<input type='text' id='grade_" . $student['sid'] . "' name='grade[" . $student['sid'] . "]' required><br><br>";
        }
        ?>
        <input type="submit" value="Submit">
    </form>
</body>

</html>