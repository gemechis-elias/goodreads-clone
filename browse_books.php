<?php
require_once 'user/user.php';
require_once 'connection/connection.php';
require_once 'books/book.php';
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

?>

<!doctype html>
<html lang="en">

<head>
   
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    
    <title>Books List</title>
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
                         <img src="assets/images/logo.png" alt="Logo">
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
                                 <a href="my_book.php">My Books</a>
                             </li>
                             <li class="nav-item">
                                 <a  class="active" href="browse_books.php">Browse</a>
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
    <section id="page-banner" class="pt-105 pb-130 bg_cover" data-overlay="6" style="background-image: url(assets/images/page-banner-5.jpg)">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="page-banner-cont">
                        <h2>Browse Books</h2>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Book Shelf</li>
                            </ol>
                        </nav>
                    </div>  
                </div>
            </div> 
        </div> 
    </section>
    
    <section id="shop-page" class="pt-120 pb-120 gray-bg">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="shop-top-search">
                        <div class="shop-bar">
                            <ul class="nav" id="myTab" role="tablist">
                                <li class="nav-item">
                                    <a class="active" id="shop-grid-tab" data-toggle="tab" href="#shop-grid" role="tab" aria-controls="shop-grid" aria-selected="true"><i class="fa fa-th-large"></i></a>
                                </li>
                                <li class="nav-item">
                                    <a id="shop-list-tab" data-toggle="tab" href="#shop-list" role="tab" aria-controls="shop-list" aria-selected="false"><i class="fa fa-th-list"></i></a>
                                </li>
                                <li class="nav-item">Recommendations<li>
                            </ul> <!-- nav -->
                        </div><!-- shop bar -->
                        <div class="shop-select">
                           <select>
                                <option value="1">Sort by</option>
                                <option value="1">Published Time</option>
                                <option value="2">Most Popular</option>
                                <option value="3">Downloads</option>
                            </select>
                        </div> <!-- shop select -->
                    </div> <!-- shop top search -->
                </div>
            </div> <!-- row -->
            <div class="tab-content" id="myTabContent">
              <div class="tab-pane fade show active" id="shop-grid" role="tabpanel" aria-labelledby="shop-grid-tab">
              <div class="row justify-content-center">
                <?php
                $limit = 4; // Limit the number of books to display
                $counter = 0; // Counter to keep track of the number of displayed books
                foreach ($all_book as $book) {
                    // Check if the counter exceeds the limit
                    if ($counter >= $limit) {
                        break; // Exit the loop if the limit is reached
                    }

                    $imagePath = "uploads/" . $book['image']; // Assuming the image path is stored in the 'image' column
                    $title = $book['title'];
                    $author = $book['author'];
                    $price = $book['price'];
                    $bookId = $book['id'];
                ?>
                <div class="col-lg-3 col-md-6 col-sm-8">
                    <div class="singel-publication mt-30">
                        <div class="image">
                            <img src="<?php echo $imagePath; ?>" alt="Publication">
                            <div class="add-cart">
                                <ul>
                                    <li><a href="?action=add_to_cart&book_id=<?php echo $bookId; ?>"><i class="fa fa-shopping-cart"></i></a></li>
                                    <li><a href="?action=add_to_my_books&book_id=<?php echo $bookId; ?>"><i class="fa fa-heart-o"></i></a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="cont">
                            <div class="name">
                                <a href="shop-singel.html"><h6><?php echo $title; ?></h6></a>
                                <span><?php echo $author; ?></span>
                            </div>
                            <div class="button text-right">
                                <a href="#" class="main-btn">Buy Now ($<?php echo $price; ?>)</a>
                            </div>
                        </div>
                    </div>  
                </div>
                <?php
                    $counter++; // Increment the counter after displaying a book
                }
                ?>
            </div>
          </div>
             
            </div> <!-- tab content -->
      
            <div class="row">
                <div class="col-lg-12">
                    <div class="shop-top-search">
                        <div class="shop-bar">
                            <ul class="nav" id="myTab" role="tablist">
                                <li class="nav-item">
                                    <a class="active" id="shop-grid-tab" data-toggle="tab" href="#shop-grid" role="tab" aria-controls="shop-grid" aria-selected="true"><i class="fa fa-th-large"></i></a>
                                </li>
                                <li class="nav-item">
                                    <a id="shop-list-tab" data-toggle="tab" href="#shop-list" role="tab" aria-controls="shop-list" aria-selected="false"><i class="fa fa-th-list"></i></a>
                                </li>
                                <li class="nav-item">Recommendations<li>
                            </ul> <!-- nav -->
                        </div><!-- shop bar -->
                        <div class="shop-select">
                           <select>
                                <option value="1">Sort by</option>
                                <option value="1">Published Time</option>
                                <option value="2">Most Popular</option>
                                <option value="3">Downloads</option>
                            </select>
                        </div> <!-- shop select -->
                    </div> <!-- shop top search -->
                </div>
            </div> <!-- row -->
            <div class="tab-content" id="myTabContent">
              <div class="tab-pane fade show active" id="shop-grid" role="tabpanel" aria-labelledby="shop-grid-tab">
                    <div class="row justify-content-center">
                        <div class="col-lg-3 col-md-6 col-sm-8">
                            <div class="singel-publication mt-30">
                                <div class="image">
                                    <img src="assets/images/publication/p-1.jpg" alt="Publication">
                                    <div class="add-cart">
                                        <ul>
                                            <li><a href="#"><i class="fa fa-shopping-cart"></i></a></li>
                                            <li><a href="#"><i class="fa fa-heart-o"></i></a></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="cont">
                                    <div class="name">
                                        <a href="shop-singel.html"><h6>Magazine</h6></a>
                                        <span>$50.00</span>
                                    </div>
                                    <div class="button text-right">
                                        <a href="#" class="main-btn">Buy Now</a>
                                    </div>
                                </div>
                            </div> <!-- singel publication -->
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-8">
                            <div class="singel-publication mt-30">
                                <div class="image">
                                    <img src="assets/images/publication/p-2.jpg" alt="Publication">
                                    <div class="add-cart">
                                        <ul>
                                            <li><a href="#"><i class="fa fa-shopping-cart"></i></a></li>
                                            <li><a href="#"><i class="fa fa-heart-o"></i></a></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="cont">
                                    <div class="name">
                                        <a href="shop-singel.html"><h6>Notebook </h6></a>
                                        <span>$50.00</span>
                                    </div>
                                    <div class="button text-right">
                                        <a href="#" class="main-btn">Buy Now</a>
                                    </div>
                                </div>
                            </div> <!-- singel publication -->
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-8">
                            <div class="singel-publication mt-30">
                                <div class="image">
                                    <img src="assets/images/publication/p-3.jpg" alt="Publication">
                                    <div class="add-cart">
                                        <ul>
                                            <li><a href="#"><i class="fa fa-shopping-cart"></i></a></li>
                                            <li><a href="#"><i class="fa fa-heart-o"></i></a></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="cont">
                                    <div class="name">
                                        <a href="shop-singel.html"><h6>Staionary set </h6></a>
                                        <span>$50.00</span>
                                    </div>
                                    <div class="button text-right">
                                        <a href="#" class="main-btn">Buy Now</a>
                                    </div>
                                </div>
                            </div> <!-- singel publication -->
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-8">
                            <div class="singel-publication mt-30">
                                <div class="image">
                                    <img src="assets/images/publication/p-4.jpg" alt="Publication">
                                    <div class="add-cart">
                                        <ul>
                                            <li><a href="#"><i class="fa fa-shopping-cart"></i></a></li>
                                            <li><a href="#"><i class="fa fa-heart-o"></i></a></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="cont">
                                    <div class="name">
                                        <a href="shop-singel.html"><h6>Set for life </h6></a>
                                        <span>$50.00</span>
                                    </div>
                                    <div class="button text-right">
                                        <a href="#" class="main-btn">Buy Now</a>
                                    </div>
                                </div>
                            </div> <!-- singel publication -->
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-8">
                            <div class="singel-publication mt-30">
                                <div class="image">
                                    <img src="assets/images/publication/p-5.jpg" alt="Publication">
                                    <div class="add-cart">
                                        <ul>
                                            <li><a href="#"><i class="fa fa-shopping-cart"></i></a></li>
                                            <li><a href="#"><i class="fa fa-heart-o"></i></a></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="cont">
                                    <div class="name">
                                        <a href="shop-singel.html"><h6>Set for life </h6></a>
                                        <span>$50.00</span>
                                    </div>
                                    <div class="button text-right">
                                        <a href="#" class="main-btn">Buy Now</a>
                                    </div>
                                </div>
                            </div> <!-- singel publication -->
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-8">
                            <div class="singel-publication mt-30">
                                <div class="image">
                                    <img src="assets/images/publication/p-6.jpg" alt="Publication">
                                    <div class="add-cart">
                                        <ul>
                                            <li><a href="#"><i class="fa fa-shopping-cart"></i></a></li>
                                            <li><a href="#"><i class="fa fa-heart-o"></i></a></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="cont">
                                    <div class="name">
                                        <a href="shop-singel.html"><h6>Set for life </h6></a>
                                        <span>$50.00</span>
                                    </div>
                                    <div class="button text-right">
                                        <a href="#" class="main-btn">Buy Now</a>
                                    </div>
                                </div>
                            </div> <!-- singel publication -->
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-8">
                            <div class="singel-publication mt-30">
                                <div class="image">
                                    <img src="assets/images/publication/p-7.jpg" alt="Publication">
                                    <div class="add-cart">
                                        <ul>
                                            <li><a href="#"><i class="fa fa-shopping-cart"></i></a></li>
                                            <li><a href="#"><i class="fa fa-heart-o"></i></a></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="cont">
                                    <div class="name">
                                        <a href="shop-singel.html"><h6>Magazine </h6></a>
                                        <span>$50.00</span>
                                    </div>
                                    <div class="button text-right">
                                        <a href="#" class="main-btn">Buy Now</a>
                                    </div>
                                </div>
                            </div> <!-- singel publication -->
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-8">
                            <div class="singel-publication mt-30">
                                <div class="image">
                                    <img src="assets/images/publication/p-8.jpg" alt="Publication">
                                    <div class="add-cart">
                                        <ul>
                                            <li><a href="#"><i class="fa fa-shopping-cart"></i></a></li>
                                            <li><a href="#"><i class="fa fa-heart-o"></i></a></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="cont">
                                    <div class="name">
                                        <a href="shop-singel.html"><h6>Set for life </h6></a>
                                        <span>$50.00</span>
                                    </div>
                                    <div class="button text-right">
                                        <a href="#" class="main-btn">Buy Now</a>
                                    </div>
                                </div>
                            </div> <!-- singel publication -->
                        </div>
                    </div> <!-- row -->
                </div>
                <div class="tab-pane fade" id="shop-list" role="tabpanel" aria-labelledby="shop-list-tab">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="singel-publication mt-30">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="image">
                                            <img src="assets/images/publication/p-1.jpg" alt="Publication">
                                            <div class="add-cart">
                                                <ul>
                                                    <li><a href="#"><i class="fa fa-shopping-cart"></i></a></li>
                                                    <li><a href="#"><i class="fa fa-heart-o"></i></a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="cont">
                                            <div class="name">
                                                <a href="shop-singel.html"><h6>Set for life </h6></a>
                                                <span>$50.00</span>
                                            </div>
                                            <div class="description pt-10">
                                                <p>Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley.</p>
                                            </div>
                                            <div class="button">
                                                <a href="#" class="main-btn">Buy Now</a>
                                            </div>
                                        </div>
                                    </div>
                                </div> <!-- row -->
                            </div> <!-- singel publication -->
                        </div>
                        <div class="col-lg-6">
                            <div class="singel-publication mt-30">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="image">
                                            <img src="assets/images/publication/p-2.jpg" alt="Publication">
                                            <div class="add-cart">
                                                <ul>
                                                    <li><a href="#"><i class="fa fa-shopping-cart"></i></a></li>
                                                    <li><a href="#"><i class="fa fa-heart-o"></i></a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="cont">
                                            <div class="name">
                                                <a href="shop-singel.html"><h6>Set for life </h6></a>
                                                <span>$50.00</span>
                                            </div>
                                            <div class="description pt-10">
                                                <p>Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley.</p>
                                            </div>
                                            <div class="button">
                                                <a href="#" class="main-btn">Buy Now</a>
                                            </div>
                                        </div>
                                    </div>
                                </div> <!-- row -->
                            </div> <!-- singel publication -->
                        </div>
                        <div class="col-lg-6">
                            <div class="singel-publication mt-30">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="image">
                                            <img src="assets/images/publication/p-3.jpg" alt="Publication">
                                            <div class="add-cart">
                                                <ul>
                                                    <li><a href="#"><i class="fa fa-shopping-cart"></i></a></li>
                                                    <li><a href="#"><i class="fa fa-heart-o"></i></a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="cont">
                                            <div class="name">
                                                <a href="shop-singel.html"><h6>Set for life </h6></a>
                                                <span>$50.00</span>
                                            </div>
                                            <div class="description pt-10">
                                                <p>Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley.</p>
                                            </div>
                                            <div class="button">
                                                <a href="#" class="main-btn">Buy Now</a>
                                            </div>
                                        </div>
                                    </div>
                                </div> <!-- row -->
                            </div> <!-- singel publication -->
                        </div>
                        <div class="col-lg-6">
                            <div class="singel-publication mt-30">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="image">
                                            <img src="assets/images/publication/p-4.jpg" alt="Publication">
                                            <div class="add-cart">
                                                <ul>
                                                    <li><a href="#"><i class="fa fa-shopping-cart"></i></a></li>
                                                    <li><a href="#"><i class="fa fa-heart-o"></i></a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="cont">
                                            <div class="name">
                                                <a href="shop-singel.html"><h6>Set for life </h6></a>
                                                <span>$50.00</span>
                                            </div>
                                            <div class="description pt-10">
                                                <p>Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley.</p>
                                            </div>
                                            <div class="button">
                                                <a href="#" class="main-btn">Buy Now</a>
                                            </div>
                                        </div>
                                    </div>
                                </div> <!-- row -->
                            </div> <!-- singel publication -->
                        </div>
                    </div> <!-- row -->
                </div>
            </div> <!-- tab content -->
         
        </div> <!-- container -->
    </section>
 
    
    <footer id="footer-part">
        <div class="footer-top pt-40 pb-70">
            <div class="container">
                <div class="row">
                    <div class="col-lg-3 col-md-6">
                        <div class="footer-about mt-40">
                            <div class="logo">
                                <a href="#"><img src="assets/images/logo-2.png" alt="Logo"></a>
                            </div>
                            <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ማንበብ ሙሉ ሰው ያደርጋል!</p>
                            <ul class="mt-20">
                                <li><a href="#"><i class="fa fa-facebook-f"></i></a></li>
                                <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                                <li><a href="#"><i class="fa fa-google-plus"></i></a></li>
                                <li><a href="#"><i class="fa fa-instagram"></i></a></li>
                            </ul>
                        </div> <!-- footer about -->
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
                        </div> <!-- footer link -->
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
                        </div> <!-- support -->
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
        
 
        <footer id="footer-part">
        <div class="footer-top pt-40 pb-70">
            <div class="container">
                <div class="row">
                    <div class="col-lg-3 col-md-6">
                        <div class="footer-about mt-40">
                            <div class="logo">
                                <a href="#"><img src="assets/images/logo-2.png" alt="Logo"></a>
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
    <script>
</body>

</html>
