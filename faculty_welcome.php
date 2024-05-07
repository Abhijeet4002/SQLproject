<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        body {
            background-color: #f2f2f2;
            font-family: Arial, sans-serif;
        }

        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .btn-container {
            text-align: center;
        }

        .btn-custom {
            padding: 15px 30px;
            font-size: 20px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin: 10px;
            transition: background-color 0.3s ease;
        }

        .btn-custom:hover {
            background-color: #0056b3;
        }
    </style>
</head>

<body style="background-color: black;">
    <div class="container">
        <div class="btn-container">
            <a href="http://localhost/phptutorial/fac_index.php">
                <button class="btn-custom">Attendance</button>
            </a>
            <a href="http://localhost/phptutorial/fac_index_marks.php">
                <button class="btn-custom">Marks</button>
            </a>
        </div>
    </div>

</body>

</html>