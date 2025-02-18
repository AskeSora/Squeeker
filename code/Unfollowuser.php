<?php
session_start();
require '../classes/Users.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: ../index.php?page=login');
    exit;
}

require '../classes/Connection.php';
        $conobject = new Connection();
        $connection = $conobject->getConnection();

$followingUserID = $_SESSION['user_id'];
$followedUserID = $_POST['Followed_user_id'];

$usersobject = new Users($connection);

if ($usersobject->isFollowing($followingUserID, $followedUserID)) {
    $sql = "DELETE FROM follows WHERE Following_user_id = ? AND Followed_user_id = ?";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("ii", $followingUserID, $followedUserID);
    $stmt->execute();
    header('Location: ../index.php?page=userprofile&id=' . $followedUserID);
    exit;
}
