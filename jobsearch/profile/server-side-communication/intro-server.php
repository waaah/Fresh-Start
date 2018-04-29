<?php
require $_SERVER['DOCUMENT_ROOT'] ."/DBConnectionString/dbconnect_class.php";
if(isset($_POST['toProfile'])){
	$db_obj = new DatabaseConnection();
	$db_obj->setQuery("Update account_verification SET isLoggedIn=1 where accno=:accno");
	$db_obj->executeQuery(array(':accno' => $_SESSION['accno']));
	print $_SESSION['utype']."_profile.php";
}
else if(isset($_POST['toInstruction'])){	
	print $_SESSION['utype']."_help.html";
}


?>