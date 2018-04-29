<?php
	require $_SERVER['DOCUMENT_ROOT'] ."/DBConnectionString/dbconnect_class.php";

	if(isset($_POST['action'])){
		$action = $_POST['action'];
		$dateTime = new DateTime();
		$db_obj = new DatabaseConnection();
		switch ($action) {
			case 'save':
				$db_obj->setQuery("Insert into password_rec_timeout values('',:email,:date,:time)");
				$date = $dateTime->format("Y-m-d");
				$time = $dateTime->format("H:i:s");
				$parameters = array(
					':email' => $_POST['email'],
					':date' => $date,
					':time' => $time 
				);
				$db_obj->executeQuery($parameters);
				break;
			case 'check':
				$db_obj->setQuery("select * from password_rec_timeout where email=:email");
				$parameter = array(':email' => $_POST['email']);
				$db_obj->executeQuery($parameter,true);
				//prints true if
				if($db_obj->returnCount() > 0){
					print false;
				}
				else{
					print true;
				}				
				exit();
				break;
			case 'delete':
				$db_obj->setQuery("delete from password_rec_timeout where email=:email");
				$parameter = array(':email' => $_POST['email']);
				$db_obj->executeQuery($parameter);
			default:
				# code...
				break;
		}
		
		if($db_obj->getConnectionStatus()){
			print true;
		}
		else{
			$db_obj->getErrorMessage();
		}
		
	}
?>