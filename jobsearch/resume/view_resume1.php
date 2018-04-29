<?php
	require $_SERVER['DOCUMENT_ROOT'] ."/DBConnectionString/dbconnect_class.php";
	include("resume-info.php");
	$accno = $_GET['accno'];
	if(!isset($_GET['accno'])){
		header("location:/jobsearch/index.php");
	}
	else{
		$new_user_records = new DatabaseFunction();
		$parameters = array(':accno' => $accno );
		$new_user_records -> setQueryandParameters("select * from resume where accno=:accno and resume='resume1'",$parameters);
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
	<title>Resume 1</title>

	<meta charset="UTF-8">
    <meta name="description" content="Free Web tutorials">
    <meta name="keywords" content="HTML,CSS,XML,JavaScript">
    <meta name="author" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
	<link href="https://fonts.googleapis.com/css?family=Open+Sans+Condensed:300">
	<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
	<script src="jscolor-2.0.4/jscolor.min.js"></script>
	<script src="https://code.jquery.com/jquery-3.2.1.js" integrity="sha256-DZAnKJ/6XZ9si04Hgrsxu/8s717jcIzLy3oi35EouyE=" crossorigin="anonymous"></script>
	
	<script src="jscolor-2.0.4/jscolor.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<style type="text/css">
		*{
			
			margin:0 auto;
		}
		body{
			margin-top: 20px;
			background-color: #F5F5F5;
			margin-bottom: 20px;
			font-family: 'Open Sans Condensed', sans-serif;
		}
		h1,h2{
			font-family: 'Open Sans Condensed', sans-serif;

		}
		.resume1{
			display: table;
			max-width:800px;
			width: 100%;
			table-layout: fixed;
		}
		#resumeTop{
			background-color: #4CA69D;
			padding: 20px 20px 20px 20px;
			padding-left: 40px;
			padding-right: 40px;
		}
		.pro-pic{
			height:150px;
			width:150px;
		}
		
		.splitContent{
			display: table;

		}
		#resumeBody{
			background-color: white;
			height: auto;
			position: relative;
			max-width: 800px;
			z-index: -2;
			box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2);
			margin-bottom: 20px; 
			padding-bottom: 50px;
			padding-top: 20px;
		}
		.leftSide{
			display: table-cell;
			width: 400px;
			padding:20px;
			padding-top:10px;
			padding-bottom: 10px; 
		}
		.rightSide{
			display: table-cell;
			width: 400px;
			padding:20px; 
			padding-top:10px;
			padding-bottom: 10px; 
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
		@media only print{
			#display-none{display:none;margin: 0;}
			.resume1{display: block;width: 100%}
			
			
			#resumeTop{
				margin: 0;
				margin-left: -1cm;
				margin-right: -1cm;
			}
			.resume1,#resumeBody{
				box-shadow: none;
			}
			body {-webkit-print-color-adjust: exact;background-color: #fff;margin-top: 0 !important}
			@page:first {
	 			margin: 0;
			    margin-top: -10px;
			    margin-bottom: 50px;

			}
			@page{
				margin-left:0;
				margin-right:0; 
				margin-bottom: 50px;
				font-size: 12;		
			}
			@-moz-document url-prefix() { 
			  @page{
			  	margin-top: 0;
			  }
			}
			
		}
		
		.user-pic-div{
			display: table-cell;
			width: 200px;
		}
		.additional-info-div{
			display: table-cell;
			width: 800px;
			vertical-align: top;
			margin-top: 20px;
			color:white;
		}
		.additional-info-div p{
			padding-top:2px;
			padding-bottom: 2px;
		}
		.additional-info-div h1{
			padding-bottom: 5px;
			padding-top: 5px;
		}
	</style>
	<style type="text/css">
		.ribbon {
			 font-size: 16px !important;
			 /* This ribbon is based on a 16px font side and a 24px vertical rhythm. I've used em's to position each element for scalability. If you want to use a different font size you may have to play with the position of the ribbon elements */
			 width: 80%;
			 position: relative;
			 background: #4CA69D;
			 color: #fff;
			 text-align: center;
			 padding: 1em 2em; /* Adjust to suit */
			 margin: 2em auto 1em; /* Based on 24px vertical rhythm. 48px bottom margin - normally 24 but the ribbon 'graphics' take up 24px themselves so we double it. */

		}
		.ribbon:before, .ribbon:after {
			 content: '';
			 position: absolute;
			 display: block;
			 bottom: -1em;
			 border: 1.5em solid #338D84;
			 z-index: -1;

		}
		.ribbon:before {
			 left: -2em;
			 border-right-width: 1.5em;
			 border-left-color: transparent;
		}
		.ribbon:after {
			 right: -2em;
			 border-left-width: 1.5em;
			 border-right-color: transparent;
		}
		.ribbon .ribbon-content:before, .ribbon .ribbon-content:after {
			 content: "";
			 position: absolute;
			 display: block;
			 border-style: solid;
			 border-color: #19736A transparent transparent transparent;
			 bottom: -1em;
		}
		.ribbon .ribbon-content:before {
			 left: 0;
			 border-width: 1em 0 0 1em;
		}
		.ribbon .ribbon-content:after {
			 right: 0;
			 border-width: 1em 1em 0 0;
		}
		.info-container{
			padding: 0.6em 4.2em;
			text-align: justify;
			white-space: pre-line;
		}
		.main{
			font-weight: bold;
		}	
	</style>
	<style type="text/css">
		progress {
		  background-color: #f5f5f5;
		  border: 0;
		  height: 18px;
		  border-radius: 9px;
		  width: 100%;
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
		.head{
			padding:0;
			display: inline;
		}
		.work-experience-part{
			display: inline-block;
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
		
		@media screen and (max-width: 700px){
			.ribbon{
				width: 60%;
			}
			
		}
		@media screen and (max-width: 480px){
			
			.ribbon{
				width: 60%;
			}
		}
		@media screen and (max-width: 800px){
			body{
				margin-left: 20px; 
				margin-right: 20px;
			}

		}
		.fa{
			color: white
		}
		.logo-nav{
			max-width: 150px;
			height: 50px;
			margin-top: -0.5em;
		}
		.navbar{
			padding: 5px;
			background: #4CA69D;
			border-radius: none;
			margin: -1.5em;
			margin-bottom: 2em;
		}
		.navbar-default .navbar-nav>li>a{
			color:white;
		}
	</style>
	<style type="text/css" id="rewritable"></style>
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
	<div class="resume1">
		<section id="resumeTop">
			<div class="user-pic-div">
				<img src="<?php if(!empty($userdata['pic']))print "/jobsearch/profile/upload/".$userdata['pic'];else print "/jobsearch/employee.png";?>" class="pro-pic" style="border-radius: 50%">
			</div>
			<div class="additional-info-div">
				<h1><?php print $userdata['fname'] ." " .$userdata["lname"]; ?></h1>
				<p>Address: <?php print $userdata['address']; ?></p>
				<p>Email Address: <?php print $userdata['email'] ?></p>
				<p>Phone Number: <?php print $userdata['cnum'] ?></p>
			</div>
		</section>
		<section id="resumeBody">
			<section id="general-info">
				<section name="aboutme">
					<h1 class="ribbon">
						<strong class="ribbon-content">About Me</strong>
					</h1>
					<div class="info-container">
						<?php print $userdata['description']; ?>
					</div>	
				</section>
				<?php
					$new_user_education = new DatabaseFunction();
					$new_user_education -> setQueryandParameters("select * from applicant_education where app_id=:accno",$parameters);
					$education = $new_user_education -> getAllData();
					$count_education = count($education);	
				?>
				<section name="education">
					<h1 class="ribbon">
						<strong class="ribbon-content">Education</strong>
					</h1>
					<div class="info-container splitContent">
						<?php
							$firstRow = ceil($count_education/2);
					
							print "<div class='leftSide'>";
							for($i=0;$i<$firstRow;$i++){
								print "<h4>".$education[$i]['univ_name']."</h4>";
								print $education[$i]["qualification"];
								print "<br>";
								print $education[$i]["field_of_study"];
							} 
							print "</div>";
							if($count_education > 1){
								print "<div class='rightSide'>";
								for($i=$firstRow;$i<$count_education;$i++){
									print "<h4>".$education[$i]['univ_name']."</h4>";
									print $education[$i]["qualification"];
									print "<br>";
									print $education[$i]["field_of_study"];
								} 
								print "</div>";
							}
						?>
					</div>
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
					<section name="prev_experience">
					<h1 class="ribbon">
						<strong class="ribbon-content">Previous Job Experience</strong>
					</h1>';
					$firstRow = ceil($count_experiences/2);
					print "<div class='info-container splitContent'>";
						print "<div class='leftSide'>";
						for($i=0;$i<$firstRow;$i++){
							print "<h4>".$experiences[$i]['company_name']."</h4>";
							print $experiences[$i]['year_started'] ."-" . $experiences[$i]['year_ended'];
							
							print "<h4>".$experiences[$i]['position_title'] ."</h4>";
							print $experiences[$i]['experience'];
						} 
						print "</div>";
						if($count_experiences > 1){
							print "<div class='rightSide'>";
							for($i=$firstRow;$i<$count_experiences;$i++){
								print "<h4>".$experiences[$i]['company_name']."</h4>";
								print $experiences[$i]['year_started'] ."-" . $experiences[$i]['year_ended'];
								
								print "<h4>".$experiences[$i]['position_title'] ."</h4>";
								print $experiences[$i]['experience'];
							} 
							print "</div>";
						}	
					print "</div>";
					print '</section>';
				}
				?>
						
			</section>
			<?php
				$new_user_skills = new DatabaseFunction();
				$new_user_skills -> setQueryandParameters("select * from applicant_skills where accno=:accno",$parameters);
				$skills = $new_user_skills -> getAllData();
				$count_skills = count($skills);	
			?>
			<section id="other-info">
				<h1 class="ribbon">
					<strong class="ribbon-content">Skills</strong>
				</h1>
				<div class="info-container splitContent">
					<?php
						$firstRow = ceil($count_skills/2);
				
						print "<div class='leftSide'>";
						for($i=0;$i<$firstRow;$i++){
							print "<h4>".$skills[$i]['name']."</h4>";
							$prog_val = $skills[$i]['level'] * 20;
							print "<progress value='$prog_val' max='100'></progress>";
						} 
						print "</div>";
						if($count_skills > 1){
							print "<div class='rightSide'>";
							for($i=$firstRow;$i<$count_skills;$i++){
								print "<h4>".$skills[$i]['name']."</h4>";
								$prog_val = $skills[$i]['level'] * 20;
								print "<progress value='$prog_val' max='100'></progress>";
							} 
							print "</div>";
						}
					?>
				</div>
				<?php
					$new_user_seminars = new DatabaseFunction();
					$new_user_seminars-> setQueryandParameters("select * from applicant_seminars where accno=:accno",$parameters);
					$seminars = $new_user_seminars->getAllData(); 
					$count_seminars = count($seminars);
				?>
				<?php
				if($count!=0){
				print '<h1 class="ribbon">
					<strong class="ribbon-content">Seminars Attended</strong>
				</h1>';
				print '<div class="info-container splitContent">';
					print "<div class='leftSide'>";
					for($i=0;$i<$firstRow;$i++){
						//code goes here
						print "<h4>".$seminars[$i]['seminar_title']."</h4>";
						print $seminars[$i]["start_date"] ."-" .$seminars[$i]["end_date"];
						print "<br>";
						print $seminars[$i]["location"] ."," .$seminars[$i]["region/city"];
					} 
					print "</div>";
					if($count_seminars > 1){
						print "<div class='rightSide'>";
						for($i=$firstRow;$i<$count_seminars;$i++){
							//code goes here
							print "<h4>".$seminars[$i]['seminar_title']."</h4>";
							print $seminars[$i]["start_date"] ."-" .$seminars[$i]["end_date"];
							print "<br>";
							print $seminars[$i]["location"] ."," .$seminars[$i]["region/city"];
						} 
						print "</div>";
					}        
				print "</div>";
				}
				?>
			</section>
		</section>
	</div>

	<script type="text/javascript">
		function printPage(){
			window.print()
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
				$(".resume1").css("font-family",$("#font-list option:selected").text())
			})
		})
		function update(jscolor){
			//alert(document.getElementsByClassName('resumeBody').style)
			document.getElementById('resumeBody').style.color = "#" +jscolor;
		}
		function updateHeaderColor(jscolor){
			document.getElementsByClassName('additional-info-div')[0].style.color = "#" +jscolor;
			var len = document.getElementsByTagName('h1').length;
			for(var i = 0;i < len;i++){
				document.getElementsByTagName('h1')[i].style.color = "#" +jscolor;
			}
		}
		function updateBackColor(jscolor){
			var color =  "#" + jscolor;
			document.getElementById('resumeTop').style.backgroundColor = color;

			//document.getElementsByClassName('upper_half')[0].style.backgroundColor = LightenDarkenColor(color,-10);
			var len = document.getElementsByClassName('ribbon').length;
			for(var i = 0;i < len;i++){
				document.getElementsByClassName('ribbon')[i].style.backgroundColor = color;
			}
			document.getElementById('rewritable').innerHTML = ".ribbon:before, .ribbon:after {border: 1.5em solid"+ LightenDarkenColor(color,-10)+"}.ribbon:before{border-left-color: transparent;}.ribbon:after{border-right-color: transparent;}.ribbon .ribbon-content:before, .ribbon .ribbon-content:after {content: '';position: absolute;display: block;border-style: solid;border-color:"+LightenDarkenColor(color,-20)+" transparent transparent transparent;bottom: -1em;}";

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
</body>
</html>