<?php
	require $_SERVER['DOCUMENT_ROOT'] ."/DBConnectionString/dbconnect_class.php";
	if(isset($_POST['sendToServer'])){
		if($_POST['sendToServer'] === "true" || $_POST['sendToServer'] === "1"){
			$db_obj = new DatabaseConnection();
			if($_POST['isJob']==="true"){
				$applicant = $_POST['requester'];
				$employer = $_POST['target'];
				$whoRequester = "applicant";
			}
			else{
				$applicant = $_POST['target'];
				$employer = $_POST['requester'];
				$whoRequester = "company";
			}
			$parameters = array(
				':request_id' =>  sha1(microtime(9999)),
				':applicant' => $applicant,
				':company' => $employer,
				':matchedByJob' => $_POST['isJob'] === "true"? true:false,
				':jobId' => $_POST['jobId'],
				':whoRequester' => $whoRequester
			);
			$query = "INSERT INTO `request_tbl`(`request_id`, `applicant_id`, `company_id`, `matchedByJob`, `job_id`, `who_requester`) VALUES (:request_id,:applicant,:company,:matchedByJob,:jobId,:whoRequester)"; 
			$db_obj->setQuery($query);
			$db_obj->executeQuery($parameters);
			if($db_obj->getConnectionStatus()){
				print true;
			}
			else{
				print false;
			}
		}
	}
	else if(isset($_POST['removeMatch'])){
		$db_obj = new DatabaseConnection();
		$db_obj->setQuery("Delete from match_table where match_id=:match");
		$parameters = array(':match' => $_POST['match_id']);
		$db_obj->executeQuery($parameters);
		if($db_obj->getConnectionStatus()){
			print json_encode(array("isSuccess"=> true));
		}
		else{
			print json_encode(array("isSuccess"=> false,'error' => $db_obj->getErrorMessage()));	
		}
	}
?> 