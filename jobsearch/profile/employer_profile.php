<?php
	require $_SERVER['DOCUMENT_ROOT'] ."/DBConnectionString/dbconnect_class.php";
?>
<?php
if(isset($_SESSION['accno']))
{
	if($_SESSION['utype']=="applicant")
	{
		header("location:/jobsearch/profile/applicant_profile.php");
	}
}
else{
	header("location:../index.php");
}
?>
<?php
if(isset($_SESSION['accno']))
{
	$db_obj = new DatabaseConnection();
	//INNER JOIN if I want to split in database.
	$db_obj -> setQuery("Select * from employer_tbl e INNER JOIN company_table c ON e.accno = c.employer_accno where c.employer_accno=:accno");
	$result = $db_obj -> executeQuery(array(":accno" => $_SESSION['accno']),true);
	foreach ($result as $row) {
		$lname = $row['lname'];
		$fname = $row['fname'];
		$gender = $row['gender'];
		$email = $row['email'];
		$cnum = $row['cnum'];
		$bday = $row['bday'];
		$role = $row['role'];
		$cname = $row['cname'];
		$region = $row['region'];
		$city = $row['city'];
		$c_address = $row['address'];
		$pic = $row['pic'];
		$edate = $row['edate'];
		$company_overview = $row['company_overview'];
		$company_num = $row['company_number'];
		$edited = $row['updated'];
		$c_email = $row['company_email'];
		$logo = $row['company_pic'];
		if(!empty($pic)){
			$link = "upload/$pic";
		}
		else{
			$link = "/jobsearch/employer.png";
		}
	}
	$company_spec = array();
	$db_obj -> setQuery("Select * from company_spec where owner_id=:accno");
	$result = $db_obj -> executeQuery(array(":accno" => $_SESSION['accno']),true);
	$cnt = $db_obj ->returnCount();
	if($cnt != 0){
		foreach ($result as $row) {
			array_push($company_spec,$row['specialization_name']);
		}
	}
}
?>

<!DOCTYPE html>
<title>Employer Profile</title>
<meta charset="UTF-8">
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"  type="text/javascript"></script>

<!-- Latest compiled JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="autofill_textbox.js" type="text/javascript"></script>

<link rel="stylesheet" href="Croppie-master/croppie.css">
<link rel="stylesheet" href="css/button.css">
<link rel="stylesheet" href="w3.css">
<link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Ubuntu'>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="css/employer.css">
<script src="https://www.gstatic.com/firebasejs/4.0.0/firebase.js"></script>
<script src="Croppie-master/croppie.js" type="text/javascript"></script>

<link rel="stylesheet" href="iHover/ihover.css">

<script src="../validation_function/dist/jquery.validate.js"></script>
<script src="sweetalert2/sweetalert2.min.js"></script>
<link rel="stylesheet" href="sweetalert2/sweetalert2.min.css">

<link rel="stylesheet" href="../bootstrap-select-1.12.1/dist/css/bootstrap-select.css">
<script src="../bootstrap-select-1.12.1/dist/js/bootstrap-select.js"></script>
<script src="/jobsearch/profile/custom_modal.js"></script>

<link rel="stylesheet" type="text/css" href="../chat/style2.css">
<link rel="stylesheet" type="text/css" href="../chat/style.css">
<script src="notif/notyf.min.js"></script>
<link rel="stylesheet" type="text/css" href="notif/notyf.min.css">
<link rel="stylesheet" type="text/css" href="css/loader.css">
<script src="../select-region/regions.js"></script>


<script>
function allow(decision){
	if(decision==="No"){
		$("body").ready(function(){
			$("#post_a_job").addClass("jobs_hidden");
			$(".floating_div").clone().insertBefore("#post_a_job").attr("id","floating_div")
			$("#floating_div").removeClass("hide")
			$("#show_postjob").remove();
		})
	}
}
$(function(){
	allow(<?php print json_encode($edited) ?>) 
})
$(function(){
	
	$("ul").on('click','.show_Message',function(){
		$("#chatList").modal('show');
	})	
	function setVal(){
		$("#list_of_regions").val($("region").text()).change();
		$("#list_of_cities").on('DOMSubtreeModified',function(){
			$(this).val($("city").text());
		})
		$("spec").each(function(){
			var text = $(this).text();
			$("#select_spec option[value='" + text + "']").attr("selected", true);
		})
		$("#select_spec").selectpicker('refresh');
		$("#role").val($("role").text());
		$("#c_name").val($("c_name").text());
		$("#c_address").val($("c_add").text());
		$("#e_date").val($("edate").text());
		$("#c_overview").val($("c_overview").text());
		$("#phone_number").val($("company_number").text());
		$("#c_email").val($("c_email").text());
	}
	function text(){
		var len = $("#c_overview").val().length
		$("#num_text").html(len)
	}
	text();
	$("#c_overview").on('keydown keypress keyup',function(){
		text();	
	})
	$("#saved_company_profile").hide();

	$("#edit_abt_company").click(function(){
		$("#saved_company_profile").show();
		$("#saved_company_profile_disabled").hide();
		setVal();
		text();
	})
	$("#cancel_abt_company").click(function(){
		$("#saved_company_profile").hide();
		$("#saved_company_profile_disabled").show();
		setVal();

	})
})
</script>
<script>
	$(document).ready(function(){
		$("#aboutme").hide();
		$("#matches").hide();
		$("#company_profile").hide();
		$("#link_postjob").css("background-color",'#eee');
		$(".profile").click(function(){
			var $id = $(this).attr('id');
			if($id=='link_postjob'){
				$id ="#postjob";
				$("#aboutme").hide();
				$("#matches").hide();
				$("#company_profile").hide();
			}
			if($id=='link_company_profile'){
				$("#postjob").hide();
				$("#aboutme").hide();
				$("#matches").hide();
				$id = "#company_profile";
			}
			else if($id=='link_about'){
				$("#postjob").hide();
				$id = "#aboutme";
				$("#matches").hide();
				$("#company_profile").hide();
			}
			else if($id=='link_matches'){
				$("#postjob").hide();
				$("#aboutme").hide();
				$id = "#matches";
				$("#company_profile").hide();
			}
			$(".profile").css("background-color",'white');
			$(this).css("background-color",'#eee');
			$($id).show();
			$('html,body').animate({
			   scrollTop: $($id).offset().top - 90
			});
		});
		$(".notification").on('click','.matches-notif',function(){
			$("#postjob").hide();
			$("#aboutme").hide();
			$("#matches").show();
			$("#company_profile").hide();
			$(".profile").css("background-color",'white');
			$("#link_matches").css("background-color",'#eee');
		});
	});
