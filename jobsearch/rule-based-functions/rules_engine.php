<?php
	require $_SERVER['DOCUMENT_ROOT'] ."/DBConnectionString/dbconnect_class.php";
	date_default_timezone_set('Asia/Manila');
	class Simulations{
		public function addSimulation($text){
			$this->simulation_text .= $text;
		}
		public function saveSimulation(){
			file_put_contents('SimulationsNew.txt', $this->simulation_text);
		}

	}
	class Rules extends Simulations{
		//if the array separated through comma.
		
		//finds a string based on database data.
		function findIndex($arrayIndex,$searchVal){
			//strips the string of any unneccessary characters
			//$searchVal = preg_replace("~[^a-z0-9 .]~i", "", $searchVal);
			$searchVal = explode(' ', $searchVal);
			$foundAtLeastOne = false;
			$findCount = 0;
			foreach ($searchVal as $word) {
				$found = strpos(strtolower($arrayIndex), strtolower($word)) !== false; 
				if($found){
					$findCount++;
					$foundAtLeastOne = true;
				}		
			} 
				return $foundAtLeastOne;
		}
	}
	class RuleVariableGeneration extends Simulations{
		//gets the variable Rule
		function __construct(){
			$this->simulation_text = "";
		}
		public function getRule($valueIndex,$array,$searchVal){
			return self::generateRule($valueIndex,$array,$searchVal);
		}
		//generate an Rule appropriate for the value entered
		private function generateRule($value,$array,$searchVal){
			$type = substr($array['accno'], 4,3);
			if($type == '112'){
				if($_POST['isCompanySearch'] === 'false'){
					$storage = array(
						'region'=> array(
										  'rule' => 'isEqualRule',
										  'parameters' =>  array('value' => $array['region'] , 'searchVal' => $searchVal )
									),
						'city'  => 	array(
										  'rule' => 'isEqualRule',
										  'parameters' =>  array('value' => $array['city'] , 'searchVal' => $searchVal )
									),
						'salary' => array(
										'rule' => 'rangeRule',
										'parameters' =>  array('min' => $array['min_salary'] ,'max' => $array['max_salary'] , 'searchVal' => $searchVal )
									),
						'employment' => array(
											'rule' => 'employmentRule',
											'parameters' => array('employType' => $array['employ_type'], 'searchVal' => $searchVal)
										),
						'specialization' => array(
										  'rule' => 'searchArray',
										  'parameters' =>  array('value' => $array['spec_job'] , 'searchVal' => $searchVal )
										),
						'job_name' => array(
										  'rule' => 'findIndex',
										  'parameters' =>  array('value' => $array['job_name'] , 'searchVal' => $searchVal )

										),
						'looking_for' => array(
										  'rule' => 'findIndex',
										  'parameters' =>  array('value' => $array['looking_for'] , 'searchVal' => $searchVal )

										),
						'requirements' => array(
										  'rule' => 'findIndex',
										  'parameters' =>  array('value' => $array['requirements'] , 'searchVal' => $searchVal )
										),
						'responsibilities' => array(
										  'rule' => 'findIndex',
										  'parameters' =>  array('value' => $array['responsibilities'] , 'searchVal' => $searchVal )
										)												
					);
				}
				else{
					$storage = array(
						'region'=> array(
										  'rule' => 'isEqualRule',
										  'parameters' =>  array('value' => $array['region'] , 'searchVal' => $searchVal )
									),
						'city'  => 	array(
										  'rule' => 'isEqualRule',
										  'parameters' =>  array('value' => $array['city'] , 'searchVal' => $searchVal )
									),
						'rating' => array(
										'rule' => 'ratingRule',
										'parameters' =>  array('rate' => $array['rate'] , 'searchVal' => $searchVal )
									),
						'company_name' => array(
										  'rule' => 'findIndex',
										  'parameters' =>  array('value' => $array['cname'] , 'searchVal' => $searchVal )
										),
						'specialization' => array(
										  'rule' => 'searchArray',
										  'parameters' =>  array('value' => $array['spec_job'] , 'searchVal' => $searchVal )
										),
					);
				}
			}
			else if($type == '111'){
				$storage = array(
					'app-salary' => array(
										'rule' => 'rangeRule',
										'parameters' => array('min' => $array['salary_range_min'] ,'max' => $array['salary_range_max'] , 'searchVal' => $searchVal )
									),
					'with-exp' => array(
										'rule' => 'experienceRule',
										'parameters' => array('company_name' => $array['company_name'], 'searchVal' => $searchVal)
									),
					'skills' => array(
										  'rule' => 'searchArray',
										  'parameters' =>  array('value' => $array['skill_name'] , 'searchVal' => $searchVal )
									),
					'qualification' => array(
										  'rule' => 'qualification',
										  'parameters' =>  array('value' => $array['quali'] , 'searchVal' => $searchVal )
									),
				    'field-study' => array(
										  'rule' => 'searchArray',
										  'parameters' =>  array('value' => $array['field_name'] , 'searchVal' => $searchVal )
									),
				    'worked_at'=> array(
										  'rule' => 'findIndex',
										  'parameters' =>  array('value' => $array['company_name'] , 'searchVal' => $searchVal )
									),
				    'post_tile'=> array(
										  'rule' => 'findIndex',
										  'parameters' =>  array('value' => $array['position_title'] , 'searchVal' => $searchVal )
									),
				    'role'=> array(
										  'rule' => 'findIndex',
										  'parameters' =>  array('value' => $array['role'] , 'searchVal' => $searchVal )
									),
				    'univ_name'=> array(
										  'rule' => 'findIndex',
										  'parameters' =>  array('value' => $array['univ_name'] , 'searchVal' => $searchVal )
									)

				);

			}
			//return (boolval($rules[$value] ? 'true': 'false');
			return boolval($this->processRule($storage[$value]['rule'],$storage[$value]['parameters'])) ? 'true':'false';
		}
		function issetValueNull(&$mixed)
		{
		    return (isset($mixed)) ? $mixed : '';

		}
		private function processRule($ruleIndex,$parameters){
			$searchVal = $parameters['searchVal'];
			switch($ruleIndex){
				case 'isEqualRule' :
					$value = $parameters['value'];
					$statement = $value === $searchVal ? 1 : 0;
					$this->addSimulation("if($value === $searchVal){ statement = $statement } \r\n\r\n");
					break;
				case 'employmentRule' :
					$employType = $parameters['employType'];
					$statement = ($employType === $searchVal  || $employType === 'Any') ? 1: 0;
			        $this->addSimulation("if($employType === $searchVal || $employType === 'Any'){ statement = $statement} \r\n\r\n");
			        break;
			    case 'rangeRule':
			    	$min = $parameters['min'];
			    	$max = $parameters['max'];
			    	$statement = $searchVal>=$min && $searchVal<=$max ? 1 : 0;
			    	$this->addSimulation("if($searchVal>=$min && $searchVal<=$max){ statement = $statement} \r\n\r\n");
			    	break;
			    case 'experienceRule':
			    	$company_name = $parameters['company_name'];
					$statement =  (!empty($company_name) ? "true" : "false") === $searchVal ? 1: 0;
					$this->addSimulation("if( '$company_name' !== '' ? 'true': 'false') === $searchVal ){ statement = $statement } \r\n\r\n");
					break;
				case 'ratingRule':
					$rate = $parameters['rate']; 
					$statement = $searchVal <= $rate;
					$this->addSimulation("if( $searchVal<=$rate ){ statement = $statement } \r\n\r\n");
					break;

				case 'searchArray':
					$statement = 0;
					$array = $parameters['value'];
					$array_combined = "";
					if(!empty($array)){
							$array_split = explode(',', $array);
							$array_combined = implode(',',$array_split); 
							for($i = 0;$i<count($array_split);$i++){
								if(strpos(strtolower($searchVal),strtolower($array_split[$i]))===0){
									$statement = 1;
									break;
								}
									//1 is equivalent to and 0 is equivalent to true
							}
					}
					$this->addSimulation("if( $searchVal IS IN $array_combined ){ statement = $statement } \r\n\r\n");
					break;
				case 'findIndex':
					$arrayIndex = $parameters['value'];
				    $this->addSimulation("List of items found according to word per word \r\n\r\n");
					$searchVal = explode(' ', $searchVal);
					$foundAtLeastOne = 0;
					$findCount = 0;

					foreach ($searchVal as $word) {
						$reg = "/\b".$word."\b/i";
						$found = preg_match($reg, $arrayIndex) !== 0 ? 1:0; 
						if($found){
							$findCount++;
							$foundAtLeastOne = true;
						}
						$this->addSimulation("if( $word IS IN $arrayIndex ){ statement = $found;foundAtLeastOne = $foundAtLeastOne; } \r\n\r\n");		
					}
					$statement = $foundAtLeastOne;
					$this->addSimulation("End of searching items per word \r\n\r\n");
					break; 
				case 'qualification':
					$val = $parameters['value'];
					/*if( ($searchVal == "Bachelors/College Degree" || $searchVal == "Post Graduate Diploma/Masters Degree" || $searchVal == "Doctorate Degree") &&  ($val == "Bachelors/College Degree" || $val == "Post Graduate Diploma/Masters Degree" || $val == "Doctorate Degree") ){
						$levels = array("Bachelors/College Degree" => 1, "Post Graduate Diploma/Masters Degree" => 2, "Doctorate Degree" => 3);
						//the level of searchVal must be less than or equal to the 
						$statement = $levels[$val] >= $levels[$searchVal] ? 1:0;
						$this->addSimulation("if( $$searchVal IS PRE-REQUISITE OF $val OR $searchVal == $val$("c#all").text(size); ){ statement = $statement; } \r\n\r\n");
					}
					else{
						*/
						$statement = $searchVal == $val;
						$this->addSimulation("if( $$searchVal === $val ){ statement = $statement; } \r\n\r\n");
					//}
					break;
			}
			return $statement; 
		}
			
	}
	function pic($picture){
		if($picture!==''){
			if($_POST['type']==="/jobsearch/applicant_search.php"){
				$url = "/jobsearch/profile/upload/".$picture;
			}
			else if($_POST['type']==="/jobsearch/job_search.php"){
				$url = "/jobsearch/profile/company-logo/".$picture;
			}
		}
		else if($_POST['type']==="/jobsearch/job_search.php"){
			$url = "/jobsearch/img/freshstartlogo.png";
		}
		else if($_POST['type']==="/jobsearch/applicant_search.php"){
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
		$updated = "Last update: ";
		if($num <= 0){
			$diff_in_minutes =  floor(($curr_time - $saved_time)/ 60);
			if($diff_in_minutes>=60){
				$diff_in_minutes = floor($diff_in_minutes/60);
				return $updated .$diff_in_minutes ." hour(s) ago";
			}
			else{
				if($diff_in_minutes > 0){
					return $updated .$diff_in_minutes ." minutes(s) ago";
				}
				else{
					return $updated ."a few minutes ago";
				}
			}
		}
		return $updated .$num ." day(s) ago";
	}
	$db_obj = new DatabaseConnection();
	$custom_rule = new RuleVariableGeneration();

	if($_POST['type']==="/jobsearch/job_search.php"  && $_POST['isCompanySearch'] == 'false'){
		$jobs_display= array();
		$select = "select * from jobs LEFT JOIN employer_tbl ON jobs.accno = employer_tbl.accno INNER JOIN company_table company ON employer_tbl.accno = company.employer_accno ORDER BY date_posted DESC,time_posted DESC";
		$db_obj->setQuery($select);
		$res = $db_obj->executeQuery(array(),true);
		$cnt = $db_obj->returnCount();
		//if the user inputs search parameters
		if(isset($_POST['values'])){
			$values = $_POST['values'];		
			$count_values = count($_POST['values']);
			if($cnt!=0){
				foreach ($res as $jobs) {
					$custom_rule->addSimulation("===== Job Name: ".$jobs['job_name']. " ===== \r\n\r\n");
					//during each first cycle the degree of mismatch is reset.
					$degreeOfMismatch = 0;
					$exact = true;
					//validates if the current data is valid for the rules
					for($row=0;$row<count($values);$row++){
						$filledAllRequirements = $custom_rule->getRule($values[$row][0],$jobs,$values[$row][1]);
						//if not valid it breaks out of the loop.
						if($filledAllRequirements==='false'){
							$degreeOfMismatch++;
							$exact = false;
						}
					}
					$isValid = ($count_values > 1 && $degreeOfMismatch == 1) || $exact;
					$isValid_string = $isValid ? "true":"false";
					//if all search requirements are filled, or if there is only 1 missing element in the search.
					$custom_rule->addSimulation("<b>Number of Mismatches:".$degreeOfMismatch ."</b>\r\n\r\n");
					$custom_rule->addSimulation("<b>Is Data Valid:" .$isValid_string ."</b>\r\n\r\n");
					if($isValid){
						//Pushes an array into the array jobs_display
						$jobs['date_time_posted'] = getDays($jobs['date_posted'],$jobs['time_posted'],$jobs['updated']);
						$jobs['degreeOfMismatch'] = $degreeOfMismatch;
						$jobs['pic'] = pic($jobs['company_pic']);
						array_push($jobs_display,$jobs);
					}					
				}

				$custom_rule->saveSimulation();
				print json_encode($jobs_display);
			}
			else{
				print "No records!";
			}	
		}
		//if the user doesn't input search parameters.
		else{
			foreach ($res as $jobs) {
				$jobs['date_time_posted'] = getDays($jobs['date_posted'],$jobs['time_posted'],$jobs['updated']);
				$jobs['pic'] = pic($jobs['company_pic']);
				array_push($jobs_display,$jobs);
			}
			print json_encode($jobs_display);
		}
	}
	else if($_POST['type']==="/jobsearch/job_search.php" && $_POST['isCompanySearch'] == 'true'){
		$company_display = array();
		$select = "select c.*, Coalesce(CAST(AVG(rating) as DECIMAL(10,2)),0) rate,GROUP_CONCAT(DISTINCT(s.specialization_name)) spec_job, c.employer_accno as accno from company_table c LEFT OUTER JOIN reviews r ON c.employer_accno = r.emp_accno LEFT JOIN company_spec s ON c.employer_accno = s.owner_id GROUP BY c.employer_accno";
		$db_obj->setQuery($select);
		$res = $db_obj->executeQuery(array(),true);
		$cnt = $db_obj->returnCount();
		if(!empty($_POST['values'])){
			$values = $_POST['values'];	
			$count_values = count($_POST['values']);	
			if($cnt!=0){
				//loops through all data in the database.
				foreach ($res as $companies) {
					$custom_rule->addSimulation("===== Company Name: ".$companies['cname']. "=====\r\n");
					//reset parameters on loop
					$degreeOfMismatch = 0;
					$exact = true;
					//end of reset parameters
					for($row=0;$row<count($values);$row++){
						$filledAllRequirements = $custom_rule->getRule($values[$row][0],$companies,$values[$row][1]);
						if($filledAllRequirements==='false'){
							$degreeOfMismatch++;	
							$exact = false;		
						}
					}
					$isValid = ($count_values > 1 && $degreeOfMismatch == 1) || $exact;
					$isValid_string = $isValid ? 1: 0;
					$custom_rule->addSimulation("<b>Number of Mismatches:".$degreeOfMismatch ."</b>\r\n\r\n");
					$custom_rule->addSimulation("<b>Is Data Valid:" .$isValid_string ."</b>\r\n\r\n");
					if( $isValid ){
						$companies['company_pic'] = pic($companies['company_pic']);
						$companies['degreeOfMismatch'] = $degreeOfMismatch;
						$companies['rate'] = round($companies['rate'],2);
						array_push($company_display,$companies);
					}
				}
				$custom_rule->saveSimulation();
				print json_encode($company_display);
			}
			else{
				print "No records!";
			}
		}
		else{
			foreach ($res as $companies){
				$companies['company_pic'] = pic($companies['company_pic']);
				array_push($company_display,$companies);
			}
			print json_encode($company_display);
		}
	}
	else if($_POST['type']==="/jobsearch/applicant_search.php"){
		$applicant_display= array();
		//long query uniting all applicant related tables.
		$select = "Select tbl.*,GROUP_CONCAT(DISTINCT(edu.qualification)) as quali,GROUP_CONCAT(DISTINCT(name)) as skill_name,GROUP_CONCAT(DISTINCT(edu.field_of_study)) as field_name, GROUP_CONCAT(DISTINCT(company_name)) as company_name,GROUP_CONCAT(DISTINCT(role)) as role, GROUP_CONCAT(DISTINCT(position_title)) as position_title,GROUP_CONCAT(DISTINCT(univ_name)) as univ_name  from applicant_tbl tbl
					LEFT JOIN 
						applicant_education edu on tbl.accno = edu.app_id 
					LEFT JOIN 
						applicant_skills sk on tbl.accno = sk.accno
					LEFT JOIN 
						applicant_exp exp on tbl.accno = exp.applicant_id
					LEFT JOIN 
						resume ON resume.accno = tbl.accno
					GROUP BY accno";
		//setting up the database objects
		$db_obj->setQuery($select);
		$res = $db_obj->executeQuery(array(),true);
		$cnt = $db_obj->returnCount();
		if(!empty($_POST['values'])){
			$values = $_POST['values'];		
			$count_values = count($_POST['values']);
			if($cnt!=0){
				//loops through all data in the database.
				foreach ($res as $applicants) {
					//reset parameters on loop
					$degreeOfMismatch = 0;
					$exact = true;
					//end of reset parameters

					$custom_rule->addSimulation("===== Full Name: ".$applicants['lname']. ",".$applicants['fname']."=====\r\n");
					$custom_rule->addSimulation("===== Account Number: ".$applicants['accno']."=====\r\n");
					for($row=0;$row<count($values);$row++){
						$filledAllRequirements = $custom_rule->getRule($values[$row][0],$applicants,$values[$row][1]);
						if($filledAllRequirements==='false'){
							$degreeOfMismatch++;
							$exact = false;
						}
					}
					$isValid = ($count_values > 1 && $degreeOfMismatch == 1) || $exact;
					$isValid_string = ($count_values > 1 && $degreeOfMismatch == 1) || $exact;
					$custom_rule->addSimulation("<b>Number of Mismatches:".$degreeOfMismatch ."</b>\r\n\r\n");
					$custom_rule->addSimulation("<b>Is Data Valid:" .$isValid_string ."</b>\r\n\r\n");
					if($isValid){
						$applicants['pic'] = pic($applicants['pic']);
						if(empty($applicants['skill_name'])){
							$applicants['skill_name'] = "Not yet stated.";
						}
						$applicants['degreeOfMismatch'] = $degreeOfMismatch;	
						array_push($applicant_display,$applicants);
					}
					
				}
				//after loop the data is saved as a simulation
				$custom_rule->saveSimulation();
				print json_encode($applicant_display);
			}
			else{
				print "No records!";
			}
		}
		else{
			foreach ($res as $applicants){
				$applicants['pic'] = pic($applicants['pic']);
				if(empty($applicants['skill_name'])){
					$applicants['skill_name'] = "Not yet stated.";
				}
				array_push($applicant_display,$applicants);
			}
			print json_encode($applicant_display);
		}
	}
	else{
		print "Sorry. Invalid access";
	}
?>