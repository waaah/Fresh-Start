<?php
	require $_SERVER['DOCUMENT_ROOT'] ."/DBConnectionString/dbconnect_class.php";
	$db_obj = new DatabaseConnection(); 
?>
<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->  
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->  
<!--[if !IE]><!--> <html lang="en"> <!--<![endif]-->  
<head>

    <title>View Applicant Profile</title>

    <?php
        
        if(isset($_GET['code'])){
            $code = $_GET['code'];
            $query = "select * from applicant_tbl where accno=:code";
            $db_obj->setQuery($query);
            $res = $db_obj->executeQuery(array(":code"=>$code),true);
            foreach ($res as $row) {
                $accno = $row['accno'];
                $lname = $row['lname'];
                $fname = $row['fname'];
                $email = $row['email'];
                $cnum = $row['cnum'];
                $age = $row['age'];
                $gender = $row['gender'];
                $self_desc = $row['description'];
                $min = $row['salary_range_min'];
                $min = $row['salary_range_max'];
                $exp_level = $row['job_experience_level'];
                $pic = $row['pic'];
                if(empty($pic)){
                    $pic = "../employee.png";
                }
                else{
                    $pic = "../profile/upload/".$pic;
                }
                if(empty($exp_level)){
                    $exp_level = "Not yet stated";
                }
            }
        }
        else{
            print "No code received";
            exit();
        }

    ?>
    <!-- Meta -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Responsive HTML5 Resume/CV Template for Developers">
    <meta name="author" content="Xiaoying Riley at 3rd Wave Media">    
    <link rel="shortcut icon" href="../img/logo.png">
    <link href='https://fonts.googleapis.com/css?family=Roboto:400,500,400italic,300italic,300,500italic,700,700italic,900,900italic' rel='stylesheet' type='text/css'>
    <!-- Global CSS -->
    <link rel="stylesheet" href="assets/plugins/bootstrap/css/bootstrap.min.css">   
    <!-- Plugins CSS -->
    <link rel="stylesheet" href="assets/plugins/font-awesome/css/font-awesome.css">
    
    <!-- Theme CSS -->  
    <link id="theme-style" rel="stylesheet" href="assets/css/styles-2.css">
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
        <script type="text/javascript" src="assets/plugins/jquery-1.11.3.min.js"></script>
        <script type="text/javascript" src="assets/plugins/bootstrap/js/bootstrap.min.js"></script>    
        <!-- custom js -->
        <script type="text/javascript" src="assets/js/main.js"></script>
         <script type="text/javascript" src="assets/js/print.js"></script>
        
        <style type="text/css">
            body{
            font-family: "Century Gothic", CenturyGothic, Geneva, AppleGothic, sans-serif;
        }
        .navbar-default {
            background-color: #4CA69D !important;
            border-color: #009968;
            border-radius: 0px;

        }
        .navbar-default .navbar-nav > li > a {
            color: white;
            font-weight: 300;
        }
        .navbar {
           min-height:10%;
           margin-bottom:0;
           color:white;
        }
        .navbar-nav {
           margin: 18px 0 0 0;
           float:right;
        }
        .navbar-default .navbar-nav > .open > a, .navbar-default .navbar-nav > .open > a:hover, .navbar-default .navbar-nav > .open > a:focus {
            color: #fff;
            background-color:#009968;
        }

        .navbar-nav > li > a {
           padding:10px 15px;
        }
        .navbar-default{
            margin-top: -30px;
            margin-left: -30px;
            margin-right: -30px;
            margin-bottom: 20px;
        }
        .nav-item{
            border-style: none;
            padding: none;
            font-size: 15px;
            font-weight: 200px;
            text-decoration: none;
            color:white;
            padding-right:20px;
            cursor: pointer;
            font-weight: bold;
            padding-left: 20px;
        }
        .nav-item:hover{
            text-decoration: none;
            color:white;
            cursor: pointer;
            background-color:#0499C8;
            padding-top: 20px;
            padding-bottom: 20px;
            padding-left: 20px; 
        }
        </style> 
        <script type="text/javascript">
            $(document).ready(function(){
                $('#homehover').hide();
                $("#home-btn").hover(function(){
                        $('#homehover').delay().show();
                })
                 $("#home-btn").mouseout(function(){
                        $('#homehover').hide();
                })
            });
        </script>  
        <script type="text/javascript">
            $(document).ready(function(){
                $('#logouthover').hide();
                $("#logout-btn").hover(function(){
                        $('#logouthover').show();
                })
                 $("#logout-btn").mouseout(function(){
                        $('#logouthover').hide();
                })
            });
        </script> 
        </script>  
        <script type="text/javascript">
         $(document).ready(function(){
            $('#back-to-top').click(function() {
                $('html, body').animate({
                 scrollTop: 0
                 }, 700);
                return false;
            });
        });
        </script>    
        <script type="text/javascript">
          $(document).ready(function(){
            $('#experiancebtn').click(function() {
               
            $('html, body').animate({
             scrollTop: 200
             }, 700);
    return false;
    });
});
        </script> 
        <script type="text/javascript">
         $(document).ready(function(){
            $('#skiilsbtn').click(function() {
            $('html, body').animate({
             scrollTop:1000
             }, 700);
    return false;
    });
});
        </script> 

        <script type="text/javascript">
         $(document).ready(function(){
            $('#othersbtn').click(function() {
            $('html, body').animate({
             scrollTop: 800
             }, 700);
    return false;
    });
});

        </script>   
        <script type="text/javascript">
          
            $(document).ready(function(){
                  $(".drop").hide();
                $("#pdfbutton").click(function(){
                    $(".drop").toggle();
    });
});
        </script>

