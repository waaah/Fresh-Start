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
  
  <!--Other Necessary Javascript -->
  <script src="select-region/regions.js"></script>
  <script src="https://www.gstatic.com/firebasejs/4.0.0/firebase.js"></script>
  <script src="rule-based-functions/rule-based-search.js"></script>
  <script src="/jobsearch/profile/Like-Request-Chat/js/app.js"></script>
  <script src="Like/like_user.js"></script>

  <!-- Sweet Alert -->
  <script type="text/javascript" src="/jobsearch/profile/sweetalert2/sweetalert2.js"></script>
  <link rel="stylesheet" type="text/css" href="/jobsearch/profile/sweetalert2/sweetalert2.css">
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

  <!--Slider JS-->
  <script src="/jobsearch/slider/wNumb.js"></script>
  <script src="/jobsearch/slider/nouislider.js"></script>
  <link rel="stylesheet" type="text/css" href="/jobsearch/slider/nouislider.css">

  <script type="text/javascript">
  	$(function(){
  		$(".button-collapse").sideNav();
  		$('#params_modal').modal();
  		$('.parallax').parallax();
  		$('select').material_select();
  		$('.tooltip').tooltip({delay: 50});

  	})
  </script>
  
  <title>Search</title>
</head>
<!-- Entire Navigation Bar -->

<!-- End of Navigation Bar -->
<body>
	<nav>
		<div class="nav-wrapper blue">
		  <a href="/jobsearch/" class="brand-logo"><img src="img/applisearch.png" class="logo-navbar"></a>
		  <a href="#" data-activates="mobile-demo" class="button-collapse"><i class="material-icons">menu</i></a>
		  <ul class="right hide-on-med-and-down">
		  	<li><a href="/jobsearch/job_search.php" class='white-text tooltip' data-position="bottom" data-delay="50" data-tooltip="Find Job"><i class="material-icons">work</i></a></li>
		    <li><a href="/jobsearch/help/faq-template/af_help.html" class='white-text tooltip' data-position="bottom" data-delay="50" data-tooltip="How to use?"><i class="material-icons">question_answer</i></a></li>
	        <li><a href="/jobsearch/" class='white-text tooltip' data-position="bottom" data-delay="50" data-tooltip="Home"><i class="material-icons">home</i></a></li>

	        <?php 
	        	if(isset($_SESSION['accno'])){
	        		print "<li><a href='/jobsearch/index.php?logout=true' class='white-text tooltip' data-position='bottom' data-delay='50' data-tooltip='Logout'><i class='material-icons'>power_settings_new</i></a></li>"; 
	        	}
	        ?>
		  </ul>
		  <ul class="side-nav blue white-text" id="mobile-demo">
		  	<li><h4 class="black-text"><img src="img/icon.png" class="icon-navbar"></h4></li>
		  	<hr>
		  	<li><a href="/jobsearch/help/faq-template/af_help.html" class='white-text'><i class="material-icons">question_answer</i>&nbsp;How to use?</a></li>
	        <li><a href="/jobsearch/" class='white-text'><i class="material-icons">home</i>&nbsp;Home</a></li>
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
				<div class="row">
				    <div class="input-field col m5 s12">
			            <input id="search">
			        </div>
			        <div class="input-field col m5 s12">
				        <select id="search-select" class="form-control" placeholder="Keyword Search..." type="text">
				        	<option disabled selected>Search Options</option>
				  			<option value="univ_name">University Name</option>
				  			<option value="worked_at">Worked At</option>
				  			<option value="pos_title">Position Title</option>
				  			<option value="role">Role</option>				  			
				  		</select>
					</div>
					<div class="input-field col m1 s6">
				       <button class="search-button btn blue waves-effect" style="height: 3rem" id="filter-btn"><center><i class="material-icons left">search</i></center>Search</button>
				       
					</div>
					<div class="input-field col m1 s6">
						<button class="search-button btn red waves-effect" style="height: 3rem" id="reset-filter-btn"><center><i class="material-icons left">replay</i></center>Reset</button>
					</div>
		        </div>
	        </div>
	      </div>
	    </li>
	</ul>
	<div class="card-container">
	  	<div class="row">
	      <div class="col s12 l8">
	      		<div id="applicant-container" class="content-xaas">
	      			
	      		</div>
			    <!-- Card Content -->
		
		        <!-- End of Card Content -->
		        <center>
			        <ul class="pagination" id="pagination">
					    
					</ul>
				</center>
	      </div>
	      <div class="col l4 search-panel">
	      	<div class="card-panel large item">
	      		<div class="card-header">
	      			<h5>Search Parameters:</h5>
	      		</div>
	      		<div class="card-content" id="card-content">
	      			
	      		</div>
	      		<div class="empty-container">
	      			<div class="exact">
	      				<div class="exact-label" style="display: none;">Exact Matches</div>

	      			</div>
	      			<div class="relevant">
	      				<div class="relevant-label" style="display: none;">Relevant Results</div>
	      			</div>
	      		</div>
	      	</div>
	      </div>
	    </div>
	</div>
	 <div class="fixed-action-btn toolbar toolbar-with-search">
	    <a class="btn-floating btn-large blue">
	      <i class="large material-icons">settings</i>
	    </a>
	    <ul>
	      <li class="waves-effect waves-light pagination_prev"><a><i class="material-icons">arrow_backward</i></a></li>
	      <li class="waves-effect waves-light pagination_next"><a href="#!"><i class="material-icons">arrow_forward</i></a></li>
	      <li class="waves-effect waves-light"><a href="help/faq-template/af_help.html"><i class="material-icons" target="_blank">help</i></a></li>
	      <li class="waves-effect waves-light trigger-search-modal"><a href="#params_modal"><i class="material-icons">search</i></a></li>
	    </ul>
	  </div>
	  <div class="fixed-action-btn toolbar toolbar-without-search">
	    <a class="btn-floating btn-large blue">
	      <i class="large material-icons">settings</i>
	    </a>
	    <ul>
	      <li class="waves-effect waves-light pagination_prev"><a><i class="material-icons">arrow_backward</i></a></li>
	      <li class="waves-effect waves-light pagination_next"><a href="#!"><i class="material-icons">arrow_forward</i></a></li>
	      <li class="waves-effect waves-light"><a href="help/faq-template/af_help.html" target="_blank"><i class="material-icons">help</i></a></li>
	    </ul>
	  </div>
		
	<div id="params_modal" class="modal">
		<h5>Search Parameters</h5>
	    <div class="modal-content" id="modal-content">	      
	    </div>
	    <div class="modal-footer">
	      <a href="" class="modal-action modal-close waves-effect waves-green btn-flat">Close</a>
	    </div>
	</div>
	
