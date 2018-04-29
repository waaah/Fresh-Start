<?php
require $_SERVER['DOCUMENT_ROOT'] ."/DBConnectionString/dbconnect_class.php";
date_default_timezone_set('Asia/Manila');
$accno = $_SESSION['accno'];
$_POST  = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);	
$db_obj = new DatabaseConnection();
if(isset($_GET['action'])){
	$action = $_GET['action'];
	if($action == "update_level_experience"){
		$exp = $_POST['exp'];
		$query = "Update applicant_tbl SET job_experience_level=:exp where accno =:accno";
		$db_obj->setQuery($query);
		$db_obj->executeQuery(array(":exp" => $exp , ":accno" => $accno),true);
		//reset to PDO
	}
	if($action == 'save_exp'){
		$pos_title = $_POST['pos_title'];
		$company_name = $_POST['company_name'];
		$start_year = $_POST['start_year'];
		$end_year = $_POST['end_year'];
		$spec = $_POST['spec'];
		$role = $_POST['role'];
		$pos_level = $_POST['pos_level'];
		$salary = $_POST['salary'];
		if(!isset($salary)){
			$salary = "";
		}
		$exp = $_POST['exp'];
		$insert = "Insert into applicant_exp values('',:accno,:pos_title,:company_name,:start_year,:end_year,:spec,:role,:pos_level,:salary,:exp)";
		$parameters = array(
			":accno" => $accno,
			":pos_title" => $pos_title,
			":company_name" => $company_name,
			":start_year" => $start_year,
			":end_year" => $end_year,
			":spec" => $spec,
			":role" => $role,
			":pos_level" => $pos_level,
			":salary" => $salary,
			":exp" => $exp
		);
		$db_obj->setQuery($insert);
		$db_obj->executeQuery($parameters);
		if($res = $db_obj->getConnectionStatus()){
			print "Data has been saved!";
		}
		else{
			print $db_obj->getErrorMessage();
		}
		//reset to PDO
	}
	if($action=='save_job'){
		
		//code for getting the data
		$requirements = $_POST['requirements'];
		$responsibilities = nl2br($_POST['responsibilities']);	
		if(empty(strpbrk($requirements, "aeiou"))==1){
			$requirements = '';
		}
		$date = new DateTime();
		$curr_date = $date->format("Y-m-d");
		$curr_time = $date->format("H:i:s");	
		$rand = substr(str_shuffle(MD5(microtime())), 0, 10);
		//end of getting data
		try{
			$db_obj = new DatabaseConnection();
			$con = $db_obj-> returnConnection();
			$con -> beginTransaction();
			$insert = "Insert into jobs values('',:jobname,:accno,:jobdetails,:employ_type,:min_salary,:max_salary,:requirements,:responsibilities,:spec,:curr_date,:curr_time,'No',1)";
			$parameters = array(
				":jobname" => $_POST['jobname'],
				":accno" => $accno,
				":jobdetails" => $_POST['jobdetails'],
				":employ_type" => $_POST['employ_type'],
				":min_salary" => $_POST['min_salary'],
				":max_salary" => $_POST['max_salary'],
				":requirements" => $requirements,
				":responsibilities" => $responsibilities,
				":spec" => $_POST['spec'],
				":curr_date" => $curr_date,
				":curr_time" => $curr_time
			);
			$db_obj -> setQuery($insert);
			$db_obj -> executeQuery($parameters);
			$last_id = $con -> lastInsertId();
			$db_obj -> setQuery("INSERT INTO jobs_security_code values(:rand,:lastid)");
			$db_obj -> executeQuery($arrayName = array(':rand' => $rand , ":lastid" => $last_id));
			$con ->commit();
			print "Data has been saved!";
		}
		catch(Exception $e){
			echo $e;
			$con->rollBack();
		}
		
	}
	else if($action=="update_e_profile")
	{
		$parameters = array(
			':lname' => $_POST['lname'],
			':fname' => $_POST['fname'],
			':gender' => $_POST['gender'],
			':bday' => $_POST['bday'],
			':cnum' => $_POST['c_num'],
			':age' => $_POST['age'],
			':accno' => $accno
		);
		$query = "update employer_tbl set lname=:lname,fname=:fname,gender=:gender,cnum=:cnum,bday=:bday,age=:age where accno=:accno";
		$db_obj -> setQuery($query);
		$db_obj -> executeQuery($parameters);		
		if($db_obj->getConnectionStatus()){
			print "Data has been saved!";
		}
	}
	else if($action=="save_seminar")
	{
		$location =  $_POST['region'] ."," .$_POST['city'];
        $parameters = array(
        	':accno' => $accno,
        	':seminar_title' => $_POST['seminar_title'],
        	':seminar_start' => $_POST['seminar_start'],
        	':seminar_end' => $_POST['seminar_end'],
        	':seminar_address' => $_POST['seminar_address'],
        	':location' => $location 
        );
        $query = "Insert into applicant_seminars VALUES('',:accno,:seminar_title,:seminar_start,:seminar_end,:seminar_address,:location)";
        $db_obj -> setQuery($query);
		$db_obj -> executeQuery($parameters);		
		if($db_obj->getConnectionStatus()){
			print "Data has been saved!";
		}
	}
	else if($action=="update_e_profile_company")
	{
		try {
			$con = $db_obj->returnConnection();
			$con->beginTransaction();
			$parameters = array(
				':c_name' =>  $_POST['c_name'],
				':c_address' =>  $_POST['c_address'],
				':region' => $_POST['region'],
				':city' => $_POST['city'],
				':edate' => $_POST['e_date'],
				':c_email' => $_POST['c_email'],
				':c_number' => $_POST['c_number'],
				':c_overview' => $_POST['c_overview'],
				":accno" => $accno
			);

			$query = "update company_table set cname=:c_name,address=:c_address,edate=:edate,region=:region,city=:city,company_overview=:c_overview,edate=:edate,company_email=:c_email,company_number=:c_number where employer_accno=:accno";
			$db_obj -> setQuery($query);
			$db_obj -> executeQuery($parameters);	
			$query = "update employer_tbl set role=:role,updated='Yes' where accno=:accno";
			$db_obj -> setQuery($query);
			$parameter = array(':role' => $_POST['role'], ":accno"=>$accno );
			$db_obj -> executeQuery($parameter);		
			$spec = $_POST['select_spec'];
			$delete = "delete from company_spec where owner_id = :accno";
			$db_obj -> setQuery($delete);
			$db_obj -> executeQuery($arrayName = array(':accno' => $accno ));		
			$sql = array(); 
			for($i = 0;$i<count($spec);$i++){
				$sql[] = '('.$accno.', "'.$spec[$i].'")';
			}
			$db_obj -> setQuery('INSERT INTO company_spec VALUES '.implode(',', $sql));
			$db_obj -> executeQuery(array());
			$con->commit();
			print "Data has been saved!";
		} 
		catch (Exception $e) {
			echo $e;
			$con->rollBack();
		}
	
	}
	else if($action=="update_a_profile")
	{
		$parameters = array(
			':lname' => $_POST['lname'],
			':fname' => $_POST['fname'],
			':gender' => $_POST['gender'],
			':bday' => $_POST['bday'],
			':cnum' =>  $_POST['c_num'],
			':min' => $_POST['min_salary'],
			':max' => $_POST['max_salary'],
			':address' => $_POST['address'],
			':home_num' => $_POST['home_num'],
			':age' => $_POST['age'],
			':accno' => $accno,
			':desc' => $_POST['desc']
		);
		$query = "update applicant_tbl set lname=:lname,fname=:fname,gender=:gender,cnum=:cnum,bday=:bday
			,salary_range_min=:min,salary_range_max=:max,age=:age,address=:address,home_phone_number=:home_num,description=:desc where accno=:accno";
		$db_obj->setQuery($query);
		$db_obj->executeQuery($parameters);
		if($db_obj->getConnectionStatus()){
			print "Data has been saved!";
		}
		
	}
	else if($action=="update_seminar"){
		$parameters = array(
			':id' => $_POST['id'],
			':seminar_title' => $_POST['seminar_title'],
	        ':seminar_end' =>  $_POST['seminar_end'],
	        ':seminar_start' =>  $_POST['seminar_start'],
	        ':seminar_address'=>  $_POST['seminar_address'],
	        ':location' => $_POST['region'] ."," .$_POST['city']
	    );
        $query = "update applicant_seminars set seminar_title=:seminar_title, end_date=:seminar_end,start_date=:seminar_start,location=:seminar_address,`region/city`=:location where id=:id";
        $db_obj -> setQuery($query);
        $db_obj-> executeQuery($parameters);
        if($db_obj->getConnectionStatus()){
        	print "Data has been saved!";
        }
        
	}
	else if($action=="update_skills"){
		$parameters = array(
			':proflevel' => $_POST['prof_level'],
			':skill_name' => $_POST['skills'],
			':myaccno' => $_SESSION['accno'],
		);
		$query = "Insert into applicant_skills values('',:myaccno,:skill_name,:proflevel)";
		$res = $db_obj;
        $res -> setQuery($query);
        $res-> executeQuery($parameters);
        if($res->getConnectionStatus()){
        	print "Data has been saved!";
        }
	}
	else if($action=="edit_skills"){
		$parameters = array( 
			':id' => $_POST['id'],
			':proflevel' => $_POST['prof_level'],
			':skill_name' => $_POST['skills'],
		);
		$query = "Update applicant_skills set level=:proflevel, name=:skill_name where id = :id";
		$res = $db_obj;
        $res -> setQuery($query);
        $res-> executeQuery($parameters);
        if($res->getConnectionStatus()){
        	print "Data has been saved!";
        }
	}
	else if($action == "save_education"){	
		if(isset($_POST['quali'])){
			if($_POST['quali'] == "High School Diploma" || $_POST['quali'] == "Elementary School Diploma"){
				$_POST['field_of_study'] = "";
				
				$_POST['major'] = "";
			}
		}
		$parameters = array(						
			':myaccno' => $_SESSION['accno'],
			':quali' => $_POST['quali'],
			':university' => $_POST['university'],
			':field_of_study' => $_POST['field_of_study'],
			':end_year' => $_POST['ed_end_year'],
			':major' => $_POST['major'],
			':start_year' => $_POST['ed_start_year']
		);
		$query = "Insert into applicant_education values('',:myaccno,:university,:quali,:field_of_study,:major,:start_year,:end_year)";
		$res = $db_obj;
        $res -> setQuery($query);
        $res-> executeQuery($parameters);
        if($res->getConnectionStatus()){
        	print "Data has been saved!";
        }
	}
	
	else if($action == "edit_education"){
		$parameters = array(
			':id' => $_POST['id'],		
			':quali' => $_POST['quali'],
			':university' => $_POST['university'],
			':field_of_study' => $_POST['field_of_study'],
			':end_year' => $_POST['ed_end_year'],
			':major' => $_POST['major'],
			':start_year' => $_POST['ed_start_year']
		);
		$query = "Update applicant_education set univ_name = :university, qualification = :quali, major=:major, end_year=:end_year, start_year=:start_year,field_of_study = :field_of_study where id=:id";
		$res = $db_obj;
        $res -> setQuery($query);
        $res-> executeQuery($parameters);
        if($res->getConnectionStatus()){
        	print "Data has been saved!";
        }
	}
	
	else if($action=='edit_jobs'){
		$date = new DateTime();
		$parameters = array(
			':jobname' => trim($_POST['jobname']),
			':jobdetails' => nl2br(trim($_POST['jobdetails'])),
			':min_salary' => $_POST['min_salary'],
			':max_salary' => $_POST['max_salary'],
			':employ_type' => $_POST['employ_type'],
			':spec' => $_POST['spec'],
			':responsibilities' => $_POST['responsibilities'],
			':requirements' => nl2br($_POST['requirements']),
			':id' => $_POST['id'],
			':curr_date' => $date->format("Y-m-d"),
			':curr_time' => $date->format("H:i:s")
		);
		$query ="Update jobs SET job_name=:jobname,looking_for=:jobdetails,min_salary=:min_salary,max_salary=:max_salary,employ_type=:employ_type,spec_job=:spec,responsibilities=:responsibilities,requirements=:requirements,date_posted=:curr_date,time_posted=:curr_time,updated='Yes' where id=:id";
		$res = $db_obj;
        $res -> setQuery($query);
        $res-> executeQuery($parameters);
        if($res->getConnectionStatus()){
        	print "Data has been saved!";
        }
	}
}
else if(isset($_GET['display_what'])){
	$id = $_POST['id'];
	$type_of_table = $_GET['display_what'];
	if($type_of_table == 'job'){
		$query = "select * from jobs where id=:id";
		$db_obj->setQuery($query);
		$res = $db_obj->executeQuery($arrayName = array(':id' => $id ),true);
		foreach ($res as $row) {
			$job_name = $row['job_name'];
			$looking_for = $row['looking_for'];
			$employ_type = $row['employ_type'];
			$min_salary = $row['min_salary'];
			$max_salary = $row['max_salary'];
			$spec = $row['spec_job'];
			$requirements = $row['requirements'];
			$responsibilities = $row['responsibilities'];
		}
		$data = array($job_name,$looking_for,$min_salary,$max_salary,$employ_type,$responsibilities,$spec,$requirements);
	}
	if($type_of_table == "education"){
		$query = "select * from applicant_education where id=:id";
		$db_obj->setQuery($query);
		$res = $db_obj->executeQuery($arrayName = array(':id' => $id ),true);
		foreach ($res as $row) {
			$univ_name = $row['univ_name'];
			$qualification = $row['qualification'];
			$field_of_study= $row['field_of_study'];
			$major = $row['major'];
			$start_year = $row['start_year'];
			$end_year = $row['end_year'];
		}
		$data = array($univ_name,$qualification,$field_of_study,$major,$start_year,$end_year);
	}
	if($type_of_table == "skill"){
		$query = "select * from applicant_skills where id=:id";
		$db_obj->setQuery($query);
		$res = $db_obj->executeQuery($arrayName = array(':id' => $id ),true);
		foreach ($res as $row) {
			$name = $row['name'];
			$level = $row['level'];
		}
		$data = array($name,$level);
	}
	if($type_of_table == "seminar"){
		$query = "select * from applicant_seminars where id=:id";
		$db_obj->setQuery($query);
		$res = $db_obj->executeQuery($arrayName = array(':id' => $id ),true);
		foreach ($res as $row) {	
			$seminar_title = $row['seminar_title'];
			$start_date = $row['start_date'];
			$end_date = $row['end_date'];
			$location = $row['location'];
			$region_city_split= explode(",",$row['region/city']);
		}
		$data = array($seminar_title,$location,$start_date,$end_date,$location,$region_city_split[0],$region_city_split[1]);
	}
	echo json_encode($data);	
}	

?>