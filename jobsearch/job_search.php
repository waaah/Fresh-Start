<?php
	require $_SERVER['DOCUMENT_ROOT'] ."/DBConnectionString/dbconnect_class.php";
	$db_obj = new DatabaseConnection();
?>
<!DOCTYPE html>
<html>
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- Compiled and minified CSS -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.99.0/css/materialize.min.css">
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="css/search.css">

  <!-- Compiled and minified JavaScript -->
  <script src="js/jquery.min.js"></script>
  <script src="js/jquery.template.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.99.0/js/materialize.min.js"></script>
  <!--Other Javascript -->
  <script src="select-region/regions.js"></script>
  <script src="rule-based-functions/rule-based-search.js"></script>
  <script src="https://www.gstatic.com/firebasejs/4.0.0/firebase.js"></script>	
  <script src="/jobsearch/profile/Like-Request-Chat/js/app.js"></script>
  <script src="Like/like_user.js"></script>

  <!-- Sweet Alert -->
  <script type="text/javascript" src="/jobsearch/profile/sweetalert2/sweetalert2.js"></script>
  <link rel="stylesheet" type="text/css" href="/jobsearch/profile/sweetalert2/sweetalert2.css">
  
  <!--Slider JS-->
  <script src="/jobsearch/slider/wNumb.js"></script>
  <script src="/jobsearch/slider/nouislider.js"></script>
  <link rel="stylesheet" type="text/css" href="/jobsearch/slider/nouislider.css">
  <link rel="stylesheet" href="/jobsearch/view/assets/plugins/font-awesome/css/font-awesome.css">

  <!--End of Slider.JS-->

  <script type="text/javascript">
  	$(function(){
  		$(".button-collapse").sideNav();
  		$('#params_modal').modal();
  		$('.parallax').parallax();
  		$('.tooltip').tooltip({delay: 50});

  	})
  </script>
  <style type="text/css">
  	.results-num{
  		font-weight: bolder;
  		float: right;
  		padding-right:10px;
  		font-size: 16px;
  	}
  </style>
  <title>Search</title>
</head>
<!-- Entire Navigation Bar -->

