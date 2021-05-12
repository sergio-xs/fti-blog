<?php
include("classes/autoloader.php");

if(isset($_SESSION['get_param'])){
    if($_SESSION['blog_user_id']!=$_SESSION['get_param']){
      $relationship=new Relationship($_SESSION['blog_user_id'],$_SESSION['get_param']);
      $check_relationship_status=$relationship->check_relationship_status();
      $status=array("status"=>"$check_relationship_status");
      echo json_encode($status);
    }
}
?>