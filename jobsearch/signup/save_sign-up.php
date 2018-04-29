<?php
require $_SERVER['DOCUMENT_ROOT'] ."/DBConnectionString/dbconnect_class.php";

function ageCalculator($date){
	$dateOfBirth = $date;
	$today = date("Y-m-d");
	$diff = date_diff(date_create($dateOfBirth), date_create($today));
	return $diff->format('%y');
}
function encodeJSON($status,$message){
	$arrayName = array('0' => $status, 'message' => $message);
	print json_encode($arrayName);

}
//processes if captcha is empty
if(isset($_POST['captcha']) &&!empty($_POST['captcha'])){
	$_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
	//$secret = '6LfVDB0UAAAAAOcw5X-y7VEc5F195AIfo2ZMyGOV';
	$secret = "6LeJ3TEUAAAAABjvHazc_qJZf0f4YT_2WxFe8xWV";
    //get verify response data
    $verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$secret.'&response='.$_POST['captcha']);
    $responseData = json_decode($verifyResponse);
    //if response data is successful
	if($responseData->success){
		$userDetails = $_POST;
		if($userDetails['pageLocation']=="s_company.php"){
			$insert = "INSERT INTO `temp_employer_tbl` (`accno`, `password`, `fname`, `lname`, `gender`, `age`, `bday`, `cnum`, `email`, `role`, `cname`, `address`, `url`, `pic`, `edate`, `region`, `city`, `company_overview`, `security_code`, `company_email`, `company_number`, `updated`, `sec`) VALUES (:accno, :password,:fname,:lname,:gender,:age,:bday,:cnum, :email,:role,:cname,:c_add,:url,'',:edate,:region, :city,'',:rand,:c_email,:company_num,'No','');";
			$parameters = array(
					':accno' => $userDetails['accno'],
					':password' => $userDetails['password'],
					':fname' => $userDetails['fname'],
					':lname' => $userDetails['lname'],
					':gender'=>$userDetails['gender'],
					':age'=>ageCalculator($userDetails['bday']),
					':bday'=>$userDetails['bday'],
					':cnum'=>$userDetails['company_num'],
					':email' =>$userDetails['email'],
					':role'=>$userDetails['role'],
					':cname' =>$userDetails['cname'],
					':c_add' => $userDetails['address'],
					':url' => $userDetails['url'],
					':edate' => $userDetails['edate'],
					':region' => $userDetails['region'],
					':city' => $userDetails['city'],
					':rand' => substr(str_shuffle(MD5(microtime())), 0, 10),
					':c_email' => $userDetails['company_email'],
					':company_num' => $userDetails['company_num']
				);	
		}
		else if($userDetails['pageLocation']=="s_app.php"){
			$insert = "insert into applicant_tbl (`accno`, `password`, `fname`, `lname`, `gender`, `age`, `description`, `email`, `cnum`, `bday`, `salary_range_min`,`salary_range_max`, `pic`, `job_experience_level`, `security_code`, `address`, `home_phone_number`) values(:accno,:password,:fname,:lname,:gender,:age,:description,:email,:cnum,:bday,:min,:max,'','',:rand,:address,:pnum)";
			$parameters = array(
	            ":accno" => $userDetails['accno'],
	            ":password" =>$userDetails['password'],
	            ':fname' => $userDetails['fname'],
				':lname' => $userDetails['lname'],
	            ":age" => ageCalculator($userDetails['bday']),
	            ":gender" =>$userDetails['gender'],
	            ":bday" => $userDetails['bday'],
	            ":address" => $userDetails['address'],
	            ":email" => $userDetails['email'],
	            ":pnum" => $userDetails['pnum'],
	            ":cnum" => $userDetails['cnum'],
	            ":description" => $userDetails['description'],
	            ':rand' => substr(str_shuffle(MD5(microtime())), 0, 10),
	            ":max" => $userDetails['max'],
	            ":min" => $userDetails['min']
	        );
		} 
		$db_obj = new DatabaseConnection();
		$db_obj->setQuery($insert);
		$db_obj->executeQuery($parameters);
		if($db_obj->getConnectionStatus()){
			$_SESSION['userDetails'] = $parameters;
			encodeJSON(true,"Data has been saved! Please check the verification code on your email address.");
		}

		else{
			encodeJSON(false,$db_obj->getErrorMessage());			
		}
	}
	else{
		encodeJSON(false,'Sorry, there seems to be an error in the captcha. Please refresh the page and try again.');			
	}
	//end of response checking
}
else{
	encodeJSON(false,'Please fill up the captcha first!');
}
//end of empty captcha processing

?>