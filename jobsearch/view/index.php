<?php
    include ('../dbconnect.php');
    if(isset($_GET['code'])){
        $code = $_GET['code'];
        $query = "select jobs.*,sec.security_code,emp.* from jobs 
                    INNER JOIN employer_tbl emp on jobs.accno = emp.accno 
                    LEFT JOIN jobs_security_code sec on jobs.id = sec.job_id
                    where sec.security_code='$code'";
        $res = mysql_query($query);
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
    <link id="theme-style" rel="stylesheet" href="assets/css/styles.css">
    <script type="text/javascript" src="assets/plugins/jquery-1.11.3.min.js"></script>
    <script type="text/javascript" src="assets/plugins/bootstrap/js/bootstrap.min.js"></script>    
    <!-- custom js -->
    <script type="text/javascript" src="assets/js/main.js"></script> 
    <style type="text/css">
        body{
            font-family: "Century Gothic", CenturyGothic, Geneva, AppleGothic, sans-serif;
        }
    </style>
</head>
<body><br><br><br>

    <div class="wrapper" id="divtoprint">
         <link rel="shortcut icon" href="../img/logo.png">
    <link href='https://fonts.googleapis.com/css?family=Roboto:400,500,400italic,300italic,300,500italic,700,700italic,900,900italic' rel='stylesheet' type='text/css'>
    <!-- Global CSS -->
    <link rel="stylesheet" href="assets/plugins/bootstrap/css/bootstrap.min.css">   
    <!-- Plugins CSS -->
    <link rel="stylesheet" href="assets/plugins/font-awesome/css/font-awesome.css">
    <!-- Theme CSS -->  
    <link id="theme-style" rel="stylesheet" href="assets/css/styles.css">
            <div class="sidebar-wrapper" id="about">
                <div class="profile-container">
                    <img class="profile" src="assets/images/aladeen.jpg" alt="" />
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
                <!--<div class="education-container container-block">
                    <h2 class="container-block-title">Education</h2>
                    <div class="item">
                        <h4 class="degree">MSc in Computer Science</h4>
                        <h5 class="meta">University of London</h5>
                        <div class="time">2011 - 2012</div>
                    </div>
                    <div class="item">
                        <h4 class="degree">BSc in Applied Mathematics</h4>
                        <h5 class="meta">Bristol University</h5>
                        <div class="time">2007 - 2011</div>
                    </div>
                </div>--><!--//education-container-->
                
            </div><!--//sidebar-wrapper-->
            <div class="main-wrapper">
                <h1 class="name" style='margin-top:-20px;'><?php print $job_name ?></h1>
                <!--<div id="hide"><button id="btn-like">Like</button><button id="btn-pass">Pass</button></div>-->
                <i><h3 class="tagline"><i class="fa fa-building"></i> <?php print $cname; ?></h3></i>
                <hr>
                <section class="section about-section">
                    <h2 class="section-title"><i class="fa fa-user"></i>About the Company</h2>
                    <div class="summary">
                        <p><?php print $c_overview; ?></p>
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
                else{
                    print "None";
                }
                ?>
                <?php
                if(!empty($responsibilities)){
                    print "<section class='section responsibilities-section'>";
                    print " <h2 class='section-title'><i class='fa fa-asterisk'></i>Requirements</h2>";
                    print "These are your responsibilities in our company<br>";
                    print $responsibilities;
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
     <div id="top">
                <div id="toptop">
                  <button class="top-btn" id="pdfbutton"  onclick='printDiv();' >Print Resume</button><button id="back-to-top" class="top-btn" > About Me</button><button class="top-btn" id="experiancebtn">Experience</button><button class="top-btn" id="skiilsbtn">Skills</button><button class="top-btn" id="othersbtn">Others</button><button class="top-btn" id="searchfilterbtn">Search Filter</button><input id="searchinput" type="text" name="" placeholder="Search Here!" id="search"><button id="searchbtn" type="submit" onclick="<?php echo searchquery();?>" name="gosearch"><img src="assets/images/search.png" id="searchimg" /></button>
                </div>
                <div id="searchfilter">
                    
                    <input type="checkbox" class="top-check-box" name="course" value="course">By Field of Study
                    <input type="checkbox" class="top-check-box" name="age" value="age">By Age
                    <input type="checkbox" class="top-check-box" name="experience" value="experience">Experience
                    <input type="checkbox" class="top-check-box" name="Gender" value="Gender">By Gender
                   
                </div>
            </div>
        
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

