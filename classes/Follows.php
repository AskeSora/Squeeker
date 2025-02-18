<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

/**
 * Description of Follows
 *
 * @author 65585
 */
class Follows {
    public $connection;
    public $Following_user_id;
    public $Followed_user_id;
    
    public function __construct($connection) {
        $this->connection = $connection;
        //echo "database connection assigned.<br>";
    }

    public function getFollows($userID) {
        $sql = "SELECT Followed_user_id FROM follows WHERE Following_user_id = ?";
        $stmt = $this->connection->prepare($sql);
        $stmt->bind_param("i", $userID);
        $stmt->execute();
        $result = $stmt->get_result();
        $followedUsers = [];

        while ($row = $result->fetch_assoc()) {
            $followedUsers[] = $row['Followed_user_id'];
        }

        $stmt->close();
        return $followedUsers;
    }
}

