<?php

class Post {
    private $connection;

    public function __construct(mysqli $connection) {
        $this->connection = $connection;
    }

    public function addPost($title, $description, $author, $image, $date) {
        $query = "INSERT INTO post (title, description, author, image, date) VALUES (?, ?, ?, ?, ?)";
        $statement = $this->connection->prepare($query);
        $statement->bind_param("sssss", $title, $description, $author, $image, $date);
        
        return $statement->execute();
    }
    public function getLatestPost() {
        $query = "SELECT * FROM post ORDER BY id DESC LIMIT 1";
        $result = $this->connection->query($query);

        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return $row;
        }

        return null;
    }

    public function getAllPosts() {
        $query = "SELECT * FROM post ORDER BY id DESC LIMIT 3";
        $result = $this->connection->query($query);

        $posts = [];
        while ($row = $result->fetch_assoc()) {
            $posts[] = $row;
        }

        return $posts;
    }

    public function getSinglePost($id) {
        $query = "SELECT * FROM post WHERE id = ?";
        $statement = $this->connection->prepare($query);
        $statement->bind_param("i", $id);
        $statement->execute();
        
        $result = $statement->get_result();
        $post = $result->fetch_assoc();

        return $post;
    }

    public function deletePost($id) {
        $query = "DELETE FROM post WHERE id = ?";
        $statement = $this->connection->prepare($query);
        $statement->bind_param("i", $id);
        
        return $statement->execute();
    }
}


?>
