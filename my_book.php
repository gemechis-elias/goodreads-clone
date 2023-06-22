<?php
require_once 'user/user.php';
require_once 'connection/connection.php';
require_once 'books/book.php'; 
require_once 'posts/post.php';

session_start();

// Check if user is not logged in (session doesn't exist)
if (!isset($_SESSION['user'])) {
    // Redirect to login page
    header("Location: login.php");
    exit();
}

// User is logged in
$email = $_SESSION['user']['email'];

// Instantiate the User class and pass the database connection
$user = new User($connection);

// Get the user's ID by email
$userId = $user->getUserIdByEmail($email);
// Get the Current User
$current_user = $user->getUser($userId);
$books = new Book($connection);
$all_book = $books->getAllBooks();


// Check if the shopping-cart or heart-o buttons are clicked
if (isset($_GET['action'])) {
    $action = $_GET['action'];
    $bookId = $_GET['book_id'];

    // Perform the corresponding action based on the button clicked
    switch ($action) {
        case 'add_to_cart':
            $user->addToCart($userId, $bookId);
            // refresh the page
            header("Location: index.php");
            break;
        case 'add_to_my_books':
            $user->addToMyBooks($userId, $bookId);
            header("Location: index.php");
            break;
    }
}

// Get All Book in Cart
$totalBooksInCart = $user->getTotalBooksInCart($userId);

// Upload Post
$post = new Post($connection);
if (isset($_POST['post_comment'])) {
 
    $title = $_POST['title'];
    $description = $_POST['description'];
    $author = $current_user['name'];
    $date = date("Y-m-d"); 
    $post = new Post($connection);

    $image = '';
    if (!empty($_FILES['image']['name'])) {
        $file = $_FILES['image'];
        $fileName = $file['name'];
        $fileSize = $file['size'];
        $fileTmp = $file['tmp_name'];
        $fileError = $file['error'];

        // Check if the file is an image
        $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        $allowedExtensions = array('jpg', 'jpeg', 'png', 'gif');
        if (!in_array($fileExt, $allowedExtensions)) {
            echo "Error: Only JPG, JPEG, PNG, and GIF files are allowed.";
            exit;
        }
        $maxFileSize = 5 * 1024 * 1024; // 5 MB in bytes
        if ($fileSize > $maxFileSize) {
            echo "Error: File size exceeds the maximum limit (5 MB).";
            exit;
        }

        $newFileName = uniqid('', true) . '.' . $fileExt;
        $uploadDir = 'uploads/posts/';

        if (!move_uploaded_file($fileTmp, $uploadDir . $newFileName)) {
            echo "Error: Failed to upload the file.";
            exit;
        }
        $image = $newFileName;
    }
    $post = new Post($connection);
    $post->addPost($title, $description, $author, $image, $date);
    header("Location: index.php#news-part");

}
?>
<!doctype html>
<html lang="en">

<head>
   
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    
    <title>My Books</title>
    <link rel="shortcut icon" href="assets/images/favicon.png" type="image/png">
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
</head>

