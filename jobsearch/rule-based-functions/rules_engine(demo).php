<?php
	include("../dbconnect.php");
	date_default_timezone_set('Asia/Manila');
	class RuleVariableGeneration{
		//gets the variable Rule
		public function getRule($valueIndex,$array,$searchVal){
			return self::generateRule($valueIndex,$array,$searchVal);
		}
		//generate an Rule appropriate for the value entered
		private function generateRule($value,$array,$searchVal){

			$rules = array(
				'city' => ($array['city'] === $searchVal),
				'region' =>(issetValueNull($array['region']) === $searchVal),
				'salary' =>( $searchVal>=issetValueNull($array['min_salary']) && $searchVal<=issetValueNull($array['max_salary']) ),
				'employment' => (issetValueNull($array['employ_type']) === $searchVal  || issetValueNull($array['employ_type']) === 'Any'),
				'specialization' => searchArray($searchVal,issetValueNull($array['spec_job'])),
				'job_name' => findIndex( issetValueNull($array['job_name']), $searchVal ),
				'looking_for' => findIndex( issetValueNull($array['looking_for']) , $searchVal ),
				'requirements' => findIndex( issetValueNull($array['requirements']) , $searchVal ),
				'responsibilities' => findIndex( issetValueNull($array['responsibilities']) , $searchVal ),
				'qualification' => searchArray($searchVal , issetValueNull($array['quali'])),
				'field-study' => searchArray($searchVal , issetValueNull($array['field_name'])),
				'app-salary' => ( $searchVal>=issetValueNull($array['min']) && $searchVal<=issetValueNull($array['max']) ),
				'with-exp' => (boolval(issetValueNull($array['company_name']) !== '')? 'true': 'false') === $searchVal,
				'worked_at' =>  findIndex(issetValueNull($array['company_name']),$searchVal),
				'pos_title' =>  findIndex(issetValueNull($array['position_title']),$searchVal),
				'role' =>  findIndex(issetValueNull($array['role']),$searchVal),
				'skills' => searchArray($searchVal,issetValueNull($array['skill_name'])),
				'univ_name' => findIndex(issetValueNull($array['univ_name']),$searchVal)
			);
			return (boolval($rules[$value]) ? 'true': 'false');
		}
		
		
	}
	function issetValueNull($mixed)
	{
	    return (isset($mixed)) ? $mixed : '';
	}

	function searchArray($searchVal,$array){
		if(!empty($array)){
			$array_split = explode(',', $array);
			for($i = 0;$i<count($array_split);$i++){
				if(strcmp(strtolower($searchVal),strtolower($array_split[$i]))===0)
					return 1;
					//1 is equivalent to and 0 is equivalent to true
			}
			return 0;
		}
	}
	function findIndex($arrayIndex,$searchVal){
		return strpos(strtolower($arrayIndex), strtolower($searchVal)) !== false;
	}	
	function pic($picture){
		if($picture!==''){
			$url = "/jobsearch/profile/upload/".$picture;
		}
		else if($_GET['type']==="/jobsearch/job_search.php"){
			$url = "/jobsearch/employer.png";
		}
		else if($_GET['type']==="/jobsearch/applicant_search.php"){
			$url = "/jobsearch/employee.png";
		}
		return $url;
	}
	function getDays($saved_date,$saved_time,$updated){
		$saved_date = date_create($saved_date);
		$saved_time = strtotime($saved_time);
		$curr_date = date_create();
		$curr_time = strtotime($curr_date -> format("H:i:s"));
		$num = date_diff($curr_date,$saved_date) -> format("%a");
		if($updated ==="Yes"){
			$updated = "Updated ";
		}
		else
			$updated = "Posted ";
		if($num <= 0){
			$diff_in_minutes =  floor(($curr_time - $saved_time)/ 60);
			if($diff_in_minutes>=60){
				$diff_in_minutes = floor($diff_in_minutes/60);
				return $updated .$diff_in_minutes ." hour(s) ago";
			}
			else
				return $updated .$diff_in_minutes ." minutes(s) ago";
		}
		return $updated .$num ." day(s) ago";
	}
	$custom_rule = new RuleVariableGeneration();
	if($_GET['type']==="/jobsearch/job_search.php"){
		$jobs_display= array();
		$select = "select * from jobs LEFT JOIN employer_tbl ON jobs.accno = employer_tbl.accno INNER JOIN jobs_security_code sec on jobs.id = sec.job_id";
		$res = mysql_query($select);
		$cnt = mysql_num_rows($res);
		if(isset($_GET['values'])){
			$values = $_GET['values'];		
			if($cnt!=0){
				while($jobs = mysql_fetch_array($res)){
					for($row=0;$row<count($values);$row++){
						$filledAllRequirements = $custom_rule->getRule($values[$row][0],$jobs,$values[$row][1]);
						if($filledAllRequirements==='false'){
							break;			
						}
					}
					if($filledAllRequirements==='true'){
						//Pushes an array into the array jobs_display
						array_push($jobs_display,array($jobs['job_name'],$jobs['looking_for'],pic($jobs['pic']),getDays($jobs['date_posted'],$jobs['time_posted'],$jobs['updated']),$jobs['cname'],$jobs['security_code'],($jobs['lname'] ." " .$jobs['fname']) ) );
					}
				}
				print json_encode($jobs_display);
			}
			else{
				print "No records!";
			}	
		}
		else{
			while($jobs = mysql_fetch_array($res)){
				array_push($jobs_display,array( $jobs['job_name'], $jobs['looking_for'], pic($jobs['pic']), getDays($jobs['date_posted'],$jobs['time_posted'],$jobs['updated']),$jobs['cname'],$jobs['security_code'],($jobs['lname'] ." " .$jobs['fname']) ) );
			}
			print json_encode($jobs_display);
		}
	}
	else if($_GET['type']==="/jobsearch/applicant_search.php"){
		$applicant_display= array();
		$select = "Select tbl.*,GROUP_CONCAT(DISTINCT(edu.qualification)) as quali,GROUP_CONCAT(DISTINCT(name)) as skill_name,GROUP_CONCAT(DISTINCT(edu.field_of_study)) as field_name, GROUP_CONCAT(DISTINCT(company_name)) as company_name,GROUP_CONCAT(DISTINCT(role)) as role, GROUP_CONCAT(DISTINCT(position_title)) as position_title,GROUP_CONCAT(DISTINCT(univ_name)) as univ_name  from applicant_tbl tbl
					INNER JOIN 
						applicant_education edu on tbl.accno = edu.app_id 
					INNER JOIN 
						applicant_skills sk on tbl.accno = sk.accno
					LEFT JOIN 
						applicant_exp exp on tbl.accno = exp.applicant_id
						GROUP BY accno";
		$res = mysql_query($select);
		$cnt = mysql_num_rows($res);
		if(!empty($_GET['values'])){
			$values = $_GET['values'];		
			if($cnt!=0){
				while($applicants = mysql_fetch_array($res)){
					for($row=0;$row<count($values);$row++){
						$filledAllRequirements = $custom_rule->getRule($values[$row][0],$applicants,$values[$row][1]);
						if($filledAllRequirements==='false'){
							break;			
						}
					}
					if($filledAllRequirements==='true'){
						array_push($applicant_display,array($applicants['fname']." " .$applicants['lname'],$applicants['description'],pic($applicants['pic']),$applicants['security_code'] ) );
					}
				}
				print json_encode($applicant_display);
			}
			else{
				print "No records!";
			}
		}
		else{
			while($applicants = mysql_fetch_array($res)){
				array_push($applicant_display,array($applicants['fname']." " .$applicants['lname'],$applicants['description'],pic($applicants['pic']),$applicants['security_code']));
			}
			print json_encode($applicant_display);
		}
	}
	else{
		print "Sorry. Invalid access";
	}
?>