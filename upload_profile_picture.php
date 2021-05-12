<?php
//include the database connection file
$status_msg='';
 include("classes/autoloader.php");
//File upload path
$targetDir="uploads/profilepic/".$_SESSION['blog_user_id']."/";

if(!file_exists($targetDir)){
    mkdir($targetDir,0777,true);
}




$fileName=urlencode(basename($_FILES["file"]["name"]));
$targetFilePath=$targetDir.$fileName;
$fileType=pathinfo($targetFilePath,PATHINFO_EXTENSION);



if(isset($_POST["submit"])&& !empty($_FILES["file"]["name"])){
   
    //Allow certain file formats
    $allowTypes=array('jpg','jpeg','jfif');
    if(in_array($fileType,$allowTypes)){
        //upload file to server
       
        if(move_uploaded_file($_FILES["file"]["tmp_name"],$targetFilePath)){
           
            //insert image file name into database
            $temp=$_SESSION['blog_user_id'];
            $fileName="uploads/profilepic/" . $_SESSION['blog_user_id'] . "/".$fileName;
            $query="UPDATE users SET image='".$fileName."' WHERE user_id=$temp";
            $DB=Database::getInstance();
            $insert=$DB->save($query);
           
            if($insert){
                $status_msg="The file ".$fileName." has been uploaded succesfully.";
                
            }else{
                $status_msg="File upload failed,please try again.";
            }
        }else{ 
            $status_msg="Sorry there was an error uploading your file";
            }
    }else{
        $status_msg="Sorry file type not allowed!";
        }
}else{
    $status_msg="Please select a file to upload";
    }

    echo $status_msg;
    header("Location: profile_page.php");
    exit();
            
?>