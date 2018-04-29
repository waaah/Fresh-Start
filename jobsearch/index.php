<?php
ob_start();
require $_SERVER['DOCUMENT_ROOT'] ."/DBConnectionString/dbconnect_class.php";
if(isset($_GET['logout']))
{
    unset($_SESSION["accno"]);
    unset($_SESSION["unregistered_accno"]);
    unset($_SESSION["utype"]);
	header("location:/jobsearch/");
}
else if(isset($_SESSION['utype'])&&!isset($_GET['logout']))
{
	if($_SESSION['utype']=="applicant")
	{
		header("location:/jobsearch/profile/applicant_profile.php");
	}
	else if($_SESSION['utype']=="employer")
	{
		header("location:/jobsearch/profile/employer_profile.php");
	}
}
else if(isset($_SESSION['question_made'])){
    if($_SESSION['question_made']=='false'){
        header("location:make_question.php");      
    }
}
else if(isset($_SESSION['unregistered_accno'])){
  header("location:emp_validate.php");
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <script src="/jobsearch/profile/sweetalert2/sweetalert2.min.js"></script>
    <link rel="stylesheet" href="/jobsearch/profile/sweetalert2/sweetalert2.min.css">
	<LINK rel="shortcut icon" href="img/logo.png">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Fresh Start | Job Search</title>
    <!-- Bootstrap Core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <script class="cssdeck" src="//cdnjs.cloudflare.com/ajax/libs/jquery/1.8.0/jquery.min.js"></script>

    <!-- Theme CSS -->
    <link href="css/freelancer.min.css" rel="stylesheet">
	<link href="css/c.css" rel="stylesheet">
	<link href="css/style.css" rel="stylesheet">
    <!-- Custom Fonts -->
    <link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Lato:400,700,400italic,700italic" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <style type="text/css">
        a,a:hover{
            text-decoration: none;
            color: white
        }
        .point{
            margin:auto;
        }
        #job,#candidate{
            font-size: 20px;
        }
        #looking-for-na-word{
            font-size:20px;
        }
        @media screen and (min-width: 546px) {
            #job,#candidate{
                font-size: 2em;

            }
            #looking-for-na-word{
                font-size:2em;
            }
        }
    </style>
    <script type="text/javascript">
        var job = document.getElementById("job");
        var candidate = document.getElementById("candidate"); 
        $(document).ready(function(){
            $('#job').hover(function(){
                $('#jobdesc').show();
                $('#candidesc').hide();
            })
            $('#candidesc').hide();
            $('#candidate').hover(function(){
                $('#jobdesc').hide();
                $('#candidesc').show();
            })
            $("#myModal").on('hidden.bs.modal',function(){
                $("#rememberPass").modal('show');
            })
        })
        $(document).ready(function() {
    $('#rightPointer').hide();
    $("#candidate").css("border", "0px solid white");
    $("#job").css("border", "5px solid white");

});
$(document).ready(function() {
    $('#candidate').hover(function(){
      $('#leftPointer').hide();
      $('#rightPointer').show();
      $("#job").css("border", "0px solid white");
      $(this).css("border", "5px solid white");
  });
});
$(document).ready(function() {
    $('#job').hover(function(){
        $('#rightPointer').hide();
        $('#leftPointer').show();
        $("#candidate").css("border", "0px solid white");
        $(this).css("border", "5px solid white");
    });


});
    </script>
<style type="text/css">
    .searchdesc{
        color: white;
    }
    #searchform{
        height: auto;
        padding:10px;
    }
    .forg-pass:hover{
        text-decoration: underline;
    }
</style>
</head>

