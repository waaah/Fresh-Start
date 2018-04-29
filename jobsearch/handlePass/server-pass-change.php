<?php
	require $_SERVER['DOCUMENT_ROOT'] ."/DBConnectionString/dbconnect_class.php";
	if(isset($_POST['save_pass'])){
		$params = $_SESSION['parameters_pass'];
		$string = substr($params['accno'],4,3);
		if($string=='111' || $string == '112'){
			$query = "update applicant_tbl set password=:password where accno=:accno";
		}
		else{
			$query = "update applicant_tbl set password=:password where accno=:accno";	
		}
		//employer and applicant
		$db_obj = new DatabaseConnection();
		$db_obj->setQuery($query);
		$parameters = array(
			':password' => $_POST['password'],
			':accno' => $params['accno'] 
		);
		$db_obj->executeQuery($parameters);
		$success =  $db_obj->getConnectionStatus();

		$delete = "delete from password_recovery where accno=:accno";
		unset($parameters[':password']);
		$db_obj->setQuery($delete);
		$db_obj->executeQuery($parameters);

		print $success;
	}
?>