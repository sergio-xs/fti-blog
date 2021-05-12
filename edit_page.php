<?php
include("classes/autoloader.php");

$DB=Database::getInstance();

$login = new Login();
$login->check_login($_SESSION['blog_user_id']); 

$user=new User();
$user_data=$user->get_user($_SESSION['blog_user_id']);

if($_SERVER['REQUEST_METHOD']=='POST')
     {
      $status_msg='';
      $temp=$_SESSION['blog_user_id'];
      
      if(isset($_POST["submit"])){
          $DB=Database::getInstance();
          if($user_data['role']=='Student'){
              $study_field=$_POST['study_field'];
              $currently=$_POST['currently'];
              $class=$_POST['class'];

              //Nuk e di a eshte eficente kjo menyre me shume kontrolle if por besoj me eficente se te besh insert ne db vec e vec eshte
              
              if(empty($study_field)){
                $query_student="UPDATE users SET 
                cikli_studimit='$currently', klasa='$class' WHERE user_id=$temp";
                if(empty($currently)){
                    $query_student="UPDATE users SET klasa='$class' WHERE user_id=$temp";
                    if(empty($class)){
                        $query_student="";
                    }
                }else{
                    $query_student="UPDATE users SET cikli_studimit='$currently', klasa='$class' WHERE user_id=$temp";
                     if(empty($class)){
                        $query_student="UPDATE users SET cikli_studimit='$currently' WHERE user_id=$temp";
                    }
                }
              }else{
                $query_student="UPDATE users SET dega='$study_field',
                cikli_studimit='$currently', klasa='$class' WHERE user_id=$temp";
                 if(empty($currently)){
                    $query_student="UPDATE users SET  dega='$study_field', klasa='$class' WHERE user_id=$temp";
                    if(empty($class)){
                        $query_student="UPDATE users SET  dega='$study_field' WHERE user_id=$temp";
                    }
                }else{
                    $query_student="UPDATE users SET dega='$study_field', cikli_studimit='$currently', klasa='$class' WHERE user_id=$temp";
                     if(empty($class)){
                        $query_student="UPDATE users SET dega='$study_field', cikli_studimit='$currently' WHERE user_id=$temp";
                    }
                }
              }

              $insert=false;
              if(!empty($study_field)||!empty($currently)||!empty($class)){
                $insert=$DB->save($query_student);
              }else if(empty($study_field)&&empty($currently)&&empty($class)){
                  $status_msg="You didn't make any changes";
              }
              
          }else{

              $text=$_POST["courses"];
              if(!empty($text)){
                $query_profesor="UPDATE users SET courses='$text' WHERE user_id=$temp";
                $DB_1=Database::getInstance();
                $insert=$DB_1->save($query_profesor);
              }
              
          }
      //File upload path
          $targetDir="uploads/CV/".$_SESSION['blog_user_id']."/";
      
          if(!file_exists($targetDir)){
              mkdir($targetDir,0777,true);
          }
          $fileName=basename($_FILES["file"]["name"]);
      
          $targetFilePath=$targetDir.$fileName;
          $fileType=pathinfo($targetFilePath,PATHINFO_EXTENSION);
      
          if(!empty($_FILES["file"]["name"])){
          
              //Allow certain file formats
              $allowTypes=array('docx','pdf');
              if(in_array($fileType,$allowTypes)){
                  //upload file to server
              
                  if(move_uploaded_file($_FILES["file"]["tmp_name"],$targetFilePath)){
                  
                      //insert image file name into database
                     
                      $fileName="uploads/CV/" . $_SESSION['blog_user_id'] . "/".$fileName;
                      $query="UPDATE users SET CV='".$fileName."' WHERE user_id=$temp";
                      //$DB=Database::getInstance();
                      $insert_file=$DB->save($query);
                  
                      if($insert_file){
                          $status_msg="The file ".$fileName." has been uploaded succesfully.";
                          header("Location: profile_page.php");
                          exit();
                          
                      }else{
                          $status_msg="File upload failed,please try again.";
                      }
                    
                  }else{ 
                      $status_msg="Sorry there was an error uploading your file";
                      }
              }else{
                  $status_msg="Sorry file type not allowed!";
                  }
          } 
          
          if($insert){
            $status_msg="Changed successfully";
            header("Location: profile_page.php");
            exit();
            
        }
      }       
     }

