<?php
	require $_SERVER['DOCUMENT_ROOT'] ."/DBConnectionString/dbconnect_class.php";
	include("resume-info.php");
	$accno = $_GET['accno'];

	if(!isset($_GET['accno'])){
		header("location:/jobsearch/index.php");
	}
	else{
		$parameters = array(':accno' => $accno);
		$new_user_records = new DatabaseFunction();
		$new_user_records -> setQueryandParameters("select * from resume where accno=:accno and resume='resume2'",$parameters);
		$count = count($new_user_records ->getAllData());
		if($count==0){
			print "This resume is not your selected resume. Please try again when you have selected this template as your resume.";	
			exit();	
		}	
	}
	$new_user_records = new DatabaseFunction();
	$new_user_records -> setQueryandParameters("select * from applicant_tbl where accno=:accno",$parameters);
	$userdata = $new_user_records->getRow(1);

?>
<!DOCTYPE html>
<html moznomarginboxes>
<head>
	<link href="https://fonts.googleapis.com/css?family=Ubuntu" rel="stylesheet">

	<meta charset="UTF-8">
    <meta name="description" content="Free Web tutorials">
    <meta name="keywords" content="HTML,CSS,XML,JavaScript">
    <meta name="author" content="Joshua S.Co">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

	<script src="https://code.jquery.com/jquery-3.2.1.js" integrity="sha256-DZAnKJ/6XZ9si04Hgrsxu/8s717jcIzLy3oi35EouyE=" crossorigin="anonymous"></script>
	<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	<script src="jscolor-2.0.4/jscolor.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	<style type="text/css">
		.resume2{
			max-width: 800px;
			background-color: white;
			margin: 0 auto;
			
		}
		body{
			background-color: #f5f5f5;
			font-family: 'Ubuntu', sans-serif;	
		}
		.coverphoto{
			width: 100%;
			height:250px;
		}
		.cover-container{
			position: relative;
		}
		.propic{
			width: 200px;
			height: 200px;
			border-radius: 50%;
			padding: 20px 20px 20px 20px;
			position: absolute;
			margin-left: auto;
			margin-right: auto;
			left: 0;
			right: 0;
			top: 35%;
		}
		.resume-content{
			margin-top:80px;
			font-family: 'Ubuntu', sans-serif;
			margin-left: 20px;
			margin-right: 20px;
			padding-bottom: 20px;
			padding: 50px;
			padding-top: 20px;
		}
		section h2{
			border-bottom: 1.5px solid 	#87CEEB; 
			padding:0;
			margin: 0;
			margin-top: 20px; 
		}
		.splitContent{
			display: table;
			font-size:14px; 
		}
		.leftContent{
			display: table-cell;
			width: 400px;
			padding-right: 20px;
		}
		.rightContent{
			display: table-cell;
			width: 400px;
		}
		progress {
		  background-color: #f5f5f5;
		  border: 0;
		  height: 18px;
		  width: 100%;
		}
		progress[value]::-webkit-progress-bar{
			background-color: #f5f5f5;
		}
		progress[value]::-webkit-progress-value{
			background-color: #87CEEB;
		}
		progress[value]::-moz-progress-bar{
			background-color: #87CEEB;	
		}
		h4{
			margin-bottom: 0px;
		}
		@media print{
			.noprint,.noprintGroup{
				display: none;
			}
			*{
				-webkit-print-color-adjust: exact;
			}
			.resume2{
				width: 100%;
			}
			body{
				background-color: white;
				margin: 0;
			}
			section{
				page-break-inside: avoid;
				padding: 0.5cm 0.5cm 0.5cm 0.5cm;
			}
			.resume-content{
				margin-top: 0.9cm; 
			}
			section.self-info{
				margin-top: 100cm;
			}
		}
		@page{
			padding: 0;
			margin-left: -0.3cm; 
			margin-right: -0.3cm;
			margin-top: 1cm;
		}
		@page:first{ 
			margin-top: -0.5cm;
			
		}
		@-moz-document url-prefix() { 
			  @page{
			  	margin-top: 0;
			  	margin-left: -0.09mm; 
				margin-right: -0.09mm;
			  }

		}
	</style>
	<style type="text/css">
		.floating-button{
			padding: 20px;
			border-style: none;
			border-radius: 50%;
			margin-bottom: 20px;
			margin-top: 20px;
			box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2);
			background-color: #87CEEB;
		}
		.floating-button:focus{
			border: none;
			outline: none;
			
		}
		.floating-button:active{
			transform: translate(3%,3%);
		}
		.floating-container{
			position: fixed;
			bottom:0;
			right:0;
			margin-left: 20px;
			margin-right: 20px;
			margin-top: 5px;
			margin-bottom: 5px;
		}
		.fa{
			color:white;
		}
		.filter-element{
	    	display: block;
	    }
	    .filter-container{
	    	background-color: white;
	    	position: fixed;
	    	display: inline-block;
	    	bottom: 14%;
	    	right:2%;
	    	padding: 20px;
	    	box-shadow: 0px 4px 8px 0px rgba(0,0,0,0.2);
	    	margin-bottom: 20px;
	    	z-index: 20;
		 }
		 
	    .filter-container > .filter-element{
	    	margin: 20px; 

	    }
	    .filter-container > .filter-element > input,select{
	    	border-radius: 2px;
	    	font-size: 15px;
	    	height: 25px;
	    	width:100%;
	    	border-style:none;
	    	border: 1px solid black; 
	    }
	     .filter-container > .filter-element > input:focus{
	    	outline: none;
	    }
		@media screen and (max-width: 850){
			body{
				margin:20px;
			}
		}
		@media screen and (max-width: 550){
			.propic{
				width: 150px;
			    height: 150px;
			}
		}
		.name{
			font-size: 2.3em;
			text-align: center;
		}
		section.self-info{
			margin-top: 20px;
			border-bottom: 1.5px double	#87CEEB; 
			border-top: 1.5px double	#87CEEB; 
			padding-bottom:20px;
		}
	</style>
	<script type="text/javascript">
		function printResume(){
			window.print();
		}
		$(function(){
			
			$("#edit-resume").click(function(){
				$(".filter-container").toggle();
			})
			$(".change_fontsize").on("change",function(){
				var whatFor = $(this).attr("for") 
				var value = parseInt($(this).val());
				if(whatFor == "resumeBody"){
					$(".resume2").css("font-size", value +"px")
				}
				else if(whatFor == "header"){
					$("h1").css("font-size",  (value+1) +"em")
					$("h2").css("font-size",  (value+.5) +"em")
					$("h3").css("font-size",  (value+.17) +"em")
					$("h4").css("font-size",  value +"em")
					$("h5").css("font-size",  (value-.17) +"em")
					$("h6").css("font-size",  (value+.33) +"em")					
				}
			})
			$("#font-list").change(function(){
				$(".resume2").css("font-family",$("#font-list option:selected").text())
			})
		})
		function update(jscolor){
			document.getElementsByClassName('resume2')[0].style.color = "#" +jscolor;
		}
		
		function updateBackColor(jscolor){
			var color =  "#" + jscolor;
			var len = document.getElementsByTagName('h2').length;
			for(var i = 0;i < len;i++){
				document.getElementsByTagName('h2')[i].style.borderBottom = "1.5px solid"+color;
			}
			document.getElementsByClassName('self-info')[0].style.borderBottom = "1.5px solid"+color;
			document.getElementsByClassName('self-info')[0].style.borderTop = "1.5px solid"+color;

		}
		function uploadFunction(){
			if (input.files && input.files[0]) {
            var reader = new FileReader();
            
            reader.onload = function (e) {
                $('.coverphoto').attr('src', e.target.result);
            }
            
            reader.readAsDataURL(input.files[0]);
        	}
        	else{alert("error")}
		}
		$("#imgInp").change(function(){
			readURL(this)
		})
	</script>
	
	<title>Resume 2</title>
