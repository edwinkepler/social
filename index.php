<?php
include 'includes/header.php';
include "includes/classes/User.php";
include "includes/classes/Post.php";

if (isset($_POST["post"])) {
    $post = new Post($con, $userLoggedIn);
    $post->submitPost($_POST["post_text"], "none");
}
?>
        <div class="user-details column">
            <a href="<?php echo $userLoggedIn ?>"><img src="<?php echo $user["profile_pic"]; ?>" alt="">
            </a>
            <div class="user-details-left-right">
                <a href="<?php echo $userLoggedIn ?>">
                    <?php echo $user["first_name"] . " " . $user["last_name"]; ?>
                </a>
                <br>
                <?php
                echo "Posts: " . $user["num_posts"] . "<br>"; 
                echo "Likes: " . $user["num_likes"];
                ?>
            </div>
        </div>
        <div class="main-column column">
            <form class="post-form" action="index.php" method="POST">
                <textarea name="post_text" id="post_text" placeholder="Got something to say?"></textarea>
                <input type="submit" name="post" id="post_button" value="Post">
            </form>

            <?php
                $post = new Post($con, $userLoggedIn);
                $post->loadPostsFriends();
            ?>
        </div>
    </div>
</body>
</html>