</script>
<script type="text/javascript">
	$(window).on('load',function(){
		setTimeout(function(){
			$('.loader-container').fadeOut('slow');
		},2000);
	});
</script>
</head>
 	
<section class="loader-container">
	<div class="cssload-loader">Loading</div>
</section>
<body class="w3-light-grey" class="margin" oncontextmenu="return false">

<nav id="mainNav" class="navbar navbar-default navbar-fixed-top navbar-custom">
    <div class="container">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header page-scroll">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>  <i class="fa fa-bars"></i>
            </button>
            <img class="img-responsive" id='main' src="/jobsearch/img/freshstartlogo.png" style="border-radius:15px" width="160px" alt="">
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav navbar-right">
                <li class="hidden">
                    <a href="#page-top"></a>
                </li>
                <li>
                   <a href="../applicant_search.php"><i class="fa fa-search"></i> Find Applicants</a>
                </li>
                <li id="notification_li">
					<span id="my-notif-count"></span>
					<a href="#" id="notificationLink"><i class="fa fa-bell"></i>&nbsp;Notifications</a>
					<div id="notificationContainer">
						<div id="notificationTitle">Notifications</div>
						<div id="notificationsBody" class="notification">
							<ul class="notifications" style="list-style: none;margin-left:-20px">
								
							  
							</ul>
						</div>
					</div>
				</li>
				<li class="page-scroll">
					<span id="number_of_matches"></span>
                    <a data-toggle="modal" data-target="#chatList" id="openChatList"><i class="fa fa-weixin" aria-hidden="true"></i>Chat Room</a>
                    <script type="text/javascript">
                    	$(function(){
                    		$("#openChatList").click(function(){
                    			$('html,body').animate({
								   scrollTop: 0
								});
                    		})
                    	})
                    </script>
                </li>                     
                <li>
                   <a href="../index.php?logout=true"><i class="fa fa-power-off"></i> Log-Out</a>
                </li>
            </ul>
        </div>
        <!-- /.navbar-collapse -->
    </div>
    <!-- /.container-fluid -->
</nav>
<div class="container-toggable-notification">
	<button class="floating-button-notif my-notif-exit" id="my-notif-exit">
		<i class="fa fa-times fa-lg fa-white"></i>
	</button>
	<div id="notificationContainer">
		<div id="notificationTitle">Notifications</div>
		<div id="notificationsBody" class="notification">
			<ul class="notifications" style="list-style: none;margin-left:-20px">	  
			</ul>
		</div>
	</div>