<body>

    
    <header id="header-part">
 
        <div class="navigation">
            <div class="container">
                <div class="row">
                    <div class="col-lg-10 col-md-10 col-sm-9 col-8">
                        <nav class="navbar navbar-expand-lg">
                            <a class="navbar-brand" href="index-4.html">
                                <img style="width:180px;" src="assets/images/logo-2.png" alt="Logo">
                            </a>
                            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                            </button>

                            <div class="collapse navbar-collapse sub-menu-bar" id="navbarSupportedContent">
                            <ul class="navbar-nav ml-auto">
                                    <li class="nav-item">
                                        <a  href="index.php">Home</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="active" href="my_book.php">My Books</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="browse_books.php">Browse</a>
                                        <ul class="sub-menu">
                                            <li><a href="browse_books.php">Recommendation</a></li>
                                            <li><a href="browse_books.php">Choice Awards</a></li>
                                            <li><a href="browse_books.php">News and Interview</a></li>
                                            <li><a href="">Explore </a></li>

                                        </ul>
                                    </li>
                                    <li class="nav-item">
                                        <a href="community.php">Community</a>
                                       
                                    </li>
                                   
                                    <li class="nav-item">
                                        <a href="cart.php">Cart</a>
                                        <ul class="sub-menu">
                                            <li><a href="cart.php">My Cart</a></li>
                                            <li><a href="about.php">Wish List</a></li>
                                        </ul>
                                    </li>
                                    <li class="nav-item">
                                        <a href="logout.php">Logout</a>
                                    </li>
                                </ul>
                             </div>
                        </nav>
                    </div>
                    <div class="col-lg-1 col-md-2 col-sm-3 col-3">
                        <div class="right-icon text-right">
                            <ul>
                                <li><a href="#"><i class="fa fa-cart-plus"></i><span><?php echo $totalBooksInCart?></span></a></li>
                            </ul>
                        </div>  
                    </div>
                </div>  
            </div>  
        </div>
    </header>
    
    <div class="search-box">
        <div class="serach-form">
            <div class="closebtn">
                <span></span>
                <span></span>
            </div>
            <form action="#">
                <input type="text" placeholder="Search by keyword">
                <button><i class="fa fa-search"></i></button>
            </form>
        </div> <!-- serach form -->
    </div>

    
    <section id="teachers-singel" class="pt-70 pb-120 gray-bg">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-4 col-md-8">
                    <div class="teachers-left mt-50">
                        <div class="hero">
                            <img src="uploads/profile/<?php echo $current_user['profile_pic'] ?>" alt="Profile Picture">
                        </div>
                        <div class="name">
                            <h6><?php echo $current_user['name']; ?></h6>
                            <span><?php echo $current_user['bio']; ?></span></br>
                            <!--------Change profile button -->
                            <button type="button" id="changeProfileBtn" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalCenter">
                                Change Profile
                            </button>
                            <br>
                            <br>
                            
                        </div>
                       
                      
                    </div>  
                </div>
                <div class="col-lg-8">
                    <div class="teachers-right mt-50">
                        <ul class="nav nav-justified" id="myTab" role="tablist">
                            <li class="nav-item">
                                <a class="active" id="dashboard-tab" data-toggle="tab" href="#dashboard" role="tab" aria-controls="dashboard" aria-selected="true">Profile</a>
                            </li>
                            
                            <li class="nav-item">
                                <a id="reviews-tab" data-toggle="tab" href="#reviews" role="tab" aria-controls="reviews" aria-selected="false">My Books</a>
                            </li>

                            <li class="nav-item">
                                <a id="reviews-tab" data-toggle="tab" href="#posts" role="tab" aria-controls="reviews" aria-selected="false">Create Post</a>
                            </li>
                        </ul>  
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="dashboard" role="tabpanel" aria-labelledby="dashboard-tab">
                                <div class="dashboard-cont">
                                    <div class="singel-dashboard pt-40">
                                        <h5>About</h5>
                                        <p><?php echo $current_user['about']; ?></p>
                                    </div>  
                                    <div class="singel-dashboard pt-40">
                                        <h5>GEMECHIS’S QUOTES</h5>
                                        <p><?php echo $current_user['qoutes']; ?></p>
                                    </div>  
                                    <div class="singel-dashboard pt-40">
                                        <h5>FAVORITE GENRES</h5>
                                        <p>Christian<br>Novel<br>Science</p>
                                    </div>  
                                </div> 
                            </div>
                      
                            <div class="tab-pane fade" id="reviews" role="tabpanel" aria-labelledby="reviews-tab">
                                <div class="reviews-cont">
                                    <div class="title">
                                        <h6>Saved Books</h6>
                                    </div>
                                    <ul>
                                       <li>
                                       <?php
                                            $mybooks = $user->getMyBooks($userId);
                                            foreach ($mybooks as $s_book) {
                                                $bookId = $s_book['book_id'];
                                                $book = $books->getSingleBook($bookId);

                                                $imagePath = "uploads/" . $book['image'];
                                                $title = $book['title'];
                                                $author = $book['author'];
                                                $description = $book['description'];
                                                $date = $book['date'];
                                            ?>
                                           <div class="singel-reviews">
                                                <div class="reviews-author">
                                                    <div class="author-thum">
                                                        <img style="width:80px; height:100px; " src="<?php echo $imagePath; ?>" alt="Reviews">
                                                    </div>
                                                    <div class="author-name">
                                                        <h6><?php echo $title; ?></h6>
                                                        <span><?php echo $author; ?></span> - 
                                                        <span><?php echo $date; ?></span>
                                                    </div>
                                                </div>
                                                <div class="reviews-description pt-20">
                                                    <p><?php echo $description; ?></p>
                                              
                                                </div>
                                            </div>  
                                      
                                            <?php
                                                }
                                            ?>  
                                            </li>
                                    </ul>
                                   </div>  
                            </div>
                            <div class="tab-pane fade" id="posts" role="tabpanel" aria-labelledby="reviews-tab">
                                <div class="reviews-cont">
                                    <div class="title">
                                        <h6>Add New Posts</h6>
                                    </div> 
                                    <div class="reviews-form">
                                        <form action="#" method="post" enctype="multipart/form-data">
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <div class="form-singel">
                                                        <input type="file" name="image" placeholder="Choose Image">
                                                    </div>
                                                </div>
                                                <div class="col-lg-12">
                                                    <div class="form-singel">
                                                        <input type="text" name="title" placeholder="Title">
                                                    </div>
                                                </div>
                                                <div class="col-lg-12">
                                                    <div class="form-singel">
                                                        <textarea name="description" placeholder="Write a post..."></textarea>
                                                    </div>
                                                </div>
                                                <div class="col-lg-12">
                                                    <div class="form-singel">
                                                        <button type="submit" name="post_comment" class="main-btn">Upload Post</button>
                                                    </div>
                                                </div>
                                            </div> 
                                        </form>
                                    </div> </div>
                            </div>
                        </div>  
                    </div>  
                </div>
            </div>  
        </div>  
    </section>


    <footer id="footer-part">
        <div class="footer-top pt-40 pb-70">
            <div class="container">
                <div class="row">
                    <div class="col-lg-3 col-md-6">
                        <div class="footer-about mt-40">
                            <div class="logo">
                            <img style="width:180px;" src="assets/images/logo.png" alt="Logo">

                            </div>
                            <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ማንበብ ሙሉ ሰው ያደርጋል!</p>
                            <ul class="mt-20">
                                <li><a href="#"><i class="fa fa-facebook-f"></i></a></li>
                                <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                                <li><a href="#"><i class="fa fa-google-plus"></i></a></li>
                                <li><a href="#"><i class="fa fa-instagram"></i></a></li>
                            </ul>
                        </div>  
                    </div>
                    <div class="col-lg-4 col-md-6 col-sm-6">
                        <div class="footer-link mt-40">
                            <div class="footer-title pb-25">
                                <h6>Sitemap</h6>
                            </div>
                            <ul>
                                <li><a href="index-2.html"><i class="fa fa-angle-right"></i>Home</a></li>
                                <li><a href="about.html"><i class="fa fa-angle-right"></i>About us</a></li>
                                <li><a href="courses.html"><i class="fa fa-angle-right"></i>Courses</a></li>
                            </ul>
                            <ul>
                                <li><a href="#"><i class="fa fa-angle-right"></i>Gallery</a></li>
                                <li><a href="shop.html"><i class="fa fa-angle-right"></i>Shop</a></li>
                                <li><a href="teachers.html"><i class="fa fa-angle-right"></i>Teachers</a></li>
                            </ul>
                        </div>  
                    </div>
                    <div class="col-lg-2 col-md-6 col-sm-6">
                        <div class="footer-link support mt-40">
                            <div class="footer-title pb-25">
                                <h6>Support</h6>
                            </div>
                            <ul>
                                <li><a href="#"><i class="fa fa-angle-right"></i>FAQS</a></li>
                                <li><a href="#"><i class="fa fa-angle-right"></i>Privacy</a></li>
                                <li><a href="#"><i class="fa fa-angle-right"></i>Policy</a></li>
                            </ul>
                        </div> 
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="footer-address mt-40">
                            <div class="footer-title pb-25">
                                <h6>Contact Us</h6>
                            </div>
                            <ul>
                                <li>
                                    <div class="icon">
                                        <i class="fa fa-home"></i>
                                    </div>
                                    <div class="cont">
                                        <p>Addis Ababa Science and Technology University</p>
                                    </div>
                                </li>
                            
                                <li>
                                    <div class="icon">
                                        <i class="fa fa-envelope-o"></i>
                                    </div>
                                    <div class="cont">
                                        <p>Section B, SWE</p>
                                    </div>
                                </li>
                            </ul>
                        </div>  
                    </div>
                </div>  
            </div>  
        </div>  
    </footer>
    <a href="#" class="back-to-top"><i class="fa fa-angle-up"></i></a>
    <script src="assets/js/vendor/modernizr-3.6.0.min.js"></script>
    <script src="assets/js/vendor/jquery-1.12.4.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/slick.min.js"></script>
    <script src="assets/js/jquery.magnific-popup.min.js"></script>
    <script src="assets/js/waypoints.min.js"></script>
    <script src="assets/js/jquery.counterup.min.js"></script>
    <script src="assets/js/jquery.nice-select.min.js"></script>
    <script src="assets/js/jquery.nice-number.min.js"></script>
    <script src="assets/js/jquery.countdown.min.js"></script>
    <script src="assets/js/validator.min.js"></script>
    <script src="assets/js/ajax-contact.js"></script>
    <script src="assets/js/main.js"></script>
    <script src="assets/js/map-script.js"></script>
    <script>
        // Add an event listener to the button
        document.getElementById('changeProfileBtn').addEventListener('click', function() {
        // Create an input element of type file
        var input = document.createElement('input');
        input.type = 'file';

        // Add change event listener to the input element
        input.addEventListener('change', function(event) {
            var file = event.target.files[0];  
            var formData = new FormData();  

            formData.append('profile_pic', file);  

            // Send the form data via AJAX to update the profile picture
            var xhr = new XMLHttpRequest();
            xhr.open('POST', 'update-profile.php'); 
            xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                alert('Profile picture updated!');
                // refresh page
                window.location.reload();
                } else {
                alert('Error updating profile picture. Please try again.');
                }
            }
            };
            xhr.send(formData);
        });
        input.click();
        });
    </script>
 




</body>
</html>
