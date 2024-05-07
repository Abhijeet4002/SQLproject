<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
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
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background: linear-gradient(45deg, #7B1FA2, #03A9F4);
        }

        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .btn-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            align-items: center;
            gap: 20px;
        }

        .btn-custom {
            background-color: #4CAF50;
            border: none;
            color: white;
            padding: 15px 30px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            transition-duration: 0.4s;
            cursor: pointer;
            border-radius: 12px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transform: perspective(1px) translateZ(0);
            transition-duration: 0.3s;
        }

        .btn-custom:hover {
            background-color: #45a049;
            color: white;
            box-shadow: 0 12px 16px rgba(0, 0, 0, 0.2);
            transform: scale(1.05);
        }
    </style>
</head>

<body>

	<div class="box gradient-background" style="position: sticky; top: 0; z-index: 2">
        <div>
			<p>
				<h2 style="color: black;">Admin Dashboard</h2>
			</p>
		</div>
		<div class="item-logout">
            <a href="http://localhost/phptutorial/logout.php">
                <button type="button" class="btn btn-primary" style="color: black"><strong>Logout</strong>
                </button>
            </a>
        </div>
    </div>

    <div class="container">
        <div class="btn-container">
            <!-- Buttons for admin actions -->
            <a href="./add-student.php" class="btn-custom">Add students</a>
            <a href="./view-student.php" class="btn-custom">View students</a>
            <a href="./view-faculty.php" class="btn-custom">View faculty</a>
            <a href="./add-courses.php" class="btn-custom">Add courses</a>
            <a href="./view-courses.php" class="btn-custom">View courses</a>
            <a href="./delete-student.php" class="btn-custom">Delete student</a>
        </div>
    </div>
</body>
</html>