</script>
<script type="text/javascript">
$(document).ready(function(){
    $('#searchfilter').hide();
    $("#searchfilterbtn").click(function(){
        $('#searchfilter').toggle();
    })
});
</script>
<script type="text/javascript">
$(document).ready(function(){
    $('#pdfbutton').hide();
    $('#btn-unlike').hide();
    $("#btn-like").click(function(){
     var r =  confirm ("You can now message with Aladeen Aladeen's and print his resume")
if (r == true) {
    $('#btn-like').hide();
    $('#btn-pass').hide();
    $('#pdfbutton').show();
    $('#btn-unlike').show();  
} else {
   $('#hide').show();
    $('#pdfbutton').hide(); 
    $('#pdfbutton').show();
    $('#btn-unlike').show();  
}       
    })
});
</script>
<script type="text/javascript">
 
</script>
<script type="text/javascript">
$('#pdfbutton').hide();
$(document).ready(function(){
    $("#btn-pass").click(function(){
    var r =  confirm ("Do you really want to close?");
    if (r == true) {
    $('#hide').hide();
    } else {
   $('#hide').show();
    $('#pdfbutton').hide(); 
    }       
    })
});
</script>
<script type="text/javascript">
    $('#pdfbutton').hide();
    $('#btn-unlike').show();  
$(document).ready(function(){
    $("#btn-unlike").click(function(){
    var r =  confirm ("Are You Sure?");
    if (r == true) {
    $('#btn-unlike').hide();
    $('#btn-like').show();
    $('#btn-pass').show();
     $('#pdfbutton').hide(); 

    } else {
     $('#btn-like').hide();
    $('#btn-pass').hide();
    }       
    })
});
</script>
        <script type="text/javascript">
            function printDiv() 
            {

              var divToPrint=document.getElementById('divtoprint');

              var newWin=window.open('','Print-Window');

              newWin.document.open();

              newWin.document.write('<head><link id="theme-style" rel="stylesheet" href="assets/css/styles-2.css"></head><html><body onload="window.print()">'+divToPrint.innerHTML+'</body></html>');

              newWin.document.close();

              setTimeout(function(){newWin.close();},10);

            };
        </script> 
<script type="text/javascript">
    $(document).ready(function(){
    $('#subcat_skills').hide();
    $('#subcat_job').hide();
    $('#subcat_course').hide();
    
    })
</script>
</head> 
<nav class="navbar navbar-default" role="navigation">
    <div class="navbar-header">
        <img src='../img/freshstartlogo.png' width=200px>
        <button class="navbar-toggle" type="button" data-toggle="collapse" data-target="#navbar-main">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        
    </div>
    <input id="u_type" type="hidden">
    <div class="navbar-collapse collapse" id="navbar-main">    
    
        <div style="margin-top:15px"></div>  
        <div class='navbar-form navbar-right'>
            <a class='home nav-item' href='/jobsearch/applicant_search.php'><i class='fa fa-search' aria-hidden='true'></i> Find Applicants</a>
            <?php
                if(isset($_SESSION['accno'])){
                    print "<a class='home nav-item' href='/jobsearch/applicant_search.php'><i class='fa fa-home' aria-hidden='true'></i> Home</a>";
                } 
            ?>
        </div>
     </div>
    
