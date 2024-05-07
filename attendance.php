<?php
session_start(); // Start the session

// Include database connection
include("connection.php");

// Check if the faculty member is logged in
if (!isset($_SESSION['fid'])) {
    header("Location: fac_index.php"); // Redirect to login page if not logged in
    exit();
}

// Fetch the courses taught by the currently logged-in faculty
$fid = $_SESSION['fid'];
$courses_query = "SELECT DISTINCT cid FROM instructor WHERE fid = $fid";
$courses_result = mysqli_query($conn, $courses_query);

// Store the course IDs in an array
$course_ids = [];
while ($row = mysqli_fetch_assoc($courses_result)) {
    $course_ids[] = $row['cid'];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Marks</title>
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
    <h1>Select Course to Take Attendance</h1>
    <div>
        <?php
        // Display buttons for each course taught by the faculty
        foreach ($course_ids as $cid) {
            echo "<form method='POST' action='attendance_action.php'>";
            echo "<input type='hidden' name='cid' value='$cid'>";
            echo "<input type='submit' value='Take Attendance for CID: $cid'>";
            echo "</form>";
        }
        ?>
    </div>
</body>

</html>