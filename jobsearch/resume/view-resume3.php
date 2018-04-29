<?php
	require $_SERVER['DOCUMENT_ROOT'] ."/DBConnectionString/dbconnect_class.php";
	include("view-resume.php");
	$accno = $_GET['accno'];
	
	if(!isset($_GET['accno'])){
		header("location:/jobsearch/index.php");
	}
	else{
		$parameters = array(':accno' => $accno );
		$new_user_records = new DatabaseFunction();
		$new_user_records -> setQueryandParameters("select * from resume where accno=:accno and resume='resume3'",$parameters);
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

	<meta charset="UTF-8">
    <meta name="description" content="Free Web tutorials">
    <meta name="keywords" content="HTML,CSS,XML,JavaScript">
    <meta name="author" content="Joshua S.Co">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

	<link href="https://fonts.googleapis.com/css?family=Roboto+Condensed" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	<script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
	<script src="jscolor-2.0.4/jscolor.min.js"></script>
	<style type="text/css">
		.resumeBody{
			background-color: white;
			max-width: 800px;
			margin: 0 auto;
			position: relative;
			display: table;
			table-layout: fixed;
			z-index: -2;
		}
		body{
			background-color: #f5f5f5;
			margin: 20px 20px 20px 20px;
			font-family: 'Roboto Condensed', sans serif;

		}
		.leftContent{
			width: 500px;
			padding: 20px 20px 20px 20px;
			position: relative;
			display: table-cell;
			vertical-align:top;

		}
		.rightContent{
			width: 300px;
			background-color: #4CA69D;
			color:white;
			position: relative;
			display: table-cell;
		}
		.profile-pic{
			border-radius: 50%;
			width: 200px; 
			height: 200px;
			margin-left:auto;
			margin-right:auto;
			display: block;
		}	
		.upper_half{
			padding:30px; 
			background-color: #3D8A7E; 
		}
		.lower_half{
			padding: 20px 20px 20px 20px;
		}
		.leftContent h1{
			border-bottom: 2px solid #f5f5f5;
		}
		section > h2{
			background-color: #4CA69D;
			padding:10px 10px 10px 10px;
			margin-left:-20px;
			color: white; 
			margin-top:10px;
			margin-bottom: 10px;
		}
		section h4{
			padding: 0px;
			padding-bottom: 5px;
			padding-top: 5px;
			margin: 0px;
		}
		section{
			text-align: justify;
		}
		progress {
		  background-color: #f5f5f5;
		  border: 0;
		  height: 18px;
		  width: 100%;
		  margin-top: 10px;
		  margin-bottom:10px; 
		}
		progress[value]::-webkit-progress-bar{
			background-color: #f5f5f5;
		}
		progress[value]::-webkit-progress-value{
			background-color: #4CA69D;
		}
		progress[value]::-moz-progress-bar{
			background-color: #4CA69D;	
		}
	</style>
	<style type="text/css">
		.noprintGroup{
			display: relative;
		}
		@page{
			margin: 0;
			margin-right: 0.3cm;
		}
		@page:first{
			margin-top: 0px;
		}
		@media print {
			.noprintSingle,.noprintGroup{
				display: none;
			}
			.resumeBody{
				width: 100%;
				height:auto;
				margin-bottom: none;
			}
			body {-webkit-print-color-adjust: exact;margin: 0;}
			.resumeBody .rightContent{
				margin-top:-40px !important;		

			}
			.leftContent{
				height: 80%;
			}
			progress{
		        page-break-inside: avoid;
		    }
		    section{
		    	page-break-before: auto;
		    	page-break-inside:avoid;
		    	text-align: justify-all;
		    }
		    body{
		    	background-color: white;

		    }
		    
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
	</style>
	<style type="text/css">
		.floating-button{
			padding: 20px;
			border-style: none;
			border-radius: 50%;
			margin-bottom: 20px;
			margin-top: 20px;
			box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2);
			background-color: #4CA69D;
			z-index:200;
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
			display: inline-block;
			overflow: none;

		}
		.fa{
			color: white;
		}
		@media screen and (max-width: 550px){

		}
		@media screen and (max-width: 550px){
			.content{
				margin:20px;
				margin-right: 0px;
			}
			.leftContent{
				display: table-row;
			}
			.rightContent{
				display: table-row;
			}
			

		}
		.edit-info{
			position: relative;
		}
		.noprintGroup{
			position: relative;
		}
		
	</style>
	<script type="text/javascript">
		function printResume(){
			window.print();
		}
		
		$(function(){
			$("#color-picker").on("change",function(){
				//$(".resumeBody").css("color",$(this).val());
			})
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
				$(".resumeBody").css("font-family",$("#font-list option:selected").text())
			})
		})
		function update(jscolor){
			//alert(document.getElementsByClassName('resumeBody').style)
			document.getElementsByClassName('resumeBody')[0].style.color = "#" +jscolor;
		}
		function updateHeaderColor(jscolor){
			//alert(document.getElementsByClassName('resumeBody').style)
			var len = document.getElementsByTagName('h2').length;
			document.getElementsByTagName('h1')[0].style.color = "#" +jscolor;
			for(var i = 0;i < len;i++){
				document.getElementsByTagName('h2')[i].style.color = "#" +jscolor;
			}
		}
		function updateBackColor(jscolor){
			var color =  "#" + jscolor;
			document.getElementsByClassName('rightContent')[0].style.backgroundColor = color;
			document.getElementsByClassName('upper_half')[0].style.backgroundColor = LightenDarkenColor(color,-10);
			var len = document.getElementsByTagName('h2').length;
			for(var i = 0;i < len;i++){
				document.getElementsByTagName('h2')[i].style.backgroundColor = color;
			}

		}
		function LightenDarkenColor(col, amt) {
  
		    var usePound = false;
		  
		    if (col[0] == "#") {
		        col = col.slice(1);
		        usePound = true;
		    }
		 
		    var num = parseInt(col,16);
		 
		    var r = (num >> 16) + amt;
		 
		    if (r > 255) r = 255;
		    else if  (r < 0) r = 0;
		 
		    var b = ((num >> 8) & 0x00FF) + amt;
		 
		    if (b > 255) b = 255;
		    else if  (b < 0) b = 0;
		 
		    var g = (num & 0x0000FF) + amt;
		 
		    if (g > 255) g = 255;
		    else if (g < 0) g = 0;
		 
		    return (usePound?"#":"") + (g | (b << 8) | (r << 16)).toString(16);
		  
		
		}
	</script>
	<title>Resume 3</title>
