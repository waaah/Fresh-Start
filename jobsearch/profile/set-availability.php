<?php
	require $_SERVER['DOCUMENT_ROOT'] ."/DBConnectionString/dbconnect_class.php";

	if(isset($_POST['isAvailable'])){
		$availability = $_POST['isAvailable']  == "true" ? true:false;
		$db_obj = new DatabaseConnection();
		$parameters  = array(
			':isAvailable' => !$availability,
			':id' => $_POST['id'] 
		);
		$db_obj->setQuery("Update jobs set isAvailable=:isAvailable where id=:id");
		$db_obj->executeQuery($parameters);
		print ($db_obj->getConnectionStatus()) ? true:false;
	}
	else{
		print "none";
	}
?>