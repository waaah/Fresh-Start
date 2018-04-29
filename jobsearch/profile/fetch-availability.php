<?php
	require $_SERVER['DOCUMENT_ROOT'] ."/DBConnectionString/dbconnect_class.php";

	if(isset($_POST['id'])){
		$db_obj = new DatabaseConnection();
		$parameters  = array(
			':id' => $_POST['id'] 
		);
		$db_obj->setQuery("select isAvailable from jobs where id=:id");
		$result = $db_obj->executeQuery($parameters,true);
		$valid = ($db_obj->getConnectionStatus()) ? true:false;
		$result['valid'] = $valid;
		print json_encode($result);
	}
	else{
		print "none";
	}
?>