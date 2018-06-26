<?php
include 'includes/header.php';
?>
        <div class="user-details column">
            <a href="#"><img src="<?php echo $user["profile_pic"]; ?>" alt="">
            </a>
            <div class="user-details-left-right">
                <a href="#">
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
            Thi is profile page
        </div>
    </div>
</body>
</html>