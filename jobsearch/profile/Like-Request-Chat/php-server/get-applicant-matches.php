<?php
	require $_SERVER['DOCUMENT_ROOT'] ."/DBConnectionString/dbconnect_class.php";
	if(isset($_POST['toServer'])){
		$db_obj = new DatabaseConnection();
		$returnData = array();
		$db_obj->setQuery("select * from employer_tbl et INNER JOIN match_table mt ON et.accno = mt.company_accno 	where mt.applicant_accno=:accno");
		$parameter = array(
			":accno" => $_SESSION['accno']
		);
		$data = $db_obj->executeQuery($parameter,true);
		if($db_obj->getConnectionStatus()){
			$returnData = array(
				'employer' => $data,
				'success' => true
			); 	
		}
		else{
			$returnData['success'] = false;
		}
		print json_encode($returnData);
		
	}

?>