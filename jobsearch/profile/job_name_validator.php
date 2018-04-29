<?php 
require $_SERVER['DOCUMENT_ROOT'] ."/DBConnectionString/dbconnect_class.php";
if(isset($_POST['jobname'])){
	$job_name = $_POST['jobname'];
	$accno = $_SESSION['accno'];
	$select = "select job_name from jobs where job_name = :job_name";
	$db_obj = new DatabaseConnection();
	$db_obj->setQuery($select,true);
	$db_obj->executeQuery(array(":job_name" => $job_name),true);
	$count = $db_obj->returnCount();
	if($count > 0){
		print "false";
	}
	else{
		print "true";
	}
}
else{
	print "false";
}
?>