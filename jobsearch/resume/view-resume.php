<?php 
	require $_SERVER['DOCUMENT_ROOT'] ."/DBConnectionString/dbconnect_class.php";
	date_default_timezone_set('Asia/Manila');
	$dateTime = new DateTime();
	$date = $dateTime->format("Y-m-d");
	$y = $dateTime->format("Y");
	$m = $dateTime->format("m");
	$d = $dateTime->format("d");
	$time = $dateTime->format("H:i:s");
	$parameters = array(
		':accno' => $_SESSION['accno'], 
	);
	$db_obj = new DatabaseConnection();
	$db_obj->setQuery("select * from resume_views where accno=:accno order by date_viewed DESC,time_viewed DESC");
	$res = $db_obj->executeQuery($parameters,true);
	$cnt = $db_obj->returnCount();
	if($cnt == 0){
		saveView($date,$time,$m,$y,$d);
	}
	else{
		foreach ($res as $row) {
			if($date > $row['date_viewed'] && $time >= $row['time_viewed']){
				saveView($date,$time,$m,$y,$d);
			}
			break;
		}
	}
	function saveView($date,$time,$m,$y,$d){
		$db_obj = new DatabaseConnection();
		$db_obj->setQuery("insert into resume_views values('',:accno,:time_viewed,:date_viewed,:m,:d,:y)");
		$parameters = array(
			':accno' => $_SESSION['accno'], 
			':date_viewed' => $date,
			':time_viewed' => $time,
			':m' => $m,
			':d' => $d,
			':y' => $y
		);
		$db_obj->executeQuery($parameters,true);	
	}
?>