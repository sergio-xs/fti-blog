<?php

class Relationship{
    public $userOne;
    public $userTwo;
    /* The status of the relationship can be 
      0 - Not connected
      1 - Connected
      2 - Pending
      By default the status is set to 0
     */

    public $status=0;

    //Useri qe ka ber updatimin me te fundit te statusit. Per momentin nuk e perdorim por do te na duhet kur te implementojme komentet
    public $actionUserId;

    //Konstruktori
    function __construct($userOne, $userTwo){
        if($userTwo<$userOne){
            $this->userOne = $userTwo;
            $this->userTwo = $userOne;
        }else{
            $this->userOne = $userOne;
            $this->userTwo = $userTwo;
        }

        $query_1="SELECT * FROM `relationship`
        WHERE `user_one_id` = $this->userOne AND `user_two_id` = $this->userTwo";
        $DB_1=Database::getInstance();
        $result=$DB_1->read($query_1);
        if($result){
            
        }else{
            
                $query="INSERT INTO `relationship` (`user_one_id`, `user_two_id`, `status`, `action_user_id`)
                VALUES ($this->userOne,$this->userTwo, 0, 0)";
                $DB=Database::getInstance();
                $result=$DB->save($query);
              
        }   
      }
    

      function request_connection($logged_user){
        $query="UPDATE`relationship` SET `status`=2, `action_user_id`=$logged_user
        WHERE `user_one_id` = $this->userOne AND `user_two_id` = $this->userTwo";
        $DB=Database::getInstance();
        $result=$DB->save($query);
    }

    function accept_connection($logged_user){
        $query="UPDATE`relationship` SET `status`=1, `action_user_id`=$logged_user
        WHERE `user_one_id` = $this->userOne AND `user_two_id` = $this->userTwo";
        $DB=Database::getInstance();
        $result=$DB->save($query);
        $query_count="UPDATE`users` SET `connections_count`=`connections_count`+1
        WHERE (`user_id` = $this->userOne) OR (`user_id` = $this->userTwo)";
        $DB->save($query_count);
    }

    function reject_connection($logged_user){
        $query="UPDATE`relationship` SET `status`=0, `action_user_id`=$logged_user
         WHERE `user_one_id` = $this->userOne AND `user_two_id` = $this->userTwo";
        $DB=Database::getInstance();
        $DB->save($query);
    }


    function unfriend($logged_user){
        $query="UPDATE`relationship` SET `status`=0, `action_user_id`=$logged_user
         WHERE `user_one_id` = $this->userOne AND `user_two_id` = $this->userTwo";
        $DB=Database::getInstance();
        $DB->save($query);
        $query_count="UPDATE`users` SET `connections_count`=`connections_count`-1
         WHERE (`user_id` = $this->userOne) OR (`user_id` = $this->userTwo)";
        $res=$DB->save($query_count);
    }

   
    function check_relationship(){
        $query_1="SELECT * FROM `relationship`
        WHERE `user_one_id` = $this->userOne AND `user_two_id` = $this->userTwo";
        $DB_1=Database::getInstance();
        $result=$DB_1->read($query_1);
        if($result){
            return true;
        }else{
            return false;
        }
    }

    function check_relationship_status(){
        $query_1="SELECT * FROM `relationship`
        WHERE `user_one_id` = $this->userOne AND `user_two_id` = $this->userTwo limit 1";
        $DB_1=Database::getInstance();
        $result=$DB_1->read($query_1);
        if($result){
            return $result[0]['status'];
        }else{
            return false;
        }
    }

   function check_friendship(){
        $query="SELECT * FROM `relationship`
        WHERE `user_one_id` = $this->userOne AND `user_two_id` = $this->userTwo AND `status` = 1";
        $DB=Database::getInstance();
        $result=$DB->read($query);
        if($result){
            return true;
        }else{
            return false;
        }
    }

    public static function get_pending_requests($logged_user){
        $query="SELECT * FROM `relationship`
        WHERE (`user_one_id` = $logged_user OR `user_two_id` = $logged_user) AND (`status` = 2) AND (`action_user_id`<>$logged_user)";
        
        
        $DB=Database::getInstance();
        $result_set=$DB->read($query);
        
       // print_r($result_set);
        $pending_requests=array();
        if(!empty($result_set)){
            foreach($result_set as $row){          
                if($row['user_one_id']==$logged_user){
                    $pending_requests[]=$row['user_two_id'];               
                }
                if($row['user_two_id']==$logged_user){
                    $pending_requests[]=$row['user_one_id'];
                }
              }
        }else{
            //return "There are no pending requests";
        }
        return $pending_requests;
    }

    //Kthen te gjithe relationships qe ka useri i loguar 
    public static function friends_list($logged_user){
        $query="SELECT * FROM `relationship`
        WHERE (`user_one_id` = $logged_user OR `user_two_id` = $logged_user)
        AND `status` = 1";
        $DB=Database::getInstance();
        $result_set=$DB->read($query);

        $friends=array();
        if(!empty($result_set)){
            foreach($result_set as $row){          
                if($row['user_one_id']==$logged_user){
                    $friends[]=$row['user_two_id'];               
                }
                if($row['user_two_id']==$logged_user){
                    $friends[]=$row['user_one_id'];
                }
              }
        }
            
      

        $friends_information=array();
        if(!empty($friends)) {
            foreach($friends as $friend_id){           
                $query="SELECT * FROM `users`
                WHERE `user_id` = $friend_id limit 1";
                $res = $DB->read($query);
                $friends_information[]=$res[0];
            }
        }
        return $friends_information;
    }
}
?>

    