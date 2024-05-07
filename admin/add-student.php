<?php
session_start(); // Start the session

// Include database connection
include("../connection.php");

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $sname = $_POST['sname'];
    $dob = $_POST['dob'];
    $email = $_POST['email'];
    $pass = $_POST['pass'];
    $password = hash('sha256', $pass);
    $phone = $_POST['phone'];
    $did = $_POST['did'];

    // Find the max sid from students table
    $max_sid_query = "SELECT MAX(sid) AS max_sid FROM students";
    $result = mysqli_query($conn, $max_sid_query);
    $row = mysqli_fetch_assoc($result);
    $max_sid = $row['max_sid'];

    // Increment sid for the new student
    $sid = $max_sid + 1;

    // Insert student details into students table
    $insert_student_query = "INSERT INTO students (sid, did, sname, dob, email, phone) 
                            VALUES ('$sid', '$did', '$sname', '$dob', '$email', '$phone')";
    mysqli_query($conn, $insert_student_query);

    // Insert data into stud_pass table
    $insert_pass_query = "INSERT INTO stud_pass (sid, email, password) 
                        VALUES ('$sid', '$email', '$password')";
    mysqli_query($conn, $insert_pass_query);

    // Retrieve selected courses
    if(isset($_POST['courses'])) {
        $selected_courses = $_POST['courses'];
        foreach ($selected_courses as $cid) {
            // Insert into takes table
            $insert_takes_query = "INSERT INTO takes (sid, cid) VALUES ('$sid', '$cid')";
            mysqli_query($conn, $insert_takes_query);

            // Get fid from teaches table for each selected course and insert into instructor table
            $get_fid_query = "SELECT fid FROM teaches WHERE cid = '$cid' LIMIT 1"; 
            $result = mysqli_query($conn, $get_fid_query);
            $row = mysqli_fetch_assoc($result);
            $fid = $row['fid'];
            // Insert into instructor table
            $insert_instructor_query = "INSERT INTO instructor (sid, fid, cid) VALUES ('$sid', '$fid', '$cid')";
            mysqli_query($conn, $insert_instructor_query);
        }
    }

   // Redirect after successful insertion
    echo "<script>alert('Student added successfully');</script>";
    echo "<script>window.location.href = 'admin_dash.php';</script>";
    exit();

}

// Retrieve courses for CSE and ECE departments
$cse_courses_query = "SELECT * FROM courses WHERE did = 101"; // Assuming 101 is the department ID for CSE
$ece_courses_query = "SELECT * FROM courses WHERE did = 102"; // Assuming 102 is the department ID for ECE
$cse_courses_result = mysqli_query($conn, $cse_courses_query);
$ece_courses_result = mysqli_query($conn, $ece_courses_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Student</title>
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
</head>
<body>
    <h1>Add Student</h1>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="sname">Student Name:</label><br>
        <input type="text" id="sname" name="sname" required><br>

        <label for="dob">Date of Birth:</label><br>
        <input type="date" id="dob" name="dob" required><br>

        <label for="email">Email:</label><br>
        <input type="email" id="email" name="email" required><br>

        <label for="pass">Password:</label><br>
        <input type="password" id="pass" name="pass" required><br>

        <label for="phone">Phone Number:</label><br>
        <input type="text" id="phone" name="phone" required><br>

        <label for="did">Select Department:</label><br>
        <select name="did" id="did">
            <option value="101">CSE</option>
            <option value="102">ECE</option>
        </select><br>

        <label for="courses">Select Courses:</label><br>
        <label>CSE Courses:</label><br>
        <?php while($row = mysqli_fetch_assoc($cse_courses_result)): ?>
            <input type="checkbox" name="courses[]" value="<?php echo $row['cid']; ?>"><?php echo $row['cname']; ?><br>
        <?php endwhile; ?>
        <label>ECE Courses:</label><br>
        <?php mysqli_data_seek($ece_courses_result, 0); ?>
        <?php while($row = mysqli_fetch_assoc($ece_courses_result)): ?>
            <input type="checkbox" name="courses[]" value="<?php echo $row['cid']; ?>"><?php echo $row['cname']; ?><br>
        <?php endwhile; ?>

        <input type="submit" value="Submit">
    </form>
</body>
</html>