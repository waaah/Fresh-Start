<?php
	if(isset($_POST['accno'])){
		$dateTime = new DateTime("now", new DateTimeZone('Asia/Manila'));
		$db_obj = new DatabaseConnection();
		$db_obj->setQuery("");
		$db_obj->executeQuery();
	    $array = array(
	  	  'time' => $dateTime->format("h:i:s A"),
	  	  'date' => $dateTime->format("m-d-y") 
	    );
	    print json_encode($array);
	}
	  
?>