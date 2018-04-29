<?php
	require $_SERVER['DOCUMENT_ROOT'] ."/DBConnectionString/dbconnect_class.php";
	if(isset($_POST['printNotif']) && $_POST['printNotif'] == true){
		$db_obj = new DatabaseConnection();
		$parameters = array(
			':accno' => $_SESSION['accno']
		);	
		if($_SESSION['utype'] == "applicant"){
			$query = "select * from employer_tbl et INNER JOIN notification notif ON et.accno = notif.company where target='applicant' and notif.applicant=:accno";
		}
		else if($_SESSION['utype'] == "employer"){
			$query = "select * from applicant_tbl at INNER JOIN notification notif ON at.accno = notif.applicant where target='company' and notif.company = :accno";
		}
		if(isset($_POST['printAll']) && $_POST['printAll'] == "false"){
			$query.= " and unread='true'";
		}
		$query.= " ORDER BY notif.date_received DESC,notif.time_received DESC";
		$db_obj->setQuery($query);
		$res = $db_obj->executeQuery($parameters,true);
		print json_encode($res);
	}
?>

