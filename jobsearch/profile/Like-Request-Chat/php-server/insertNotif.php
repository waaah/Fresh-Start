<?php
	require $_SERVER['DOCUMENT_ROOT'] ."/DBConnectionString/dbconnect_class.php";
	if(isset($_POST['notif_accno'])){
		$dateTime = new DateTime("now", new DateTimeZone('Asia/Manila'));
		$date = $dateTime->format("m-d-y");
		$time = $dateTime->format("h:i:s A");
		$db_obj = new DatabaseConnection();
		if($_SESSION['utype'] == "applicant"){
			$applicant = $_SESSION['accno'];
			$employer = $_POST['notif_accno']; 
			$target = "company";
		}
		else if($_SESSION['utype'] == "employer"){
			$employer = $_SESSION['accno'];
			$applicant = $_POST['notif_accno']; 
			$target = "applicant";
		}
		$parameters = array(
			':notifText' => $_POST['notif_text'], 
			':notifType' => $_POST['notif_type'],
			':applicant' => $applicant,
			':company' => $employer,
			':r_date' => $date,
			':r_time' => $time,
			':target' => $target
		);
		$db_obj->setQuery("INSERT INTO `notification`(`notif_id`, `notif_text`, `notif_type`, `applicant`, `company`, `date_received`, `time_received`, `unread`, `target`) VALUES ('',:notifText,:notifType,:applicant,:company,:r_date,:r_time,'true',:target)");
		$db_obj->executeQuery($parameters);
	    if($db_obj->getConnectionStatus()){
	    	$parameters['success'] = true;
	    	print json_encode($parameters);
	    }
	    else{
	    	print $success = false;
	    }
	}
	else{
		print "Not defined";
	}
	  
?>