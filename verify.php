<?php
include_once("connection.php");
if(isset($_GET['vkey'])){
    //Proccess verification
    $vkey=$_GET['vkey'];
    $DB=Database::getInstance();
    $query="SELECT verified,verification_key FROM users WHERE verified=0 AND verification_key='$vkey' limit 1";
    $result=$DB->read($query);

    if($result){
        $query2="UPDATE users SET verified=1 WHERE verification_key='$vkey'";
        $update=$DB->save($query2);
        if($update){
            header("Location: login_page.php");
            die;
        }else{
            echo "There was a problem with verifying your account.";
        }
    }else{
        echo "This account is invalid or already verified";
    }
}else{
    die("Something went wrong.");
}
?>

