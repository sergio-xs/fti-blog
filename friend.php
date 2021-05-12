<div id="friends" style="display: inline;">
    <a href="profile_page.php?id=<?php echo $friend['user_id'] ?>">

        <img src=<?php if(empty($users['image'])){echo 'assets\img\default_user_picture.jpg'; }else echo $users['image'] ?> width="10%" alt="">
        <br>
        <?php echo $friend['emer'] . " " . $friend['mbiemer']; ?>
    </a>
</div>