<?php
include 'includes/SqueekerHeader.php';

// Handle the page navigation
$page = isset($_GET['page']) ? $_GET['page'] : 'home'; // Default page if no 'page' is set

if ($page == "searchresult") {
    // Make sure to use the value from the search query
    $searchQuery = isset($_GET['searchQuery']) ? $_GET['searchQuery'] : '';
    // Use the searchQuery to fetch results or display the search results page
    include 'pages/searchresult.php';
} elseif (file_exists("pages/$page.php")) {
    include_once "pages/$page.php";
} else {
    include_once 'pages/404.php';
}

include 'includes/SqueekerFooter.php';
