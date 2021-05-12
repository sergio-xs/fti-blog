<?php
include_once("connection.php");
class Login{
    private $error="";
    
    function get_error(){
        return $this->error;
    }

    function evaluate($data){
        $email=addslashes($data['email']);
        $password= $this->hash_text($data['password']);
        $query="select * from users where email='$email' limit 1";
        $DB=Database::getInstance();
        $result=$DB->read($query);
        if($result){
            $row=$result[0];
            if($password==$row['fjalekalimi']){  
                //create session data
                $_SESSION['blog_user_id']=$row['user_id'];
                //Process Login
                $verified=$row['verified'];
                if($verified==1){
                    //continue proccessing
                    header("Location: profile_page.php");
                    die;
                }else{
                    $this->error="This account has not yet been verified.An email was sent to ".$row['email'];
                }   
            }else{
                $this->error.="Wrong password<br>";
            }
        }else{
            $this->error.="No such email was found<br>";
        }
        return $this->error;
    }

    function check_login ($id){
        if(is_numeric($id)){
            $query="SELECT * FROM users WHERE user_id='$id' limit 1";
            $DB =Database::getInstance();
            $result= $DB->read($query);

            if($result){
                $user_data=$result[0];
                return $user_data;
            }else{
                header("Location: login_page.php");
                die;
            }        
        }else{
            header("Location: login_page.php");
            die;
        }
    }
    
    private function hash_text($text){
        $text = hash("md5", $text);
        return $text;
    }
}
?>