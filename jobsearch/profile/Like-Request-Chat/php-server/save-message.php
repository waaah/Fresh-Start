<?php
	require $_SERVER['DOCUMENT_ROOT'] ."/DBConnectionString/dbconnect_class.php";
	if(isset($_POST['message'])){
		$db_obj = new DatabaseConnection();
		$date = new DateTime("now",new DateTimeZone("Asia/Manila"));
		$today = $date->format("m/d/y");;
		$time = $date->format("h:i:s A");
		$parameters = array(
			":message" => $_POST['message'],
			":date" => $today,
			":time" => $time,
			":sender" => $_SESSION['accno']
		);
		$db_obj->setQuery("Update match_table set latestMessage=:message,dateSent=:date,timeSent=:time,sender=:sender");
		$db_obj->executeQuery($parameters);
		$arrayName = array(
			'accno' => $_SESSION['accno'],
			'saved' => $db_obj->getConnectionStatus()
		);
		print json_encode($arrayName);
	}
?>