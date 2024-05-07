<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
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

        .custom-h2 {
            display: inline;
            color: navy;
            background-color: antiquewhite;
            box-shadow: -2px 10px 5px 3px lightseagreen;
        }

        .carousel-item img {
            height: 300px;
        }

        .carousel-iiitg {
            padding: 20px;
            margin-bottom: 20px;
        }

        .paragraph-container {
            margin-top: 20px;
            padding: 20px;
        }

        @media (max-width:1400px){
            .logo{
                text-align: center;
                display: block;
            }
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
       <div class = "item">
        <a href="http://localhost/phptutorial/faculty_welcome.php">
            <button type="button" class="btn btn-success" style="color: black;"><strong>Faculty Login</strong> </button>
            </a>
       </div>
       <div class = "item">
        <a href="http://localhost/phptutorial/stud_index.php">
            <button type="button" class="btn btn-success" style="color: black"><strong>Student Login</strong> </button>
            </a>
       </div>
       <div class = "item">
        <a href="http://localhost/phptutorial/admin/admin.php">
            <button type="button" class="btn btn-success" style="color: black"><strong>Admin Login</strong> </button>
            </a>
       </div>
    </div>
    <span>
        <img src="./images/logo.jpg" alt="hi" height="150px" class="logo">
        <h2 class="custom-h2 logo">INDIAN INSTITUTE OF INFORMATION TECHNOLOGY GUWAHATI</h2>
    </span>
    <br><br>
    <div class="container-fluid">
        <div class="carousel-iiitg">
            <div id="carouselExampleCaptions" class="carousel pointer slide" data-ride="carousel">
                <div class="carousel-indicators">
                    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active"
                        aria-current="true" aria-label="Slide 1"></button>
                    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1"
                        aria-label="Slide 2"></button>
                    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2"
                        aria-label="Slide 3"></button>
                </div>
                <div class="carousel-inner">
                    <div class="carousel-item active CIA">
                        <img src="./images/pic3.webp" class="d-block w-100" alt="...">
                        <div class="carousel-caption d-none d-md-block">
                            <h5>Academic Building</h5>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <img src="./images/pic2.jpg" class="d-block w-100" alt="...">
                        <div class="carousel-caption d-none d-md-block">
                            <h5>Canteen</h5>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <img src="./images/pic1.webp" class="d-block w-100" alt="...">
                        <div class="carousel-caption d-none d-md-block">
                            <h5>Hostel</h5>
                        </div>
                    </div>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions"
                    data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions"
                    data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
        </div>
        <div class="paragraph-container">
            <p>
                Indian Institute of Information Technology Guwahati (IIITG) is an institution of National Importance under
                an Act of Parliament (THE INDIAN INSTITUTES OF INFORMATION TECHNOLOGY (PUBLIC-PRIVATE PARTNERSHIP) ACT,
                2017). It offers B.Tech. courses in Electronics and Communication Engineering (ECE) and Computer Science
                Engineering (CSE), M.Tech. courses in CSE and ECE and runs PhD programmes in ECE, CSE, Mathematics, and
                Humanities and Social Sciences (HSS). IIITG started operations in August 2013 with B.Tech programmes in CSE
                and ECE. The first batch of B.Tech. students completed their programme in May 2017. The first convocation of
                the Institute was held on May 15 2018.The institute has further received funding for infrastructural
                development and academic improvement under TEQIP III.
            </p>
        </div>
    </div

    <div class="container-fluid">
        <footer class="py-3 my-4">
            <ul class="nav justify-content-center border-bottom pb-3 mb-3">
                <li class="nav-item"><a href="./home.php" class="nav-link px-2 text-body-secondary">Home</a></li>
                <li class="nav-item"><a href="./home.php" class="nav-link px-2 text-body-secondary">Features</a></li>
                <li class="nav-item"><a href="./home.php" class="nav-link px-2 text-body-secondary">About</a></li>
            </ul>
            <p class="text-center text-body-secondary">&copy; 2024, Inc</p>
        </footer>
    </div>
    
</body>

</html>