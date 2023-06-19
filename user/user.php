<?php
class User {
    private $connection;

    public function __construct(mysqli $connection) {
        $this->connection = $connection;
    }

    public function signUp($name, $email, $password, $profilePic) {
        $statement = $this->connection->prepare("INSERT INTO user (name, email, password, profile_pic) VALUES (?, ?, ?, ?)");
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $statement->bind_param("ssss", $name, $email, $hashedPassword, $profilePic);

        $result = $statement->execute();
        
        return $result;
    }

    public function login($email, $password) {
        $statement = $this->connection->prepare("SELECT * FROM user WHERE email = ?");
        $statement->bind_param("s", $email);
        $statement->execute();
    
        $result = $statement->get_result();
        $user = $result->fetch_assoc();
    
        if (!$user || !password_verify($password, $user['password'])) {
            return false;
        }
       
        session_start();
        $_SESSION['user'] = array(
            'email' => $user['email'],
        ); 
        session_write_close();
        
        return true;
    }
    
    
    public function getUser($userId) {
        $statement = $this->connection->prepare("SELECT * FROM user WHERE id = ?");
        $statement->bind_param("i", $userId);
        $statement->execute();

        $result = $statement->get_result();
        $user = $result->fetch_assoc();

        return $user;
    }

    public function updateUser($userId, $name, $email, $profilePic) {
        $statement = $this->connection->prepare("UPDATE user SET name = ?, email = ?, profile_pic = ? WHERE id = ?");
        $statement->bind_param("sssi", $name, $email, $profilePic, $userId);
        $statement->execute();

        return $statement->affected_rows > 0;
    }

    public function deleteUser($userId) {
        $statement = $this->connection->prepare("DELETE FROM user WHERE id = ?");
        $statement->bind_param("i", $userId);
        $statement->execute();

        return $statement->affected_rows > 0;
    }

    public function getUserIdByEmail($email) {
        $statement = $this->connection->prepare("SELECT id FROM user WHERE email = ?");
        $statement->bind_param("s", $email);
        $statement->execute();

        $result = $statement->get_result();
        $row = $result->fetch_assoc();

        return $row ? $row['id'] : null;
    }
    
    public function addToCart($userId, $bookId) {
        // Insert the book into the cart table
        $query = "INSERT INTO cart (user_id, book_id) VALUES ($userId, $bookId)";
        $this->connection->query($query);
    }

    public function displayCarts($userId) {
        // Retrieve the books in the user's cart
        $query = "SELECT * FROM cart WHERE user_id = $userId";
        $result = $this->connection->query($query);
        $carts = array();

        while ($row = $result->fetch_assoc()) {
            $carts[] = $row;
        }

        return $carts;
    }

    public function addToMyBooks($userId, $bookId) {
        // Insert the book into the mybooks table
        $query = "INSERT INTO mybooks (user_id, book_id) VALUES ($userId, $bookId)";
        $this->connection->query($query);
    }

    public function getMyBooks($userId) {
        // Retrieve the user's books from the mybooks table
        $query = "SELECT * FROM mybooks WHERE user_id = $userId";
        $result = $this->connection->query($query);
        $myBooks = array();

        while ($row = $result->fetch_assoc()) {
            $myBooks[] = $row;
        }

        return $myBooks;
    }
    public function getTotalBooksInCart($userId) {
        // Retrieve the count of books in the user's cart
        $query = "SELECT COUNT(*) AS total FROM cart WHERE user_id = $userId";
        $result = $this->connection->query($query);
        $row = $result->fetch_assoc();
        $totalBooksInCart = $row['total'];

        return $totalBooksInCart;
    }
}
?>
