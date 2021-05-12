<?php
include("classes/autoloader.php");
    if($_SERVER['REQUEST_METHOD']=='POST')
     {
      $status_msg='';
      $temp=$_SESSION['blog_user_id'];
      
      if(isset($_POST["submit"])){
          $DB=Database::getInstance();
          $old_password=md5($_POST['old_password']);
          $new_password=md5($_POST['new_password']);
          $confirm_new_password=md5($_POST['confirm_new_password']);
          
          $DB=Database::getInstance();
          $user_id=$_SESSION['blog_user_id'];

          $query="SELECT fjalekalimi FROM `users` WHERE user_id=$user_id limit 1";
          $result=$DB->read($query);
          $result=$result[0]['fjalekalimi'];

          
          if($old_password===$result){
            $query_change="UPDATE `users` SET `fjalekalimi`='$new_password' WHERE user_id=$user_id";
            $changed=$DB->save($query_change);
            
            if($changed){
                
            function alert($msg) {
                echo "<script type='text/javascript'>alert('$msg');</script>";
            }

                $status_msg='<i class="fas fa-check-circle"></i> Password successfully changed';
                
                
            }else{
                $status_msg='<i class="fas fa-exclamation-triangle"></i> There was a problem during the change';
                
            }
          }else{
            if ($old_password != ''&&$old_password != null){     
                $status_msg='<i class="fas fa-exclamation-triangle"></i> Old password is not correct';  
              }
          }
      }
      
    }

return;
?>