</div>	
<div class=margin>
<!-- Page Container -->
<div class="w3-content w3-margin-top" style="max-width:1400px;">

  <!-- The Grid -->
  <div class="w3-row-padding">
  
    <!-- Left Column -->
    <div class="w3-third">
		<div class="w3-card-2 w3-round w3-white w3-margin-bottom">
			<div class="w3-container">
			 <h4 class="w3-center">My Profile</h4>
			 <!-- normal -->
			 <center>
				<div class="ih-item circle effect5"><a data-toggle="modal" data-target="#uploadImage">
				<img src="<?php print $link; ?>" id="my-image2" alt="img" width=400 style='border-radius: 50%'>
				<div class="info">
				  <div class="info-back">
					<h3><i class="fa fa-instagram fa-lg"></i></h3>
				  </div>
				</div></a></div>
			</center>
			<!-- end normal -->
		
			 <hr>
			 <ul style="list-style: none;margin:0;padding:0" class="user_profile">
				<li><a class="profile" id="link_postjob" style="padding-bottom:20px"><i class="fa fa-briefcase fa-fw w3-margin-right w3-large w3-text-teal"></i>Post a job</a></li>

				<li><a class="profile" id="link_about"><p><i class="fa fa-user fa-fw w3-margin-right w3-large w3-text-teal"></i>About Me</p></a></li>
				<li><a class="profile" id="link_company_profile"><p><i class="fa fa-building fa-fw w3-margin-right w3-large w3-text-teal"></i>Company Profile</p></a></li>
				<li><a class="profile" id="link_matches"><p><i class="fa fa-thumbs-up fa-thumbs-down fa-fw w3-margin-right w3-large w3-text-teal"></i>Requests
					<span id="notification_count" class="w3-badge w3-green"></span>
				</p></a></li>
				<!--<script>
					notification_function();
				</script>-->
			</ul>
			<hr>
			</div>
		  </div>
		<!-- End Left Column -->
   
    <!-- End Left Column -->
    </div>
    
    <!-- Right Column -->
    <div class="w3-twothird">
    <!--About Me-->
			
    <div id="postjob">
		<script>
		$(document).ready(function(){
			$("#post_a_job").hide();
			$("#show_postjob").click(function(){
				$("#post_a_job").slideDown();
				$("#show_postjob").hide();
			});
			$("#close_jobs_field").click(function(){
				$("#post_a_job").slideUp();
				$("#show_postjob").show();
			});
			$("input[type='number']").keypress(function(e){
				if(e.keyCode == 69 || e.keyCode == 101){
					return false;
				}
			});
		});
		</script>
		<div id="post_a_job">
		
			<div class="w3-container w3-card-2 w3-white w3-margin-bottom">
				<h2 class="w3-text-grey w3-padding-16"><i class="fa fa-suitcase fa-fw w3-margin-right w3-xxlarge w3-text-teal"></i>Post a Job</h2>
				<a href="/jobsearch/help/faq-template/employer_help.html#" class="trigger-help btn btn-info help" target="_blank">?</a>
				<form method=post id=form_addjob>
					<label class="w3-label w3-text-black"><b>Job Name</b></label>
					<input class="form-control" type="text" name="jobname" id="jobname" required>
 
					<label class="w3-label w3-text-black"><b>Job Details</b></label>
					<textarea class="form-control" name="jobdetails" id="jobdetails" type="text" rows=15 required></textarea>
					
					
					<label class="w3-label w3-text-black"><b>Min Salary</b></label>
					<input class="form-control" type="number" name="min_salary" id="min_salary" min="0" required>
					
					<label class="w3-label w3-text-black"><b>Max Salary</b></label>
					<input class="form-control" type="number" name="max_salary" id="max_salary" min="1" required>
					
					<label class="w3-label w3-text-black"><b>Type of Employment</b></label>
					<select class="form-control" name="employ_type" id="employ_type" required>
						<option value="Any">Any</option>
						<option value="Full Time">Full Time</option>
						<option value="Part Time">Part Time</option>
						<option value="Freelance">Freelance</option>
					</select>
					
					<label class="w3-label w3-text-black"><b>Job Specialization</b></label>
					<select class="form-control selectpicker" multiple="multiple" data-live-search="true" name="job_select_spec" id="job_select_spec">
					<?php
					 	$db_obj->setQuery("select distinct cat from specialization WHERE specialization_name IN(select specialization_name from company_spec where owner_id=:accno)");
					 	$result = $db_obj->executeQuery(array(":accno" => $_SESSION['accno']),true);
					 	$cnt = $db_obj->returnCount();
					 	if($cnt!=0)
					 	{
							foreach ($result as $row) {
								$category = $row['cat'];
								print "<optgroup label='$category'>";
								$spec_connection = new DatabaseConnection();
								$spec_connection->setQuery("select distinct sp.specialization_name sp_name, sp.cat, csp.* from specialization sp INNER JOIN company_spec csp ON csp.specialization_name =  sp.specialization_name where cat=:category and owner_id=:accno");
								$spec_result = $spec_connection->executeQuery(array(":category" => $category, ":accno" => $_SESSION['accno']),true); 
								foreach ($spec_result as $row2) {
									$spec_name = $row2['specialization_name'];
									print "<option value='$spec_name'>$spec_name</option>";
								}
								print "</optgroup>";
							}
						}
					?>
					</select>
					<br><br>
					<label class="w3-label w3-text-black"><b>Requirement(s)</b></label>
					<div class="row">
						<div class="col-xs-9">
							<div class="left-inner-addon">
								<input class="form-control requirements add" name="requirement" id="requirement">
								<i class='glyphicon glyphicon-asterisk'></i>
							</div>
							<div id="requirements_text_fields">
							</div>
						</div>
						<div class="col-xs-3">
							<button id="add_requirement_a" type="button" class="btn btn-success btn"><i class="fa fa-plus"></i>&nbsp; More</button>
							<button id='del_requirement_a' type='button' class="btn btn-success btn"><i class="fa fa-minus"></i>&nbsp; Delete</button>
						</div>
					</div>
					<label class="w3-label w3-text-black"><b>*Responsibilities</b></label>
					<textarea class="form-control" name="" id="responsibilities" type="text" rows=15></textarea>
					<script type="text/javascript">
						$(function(){
							$("#add_requirement_a").click(function(){
								var added = true;
								$(".form-control.requirements.add").each(function(){
									if($(this).val().trim()===''){
										swal("Error","Please try filling all the other blank requirements before adding another one","error")
										added = false;
									}
								})
								if(added===true){
									$("#requirements_text_fields").append("<div class='col-s-10' style='padding-top:10px'><div class='left-inner-addon' id=><i class='glyphicon glyphicon-asterisk'></i><input class='form-control requirements add' name='requirement' id='requirement'></div></div>");
								}
							})
							$("body").on('click',"#del_requirement_a",function(){
								var len = $(".form-control.requirements.add").length;
								if(len>1)
									$(".form-control.requirements.add").last().parent().parent().remove();
								else
									swal("Error","Sorry! You cannot delete the last input","error");

							})
						})
					</script>
					<br>
					<center>
						<button name="save_add_job" id="btn_save_job" type="submit" maxlength="80" class="btn btn-success btn-lg">Save</button>
						<button id="close_jobs_field" type="button" maxlength="80" class="btn btn-success btn-lg">Close</button>
						<button name="clear_jobs_field" id="clear_jobs_field" type="reset" maxlength="80" class="btn btn-success btn-lg">Re-Set</button>
					<hr>

				</form>
			</div>
		</div>
		<div id="list_jobs_posted">
			<div class="w3-container w3-card-2 w3-white w3-margin-bottom">
				<h2 class="w3-text-grey w3-padding-16"><i class="fa fa-briefcase fa-fw w3-margin-right w3-xxlarge w3-text-teal"></i>My Posted Jobs</h2>
				<a id="show_postjob" style="float:right;">+Post a new job</a>
				<br>
				
				<div id="success" class="alert alert-success hide"></div>
				
				<script>
					$(document).ready(function(){
						
						$(".btn.btn-danger.remove").click(function(){			
							var job_id = $(this).parent().parent().attr("id");
							var selector = "#list_jobs_posted #" +job_id; 
							delete_field(selector,job_id,"job");
						});
						
						$(".btn.btn-success.edit").click(function(){
							var job_id = $(this).parent().parent().attr("id");							
							button_edit(job_id);
						});
					});
				</script>
					<?php
						$db_obj->setQuery("select * from jobs where accno=:accno");
						$result = $db_obj->executeQuery(array(":accno" => $_SESSION['accno']),true);
						$count = $db_obj->returnCount();
						if($count > 0){
							foreach ($result as $row) {
								$jobname = nl2br($row['job_name']);
								$jobdetails = nl2br($row['looking_for']);
								$min_salary = $row['min_salary'];
								$max_salary = $row['max_salary'];
								$employ_type = $row['employ_type'];
								$spec = $row['spec_job'];
								$requirements = $row['requirements'];
								$responsibilities = nl2br($row['responsibilities']);
								$employ_type = $row['employ_type'];
								$id = $row['id'];
								$isAvailable = $row['isAvailable'];
								$checked="";
								$available = "Unavailable";
								if(empty($requirements)){
									$requirements = '<br>None';
								}
								if(empty($responsibilities)){
									$responsibilities = 'None';
								}
								if($isAvailable){
									$checked = "checked";
									$available = "Available";
								}
								$requirements = str_replace(",","<br>",$requirements);
								$spec = str_replace(",","<br>",$spec);
								print"<div class='w3-container' id='$id'>
										<h5><b>$jobname</b></h5>
										<div style='float:right;'>
											<button id='button1' class='btn btn-success edit'>
												<i class='glyphicon glyphicon-pencil'></i>
											</button>
											<button id='button2' class='btn btn-danger remove'>
												<i class='glyphicon glyphicon-remove'></i>
											</button>
										</div>
										<h6><b class=w3-opacity><i class='fa fa-money w3-text-teal'></i>&nbsp; P $min_salary - P $max_salary($employ_type)</b></h6>
										<br>
										<div class='w3-panel w3-card-2'>
											<p><b><h6 style='margin-bottom:0;'>Job Availability:<availability id='$id'>($available)</availability></h6></b></p>
											<label class='switch'>
											  <input type='checkbox' $checked class='job-availability' jobId='$id'>
											  <span class='slider round'></span>
											</label>

										</div>
										<br>

										<h6 style='margin-bottom:0px'><i class='fa fa-user w3-text-teal' aria-hidden='true'></i>&nbsp; <b>Job Information:</b></h6>
										<p>$jobdetails<br></p>
										<h6 style='margin-bottom:0px'><i class='fa fa-user w3-text-teal' aria-hidden='true'></i>&nbsp; <b>Job Specializations:</b></h6>
										<br>$spec
										<h6 style='margin-bottom:0px'><i class='fa fa-user w3-text-teal' aria-hidden='true'></i>&nbsp; <b>Requirements:</b></h6>
										$requirements
										<h6 style='margin-bottom:0px'><i class='fa fa-user w3-text-teal' aria-hidden='true'></i>&nbsp; <b>Responsibilities:</b></h6>
										<br>$responsibilities
										<hr>
									</div>";
							}
						}
					?>
					<script>
						$(function(){
							function capitalizeFirstLetter(string) {	
							    return string.charAt(0).toUpperCase() + string.slice(1);
							}
							function fetchAvailability(id,callback){
								$.post('fetch-availability.php',{id:id},function(response){
									callback(response);
								})
							}
							$('.job-availability').click(function(e){
								e.preventDefault();
								var id = $(this).attr("jobId");
								var opposite_availability,isSuccessful=false;
								
								var object = $(this);
								var $available;
								fetchAvailability(id,function(response){
									response = JSON.parse(response);
									console.log(response)
									if(response.valid){
										$available = response[0].isAvailable;
										$available =  ($available == 1) ? true:false
									}
									if($available){
										opposite_availability = "unavailable"
									}
									else{
										opposite_availability = "available"	
									}
									var $parameters = {
										isAvailable:$available,
										id:id
									};
									swal({
										title:"Confimation",
										text:"Do you want to set this job to "+opposite_availability+"?",
										type:"question",
										showCancelButton:true,
										preConfirm: function (email) {
										    return new Promise(function (resolve, reject) {
												$.post("set-availability.php",$parameters,function(response){
													isSuccessful = response;
													console.log(isSuccessful);
												}).done(function(){
													resolve();
												})      
										    })
										},
									}).then(function(){
										if(isSuccessful == "1"){
											swal("Success!","Data has been saved","success");
											$('availability').html("("+capitalizeFirstLetter(opposite_availability)+")");
											object.prop('checked',!$available);	
											object.attr('checked',!$available);										
										}
										else{
											swal("Error","Sorry your request could not be processed","error");
										}
									}).catch(swal.noop);

									});
								});
						})
					</script>
			</div>
		</div>
	</div>

	<div id="company_profile">		
		<div class="w3-container w3-card-2 w3-white w3-margin-bottom">
			<h2 class="w3-text-grey w3-padding-16"><i class="fa fa-building fa-fw w3-margin-right w3-xxlarge w3-text-teal"></i>Company Profile</h2>
			<a href="/jobsearch/help/faq-template/employer_help.html#company_profile" class="trigger-help btn btn-info help" target="_blank">?</a>
				<div id="saved_company_profile_disabled">
					<div class="w3-container c-profile-container">
					<?php				
						print "<div class='row'>";
						print "<div class='col-md-5'>";
						if(empty($logo)){
							$logo = "freshstartlogo.png";
						}
						print '<img class="img-responsive img-thumbnail" src="/jobsearch/profile/company-logo/'.$logo.'" alt="Chania" id="company-logo"><br><br><button type="button" class="btn btn-success btn-block" data-toggle="modal" data-target="#uploadCompanyLogo">Edit Company Logo</button>';
						print "</div>";
						print "<div class='col-md-7 info-container'>";
						print "<h4><i class='fa fa-user w3-text-teal'></i><b> &nbsp; <c_name>$cname&nbsp;<button name='edit_abt_company' id='edit_abt_company' type='button' maxlength='80' class='btn btn-success'><i class='fa fa-edit'></i></button>
							</c_name></b></h4><hr>";
						print "<b><font size='3.5px'><i class='fa fa-exclamation-circle w3-text-teal'></i> &nbsp; Company Overview:</b></font>";
						print "<br><c_overview>$company_overview<br></c_overview><hr>";
						print "</div>";
						print "</div>";
						print "<hr>";
						print "<div class='row'>";
							print "<div class='col-md-6'>";
								print "<b><font size='3.5px'><i class='fa fa-building-o w3-text-teal' aria-hidden='true'></i>&nbsp; Company Specialization:</font></b><br>";
								for($i=0;$i<count($company_spec);$i++){
									print "<spec>$company_spec[$i]</spec><br>";
								}
							print "</div>";
							print "<div class='col-md-6'>";
								print "<b><font size='3.5px'><i class='fa fa-building-o w3-text-teal' aria-hidden='true'></i>&nbsp; </i>More Information:</font></b>";
								print "<br><b>Region Name: &nbsp;</b><region>$region<br></region>";
								print "<b>City Name: &nbsp;</b><city>$city<br></city>";
								print "<b>My Role in the company: &nbsp;</b><role>$role<br></role>";
								print "<b>Company Address: &nbsp;</b><c_add>$c_address<br></c_add>";
								print "<b>Company Email: &nbsp;</b><c_email>$c_email<br></c_email>";
								print "<b>Company Phone Number: &nbsp;</b><company_number>$company_num<br></company_number>";
								print "<b>Establistment Date: &nbsp;</b><edate>$edate<br></edate>";
							print "</div>";
						print "</div>";
					?>
					</div>
				</div>
				<form name="saved_company_profile" id="saved_company_profile" method="post">
					<label>Region</label>
					<select id="list_of_regions" class="form-control" name="search_region">
					</select>
					<label>City</label>
					<select id="list_of_cities" class="form-control" name="search_city">			    	
					</select>
					<label class="w3-label w3-text-black"><b>Role</b></label>
					<input class="form-control" name="role" id="role" type="text">
					
					<label class="w3-label w3-text-black"><b>Company Name</b></label>
					<input class="form-control" name="c_name" id="c_name" type="text">
					
					<label class="w3-label w3-text-black"><b>Company Address</b></label>
					<input class="form-control" name="c_address" id="c_address" type="text">

					<label class="w3-label w3-text-black"><b>Company Email</b></label>
					<input class="form-control" name="c_email" id="c_email" type="email">

					<label class="w3-label w3-text-black"><b>Company Phone Number</b></label>
					<input class="form-control" name="phone_number" id="phone_number" type="text">
					
					<label class="w3-label w3-text-black"><b>Establistment Date</b></label>
					<input type="date" class="form-control" id="e_date" name="e_date" min="1979-01-01" max="<?php print date("Y-m-d"); ?>" >

					<label class="w3-label w3-text-black"><b>Company Specializations</b></label>
					<select class="form-control selectpicker" multiple="multiple" data-live-search="true" name="select_spec" id="select_spec">
					<?php
						$db_obj = new DatabaseConnection();
					 	$db_obj -> setQuery("select distinct cat from specialization");
					 	$res = $db_obj->executeQuery(array(),true); 
					 	foreach ($res as $row) {
					 		$cat = $row['cat'];
							print "<optgroup label = '$cat'>";
					 		$db_obj->setQuery("select specialization_name from specialization where cat=:cat");
					 		$res2 = $db_obj->executeQuery(array(":cat" => $cat),true);
					 		foreach ($res2 as $row2) {
					 			$spec_name = $row2['specialization_name'];
					 			print "<option value='$spec_name'>$spec_name</option>";
					 		}
					 		print "</optgroup>";
					 	}
					?>
					</select>
					<label class="w3-label w3-text-black"><b>Company Overview</b></label>
					<textarea class="form-control" id="c_overview" name="c_overview" rows=15 maxlength="3500"></textarea>
					<div class="pull-right">
						<div id="num_text" class="pull-left">0</div>&nbsp; characters of 3500
					</div>
					
					<br>
					<center>
						<button name="btn_save_abt_company" id="btn_save_abt_company" type="submit" maxlength="80" class="btn btn-success btn-lg">Save</button>
						<button name="cancel_abt_company" id="cancel_abt_company" type="button" maxlength="80" class="btn btn-success btn-lg">Cancel</button>
					</center>
				</form>
				<br>
		</div>
	</div>
	<div id="aboutme">
		<script>
			$(document).ready(function(){
				var $lname,$fname,$cnum,$gender,$bday,$min,$email;
				$("#btn_save_abtme").prop("disabled",true);	
				$("#cancel_abtme_save").hide();	
				
				$("#edit_abtme").on('click',function(){
						
					$fname = $( "#firstname" ).val();
					$lname = $( "#lastname" ).val();
					$cnum = $( "#cnum" ).val();
					$gender = $( "#gender" ).find(":selected").text();
					$bday = $( "#bday" ).val();
					$min = $( "#min_salary" ).val();
					$email = $( "#email" ).val();					
					$( "#lastname" ).prop( "disabled", false );
					$( "#firstname" ).prop( "disabled", false );
					$( "#bday" ).prop( "disabled", false );
					$( "#cnum" ).prop( "disabled", false );
					$( "#gender" ).prop("disabled",false);
					$( "#min_salary" ).prop( "disabled", false );
					$( "#email" ).prop( "disabled", false );
					
					$("#edit_abtme").hide();
					$("#cancel_abtme_save").show();
					$( "#btn_save_abtme" ).prop( "disabled", false);
				});
				
				$("#cancel_abtme_save").on('click',function(){			
					$( "#firstname" ).prop( "disabled", true ).prop("value",$fname);
					$( "#lastname" ).prop( "disabled", true ).prop("value",$lname);
					$( "#cnum" ).prop( "disabled", true ).prop("value",$cnum);	
					$( "#bday" ).prop( "disabled", true ).prop("value",$bday);
					$( "#gender" ).prop("disabled",true).prop("selected",$gender);
					$( "#email" ).prop( "disabled", true ).prop("value",$email);
					$("form .error").text('');
					$(".form-control").css("color","black");
					$( "#btn_save_abtme" ).prop( "disabled", true);					
					$("#edit_abtme").show();
					$("#cancel_abtme_save").hide();
				});
				
			});
		</script>
				
		<div class="w3-container w3-card-2 w3-white w3-margin-bottom">
		<h2 class="w3-text-grey w3-padding-16"><i class="fa fa-user fa-fw w3-margin-right w3-xxlarge w3-text-teal"></i>About me</h2>
		<a href="/jobsearch/help/faq-template/employer_help.html#about_me" class="trigger-help btn btn-info help" target="_blank">?</a>
			<div class="w3-container">
				<form method=post id="form_abtme_employer">
				
					<label class="w3-label w3-text-black"><b>First Name</b></label>
					<input class="form-control" type="text" name="firstname" id="firstname" value="<?php print $fname; ?>" disabled>
					<div id="errors"></div>
 
					<label class="w3-label w3-text-black"><b>Last Name</b></label>
					<input class="form-control" name="lastname" id="lastname" type="text" value="<?php print $lname; ?>" disabled>
					<div id="errors"></div>				
					
					<label class="w3-label w3-text-black"><b>Gender</b></label>
						<select class="form-control" id="gender" name=gender disabled>
							<option value="Male" <?php if(strtolower($gender)=='male') print 'selected'; ?>>Male</option>
							<option value="Female" <?php if(strtolower($gender)=='female') print 'selected'; ?>>Female</option>
						</select>
				
					<label class="w3-label w3-text-black"><b>Birthday</b></label>
					<input type="date" class="form-control" id="bday" name="bday" min="1979-01-01" value='<?php print $bday;?>' max="<?php print date("Y-m-d"); ?>" disabled></b>
					
					<label class="w3-label w3-text-black"><b>Cellphone Number</b></label>
					<div style="display: flex">
						<input value="+63" disabled style="width:80px" class="form-control">
						<input class="form-control" name="cnum" id="cnum" value='<?php print $cnum;?>' type="text" disabled style="width: 85%">
					</div>
					<div id="errors"></div>					
					
					<br><center>
					<button name="btn_save_abtme" id="btn_save_abtme" type="submit" maxlength="80" class="btn btn-success btn-lg">Save</button>
					<button name="edit_abtme" id="edit_abtme" type="button" maxlength="80" class="btn btn-success btn-lg">Edit</button>
					<button name="cancel_abtme_save" id="cancel_abtme_save" type="button" maxlength="80" class="btn btn-success btn-lg">Cancel</button>
					</center>
					<br>
				</form>
			</div>
		</div>
	</div>
	<!--About Me-->
	
	<div id="matches">
	
		<div class="w3-container w3-card-2 w3-white w3-margin-bottom">
			<h2 class="w3-text-grey w3-padding-16"><i class="fa fa-thumbs-up fa-fw w3-margin-right w3-xxlarge w3-text-teal"></i>Pending Requests</h2>
			<a href="/jobsearch/help/faq-template/employer_help.html#pending_request" class="trigger-help btn btn-info help" target="_blank">?</a>
			<fieldset>
				<legend for="requests_list">Applicants Requesting for a job</legend>
				<div class="table-container">

					<input type="hidden" value="<?php print $_SESSION['accno']; ?>" id="hidden_accno">
					<b><br class='pull-left'>Showing <count id='count-applicant-requesters-narrowed'></count> of <count id='count-applicant-requesters'></count> Requests</b>
					<div class="form-inline">
						<label>Filter:</label> 
						<input type="text" class="form-control d-inline-block" id="req-filter" name="req-filter" onkeyup="filter(this,this.nextElementSibling)">
						<select class="form-control d-inline-block" id="req-select-filter" name="req-select-filter" onchange="filter(this.previousElementSibling,this)">
							<option value="Full Name">Full Name</option>
							<option value="Job Name">Job Name</option>
						</select>
						<br><br>
					</div>	
					<table id="requesting-applicants-table" class="table table-no-more" style="font-size: 18px">
			            <thead id="header-list-of-matches">
			                <tr>
			                    <th>Picture</th>
			                    <th>Full Name</th>
			                    <th>Job Name</th>
			                    <th>Actions</th>
			                </tr>
			            </thead>
			            <tbody id="requesting-applicants">
			                
			            </tbody>
			        </table>
				</div>
			</fieldset>
			<br><br>
			<fieldset>
				<legend for="requests_list">Applicants I've Requested</legend>
				<div class="table-container">
					<input type="hidden" value="<?php print $_SESSION['accno']; ?>" id="hidden_accno">
					<b><br class='pull-left'>Showing <count id='requested-applicants-narrowed'></count> of <count id='requested-applicants-count'></count> Requests</b>
					<div class="form-inline">
						<label>Filter:</label> 
						<input type="text" class="form-control d-inline-block" id="my=req-filter" name="my-req-filter" onkeyup="filter(this,this.nextElementSibling)">
						<select class="form-control d-inline-block" id="my-req-select-filter" name="my-req-select-filter" onchange="filter(this.previousElementSibling,this)">
							<option value="Full Name">Full Name</option>
						</select>
						<br><br>
					</div>	
					<table id="list_of_my_requests" class="table table-no-more" style="font-size: 18px">
			            <thead>
			                <tr>
			                    <th>Picture</th>
			                    <th>Full Name</th>
			                    <th>Actions</th>
			                </tr>
			            </thead>
			            <tbody id="requested-applicants">
			                
			            </tbody>
			        </table>	        
				</div>
				
			</fieldset>
			
			<br><br>
		</div>
	
    <!-- End Right Column -->
    </div>
	</div>

		
	
    
  <!-- End Grid -->
  </div>
  
  <!-- End Page Container -->
