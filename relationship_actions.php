<?php 
   include("classes/autoloader.php");

   if(isset($_SESSION['get_param'])){
       if($_SESSION['blog_user_id']!=$_SESSION['get_param']){
         $relationship=new Relationship($_SESSION['blog_user_id'],$_SESSION['get_param']);
         $check_relationship_status=$relationship->check_relationship_status();
        
         
         if($check_relationship_status==1){
            $relationship->unfriend($_SESSION['blog_user_id']);
            $status=array("status"=>"0");
         }else{                     
             //Kur eshte 0 se 2 smund te jete se kur eshte 2 eshte disabled butoni
            $relationship->request_connection($_SESSION['blog_user_id']);
            $status=array("status"=>"2");
         }
         
         echo json_encode($status);
       }
   }
?>