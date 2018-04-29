<?php
    include ('../dbconnect.php');
    if(isset($_GET['code'])){
        $code = mysql_real_escape_string($_GET['code']);
        $query = "select jobs.*,sec.security_code,emp.* from jobs 
                    INNER JOIN employer_tbl emp on jobs.accno = emp.accno 
                    LEFT JOIN jobs_security_code sec on jobs.id = sec.job_id
                    where sec.security_code='$code'";
        $res = mysql_query($query);
        $cnt = mysql_num_rows($res);
        if($cnt !==0){
            while($row = mysql_fetch_array($res)){
                $lname = $row['lname'];
                $fname = $row['fname']; 
                $cname = $row['cname']; 
                $address = $row['address']; 
                $cnum = $row['cnum'];
                $link =$row['url'];
                $email = $row['email'];
                $region = $row['region'];
                $city = $row['city'];
                $c_overview = $row['company_overview'];
                $looking_for = $row['looking_for'];
                $spec = $row['spec_job'];
                $job_name = $row['job_name'];
                $requirements = $row['requirements'];
                $responsibilities = $row['responsibilities'];
                $min = $row['min_salary'];
                $max = $row['max_salary'];
                $employ_type = $row['employ_type'];
                $pic = $row['pic'];
                if(empty($pic)){
                    $pic = "../employer.png";
                }
                else{
                    $pic = "../profile/upload/".$pic;
                }
            }
        }
        else{
            print "Invalid code";
            exit();
        }

    }
    else{
        print "There is no job code received";
        exit();        
    }
?>
<head>
    <title>Job Information</title>
    
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
    <script type="text/javascript" src="assets/plugins/jquery-1.11.3.min.js"></script>
    <script type="text/javascript" src="assets/plugins/bootstrap/js/bootstrap.min.js"></script> 
    <link id="theme-style" rel="stylesheet" href="assets/css/styles-2.css">
   
    <!-- custom js -->
    <script type="text/javascript" src="assets/js/main.js"></script> 
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
            <a class='home nav-item' href='/jobsearch/job_search.php'><i class='fa fa-search' aria-hidden='true'></i> Find Jobs</a>
            <?php
                change_navbar("applicant");
            ?>
        </div>
     </div>
    
