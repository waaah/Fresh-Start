<?php
	require $_SERVER['DOCUMENT_ROOT'] ."/DBConnectionString/dbconnect_class.php";
    if ( 0 < $_FILES['file']['error'] ) {
        echo 'Error: ' . $_FILES['file']['error'] . '<br>';
    }
    else {
        $query = "UPDATE temp_employer_tbl SET sec=:sec where accno=:accno";
        $ext = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
        $newName = $_SESSION['unregistered_accno'].".".$ext;

		$parameters = array(
			':sec' => $newName,
			':accno' => $_SESSION['unregistered_accno']
		);

		$db_obj = new DatabaseConnection();
		$db_obj->setQuery($query);
		$db_obj->executeQuery($parameters);
		if($db_obj->getConnectionStatus()){
			move_uploaded_file($_FILES['file']['tmp_name'], 'sec/' . $newName);
			print true;	
		}
		else{
			print false;
		}
        
    }

?>