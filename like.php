<?php
//unset($_SESSION['blog_user_id']);
include("classes/autoloader.php");
//isset($_SESSION['blog_user_id']);
$login = new Login();
$user_data = $login->check_login($_SESSION['blog_user_id']);

if(isset($_SERVER['HTTP_REFERER'])){
$return_to=$_SERVER['HTTP_REFERER']; // te kten nga faqja nga erdhe
}else{
    $return_to="profile.php";
}

    if(isset($_GET['type'])&&isset($_GET['id'])){
        if(is_numeric($_GET['id'])){
            if($_GET['type']=="post"){
                $post=new Post();
                $post->like_post($_GET['id'],$_GET['type'],$_SESSION['blog_user_id']);
            }
        }
    }
header("Location: ".$return_to);
die;