<!-- End of Navigation Bar -->
<body>
	<nav>
		<div class="nav-wrapper teal">
		  <a href="/jobsearch/" class="brand-logo"><img src="img/searchjob.png" class="logo-navbar"></a>
		  <a href="#" data-activates="mobile-demo" class="button-collapse"><i class="material-icons">menu</i></a>
		  <ul class="right hide-on-med-and-down">
		    <li><a href="/jobsearch/applicant_search.php" class='white-text tooltip' data-position="bottom" data-delay="50" data-tooltip="Look for Applicant"><i class="material-icons">person</i></a></li>
		    <li><a href="/jobsearch/help/faq-template/jf_help.html" class='white-text tooltip' data-position="bottom" data-delay="50" data-tooltip="How to use?"><i class="material-icons">question_answer</i></a></li>
	        <li><a href="/jobsearch/" class='white-text tooltip' data-position="bottom" data-delay="50" data-tooltip="Home"><i class="material-icons">home</i></a></li>
	        <?php 
	        	if(isset($_SESSION['accno'])){
					print "<li><a href='/jobsearch/index.php?logout=true' class='white-text tooltip' data-position='bottom' data-delay='50' data-tooltip='Log Out'><i class='material-icons'>power_settings_new</i></a></li>"; 	        	}
	        ?>
		  </ul>
		  <ul class="side-nav teal white-text" id="mobile-demo">
		  	<li><h4 class="black-text"><img src="img/icon.png" class="icon-navbar"></h4></li>
		  	<hr>
		    <li><a href="" class='white-text'><i class="material-icons">question_answer</i> How to use?</a></li>
	        <li><a href="/jobsearch/" class='white-text'><i class="material-icons">home</i>Home</a></li>
	        <?php 
	        	if(isset($_SESSION['accno'])){
	        		print "<li><a href='/jobsearch/index.php?logout=true' class='white-text'><i class='material-icons'>power_settings_new</i>Log Out</a></li>"; 
	        	}
	        ?>
		  </ul>
		</div>
	</nav>
	<ul class="collapsible filter-box-ul" data-collapsible="accordion" >
	    <li>
	      <div class="collapsible-header"><i class="material-icons">search</i>Additional Filters</div>
	      <div class="collapsible-body" style="background: #f5f5f5 !important;">
	      	<div class="inputbox-padding">
				<div class="row" id="searchbox-params">
					<div class="search-field-with-select">
					    <div class="input-field col m5 s12">
				            <input id="search">
				        </div>
				        <div class="input-field col m5 s12">
					        <select class="search-select" id="search-select">
							    <option value="default" disabled selected>Choose your option</option>
							    <option value="job_name">Job Name</option>
					  			<option value="looking_for">Job Information</option>
					  			<option value="requirements">Requirements</option>
					  			<option value="responsibilities">Responsibilities</option>
							</select>
						</div>
						<div class="input-field col m1 s6">
					       <button class="search-button btn teal waves-effect" style="height: 3rem" id="filter-btn"><center><i class="material-icons left">search</i></center></button>
						</div>
						<div class="input-field col m1 s6">
							<button class="search-button btn red waves-effect" style="height: 3rem" id="reset-filter-btn"><center><i class="material-icons left">replay</i></center></button>
						</div>
					</div>
					<div class="col m12 l4">
						<div class="switch" id="flick-switch">
							<label>Company Search:</label>
							<br>
						    <label>
						      Off
						      <input type="checkbox" id="switch-search-type">
						      <span class="lever"></span>
						      On
						    </label>
						</div>		
					</div>
	        	</div>
        	</div>
           </div>
	    </li>
	</ul>
	<div class="card-container">
		<div class="col s4 l4" id="switch-search">
	    	
		</div>
	  	<div class="row">
	  	  <div class="col l4 search-panel" id="search-panel">
	      	<div class="card-panel">
	      		<div class="card-header">
	      			<h5>Search Parameters:</h5>
	      		</div>
	      		<div class="card-content" id="card-content">
	      		</div>
	      	</div>
	      </div>
	      <div class="results-num">Showing <c id="all"></c> Results</div>
	      <div class="col s12 l8">
	      		<div id="job-container" class="content-xaas">
	      			
	      		</div>
	      		<div class="empty-container">
	      			<div class="exact">

	      			</div>
	      			<div class="relevant">

	      			</div>
	      		</div>
			    <!-- Card Content -->
			   
		        <!-- End of Card Content -->
		        <center>
			        <ul class="pagination" id="pagination">
					    
					</ul>
				</center>
	      </div>
	      
	    </div>
	</div>
	 <div class="fixed-action-btn toolbar toolbar-with-search">
	    <a class="btn-floating btn-large teal">
	      <i class="large material-icons">settings</i>
	    </a>
	    <ul>
	      <li class="waves-effect waves-light pagination_prev"><a><i class="material-icons">arrow_backward</i></a></li>
	      <li class="waves-effect waves-light pagination_next"><a href="#!"><i class="material-icons">arrow_forward</i></a></li>
	      <li class="waves-effect waves-light"><a href="help/faq-template/jf_help.html" target="_blank"><i class="material-icons">help</i></a></li>
	      <li class="waves-effect waves-light trigger-search-modal"><a href="#params_modal"><i class="material-icons">search</i></a></li>
	    </ul>
	  </div>
	  <div class="fixed-action-btn toolbar toolbar-without-search">
	    <a class="btn-floating btn-large teal">
	      <i class="large material-icons">settings</i>
	    </a>
	    <ul>
	      <li class="waves-effect waves-light pagination_prev"><a><i class="material-icons">arrow_backward</i></a></li>
	      <li class="waves-effect waves-light pagination_next"><a href="#!"><i class="material-icons">arrow_forward</i></a></li>
	      <li class="waves-effect waves-light"><a href="help/faq-template/jf_help.html" target="_blank"><i class="material-icons">help</i></a></li>
	    </ul>
	  </div>
		
	<div id="params_modal" class="modal">
		<h5>Search Parameters</h5><hr>
	    <div class="modal-content" id="modal-content">
	      
	    </div>
	    <div class="modal-footer">
	      <button class="modal-action modal-close waves-effect waves-green btn-flat">Close</button>
	    </div>
	</div>
	
</body>