?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>FTI blog</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
        <link href="assets/css/edit.css" rel="stylesheet">
        <link href="assets/fontawesome/css/all.css" rel="stylesheet">
        <script defer src="assets/fontawesome/js/all.js"></script> 
    </head>
    <header>
    
    </header>
    <body id="edit">
     <?php
      include ("navbar.php");
     ?>
   
        <div class="container my-5">
            <div class="row h-100 d-flex justify-content-center align-items-center ">
            <div class="card px-0 m-0" id="card">
            <div class="card-header d-flex justify-content-center align-items-center" id="card_header">
                <h4 id="header" class="card-title">Edit your personal information</h4>
            </div>
            <div class="card-body d-flex flex-row justify-content-center">
            
           
                <div class="d-flex justify-content-center w-75">
                    <form method="post"  class="my-auto" id="student_form" enctype="multipart/form-data">
                    <?php if($user_data['role']==='Student'){?>
                        <div>
                              <div class="form-group d-flex flex-column justify-content-start m-2">
                              <label class="mx-2" for="study_field">Study Field</label>
                              <select class="form-select" name="study_field" id="study_field" aria-label="Default select example">
                                <option selected>-</option>
                                <option value="Inxhinieri Informatike">Inxhinieri Informatike</option>
                                <option value="Inxhinieri Elektronike">Inxhinieri Elektronike</option>
                                <option value="Inxhinieri Telekomunikacioni">Inxhinieri Telekomunikacioni</option>
                              </select>
                            </div>

                           
                            <div class="form-group d-flex flex-column justify-content-start m-2">
                              <label class="mx-2" for="currently">Currently in</label>
                              <select class="form-select" id="currently" name="currently" aria-label="Default select example">
                                <option selected>-</option>
                                <option value="Bachelor 1st year">Bachelor 1st year</option>
                                <option value="Bachelor 2nd year">Bachelor 2nd year</option>
                                <option value="Bachelor 3rd year">Bachelor 3rd year</option>
                                <option value="Master 1st year">Master 1st year</option>
                                <option value="Master 2st year">Master 2st year</option>
                                <option value="Graduated">Graduated</option>
                              </select>
                            </div>

                            <div class="form-group d-flex flex-column justify-content-start m-2">
                              <label class="mx-2" for="class">Class</label>
                              <select class="form-select" name="class" id="class" aria-label="Default select example">
                                <option selected>-</option>
                                <option value="A">A</option>
                                <option value="B">B</option>
                                <option value="C">C</option>
                                <option value="D">D</option>
                              </select>
                            </div>
                        </div>
                        <?php }else{?> 
                            <div>
                                <div class="form-group m-2">
                                    <label for="courses">Courses(Every course must be separated by commas)</label>
                                    <textarea class="form-control m-1" name="courses" id="courses" rows="3"></textarea>
                                </div>
                            </div>
                           
                        <?php } ?>       

                            <div class="m-2">
                                <label for="file" class="form-label">Upload your CV</label>
                                <input class="form-control" type="file" name="file" id="file">
                            </div>
                            <div class="text-center error">    
                              <span id="php_error" class="mx-auto">
                               
                                <?php if(!empty($status_msg)){
                                  echo ' <i class="fas fa-exclamation-triangle"></i> ';
                                  echo $status_msg;
                                }
                                  ?>
                              </span>  
                            </div>
                           
                    
                          <div class="text-center my-4 d-inline-flex w-100">
                            <input onclick="window.location = 'profile_page.php';" type="button" id="cancel" name="cancel" class="btn edit-buttons text-align-center w-50 m-2" value="Cancel"></input>
                            <input type="submit" id="save_changes" name="submit" class="btn edit-buttons text-align-center w-50 m-2" value="Save changes"></input>
                          </div>
                                                            
                    </form>
                </div> 
            
                
                
            </div>
            </div>
            </div>            
        </div>
           
        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    </body>
</html>