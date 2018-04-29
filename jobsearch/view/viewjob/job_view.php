<?php
	require $_SERVER['DOCUMENT_ROOT'] ."/DBConnectionString/dbconnect_class.php";
	if(isset($_GET['job_id'])){
		$db_obj = new DatabaseConnection();
		$dateTime = new DateTime();
		$date = $dateTime->format("m-d-y");
		$time = $dateTime->format("H:i:s");
		$db_obj->setQuery("Insert into view_job values('',:job_id,:date,:time)");
		$params = array(
			':job_id' => $_GET['job_id'],
			':date' => $date,
			':time' => $time
		);
		$db_obj->executeQuery($params,true);

		$job_id = $_GET['job_id'];
		$select = "select * from jobs 
					INNER JOIN employer_tbl emp ON emp.accno = jobs.accno
					INNER JOIN company_table c ON c.employer_accno = emp.accno
					where jobs.id = :job_id";
		$db_obj->setQuery($select);
		$params = array(
			':job_id' => $job_id
		);
		$res = $db_obj->executeQuery($params,true);
		if($db_obj->returnCount() > 0){
			foreach ($res as $row) {
				$jobname = $row['job_name'];
				$date_posted = $row['date_posted'];
				$time_posted = $row['time_posted'];
				$min = $row['min_salary'];
				$max = $row['max_salary'];
				$desc = $row['looking_for'];
				$req = $row['requirements'];
				$resp = $row['responsibilities'];
				$spec = $row['spec_job'];
				$img = $row['pic'];
				$lname = $row['lname'];
				$fname = $row['fname'];
				$role = $row['role'];
				$cname = $row['cname'];
				$accno = $row['accno'];
			}	
		}
		else{
			print "Invalid Job Id";
		}
				
	}
	else{
		header("location:/jobsearch/index.php");
	}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Profile</title>
	<!-- Compiled and minified CSS -->
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.99.0/css/materialize.min.css">
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	<script src="/jobsearch/js/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.99.0/js/materialize.min.js"></script>
	<!-- Sweet Alert -->
	<script type="text/javascript" src="/jobsearch/profile/sweetalert2/sweetalert2.js"></script>
	<link rel="stylesheet" type="text/css" href="/jobsearch/profile/sweetalert2/sweetalert2.css">
	<script src="https://www.gstatic.com/firebasejs/4.0.0/firebase.js"></script>	
  	<script src="/jobsearch/profile/Like-Request-Chat/js/app.js"></script>
  	<script src="/jobsearch/Like/like_user.js"></script>
	
	<script type="text/javascript">
	$(function(){
		$(".button-collapse").sideNav();
		$('.tooltip').tooltip({delay: 50});
	})
	</script>
	<style type="text/css">
		body{
			background: #f5f5f5;
		}
		.card-padding{
			padding: 20px;
		}
		.leftmost-card{
			float: left;
			margin: 20px;
		}
		@media screen and (max-width: 700px){
			.leftmost-card{
				max-width: 700px !important;
			}
		}
		.bold{
			font-weight: bold;
		}
		.one-card{
			padding: 20px;
		}
		.one-card > .text{
			text-align: justify;
		}
		.fill{
			width: 100%;
			margin-bottom: 10px;
			margin-top: 10px;
		}
		.text{
			font-size: 16px;
		}
		hr.star-light,
		hr.star-primary {
		    margin: 25px auto 30px;
		    padding: 0;
		    border: 0;
		    border-top: solid 5px;
		    text-align: center;
		    color : #4DB6AC;

		}

		hr.star-light:after,
		hr.star-primary:after {
		    content: "\2605";
		    display: inline-block;
		    position: relative;
		    top: -.8em;
		    font-family: FontAwesome;
		    font-size: 2em;
		}

		hr.star-light {
		    border-color: #fff;
		}

		hr.star-light:after {
		    color: #fff;
		    background-color: #18bc9c;
		}

		hr.star-primary {
		    border-color: #2c3e50;
		}

		hr.star-primary:after {
		    color: #2c3e50;
		    background-color: white;
		}
		.top{
			margin:-20px;
			margin-top:-20px;
			padding: 10px;
			margin-bottom: 20px; 
		}
		.above{
			text-align: right;
		}
		.ribbon{
			font-size: 22px;
			position:relative;
			background: #4DB6AC;
			color: #fff;
			font-weight: bold;
			text-align: center;
			margin: 20px;
			padding: 1em 1em; /* Adjust to suit */
		}
		.profile-image{
			border-radius: 50%;
			display: block;
			margin: 0 auto;
		}
		@media screen and (max-width: 720px){
			.leftmost-card{
				width: 93%;
				max-width: 93%;
			}
		}
		h5.name{
			font-size: 17px;
		}
		.icon-navbar{
			width: 150px;
		}
	</style>
