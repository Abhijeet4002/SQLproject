<?php
    include("../connection.php");

    session_start();

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $username = $_POST['user'];
        $pass = $_POST['pass'];
        $password=hash('sha256',$pass);

        $sql = "SELECT * FROM admin_table WHERE email = '$username' AND password = '$password'";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) == 1) {
            $row = mysqli_fetch_assoc($result);
            
            header("Location: admin_dash.php");
            exit();
        } else {
            echo "<script>alert('Invalid username or password');</script>";
        }
    }
?>

<html>
<head>
    <title>Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            /* background-color: blueviolet; */
            background-image:url(../images/admin_img_back.jpg);
            background-position:center;
            background-repeat:no-repeat;
            background-size:cover;
            
        }

        #form {
            background-color:rgb(189, 226, 241);
            width: 25%;
            border-radius: 4px;
            margin: 120px auto;
            padding: 50px;
            border-radius: 20px;
            box-shadow: 10px 10px 5px rgb(82, 11, 77);
        }

        #btn {
            color: rgb(255, 255, 255);
            background-color: green;
            padding: 10px;
            font-size: large;
            border-radius: 10px;
        }
        input{
            margin-left:10px;
            border:none;
            outline:none;
            font-family: Cambria, Cochin, Georgia, Times, 'Times New Roman', serif;
            font-size: 20px;
            height: 30px;
            border-radius:5px;
            margin-bottom: 10px;
            width:60%;
        }
        label{
            font-family: Arial, Helvetica, sans-serif;
            font-size: 20px;
            font-weight: bold;
        }
        .head{
            margin-bottom: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .btn{
            
            display: flex;
            justify-content: center;
            align-items: center;
        }
        button{
            border:none;
            outline:none;
            cursor:pointer;
        }
  


        @media screen and (max-width: 570px) {
            #form {
                width: 65%;
                margin-left: none;
                padding: 40px;
            }
        }
    </style>
</head>

<body>
    <div id="form">
     <div class="head">
        <h1>Admin Login</h1>
     </div>
        <form name="form" action="admin.php" onsubmit="return isvalid()" method="POST">
            <label>Username: </label>
            <input type="text" id="user" name="user"></br></br>
            <label>Password: </label>
            <input type="password" id="pass" name="pass"></br></br>
            <div class="btn">
                <!-- <input type="submit" id="btn" value="Login" name="Login" /> -->
                <button type="submit" id="btn" value="Login" name="Login"> Login</button>
            </div>
      

        </form>
    </div>
    <script>
        function isvalid() {
            var user = document.form.user.value;
            var pass = document.form.pass.value;
            if (user.length == "" && pass.length == "") {
                alert(" Username and password field is empty!!!");
                return false;
            }
            else if (user.length == "") {
                alert(" Username field is empty!!!");
                return false;
            }
            else if (pass.length == "") {
                alert(" Password field is empty!!!");
                return false;
            }

        }
    </script>
</body>

</html>