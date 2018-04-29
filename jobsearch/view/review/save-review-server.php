<?php 
require $_SERVER['DOCUMENT_ROOT'] ."/DBConnectionString/dbconnect_class.php";
if(isset($_POST['save_review'])){
	$db_obj = new DatabaseConnection();
	$params = array(
		":comment" => $_POST['comment'],
	    ":name" => $_POST['name'],
	    ":rating" => $_POST['rating'],
	    ":title" => $_POST['title'],
	    ":date_today" => date('F d, Y - h:i A'),
	    ":accno" => $_POST['accno']
	);
	
    $insert = "INSERT INTO reviews (`review_id`,`emp_accno`, `title`, `name`, `body`, `date`, `rating`) VALUES ('',:accno, :title, :name, :comment, :date_today, :rating)";
    $db_obj->setQuery($insert);
    $res = $db_obj->executeQuery($params);
    $success = $db_obj->getConnectionStatus();
    if($success){
    	print true;
    }
    else{
    	print false;
    }

}
?>