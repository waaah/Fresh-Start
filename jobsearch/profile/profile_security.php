<?php
ob_start();
include("dbconnect.php");
//dont mind this file
if(isset($_GET['action'])){
	$action = $_GET['action'];
	if($action=='save_job'||$action =='edit_jobs'){
		$jobname = $_POST['jobname'];
		$jobdetails = $_POST['jobdetails'];
		$min_salary = $_POST['min_salary'];
		$max_salary = $_POST['max_salary'];
		$employ_type = $_POST['employ_type'];
		$jobname_error = '';
		$jobdetails_error = '';
		$salary_error = '';
		if(strlen($jobname) < 10)
			$jobname_error= "*Job Name must be more than 10 characters";
		if(strlen($jobdetails) < 30)
			$jobdetails_error="*Job details must be more than 10 characters";
		if($min_salary >= $max_salary)
			$salary_error.= "*Minimum Salary Cannot be greater than Maximum Salary\n";
		if($min_salary == 0||$max_salary==0)
			$salary_error.= "*Either maximum and minimum salary cannot be zero\n";
		$errors=array($jobname_error,$jobdetails_error,$salary_error);		
	}
	if($action=="update_e_profile")
	{
		$lname = $_POST['lname'];
		$fname = $_POST['fname'];
		$gender = $_POST['gender'];
		$bday = $_POST['bday'];
		$cnum = $_POST['c_num'];
		$email = $_POST['email'];
		$c_name = $_POST['c_name'];
		$c_address = $_POST['c_add'];
		$role = $_POST['role'];
		$fname_error = '';
		$lname_error = '';
		$email_error = '';
		$cnum_error = '';
		$c_name_error = '';
		$c_address_error = '';
		
		if(strlen($fname) < 2)
			$fname_error = "*First Name cannot be less than two characters";
		if(strlen($lname) < 2)
			$lname_error = "*Last Name cannot be less than two characters";
		if(!filter_var($email, FILTER_VALIDATE_EMAIL))
			$email_error = "* Invalid email address try another one";
		if( (strlen($cnum) != 11) || (!ctype_digit($cnum)) || !(substr( $cnum, 0, 2 ) == "09") )
			$cnum_error = "*Cellphone number must be numeric and have a length of 11 charaters(Additional Note:it must start with 09)";
	
		if(strlen($c_name) < 10)
			$c_name_error = "*Company Name cannot be less than ten characters";
		if(strlen($c_address) < 10)
			$c_address_error = "*Company Address cannot be less than ten characters";
		
		$errors=array($fname_error,$lname_error,$email_error,$cnum_error,$c_name_error,$c_address_error);		
	}
	if($action == "update_a_profile"){
		$lname = $_POST['lname'];
		$fname = $_POST['fname'];
		$gender = $_POST['gender'];
		$bday = $_POST['bday'];
		$cnum = $_POST['c_num'];
		$min = $_POST['min_salary'];
		$email = $_POST['email'];
		$fname_error = '';
		$lname_error = '';
		$email_error = '';
		$cnum_error = '';
		$salary_error = '';
		
		if(strlen($fname) < 2)
			$fname_error = "*First Name cannot be less than two characters";
		if(strlen($lname) < 2)
			$lname_error = "*Last Name cannot be less than two characters";
		if(!filter_var($email, FILTER_VALIDATE_EMAIL))
			$email_error = "* Invalid email address try another one";
		if( (strlen($cnum) != 11) || (!ctype_digit($cnum)) || !(substr( $cnum, 0, 2 ) == "09") )
			$cnum_error = "*Cellphone number must be numeric and have a length of 11 charaters(Additional Note:it must start with 09)";
		if($min <= 0)
			$salary_error = "*Expected Salary cannot be 0";
		$errors=array($fname_error,$lname_error,$email_error,$cnum_error,$salary_error);
	}
	if($action=="save_education"){
		$myaccno = $_SESSION['accno'];
		$quali = $_POST['quali'];
		$university = $_POST['university'];
		$course = $_POST['courses'];
		$end_year = $_POST['ed_end_year'];
		$start_year = $_POST['ed_start_year'];
		$year_error = '';
		
		$quali_database = array();
		$index = 0;
	
		$select = "Select * from applicant_education where app_id = '$myaccno'";
		$res = mysql_query($select);
		$count = mysql_num_rows($res);
		if($count != 0){
			while($row = mysql_fetch_array($res))
			{
				$quali_database[$index] = $row['quali'];
				$index+=1;
			}
		}
		if($start_year>=$end_year)
			$year_error = "Start Year cannot be greater than End Year";
		
	}
	echo json_encode($errors);
}
?>