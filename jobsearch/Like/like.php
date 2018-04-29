<?php
	function ifRequestExists($isJob,$applicant_id,$company_id,$db_obj, $jobId = null){
		//first checks if the job is available
		$istheLikedJob = false;
		if($isJob == true){
			$db_obj->setQuery("select * from jobs where accno=:accno and id=:id and isAvailable=0");
			$params = array(
				':accno' => $company_id,
				':id'=> $jobId
			);
			$res = $db_obj->executeQuery($params,true);
			
			if($db_obj->returnCount() > 0){
				$success_params = array('isSuccess' => false, 'reason' => "It appears that this job is unavaible as of the moment. Please wait until the employer enables hiring.");
				print json_encode($success_params);
				exit();
			}
		}
		//second it checks for a match
		$db_obj->setQuery("select * from match_table where applicant_accno=:applicant and company_accno=:company");
		$params = array(
			':applicant' => $applicant_id,
			':company'=> $company_id
		);
		$db_obj->executeQuery($params,true);
		//thirds sends accordingly. Of course it checks if there are errors.
		if($db_obj->returnCount() == 0){
			//let's first grab the content of the request table which has the two users. This is the query
			$db_obj->setQuery("select * from request_tbl where applicant_id=:applicant and company_id=:company");	
			//stores the data from query
			$res = $db_obj->executeQuery($params,true);
			if($db_obj->returnCount() > 0){
				$success_params = array('isSuccess' => false, 'reason' => "It appears that you have already sent a request for this job/applicant.");
				//A change request is sent if isJob is true and istheLikedJob is still false.
				if($isJob == true){
					//next we test if the current job is the one that is requested.
					if($res[0]['job_id'] == $jobId){
						$istheLikedJob = true;
					}
					if(!$istheLikedJob){	
						$success_params['isJob'] = $isJob;
						$success_params['changeRequest'] = true;
					}
				}
				print json_encode($success_params);
				exit();
			}
		}
		else{
			$success_params = array('isSuccess' => false, 'reason' => "It appears that you and this user are already matched. A match request cannot be sent.");
			print json_encode($success_params);
			exit();
		}
	}
	require $_SERVER['DOCUMENT_ROOT'] ."/DBConnectionString/dbconnect_class.php";
	$db_obj = new DatabaseConnection();
	//this if will only work if the user is sending a reuest with no overwrite functionality
	if(isset($_POST['sendRequest']) && !isset($_POST['retrySend'])){
		if(isset($_SESSION['accno']) && isset($_SESSION['utype'])){
			$utype = $_SESSION['utype'];
			if($_POST['isJob'] == true && $_SESSION['utype']=="applicant"){
				$applicant = $_SESSION['accno'];
				$employer = $_POST['target'];
				$whoRequester = "applicant";
				$jobId = $_POST['jobId'];
				ifRequestExists($_POST['isJob'],$applicant,$employer,$db_obj,$_POST['jobId']);
			}
			else if(($_POST['isJob'] == false && $_SESSION['utype']=="employer")){
				$applicant = $_POST['target'];
				$employer = $_SESSION['accno'];
				$whoRequester = "company";
				$jobId = '';
				ifRequestExists($_POST['isJob'],$applicant,$employer,$db_obj);
			}
			else{
				print json_encode(array('isSuccess' => false, 'reason' => "Inappropriate type of user is logged in. If you wish to like an applicant, you must log in as an employer. However, if you wish to like a job/employer, the user must log in as an applicant"));
				exit();
			}
			$parameters = array(
				':request_id' =>  sha1(microtime(9999)),
				':applicant' => $applicant,
				':company' => $employer,
				':matchedByJob' => $_POST['isJob'],
				':jobId' => $jobId,
				':whoRequester' => $whoRequester
			);
			$query = "INSERT INTO `request_tbl`(`request_id`, `applicant_id`, `company_id`, `matchedByJob`, `job_id`, `who_requester`) VALUES (:request_id,:applicant,:company,:matchedByJob,:jobId,:whoRequester)"; 
			$db_obj->setQuery($query);
			$db_obj->executeQuery($parameters);
			if($db_obj->getConnectionStatus()){

				if($_POST['isJob'] == true){
					$query = "INSERT INTO `requested_job_count` VALUES ('',:jobId,:dateT)";	
					$newParams = array(":jobId" => $jobId, ":dateT" => date("Y/m/d"));
				}
				if($_POST['isJob'] == false){
					$query = "INSERT INTO `requested_applicant_count` (`id_auto`, `applicant_id`, `date`) VALUES ('',:applicant,:dateT)";	
					$newParams = array(":applicant" => $applicant, ":dateT" => date("Y/m/d"));
				}
				
				$db_obj->setQuery($query);
				$db_obj->executeQuery($newParams);
				print json_encode(array('isSuccess' => true));

			}
			else{
				print json_encode(array('isSuccess' => false, 'reason' => $db_obj->getErrorMessage()));
			}
			
		} 
		else{
			print json_encode(array('isSuccess' => false, 'reason' => "This functionality is unavaible for users that aren't logged in"));
		}
	}
	if(isset($_POST['sendRequest']) && isset($_POST['retrySend'])){
		$db_obj->setQuery("Update `request_tbl` SET job_id=:job where applicant_id=:app and company_id=:comp");
		$params = array(':job' => $_POST['jobId'], ':app' => $_SESSION['accno'], ':comp' => $_POST['target']);
		$db_obj->executeQuery($params);

		if($db_obj->getConnectionStatus()){
			if($_POST['isJob'] == true){
				$query = "INSERT INTO `requested_job_count` VALUES ('',:jobId,:dateT)";	
				$newParams = array(":jobId" => $jobId, ":dateT" => date("Y/m/d"));
			}
			else{
				$query = "INSERT INTO `requested_applicant_count` VALUES ('',:applicant,:dateT)";	
				$newParams = array(":applicant" => $applicant, ":dateT" => date("Y/m/d"));
			}
			$db_obj->setQuery($query);
			$db_obj->executeQuery($newParams);
			print json_encode(array('isSuccess' => true, 'reason' => "Success! Re-request has been successful!"));
		}
		else{
			print json_encode(array('isSuccess' => false, 'reason' => $db_obj->getErrorMessage()));
		}
	}
?>