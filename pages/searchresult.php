<?php
session_start();
require '../classes/Connection.php';

$conobject = new Connection();
$connection = $conobject->getConnection();
?>

<main>
    <section class="search-results">
        <?php
        if (isset($_GET['searchQuery']) && !empty($_GET['searchQuery'])) {
            $searchQuery = $_GET['searchQuery'];
            $searchTerm = "%" . $searchQuery . "%";

            $stmt = $connection->prepare("SELECT * FROM users WHERE Username LIKE ? LIMIT 10");
            $stmt->bind_param("s", $searchTerm);
            
            $stmt->execute();
            $result = $stmt->get_result();
            
            if ($result->num_rows > 0) {
                echo "<h3>Search Results for '" . htmlspecialchars($searchQuery) . "':</h3>";
                echo "<ul>"; // Use a list to display the results more clearly
                while ($row = $result->fetch_assoc()) {
                    echo "<li><strong>" . htmlspecialchars($row['Username']) . "</strong> | <a href='profile.php?id=" . $row['UserID'] . "'>View Profile</a></li>";
                }
                echo "</ul>";
            } else {
                echo "<p>No users found matching your search for '" . htmlspecialchars($searchQuery) . "'.</p>";
            }
            
            $stmt->close();
        } else {
            echo "<p>Please enter a search term.</p>";
        }

        $connection->close();
        ?>
    </section>
</main>
