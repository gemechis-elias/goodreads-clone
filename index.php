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
// Create an instance of the Post class with the database connection
$post = new Post($connection);

// Fetch the posts
$posts = $post->getAllPosts();


?>

<!doctype html>
<html lang="en">

<head>
   
    <!--====== Required meta tags ======-->
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    
    <title>Yenibab Maed</title>
    
    <link rel="shortcut icon" href="assets/images/favicon.png" type="image/png">
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
    #autocompleteContainer {
        position: absolute;
        z-index: 1;
        background-color: white;
        max-height: 154px;
        overflow-y: auto;
        width: 100%; /* Adjust the width as needed */
        border: 1px solid #ccc;
        margin-top: -3px; /* Add some margin for spacing */
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2); 
    /* Add a slight shadow effect */
    }

    .ui-autocomplete-category {
        font-weight: bold;
        padding: 5px 10px;
        background-color: #f5f5f5; /* Light gray background color */
        border-bottom: 1px solid #ccc; /* Bottom border */
    }

    .ui-autocomplete-item {
        padding: 5px 10px;
        cursor: pointer;
        color: #3B0000;
    }

    .ui-autocomplete-item:last-child {
        border-bottom: none; /* Remove bottom border for the last item */
    }

    .description-container {
        height: 3.6em; /* Set the height to accommodate 2 lines of text */
        overflow: hidden;
        text-overflow: ellipsis;
        display: -webkit-box;
        -webkit-line-clamp: 2; /* Limit the description to 2 lines */
        -webkit-box-orient: vertical;
    }
            </style>
</head>

