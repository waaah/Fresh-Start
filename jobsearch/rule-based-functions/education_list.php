<?php
	require $_SERVER['DOCUMENT_ROOT'] ."/DBConnectionString/dbconnect_class.php";
	$db_obj = new DatabaseConnection();
	$db_obj->setQuery("SET character_set_results = 'utf8', character_set_client = 'utf8', character_set_connection = 'utf8', character_set_database = 'utf8', character_set_server = 'utf8'");
	$query = "select * from universities";
	$skills = array();
	$db_obj->setQuery($query);
	$res = $db_obj->executeQuery(array(),true);
	foreach ($res as $row) {
		array_push($skills,$row['univ_name']);
	}
	print json_encode($skills);
?>