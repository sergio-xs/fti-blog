<?php
class Signup
{
    private $error = "";
    private $vkey=0;
    public function evaluate($data){
        if ($this->error == ""){
            $db_response=$this->krijo_user($data);
                if($db_response){
                    //if data was saved successfully in the db send the verification email 
                    $to=$data['email'];
                    $subject="Email Verification";
                    $message="Welcome! Please verify your account by clicking on this link <a href='http://localhost/Blog/verify.php?vkey=$this->vkey'>VERIFY EMAIL</a>.";
                    $headers = 'From: <ftiblog2021@gmail.com>' . "\r\n";
                    $headers .= "MIME-Version: 1.0" . "\r\n";
                    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

                    mail($to,$subject,$message,$headers);
                    header('location:email_sent.php');
                }else{
                    return $this->error="There was a problem during the sign up process. Please try again.";
                }
        }else{
            return $this->error;
        }
    }
    
    public function krijo_user($data){
        $emer = trim(ucfirst($data['emer']));
        $mbiemer = trim(ucfirst($data['mbiemer']));
        $email = trim(strtolower($data['email']));
        $fjalekalimi = hash("md5",trim($data['fjalekalimi']));
        $roli =$data['roli'];
        //e krijon databaza vet
        $user_id = $this->krijo_user_id();
        //Generates a key that is an encryption of the time of creation and name thus it will always be unique
        $this->vkey=md5(time().$data['emer'].$data['mbiemer']);      
        $query = "INSERT INTO users (user_id,emer,mbiemer,email,fjalekalimi,role,verification_key) VALUES ('$user_id','$emer','$mbiemer','$email','$fjalekalimi','$roli','$this->vkey')";
        $database = Database::getInstance();
        return $database->save($query);
    }

    //Krijon nje id random per userin
    private function krijo_user_id(){
        $length = rand(4, 10);
        $number = "";
        for ($i = 0; $i < $length; $i++){
            $new_rand = rand(0, 9);
            $number = $number . $new_rand;
        }
        return $number;
    }
}
