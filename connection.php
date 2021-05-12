<?php
//Singleton prove
//Menyra si e therret
//$DB=Database::getInstance();
class Database{
    /*
    private $dbHost="localhost";
    private $dbUsername="root";
    private $dbPassword="";
    private $dbName="blog";
    */

    //REMOTE DATABASE 
    private $dbHost="remotemysql.com";
    private $dbUsername="3VZ65vWumF";
    private $dbPassword="dMnv0v0J0H";
    private $dbName="3VZ65vWumF";

    private static $database=NULL;
    private $connection=NULL;
    //Konstruktor privat qe mund te aksesohet vetem brenda klases
    private function __construct(){
        $this->connect();
    }
    //Create database connection
    function connect(){
        $this->connection=new mysqli($this->dbHost,$this->dbUsername,$this->dbPassword,$this->dbName);
        //return $this->connection;
    }

    /* A static method that will create an object instance once and after 
    that it will reuse the same instance for all other requests */
    static function getInstance():Database {
        if (NULL == self::$database) {
            self::$database = new Database();
        }
        return self::$database;
    }

     /* A getter function to access the connection object */
     public function getConnection(){
        return $this->connection;
    }

    //Read from database
    function read($query){
        $conn=$this->getConnection();
        $result=mysqli_query($conn,$query);
        if(!$result){
            return false;
        }else{
            $data=false;
            while($row=mysqli_fetch_assoc($result)){
               $data[]=$row;
            }
            return $data;
        }
    }

    //Save to database
    function save($query){
        $conn=$this->getConnection();
        $result=mysqli_query($conn,$query);
        if(!$result){
            
            return false;
        }else{
   
            echo $this->connection->error;
            return true;
        }
    }
}
    

?>

