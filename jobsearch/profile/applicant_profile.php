<?php
	require $_SERVER['DOCUMENT_ROOT'] ."/DBConnectionString/dbconnect_class.php";
	if(isset($_SESSION['accno']))
	{
		if($_SESSION['utype']=="employer")
		{
			header("location:/jobsearch/profile/employer_profile.php");
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
		$accno = $_SESSION['accno'];
		$db_obj -> setQuery("Select * from applicant_tbl where accno=:accno");
		$result = $db_obj->executeQuery($array_params = array(":accno" => $accno),true);
		foreach($result as $row) {
			$lname = $row['lname'];
			$fname = $row['fname'];
			$password = $row['password'];
			$gender = $row['gender'];
			$description = $row['description'];
			$email = $row['email'];
			$cnum = $row['cnum'];
			$bday = $row['bday'];
			$min = $row['salary_range_min'];
			$pic = $row['pic'];
			$max = $row['salary_range_max'];
			$address = $row['address'];
			$phone_num = $row['home_phone_number'];
			if(empty($pic)){
				$link = "/jobsearch/employee.png";
			}
			else{
				$link = "upload/$pic";
			}
		}
	}
?>
<!DOCTYPE html>
<html>
<title>Applicant Profile</title>
<meta charset="UTF-8">
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<!-- jQuery library -->
<!-- Latest compiled JavaScript -->
<!--Bootstrap Plugins-->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"  type="text/javascript"></script>

<!-- Latest compiled JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<!--End of Bootstrap-->



<link rel="stylesheet" href="hoverimage.css">
<link rel="stylesheet" href="w3.css">
<link rel="stylesheet" href="css/button.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<!-- Important Functions -->

<!--<script src="../Like/notification-function.js"></script>-->

<script src="../validation_function/dist/jquery.validate.js"></script>

<script src="Croppie-master/croppie.js"></script>
<link rel="stylesheet" href="Croppie-master/croppie.css">

<script src="https://www.gstatic.com/firebasejs/4.0.0/firebase.js"></script>
<link rel="stylesheet" href="iHover/ihover.css">
<script src="../select-region/regions.js"></script>
<!--Sweet Alert-->
<script src="sweetalert2/sweetalert2.min.js"></script>
<link rel="stylesheet" href="sweetalert2/sweetalert2.min.css">
<!--End of Sweet Alert -->
<link rel="stylesheet" href="css/applicant.css">
<script src="autofill_textbox.js"></script>

<link rel="stylesheet" type="text/css" href="../chat/style2.css">
<link rel="stylesheet" type="text/css" href="../chat/style.css">

<!--Notyf.css-->
<script src="notif/notyf.min.js"></script>
<link rel="stylesheet" type="text/css" href="notif/notyf.min.css">

<script type="text/javascript" src="/jobsearch/js/jquery-ui-1.12.1/jquery-ui.min.js"></script>
<link rel="stylesheet" type="text/css" href="/jobsearch/js/jquery-ui-1.12.1/jquery-ui.min.css">
<!--End of Notif.css-->
<link rel="stylesheet" type="text/css" href="css/loader.css">

<!--Class for Sliders-->
  <script src="/jobsearch/slider/wNumb.js"></script>
  <script src="/jobsearch/slider/nouislider.js"></script>
  <link rel="stylesheet" type="text/css" href="/jobsearch/slider/nouislider.css">

  <!--End of Class for Sliders-->
  


<script>
	$(window).on('load',function(){
		setTimeout(function(){
			$('.loader-container').fadeOut('slow');
		},2000);
	});
	$(document).ready(function(){
		$("ul").on('click','.show_Message',function(){
			$("#chatList").modal('show');
		})	
		
		$("#list_education .btn.btn-danger.remove").click(function(){			
			var education_id = $(this).parent().parent().attr("id");
			var selector = "#list_education #" +education_id; 
			delete_field(selector,education_id,"education");
		});
		
		$("#list_education .btn.btn-success.edit").click(function(){
			var education_id = $(this).parent().parent().attr("id");
			var count=0;
			$.post("profile_import.php?display_what=education",{id:education_id},function(response){
				var data = $.parseJSON(response);
				$("#education_Modal").find("#edit_saved_education").children("select, input").each(function(){
					$(this).val(data[count]).change();
					count+=1;									
				});
				$("#education_Modal").modal("show");
				$("#hidden_education_id").val(education_id);
			});
		});

		$("#seminars_list .btn.btn-success.edit").click(function(){
			var id = $(this).parent().parent().attr("id");
			var count = 0,data,city_name; 
			$.post("profile_import.php?display_what=seminar",{id:id},function(response){
				data = $.parseJSON(response);
				$("#seminars_modal").find("#edit_saved_seminar").children("input").each(function(){
					$(this).val(data[count]).change();
					count+=1;									
				});
				$("#hidden_seminar_id").val(id);
				$('#seminars_modal #list_of_regions option[value="' + data[5] + '"]').attr("selected", "selected").change();

				city_name = data[6];
				
			}).done(function(){				
				$('#seminars_modal #list_of_cities').on('something',function(){
					$('#seminars_modal #list_of_cities').val(city_name);
				})
				
				$("#seminars_modal").modal("show");
			})
			
		})
		$("#seminars_list .btn.btn-danger.remove").click(function(){
			var id = $(this).parent().parent().attr("id");
			var selector = "#seminars_list #"+id;
			delete_field(selector,id,"certifications")
		})
	});

</script>
<script>
	//notification_function();
</script>
<!--<script>		
	$(function(){
		$("#matches_hover").on('click','.unmatch',function(){
			var otherid = $(this).parent().attr("id");
			removeMatching(otherid);
		})
		
		listmatches();
		function listChatUser(){
			$.post( "../chat/a.php", function( data ) {
			  $( "#chatListUL" ).html( data );
			});
		}
		listChatUser();
		$('#number_of_matches').on('DOMSubtreeModified',function(){
			listChatUser();
		})

	})
</script>-->


<script>
$(function(){
	$("#show_radio").click(function(){
		$(".my_experience_type_saved").addClass("hidden");
		$("#my_experience_type").removeClass("hidden");
	})
	$("#unshow_radio").click(function(){
		$(".my_experience_type_saved").removeClass("hidden");
		$("#my_experience_type").addClass("hidden");
	})
	$(".new_exp").change(function(){
		var text = $(this).next().text();
		$.post("profile_import.php?action=update_level_experience",{exp:text},function(){
			$(".my_experience_type_saved").removeClass("hidden");
			$("#my_experience_type").addClass("hidden");
			$("#saved_experience_level").html(text);
		});

	})

})
</script>
<script>
$(function(){
  	function text(len){
		$("#num_text").html(len)
	}
	text();
	$("textarea").on('keydown keypress keyup',function(){
		text($(this).val().length);	
	})

})
</script>
<script type="text/javascript">
	 
</script>
<script>
$(document).ready(function(){		
	$("#link_experience").css("background-color",'#eee');	
	$("#education").hide();
	$("#experience").show();
	$("#skills").hide();
	$("#aboutme").hide();
	$("#matches").hide();
	$("#seminars_attanded").hide();
	$(".profile").click(function(){
		var $id = $(this).attr('id');
		if($id=='link_experience'){
			$("#education").hide();
			$id = "#experience";
			$("#skills").hide();
			$("#aboutme").hide();
			$("#matches").hide();
			$("#seminars_attanded").hide();
		}
		else if($id=="link_seminars"){
			$("#education").hide();
			$("#experience").hide();
			$("#skills").hide();
			$("#aboutme").hide();
			$("#matches").hide();
			$id = "#seminars_attanded";

		}
		else if($id=='link_education'){
			$id = "#education";
			$("#experience").hide();
			$("#skills").hide();
			$("#aboutme").hide();
			$("#matches").hide();
			$("#seminars_attanded").hide();
		}
		else if($id=='link_skills'){
			$("#education").hide();
			$("#experience").hide();
			$id = "#skills";
			$("#aboutme").hide();
			$("#matches").hide();
			$("#seminars_attanded").hide();
		}
		else if($id=='link_about'){
			$("#education").hide();
			$("#experience").hide();
			$("#skills").hide();
			$id = "#aboutme";
			$("#matches").hide();
			$("#seminars_attanded").hide();
		}
		else if($id=='link_matches'){
			$("#education").hide();
			$("#experience").hide();
			$("#skills").hide();
			$("#aboutme").hide();
			$id = "#matches";
			$("#seminars_attanded").hide();
		}
		$(".profile").css("background-color",'white');	
		$(this).css("background-color",'#eee');	
		$($id).show();	
		$('html,body').animate({
		   scrollTop: $($id).offset().top - 90
		});
	});
	$(".notification").on('click','.matches-notif',function(){		
		$("#education").hide();
		$("#experience").hide();
		$("#skills").hide();
		$("#aboutme").hide();
		$("#matches").show();
		$(".profile").css("background-color",'white');
		$("#link_matches").css("background-color",'#eee');
	});
	$("#round_print_button").click(function(){
		$(".resume-templates-container").show();
		$("#overlay").removeClass("hidden");
	})
	$(".close-button").click(function(){
		$("#overlay").addClass("hidden");
		$(".resume-templates-container").hide();
	})
	
});
</script>
<style type="text/css">
	.carousel{
    background: #2f4357;
    margin-top: 20px;

}
.carousel .item{
    min-height: 320px; /* Prevent carousel from being distorted if for some reason image doesn't load */
}
.carousel .item img{
    margin: 0 auto;
    height:280px;
    margin-top: 20px;
     /* Align slide image horizontally center */
}
.carousel-option{
	text-shadow:
       3px 3px 0 #000,
     -1px -1px 0 #000,  
      1px -1px 0 #000,
      -1px 1px 0 #000,
       1px 1px 0 #000;
}

.bs-example{
	margin: 20px;
}
.close-button{

}
</style>
</head>
<section class="loader-container">
	<div class="cssload-loader">Loading</div>
</section>
<body class="w3-light-grey margin">
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
                <li class='nav-item'>
                   <a href="../job_search.php"><i class="fa fa-search"></i> Find Job</a>
                </li>
                <li id="notification_li" class='nav-item'>
					<span id="my-notif-count"></span>
					<a href="#" id="notificationLink"><i class="fa fa-bell"></i>&nbsp;Notifications</a>

				</li>
				<li class="page-scroll nav-item">
					<span id="number_of_matches"></span>
                    <a data-toggle="modal" data-target="#chatList" id="openChatList"><i class="fa fa-weixin" aria-hidden="true"></i> Chat Room</a>
                    <script>
                    	$(function(){
                    		$("#openChatList").click(function(){
                    			$('html,body').animate({
								   scrollTop: 0
								});
                    		})
                    	})
                    </script>
                </li>                     
                <li class='nav-item'>
                   <a href="../index.php?logout=true"><i class="fa fa-power-off"></i> Log-Out</a>
                </li>
            </ul>
        </div>
        <!-- /.navbar-collapse -->
     </div>
    <!-- /.container-fluid -->
</nav> 

<!--Div for notifications-->
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
<!--End of notifications div-->	
<!-- Page Container -->

<div class="bottom-container">
	<div class="floating_button_set">
		<button class="round_print_button" id="round_print_button">Choose my Resume</button>
	</div>
	<div class="resume-templates-container" style="display: none">


		<h2>List of Resumes</h2>
		<hr>
		<div class="bs-example">
	    <div id="myCarousel" class="carousel slide" data-interval="3000" data-ride="carousel">
	    	<!-- Carousel indicators -->
	        <ol class="carousel-indicators">
	            <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
	            <li data-target="#myCarousel" data-slide-to="1"></li>
	            <li data-target="#myCarousel" data-slide-to="2"></li>
	        </ol>   
	        <!-- Wrapper for carousel items -->
	        <div class="carousel-inner">
	            <div class="active item">
	                <img src="/jobsearch/resume/resume1.png">
	         		<div class="carousel-caption">
	                  <button class="set-resume btn btn-info" resume-name="resume1">Select this Resume!</button>
	                </div>
	            </div>
	            <div class="item">
	                <img src="/jobsearch/resume/resume2.png">
	                <div class="carousel-caption">
	                  <button class="set-resume btn btn-info" resume-name="resume2">Select this Resume!</button>
	                </div>
	            </div>
	            <div class="item">
	                <img src="/jobsearch/resume/resume3.png">
	                <div class="carousel-caption">
	                  <button class="set-resume btn btn-info" resume-name="resume3">Select this Resume!</button>
	                </div>
	            </div>
	        </div>
	        <!-- Carousel controls -->
	        <a class="carousel-control left" href="#myCarousel" data-slide="prev">
	            <span class="glyphicon glyphicon-chevron-left"></span>
	        </a>
	        <a class="carousel-control right" href="#myCarousel" data-slide="next">
	            <span class="glyphicon glyphicon-chevron-right"></span>
	        </a>
	    </div>
	    <div class="bottom">
	    	<button class="btn btn-primary go-to-resume">Go to my resume</button>
	    	<button class="btn btn-danger close-button">Close</button>
			
	    </div>
</div>
		
	</div>
</div>

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
				<div class="ih-item circle effect5"><a data-toggle="modal" data-target="#myModal">
				<img src="<?php print $link; ?>" id="my-image2" alt="img" style="border-radius: 50%">
				<div class="info">
				  <div class="info-back">
					<h3><i class="fa fa-instagram fa-lg"></i></h3>
				  </div>
				</div></a></div>
			</center>
			<!-- end normal -->        
		 <hr>
         <ul style="list-style: none;margin:0;padding:0" class="user_profile">
			<li><a class="profile" id="link_experience" title="This tab allows you the user to add any of your past job experiences."><i class="fa fa-briefcase fa-fw w3-margin-right w3-large w3-text-teal"></i>Experience</p></a></li>
			<li><a class="profile" id="link_about"><i class="fa fa-user fa-fw w3-margin-right w3-large w3-text-teal"></i>About Me</p></a></li>
			<li><a class="profile" id="link_education"><i class="fa fa-graduation-cap fa-fw w3-margin-right w3-large w3-text-teal"></i>Education</p></a></li>
			<li><a class="profile" id="link_skills"><i class="fa fa-suitcase fa-fw w3-margin-right w3-large w3-text-teal"></i>Skills</p></a></li>
			<li><a class="profile" id="link_seminars"><i class="fa fa-certificate fa-fw w3-margin-right w3-large w3-text-teal"></i>Seminars Attended</p></a></li>
			<li><a class="profile" id="link_matches"><i class="fa fa-thumbs-up fa-fw w3-margin-right w3-large w3-text-teal"></i>Matches				
				<span id="notification_count" class="w3-badge w3-green"></span>
			</p></a></li>
			
		</ul>
		<hr>
        </div>
      </div>
    <!-- End Left Column -->
    </div>

    <!-- Right Column -->
    <div class="w3-twothird">
    <!--About Me-->

	<div id="aboutme">
		
		<script>
			$(document).ready(function(){
				var $lname,$fname,$cnum,$gender,$bday,$min,$email,$max,$slider;
				$( "#min_salary_range" ).val("<?php print $min;?>");
				$( "#max_salary_range" ).val("<?php print $max;?>");
				$slider = document.getElementById("keypress");
				$slider.setAttribute("disabled",true);
				$("#btn_save_abtme").prop("disabled",true);	
				$("#cancel_abtme_save").hide();	
				$("#edit_abtme").on('click',function(){
				
					$fname = $( "#firstname" ).val();
					$lname = $( "#lastname" ).val();
					$cnum = $( "#cnum" ).val();
					$gender = $( "#gender" ).find(":selected").text();
					$bday = $( "#bday" ).val();
					$min = $( "#min_salary_range" ).val();
					$max = $( "#max_salary_range" ).val();
					$email = $( "#email" ).val();
					$address = $( "#address" ).val();
					$home_num = $( "#home_num" ).val();
					$( "#home_num" ).prop( "disabled", false );
					$( "#lastname" ).prop( "disabled", false );
					$( "#firstname" ).prop( "disabled", false );
					$( "#address" ).prop( "disabled", false );
					$( "#home_num" ).prop( "disabled", false );
					$( "#bday" ).prop( "disabled", false );
					$( "#cnum" ).prop( "disabled", false );
					$( "#gender" ).prop("disabled",false);
					$( "#min_salary_range" ).prop( "disabled", false );
					$( "#max_salary_range" ).prop( "disabled", false );
					$( "#self_desc" ).prop( "disabled", false );
					$("#edit_abtme").hide();
					$("#cancel_abtme_save").show();

					$slider.removeAttribute("disabled");
					$( "#btn_save_abtme" ).prop( "disabled", false);
				});
				$("#cancel_abtme_save").on('click',function(){	
					$( "#address" ).prop( "disabled", true ).prop("value",$address);
					$( "#home_num" ).prop( "disabled", true ).prop("value",$home_num);		
					$( "#firstname" ).prop( "disabled", true ).prop("value",$fname);
					$( "#lastname" ).prop( "disabled", true ).prop("value",$lname);
					$( "#cnum" ).prop( "disabled", true ).prop("value",$cnum);	
					$( "#bday" ).prop( "disabled", true ).prop("value",$bday);
					$( "#gender" ).prop("disabled",true).prop("selected",$gender);
					$( "#min_salary_range" ).prop( "disabled", true ).prop("value",$min);
					$( "#max_salary_range" ).prop( "disabled", true ).prop("value",$max);
					$( "#self_desc" ).prop( "disabled", true ).prop("value",$email);
					$( "#btn_save_abtme" ).prop( "disabled", true);
					$slider.setAttribute("disabled",true);
					$("#edit_abtme").show();
					$("#cancel_abtme_save").hide();
				});
			});
		</script>
		
		<div class="w3-container w3-card-2 w3-white w3-margin-bottom">
			<div class="wrapper">
				<div class="header-container">
					<h2 class="w3-text-grey w3-padding-16 w3-no-break"><i class="fa fa-user fa-fw w3-margin-right w3-xxlarge w3-text-teal"></i>About Me</h2>
					<a href="/jobsearch/help/faq-template/applicant_help.html#about_me" class="trigger-help btn btn-info" target="_blank">?</a>
				</div>
			</div>
			
			<script type="text/javascript">
				$(function(){
					$('.trigger-help').click(function(){
						var $otherModal = $(this).attr("trigger");
						$("#"+$otherModal).show();
					})
					$('.close-help').click(function(){
						var target = $(this).attr("target");	
						$("#"+target).hide();
					})
				})
				
			</script>
			<div class="w3-container">
				<form method=post id="form_abtme">	
					
					<label class="w3-label w3-text-black"><b>First Name</b></label>
					<input class="form-control" type="text" name="firstname" id="firstname" value='<?php print $fname; ?>' disabled required>
					<div id="errors"></div>
 
					<label class="w3-label w3-text-black"><b>Last Name</b></label>
					<input class="form-control" name="lastname" id="lastname" type="text" value='<?php print $lname; ?>' disabled required>
					<div id="errors"></div>

				
					<label class="w3-label w3-text-black"><b>Gender</b></label>
						<select class="form-control" id="gender" name=gender disabled required>
							<option value="Male" <?php if(strtolower($gender)==='male') print 'selected'; ?>>Male</option>
							<option value="Female" <?php if(strtolower($gender)==='female') print 'selected'; ?>>Female</option>
						</select>
				
					<label class="w3-label w3-text-black"><b>Birthday</b></label>
					<input type="date" class="form-control" id="bday" name="bday" min="1979-01-01" value='<?php print $bday;?>' max=<?php print date("Y-m-d") ?> disabled required></b>
					
					
					
					<label class="w3-label w3-text-black"><b>Cellphone Number</b></label>
					<div style="display: flex">
                  		<input value="+63" type="text" pattern="[0-9]*" class="form-control"  disabled style="width:80px !important;">
						<input class="form-control" name="cnum" id="cnum" value='<?php print $cnum;?>' style="width: 85%" type="text" disabled required>
					</div>
					<div id="errors"></div>

					<label class="w3-label w3-text-black"><b>Address</b></label>
					<input class="form-control" name="address" id="address"  value='<?php print $address;?>'  disabled required>
					<div id="errors"></div>	

					<label class="w3-label w3-text-black"><b>Home Phone Number (optional):</b></label>
					<input class="form-control" name="home_num" id="home_num"  value='<?php print $phone_num;?>' disabled>
					<div id="errors"></div>	
					
					<label class="w3-label w3-text-black"><b>Salary Range</b></label>
					<!--this is the slider for the salary range.-->
					<fieldset style="border:none">
	                  <div id="keypress"></div>
	                  <label> Minimum Range:</label>
	                  <input id="min_salary_range" class="form-control" name="min_salary_range" value="<?php print $min;?>" disabled required>
	                  <label> Maximum Range:</label>
	                  <input id="max_salary_range" class="form-control" name="max_salary_range" value="<?php print $max;?>" disabled required>
	                </fieldset>
					<!-- end of the salary range -->
					<!-- <input class="form-control" name="app_min_salary" id="app_min_salary" type="tel"  value='<?php print $salary;?>' min=1000 disabled required>
					<div id="errors"></div>	 -->
					
					<label class="w3-label w3-text-black"><b>Information about myself</b></label>
					<textarea class="form-control" name="self_desc" id="self_desc" rows="20" cols="20" value='' disabled required><?php print $description;?></textarea>

					<br><center>
					<button name="btn_save_abtme" id="btn_save_abtme" type="submit" maxlength="80" class="btn btn-success">Save</button>
					<button name="edit_abtme" id="edit_abtme" type="button" maxlength="80" class="btn btn-success">Edit</button>
					<button name="cancel_abtme_save" id="cancel_abtme_save" type="button" maxlength="80" class="btn btn-success">Cancel</button>
					</center>
					<br>
				</form>
			</div>
		</div>
		
	</div>
	<!--About Me-->

	<!--List of Skills-->
	<div id="skills">
		<script>
			$(document).ready(function(){
				$("#my_add_skills").hide();
				$("#add_skills_for_me").click(function(){			
					$("#my_add_skills").show();
					$("#add_skills_for_me").hide();
				});
				$("#close_add_skills").click(function(){			
					$("#my_add_skills").hide();
					$("#add_skills_for_me").show();
				});
			});
		</script>
		
		
		<div id="my_add_skills">
			<div class="w3-container w3-card-2 w3-white w3-margin-bottom">

				<h2 class="w3-text-grey w3-padding-16"><i class="fa fa-suitcase fa-fw w3-margin-right w3-xxlarge w3-text-teal"></i>Add Skills</h2>
					<form method=post name="add_new_skills">						
						<label class="w3-label w3-text-black"><b>Skill Name</b></label>
						<input class="form-control"  name="skills_select" id="skills_select" onkeyup="skillsFilter(this)">
						
						<label class="w3-label w3-text-black"><b>Profiency Level</b></label>
						<input class="form-control" name="prof_level" id="prof_level" type="number" min=1 max=5>

						<br>
						<center>
							<button name="btn_add_skills" id="btn_add_skills" type="submit" maxlength="80" class="btn btn-success">Save</button>
							<button name="close_add_skills" id="close_add_skills" type="button" maxlength="80" class="btn btn-success">Close</button>
						</center>
						<br><br>
					</form>
			</div>
					
		</div>
		<div id="list_of_skills">
			<div class="w3-container w3-card-2 w3-white w3-margin-bottom">
				<div class="wrapper">
					<div class="header-container">
						<h2 class="w3-text-grey w3-padding-16 w3-no-break"><i class="fa fa-briefcase fa-fw w3-margin-right w3-xxlarge w3-text-teal"></i>Skills</h2>
						<a href="/jobsearch/help/faq-template/applicant_help.html#skills" class="trigger-help btn btn-info" target="_blank">?</a>
					</div>
				</div>
				
				<a id="add_skills_for_me" style="float:right;">+Add Skills</a><br>
				<div id="success_skills" class="alert alert-success hide"></div>
				<div class="w3-container">
					<h5 class="w3-opacity"><b>My Skills</b></h5>
					<ul style="list-style:none;">
						<?php
							$myaccno = $_SESSION['accno'];
							$db_obj-> setQuery("select * from applicant_skills where accno=:accno");
							$result = $db_obj->executeQuery($array_params = array(":accno" => $myaccno),true);
							$count = $db_obj->returnCount();
							if($count!=0){
								foreach ($result as $row) {
									$skill_name = $row['name'];
									$level = $row['level'];
									$id = $row['id'];
									$skill_width = $level * 20;
									print "<li class=row id='$id'>												
												 <div class='col-md-9'>
												 <b>$skill_name</b>
												 <div class='w3-progress-container w3-round-xlarge w3-small'>
													<div class='w3-progressbar w3-round-xlarge w3-teal' style='width:$skill_width%'>
														<div class='w3-center w3-text-white'>$level</div>
													</div>
												</div>
												 </div>
												 <div class='col-md-3 pull-right'>
													<button id='button1' class='btn btn-success edit'>
														<i class='glyphicon glyphicon-pencil'></i>
													</button>
													<button id='button2' class='btn btn-danger remove'>
														<i class='glyphicon glyphicon-remove'></i>
													</button>
												</div>
												
										   </li>";
								}								
							}
							
							
							else
							{
								print "You have not added your skills yet. Press the button above to add one";
							}
						?>
					</ul>
					<?php $skills_count = $count ?>
				</div>
				<script>
					$(document).ready(function(){
						$("#list_of_skills .btn.btn-danger.remove").click(function(){			
							var skill_id = $(this).parent().parent().attr("id");
							var selector = "#list_of_skills #" +skill_id; 
							delete_field(selector,skill_id,"skills");
						});
						
						$("#list_of_skills .btn.btn-success.edit").click(function(){
							var skill_id = $(this).parent().parent().attr("id");
							var count=0;
							$.post("profile_import.php?display_what=skill",{id:skill_id},function(response){
								var data = $.parseJSON(response);
								$("#skills_modal").find("#edit_saved_skills").children("input").each(function(){
									$(this).val(data[count]);			
									count+=1;									
								});					
								$("#hidden_skills_id").val(skill_id);								
								$("#skills_modal").modal("show");
								
							});
						});
					});
				</script>
			</div>
		</div>
	</div>
	<!--End List of Skills-->

		
	
    <!--Work Experience-->
	<div id="experience">
	  <!--Post Work Experience-->
	  <div class="w3-container w3-card-2 w3-white w3-margin-bottom">
			
			<div class="wrapper">
				<div class="header-container">
					<h2 class="w3-text-grey w3-padding-16 w3-no-break"><i class="fa fa-briefcase fa-fw w3-margin-right w3-xxlarge w3-text-teal"></i>Add Work Experience</h2>
					<a href="/jobsearch/help/faq-template/applicant_help.html#applicant_experience" target="_blank" class="trigger-help btn btn-info">?</a>
				</div>
			</div>
			
			<label>Fill this first before adding a work experience. Please note that whatever is checked here will be shown on your profile. </label>
			<center>
			<div class="my_experience_type_saved">
				<button id="show_radio" class="btn btn-default pull-right"><i class="glyphicon glyphicon-pencil"></i></button>
				<br><br><div id="saved_experience_level">
					<?php
						$var = $_SESSION['accno'];
						$db_obj -> setQuery("select job_experience_level from applicant_tbl where accno= :accno");
						$result = $db_obj ->executeQuery(array(":accno" => $var),$fetch = true);
						$count = $db_obj->returnCount();
						if($count==0){
							print "You have not selected anything";
						}
						else{
							foreach ($result as $row) {
								$exp_type = $row['job_experience_level'];
								print $exp_type;
							}
							
						}
					?>
				
				</div>
				
			</div>
			</center>

			<div id="my_experience_type" class="hidden">
				<ul style="list-style:none">
					<li>
						<input type="radio" class="new_exp" name="new_exp" id="w_exp_student"><label class='unbolded-label'>I am a fresh graduate seeking my first job</label>
					</li>
					<li>
						<input type="radio" class="new_exp" name="new_exp" id="w_exp_veteran"><label class='unbolded-label'>I have been working for a long time now</label>
					</li>
					<li>
						<input type="radio" class="new_exp" name="new_exp" id="w_exp_part_time"><label class='unbolded-label'>I am a student seeking a part-time job</label>
					</li>
					<li>
						<input type="radio" class="new_exp" name="new_exp" id="w_exp_part_time"><label class='unbolded-label'>I am an experienced worker, but I have only finished high school</label>
					</li>
				</ul>					
				<center>
					<button id="unshow_radio" class="btn btn-danger"><i class="glyphicon glyphicon-remove"></i>Cancel</button>
				</center>
			</div>
			<div class="w3-container" id="add_experiece">
				<hr>
				<b><center>Post your Experience</center></b><br>
				<form name="post_new_experience">
					<label class="w3-label w3-text-black"><b>Position Title</b></label>
					<input class="form-control" name="position_title" id="position_title" type="text" required>
					
					<label class="w3-label w3-text-black"><b>Company Name</b></label>
					<input class="form-control" id="company_name" name="company_name" type="text" maxlength="80" value="" required>
					
					<div class="w3-half">
						<label class="w3-label w3-text-black"><b>Year Started</b></label>
						<select class="form-control" name="start_year" id="start_year" placeholder="Start Year" required>
							<?php
								for($i = 1960;$i<=2017;$i++)
									print "<option value='$i'>$i</option>"
							?>
						</select>
					</div>
					
					<div class="w3-half">
						<label class="w3-label w3-text-black">Year Ended</label>
						<select class="form-control" id="end_year" name="end_year" placeholder="End Year" required>
							<?php
								for($i = 1960;$i<=2017;$i++)
									print "<option value='$i'>$i</option>"
							?>
						</select>
					</div>
					
					
					<label class="w3-label w3-text-black"><b>Specialization</b></label>
					<select class="form-control" id="spec" name="spec" required>
					<?php
						$db_obj-> setQuery("select DISTINCT(cat) from specialization ORDER BY cat");
						$result = $db_obj->executeQuery($array_params = array(),true);
						foreach ($result as $row) {
							$cat = $row['cat'];
							print "<optgroup label='$cat'>";
							$spec_db_connection = new DatabaseConnection();
							$spec_db_connection -> setQuery("select specialization_name from specialization where cat = :cat ORDER BY specialization_name");
							$result_spec =  $spec_db_connection->executeQuery(array(":cat" => $cat) , true);
							foreach ($result_spec as $row_spec) {
								$spec = $row_spec['specialization_name'];
								print "<option value='$spec'>$spec</option>";
							}
							print "</optgroup>";
						}
					?>
					</select>
					<label class="w3-label w3-text-black"><b>Role</b></label>
					<input class="form-control" id="role" name="role" type="text" maxlength="80" value="" required>
					
					<label class="w3-label w3-text-black"><b>Position Level</b></label>
					<select class="form-control" id="pos_level" name="pos_level" required>
						<option value="CEO/SVP/AVP/VP/Director">CEO/SVP/AVP/VP/Director</option>
						<option value="Assistant Manager/Manager">Assistant Manager/Manager</option>
						<option value="Supervisor/5 years & Up Experienced Employee">Supervisor/5 years & Up Experienced Employee</option>
						<option value="Fresh Grad">Fresh Grad</option>
					</select>
					
					<label class="w3-label w3-text-black"><b>Monthly Salary</b></label>

					<div class="row">
						<div class="col-xs-6 col-sm-4">
							<input type="text" value="PHP" class="form-control" disabled>
						</div>
						<div class="col-xs-6 col-sm-4">
							<input class="form-control" id="salary" name="salary" type="number" value="" aria-required="false" required="false">
						</div>
					</div>
					<label class="w3-label w3-text-black"><b>More info on your Experience(optional)</b></label>
					<textarea class="form-control" id="exp" name="exp" type="text" maxlength="3500" cols="20" rows="20" value="" required></textarea>
					<div class="pull-right">
						<div id="num_text" class="pull-left">0</div>&nbsp; characters of 3500
					</div>
					<br>
					<center>
						<button name="add_exp" id="add_exp_btn" type="submit" maxlength="80" class="btn btn-success">Save</button>
						<button name="clear_exp" id="clear_exp" type="button" maxlength="80" class="btn btn-success">Close</button>
					</center>
					<br><br>
				</form>
			</div>
	  </div>
	  
	  <!--Populate using PHP -->
      <div class="w3-container w3-card-2 w3-white w3-margin-bottom">
        <h2 class="w3-text-grey w3-padding-16"><i class="fa fa-suitcase fa-fw w3-margin-right w3-xxlarge w3-text-teal"></i>Work Experience</h2>
        <div id="my-work-exp">
        	<?php
        		$accno = $_SESSION['accno'];
        		$db_obj -> setQuery("select * from applicant_exp where applicant_id =:accno");
        		$result = $db_obj -> executeQuery(array(":accno" => $accno) , true);
        		$count = $db_obj -> returnCount();
        		if($count ==0)
        			print "<center><label>Sorry! No records are saved</label></center>";
        		else{
	        		foreach ($result as $row) {
	        			$position_title = $row['position_title'];
	        			$company_name = $row['company_name'];
	        			$exp = $row['experience'];
	        			$start_year = $row['year_started'];
	        			$end_year = $row['year_ended'];
	        			$spec = $row['spec'];
	        			$role = $row['role'];
	        			$pos_level = $row['pos_level'];
	        			print "<div class='w3-container'>
		          			<h5 class='w3-opacity'><b>$position_title / $company_name</b></h5>
		          			";
		          		print "<h6 class='w3-text-teal'><i class='fa fa-calendar fa-fw w3-margin-right'></i>$start_year - <span class='w3-tag w3-teal w3-round'>$end_year</span></h6>";
		          			if($exp!=''){
		          				print "<p>Experience Information: $exp</p>";
		          			}
		          			print "<label>More Information</label>
		          					<ul>";
		          			print "<li>Specialization:&nbsp; $spec</li>";
		          			print "<li>Role:&nbsp;$role</li>";
		          			print "<li>Position Level:&nbsp;$pos_level</li>";
		          			print "</ul><hr></div>";
	        		}
        		}
        	?>
	    </div>
	  </div>
	</div>
	
	<!--End Work Experience-->

	<!--Education-->
	<div id="education">
		<script>
			$(document).ready(function(){
				$("#my_add_education").hide();
				$("#add_education").click(function(){
					$("#my_add_education").show();
					$("#add_education").hide();
				});
				$("#hide_education").click(function(){
					$("#my_add_education").hide();
					$("#add_education").show();
				});
				
				
			});
		</script>
	  <div id="my_add_education">	
		<div class="w3-container w3-card-2 w3-white w3-white w3-margin-bottom">
        			
		   <div class="w3-container">
		   		<div class="wrapper">
					<div class="header-container">
						<h2 class="w3-text-grey w3-padding-16 w3-no-break"><i class="fa fa-graduation-cap fa-fw w3-margin-right w3-xxlarge w3-text-teal"></i>Add New Education</h2>
					</div>
				</div>
				<form method=post name="form_education">
					<label class="w3-label w3-text-black"><b>Institute/University</b></label>
					<input class="form-control" type="text" id="university" name="university" index="0" maxlength="80" onkeyup="educationFilter(this)" required>
					<!--Fill with PHP-->                       				
					<label class="w3-label w3-text-black"><b>Qualification</b></label>
					<select class="form-control" id="quali" name="quali" required>
							<option value="Bachelors/College Degree">Bachelors/College Degree</option>
							<option value="Post Graduate Diploma/Masters Degree">Post Graduate Diploma/Masters Degree</option>
							<option value="Professional License(Passed Board/Bar/Professional License Exam)">Professional License(Passed Board/Bar/Professional License Exam)</option>
							<option value="Doctorate Degree">Doctorate Degree</option>
							<option value="Vocational Diploma/Short Course Certificate">Vocational Diploma/Short Course Certificate</option>
							<option value="High School Diploma">High School Diploma</option>
							<option value="Elementary School Diploma">Elementary School Diploma</option>
					</select>		
					<!-- Disable or remove if High School or Elementary Diploma is chosen -->
					<div class="if-higher-highschool">
						<label class="w3-label w3-text-black">Field of Study</label>
						<select class="form-control" id="field_of_study">
						<?php
							$db_obj ->setQuery("select * from fields_study");
							$res = $db_obj->executeQuery(array(),true);
							foreach ($res as $row) {						
								$field_name = $row['field_name'];
								print "<option value='$field_name'>$field_name</option>";
							} 
						?>
					    </select>

					    <label class="w3-label w3-text-black">Major</label>
					    <input class="form-control" id="major">		
					</div>
					<script type="text/javascript">
						$(function(){
							$("#quali").change(function(){
								var $quali = $("#quali").val()
								if($quali == "High School Diploma" || $quali =="Elementary School Diploma"){
									$(".if-higher-highschool").hide();
								}
								else{
									$(".if-higher-highschool").show();	
								}
							})
						})
					</script>	    	
					
					<div class="w3-half">
						<label class="w3-label w3-text-black"><b>Year Started</b></label>
						<select class="form-control" name="ed_start_year" id="ed_start_year" index>
						<?php
							$limit = date('Y');
							for($i=1960;$i<=$limit;$i++)
							{
								print "<option name=$i>$i</option>";
							}
						?>
						</select>
					</div>
				
					<div class="w3-half">
						<label class="w3-label w3-text-black">Year Ended</label>
						<select class="form-control" name="ed_end_year" id="ed_end_year">
						<?php
							$limit = date('Y');
							for($i=1960;$i<=$limit;$i++)
							{
								print "<option name=$i>$i</option>";
							}
						?>
						</select>
					</div>
					<div class="year error"></div>
					<br><br>
					<center>
					<br><br>	
					<button id="save_education" name="save_education" type="submit" class="btn btn-success">Save</button>
					<button id="hide_education" name="hide_education" type="button" class="btn btn-success">Cancel</button>
					<br><br>
					</center>
				</form>
		  </div>
		  
		</div>
	  </div>
	  <div id="list_education">
		  <div class="w3-container w3-card-2 w3-white w3-white w3-margin-bottom">
			<div class="wrapper">
				<div class="header-container">
					<h2 class="w3-text-grey w3-padding-16 w3-no-break"><i class="fa fa-graduation-cap fa-fw w3-margin-right w3-xxlarge w3-text-teal"></i>Education</h2>
					<a href="/jobsearch/help/faq-template/applicant_help.html#education" class="trigger-help btn btn-info" target="_blank">?</a>
				</div>
			</div>
			
			<a id="add_education" style="float:right;">+Add Education</a><br>
			<div class="w3-container">
				<h5 class="w3-opacity"><b>My Education</b></h5>
				<div id="success" class="alert alert-success hide"></div>
					
				<?php
					$id = $_SESSION['accno'];
					$db_obj->setQuery("Select * from applicant_education where app_id=:accno");
					$res = $db_obj->executeQuery(array(':accno' => $id ),true);
					$count = $db_obj->returnCount();
					if($count!=0){
						foreach ($res as $row) {
							$univ_name = $row['univ_name'];
							$quali = $row['qualification'];
							$field_of_study = $row['field_of_study'];
							$major = $row['major'];
							$start_year = $row['start_year'];
							$end_year = $row['end_year'];
							$id = $row['id'];
							print "<div class='w3-container' id='$id'>		  		  	  
								<h5 class='w3-opacity'><b>$univ_name</b></h5>
										<div style='float:right'>
											<button id='button1' class='btn btn-success edit'>
												<i class='glyphicon glyphicon-pencil'></i>Edit
											</button>
											<button id='button2' class='btn btn-danger remove'>
												<i class='glyphicon glyphicon-remove'></i>Remove
											</button>
										</div>
								<h6 class='w3-text-teal'><i class='fa fa-calendar fa-fw w3-margin-right'></i>$start_year - $end_year</h6>";
							if($quali != "High School Diploma" && $quali != " Elementary School Diploma"){
								print "<b>More Information:</b>
								<ul>
									<li>Field of Study: $field_of_study</li>
									<li>Major: $major</li>
									<li>Qualification: $quali</li>
								</ul>	
								";
							}
							print "<hr>
							   </div>";	
						}
					}
					else{
						print "No education was added yet. Please click the link above to add an education<hr>";
					}
				?>
				<?php $education_count = $count ?>						

		    </div>
		    <hr>
		  </div>
      </div>
	</div>
	<!--End Education-->
	<div id="matches">	
		<div class="w3-container w3-card-2 w3-white w3-margin-bottom">
			<div class="wrapper">
				<div class="header-container">
					<h2 class="w3-text-grey w3-padding-16 w3-no-break"><i class="fa fa-thumbs-up fa-fw w3-margin-right w3-xxlarge w3-text-teal"></i>Pending Company Requests</h2>
					<a href="/jobsearch/help/faq-template/applicant_help.html#pending_request" class="trigger-help btn btn-info" target="_blank">?</a>
				</div>
			</div>
			
			<div class="w3-container">
				<fieldset>
					<legend>Request List</legend>
					<input type="hidden" value="<?php print $_SESSION['accno']; ?>" id="hidden_accno">
					<div class="table-container table-responsive">
						<input type="hidden" value="<?php print $_SESSION['accno']; ?>" id="hidden_accno">
						<b><br class='pull-left'>Showing <count id="company-request-count-narrowed"></count> of <count id="company-request-count"></count> Requests</b>
						<div class="form-inline">
							<label>Filter:</label> 
							<input type="text" class="form-control d-inline-block" id="req-filter" name="req-filter" onkeyup="filter(this,this.nextElementSibling)">
							<select class="form-control d-inline-block" id="req-select-filter" name="req-select-filter" onchange="filter(this.previousElementSibling,this)">
								<option value="Full Name">Full Name</option>
								<option value="Company Name">Company Name</option>
							</select>
							<br><br>
						</div>
						<table id="list_of_matches" class="table table-striped table-no-more" style="font-size: 18px;padding: 10px;" >
				            <thead>
				                <tr id="header-list-of-matches">
				                    <th>Picture</th>
				                    <th>Full Name</th>
				                    <th>Company Name</th>
				                    <th>Actions</th>
				                </tr>
				            </thead>
				            <tbody id="list-companies">
				              
				            </tbody>
				        </table>
					</div>
					<div style="padding-bottom:20px;"></div>
				</fieldset>
				<br>
				<fieldset>
					<legend for="requests_list">Jobs I've Requested</legend>
					<div class="table-container table-responsive">
						<b><br class='pull-left'>Showing <count id='my-job-requests-narrowed'></count> of <count id="my-job-requests"></count> Requests</b>
						<div class="form-inline">
							<label>Filter:</label> 
							<input type="text" class="form-control d-inline-block" id="my-req-filter" name="my-req-filter" onkeyup="filter(this,this.nextElementSibling)">
							<select class="form-control d-inline-block" id="my-req-select-filter" name="my-req-select-filter" onchange="filter(this.previousElementSibling,this)">
								<option value="Full Name">Full Name</option>
								<option value="Company Name">Company Name</option>
							</select>
							<br><br>
						</div>	
						<table id="list_of_my_requests" class="table table-no-more" style="font-size: 18px">
				            <thead>
				                <tr id="header-list-of-my-request">
				                    <th>Picture</th>
				                    <th>Full Name</th>
				                    <th>Company Name</th>
				                    <th>Job Name</th>
				                    <th>Actions</th>
				                </tr>
				            </thead>
				            <tbody id="job-request-list">
				                
				            </tbody>
				        </table>
					</div>
					
				</fieldset>
				<br>
			</div>
		</div>
    <!-- End Right Column -->
    </div>

    <div id="seminars_attanded">
    	<script type="text/javascript">
    		$(function(){
    			$("#add_seminars").hide();
    			$("#hide_seminars").click(function(){
    				$("#add_seminars").hide();
    				$("#show_add_seminars").show();
    			})
    			$("#show_add_seminars").click(function(){
    				$("#add_seminars").show();
    				$(this).hide();
    			})

    		})
    	</script>
	    <div id="add_seminars">
		    <div class="w3-container w3-card-2 w3-white w3-margin-bottom">
		    	<div class="wrapper">
					<div class="header-container">
						<h2 class="w3-text-grey w3-padding-16 w3-no-break"><i class="fa fa-certificate fa-fw w3-margin-right w3-xxlarge w3-text-teal"></i>Add New Seminars</h2>
						<a href="/jobsearch/help/faq-template/applicant_help.html#seminars" class="trigger-help btn btn-info" target="_blank">?</a>
					</div>
				</div>
				
			    <div class="w3-container">
			    	<form id="save_seminars" name="save_seminars">
				    	<label class="w3-label w3-text-black"><b>Seminar Title</b></label>
						<input class="form-control" type="text" id="seminar_title" name="seminar_title" required>
						<label class="w3-label w3-text-black"><b>Address</b></label>
						<input class="form-control" type="text" id="seminar_address" name="seminar_address" required>
						<label class="w3-label w3-text-black"><b>Date Started</b></label>
						<input class="form-control" type="date" id="seminar_start" name="seminar_start" required>
						<label class="w3-label w3-text-black"><b>Date Ended</b></label>
						<input class="form-control" type="date" id="seminar_end" name="seminar_end" required>
						<label>Region</label>
						<select id="list_of_regions" class="form-control" name="search_region">
						</select>
						<label>City</label>
						<select id="list_of_cities" class="form-control" name="search_city">			    	
						</select>
						<br><center>
						<button name="btn_save_seminar" id="btn_save_seminar" type="submit" maxlength="80" class="btn btn-success">Save</button>
						<button type="reset" maxlength="80" class="btn btn-success" id="hide_seminars">Hide</button>
						</center>
					</form>
				</div>
				<hr>
		    </div>
		</div>
		<div id="seminars_list">
	    	<div class="w3-container w3-card-2 w3-white w3-margin-bottom">
				<h2 class="w3-text-grey w3-padding-16"><i class="fa fa-certificate fa-fw w3-margin-right w3-xxlarge w3-text-teal"></i>Seminars Attended</h2>
				<a id="show_add_seminars" style="float: right">Add Seminars</a>
				<br>
				<hr>
				<div id="success" class="alert alert-success hide"></div>
				<?php 
					$db_obj = new DatabaseConnection();
					$db_obj->setQuery("select * from applicant_seminars where accno = :accno");
					$result = $db_obj -> executeQuery( array(':accno' => $_SESSION['accno']) , true );
					$cnt = $db_obj-> returnCount();
					if($cnt!=0){
						foreach ($result as $row) {
							$id = $row['id'];
							$seminar_title = $row['seminar_title'];
							$seminar_start = date("M-d-Y", strtotime($row['start_date']));
							$seminar_end = date("M-d-Y", strtotime($row['end_date']));
							$seminar_address = $row['location'];
							$location = $row['region/city'];
							print "<div class='w3-container seminar_single' id='$id'>
										<h5 class='w3-opacity'><b>$seminar_title</b></h5>
												<div style='float:right'>
													<button id='edit_certification' class='btn btn-success edit'>
														<i class='glyphicon glyphicon-pencil'></i>Edit
													</button>
													<button id='remove_certification' class='btn btn-danger remove'>
														<i class='glyphicon glyphicon-remove'></i>Remove
													</button>
												</div>
										<h6 class='w3-text-teal'><i class='fa fa-calendar fa-fw w3-margin-right'></i>$seminar_start - $seminar_end</h6>
										Location:$seminar_address ($location)
									</div>";
						}
					}
					else
						print "No records saved!";
				?>
				<hr>
			</div>
	    </div>
	</div>
</div>
  <!-- End Grid -->

<div id="education_Modal" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">
	
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Edit Education</h4>
      </div>
      <div class="modal-body">
      		
			<form id="edit_saved_education" name="edit_saved_education">
				<label class="w3-label w3-text-black"><b>Institute/University</b></label>
				<input type="text" class="form-control" id="edit_university" name="edit_university" index="0" maxlength="80" onkeyup="educationFilter(this)" required>
								

				<label class="w3-label w3-text-black"><b>Qualification</b></label>
				<select class="form-control" id="edit_quali" name="edit_quali" index="0" maxlength="80" required>
						<option value="Bachelors/College Degree">Bachelors/College Degree</option>
						<option value="Post Graduate Diploma/Masters Degree">Post Graduate Diploma/Masters Degree</option>
						<option value="Professional License(Passed Board/Bar/Professional License Exam)">Professional License(Passed Board/Bar/Professional License Exam)</option>
						<option value="Doctorate Degree">Doctorate Degree</option>
						<option value="Vocational Diploma/Short Course Certificate">Vocational Diploma/Short Course Certificate</option>
				</select>		

				<label class="w3-label w3-text-black">Field of Study</label>
				<select class="form-control" id="edit_f_study">
					<?php
					$db_obj = new DatabaseConnection();
					$db_obj -> setQuery("select * from fields_study");
					$res = $db_obj->executeQuery(array(),true);
					foreach ($res as $row) {
						$field_name = $row['field_name'];
						print "<option value='$field_name'>$field_name</option>";
					} 
					?>
			    </select>

			    <label class="w3-label w3-text-black">Major</label>
			    <input class="form-control" id="edit_major">	

			    </select>

					<label class="w3-label w3-text-black"><b>Year Started</b></label>
					<select class="form-control" name="edit_ed_start_year" id="edit_ed_start_year">
					<?php
						$limit = date('Y');
						for($i=1960;$i<=$limit;$i++)
						{
							print "<option name=$i>$i</option>";
						}
					?>
					</select>
			
					<label class="w3-label w3-text-black">Year Ended</label>
					<select class="form-control" name="edit_ed_end_year" id="edit_ed_end_year">
					<?php
						$limit = date('Y');
						for($i=1960;$i<=$limit;$i++)
						{
							print "<option name=$i>$i</option>";
						}
					?>
					</select>
				<div class="year error"></div>
				
				<input type=hidden id='hidden_education_id' value="">
			
      </div>
      
      <div class="modal-footer">
 	    <button id="edit_btn_educ_save" name="edit_btn_educ_save" type="submit" class="btn btn-success">Save</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
    </form>
  </div>
</div>
<div id="seminars_modal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Update Seminar</h4>
      </div>
      <div class="modal-body">
		<form id="edit_saved_seminar" name="edit_saved_seminar" method="post">
				<label class="w3-label w3-text-black"><b>Seminar Title</b></label>
				<input class="form-control" type="text" id="edit_seminar_title" name="edit_seminar_title" required>
				<label class="w3-label w3-text-black"><b>Address</b></label>
				<input class="form-control" type="text" id="edit_seminar_address" name="edit_seminar_address" required>
				<label class="w3-label w3-text-black"><b>Date Started</b></label>
				<input class="form-control" type="date" id="edit_seminar_start" name="edit_seminar_start" required>
				<label class="w3-label w3-text-black"><b>Date Ended</b></label>
				<input class="form-control" type="date" id="edit_seminar_end" name="edit_seminar_end" required>
				<label>Region</label>
				<select id="list_of_regions" class="form-control" name="search_region">
				</select>
				<label>City</label>
				<select id="list_of_cities" class="form-control" name="search_city">			    	
				</select>				
				<input type=hidden id='hidden_seminar_id' value="">		
      </div>
      <div class="modal-footer">
	    	<button id="edit_btn_save_seminar" name="edit_btn_save_seminar" type="submit" class="btn btn-success">Save</button>
        	<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      	</form>
      </div>
    </div>
  </div>
</div>
<div id="skills_modal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Update Skill</h4>
      </div>
      <div class="modal-body">
		<form method=post id="edit_saved_skills">						
			<label class="w3-label w3-text-black"><b>Skill Name</b></label>
			<input class="form-control"  name="edit_skills_select" id="edit_skills_select" onkeyup="skillsFilter(this)">
							
			<label class="w3-label w3-text-black"><b>Profiency Level</b></label>
			<input class="form-control" type="number" name="edit_prof_level" id="edit_prof_level" min=1 max=5>
			<input type=hidden id='hidden_skills_id' value="">
		
      </div>
      <div class="modal-footer">
	    	<button id="edit_btn_save_skills" name="edit_btn_save_skills" type="submit" class="btn btn-success">Save</button>
        	<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      	</form>
      </div>
    </div>

  </div>
</div>
<!--Direct Chat-->
<div class="chat_window modal fade" id="directChat" role="dialog" account-number="">
  <div class="top_menu">
      <div class="buttons">
        <div class="button close" data-dismiss="modal" title="Close"></div>
        <div class="button minimize" title="Back" data-toggle="modal" data-dismiss="modal" data-target="#chatList"></div>  
      </div>
      
      <div class="title"><img src="" id="top-image" alt="User Avatar" class="img-circle" width=70px></div>
  </div>
	<ul class="messages"></ul>
	  <div class="bottom_wrapper clearfix">
	    <div class="message_input_wrapper">
	      <input class="message_input" placeholder="Type your message here..."/>
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
<!-- End Page Container -->
<div id="myModal" class="modal fade" role="dialog" >
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
<div id="overlay" class="overlay hidden"></div>
<script type="text/javascript">
	$(function(){
		var resume_name;
		var param = {gotoResume:true};
		$(".go-to-resume").click(function(){
			swal({
				type:"question",
				title: "Confirmation Question",
				showCancelButton:true,
				allowOutsideClick:false,
				text:"Do you want to open your set resume?",
				showLoaderOnConfirm:true,
				preConfirm:function(){
					return new Promise(function(resolve,reject){
						$.post("../resume/choose_resume.php",param,function(text){
							resume_name = text;
							resolve();
						})
					})
				}
			}).then(function(){
				if(resume_name!=0){
					var win = window.open("/jobsearch/resume/"+resume_name+".php", '_blank');
  					win.focus();
  				}
  				else{
  					swal("Sorry!","You need to set your resume first","error");
  				}
			})
		})
		$(".set-resume").click(function(){
			var resumename = $(this).attr("resume-name");
			var education_count = <?php print $education_count;?>;
			var skills_count = <?php print $skills_count; ?>;
			swal({
				type:"question",
				title: "Confirmation Question",
				showCancelButton:true,
				allowOutsideClick:false,
				text:"Are you want to set " +resumename +" as your default resume layout?",
			}).then(function(){
				if(education_count > 0 && skills_count > 0){
					$.ajax({
						type:"post",
						url:"../resume/choose_resume.php",
						data:{
							resume:resumename
						}, 
						success:function(result){
							console.log(result);
						}
					}).done(function(error){
						if(error==="false")
							swal({
								title:"Success",
								text:"User Resume has been created! Press OK to see to your updated resume resume!",
								type:"success"
							}).then(function(){
								location.href = "/jobsearch/resume/"+resumename +".php";
							})
						else
							swal("Sorry","This resume is already chosen. Please pick another resume","error")
					})
					.fail(function(fail){
						swal("Error",fail,"error")
					})
				}
				else{
					swal("Sorry!","You cannot make a resume without proper education and skills!","error")
				}
			})
		})
	})
	
</script>
<script type="text/javascript" src="/jobsearch/slider/slider-range.js"></script>
<script src="profile-pic.js"></script>
<script src="../validation_function/js/applicant_validation.js"></script>
<script src="/jobsearch/profile/Like-Request-Chat/js/app.js"></script>
<script type="text/javascript" src="/jobsearch/profile/Like-Request-Chat/js/request_user.js"></script>
<script type="text/javascript">
	updateSlider("<?php print $min;?>","<?php print $max;?>");
	setUserFunctions("<?php print $_SESSION['accno']; ?>","<?php print $_SESSION['utype']; ?>");	
</script>

</body>
</html>
