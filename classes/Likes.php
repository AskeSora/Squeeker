<?php


class Likes {
    public $connection;
    
    public function __construct($connection) {
        $this->connection = $connection;
        //echo "database connection assigned.<br>";
    }
    public function hasLikedPost($userID, $postID) {
        $sql = "SELECT * FROM likes WHERE UserID = ? AND PostID = ? AND CommentID IS NULL";
        $stmt = $this->connection->prepare($sql);
        $stmt->bind_param("ii", $userID, $postID);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->num_rows > 0;
    }
    public function hasLikedComment($userID, $commentID) {
        $sql = "SELECT * FROM likes WHERE UserID = ? AND CommentID = ? AND PostID IS NULL";
        $stmt = $this->connection->prepare($sql);
        $stmt->bind_param("ii", $userID, $commentID);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->num_rows > 0;
    }
    public function getPostLikesCount($postID) {
        $sql = "SELECT COUNT(*) AS likeCount FROM likes WHERE PostID = ? AND CommentID IS NULL";
        $stmt = $this->connection->prepare($sql);
        $stmt->bind_param("i", $postID);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        return $row['likeCount'];
    }
    public function getCommentLikesCount($commentID) {
        $sql = "SELECT COUNT(*) AS likeCount FROM likes WHERE CommentID = ? AND PostID IS Null";
        $stmt = $this->connection->prepare($sql);
        $stmt->bind_param("i", $commentID);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        return $row['likeCount'];
    }
}
