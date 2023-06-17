<?php
require_once 'user/user.php';
require_once 'connection/connection.php';
// Include connection.php and establish database connection

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Validate and sanitize input data
    $user = new User($connection);
    $result = $user->login($email, $password);

    if ($result) {
        echo "<script>alert('User created successfully!');</script>";
        
        // Redirect to index.php or any other page
        header("Location: index.php");
        exit();

    } else {
        echo "<script>alert('Invalid credentials. User creation failed.');</script>";
    }
}
?>

<!doctype html>
<html lang="en">

<head>

    <!--====== Required meta tags ======-->
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!--====== Title ======-->
    <title>Login - Yenibab Mead</title>
    <link rel="shortcut icon" href="images/favicon.png" type="image/png">
    <link rel="stylesheet" href="assets/css/slick.css">
    <link rel="stylesheet" href="assets/css/animate.css">
    <link rel="stylesheet" href="assets/css/nice-select.css">
    <link rel="stylesheet" href="assets/css/jquery.nice-number.min.css">
    <link rel="stylesheet" href="assets/css/magnific-popup.css">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/font-awesome.min.css">
    <link rel="stylesheet" href="assets/css/default.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/responsive.css">

    <style>
        .developer-credit {
            text-align: center;
            font-size: 18px;
            margin-top: 20px;
            color: #ffffff;
        }
        .developer-credit span {
            font-weight: bold;
            color: #f0f0f0;
        }
    </style>
</head>

<body>

 

    <section id="count-down-part" class="bg_cover pt-70 pb-120" data-overlay="4" style="background-image: url(assets/images/login-bg.jpg)">
        <div class="container">
            <div class="row align-items-center justify-content-center">
                <div class="col-lg-6">
                    <div class="count-down-cont pt-50">
                        <h3>Welcome Back</h3>
                        <h2>እንኳን ወደ የንባብ ማዕድ በደህና መጡ!</h2>
                    </div>
                    <div class="developer-credit">
                        Developed by <span>Gemechis Elias</span>, <span>Habteyesus Tadese</span>, <span>Etsub Hayelom</span>, <span>Duresa Fayisa</span> and <span>Fikre</span>.
                    </div>
                    <!-- count down cont -->
                </div>
                <div class="col-lg-5 offset-lg-1 col-md-8">
                    <div class="category-form category-form-3 pt-50">
                        <div class="form-title text-center">
                            <h3>New Registration</h3>
                            <span>Login now </span>
                        </div>
                        <div class="main-form">
                        <form action="login.php" method="POST">
                          
                            <div class="singel-form">
                                <input type="email" name="email" placeholder="Email">
                            </div>
                            <div class="singel-form">
                                <input type="password" name="password" placeholder="Password">
                            </div>
                            <div class="singel-form">
                                <button class="main-btn" name="submit" type="submit">Login</button>
                            </div>
                        </form>

                            <p style="margin-top: 10px;">Not registred? <a href="signup.php" style="color: blue;">SignUp Here</a></p>
                        </div>
                    </div>
                    <!-- category form -->
                </div>
            </div>
            <!-- row -->
        </div>
        <!-- container -->
    </section>






    <!--====== jquery js ======-->
    <script src="assets/js/vendor/modernizr-3.6.0.min.js"></script>
    <script src="assets/js/vendor/jquery-1.12.4.min.js"></script>

    <!--====== Bootstrap js ======-->
    <script src="assets/js/bootstrap.min.js"></script>

    <!--====== Slick js ======-->
    <script src="assets/js/slick.min.js"></script>

    <!--====== Magnific Popup js ======-->
    <script src="assets/js/jquery.magnific-popup.min.js"></script>

    <!--====== Counter Up js ======-->
    <script src="assets/js/waypoints.min.js"></script>
    <script src="assets/js/jquery.counterup.min.js"></script>

    <!--====== Nice Select js ======-->
    <script src="assets/js/jquery.nice-select.min.js"></script>

    <!--====== Nice Number js ======-->
    <script src="assets/js/jquery.nice-number.min.js"></script>

    <!--====== Count Down js ======-->
    <script src="assets/js/jquery.countdown.min.js"></script>

    <!--====== Validator js ======-->
    <script src="assets/js/validator.min.js"></script>

    <!--====== Ajax Contact js ======-->
    <script src="assets/js/ajax-contact.js"></script>

    <!--====== Main js ======-->
    <script src="assets/js/main.js"></script>

    <!--====== Map js ======-->
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDC3Ip9iVC0nIxC6V14CKLQ1HZNF_65qEQ"></script>
    <script src="assets/js/map-script.js"></script>

</body>

</html>