</nav>
<body><br>
<div id ="divtoprint">
    <div class="wrapper">
         <link rel="shortcut icon" href="../img/logo.png">

            <div class="sidebar-wrapper" id="about">
                <div class="profile-container">
                    <img class="profile" src="<?php print $pic; ?>" alt="" style="width:200px;border-radius:50%" />
                    
                    <!--<div id="hide"><button id="btn-like">Like</button><button id="btn-unlike">Unlike</button><button id="btn-pass">Pass</button></div>
                    <h3 class="tagline">Full Stack Developer</h3>-->
                </div><!--//profile-container-->
                <div class="contact-container container-block">
                    <ul class="list-unstyled contact-list">
                        <h2 class="container-block-title">Applicant Details</h2>
                        <li class="email"><i class="fa fa-user"></i><?php print "$fname $lname"; ?>
                        <li class="email"><i class="fa fa-envelope"></i>Email: <?php print $email; ?></li>
                        <li class="phone"><i class="fa fa-phone"></i>Mobile: <?php print $cnum; ?></li>
                        <li class="age"><i class="fa fa-user"></i>Age: <?php print $age; ?></li>
                        <li class="salary"><i class="fa fa-money"></i>Salary: <?php print $min; ?></li>
                        <li class="exp-level"><i class="fa fa-user"></i>Level: <?php print $exp_level; ?></li>
                    </ul>
                </div><!--//contact-container-->
            </div><!--//sidebar-wrapper-->
           
            <div class="main-wrapper">
                <h1 style="margin-top: -20px">Applicant Information</h1>
                <hr>
                <section class="section summary-section">
                    <h2 class="section-title"><i class="fa fa-user"></i>Education Attained</h2>
                    <?php
                        $select = "select * from applicant_education where app_id=:accno";
                        $db_obj->setQuery($select);
                        $res = $db_obj->executeQuery(array(":accno" => $code),true);
                        $cnt = $db_obj->returnCount();
                        if($cnt!==0){
                           foreach ($res as $row) {
                                $univ_name = $row['univ_name'];
                                $start_year = $row['start_year'];
                                $end_year = $row['end_year'];
                                $field_of_study = $row['field_of_study'];
                                $major = $row['major'];
                                $qualification = $row['qualification'];
                                $qualification = $row['qualification'];
                                if($end_year>=date("Y")){
                                    $end_year = "Current";
                                }
                                print "
                                 <div class='item'>
                                    <h4 class='degree' style='opacity:0.8'>$field_of_study($major)</h4>
                                    <h5 class='meta'>$univ_name ($qualification)</h5>
                                    $start_year - $end_year
                                </div>";        
                            }
                        }
                        else{
                            print "This applicant has not posted his education yet.";
                        }
                    ?>
                </section><!--//section-->
                <section class="section experiences-section">
                    <h2 class="section-title"><i class="fa fa-briefcase"></i>Experiences</h2>
                    <?php
                        $select = "select * from applicant_exp where applicant_id=:accno";
                        $db_obj->setQuery($select);
                        $res = $db_obj->executeQuery(array(":accno" => $code),true);
                        $cnt = $db_obj->returnCount();
                        if($cnt!==0){
                            foreach ($res as $row) {
                                $position_title = $row['position_title'];
                                $start_year = $row['year_started'];
                                $end_year = $row['year_ended'];
                                $company_name = $row['company_name'];  
                                $experience = $row['experience'];                   
                                if($end_year>=date("Y")){
                                    $end_year = "Current";
                                }
                               print "<div class='item'>
                                <div class='meta'>
                                    <div class='upper-row'>
                                        <h3 class='job-title'>$position_title</h3>
                                        <div class='time'>$start_year - $end_year</div>
                                    </div><!--//upper-row-->
                                    <div class='company'>$company_name</div>
                                </div>";
                                print "<div class='details'>$experience</div>
                                </div>";     
                            }
                        }
                        else{
                            print "This applicant has not posted his job experience yet or has no experience at all.";
                        }
                    ?>
                     
                </section><!--//section-->
                
                
                <section class="skills-section section">
                    <h2 class="section-title"><i class="fa fa-rocket"></i>Skills &amp; Proficiency</h2>
                    <div class="skillset">        
                    <?php
                        $select = "select * from applicant_skills where accno=:accno";
                        $db_obj->setQuery($select);
                        $res = $db_obj->executeQuery(array(":accno" => $code),true);
                        $cnt = $db_obj->returnCount();
                        if($cnt!==0){
                            foreach($res as $row){
                                $name = $row['name'];
                                $level = $row['level'];
                                $level*=20;
                               print "<div class='item'>
                                <h3 class='level-title'>$name</h3>
                                    <div class='level-bar'>
                                        <div class='level-bar-inner' data-level='$level%'>
                                        </div>                             
                                    </div>
                                </div>";
                            }
                        }
                        else{
                            print "This applicant has not posted his job experience yet or has no experience at all.";
                        }
                    ?>                
                    </div>  
                </section><!--//skills-section-->
                 <section class="seminars section">
                    <h2 class="section-title"><i class="fa fa-certificate"></i>Seminars I've attended</h2>
                    <div class="seminars">        
                    <?php
                        $select = "select * from applicant_seminars where accno='$accno'";
                       $db_obj->setQuery($select);
                        $res = $db_obj->executeQuery(array(":accno" => $code),true);
                        $cnt = $db_obj->returnCount();
                        if($cnt!==0){
                            foreach($res as $row){
                                $seminar_title = $row['seminar_title'];
                                $start_year = $row['start_date'];
                                $end_year = $row['end_date'];
                                $location = $row['location'] ."(" .$row['region/city'] .")";
                                print "<div class='item'>
                                <div class='meta'>
                                    <div class='upper-row'>
                                        <h3 class='seminar-title'>$seminar_title</h3>
                                       <br><b>$start_year - $end_year</b>
                                    </div><!--//upper-row-->
                                    <br>
                                    <div class='company'>$location</div>
                                </div>";
                                 
                            }
                        }
                        else{
                            print "This applicant has not attended any seminars.";
                        }
                    ?>                
                    </div>  
                </section>
            </div><!--//main-body-->     
    </div>
