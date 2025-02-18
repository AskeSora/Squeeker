<?php
session_start();
require '../classes/Connection.php';

$conobject= new Connection();
$connection = $conobject->getConnection();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the user is logged in
    if (!isset($_SESSION['user_id'])) {
        echo "You need to be logged in to create a post.";
        exit;
    }
    var_dump($_SESSION['user_id']);

    $userid = $_SESSION['user_id'];
    $postcontent = $_POST['Newpost'];


    $stmt = $connection->prepare("INSERT INTO posts (UserID, Content) VALUES (?, ?)");
    $stmt->bind_param("ss", $userid, $postcontent);

    if ($stmt->execute()) {
        echo "Post successfully created!";
        //go to where we were before!
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
    
    if (isset($_POST['previous_page']) && !empty($_POST['previous_page'])) {
        $previousPage = $_POST['previous_page'];
        header("Location: $previousPage");
        exit;
    } else {
        // If no previous page is found, redirect to default page
        header("Location: index.php");
        exit;
    }
}

$connection->close();