<body class="index">

    <!-- Navigation -->
    <nav id="mainNav" class="navbar navbar-default navbar-fixed-top navbar-custom">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header page-scroll">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>  <i class="fa fa-bars"></i>
                </button>
                <a class="navbar-brand" href="#page-top">Fresh Start</a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav navbar-right">
                    <li class="hidden">
                        <a href="#page-top"></a>
                    </li>
                    <li class="page-scroll">
                        <a href="" data-toggle="modal" data-target="#myModal">Login</a>
                    </li>
						<li class="page-scroll">
                        <a href="#how">How it Works</a>
                    </li>
                    <li class="page-scroll">
                        <a href="#about">About Us</a>
                    </li>
                    <li class="page-scroll">
                        <a href="#sign">Sign up</a>
                    </li>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container-fluid -->
    </nav>

    <!-- Header -->
    <header>
        
        <div class="container" id="page-top" >
            <?php
                function printError($strong,$message){
                    print "<div class='alert alert-danger alert-dismissable fade in'>
                                <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                                <strong>$strong</strong>$message
                              </div>";
                }
                if (isset($_POST['login']))
                {
                      $a=$_POST['email'];
                      $b=$_POST['password'];
                      $type = $_POST['utype'];
                      $isRegistered = true;
                      $tempEmployer = false;
                      $db_obj = new DatabaseConnection();
                      if($type=='Applicant')
                      {
                          $table='applicant_tbl';
                          $c = 'applicant';
                      }
                      else if($type=='Employer')
                      {
                          $table='temp_employer_tbl';
                          $c = 'employer';
                          $query = "select * from temp_employer_tbl t INNER JOIN account_verification a ON t.accno = a.accno where t.email=:a and t.password=:b";
                          $db_obj2 = new DatabaseConnection();
                          $db_obj2->setQuery($query);
                          $res = $db_obj2->executeQuery(array(':a' => $a , ':b' => $b),true);
                          $count2 = $db_obj2->returnCount();
                          if ($count2==1)
                          {
                            if($res[0]["isValidated"] == "1"){
                                foreach ($res as $row) {
                                   $_SESSION['unregistered_accno'] = $row['accno'];
                                   
                                }
                                header("Refresh:0;emp_validate.php");
                                exit();
                            }
                            else{
                                printError("Sorry, ", "User must first validate his/her account before he/she could login.");
                                $tempEmployer = true;
                            }
                          }
                          else{
                            $table='employer_tbl';
                            $c = 'employer';
                          }
                      }

                       $query2 = "select * from " .$table ." INNER JOIN account_verification ON ".$table.".accno = account_verification.accno where $table.email=:a and $table.password=:b";
                       $db_obj->setQuery($query2);
                       $res = $db_obj->executeQuery($arrayName = array(':a' => $a , ':b' => $b),true);
                       $count = $db_obj->returnCount();
                       if($count == 1){  
                            if($res[0]['isValidated'] == "1"){
                               foreach ($res as $row) {
                                   $_SESSION['accno']=$row['accno'];
                                   $_SESSION['isLoggedIn'] = $row['isLoggedIn'];
                                }
                                $_SESSION['utype']=$c;
                                if($_SESSION['isLoggedIn'] === '1'){
                                    header("Refresh:0;/jobsearch/profile/$c"."_profile.php");
                                }
                                else{
                                    header("Refresh:0;/jobsearch/profile/intro.php");
                                }
                            }
                            else{
                                if(!$tempEmployer){
                                    printError("Sorry, ", "User must first validate his/her account before he/she could login.");
                                }
                            }

                       }
                       else{
                            printError("Sorry, ", "Access Denied! Please check your email address, password, and user type to see if they all match.");
                       }
                       $_POST = array();
                }
            ?>
            <div class="row" >
				<div class="col-lg-6">
    			    <div class="wrapper"><br><br><br>
    					<h2 id="looking-for-na-word">I am looking for...</h2>
    					<div id="leftBanner">
                            <!--
        					<div id="leftPointer">
        							<img class="point" src="leftPointer.png" alt="Left Arrow" />
        					</div>

        					<div id="rightPointer">
        							<img class="point" src="rightPointer.png" alt="Right Arrow" />
        					</div>-->
        					<div id="tagline">
        						<h3>
        							<span id="job" title="Job" class="selected" ><a href="job_search.php">JOB</a></span>
        							<span id="candidate" class="selected" title="Candidate"><a href="applicant_search.php">CANDIDATE</a></span>
        						</h3>
        					</div>
    						<form method="post" action="#" id="search-form">

    							<div class="field" id="searchform">
    								<h5 id="jobdesc" class="searchdesc">Click this Button and it will send you to our Job search engine that will help you to find your dream job or the job that fits to your skills.</h5><h5 id="candidesc" class="searchdesc">Click this button and it will send you to our Applicant Search Engine that will help you as an Employer to find the right Candidate for the company. </h5>
    							</div>
    						</form>
					   </div>
			        </div>
				</div>
				<div class="col-lg-6">
                    <img class="img-responsive" id='main' src="/jobsearch/img/freshstartlogo.png" style="border-radius:15px;" alt="">
                    <div class="intro-text">
                        <span class="name">Enjoy your job search.</span>

				  <!-- Trigger the modal with a button -->

				  <!-- Modal -->
				  <div class="modal fade" id="myModal" role="dialog">
					<div class="modal-dialog">

					  <!-- Modal content-->
					  <div class="modal-content">
						<div class="modal-header">
						  <button type="button" class="close" data-dismiss="modal">&times;</button>
						  <p class="modal-title" style="color:black;text-align:left;font-family:Century Gothic; font-size:26px;color:#777;">Login</p><br>
						  <p style="color:black;text-align:left;font-family:Century Gothic; font-size:16px;color:#777;">Enter your account number, password and account type to log in:</p>

						</div>
						<div class="modal-body" style="background-color:#eee;">

						<form action="index.php" method="post">
						<center>
        					<input type="text" name="email" class="form-control" placeholder="Enter Your Email Address..." required data-validation-required-message="Please enter account number." style="width:95%;border-radius:2px;font-family:Century Gothic; height:25%;" autofocus>
            				&nbsp;
        					<br><input type="password" name=password class="form-control" placeholder="Enter Your Password..." required data-validation-required-message="Please enter password." style="width:95%;border-radius:2px;font-family:Century Gothic; height:25%;">
        				    <br>
                            <select name="utype" class="form-control" required data-validation-required-message="Please enter password." style="width:95%;border-radius:2px;font-family:Century Gothic; height:25%;">
                                <option value="Applicant">Applicant</option>
                                <option value="Employer">Employer</option>
                            </select>
        					<button type="submit" name=login id="login" class="btn btn-default btn-xl" style="padding-top:12px;padding-bottom:12px;border-radius:3px;">Login</button>
                            <br><br><a href="handlePass/email-verif.php" style="color:blue" class="forg-pass">Forgot Password? Recover it right here</a>
        					<br><br>
    					</center>

						</div>

					  </div>

					</div>
					</form>
				  </div>
                  
                    </div>
                </div>

        </div>

    </header>

    <!-- How it works Grid Section -->
    <section id="how">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <h2>How it works</h2>
                    <hr class="star-primary">
                </div>
            </div>
            <div class="row">
                <div class="col-sm-4 portfolio-item">
                        <center><img src="img/portfolio/settings.jpg" class="img-responsive" alt="">
							<h3><br>Settings</h3><br><p style="color:gray; font-family:century gothic"> User can configure their search setting by the ready filters of the system.</p>
                </div>
                <div class="col-sm-4 portfolio-item">

                        <center><img src="img/portfolio/swipe.jpg" class="img-responsive" alt="">
						<h3><br>Search</h3><br><p style="color:gray; font-family:century gothic"> Users can search and choose to accept/reject a job. By clicking "Like" on the jobs you are interested and wait to get matched.</p>
                </div>
                <div class="col-sm-4 portfolio-item">

                        <center><img src="img/portfolio/message.jpg" class="img-responsive" alt="">
                  <h3><br>Message</h3><br><p style="color:gray;">Realtime chat with mutual matches. Connect instantly with hiring managers.</p>
                </div>

            </div>
        </div>
    </section>

    <!-- About Section -->
    <section class="success" id="about">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <h2>About</h2>
                    <hr class="star-light">
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4 col-lg-offset-2">
					<p align=justify>&nbsp FreshStart Job Search is a system designed to help applicants find a job suitable for their skills and to help companies increase their workforce by posting job offer(s) that completely states what type of employee they are looking for. </p>
                </div>
                <div class="col-lg-4">
					<p align=justify>&nbsp We don't want to just repair the job search experience, but rather revolutionize it, one right swipe at a time. We're leading the web job search revolution by empowering job seekers to get hired with speed and ease, and helping employers source top talent more efficiently than ever.</p>
                </div>

            </div>
        </div>
    </section>

    <!-- Sign Up Section -->
    <section id="sign">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <h2>Sign up </h2><h3>as...</h3>

                </div>
            </div>
			<div class="col-lg-12">

