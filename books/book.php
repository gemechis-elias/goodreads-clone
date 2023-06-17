<?php

class Book {
    private $connection;

    public function __construct(mysqli $connection) {
        $this->connection = $connection;
    }

    public function addBook($title, $description, $image, $date, $author, $category, $rating, $price) {
        // Prepare the query
        $query = "INSERT INTO books (title, description, image, date, author, category, rating, price) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $statement = $this->connection->prepare($query);

        // Bind the parameters
        $statement->bind_param("ssssssii", $title, $description, $image, $date, $author, $category, $rating, $price);

        // Execute the query
        $statement->execute();

        if ($statement->affected_rows > 0) {
            return true; // Book added successfully
        }
        
        return false; // Book addition failed
    }

    public function getAllBooks() {
        // Prepare the query
        $query = "SELECT * FROM books";
        $result = $this->connection->query($query);

        // Fetch all books as an associative array
        $books = $result->fetch_all(MYSQLI_ASSOC);

        return $books;
    }

    public function getSingleBook($bookId) {
        // Prepare the query
        $query = "SELECT * FROM books WHERE id = ?";
        $statement = $this->connection->prepare($query);

        // Bind the parameter
        $statement->bind_param("i", $bookId);

        // Execute the query
        $statement->execute();

        // Fetch the single book as an associative array
        $book = $statement->get_result()->fetch_assoc();

        return $book;
    }

    public function getByCategory($category) {
        // Prepare the query
        $query = "SELECT * FROM books WHERE category = ?";
        $statement = $this->connection->prepare($query);

        // Bind the parameter
        $statement->bind_param("s", $category);

        // Execute the query
        $statement->execute();

        // Fetch all books with the given category as an associative array
        $books = $statement->get_result()->fetch_all(MYSQLI_ASSOC);

        return $books;
    }

    public function searchBooks($keyword) {
        // Prepare the query
        $query = "SELECT * FROM books WHERE title LIKE ? OR author LIKE ?";
        $statement = $this->connection->prepare($query);

        // Bind the parameter
        $keyword = "%" . $keyword . "%";
        $statement->bind_param("ss", $keyword, $keyword);

        // Execute the query
        $statement->execute();

        // Fetch all matching books as an associative array
        $books = $statement->get_result()->fetch_all(MYSQLI_ASSOC);

        return $books;
    }

    public function giveRating($bookId, $ratingIncrease) {
        // Prepare the query
        $query = "UPDATE books SET rating = rating + ? WHERE id = ?";
        $statement = $this->connection->prepare($query);

        // Bind the parameters
        $statement->bind_param("ii", $ratingIncrease, $bookId);

        // Execute the query
        $statement->execute();

        if ($statement->affected_rows > 0) {
            return true; // Rating updated successfully
        }
        
        return false; // Rating update failed
    }

    public function deleteBook($bookId) {
        // Prepare the query
        $query = "DELETE FROM books WHERE id = ?";
        $statement = $this->connection->prepare($query);

        // Bind the parameter
        $statement->bind_param("i", $bookId);

        // Execute the query
        $statement->execute();

        if ($statement->affected_rows > 0) {
            return true; // Book deleted successfully
        }
        
        return false; // Book deletion failed
    }
}

?>
