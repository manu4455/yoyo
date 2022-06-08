<?php
Class Database{
 
	private $host = "localhost";
 private $username = "root";
 private $password = "";
 private $database_name = "ecommerce";
	
	//private $host = "185.27.134.10:3306";
    //private $username = "unaux_26803724";
    //private $password = "sneakers@123";
    //private $database_name = "unaux_26803724_sneekers";
 	
	public function open(){
 		try{
 			$this->db = new mysqli($this->host, $this->username, $this->password, $this->database_name);
			return $this->db;
            echo "connected";
 		}
 		catch (PDOException $e){
 			echo "There is some problem in connection: " . $e->getMessage();
 		}
 
    }
 
	public function close(){
   		$this->db = null;
 	}
 
}
$database = new Database();
 
?>