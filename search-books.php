
<?php
require_once 'user/user.php';
require_once 'books/book.php';

require_once 'connection/connection.php';
$bookObj = new Book($connection);

$category = $_GET['category'];
$keyword = $_GET['keyword'];

// For now let just use jeyword only
$books = $bookObj->searchBooks($keyword);

if (count($books) > 0) {
    foreach ($books as $book) {
        // Output the book details as desired
        echo '<a href="view-book.php?id=' . $book['id'] . '">' . $book['title'] . '</a><br>';
    }
} else {
    echo 'No books found.';
}
?>