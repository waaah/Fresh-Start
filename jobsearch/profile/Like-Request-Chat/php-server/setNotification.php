<?php
	require $_SERVER['DOCUMENT_ROOT'] ."/DBConnectionString/dbconnect_class.php";
	if(isset($_POST['setNotification'])){
		$db_obj = new DatabaseConnection();
		$setUnread = "Update notification set unread='false'";
		if($_SESSION['utype'] == "applicant")
		{
			$where = " where applicant=:accno and target='applicant'";
		}
		else if($_SESSION['utype'] == "employer"){
			$where = " where company=:accno and target='company'";
		}
		$query = $setUnread.$where;
		$db_obj->setQuery($query);
		$parameter = array(':accno' => $_SESSION['accno']);
		$db_obj->executeQuery($parameter);
	}
?>