</head>
<body>
	<nav class="navbar navbar-default navbar-static-top">
	    <div class="container">
	        <!-- Brand and toggle get grouped for better mobile display -->
	        <div class="navbar-header">
	            <button type="button" data-target="#navbarCollapse" data-toggle="collapse" class="navbar-toggle">
	                <span class="sr-only">Toggle navigation</span>
	                <span class="icon-bar"></span>
	                <span class="icon-bar"></span>
	                <span class="icon-bar"></span>
	            </button>
	            <a href="#" class="navbar-brand"><img src="/jobsearch/img/freshstartlogo.png" class="logo-nav"></a>
	        </div>
	        <!-- Collection of nav links and other content for toggling -->
	        <div id="navbarCollapse" class="collapse navbar-collapse">
	            
	            <ul class="nav navbar-nav navbar-right">
			        <li><a href="/jobsearch/applicant_search.php"><span class="glyphicon glyphicon-home"></span>&nbsp;Home</a>
			        </li>
			        <li><a href=""><span class="glyphicon glyphicon-question-sign"></span>&nbsp;Question</a></li> 
			        <li><a href="/jobsearch/applicant_search.php"><span class="glyphicon glyphicon-search"></span>&nbsp;Back to Applicant Search</a></a></li> 
			        <li><?php
			        	if(isset($_SESSION['accno'])){
			        		print "<li><a href='/jobsearch/index.php?logout=true'><span class='glyphicons glyphicons-power'></span> Log Out</a></li>"; 
			        	}
			         ?></li>
			      </ul>
	        </div>
	    </div>
	</nav>
	<div class="resume2">
		<div class="cover-container">

			<img src="cover.jpg" class="coverphoto">
			
			<img src="<?php if(!empty($userdata['pic']))print "/jobsearch/profile/upload/".$userdata['pic'];else print "/jobsearch/employee.png";?>" class="propic">
		</div>
		
		<div class="resume-content">
			<section class="self-info">
				<h1 class="name"><?php print $userdata['fname'] ." " .$userdata['lname']; ?></h1>
				<?php print $userdata['email']; ?>/
				<?php print $userdata['address']; ?>/
				<?php print $userdata['cnum']; ?>
			</section>

			<?php
				$new_user_exp = new DatabaseFunction();
				$new_user_exp -> setQueryandParameters("select * from applicant_exp where applicant_id=:accno",$parameters);
				$experiences = $new_user_exp -> getAllData();
				$count_experiences = count($experiences);
			?>
			<?php
			if($count_experiences != 0){
				print'
				<section class="past-experiences">
				<h2>Past Work Experiences</h2>';
				$firstRow = ceil($count_experiences/2);
		
				print "<div class='leftContent'>";
				for($i=0;$i<$firstRow;$i++){
					print "<h4>".$experiences[$i]['company_name']."</h4>";
					print $experiences[$i]['year_started'] ."-" . $experiences[$i]['year_ended'];
					
					print "<h4>".$experiences[$i]['position_title'] ."</h4>";
					print $experiences[$i]['experience'];
				} 
				print "</div>";
				if($count_experiences > 1){
					print "<div class='rightContent'>";
					for($i=$firstRow;$i<$count_experiences;$i++){
						print "<h4>".$experiences[$i]['company_name']."</h4>";
						print $experiences[$i]['year_started'] ."-" . $experiences[$i]['year_ended'];
						
						print "<h4>".$experiences[$i]['position_title'] ."</h4>";
						print $experiences[$i]['experience'];
					} 
					print "</div>";
				}
				
				print '</section>';
			}
			?>
			<?php
				$new_user_education = new DatabaseFunction();
				$new_user_education -> setQueryandParameters("select * from applicant_education where app_id=:accno",$parameters);
				$education = $new_user_education -> getAllData();
				$count_education = count($education);	
			?>
			<section class="education">
				<h2>Education</h2>
				<?php
					$firstRow = ceil($count_education/2);
			
					print "<div class='leftContent'>";
					for($i=0;$i<$firstRow;$i++){
						print "<h4>".$education[$i]['univ_name']."</h4>";
						print $education[$i]["qualification"];
						print "<br>";
						print $education[$i]["field_of_study"];
					} 
					print "</div>";
					if($count_education > 1){
						print "<div class='rightContent'>";
						for($i=$firstRow;$i<$count_education;$i++){
							print "<h4>".$education[$i]['univ_name']."</h4>";
							print $education[$i]["qualification"];
							print "<br>";
							print $education[$i]["field_of_study"];
						} 
						print "</div>";
					}
				?>
			</section>
			<?php
				$new_user_skills = new DatabaseFunction();
				$new_user_skills -> setQueryandParameters("select * from applicant_skills where accno=:accno",$parameters);
				$skills = $new_user_skills -> getAllData();
				$count_skills = count($skills);	
			?>
			<section class="skills">
				<h2>Skills</h2>
				<div class="splitContent">
					<?php
						$firstRow = ceil($count_skills/2);
				
						print "<div class='leftContent'>";
						for($i=0;$i<$firstRow;$i++){
							print "<h4>".$skills[$i]['name']."</h4>";
							$prog_val = $skills[$i]['level'] * 20;
							print "<progress value='$prog_val' max='100'></progress>";
						} 
						print "</div>";
						if($count_skills > 1){
							print "<div class='rightContent'>";
							for($i=$firstRow;$i<$count_skills;$i++){
								print "<h4>".$skills[$i]['name']."</h4>";
								$prog_val = $skills[$i]['level'] * 20;
								print "<progress value='$prog_val' max='100'></progress>";
							} 
							print "</div>";
						}
					?>		
				</div>
			</section>
			<?php
				$new_user_seminars = new DatabaseFunction();
				$new_user_seminars -> setQueryandParameters("select * from applicant_seminars where accno=:accno",$parameters);
				$seminars = $new_user_seminars -> getAllData();
				$count_seminars = count($seminars);
			?>
			<?php
			if($count_seminars != 0){
				print'
				<section class="applicant-seminars">
				<h2>My Seminars</h2>';
				$firstRow = ceil($count_seminars/2);
		
				print "<div class='leftContent'>";
				for($i=0;$i<$firstRow;$i++){
					//code goes here
					print "<h4>".$seminars[$i]['seminar_title']."</h4>";
					print $seminars[$i]["start_date"] ."-" .$seminars[$i]["end_date"];
					print "<br>";
					print $seminars[$i]["location"] ."," .$seminars[$i]["region/city"];
				} 
				print "</div>";
				if($count_seminars > 1){
					print "<div class='rightContent'>";
					for($i=$firstRow;$i<$count_seminars;$i++){
						//code goes here
						print "<h4>".$seminars[$i]['seminar_title']."</h4>";
						print $seminars[$i]["start_date"] ."-" .$seminars[$i]["end_date"];
						print "<br>";
						print $seminars[$i]["location"] ."," .$seminars[$i]["region/city"];
					} 
					print "</div>";
				}
				
				print '</section>';
			}
			?>
			<section class="about">
				<h2>About Me</h2>
				<?php print $userdata['description']; ?>
			</section>

		</div>
	</div>
</body>
</html>