<?php
	require $_SERVER['DOCUMENT_ROOT'] ."/DBConnectionString/dbconnect_class.php";
	if(isset($_POST['toServer'])){
		$db_obj = new DatabaseConnection();
		$returnData = array();
		try{
			$db_obj->returnConnection()->beginTransaction();
			//this is for the requested applicant list.
			$db_obj->setQuery("select * from applicant_tbl app INNER JOIN request_tbl req ON app.accno = req.applicant_id where req.company_id = :accno and req.who_requester='company'");
			$parameter = array(
				":accno" => $_SESSION['accno']
			);
			$returnData['applicant_requested'] = $db_obj->executeQuery($parameter,true);
			//end of job list

			//this is for the requesting applicant list.
			$db_obj->setQuery("select * from applicant_tbl app 
				INNER JOIN request_tbl req ON app.accno = req.applicant_id
				INNER JOIN jobs ON jobs.id = req.job_id 
				where req.company_id = :accno and req.who_requester='applicant' and matchedByJob = '1'");
			$returnData['requesting_applicants'] = $db_obj->executeQuery($parameter,true);
			//end of employer list
			$returnData['safe'] = true;
			$returnData['message'] = "Data is valid"; 
			print json_encode($returnData);
			$db_obj->returnConnection()->commit();
			
		}
		catch(Exception $e){
			$db_obj->returnConnection()->rollback();
			$error = array('safe' => false,'message' => $e );
			print json_encode($error);
		}
	}

?>