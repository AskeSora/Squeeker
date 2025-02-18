<?php
session_start();
require '../classes/Connection.php';
require '../classes/Likes.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: ../index.php?page=login');
    exit;
}

$userID = $_SESSION['user_id'];
$commentID = $_POST['CommentID'];

$conobject = new Connection();
$connection = $conobject->getConnection();
$likesObject = new Likes($connection);

$sql = "INSERT INTO likes (UserID, CommentID, Liked_at) VALUES (?, ?, NOW())";
$stmt = $connection->prepare($sql);
$stmt->bind_param("ii", $userID, $commentID);
$stmt->execute();

header("Location: {$_SERVER['HTTP_REFERER']}");
exit;
