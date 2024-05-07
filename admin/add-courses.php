<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Course</title>
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
        <div class="item">
            <a href="http://localhost/phptutorial/admin/admin_dash.php">
                <button type="button" class="btn btn-primary">Admin dashboard</button>
            </a>
        </div>
    </div>
</head>
<body>
    <div class="container mt-4">
        <h1>Add Course</h1>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <div class="mb-3">
                <label for="cname" class="form-label">Course Name</label>
                <input type="text" class="form-control" id="cname" name="cname" required>
            </div>
            <div class="mb-3">
                <label for="credit" class="form-label">Credit</label>
                <input type="number" class="form-control" id="credit" name="credit" required>
            </div>
            <div class="mb-3">
                <label for="did" class="form-label">Department</label>
                <select class="form-select" id="did" name="did" required>
                    <option value="">Select Department</option>
                    <option value="101">CSE</option>
                    <option value="102">ECE</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Add Course</button>
        </form>

        <?php
        session_start(); // Start the session

        // Include database connection
        include("../connection.php");

        // Check if the form is submitted
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Retrieve input values from the form
            $cname = $_POST['cname'];
            $credit = $_POST['credit'];
            $did = $_POST['did'];

            // Query to find the maximum existing course ID
            $max_cid_query = "SELECT MAX(cid) AS max_cid FROM courses";
            $result = mysqli_query($conn, $max_cid_query);
            $row = mysqli_fetch_assoc($result);
            $max_cid = $row['max_cid'];

            // Calculate the next available course ID
            $new_cid = $max_cid + 1;

            // Insert new course into the database
            $insert_query = "INSERT INTO courses (cid, cname, credit, did) VALUES ('$new_cid', '$cname', '$credit', '$did')";
            if (mysqli_query($conn, $insert_query)) {
                echo "<div class='alert alert-success mt-3' role='alert'>Course added successfully.</div>";
            } else {
                echo "<div class='alert alert-danger mt-3' role='alert'>Error: " . mysqli_error($conn) . "</div>";
            }
        }
        ?>
    </div>
</body>
</html>