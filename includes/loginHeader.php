<?php
require 'settings.php';
require 'classes/Connection.php';
$conobject = new Connection();
$connection = $conobject->getConnection();

if ($connection === null) {
    die("Database connection is null.");
} //else {
    //echo "Connection obtained successfully.<br>";
//}

?>
<html lang="en">
    <head>
        <title>Squeeker🐭</title>
        <style>
            <?php include 'includes/SqueekerMain.css'; ?>
        </style>
    </head>
    <body>
        <header>
            
            <img src="assets/SqueekerLogo.png" alt="SqueekerLogo"><span>Squeeker</span>
            
        </header>