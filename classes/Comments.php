<?php

/**
 * Description of Comments
 *
 * @author 65585
 */
class Comments {
    public $connection;
    public $PostID;
    
    public function __construct($connection) {
        $this->connection = $connection;
        //echo "database connection assigned.<br>";
    }
    
    public function getCommentsByPost($PostID) {
        $sql = "SELECT * FROM comments WHERE PostID = ? ORDER BY Timestamp";
        $stmt = $this->connection->prepare($sql);
        $stmt->bind_param("i", $PostID);
        $stmt->execute();
    
        $result = $stmt->get_result();
        $posts = [];
    
        while ($row = $result->fetch_assoc()) {
            $posts[] = $row;
        }
    
        return $posts;
    }
    public function addComment($PostID, $UserID, $Content) {
    $sql = "INSERT INTO comments (PostID, UserID, Content, Timestamp) VALUES (?, ?, ?, NOW())";
    $stmt = $this->connection->prepare($sql);
    $stmt->bind_param("iis", $PostID, $UserID, $Content);
    $stmt->execute();
    $stmt->close();
}

}
