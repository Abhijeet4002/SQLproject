<?php
session_start(); // Start the session

// Include database connection
include("../connection.php");

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve student ID from the form
    $sid = $_POST['sid'];

    // Delete related records first
    $delete_stud_pass_query = "DELETE FROM stud_pass WHERE sid = '$sid'";
    $delete_instructor_query = "DELETE FROM instructor WHERE sid = '$sid'";
    $delete_takes_query = "DELETE FROM takes WHERE sid = '$sid'";
    $delete_attendance_query = "DELETE FROM attendance WHERE sid = '$sid'"; // Add this line to delete attendance records

    mysqli_query($conn, $delete_stud_pass_query);
    mysqli_query($conn, $delete_instructor_query);
    mysqli_query($conn, $delete_takes_query);
    mysqli_query($conn, $delete_attendance_query); // Execute the attendance deletion query

    // Delete student record
    $delete_student_query = "DELETE FROM students WHERE sid = '$sid'";
    mysqli_query($conn, $delete_student_query);

    // Show confirmation message
    echo "<script>alert('Student with ID $sid deleted successfully');</script>";
    echo "<script>window.setTimeout(function(){ window.location.href = 'admin_dash.php'; }, 1000);</script>";
    exit();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Student</title>
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
    </div></head>
<body>
    <h1>Delete Student</h1>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="sid">Enter Student ID:</label><br>
        <input type="text" id="sid" name="sid" required><br>

        <input type="submit" value="Delete" onclick="return confirm('Are you sure you want to delete this student?');">
    </form>
</body>
</html>