</head>
<body>
	<div class="noprintGroup">
		<div class="floating-container">
			<button class="floating-button" id="edit-resume"><i class="fa fa-edit fa-2x" aria-hidden="true"></i></button>	
			<button class="floating-button"><i class="fa fa-question-circle fa-2x" aria-hidden="true"></i></button>
			<button class="floating-button" onclick="printResume()"><i class="fa fa-print fa-2x" aria-hidden="true"></i></button>		
		</div>
		<div class="filter-container" style="display: none">
			<div class="filter-element">
				Font Color: <input for="text" id="color-picker" class="jscolor {onFineChange:'update(this)'}" value="000000">
			</div>
			<div class="filter-element">
				Overall Font Size: <input type="number" for="resumeBody" class='change_fontsize'>
			</div>
			<div class="filter-element">
				Header Font Color: <input class="jscolor {onFineChange:'updateHeaderColor(this)'}" value="FFFFFF">
			</div>
			<div class="filter-element">
				Header Font Size: <input type="number" for="header" class='change_fontsize'>
			</div>
			<div class="filter-element">
				Font List: 
				<select id="font-list">
					<option style="font-family: Arial, Helvetica, sans-serif">Arial, Helvetica, sans-serif</option>	
					<option style="font-family: Comic Sans MS, cursive, sans-serif">Comic Sans MS, cursive, sans-serif</option>
					<option style="font-family: Tahoma, Geneva, sans-serif">Tahoma, Geneva, sans-serif</option>
					<option style="font-family: Verdana, Geneva, sans-serif">Verdana, Geneva, sans-serif</option>
				</select>
			</div>
			<div class="filter-element">
				Back Color: <input class="jscolor {onFineChange:'updateBackColor(this)'}" value="4CA69D">
			</div>
		</div>		
	</div>
	<div class="resumeBody" style="border-radius: 2px">
		<div class="rightContent">
			<div class="upper_half">
				<img src="<?php if(!empty($userdata['pic']))print "/jobsearch/profile/upload/".$userdata['pic'];else print "/jobsearch/employee.png";?>" class="profile-pic">
			</div>
			<div class="lower_half">
				<h1><?php print $userdata["fname"] ." " .$userdata["lname"]; ?></h1>
				<p>Address:<?php print $userdata["address"]; ?></p>
				<p>Email Address:<?php print $userdata["email"]; ?></p>
				<p>Phone Number: <?php print $userdata["cnum"]; ?></p>
			</div>
		</div>
		<div class="leftContent">
			<div class="content">
				<h1>My Resume</h1>
				<section class="about-me">
					<h2>About me</h2>
					<?php
						print $userdata["description"];
					?>
				</section>
				<?php
				$new_user_education = new DatabaseFunction();
				$new_user_education-> setQueryandParameters("select * from applicant_education where app_id=:accno",$parameters);
				$education = $new_user_education->getAllData(); 
				$count = count($education);
				?>
				<section class="education">
					<h2>Education</h2>
					<?php
						for($i = 0; $i< $count;$i++){
							print "<h4>".$education[$i]['univ_name'] ."</h4>";
							print $education[$i]['qualification'];
							print"<br>";
							print "Field of Study:".$education[$i]['field_of_study'];
						}
					?>
				</section>
				<?php
				$new_user_seminars = new DatabaseFunction();
				$new_user_seminars-> setQueryandParameters("select * from applicant_seminars where accno=:accno",$parameters);
				$seminars = $new_user_seminars->getAllData(); 
				$count = count($seminars);
				?>
				<?php 
				if($count !=0){
				print '<section name="seminars">';
				print "<h2>Attended Seminars</h2>";
				for($i=0;$i<$count;$i++){
					//code goes here
					print "<h4>".$seminars[$i]['seminar_title']."</h4>";
					print $seminars[$i]["start_date"] ."-" .$seminars[$i]["end_date"];
					print "<br>";
					print $seminars[$i]["location"] ."," .$seminars[$i]["region/city"];
				} 
				print '</section>';
				}
				?>
				<?php
				$new_user_work_exp = new DatabaseFunction();
				$new_user_work_exp->setQueryandParameters("select * from applicant_exp where applicant_id=:accno",$parameters);
				$work_exp = $new_user_work_exp->getAllData(); 
				$count = count($work_exp);
				?>
				<?php 
				if($count !=0){
				print '<section name="work-experience">';
				print "<h2>Work-Experience</h2>";
				for($i=0;$i<$count;$i++){
					//code goes here
					print "<h4>".$work_exp[$i]['company_name']."</h4>";
						print $work_exp[$i]['year_started'] ."-" . $work_exp[$i]['year_ended'];
						
						print "<h4>".$work_exp[$i]['position_title'] ."</h4>";
						print $work_exp[$i]['experience'];
				} 
				print '</section>';
				}
				?>
				<?php
				$new_user_skills = new DatabaseFunction();
				$new_user_skills-> setQueryandParameters("select * from applicant_skills where accno=:accno",$parameters);
				$skills = $new_user_skills->getAllData(); 
				$count = count($skills);
				?>
				<section class="skills">
					<h2>Skills</h2>
					<?php
						for($i = 0; $i< $count;$i++){
							print "<h4>".$skills[$i]['name'] ."</h4>";
							$progress = $skills[$i]['level'] * 20;
							
							print "<progress value='$progress' max='100'></progress>";
						}
					?>
				</section>
			</div>
		</div>
	</div>
</body>
</html>