</nav>
<body>
    
    <div class="wrapper" id="divtoprint">
         <link rel="shortcut icon" href="../img/logo.png">
   
    
            <div class="sidebar-wrapper" id="about">
                <div class="profile-container">
                    <img class="profile" src="<?php print $pic; ?>" alt="" style="width:200px;border-radius:50%" />
                </div><!--//profile-container-->
                <div class="contact-container container-block">
                    <ul class="list-unstyled contact-list">
                    <h2 class="container-block-title">Company Information</h2>
                        <li class="address"><i class="fa fa-map-marker"></i>Address: <?php print $address; ?></li>
                        <li class="phone"><i class="fa fa-phone"></i>Mobile: <?php print $cnum ?></li>
                        <li class="website"><i class="fa fa-globe"></i>Link: <a href="<?php print $link; ?>"><?php print $link ?></a></li>
                        <li class="email"><i class="fa fa-envelope"></i>Company Email: <?php print $email; ?></li>
                        <li class="more_location"><i class="fa fa-map-marker"></i>Location: <?php print $region ." , " .$city ?></li>
                    </ul>
                </div><!--//contact-container-->
            
                
            </div><!--//sidebar-wrapper-->
            <div class="main-wrapper">
                <h1 class="name" style='margin-top:-20px;'><?php print $job_name ?></h1>
                <!--<div id="hide"><button id="btn-like">Like</button><button id="btn-pass">Pass</button></div>-->
                <i><h3 class="tagline"><i class="fa fa-building"></i> <?php print $cname; ?></h3></i>
                <hr>
                <section class="section about-section">
                    <h2 class="section-title"><i class="fa fa-user"></i>About the Company</h2>
                    <div class="summary">
                        <p><?php print nl2br($c_overview); ?></p>
                    </div><!--//summary-->
                </section><!--//section-->
                <section class="section looking_for-section">
                    <h2 class="section-title"><i class="fa fa-briefcase"></i>What we're looking for</h2>
                    
                    <div class="summary">
                       <?php print $looking_for; ?>
                    </div><!--//item-->
                           
                    
                </section><!--//section-->
                
                <section class="section specializations-section">
                    <h2 class="section-title"><i class="fa fa-asterisk"></i>Required Specialization</h2>
                    Applicants must have experience or skills related to the following fields
                    <?php
                        $spec_set = explode(",", $spec);
                        $cnt = count($spec_set);
                        for($i=0;$i<$cnt;$i++){
                            print "<br><b>*$spec_set[$i]</b>";
                        }
                    ?>
                </section><!--//section-->
                
                <?php
                if(!empty($requirements)){
                    print "<section class='section requirements-section'>";
                    print " <h2 class='section-title'><i class='fa fa-asterisk'></i>Requirements</h2>";
                    print "The ff. are the minimum requirements of our company";
                    $requirement_set = explode(",", $requirements);
                    $cnt = count($requirement_set);
                    for($i=0;$i<$cnt;$i++){
                        print "<b>$requirement_set[$i]</b><br>";
                    }
                    print "</section>";
                }
                
                ?>
                <?php
                if(!empty($responsibilities)){
                    print "<section class='section responsibilities-section'>";
                    print " <h2 class='section-title'><i class='fa fa-asterisk'></i>Responsibilities</h2>";
                    print "These are your responsibilities in our company<br>";
                    print nl2br($responsibilities);
                    print "</section>";
                }
                
                ?>
                <section class="section other-info-section">
                    <h2 class="section-title"><i class="fa fa-info"></i>Other Information</h2>
                    <?php
                      print "<h5><i class='fa fa-money'></i> Salary: $min - $max</h5>";
                      print "<h5><i class='fa fa-user'></i> Employment Type: $employ_type</h5>";  
                    ?>
                </section>
                
            </div><!--//main-body-->
            
            
        </div>
        <!--<div id="top">
                <div id="toptop">
                  
                </div>
                <div id="searchfilter">
                    
                   
                   
                </div>
        </div>-->
        
        <!--<footer class="footer">
            <div class="text-center">
                    This template is released under the Creative Commons Attribution 3.0 License. Please keep the attribution link below when using for your own project. Thank you for your support. :) If you'd like to use the template without the attribution, you can check out other license options via our website: themes.3rdwavemedia.com *
                    <small class="copyright">Designed with <i class="fa fa-heart"></i> by <a href="http://themes.3rdwavemedia.com" target="_blank">Xiaoying Riley</a> for developers</small>
            </div>/container
      </footer>-->
        <!-- Javascript -->          

        <script type="text/javascript">
            function printDiv() 
{

  var divToPrint=document.getElementById('divtoprint');

  var newWin=window.open('','Print-Window');

  newWin.document.open();

  newWin.document.write('<html><body onload="window.print()">'+divToPrint.innerHTML+'</body></html>');

  newWin.document.close();

  setTimeout(function(){newWin.close();},10);

}
        </script> 
        <script type="text/javascript">
        </script>    
        <script type="text/javascript">
            $('#back-to-top').click(function() {
            $('html, body').animate({
             scrollTop: 0
             }, 700);
    return false;
});
        </script>    
        <script type="text/javascript">
            $('#experiancebtn').click(function() {
            $('html, body').animate({
             scrollTop: 200
             }, 700);
    return false;
});
        </script> 
        <script type="text/javascript">
            $('#skiilsbtn').click(function() {
            $('html, body').animate({
             scrollTop:1000
             }, 700);
    return false;
});
        </script> 
        <script type="text/javascript">
            $('#othersbtn').click(function() {
            $('html, body').animate({
             scrollTop: 800
             }, 700);
    return false;
});

        </script>   
        <script type="text/javascript">
            $(".drop").hide();
            $(document).ready(function(){
                $("#pdfbutton").click(function(){
                    $(".drop").toggle();
    });
});
        </script>

</script>
<script type="text/javascript">
$('#searchfilter').hide();
$(document).ready(function(){
    $("#searchfilterbtn").click(function(){
        $('#searchfilter').toggle();
    })
});
</script>
<script type="text/javascript">
$('#pdfbutton').hide();
$(document).ready(function(){
    $("#btn-like").click(function(){
        confirm ("You can now message with Aladeen Aladeen's and print his resume")
        $('#hide').hide();
        $('#pdfbutton').show(); 
    })
});
</script>
<script type="text/javascript">
$('#pdfbutton').hide();
$(document).ready(function(){
    $("#btn-pass").click(function(){
        confirm (" close window")
        $('#hide').hide();
        window.close(); 
    })
});
</script>