</div>
</div>

<div id="jobsModal" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Edit Job</h4>	
      </div>
      <div class="modal-body">
		<form id="edit_saved_jobs" method="post">
		<script>
		
		</script>
		
		<label class="w3-label w3-text-black"><b>Job Name</b></label>
		<input class="form-control" type="text" name="edit_jobname" id="edit_jobname" required>
		<div id="errors"></div>
		
		<label class="w3-label w3-text-black"><b>Job Details</b></label>
		<textarea class="form-control" name="edit_jobdetails" id="edit_jobdetails" type="text" rows=15 required></textarea>
		<div id="errors"></div>
					
					
		<label class="w3-label w3-text-black"><b>Min Salary</b></label>
		<input class="form-control" type="number" name="edit_min_salary" id="edit_min_salary" min="0" required>
		<div id="errors"></div>
					
		<label class="w3-label w3-text-black"><b>Max Salary</b></label>
		<input class="form-control" type="number" name="edit_max_salary" id="edit_max_salary" max="1" required>
					
		<label class="w3-label w3-text-black"><b>Type of Employment</b></label>
		<select class="form-control" type="type" name="edit_employ_type" id="edit_employ_type" required>
			<option value="Any">Any</option>
			<option value="Full Time">Full Time</option>
			<option value="Part Time">Part Time</option>
			<option value="Freelance">Freelance</option>
		</select>
		<label class="w3-label w3-text-black"><b>Job Specialization</b></label>
		<select class="form-control selectpicker" multiple="multiple" data-live-search="true" name="edit_job_select_spec" id="edit_job_select_spec">
		<?php
		 	
		 	$db_obj -> setQuery("select distinct cat from specialization WHERE specialization_name IN(select specialization_name from company_spec where owner_id =:accno)");
		 	$res = $db_obj->executeQuery(array(":accno" => $_SESSION['accno']),true);
		 	$cnt = $db_obj->returnCount();
		 	if($cnt!=0)
		 	{
				foreach ($res as $row) {
					$category = $row['cat'];
					print "<optgroup label='$category(Currently Selected Values)'>";
					$db_obj->setQuery("select distinct specialization_name from specialization where cat=:category and cat IN(select cat from company_spec where owner_id=:accno)");
					$res2 = $db_obj->executeQuery(array(":category" => $category, ":accno" => $_SESSION['accno']),true);
					foreach ($res2 as $row2) {
						$spec_name = $row2['specialization_name'];
						print "<option value='$spec_name'>$spec_name</option>";
					}
					print "</optgroup>";
				}
			}
		?>
		</select>
		<label class="w3-label w3-text-black"><b>Requirement(s)</b></label>
		<div class="row">
			<div class="col-xs-9" id="requirements_text_fields_edit">
				<div class="left-inner-addon">
					<i class='glyphicon glyphicon-asterisk'></i>
					<input class="form-control requirements edit" name="edit_requirement" id="edit_requirement">
				</div>
			</div>
			<div class="col-xs-3" id="edit-req-btns">
				<button id="edit_add_requirement" type="button">+More</button>
				<button id='del_requirement_b' type='button'>Delete</button>
			</div>
		</div>
		<label class="w3-label w3-text-black"><b>*Responsibilities</b></label>
		<textarea class="form-control" id="edit_responsibilities" type="text" rows=15></textarea>
		<script type="text/javascript">
			$(function(){
				$("#edit_add_requirement").click(function(){
					var added = true;
					$(".form-control.requirements.edit").each(function(){
						if($(this).val().trim()===''){
							swal("Error","Please try filling all the other blank requirements before adding another one","error")
							added = false;
						}
					})
					if(added===true){
						$("#requirements_text_fields_edit").append("<div style='padding-top:10px'><div class='left-inner-addon'><i class='glyphicon glyphicon-asterisk'></i><input class='form-control requirements edit' name='edit_requirement' id='edit_requirement'></div></div>");
					}
				})
				$("#edit-req-btns").on('click',"#del_requirement_b",function(){
					var len = $(".form-control.requirements.edit").length;
					if(len>1)
						$(".form-control.requirements.edit").last().parent().parent().remove();
					else
						swal("Error","Sorry! You cannot delete the last requirement!","error");

				})
			})
		</script>
		<input type=hidden id='hidden_job_id' value="">
	  
      </div>
      <div class="modal-footer">
		<button id="edit_btn_save_job" type="submit" maxlength="80" class="btn btn-success btn-lg">Save</button>
        <button type="button" class="btn btn-lg btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
    </form>
  </div>