<div class="col-lg-2"></div>
					<div class="col-lg-4">
						<center>
							<a href=/jobsearch/signup/s_app.php>
								<img title="Applicant" src="employee.png" class="img-responsive" style="border-radius:100%;">
							</a><br>
							<h1 style="color:#1c4f5f">Applicant</h1>
								<hr style="border-width:3px;">
								<p align=justify style="color:#1c4f5f">&nbsp&nbsp FreshStart offers guidance to both individuals who are unemployed seeking employment and individuals who are in employment seeking alternative or additional employment.</p>
					</div>
					<div class="col-lg-4">
						<center>
							<a href=/jobsearch/signup/s_company.php>
								<img  title="Employer" src="employer.png" class="img-responsive" style="border-radius:100%;" alt="">
							</a><br>
							<h1>Employer</h1>
							<hr style="border-width:3px;">
							<p align=justify>&nbsp&nbsp Post employment information and vacancies and enjoy access to a wealth of specialised information. FreshStart will help you find the right candidate or service today.</p>
						</div>
<div class="col-lg-2"></div>
            </div>

        </div>
    </section>

<!-- Footer -->
<footer class="text-center">
    <div class="footer-above">
        <div class="container">
            <div class="row">
                <div class="footer-col col-md-4">
                    <h3>Location</h3>
                    <p>University of the East
                        <br>Caloocan Campus</p>

                </div>
                <div class="footer-col col-md-4">
                    <h3>Around the Web</h3>
                    <ul class="list-inline">
                        <li>
                            <a href="#" class="btn-social btn-outline"><i class="fa fa-fw fa-facebook"></i></a>
                        </li>
                        <li>
                            <a href="#" class="btn-social btn-outline"><i class="fa fa-fw fa-google-plus"></i></a>
                        </li>
                        <li>
                            <a href="#" class="btn-social btn-outline"><i class="fa fa-fw fa-twitter"></i></a>
                        </li>
                        <li>
                            <a href="#" class="btn-social btn-outline"><i class="fa fa-fw fa-linkedin"></i></a>
                        </li>
                        <li>
                            <a href="#" class="btn-social btn-outline"><i class="fa fa-fw fa-dribbble"></i></a>
                        </li>
                    </ul>
                </div>
                <div class="footer-col col-md-4">
                    <h3>Creators:</h3>
	                        <p>Callanta, Carl Arthell<br></p>
													<p>Co, Joshua<br></p>
													<p>De Guia, Tristan Emerson<br></p>
													<p>Joson, Hannah Andrea Faye<br></p>
													<p>Mercado, John Christian</p>
                </div>
            </div>
        </div>
    </div>
    <div class="footer-below">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <p data-toggle="modal" data-target="#adminModal"> &copy; Fresh Start 2017 </p>
                </div>
            </div>
        </div>
    </div>
</footer>

    <!-- Scroll to Top Button (Only visible on small and extra-small screen sizes) -->
    <div class="scroll-top page-scroll hidden-sm hidden-xs hidden-lg hidden-md">
        <a class="btn btn-primary" href="#page-top">
            <i class="fa fa-chevron-up"></i>
        </a>
    </div>
	<!-- Modal -->


    <!-- jQuery -->
    <script src="vendor/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="vendor/bootstrap/js/bootstrap.min.js"></script>

    <!-- Plugin JavaScript -->
    <script src="http://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min.js"></script>

    <!-- Contact Form JavaScript -->
    <script src="js/jqBootstrapValidation.js"></script>
    <script src="js/contact_me.js"></script>

    <!-- Theme JavaScript -->
    <script src="js/freelancer.min.js"></script>
		<script src="js/sample.js"></script>
</body>

</html>


<!-- Modal -->