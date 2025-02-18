<?php
$pagename = $_GET['page'] ?? $_POST['page'] ?? 'home';
$page = "pages/$pagename.php";

// Debugging line
//var_dump($pagename); // Check if the page name is being set correctly.
//var_dump($page); // Check the full path to the page.