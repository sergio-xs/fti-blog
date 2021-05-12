<?php
ob_start();
session_start();
include("connection.php");
include("classes/login.php");
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>FTI blog</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
        <link href="assets/css/login.css" rel="stylesheet">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat:400,700" type="text/css">
        <link href="assets/fontawesome/css/all.css" rel="stylesheet">
        <script defer src="assets/fontawesome/js/all.js" data-search-pseudo-elements></script> 
        <script defer src="assets/js/login.js"></script>
    </head>
    <body id="loginPage">
        <div class="container h-100" >
            <div class="row h-100" id="login_row">
                <div class="col" id="empty_col"></div>
                <div class="col-lg-6 col-md-12 col-s-12 d-flex flex-column align-items-center justify-content-center h-100">
                    <div class="TWE m-3">
                        <div class="Iam">
                            <p>TOGETHER</p>
                            <b>
                              <div class="innerIam">
                                WE LEARN.<br /> 
                                WE GROW.<br/>
                                WE EVOLVE.<br />
                                </div>
                            </b>
                        </div>
                    </div>
                    
                    <div class="m-4 w-100 d-flex justify-content-center">
                        <form method="POST" id="login_form" action="" class="m-0">
                            <div class="form-group input-group-sm m-2">
                                <label for="email" class="form-label">Email</label>
                                <input name="email"  type="text"  id="email" class="form-control " value=<?php if(isset($_POST['email']))echo $_POST['email'] ?>>
                                <p id="error_email"></p>
                            </div>
                            
                            <div class="form-group input-group-sm m-2">
                                <label for="password" class="form-label">Password</i></label>
                                <input name="password"  type="password"  id="password" class="form-control" value=<?php if(isset($_POST['password']))echo $_POST['password'] ?>>
                                <p id="error_password"></p>
                            </div>   

                            <div class="text-center error">
                                <p class="warning mx-auto">
                                    
                                    <span id="php_error">
                                    
                                    <?php
                                            $email="";
                                            $password="";

                                            if($_SERVER['REQUEST_METHOD']=='POST'){
                                                $login=new Login();
                                                $result=$login->evaluate($_POST);
                                               
                                                if($result!=""){
                                                    echo '<i class="fas fa-exclamation-triangle"></i>'." ".$result;
                                                }else{
                                                    header("Location: profile_page.php");
                                                    die;
                                                }
                                            }
                                    ?>
                                    </span>  
                                </p>
                            </div>
                            
                            <div class="text-center">
                                <button type="submit" class=" login_button btn text-align-center m-2 w-50" name="log_in" id="login_button">Log in</button>
                                <br>
                                <h9><a href="signup.php" id="noAcc">You don't have an account?</a></h9>
                            </div>
                            
                         </form>
                    </div>                  
                </div>
            </div>
        </div>
       
       
        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    </body>
</html>

