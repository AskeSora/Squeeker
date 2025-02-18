<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: index.php?page=login');
    exit;
}

require '../classes/Users.php';
require '../classes/Connection.php';

$conobject = new Connection();
$connection = $conobject->getConnection();

$usersobject = new Users($connection);
$UserID = $_SESSION['user_id'];

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the input values from the form
    $newName = $_POST['name'];
    $newUsername = $_POST['username'];
    $newBio = $_POST['bio'];

    // Handle file upload for profile picture
    if (isset($_FILES['profilepic']) && $_FILES['profilepic']['error'] == 0) {
        $fileTmpPath = $_FILES['profilepic']['tmp_name'];
        $fileName = $_FILES['profilepic']['name'];
        $fileSize = $_FILES['profilepic']['size'];
        $fileType = $_FILES['profilepic']['type'];

        // Define the directory where you want to upload the file
        $uploadDir = 'assets/profile_pics/';
        $destPath = $uploadDir . basename($fileName);

        // Move the uploaded file to the desired location
        if (move_uploaded_file($fileTmpPath, $destPath)) {
            $profilepic = $destPath;  // Update the profile picture path
        } else {
            // If file upload fails, keep the old profile picture
            $profilepic = '';  // No new picture uploaded, keep the old one
        }
    }

    // Update the user's profile in the database
    $usersobject->updateUserProfile($UserID, $newName, $newUsername, $newBio, $profilepic);

    // Redirect back to the profile page after updating
    header('Location: ../index.php?page=myprofile');
    exit;
} else {
    // Redirect if the page is accessed without submitting the form
    header('Location: editprofile.php');
    exit;
}
