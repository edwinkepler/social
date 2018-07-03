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
            <div class="posts-area"></div>
            <img id="loading" src="assets/images/icons/loading.gif">
        </div>

        <script>
            var userLoggedIn = '<?php echo $userLoggedIn ?>';

            $(document).ready(function() {
                $('#loading').show();

                $.ajax({
                    url: "includes/handlers/ajax_load_posts.php",
                    type: "POST",
                    data: "page=1&userLoggedin=" + userLoggedIn,
                    cache: false,
                    success: function(data) {
                        $('#loading').hide();
                        $('.posts-area').html(data);
                    }
                });

                $(window).scroll(function() {
                    var height = $('.posts-area').height();
                    var scroll_top = $(this).scrollTop();
                    var page = $('.posts-area').find('.next-page').val();
                    var no_more_posts = $('.posts-area').find('.no-more-posts').val();

                    if((document.body.scrollHeight == document.body.scrollTop + window.innerHeight) && no_more_posts == 'false') {
                        $('#loading').show();

                        var ajax_reg = $.ajax({
                            url: "includes/handlers/ajax_load_posts.php",
                            type: "POST",
                            data: "page=" + page + "&userLoggedin=" + userLoggedIn,
                            cache: false,
                            success: function(response) {
                                $('posts-area').find('.next-page').remove();
                                $('posts-area').find('.no-more-posts').remove();

                                $('#loading').hide();
                                $('.posts-area').append(response);
                            }
                        });
                    }
                    return false;
                });
            });
        </script>
    </div>
</body>
</html>