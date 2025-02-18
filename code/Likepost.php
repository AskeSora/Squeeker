<?php
session_start();
require '../classes/Connection.php';
require '../classes/Likes.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: ../index.php?page=login');
    exit;
}

$userID = $_SESSION['user_id'];
$postID = $_POST['PostID'];

$conobject = new Connection();
$connection = $conobject->getConnection();
$likesObject = new Likes($connection);

$sql = "INSERT INTO likes (UserID, PostID, Liked_at) VALUES (?, ?, NOW())";
$stmt = $connection->prepare($sql);
$stmt->bind_param("ii", $userID, $postID);
$stmt->execute();

header("Location: {$_SERVER['HTTP_REFERER']}");
exit;
