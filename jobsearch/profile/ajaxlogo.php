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

$query = "select company_pic from company_table where employer_accno = :id";
$db_obj = new DatabaseConnection();
$db_obj -> setQuery($query);
$res = $db_obj -> executeQuery(array(":id" => $id), true);
$cnt = $db_obj -> returnCount();
if($cnt!=0){
	foreach ($res as $row) {
		$fileName = $row['company_pic'];		
	}
	if(!empty($fileName))
		unlink("company-logo/$fileName");	
}	

$update = "update company_table SET company_pic=:imageName where employer_accno=:id";
$db_obj-> setQuery($update);
$db_obj-> executeQuery($arrayName = array(':imageName' =>  $imageName , ":id" => $id));
if($db_obj->getConnectionStatus()){
	file_put_contents('company-logo/'.$imageName, $data);
	print $dummy;
}

?>