<body>
    <header id="header-part">        
        <div class="navigation navigation-2 navigation-3">
            <div class="container">
                <div class="row no-gutters">
                    <div class="col-lg-11 col-md-10 col-sm-9 col-9">
                        <nav class="navbar navbar-expand-lg">
                            <a class="navbar-brand" href="index-4.html">
                         <img style="width:180px;" src="assets/images/logo.png" alt="Logo">

                            </a>
                            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                            </button>

                            <div class="collapse navbar-collapse sub-menu-bar" id="navbarSupportedContent">
                                <ul class="navbar-nav ml-auto">
                                    <li class="nav-item">
                                        <a class="active" href="index.php">Home</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="my_book.php">My Books</a>
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
    
    <section id="slider-part-3" class="bg_cover"  style="background-image: url(assets/images/slider/s-3.jpg)">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="slider-cont-3 text-center">
                        <h2>What are you reading?</h2>
                        <span>ከ 10,000 በላይ መፅሀፍት ለእርስዎ</span>
                        <div class="slider-search mt-45">
                        <form action="#" id="searchForm">
                            <div class="row no-gutters">
                                <div class="col-sm-3">
                                    <select id="categorySelect">
                                        <option value="0">Category</option>
                                        <option value="1">Biography</option>
                                        <option value="2">Religious</option>
                                        <option value="3">Academic</option>
                                    </select>
                                </div>
                                <div class="col-sm-6 autocomplete-wrapper">
                                    <input type="text" placeholder="Search keyword" id="keywordInput">
                                    <div id="autocompleteContainer"></div> 
                                </div>
                                <div class="col-sm-3">
                                    <button type="button" class="main-btn">Search Now</button>
                                </div>
                            </div> 
                        </form>
                    </div>
                    </div> 
                </div>
            </div> 
          </div> 
    </section>
    
    
    <section id="publication-part" class="pt-115 pb-120 gray-bg">
        <div class="container">
            <div class="row align-items-end">
                <div class="col-lg-6 col-md-8 col-sm-7">
                    <div class="section-title pb-60">
                        <h5>For you</h5>
                        <h2>የተመረጡ መፅሀፍት </h2>
                    </div>  
                </div>
                <div class="col-lg-6 col-md-4 col-sm-5">
                    <div class="products-btn text-right pb-60">
                        <a href="#" class="main-btn">Browse</a>
                    </div>  
                </div>
            </div>  
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
                                <a href="book-detail.php?book_id=<?php echo $book['id']?>" class="main-btn">Buy Now ($<?php echo $price; ?>)</a>
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
    </section>
    
   
 
    
    <section id="news-part" class="pt-115 pb-110">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="section-title pb-50">
                        <h5>Latest News</h5>
                        <h2>NEWS & INTERVIEWS</h2>
                    </div> <!-- section title -->
                </div>
            </div> <!-- row -->

            <div class="row">
                <div class="col-lg-6">
                    <div class="singel-news mt-30">
                        <div class="news-thum pb-25">
                            <img src="uploads/posts/n-1.jpg" alt="News">
                        </div>
                        <div class="news-cont">
                            <ul>
                                <li><a href="#"><i class="fa fa-calendar"></i>Jun 2023 </a></li>
                                <li><a href="#"> <span>By</span> Mekdes Alemu</a></li>
                            </ul>
                            <a href="blog-singel.html"><h3>ህፃናት ልያነቡት የሚገባ መፅሀፍት ዝርዝር</h3></a>
                            <p>ህፃናት የሚያነቡትን መርጠን ልንሰጣቸው ይገባል! በሚያነቡት ተረት ተረት፣ ግጥም እና ታሪክ መፅሀፎች ውስጥ ልጆቻችን ምን እየተማሩ ነው? ቆም ብለን እንጠይቅ...</p>
                        </div>
                    </div>  
                </div>


                <div class="col-lg-6">
                <?php
                    // Loop through the posts and display them
                    foreach ($posts as $post) {
                        $postId = $post['id'];
                        $title = $post['title'];
                        $description = $post['description'];
                        $author = $post['author'];
                        $image = $post['image'];
                        $date = $post['date'];

                        // Display the first post normally
                        echo '<div class="singel-news news-list">';
                        echo '<div class="row">';
                        echo '<div class="col-sm-4">';
                        echo '<div class="news-thum mt-30">';
                        echo '<img src="uploads/posts/' . $image . '" alt="News">';
                        echo '</div>';
                        echo '</div>';
                        echo '<div class="col-sm-8">';
                        echo '<div class="news-cont mt-30">';
                        echo '<ul>';
                        echo '<li><a href="#"><i class="fa fa-calendar"></i>' . date("M Y", strtotime($date)) . '</a></li>';
                        echo '<li><a href="#"> <span>By </span>' . $author . '</a></li>';
                        echo '</ul>';
                        echo '<a href="blog.php?blog_id=' . $postId . '"><h3>' . $title . '</h3></a>';
                        echo '<div class="description-container">';
                        echo '<p class="description">' . $description . '</p>';
                        echo '</div>';
                        echo '</div>';
                        echo '</div>';
                        echo '</div>';
                        echo '</div>';
                    }
                    ?>
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
$(document).ready(function() {
    // Get the category and keyword elements
    var categorySelect = document.getElementById("categorySelect");
    var keywordInput = document.getElementById("keywordInput");
    var autocompleteContainer = document.getElementById("autocompleteContainer");

    // Attach the event listener to the keyword input
    $(keywordInput).on('keyup', function() {
        var category = categorySelect.value;
        var keyword = this.value;

        // Call the searchBooks function with a delay
        setTimeout(function() {
            searchBooks(category, keyword);
        }, 300);
    });

    // Autocomplete widget
    $(keywordInput).autocomplete({
        source: function(request, response) {
            var category = categorySelect.value;
            var keyword = request.term;

            $.ajax({
                url: "search-books.php",
                dataType: "json",
                data: { category: category, keyword: keyword },
                success: function(data) {
                    response(data);
                }
            });
        },
        minLength: 1,
        select: function(event, ui) {
            // Redirect to view-book.php with the selected book ID
            var bookId = ui.item.value;
            window.location.href = "book-detail.php?id=" + bookId;
        }
    });
});

function searchBooks(category, keyword) {
    if (keyword.length == 0) {
        document.getElementById("autocompleteContainer").innerHTML = "";
        return;
    }

    var xmlhttp = new XMLHttpRequest();

    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("autocompleteContainer").innerHTML = this.responseText;
        }
    };

    xmlhttp.open("GET", "search-books.php?category=" + category + "&keyword=" + keyword, true);
    xmlhttp.send();
}

</script>


</body>

</html>
