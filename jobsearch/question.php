<?php
ob_start();
//include("/jobsearch/dbconnect.php");
if(!isset($_POST['recovery_email'])){
	header("location:/jobsearch/index.php");
}
else{
	$email = $_POST['recovery_email'];
	$email = mysql_real_escape_string($email);
	//use inner join to join tables both and get id and email;
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Password Recovery | Fresh Start</title>
	<script src='https://www.google.com/recaptcha/api.js'></script>
	<style type="text/css">
		body{
			background: url("back3.png") no-repeat center center fixed;
			-webkit-background-size: cover;
			-moz-background-size: cover;
			-o-background-size: cover;
			background-size: cover; 
			font-family: "Century Gothic", CenturyGothic, AppleGothic, sans-serif;
			font-size: 15px;	
			overflow-x:none;

		}
		.question-container{
			background-color: white;
			max-width: 600px;
			height:auto;
			margin:auto;
			transform: translateY(30%);
			padding: 20px 20px 20px 20px;
			padding-top: 5px;
			width:60%;
			left:40px;
		}
		input,select,textarea{
			-webkit-transition: all 0.30s ease-in-out;
		    -moz-transition: all 0.30s ease-in-out;
		    -ms-transition: all 0.30s ease-in-out;
		    -o-transition: all 0.30s ease-in-out;
			font-size: 20px;
			width: 100%;
			display: block;
			margin: 10px 10px 10px 0px;
			height:30px;
			font-size: 15px;
			outline:none;
			font-family: "Century Gothic", CenturyGothic, AppleGothic, sans-serif;

		}
		input:focus,select:focus,textarea:focus{
			box-shadow: 0 0 5px rgba(81, 203, 238, 1);
		    border: 1px solid rgba(81, 203, 238, 1);
		}
		h1{
			font-weight: normal;
		}
		button{
			color:white;
			background-color: #47d147;
			border:none;
			padding:10px;
			font-family: "Century Gothic", CenturyGothic, AppleGothic, sans-serif;
			font-size: 15px;
			margin: 10px 10px 10px 10px;
		}
		.icon-mascot{
			position: absolute;
			height:80%;
			left: -100px;
		}
		.contents_of_div{
			margin-left: 25px;
		}
		
	</style>
</head>
<body>
	<div class="question-container">
		<img src="police_mascot.png" class="icon-mascot">
		<h1>Password Recovery Verification:</h1>
		
		<hr>
		<div class="contents_of_div">
			<form method=post>
				<label>Question: </label>
					<select name="security_question">
						<?php
							
						?>
					</select>
				<label>Answer: </label><input type="text" name="answer">
				<center><div class="g-recaptcha" data-sitekey="6LfVDB0UAAAAAKs0URkru3TETzD2_wpp4lGqArc_" style="transform:scale(0.77);-webkit-transform:scale(0.77);transform-origin:0 0;-webkit-transform-origin:0 0;"></div></center>
				<center>
					<button type="submit" name="submit">Submit</button>
					<button type="reset">Clear</button>
				</center>
			</form>
		<?php
		if(isset($_POST['submit'])){
			if(isset($_POST['g-recaptcha-response'])&&!empty($_POST['g-recaptcha-response'])){

				//your site secret key
		        $secret = '6LfVDB0UAAAAAOcw5X-y7VEc5F195AIfo2ZMyGOV';
		        //get verify response data
		        $verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$secret.'&response='.$_POST['g-recaptcha-response']);
		        $responseData = json_decode($verifyResponse);
		        if($responseData->success){
		        	print "Right Captcha";
		        }
		        else{
		        	print "Wrong Captcha Input";
		        }
			}
			else{
				print "Sorry, You have not clicked our captcha. Try again";
			}
		}
		?>

		</div>
			
	</div>

</body>
</html>