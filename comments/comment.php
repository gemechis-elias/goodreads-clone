<?php

class Comment {
    private $connection;

    public function __construct(mysqli $connection) {
        $this->connection = $connection;
    }

    public function addGroupComment($userId, $comment) {
  
        $query = "INSERT INTO comments (user_id, comment) VALUES (?, ?)";
        $statement = $this->connection->prepare($query);
        $statement->bind_param("is", $userId, $comment);
        $statement->execute();
        $statement->close();
    }
    public function addPostComment( $postId, $userId, $comment) {
  
        $query = "INSERT INTO comments (comment_id, user_id, comment) VALUES (?, ?, ?)";
        $statement = $this->connection->prepare($query);
        $statement->bind_param("iis",$postId, $userId,  $comment);
        $statement->execute();
        $statement->close();
    }
    public function displayGroupComments() {
        $query = "SELECT c.comment_id, c.user_id, c.comment, u.name, u.profile_pic FROM comments c INNER JOIN user u ON c.user_id = u.id WHERE c.comment_id = 0";
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

    public function displayPostComments($postId) {
        $query = "SELECT c.comment_id, c.user_id, c.comment, u.name, u.profile_pic FROM comments c INNER JOIN user u ON c.user_id = u.id WHERE c.comment_id = '$postId'";
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