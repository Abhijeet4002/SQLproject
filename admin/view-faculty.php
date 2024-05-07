<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Faculty</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous"></script>
    <style>
        .table-container {
            max-width: 800px;
            margin: 0 auto;
        }
    </style>
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
        <h1>View Faculty</h1>
        <div class="table-container">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Faculty ID</th>
                        <th>Name</th>
                        <th>Department ID</th>
                        <th>Email</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    session_start(); // Start the session

                    // Include database connection
                    include("../connection.php");

                    // Query to fetch faculty details
                    $query = "SELECT * FROM faculty";
                    $result = mysqli_query($conn, $query);

                    // Check if there are any faculty members
                    if (mysqli_num_rows($result) > 0) {
                        // Output data of each row
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<tr>";
                            echo "<td>" . $row['fid'] . "</td>";
                            echo "<td>" . $row['fname'] . "</td>";
                            echo "<td>" . $row['did'] . "</td>";
                            echo "<td>" . $row['email'] . "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='4'>No faculty members found.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>