<!-- Search Parameter Template -->
<script id="company-search-params-template" type="text/html">
	<div class="company-search-params">
	    <select class=" filter" id="search_region" name="search_region">
	    </select>
	    <select class=" filter" id="search_city" name="search_city">
	    	<option disabled>Select City</option>			    	
	    </select>
	    <select class=" filter" id="list_of_specializations" placeholder="All Specializations">
	    <option selected="selected" disabled="disabled" hidden>Select a Specialization</option>	
	    <?php
	    	$query = "select * from specialization";				
	    	$db_obj->setQuery($query);
	    	$res = $db_obj->executeQuery(array(),true);
	    	foreach ($res as $row) {
	    		$spec_name = $row['specialization_name'];
	    		print "<option value='$spec_name'>$spec_name</option>";
	    	}
	    ?>		    	
	    </select>
	    <select class="filter" id="rating" name="rating">
	    	<option selected="selected" disabled>Select Minimum Rating</option>
	    	<option value="1">1</option>	
	    	<option value="2">2</option>
	    	<option value="3">3</option>
	    	<option value="4">4</option>
	    	<option value="5">5</option>			    	
	    </select>
	    <button id="clear_filters" name="clear_filters" class=" btn waves-effect waves-light fill button_filter">Clear Filters</button>
	</div>
</script>

<script id="search-params-template" type="text/html">
	<div class="search-params">	
	    <select class=" filter" id="search_region" name="search_region">
	    </select>
	    <select class=" filter" id="search_city" name="search_city">
	    	<option disabled>Select City</option>			    	
	    </select>
	    <select class=" filter" id="list_of_specializations" placeholder="All Specializations">
	    <option selected="selected" disabled="disabled" hidden>Select a Specialization</option>	
	    <?php
	    	$query = "select * from specialization";				
	    	$db_obj->setQuery($query);
	    	$res = $db_obj->executeQuery(array(),true);
	    	foreach ($res as $row) {
	    		$spec_name = $row['specialization_name'];
	    		print "<option value='$spec_name'>$spec_name</option>";
	    	}
	    ?>		    	
	    </select>
	    <select class=" filter" id="employ-type" name="employ-type">
	    	<option selected="selected" disabled="disabled" hidden>Select Employment Type</option>	
	    	<option value="Full Time">Full Time</option>
			<option value="Part Time">Part Time</option>
			<option value="Freelance">Freelance</option>			    	
	    </select>
	    <div class="row">
		    <div class="col s11 m11 l11">
			    <div class="range-label" style="padding: 10px;padding-left: 0">Salary Range</div>
			    <div id="slider" class="slider"></div>
			    <div class="row">
			    	<div class="col s1 m2 l2">
			    		<input type="text" value="P" disabled="true">
			    	</div>
			    	<div class="col s11 m10 l10">
			    		<input class=" filter" name="salary_range_app" id="salary_range" placeholder="Salary Given" type="number">
			    	</div>
				</div>
			</div>
			<div class="col s1 m1 l1">
				<button class="btn-small waves-effect waves-light" id="filter-salary-job"><i class="material-icons left">search</i></button>
			</div>
		</div>
	    <button id="clear_filters" name="clear_filters" class=" btn waves-effect waves-light fill button_filter">Clear Filters</button>
	</div>
</script>

<!-- <script id="company-search-params-template" type="text/html">
	<div class="company-search-params">
	    <select class=" filter" id="search_region" name="search_region">
	    </select>
	    <select class=" filter" id="search_city" name="search_city">
	    	<option disabled>Select City</option>			    	
	    </select>
	    <select class=" filter" id="list_of_specializations" placeholder="All Specializations">
	    <option selected="selected" disabled="disabled" hidden>Select a Specialization</option>	
	    <?php
	    	$query = "select * from specialization";				
	    	$db_obj->setQuery($query);
	    	$res = $db_obj->executeQuery(array(),true);
	    	foreach ($res as $row) {
	    		$spec_name = $row['specialization_name'];
	    		print "<option value='$spec_name'>$spec_name</option>";
	    	}
	    ?>		    	
	    </select>
	       	
	    <button id="clear_filters" name="clear_filters" class=" btn waves-effect waves-light fill button_filter">Clear Filters</button>
	</div>
</script> -->

