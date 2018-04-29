<?php
	require $_SERVER['DOCUMENT_ROOT'] ."/DBConnectionString/dbconnect_class.php";
	$num_tries = 3;
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
    <script type="text/javascript" src="email-verification.js"></script>
    <link rel="stylesheet" type="text/css" href="style.css">
	<title>Send Recovery Email</title>
</head>
<body>
	<nav>
	    <div class="nav-wrapper teal">
			<img src="../img/freshstartlogo.png" width="200px">
	    </div>
	  </nav>
	<div class="container">
		<div class="row">
      		<div class="col s12 m4">
      			<hr>
      			<h3>Recover your password in just three easy steps!</h3>
      			<h5 id="tries">Tries Remaining: <span id="num_tries"><?php print $num_tries; ?></span></h5>
      			<hr>
      		</div>
      		<div class="col s12 m8">
	      		<div class="row">
				<!-- First Card which contains Applicant or Employer -->
					<div class="card col s8 offset-s2" id="card1">
					    <div class="card-content">
					      <p class="card-title">Please specify your user type.</p>
					      <hr>
					      <form class="col m12" id="user-type">
						      <div class="row">
						        <div class="input-field col m12">

						            <select id="sel_user_type" name="sel_user_type">
								      <option value="" disabled selected>Choose your user type</option>
								      <option value="Applicant">Applicant</option>
								      <option value="Employer">Employer</option>
								    </select>
						          	<label>User Type</label>
						          <button class="waves-effect waves-light btn" type="submit">Next</button>
						          <center><a href="../index.php">Back to main page</a></center>
						        </div>

						      </div>

						  </form>  
					    </div>			    
				    </div>
				    <!-- End of First Card -->
				    <!-- Second Card which contains email verification -->
					<div class="card col s8 offset-s2" id="card2">
					    <div class="card-content">
					      <p class="card-title">Please enter your email address here to recover your password.</p>
					      <hr>
					      <form class="col m12" id="user-email">
						      <div class="row">
						        <div class="input-field col m12">
						          <input type="email" name="conf_email" id="conf_email" class="validate">
						          <label for="icon_prefix">Email Address</label>
						          <button class="waves-effect waves-light btn" type="submit">Next</button>
						          <button class="waves-effect waves-light btn previous" type="button">Previous</button>
						          <center><a href="index.php">Back to main page</a></center>
						        </div>

						      </div>

						  </form>  
					    </div>			    
				    </div>
				    <!-- End of Second Card -->
				    <div class="card col s8 offset-s2" id="card3">
					    <div class="card-content">
					      <p class="card-title">Please select one of the question and answer it accordingly. You may only get up to 3 tries. Once you exceeded, you cannot do it again for another 30 minutes.</p>
					      <hr>
					      <form class="col m12" id="send-verification">
						      <div class="row">
						        <div class="input-field col m12">
						            <select id="select-question" name="select_question">
								      <option value="" disabled selected>Choose your question</option>
								    </select>
						          	<label>Question</label>
						        </div>
						        <div class="input-field col m12">
						        	<input type="text" name="conf_answer" id="conf_answer" class="validate">
						          	<label>Answer</label>
						        </div>
						        <button class="waves-effect waves-light btn" type="submit">Confirm Email</button>
						        <button class="waves-effect waves-light btn previous" type="button">Previous</button>
						        <center><a href="index.php">Back to main page</a></center>
						      </div>
					          
						  </form>  
					    </div>			    
				    </div>
				</div>
			</div>
    	</div>
		
    </div>
</body>

</html>