<?php
session_start();
if(isset($_SESSION['blog_user_id'])){
    unset($_SESSION['blog_user_id']);
}

header("Location: login_page.php");
?>