<?php
include("classes/autoloader.php");
$DB=Database::getInstance();
$user_id=$_SESSION['blog_user_id'];

$friends_list=Relationship::friends_list($_SESSION['blog_user_id']);
print_r($friends_list);
foreach($friends_list as $friend){
    $friend_id=$friend['user_id'];
    print_r($friend_id);
    $query_count="UPDATE`users` SET `connections_count`=`connections_count`-1
         WHERE `user_id` = $friend_id";
        $DB->save($query_count);
}

$query="DELETE FROM `users` WHERE user_id='$user_id'";
echo  $DB->save($query);


header("Location: landing_page.php");
die();
?>