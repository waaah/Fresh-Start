<?php
	require $_SERVER['DOCUMENT_ROOT'] ."/DBConnectionString/dbconnect_class.php";
	$db_obj = new DatabaseConnection();
	$db_obj->setQuery("select * from resume where accno=:accno");
	$rows = $db_obj->executeQuery( array(':accno' => $_GET['accno'] ),true);
	$cnt = $db_obj->returnCount();
	if($cnt > 0){
		foreach ($rows as $row) {
			$resume = $row['resume'];
		}
		header("location:/jobsearch/resume/view_".$resume.".php?accno=".$_GET['accno']);
	}
	else{
		header("location:/jobsearch/view/applicant_view.php?code=".$_GET['accno']);
	}
?>
