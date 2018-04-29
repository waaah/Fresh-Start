<?php
	require("dbconnect_class.php"); 
?>
<!DOCTYPE html>
<html>
<head>
	<title>Testing Script</title>
</head>
<body>
<?php
	$db_obj = new DatabaseConnection();

	$db_obj ->setQuery("select * from jobs where id=:id");
	$array_import = array( 
		':id' => 54
	);
	print_r($db_obj->executeQuery($array_import,true));
	//executeQuery(arrayvalues,retriveRecords?)
	print $db_obj->returnCount();
?>
<form method="post" action="testing_script.php">
	Edit ID and Accno:
	<input type="id" name="id">
	<input type="accno" name="accno">
	<button type="submit" name="update">Submit</button>
	<?php
	if(isset($_POST['update'])){
		$db_obj = new DatabaseConnection();
		$db_obj ->setQuery("update jobs set accno=:accno where id=:id");
		$array_import = array( 
			":accno" =>$_POST['accno'],
			":id" =>$_POST['id']
		);
		$db_obj->executeQuery($array_import);
		//executeQuery(arrayvalues,retriveRecords?)
		//print $db_obj->returnCount();
	}
	?>
</form>
</body>
</html>