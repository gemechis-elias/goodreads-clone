<?php

class Comment {
    private $connection;

    public function __construct(mysqli $connection) {
        $this->connection = $connection;
    }

    public function addComment($userId, $comment) {
  
        $query = "INSERT INTO comments (user_id, comment) VALUES (?, ?)";
        $statement = $this->connection->prepare($query);
        $statement->bind_param("is", $userId, $comment);
        $statement->execute();
        $statement->close();
    }

    public function displayComments() {
        $query = "SELECT c.comment_id, c.user_id, c.comment, u.name, u.profile_pic FROM comments c INNER JOIN user u ON c.user_id = u.id";
        $result = $this->connection->query($query);
        if (!$result) {
            throw new Exception("Error executing query: " . $this->connection->error);
        }
        $comments = array();
        while ($row = $result->fetch_assoc()) {
            $comments[] = $row;
        }
        return $comments;
    }

    public function likeComment($commentId) { 
        $query = "UPDATE comments SET likes = likes + 1 WHERE comment_id = ?";
        $statement = $this->connection->prepare($query);
        $statement->bind_param("i", $commentId);
        $statement->execute();
        $statement->close();
    }
}
?>