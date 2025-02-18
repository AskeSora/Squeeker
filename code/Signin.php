<?php
session_start();
require '../classes/Connection.php';

$conobject = new Connection();
$connection = $conobject->getConnection();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_input = $_POST['username'];
    $user_password = $_POST['password'];
    
    $stmt = $connection->prepare("SELECT UserID, Username, Password FROM users WHERE Username = ?");
    $stmt->bind_param("s", $user_input);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        
        if (password_verify($user_password, $user['Password'])) {
            $_SESSION['user_id'] = $user['UserID'];
            $_SESSION['username'] = $user['Username'];
            
            header("Location: ../index.php?name=home");
            exit();
        } else {
            echo "Invalid password.";
        }
    } else {
        echo "No user found with that username.";
    }
    
    $stmt->close();
}

$connection->close();