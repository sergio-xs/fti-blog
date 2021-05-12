<?php

class User
{
    public function get_user($id)
    {
        $query="SELECT * FROM users where user_id = '$id' limit 1";
        $database=Database::getInstance();
        $result=$database->read($query);

        if($result)  //nese kemi rezultat
        {
            return $result[0];
        }else
        {
            return false;
        }
    }

    public function get_friends($id)
    {
        $database = Database::getInstance();
        $sql="SELECT * FROM relationship where (user_one_id='$id' OR user_two_id='$id') && status='1' ";
        $result1=$database->read($sql);
       
        $friends_list=array();
        
        if($result1){
        foreach($result1 as $friends){
            if($friends['user_two_id']==$id){
                $friends_list[]=$friends['user_one_id'];
            }else{
                $friends_list[]=$friends['user_two_id'];
            }
               
            
        }
            
        }
        if ($friends_list)  //nese kemi rezultat
        {
            return $friends_list; //mund te jene disa, eshte vektor
        }
        else
        {
            return false;
        }
    }

}