</div>
        <!--<div id="top">
            <div id="toptop">
              <button class="top-btn" id="pdfbutton"  onclick='printDiv();' >Print Resume</button><button id="back-to-top" class="top-btn" > About Me</button><button class="top-btn" id="experiancebtn">Experience</button><button class="top-btn" id="skiilsbtn">Skills</button><button class="top-btn" id="othersbtn">Others</button><form action="search.php" method="POST"><select name="subcat" id="applicant" class="top-btn" required>
                <option value="" disabled selected class="filtercat">Search By</option>
                <option value="age" class="filtercat">By Age</option>
                <option value="min" class="filtercat">By minimum</option>
                <option value="Gender" class="filtercat">By gender</option>
                </select> <input id="searchinput" type="text" name="searchbox" placeholder="Search Here!"  required><button id="searchbtn" name="searchbtn" type="submit" ><img src="assets/images/search.png" id="searchimg" /></button></form><button class="home" > <img src="assets/images/home.png" id="home-btn"> </button><button class="logout" > <img src="assets/images/logout.png" id="logout-btn"> </button>
                <div id="homehover" ><h6 class="tophover">Home</h6></div><div  id="logouthover"><h6 class="tophover">Logout</h6></div>
            </div>
           
        </div>-->
            
        <script type="text/javascript">
            $(document).ready(function(){
                $("#searchbtn").click(function(){
                    $.ajax({
                        url: 'search.php',
                        success: function(data) {
                        }
                    });
                });
            });
        </script>
        <!--<footer class="footer">
            <div class="text-center">
                    This template is released under the Creative Commons Attribution 3.0 License. Please keep the attribution link below when using for your own project. Thank you for your support. :) If you'd like to use the template without the attribution, you can check out other license options via our website: themes.3rdwavemedia.com *
                    <small class="copyright">Designed with <i class="fa fa-heart"></i> by <a href="http://themes.3rdwavemedia.com" target="_blank">Xiaoying Riley</a> for developers</small>
            </div>/container
      </footer>-->
        <!-- Javascript -->          

    </body>
    </html> 

