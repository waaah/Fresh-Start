<?php
	//THE SCRIPT TO VERIFY THE VERIFICATION EMAIL
	require $_SERVER['DOCUMENT_ROOT'] ."/DBConnectionString/dbconnect_class.php";
	$data = json_decode(file_get_contents("php://input"));
 	$db_obj = new DatabaseConnection();
 	$db_obj->setQuery("Update account_verification set isValidated=true where password=:password and verification_code=:code and isValidated=false");
 	$db_obj->executeQuery(array(":password"=>$data->password, ":code"=>$data->code));
 	$success = $db_obj->getConnectionStatus();
 	$state = array();
 	if($success){
 		$state['success'] = true;
 		$state['message'] = 'Data has been successfully saved. Press OK to go back to the login page';
 	}
 	else{
 		$state['success'] = false;
 		$state['message'] = 'Data has not been saved successfully. Press check your password and try again';
 	}
 	print json_encode($state);
?>