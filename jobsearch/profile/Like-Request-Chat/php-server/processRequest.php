<?php
	require $_SERVER['DOCUMENT_ROOT'] ."/DBConnectionString/dbconnect_class.php";
	function printJsonDecode($isSuccessful,$message,$requestId = null){
		$response = array(
			'successful' => $isSuccessful, 
			'message' => $message,
			'requestId' => $requestId
		);
		print json_encode($response);
	}
	if(isset($_POST['startMatch'])){
		$request_response = $_POST['requestResponse'];
		$request_id = $_POST['request_id'];
		$parameter = array(':request_id' => $request_id );
		$db_obj = new DatabaseConnection();
		if($request_response != "accept" && $request_response != "reject" && $request_response != "remove"){
			printJsonDecode(false,"The system could only accept the string reject and accept");
		    exit();
		}
		if($request_response == "accept"){
			$query = "INSERT INTO `match_table`(`match_id`, `applicant_accno`, `company_accno`, `matchedByJob`, `job_id`, `who_requester`) SELECT `request_id`, `applicant_id`, `company_id`, `matchedByJob`, `job_id`, `who_requester` from request_tbl where request_id=:request_id";
			$db_obj->setQuery($query);
			$db_obj->executeQuery($parameter);
			if(!$db_obj->getConnectionStatus()){
				printJsonDecode(false,"Matching between these users could not be accomplished");
				exit();
			}
		}
		$query  = "delete from request_tbl where request_id=:request_id";
		$db_obj->setQuery($query);
		$db_obj->executeQuery($parameter);
		if($db_obj->getConnectionStatus()){
			printJsonDecode(true,"User transaction has been successful",$request_id);
		}

	} 
?>