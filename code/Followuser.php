<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: ../index.php?page=login');
    exit;
}

// Make sure the user is logged in and the follow action is valid
if (isset($_POST['follow']) && isset($_POST['Followed_user_id'])) {
    $followingUserID = $_SESSION['user_id']; // The current logged-in user
    $followedUserID = $_POST['Followed_user_id']; // The user to be followed

    // Make sure the following user is not trying to follow themselves
    if ($followingUserID !== $followedUserID) {
        require '../classes/Connection.php';
        $conobject = new Connection();
        $connection = $conobject->getConnection();

        // Check if the follow relationship already exists to avoid duplicates
        $stmt = $connection->prepare("SELECT * FROM follows WHERE Following_user_id = ? AND Followed_user_id = ?");
        $stmt->bind_param("ii", $followingUserID, $followedUserID);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 0) {
            // Insert into follows table
            $stmt = $connection->prepare("INSERT INTO follows (Following_user_id, Followed_user_id, Followed_at) VALUES (?, ?, NOW())");
            $stmt->bind_param("ii", $followingUserID, $followedUserID);
            $stmt->execute();
            $stmt->close();

            // Redirect back to the user profile page
            header("Location: ../index.php?page=userprofile&id=" . $followedUserID);
            exit;
        } else {
            // If the user is already following, redirect back with a message
            header("Location: ../index.php?page=userprofile&id=" . $followedUserID . "&message=Already following this user.");
            exit;
        }
    } else {
        // Redirect back if a user tries to follow themselves
        header("Location: ../index.php?page=userprofile&id=" . $followedUserID . "&message=You cannot follow yourself.");
        exit;
    }
} else {
    // If not all required fields are set, redirect back
    header("Location: ../index.php");
    exit;
}
?>
