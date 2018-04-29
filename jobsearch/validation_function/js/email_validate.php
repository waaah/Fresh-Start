<?php
require $_SERVER['DOCUMENT_ROOT'] ."/DBConnectionString/dbconnect_class.php";
	$db_obj = new DatabaseConnection();
	if(isset($_POST['type']) && isset($_POST['email'])){
		if($_POST['type'] == "applicant"){
			$db_obj->setQuery("select email from applicant_tbl where email=:email");
			$db_obj->executeQuery($arrayName = array(':email' => $_POST['email'] ),true);
			print $db_obj->returnCount() === 0 ? "true":"false";			
		}
		else if($_POST['type'] == "company"){
			$db_obj->setQuery("(SELECT email from employer_tbl where email=:email1) UNION (SELECT email from temp_employer_tbl where email=:email2)");
			$db_obj->executeQuery($arrayName = array(':email1' => $_POST['email'],':email2' => $_POST['email'] ),true);
			print $db_obj->returnCount() === 0 ? "true":"false";
		}


	}
	//print $_POST['type'];
?>