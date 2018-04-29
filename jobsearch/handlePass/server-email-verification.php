<?php 
require $_SERVER['DOCUMENT_ROOT'] ."/DBConnectionString/dbconnect_class.php";
require $_SERVER['DOCUMENT_ROOT'] ."/PHPMailer-master/phpmailer_testing.php";
if(isset($_POST['action'])){
	$action = $_POST['action'];
	if($action == "Set User Type"){
		$_SESSION['rec_utype'] = $_POST['usertype'];
	}
	else if($action == "Set User Email"){
		$_SESSION['rec_email'] = $_POST['email'];
		$utype = $_SESSION['rec_utype'];
		if($utype == "Applicant"){
			$query = "select ques.*,app.email,app.accno from security_question ques INNER JOIN applicant_tbl app ON ques.recipient_accno = app.accno where app.email=:email";
		}
		else if($utype == "Employer"){
			$query = "select ques.*,emp.email,emp.accno from security_question ques INNER JOIN employer_tbl emp ON ques.recipient_accno = emp.accno where emp.email=:email";
		}
		$db_obj = new DatabaseConnection();
		$db_obj->setQuery($query);
		$parameter =  array(
			":email" => $_SESSION['rec_email']
		);
		print json_encode($db_obj->executeQuery($parameter,true));
	}
	else if($action == "Verify Question"){
		$db_obj = new DatabaseConnection();
		$utype = $_SESSION['rec_utype'];
		$email = $_SESSION['rec_email'];
		if($utype == "Applicant"){
			$query = "select * from applicant_tbl where email = :email";
		}
		else if($utype == "Employer"){
			$query = "select * from employer_tbl where email = :email";
		}
		//Sets and Execute Query
		$db_obj-> setQuery($query);
		$parameter = array(":email" => $email);
		$result = $db_obj-> executeQuery($parameter,true);
		//End of Setting and Executing Query
		//Reads Security Questions!
		$db_obj->setQuery("Select * from security_question where question=:question and answer=:answer and recipient_accno=:accno");
		$parameters = array(
			':question' => $_POST['question'],
			':answer' =>  $_POST['answer'],
			':accno' => $result[0]['accno']
		);
		$db_obj->executeQuery($parameters,true);
		print $db_obj->returnCount();
	}
	else if($action == "Validate Email"){
		$sendStatus = sendPasswordRecovery();
		print json_encode($sendStatus);
	}
}
?>