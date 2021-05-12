<?php
include("classes/autoloader.php");
echo $_GET['requester'];
echo $_GET['action'];

if( $_GET['action']=='accepted'){
    $relationship=new Relationship($_SESSION['blog_user_id'],$_GET['requester']);
    $relationship->accept_connection($_SESSION['blog_user_id']);
}

if( $_GET['action']=='rejected'){
    $relationship=new Relationship($_SESSION['blog_user_id'],$_GET['requester']);
    $relationship->reject_connection($_SESSION['blog_user_id']);
}

header("Location: notifications.php");
exit();
?>