</body>
<!-- Card Template -->
<script id="template" type="text/html">
	<div class="card-panel large item" id="card-${accno}">
    	<div class="row">
	      <div class="col s12 m2">
	      	<img src="${pic}" class="list-image">
	      </div>
	      <div class="col s12 m6">
	      	<a href="/jobsearch/resume/load.php?accno=${accno}" target="_blank"><h5>${fname} ${lname}</h5></a>
	      	<div class="exact-label chip blue white-text">Result Type: ${resultType}</div>
	      	<div class="chip">Skills: ${skill_name}</div>
			<div>${description}</div>
	      </div>
	      <div class="col s12 m4">
	      	<div class="button-container">
		      	<button class="waves-effect waves-light btn green fill like" user-id='${accno}'><i class="material-icons left">thumb_up</i>Like</button>
		      	<button class="waves-effect waves-light btn red fill ignore" user-id='${accno}'><i class="material-icons left">thumb_down</i>Ignore</button>
	      	</div>
	      </div>
	    </div>
    </div>
</script>
<!-- Search Parameters Template -->
<script id="search-params-template" type="text/html">
	<label class="search-label">With Experience:</label>
	    <input type="radio" class="exp-radio" name="exp" id="radio1" is_experienced=true><label for="radio1">Yes</label>
	    <input type="radio" class="exp-radio" name="exp" id="radio2" is_experienced=false><label for="radio2">No</label>
	    <br>
	    <input class="form-control filter" id="skills" name="search-skills" placeholder="Search by Skill">
	    	    	
		<select class="form-control filter" id="quali-obtained" placeholder="All Specializations">
	    	<option disabled selected="selected" hidden>Select Qualification Obtained</option>	
		    <?php
		    	$select = "select quali_name from qualification";
		    	$db_obj->setQuery($select);
		    	$res = $db_obj->executeQuery(array(),true);
		    	foreach ($res as $row) {
		    		$quali_name = $row['quali_name'];
		    		print "<option value ='$quali_name'>$quali_name</option>";
		    	}
		    ?>			        	
	    </select>
	    <select class="form-control filter" id="field-study" name="field-study">
	    	<option selected="selected" disabled="disabled" hidden>Select your field of study</option>	
		    <?php
		    	$select = "select field_name from fields_study";
		    	$db_obj->setQuery($select);
		    	$res = $db_obj->executeQuery(array(),true);
		    	foreach ($res as $row) {
		    		$field_name = $row['field_name'];
		    		print "<option value ='$field_name'>$field_name</option>";
		    	}
		    ?>		    	
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
			    		<input class=" filter" name="salary_range_app" id="salary_range_app" placeholder="Salary Given" type="number">
			    	</div>
				</div>
			</div>
			<div class="col s1 m1 l1">
				<button class="btn-small waves-effect waves-light blue" id="filter-salary-app"><i class="material-icons left">search</i></button>
			</div>
		</div>
	    <button id="clear_filters" name="clear_filters" class="button_filter waves-effect waves-light fill blue btn">Clear Filters</button>
</script>
<!-- Loads the parameters using javascript -->
<script type="text/javascript" src="/jobsearch/rule-based-functions/loadParameters.js"></script>

<footer class="page-footer blue">
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