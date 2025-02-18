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
            
            <a href="index.php?page=home"><img src="assets/SqueekerLogo.png" alt="SqueekerLogo"></a><span class="squeekerlogo">Squeeker</span>
            <!-- Search Form -->
            <!--<form action="index.php?page=searchresult" method="GET" class="searchform">
                <label for="searchQuery">Search users: </label>
                <input type="text" id="searchQuery" name="searchQuery" placeholder="Search by username..." required>
                <button type="submit" class="searchbtn">Search</button>
            </form>-->

        </header>