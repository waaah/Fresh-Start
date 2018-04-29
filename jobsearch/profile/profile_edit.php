<?php
require $_SERVER['DOCUMENT_ROOT'] ."/DBConnectionString/dbconnect_class.php";
if(isset($_GET['action'])){
	$action = $_GET['action'];
	$type_of_field = $_POST['type_of_field'];
	$to_set = '';
	if($action=="update")
	{
		if($type_of_field == "education"){
			$table = "applicant_education";
			//Edit to_set here
		}
		
		echo $table;
		$update="UPDATE $table SET $to_set where accno=''"; 
	}
	else if($action=="delete")
	{
		$id = $_POST['id'];
		$db_obj = new DatabaseConnection();
		if($type_of_field == "job"){
			$con = $db_obj->returnConnection();
			$con->beginTransaction();
			try{
				$db_obj->setQuery("Delete from jobs where id = :id");
				$db_obj->executeQuery(array(":id" => $id),true);
				$db_obj->setQuery("Delete from jobs_security_code where job_id=:id");
				$db_obj->executeQuery(array(":id" => $id),true);
				
				$con->commit();
			}
			catch(Exception $e){
				echo $e;
				$con->rollBack();
			}

		}
		else{
			if($type_of_field == "education"){
				$table = "applicant_education";
				$id_type="id";			
			}
			else if($type_of_field == "skills"){
				$table = "applicant_skills";
				$id_type="id";			
			}
			else if($type_of_field == "certifications"){
				$table = "applicant_seminars";
				$id_type="id";			
			}
			$query = "Delete from ".$table ." where " .$id_type ."=:id";
			$db_obj -> setQuery($query);
			$db_obj -> executeQuery(array(":id" => $id));
			if($db_obj-> getConnectionStatus()){
				echo 1;
			}
			else 
				echo "There is an error in the query\n";
		}
		
		
	}
}
else echo 'error';
?>