<?php
require $_SERVER['DOCUMENT_ROOT'] ."/DBConnectionString/dbconnect_class.php";
$data = $_POST['image'];
$usertype = $_SESSION['utype'];
$id = $_SESSION['accno'];

list($type, $data) = explode(';', $data);
list(, $data) = explode(',', $data);

$data = base64_decode($data);
$imageName = time().'.png';
$dummy = $imageName;
$table = '';

if($usertype == "employer")
	$table = "employer_tbl";
else if($usertype =="applicant")
	$table = "applicant_tbl";

$query = "select * from " .$table ." where accno = :id";
$db_obj = new DatabaseConnection();
$db_obj -> setQuery($query);
$res = $db_obj -> executeQuery(array(":id" => $id), true);
$cnt = $db_obj -> returnCount();
if($cnt!=0){
	foreach ($res as $row) {
		$fileName = $row['pic'];		
	}
	if(!empty($fileName))
		unlink("upload/$fileName");	
}	

$update = "update " .$table ." SET pic=:imageName where accno=:id";
$db_obj-> setQuery($update);
$db_obj-> executeQuery($arrayName = array(':imageName' =>  $imageName , ":id" => $id));
if($db_obj->getConnectionStatus()){
	file_put_contents('upload/'.$imageName, $data);
	print $dummy;
}

?>