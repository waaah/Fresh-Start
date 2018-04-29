<?php
	require $_SERVER['DOCUMENT_ROOT'] ."/DBConnectionString/dbconnect_class.php";
	if(isset($_POST['toServer'])){
		$db_obj = new DatabaseConnection();
		$returnData = array();
		$db_obj->setQuery("select * from applicant_tbl INNER JOIN match_table mt ON applicant_tbl.accno = mt.applicant_accno where mt.company_accno=:accno");
		$parameter = array(
			":accno" => $_SESSION['accno']
		);
		$data = $db_obj->executeQuery($parameter,true);
		if($db_obj->getConnectionStatus()){
			$returnData = array(
				'applicants' => $data,
				'success' => true
			); 	
		}
		else{
			$returnData['success'] = false;
		}
		print json_encode($returnData);
		
	}

?>