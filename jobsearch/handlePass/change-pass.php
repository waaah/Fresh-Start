<?php
require $_SERVER['DOCUMENT_ROOT'] ."/DBConnectionString/dbconnect_class.php";
if(isset($_GET['recovery_code'])&&isset($_GET['email'])&&isset($_GET['accno'])){
	$db_obj = new DatabaseConnection();
	$query = "select * from password_recovery where recovery_code=:code and accno=:accno";
	$db_obj->setQuery($query);
	$parameters = array(
		':code' => $_GET['recovery_code'],
		':accno' => $_GET['accno'] 
	);
	$db_obj->executeQuery($parameters,true);
	$count = $db_obj->returnCount();
	if($count == 0){
		printNull();
	}
	else{
		$_SESSION['parameters_pass'] = array(
			'accno' => $_GET['accno'],
			'email' => $_GET['email'] 
		);
	}
}
else{
	printNull();
}
function printNull(){
	print "Sorry, this page cannot be accessed. Please send a verification before accessing this page.";
	exit();
}
?>
<!DOCTYPE html>
<html>
<head>

	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <script src="/jobsearch/profile/sweetalert2/sweetalert2.min.js"></script>
    <link rel="stylesheet" href="/jobsearch/profile/sweetalert2/sweetalert2.min.css">

	<script type="text/javascript" src="/jobsearch/materialize/js/jquery-3.2.1.js"></script>
	<script type="text/javascript" src="/jobsearch/materialize/js/materialize.min.js"></script>
	<link rel="stylesheet" type="text/css" href="/jobsearch/materialize/css/materialize.css">
	
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.16.0/jquery.validate.min.js"></script>
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.min.js"></script>
    <script type="text/javascript" src="change-pass.js"></script>

	<title>Change Password</title>
	<style type="text/css">
		.card-title{
			font-size: 20px;
			padding: 5px;
			font-weight: bold;
		}
		hr{
			margin-top: 20px;
			margin-bottom: 20px;
			border: 2px #26A69A solid;
		}
		a{
			color: blue;
			display: block;
		}
		.error{
			color: red;
			font-size: 12px;
		}
		input.error{
		    border-bottom: 1px solid #F44336 !important;
		    box-shadow: 0 1px 0 0 #F44336 !important;
		}
	</style>
</head>
<body>
	<div class="container">
		<div class="row">
			<div class="card col s8 offset-s2">
			    <div class="card-content">
			      <p class="card-title">Please enter your new password.</p>
			      <hr>
			      <form class="col m12" id="change-pass">
				      <div class="row">
				        <div class="input-field col m12">
				          <input type="password" name="pass" id="pass" class="validate">
				          <label for="icon_prefix">Password</label>
				        </div>
				        <div class="input-field col m12">
				        	<input type="password" name="conf_pass" id="conf_pass" class="validate">
					        <label for="icon_prefix">Confirm Password</label>
					        <button class="waves-effect waves-light btn" type="submit">Change Password</button>
				        </div>

				      </div>

				   </form>  
			    </div>
			    
		    </div>
		</div>
    </div>
</body>
</html>