<!-- Card Template-->
<script id="template" type="text/html">
	<div class="card-panel large-item" id="card-${accno}">
    	<div class="row">
	      <div class="col s12 m2">
	      	<img src="${pic}" class="list-image">
	      </div>
	      <div class="col s12 m6">
	      	<a href="/jobsearch/view/viewjob/job_view.php?job_id=${id}" target="_blank"><h5>${job_name}</h5></a>
	      	<div class="exact-label chip teal white-text">Result Type: ${resultType}</div>
	      	<br><i class="small-text">Posted in: ${date_posted} ${time_posted}</i>
			<p >${looking_for}</p>
	      </div>
	      <div class="col s12 m4">
	      	<div class="button-container">
		      	<button class="waves-effect waves-light btn green fill like" user-id="${accno}" job-id="${id}"><i class="material-icons left">thumb_up</i>Like</button>
		      	<button class="waves-effect waves-light btn red fill ignore" user-id="${accno}" job-id="${id}"><i class="material-icons left">thumb_down</i>Ignore</button>
	      	</div>
	      </div>
	    </div>
    </div>
</script>

<script id="company-template" type="text/html">
	<div class="card-panel large-item" id="card-${accno}">
    	<div class="row">
	      <div class="col s12 m2">
	      	<img src="${company_pic}" class="list-image">
	      </div>
	      <div class="col s12 m6">
	      	<a href="/jobsearch/view/review/reviews.php?code=${accno}" target="_blank"><h5>${cname}</h5></a>
	      	<div class="exact-label chip teal white-text">Result Type: ${resultType}</div>
	      	<br><i class="small-text">Company Rating:<div class="star"></div>${rate}</i>
			<p>${company_overview}</p>
	      </div>
	      <div class="col s12 m4">
	      	<div class="button-container">
		      	<button class="waves-effect waves-light btn green fill like" user-id="${accno}"><i class="material-icons left">thumb_up</i>Like</button>
		      	<button class="waves-effect waves-light btn red fill ignore" user-id="${accno}"><i class="material-icons left">thumb_down</i>Ignore</button>
	      	</div>
	      </div>
	    </div>
    </div>
</script>

<script id="job-extra-params" type="text/html">
    <div class="input-field col m5 s12">
        <input id="search">
    </div>
    <div class="input-field col m5 s12">
        <select class="search-select" id="search-select">
		    <option value="default" disabled selected>Choose your option</option>
		    <option value="job_name">Job Name</option>
  			<option value="looking_for">Job Information</option>
  			<option value="requirements">Requirements</option>
  			<option value="responsibilities">Responsibilities</option>
		</select>
	</div>
	<div class="input-field col m1 s6">
       <button class="search-button btn teal waves-effect" style="height: 3rem" id="filter-btn"><center><i class="material-icons left">search</i></center></button>
	</div>
	<div class="input-field col m1 s6">
		<button class="search-button btn red waves-effect" style="height: 3rem" id="reset-filter-btn"><center><i class="material-icons left">replay</i></center></button>
	</div>
</script>

<script id="company-extra-params" type="text/html">
    <div class="input-field col m10 s12">
        <input id="company-search" placeholder="Enter Company Name">
    </div>
    
	<div class="input-field col m1 s6">
       <button class="search-button btn teal waves-effect" style="height: 3rem" id="company-filter-btn"><center><i class="material-icons left">search</i></center></button>
	</div>
	<div class="input-field col m1 s6">
		<button class="search-button btn red waves-effect" style="height: 3rem" id="reset-filter-btn"><center><i class="material-icons left">replay</i></center></button>
	</div>
</script>

<footer class="page-footer teal">
  <div class="container">
    <div class="row">
      <div class="col l6 s12">
        <h5 class="white-text">Disclaimer</h5>
        <p class="grey-text text-lighten-4">Fresh Start Job Finder is created by the following people. This page is only for educational purposes and will not be polyganized for money.</p>
      </div>
      <div class="col l4 offset-l2 s12">
        <h5 class="white-text">Creators:</h5>
        <ul>
          <li class="white-text">Callanta, Carl Arthell</li>
          <li class="white-text">Co, Joshua</li>
          <li class="white-text">De Guia, Tristan Emerson</li>
          <li class="white-text">Joson, Hannah Andrea Faye</li>
          <li class="white-text">Mercado, John Christian</li>
        </ul>
      </div>
    </div>
  </div>
  <div class="footer-copyright">
    <div class="container">
    © 2017 Fresh Start
    </div>
  </div>
</footer>
</html>