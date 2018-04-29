<?php
	session_start();
	date_default_timezone_set('Asia/Manila');
	class DatabaseConnection{
		function __construct(){
			//this is for connecting to the database.
			$host = "localhost";
			$dbName = "jobsearch2";
			$username = "root";
			$password = "";
			$this->con = new PDO('mysql:host='.$host .';dbname=' .$dbName , $username , $password);
			$this->con->exec("set names utf8");
			if(!($this->con)){
				print "Unable to connect to database for some reason";
				exit();
			}
		}
		public function setQuery($query){
			$this->query = $query;
		}
		public function executeQuery($parameters,$returnType = false){
			try{
				$this->con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				$stmt = $this->con->prepare($this->query);
				foreach ($parameters as $key => &$value) {
					$stmt->bindParam($key,$value);
				}
				//checks if the statement has executed successfully
				$this ->setConnectionStatus($success = $stmt->execute($parameters));
				if($success&&$returnType){
					//returns or prints depending on user value
					$this->res = $stmt->fetchAll();
					$cnt = $stmt->rowCount();
					$this->setCount($cnt);
					//checks if the user has set returnType to true.
					if($returnType){
						if($cnt != 0){				
							return $this->res;
						}
						
						
					}
				}
				else{
					//print_r($this->con->errorInfo());
				}
				$con = null;
			}
			catch(PDOException $e){
				$this->setErrorMessage($e->getMessage());
				$this->setConnectionStatus(false);	
			}
			
			//$this->closeConnection();
			//end of statement check
		} 
		private function setCount($count){
			$this->count = $count;
		}
		public function returnCount(){
			return $this->count;
		}
		private function setConnectionStatus($success){
			$this->success = $success;
		}
		public function returnConnection(){
			return $this->con;
		}
		public function getConnectionStatus(){
			return $this->success;
		}
		private function setErrorMessage($message){
			$this->errorMessage = $message;
		}
	    public function getErrorMessage(){
	    	return $this->errorMessage;
	    }		

	}
?>
