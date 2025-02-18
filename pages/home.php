<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: index.php?page=login');
    exit;
}
require 'classes/Follows.php';
require 'classes/Posts.php';
require 'classes/Users.php';
require 'classes/Comments.php';
require 'classes/Likes.php';

$UserID = $_SESSION['user_id'];

$followsObject = new Follows($connection);
$postsObject = new Posts($connection);
$usersobject = new Users($connection);
$commentsobject = new Comments($connection);
$likesobject = new Likes($connection);

$followedUserIds = $followsObject->getFollows($UserID);

if (count($followedUserIds) > 0) {
    $posts = $postsObject->getPostsFromFollowedUsersAndSelf($UserID, $followedUserIds);
} else {
    $posts = [];
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['commentContent'], $_POST['postID'])) {
    // Handle comment submission
    $commentContent = $_POST['commentContent'];
    $postID = $_POST['postID'];

    if (!empty($commentContent)) {
        // Call the addComment function from the Comments class
        $commentsobject->addComment($postID, $UserID, $commentContent);
        header("Location: {$_SERVER['REQUEST_URI']}"); // Refresh the page to show the new comment
        exit;
    }
}
?>
<main>
    <div class="content">
        <div class="gridcontainer3">
            <div class="griditem">   
            </div>
            <div class="griditem">
                <h2 class="loggedin">Logged in as <a href="index.php?page=myprofile" class="profilelink"><?php $user = $usersobject->getUserByID($UserID); echo $user['Username']; ?></a></h2>
                <br>
                <section class="makepost">
                    <form action="code/Createpost.php" method="POST" class="postform">
                        <input type="hidden" name="previous_page" value="<?php echo $_SERVER['REQUEST_URI']; ?>">
                        <label for="Newpost">New Post:</label><br>
                        <textarea id="Newpost" name="Newpost" rows="4" cols="140"></textarea><br>
                        <button type="submit" class="postbtn">Post!</button>
                    </form>
                </section>

                <section>
                    <?php if (count($posts) > 0): ?>
                        <?php foreach ($posts as $post): ?>
                            <div class="post">
                                <?php $poster = $usersobject->getUserByID($post['UserID']); // Get the commenter's username ?>
                                <a href="index.php?page=userprofile&id=<?php echo $poster['UserID']; ?>" class="userlink"><h4><strong><?php echo $poster['Name']; ?></strong></h4></a>
                                <p><small><?php echo $post['Timestamp']; ?></small></p>
                                <div class="postcontent">
                                    <p><strong><?php echo $post['Content']; ?></strong></p>
                                </div>

                                <?php
                                $PostID = $post['PostID'];
                                $commentslist = $commentsobject->getCommentsByPost($PostID);
                                ?>
                                <?php $likes = $likesobject->getPostLikesCount($post['PostID']);
                                if ($likes > 0):
                                    ?>
                                    <p><?php echo $likes; ?> 👍</p>
                                <?php endif; ?>

                                <!-- Like Button for Post -->
                                <?php if ($likesobject->hasLikedPost($UserID, $PostID)): ?>
                                    <form action="code/Unlikepost.php" method="POST">
                                        <input type="hidden" name="PostID" value="<?php echo $PostID; ?>">
                                        <button type="submit" name="unlike" class="likebtn">Unlike</button>
                                    </form>
                                <?php else: ?>
                                    <form action="code/Likepost.php" method="POST">
                                        <input type="hidden" name="PostID" value="<?php echo $PostID; ?>">
                                        <button type="submit" name="like" class="likebtn">Like</button>
                                    </form>
                                <?php endif; ?>

                                <!-- Display existing comments -->
                                    <?php if (!empty($commentslist)): ?>
                                    <div class="comments">
                                        <?php foreach ($commentslist as $comment): ?>
                                            <?php $commenter = $usersobject->getUserByID($comment['UserID']); // Get the commenter's username  ?>
                                            <a href="index.php?page=userprofile&id=<?php echo $commenter['UserID']; ?>" class="userlink"><h5><?php echo $commenter['Name']; ?>:</h5></a>
                                            <div class="commentcontent">
                                                <p> <?php echo $comment['Content']; ?></p>
                                            </div>
                                            <?php $likes = $likesobject->getCommentLikesCount($comment['CommentID']);
                                            if ($likes > 0):
                                                ?>
                                                <p><?php echo $likes; ?> 👍</p>
                                            <?php endif; ?>

                                            <!-- Like Button for Comment -->
                                            <?php if ($likesobject->hasLikedComment($UserID, $comment['CommentID'])): ?>
                                                <form action="code/Unlikecomment.php" method="POST">
                                                    <input type="hidden" name="CommentID" value="<?php echo $comment['CommentID']; ?>">
                                                    <button type="submit" name="unlike" class="likebtn">Unlike</button>
                                                </form>
                                            <?php else: ?>
                                                <form action="code/Likecomment.php" method="POST">
                                                    <input type="hidden" name="CommentID" value="<?php echo $comment['CommentID']; ?>">
                                                    <button type="submit" name="like" class="likebtn">Like</button>
                                                </form>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                    </div>
                                <?php else: ?>
                                    <p>Be the first to comment.</p>
                                <?php endif; ?>

                                <!-- Comment form -->
                                <form action="" method="POST">
                                    <textarea name="commentContent" rows="2" cols="50" placeholder="Add a comment..." required></textarea><br>
                                    <input type="hidden" name="postID" value="<?php echo $PostID; ?>">
                                    <button type="submit" class="commentbtn">Submit Comment</button>
                                </form>

                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p>No posts from followed users.</p>
                    <?php endif; ?>
                </section>
            </div>
            <div class="griditem">   
            </div>
        </div>
    </div>
    <div class="push"></div>
</main>