</div>

<!--Direct Chat-->
<div class="chat_window modal fade" id="directChat" role="dialog">
  <div class="top_menu">
      <div class="buttons">
        <div class="button close" data-dismiss="modal" title="Close"></div>
        <div class="button minimize" title="Back" data-toggle="modal" data-dismiss="modal" data-target="#chatList"></div>  
      </div>
      <div class="title"><img src="" id="top-image" alt="User Avatar" class="img-circle profile" width=70px></div>
  </div>
	<ul class="messages">
		<i class="fa fa-refresh fa-spin fa-3x fa-fw"></i>
		<span class="sr-only">Loading...</span>
	</ul>
	    <div class="bottom_wrapper clearfix">
	    	<div class="message_input_wrapper">
	     	<input type=text class="message_input" placeholder="Type your message here..."/>
	    </div>
	    <div class="send_message">
	      <div class="icon"></div>
	      <div class="text">Send</div>
	    </div>
  	</div>
</div>
<div class="message_template">
  <li class="message">
    <div class="avatar"><img src="" id="this-image" alt="User Avatar" class="img-circle" width=50px></div>
    <div class="text_wrapper">
        <div class="text"></div>
    </div>
  </li>
</div>

<div class="floating_div hide">
	<div class="alert alert-warning">
	  <strong>Warning!</strong> Please update the company profile before posting a job.
	</div>
