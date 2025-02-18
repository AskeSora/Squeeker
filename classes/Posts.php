<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

class Posts {
    public $connection;
    public $UserID;
    public $Content;
    public $MediaType;
    public $MediaURL;
    
    public function __construct($connection) {
        $this->connection = $connection;
        //echo "database connection assigned.<br>";
    }
    public function getProfilePosts($UserID) {
    $sql = "SELECT * FROM Posts WHERE UserID = ? ORDER BY Timestamp DESC";
    $stmt = $this->connection->prepare($sql);
    $stmt->bind_param("i", $UserID);
    $stmt->execute();
    
    $result = $stmt->get_result();
    
    // Initialize an empty array to store posts
    $posts = [];
    
    // Loop through the results and add each row to the array
    while ($row = $result->fetch_assoc()) {
        $posts[] = $row;
    }
    
    // Return the array of posts
    return $posts;
    }
    
    public function getPostsFromFollowedUsersAndSelf($userId, $followedUserIds) {
    // Add the user's own ID to the list of followed user IDs
    $followedUserIds[] = $userId;

    // Convert array to a comma-separated string for use in the IN clause
    $userIdsStr = implode(',', $followedUserIds);

    $sql = "SELECT * FROM posts WHERE UserID IN ($userIdsStr) ORDER BY Timestamp DESC";
    $stmt = $this->connection->prepare($sql);
    $stmt->execute();
    $result = $stmt->get_result();
    $posts = [];

    while ($row = $result->fetch_assoc()) {
        $posts[] = $row;
    }

    $stmt->close();
    return $posts;
}
    
}
