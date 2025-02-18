<?php

/**
 * Description of Users
 *
 * @author 65585
 */
class Users {
    public $connection;
    public $UserID;
    public $Username;
    public $Name;
    public $Bio;
    public $ProfilePicture;
    
    public function __construct($connection) {
        $this->connection = $connection;
        //echo "database connection assigned.<br>";
    }
    
    public function getUserByID($UserID) {
        $sql = "SELECT * FROM users WHERE UserID= ?";
        $stmt = $this->connection->prepare($sql);
        $stmt->bind_param("i", $UserID);
        $stmt->execute();
        $result = $stmt->get_result();
        
        return $result->fetch_assoc();
    }
    
    public function isFollowing($followingUserID, $followedUserID) {
        $sql = "SELECT * FROM follows WHERE Following_user_id = ? AND Followed_user_id = ?";
        $stmt = $this->connection->prepare($sql);
        $stmt->bind_param("ii", $followingUserID, $followedUserID);
        $stmt->execute();
        $result = $stmt->get_result();
        
        return $result->num_rows > 0;
    }
    
    public function updateUserProfile($userId, $newName, $newUsername, $newBio, $newProfilePic) {
    $sql = "UPDATE users SET Name = ?, Username = ?, Bio = ?, ProfilePicture = ? WHERE UserID = ?";
    $stmt = $this->connection->prepare($sql);
    $stmt->bind_param("ssssi", $newName, $newUsername, $newBio, $newProfilePic, $userId);
    $stmt->execute();
}
}
