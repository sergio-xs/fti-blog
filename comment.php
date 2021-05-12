<div class="row mx-auto" id="komentet" style=" background-color: white;">
    <div id="avatar">
        <img id="profile_image" src=<?php
                                    if (file_exists($ROW_USER['image']))
                                    {
                                        echo htmlspecialchars($ROW_USER['image']);
                                    }
                                    else
                                    {
                                        echo "assets\img\default_user_picture.jpg";
                                    } ?> alt="avatar">
    </div>
    <div class="column">

        <b><a style="text-decoration: none; color: #4d4d4d;" href=<?php
                                                                    if ($comment_row['user_id'] != $_SESSION['blog_user_id'])
                                                                    {

                                                                        echo htmlspecialchars("profile.php?id=" . $comment_row['user_id']);
                                                                    }
                                                                    else
                                                                    {
                                                                        echo htmlspecialchars("profile.php");
                                                                    } ?>> <?php echo $ROW_USER['emer'];
                                                                        echo " " . $ROW_USER['mbiemer'] ?></a></b> <span>commented:</span>
        <p class="postim_tekst" >
            <?php echo htmlspecialchars($comment_row['post']); //escaping qe te mos ekzekutohen scripts ne html 
            //shton special characters dhe i thone browsers 'dont run this' 
            ?>
        </p>
        <small><?php
                $timestamp = strtotime($comment_row['data']);
                echo date('l h:i:s a d/m/Y', $timestamp);
                ?>
        </small>
        <hr>
        <br>
    </div>
</div>