<?php
	require $_SERVER['DOCUMENT_ROOT'] ."/DBConnectionString/dbconnect_class.php";
	if(isset($_POST['toServer'])){
		$db_obj = new DatabaseConnection();
		$returnData = array();
		try{
			$db_obj->returnConnection()->beginTransaction();
			//this is for the job list.
			$db_obj->setQuery("select * from employer_tbl emp 
						INNER JOIN company_table c ON c.employer_accno = emp.accno 
						INNER JOIN jobs ON jobs.accno = emp.accno 
						INNER JOIN request_tbl req ON jobs.id = req.job_id 
						where req.applicant_id = :accno and req.who_requester='applicant'");
			$parameter = array(
				":accno" => $_SESSION['accno']
			);
			$returnData['jobs'] = $db_obj->executeQuery($parameter,true);
			//end of job list

			//this is for the employer list.
			$db_obj->setQuery("select * from employer_tbl emp 
				INNER JOIN request_tbl req ON emp.accno = req.company_id
				INNER JOIN company_table ON emp.accno = company_table.employer_accno
				where req.applicant_id = :accno and req.who_requester='company'");
			$returnData['employer'] = $db_obj->executeQuery($parameter,true);
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