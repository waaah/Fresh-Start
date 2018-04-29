<?php
require $_SERVER['DOCUMENT_ROOT'].'/DBConnectionString/dbconnect_class.php';
if(isset($_POST['resume'])){
	$db_obj = new DatabaseConnection();
	$resumename = $_POST['resume'];
	$accno = $_SESSION['accno'];
	$query = "select * from resume where accno = :accno";
	$parameter = array(':accno' => $accno );
	
	$db_obj->setQuery($query);
	$res = $db_obj->executeQuery($parameter,true);
	$cnt = $db_obj->returnCount();
	$error = "false";

	if($cnt == 0){
		$query = "insert into resume values('',:accno,:resumename)";	
		$db_obj->setQuery($query);
		$parameters  = array(':accno' => $accno,":resumename" => $resumename );
		$db_obj->executeQuery($parameters);
	}
	else{
		foreach ($res as $row) {
			$resume_saved = $row['resume'];
		}
		if(($resume_saved == $resumename)){
			$error = "true";
		}
		else{
			$query = "Update resume set resume=:resumename";
			$parameter = array(':resumename' => $resumename);
			$db_obj->setQuery($query);
			$db_obj->executeQuery($parameter);
		}
	}
	print $error;
} 
if(isset($_POST['gotoResume']) && $_POST['gotoResume'] == true){
	$db_obj = new DatabaseConnection();
	$query = "select * from resume where accno = :accno";
	$parameter = array(':accno' => $_SESSION['accno'] );
	
	$db_obj->setQuery($query);
	$res = $db_obj->executeQuery($parameter,true);
	$cnt = $db_obj->returnCount();
	if($cnt > 0){
		print $res[0]['resume'];
	}
	else{
		print 0;
	}
}
?>