<?php 
	//the script to send a verification email
	require $_SERVER['DOCUMENT_ROOT'] ."/DBConnectionString/dbconnect_class.php";
	require $_SERVER['DOCUMENT_ROOT'] ."/PHPMailer-master/phpmailer_testing.php";
	$db_obj = new DatabaseConnection();
	try{
		$db_obj->returnConnection()->beginTransaction();
		$userDetails = $_SESSION['userDetails'];
		$data =  json_decode(file_get_contents("php://input")); 
			$questionsArray = $data->questions;
		$questionsCount = count($questionsArray);
		$success = true;
		for ($i=0; $i <	$questionsCount ; $i++) { 
			//insert script
			$db_obj->setQuery("Insert into security_question values('',:accno,:question,:answer)");
			$array = array(
				':accno' =>$userDetails[':accno'],
				':question' => $questionsArray[$i]->question,
				':answer' => $questionsArray[$i]->answer
			);
			$db_obj->executeQuery($array);
			if(!$db_obj->getConnectionStatus()){
				$success = false;
				break;
			}
		}
		$isMessageSent;
		if($success){
			$isMessageSent = sendMessage($userDetails,$db_obj);
			unset($_SESSION['userDetails']);
		}
		$db_obj->returnConnection()->commit();
		if($success == true && $isMessageSent == true){
			print $success;
		}
		else{
			print $isMessageSent;
		}
	}
	catch(Exception $e){
		$db_obj->returnConnection()->rollback();
		print false;
	}
?>