</head>
<body class="gray">
	<nav>
	    <div class="nav-wrapper teal">
	      <a href="/jobsearch/" class="brand-logo"><img src="/jobsearch/img/freshstartlogo.png" width="200"></a>
	      <a href="#" data-activates="mobile-demo" class="button-collapse"><i class="material-icons">menu</i></a>
	      <ul class="right hide-on-med-and-down">
	        
	        <li><a href="/jobsearch/job_search.php" class='white-text tooltip' data-position="bottom" data-delay="50" data-tooltip="Return to Job Finder"><i class="material-icons">work</i></a></li>
	        <li><a href="/jobsearch/applicant_search.php" class='white-text tooltip' data-position="bottom" data-delay="50" data-tooltip="Look for Applicant"><i class="material-icons">person</i></a></li>
		    <li><a href="" class='white-text tooltip' data-position="bottom" data-delay="50" data-tooltip="How to use?"><i class="material-icons">question_answer</i></a></li>
	        <li><a href="/jobsearch/" class='white-text tooltip' data-position="bottom" data-delay="50" data-tooltip="Home"><i class="material-icons">home</i></a></li>

	        <?php 
	        	if(isset($_SESSION['accno'])){
	        		print "<li><a href='/jobsearch/index.php?logout=true' class='white-text tooltip' data-position='bottom' data-delay='50' data-tooltip='Logout'><i class='material-icons'>power_settings_new</i></a></li>"; 
	        	}
	        ?>
	        <!-- <li><a href="mobile.html">Mobile</a></li> -->
	      </ul>
	      <ul class="side-nav teal" id="mobile-demo">
	      	<li><h4 class="black-text"><img src="/jobsearch/img/icon.png" class="icon-navbar"></h4></li>
		  	<hr>
	        <li><a href="" class='white-text'>How to use?</a></li>
	        <li><a href="/jobsearch/job_search.php" class='white-text'>Return to Job Finder</a></li>
	        <li><a href="/jobsearch/" class='white-text'>Home</a></li>
	        <?php 
	        	if(isset($_SESSION['accno'])){
	        		print "<li><a href='/jobsearch/index.php?logout=true'><i class='material-icons'>power_settings_new</i>Log Out</a></li>"; 
	        	}
	        ?>
	      </ul>
	    </div>
	</nav>

	<div class="container">

		<div class="card card-padding">
			<div class="teal top">
				<img src="/jobsearch/img/freshstartlogo.png" width="300px;">
			</div>
			<div class="ribbon">
				<?php print $jobname; ?>
			</div>
		    <div class="card-panel teal lighten-2 leftmost-card" style="max-width: 300px;">
		      <img src="
		      <?php
		      	if(isset($pic)){
		      		print '/jobsearch/profile/uploads' .$img;
		      	}
		      	else{
		      		print '/jobsearch/employer.png';
		      	}
		      ?>
		  	  " width="100" class="profile-image">
		      <span class="white-text bold">
		      	<label class="white-text">Poster Name:</label><h5 class="name"> <?php print $fname ." " .$lname; ?></h5>
		      	<label class="white-text">Company Name: </label><h5 class="name"><a href="/jobsearch/view/review/reviews.php?code=<?php print $accno; ?>" class="white-text tooltip" data-position="bottom" data-delay="50" data-tooltip="Go to Company Profile"><?php print $cname; ?></a></h5>
		      <hr>
		      <div class="above">
		    	<ul>
		    		<li><i><b>Date Posted: <?php print $date_posted; ?></b></i></li>
		    		<li><i><b>Job Salary Range: <?php print "P" .$max ." - P" .$min; ?></b></i></li>
		    	</ul>
		      </div>
		      <hr>
		      </span>
		      	<button class="waves-effect waves-light btn green fill like" user-id="<?php print $accno; ?>" job-id="<?php print $job_id; ?>" id="like-job"><i class="material-icons left">thumb_up</i>Like</button>
		      	
		    </div>
		    
		   	<div class="job-description one-card">
		   		<h4>Job Description</h4>
		   		<hr class="star-primary">	
		   		<div class="text">
		   		<?php
		   			print $desc;
		   		?>
		   		</div>
		   	</div>
		   	<div class="requirements one-card">
		   		<h4>Job Requirements</h4>
		   		<hr class="star-primary">	
		   		<div class="text">
		   		<?php 
		   			$req = str_replace(",*", "<br>*", $req);
		   			print $req;
		   		?>
		   		</div>
		   	</div>
		   	<div class="responsibilities one-card">
		   		<h4>Responsiblities</h4>
		   		<hr class="star-primary">	
		   		<div class="text">
		   		<?php
		   			$resp = nl2br($resp);
		   			print $resp;
		   		?>
		   		</div>
		   	</div>
		   	<div class="requirements one-card">
		   		<h4>Specialization</h4>
		   		<hr class="star-primary">	
		   		<div class="text">
		   		<?php
		   			$spec = str_replace(",", "<br>*", $spec);
		   			print "*".$spec; 
		   		?>
		   		</div>
		   	</div>
	    </div>
	</div>
</body>
</html>