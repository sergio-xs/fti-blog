
<div class="card shadow" id="user_card"  >
    <img class="card-img-top prf_img" src="<?php if(empty($users['image'])){echo 'assets\img\default_user_picture.jpg'; }else echo $users['image'] ?>" >
    <div class="card-body text-dark description ">
        <a class="remove-decorations" href=<?php 
                    if ($users['user_id']!=$_SESSION['blog_user_id'])
                    {
                        echo htmlspecialchars("profile_page.php?id=" . $users['user_id']);
                    }
                    else
                    {
                        echo htmlspecialchars("profile_page.php");
                    } ?> > 
        
            <?php echo $users['emer'] . " " . $users['mbiemer']; ?>
            
        </a>
        <?php
?>
        <p class="card-text remove-decorations ">
            <?php if($users['role']=="Student"){
                echo "Student";
                if(!empty($users['dega']))
                echo ",".$users['dega'];
            }else{
                echo "Professor";
            }
            ?>
        </p>
    </div>
</div>