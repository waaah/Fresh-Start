<?php
	require $_SERVER['DOCUMENT_ROOT'] ."/DBConnectionString/dbconnect_class.php";
	if(isset($_POST['display_select'])&&isset($_POST['reg_name']))
	{
		$reg_name = $_POST['reg_name'];
		$select = "select * from ph_regions where region_name =:reg_name";
		$param = array(':reg_name' => $reg_name );
		$db_obj = new DatabaseConnection();
		$db_obj->setQuery($select);
		$res = $db_obj->executeQuery($param,true);
		$region = array();
		foreach ($res as $row) {
			array_push($region, $row['city_name']);
		}
		print json_encode($region);
	}
	else{
		$query = "select DISTINCT(region_name) from ph_regions";
		$db_obj = new DatabaseConnection();
		$db_obj->setQuery($query);
		$res = $db_obj->executeQuery(array(),true);
		foreach ($res as $row) {
			$reg_name = $row['region_name'];
			print "<option value ='$reg_name'>$reg_name</option>";
		}
		
	}

?>