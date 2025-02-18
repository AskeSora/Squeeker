<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: index.php?page=login');
    exit;
}

require 'classes/Users.php';

$usersobject = new Users($connection);
$UserID = $_SESSION['user_id'];

// Fetch the current user's information
$user = $usersobject->getUserByID($UserID);
if ($user) {
    $username = $user['Username'];
    $name = $user['Name'];
    $bio = $user['Bio'];
    $profilepic = $user['ProfilePicture'];
} else {
    die("User not found.");
}
?>

<main>
    <h1>Edit Profile</h1>
    <form action="code/Updateprofile.php" method="POST" enctype="multipart/form-data">
        <label for="name">Name:</label><br>
        <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($name); ?>" required><br><br>

        <label for="username">Username:</label><br>
        <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($username); ?>" required><br><br>

        <label for="bio">Bio:</label><br>
        <textarea id="bio" name="bio" rows="4" cols="50"><?php echo htmlspecialchars($bio); ?></textarea><br><br>

        <label for="profilepic">Profile Picture:</label><br>
        <?php if ($profilepic): ?>
            <img src="<?php echo $profilepic; ?>" alt="Profile Picture" width="100"><br>
        <?php endif; ?>
        <input type="file" id="profilepic" name="profilepic"><br><br>

        <button type="submit">Save Changes</button>
    </form>
</main>
