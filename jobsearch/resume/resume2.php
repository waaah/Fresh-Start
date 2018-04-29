<?php
	include("view-resume.php");
	include("resume-info.php");
	$accno = $_SESSION['accno'];

	if(!isset($_SESSION['accno'])){
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
	<script src="https://code.jquery.com/jquery-3.2.1.js" integrity="sha256-DZAnKJ/6XZ9si04Hgrsxu/8s717jcIzLy3oi35EouyE=" crossorigin="anonymous"></script>
	<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	<script src="jscolor-2.0.4/jscolor.min.js"></script>
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
			height:250px;
			background: #87CEEB;
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
			top: 8%;
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
			.coverphoto{
				margin-left: -2cm;
				margin-right: -2cm;
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
			z-index: 999;
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
		.navigation {
		    list-style-type: none;
		    margin: 0;
		    padding: 0;
		    overflow: hidden;
		    background-color: #333;
		    position: fixed;
		    height: 60px;
		    top: 0;
		    left:0;
		    right:0;
		    margin-bottom: 5000px;
		    width: 100%;
		    z-index: 1000;
		}

		.navigation > li {
		    float: left;
		}

		.navigation > li a {
		    display: block;
		    color: white;
		    text-align: center;
		    padding: 20px 20px;
		    text-decoration: none;
		}

		.navigation > li a:hover:not(.active) {
		    background-color: #111;
		}

		.active {
		    background-color: #4CA69D;
		    width: 200px;
		    height: 60px;
		    position: relative;
		    margin-bottom: -1;
		}
		.active:hover{
			background: #338D84;
		}
		.active:hover:after{
			width: 0; 
			content:"";
			position:absolute;
			height:0;
			width:0;
			left:100%;
			top:0;
			border:31px solid transparent;
			border-left: 20px solid #338D84;
		}
		.active:after{
			width: 0; 
			content:"";
			position:absolute;
			height:0;
			width:0;
			left:100%;
			top:0;
			border:31px solid transparent;
			border-left: 20px solid #4CA69D;
		}
		.extrapadding{
			margin-bottom: 100px;
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
	<div class="noprintGroup">
		<ul class="navigation">
		  <li><a class="active" href="/jobsearch/">Home</a></li>
		  
		</ul>
		<div class="extrapadding"></div>
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
				Back Color: <input class="jscolor {onFineChange:'updateBackColor(this)'}" value="87CEEB">
			</div>
		</div>
	</div>
	<div class="resume2">
		<div class="cover-container">

			<div class="coverphoto">
			
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