</div>
<!--End of Direct Chat-->

<!--List of chats-->
<div class="chat_window modal fade" id="chatList" role="dialog">
  <div class="top_menu">
      <div class="buttons">
        <div class="button close" data-dismiss="modal" title="Close"></div>
      </div>      
      <div class="title">Direct Messages</div>
  </div>
  		
	<ul class="chat" id="chatListUL">
		
		<div class="chatlogs">

		</div>
	</ul>
</div>
<div id="uploadImage" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Upload Profile Image</h4>
      </div>
      <div class="modal-body">
		<div class="row">
			<div class="col-md-2"></div>
			<div class="col-md-2">
				<div id="upload-demo" style="width:350px"></div>
			</div>
		</div>       		
		<center>
			<label class="btn btn-success btn-file">
				Upload Image<input type="file" style="display: none;" id="upload">
			</label>
			<button class="btn btn-success upload-result" id="save-profile" disabled>Save Profile Image</button>
		</center>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>

<div id="uploadCompanyLogo" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Upload Profile Image</h4>
      </div>
      <div class="modal-body">
		<div class="row">
			<div class="col-md-2"></div>
			<div class="col-md-2">
				<div id="upload-company-logo" style="width:350px"></div>
			</div>
		</div>       		
		<center>
			<label class="btn btn-success btn-file">
				Upload Image<input type="file" style="display: none;" id="upload-company-logo-btn">
			</label>
			<button class="btn btn-success upload-logo" id="save-company-logo" disabled>Save Profile Image</button>
		</center>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>

<div class="overlay hidden" id="overlay"></div>

<script src="profile-pic.js"></script>
<script src="../validation_function/js/applicant_validation.js"></script>
<script src="/jobsearch/profile/Like-Request-Chat/js/app.js"></script>
<script type="text/javascript" src="/jobsearch/profile/Like-Request-Chat/js/request_user.js"></script>
<script type="text/javascript">
	setUserFunctions("<?php print $_SESSION['accno']; ?>","<?php print $_SESSION['utype']; ?>");	
</script>


</body>

<!-- Footer -->

</html>
