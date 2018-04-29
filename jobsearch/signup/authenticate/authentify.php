<?php
require $_SERVER['DOCUMENT_ROOT'] ."/DBConnectionString/dbconnect_class.php";
if(!isset($_GET['key'])){
	header("location:/jobsearch/");
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Account Authentication</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<!--Start of Materialize.css-->
	<script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
	<!-- Compiled and minified CSS -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.99.0/css/materialize.min.css">
	<!-- Compiled and minified JavaScript -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.99.0/js/materialize.min.js"></script>
    
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">  
    <!--/ End of Materialize.css-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/angular.js/1.6.1/angular.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/angular.js/1.6.1/angular-messages.js" integrity="sha256-T6HnkPMA5Ns5KMNCjniddcOy8fKP73EXnp2qdSYkydM=" crossorigin="anonymous"></script>

    <script src="/jobsearch/sweetalert2/sweetalert2.min.js"></script>
    <link rel="stylesheet" href="/jobsearch/sweetalert2/sweetalert2.min.css">

    <script src="authentify-ctrl.js"></script>
    <link href="animate.css" rel="stylesheet">

    <style type="text/css">
    	#loader{
    		color: white;
    		background: black;
    		position: fixed;
    		width: 100%;
    		height: 100%;
    		padding:20px; 
    	}
    	div[ng-messages]{
    		color: red;
    		font-weight: bold;
    	}
    	#loader > .preloader {
    		text-align: center;
    		position: absolute;
			top: 50%;
			transform: translateY(-50%);
			width: 100%;
    	}
    	.none{
    		display: none;
    	}
    	body{
    		background:#18BB9D;
    		margin:30px;
    	}
    </style>
</head>
<body ng-app="myApp">
	<!--<div id="loader">
		<section class="preloader">
			<center>
			<div class="progress">
		      <div class="indeterminate"></div>
		  	</div>
		  	Please wait page is loading...
		  	</center>
	  	</section>
  	</div>-->

  	
  	<div ng-controller="authentication-controller" >
  		<div class="container animated fadeInUp">
  			<div class="row valign-wrapper">
	  			<div class="col s10 offset-s1 valign">
		  			<div class="card">
		  				<div class="card-content">
		  					<div class="row">
		  						<form name="authenticate" class="col s12" method="post" ng-submit="authentify(authenticate)" novalidate>
		  							<h4><i class="small material-icons left">info_outline</i>Password Verification</h4>
							        <div class="card-panel teal white-text animated" ng-class="{'bounceOut':hidden,'none':none}">
								        <p style="font-weight: bold;">Greetings! Before you can login to your account, you must first enter your password. To validate your registered account, please fill-up the text field below and then press submit. After that, the system will handle the rest.</p>
								        
								        <a class="red waves-light waves-effect btn" ng-click="hideMessage()">Close</a>
							        </div>
								    <div class="row">
								    	<div class="col s12">
								    		<div ng-init="key='<?php print $_GET['key']; ?>'"></div></b>
								    	</div>
								    </div>
		  							<div class="row">
		  								<div class="input-field col s12">
		  									<input id="password"
		  									 type="password"
		  									 name="password"
		  									 class=valid
		  									 ng-model="password" 
		  									 ng-minlength="8"
											 required="true"
											 >
		  									<label for="password">Enter Password</label>
		  									<div ng-messages="authenticate.password.$error">
		  										<div ng-message="minlength">
		  											Password requires minimum of 8 characters.
		  										</div>
		  										<div ng-message="required" ng-hide="authenticate.password.$pristine" ng-show="authenticate.$submitted">
		  											User Password is required.
		  										</div>
		  									</div>
		  								</div>
		  								<div class="input-field col s12">
		  									<input id="conf_password" 
		  									type="password" 
		  									ng-model="conf_password"
		  									name="conf_password"
		  									ng-minlength="8"
											required="true"  									
		  									ng-disabled="!authenticate.password.$valid"
		  									match-field="{{password}}"
		  									ng-class="validateElement(!authenticate.conf_password.$valid)"> 
		  									<label for="conf_password">Confirm Password</label>
		  									<div ng-messages="authenticate.conf_password.$error" ng-hide="authenticate.conf_password.$pristine" ng-show="authenticate.$submitted">
		  										<div ng-message="minlength">
		  											Password requires minimum of 8 characters.
		  										</div>
		  										<div ng-message="required">
		  											Confirm Password is required.
		  										</div>
		  										<div ng-message="matchField">
		  											Both passwords must match.
		  										</div>
		  										
		  									</div>
		  								</div>
		  								<div class="right">
		  									<button class="waves-effect waves-light btn" name="authentify">Submit</button>
		  								</div>
		  							</div>
		  						</form>
		  					</div>
		  				</div>
		  			</div>
	  			</div>
  			</div>
	  	</div>
  	</div>
</body>
<script type="text/javascript">
	/*window.onload = function(){
		setTimeout(function(){
			document.getElementById('loader').className = "animated fadeOutUp";
		},3000);
		
	}*/
	$(function(){
		$('input.validate').focusout(function(){
			$element = $(this);
			if($element.hasClass('ng-invalid')){
				$element.addClass('invalid');
			}
		});
	});
</script>
</html>
<!--<?php
		/*if (isset($_POST['authentify'])) {
			$code = $_GET['key'];
		 	$db_obj = new DatabaseConnection();
		 	$db_obj->setQuery("Update account_verification set isValidated=true where password=:password and verification_code=:code");
		 	$db_obj->executeQuery(array(":password"=>$_POST['pass'], ":code"=>$code));
		 	$count = $db_obj->returnCount();
		 	print ($count > 0) ? 'Data Saved!':'Failed to save. Password Incorrect';
		 } */
	?>-->