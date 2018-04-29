<?php

    require $_SERVER['DOCUMENT_ROOT'] ."/DBConnectionString/dbconnect_class.php";
    if(isset($_GET['code'])){
        $db_obj = new DatabaseConnection();
        $code = $_GET['code'];
        $query = "select * from jobs 
                    INNER JOIN employer_tbl emp ON emp.accno = jobs.accno 
                    INNER JOIN company_table c ON c.employer_accno = emp.accno where employer_accno=:code";
        $db_obj->setQuery($query);
        $res = $db_obj->executeQuery(array(':code' => $code ),true);
        $cnt = $db_obj->returnCount();

        if($cnt !==0){
            foreach ($res as $row) {
                $accno = $row['accno'];
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
                $logo = $row['company_pic'];
                if(empty($logo)){
                    $pic = "/jobsearch/img/freshstartlogo.png";
                }
                else{
                    $pic = "/jobsearch/profile/company-logo/".$logo;
                }
                 $params = array(":accno" => $accno);
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
    <title>Company Reviews</title>
    
    <!-- Meta -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Responsive HTML5 Resume/CV Template for Developers">
    <meta name="author" content="Xiaoying Riley at 3rd Wave Media">    
    <link rel="shortcut icon" href="../img/logo.png">
    <link href='https://fonts.googleapis.com/css?family=Roboto:400,500,400italic,300italic,300,500italic,700,700italic,900,900italic' rel='stylesheet'>
    <!-- Global CSS -->
    <link rel="stylesheet" href="../assets/plugins/bootstrap/css/bootstrap.min.css">   
    <!-- Plugins CSS -->
    <link rel="stylesheet" href="/jobsearch/view/assets/plugins/font-awesome/css/font-awesome.css">
    
    <!-- Theme CSS -->  
    <script src="assets/plugins/jquery-1.11.3.min.js"></script>
    <script src="/jobsearch/view/assets/plugins/bootstrap/js/bootstrap.min.js"></script> 
    <link id="theme-style" rel="stylesheet" href="/jobsearch/view/assets/css/styles-2.css">
   
    <!-- custom js -->
    <script src="/jobsearch/view/assets/js/main.js"></script> 
    <!-- REVIEW JS AND CSS -->
    <script src="review-script.js"></script>
    <link rel="stylesheet" href="review-style.css">
    <!-- Sweet Alert -->
    <script type="text/javascript" src="/jobsearch/profile/sweetalert2/sweetalert2.js"></script>
    <link rel="stylesheet" type="text/css" href="/jobsearch/profile/sweetalert2/sweetalert2.css">
    <script src="/jobsearch/validation_function/dist/jquery.validate.js"></script>
    <style type="text/css">
        
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
           margin-bottom:0;
           color:white;
        }
        @media screen and (min-width: 768px){
            .navbar-nav {
                float:right;
            }
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
        .nav > li{
            padding:4px;
            font-size: 16px;
        }
        .nav-item{
            border-style: none;
            padding: none;
            font-size: 18px;
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
            padding-top: 20px;
            padding-bottom: 20px;
            padding-left: 20px; 
        }
        .list-unstyled.contact-list{
            font-size: 16px;
        }
        .container-block-title{
            font-size: 20px !important;
        }
    </style>
</head>

<nav class="navbar navbar-default" role="navigation">
    <div class="navbar-header">
        <!-- <img src='../img/freshstartlogo.png' width=200px> -->
        <button class="navbar-toggle" type="button" data-toggle="collapse" data-target="#navbar-main">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>       
    </div>
    <input id="u_type" type="hidden">
    <div class="navbar-collapse collapse" id="navbar-main">    
        <div class='navbar-form navbar-right'>
            <ul class="nav navbar-nav navbar-right">
            <li><a href="/jobsearch/"><span class="glyphicon glyphicon-home"></span>&nbsp;Home</a>
            </li>
            <li><a href="/jobsearch/job_search.php"><span class="glyphicon glyphicon-search"></span>&nbsp;Back to Job Search</a></a></li> 
            <li><?php
                if(isset($_SESSION['accno'])){
                    print "<li><a href='/jobsearch/index.php?logout=true'><span class='glyphicons glyphicons-power'></span> Log Out</a></li>"; 
                }
             ?></li>
          </ul>            
        </div>
     </div>   
</nav>
<body>    
    <div class="wrapper" id="divtoprint">
         <link rel="shortcut icon" href="../img/logo.png"> 
            <div class="sidebar-wrapper" id="about">
                <div class="profile-container">
                    <img class="profile" src="<?php print $pic; ?>" alt="" style="width:200px;" />
                </div><!--//profile-container-->
                <div class="contact-container container-block">
                    <ul class="list-unstyled contact-list">
                    <h2 class="container-block-title">Company Information</h2>
                        <li class="address"><i class="fa fa-map-marker"></i>Address: <?php print $address; ?></li>
                        <li class="phone"><i class="fa fa-phone"></i>Mobile: <?php print "+63".$cnum ?></li>
                        <li class="website"><i class="fa fa-globe"></i>Link: <a href="<?php print $link; ?>" target="_blank"><?php print $link ?></a></li>
                        <li class="email"><i class="fa fa-envelope"></i>Company Email: <?php print $email; ?></li>
                        <li class="more_location"><i class="fa fa-map-marker"></i>Location: <?php print $region ." , " .$city ?></li>
                    </ul>
                </div><!--//contact-container-->

            <!--//PARA SA AVERAGE RATING NG COMPANY-->
            <?php 
                $review = "SELECT * FROM `reviews` where `emp_accno` = :accno";
                $db_obj->setQuery($review);
                $rev = $db_obj->executeQuery($params,true);
                $cnt = $db_obj->returnCount();
                if($cnt !== 0){
                    $t_rating = 0;
                    foreach ($rev as $row) {    
                        $t_rating = $t_rating + $row['rating']; 
                    }
                    $ave_rating = number_format($t_rating/$cnt, 2);
                } else {
                    $ave_rating = "0";
                }
                            
            ?>
                
            </div><!--//sidebar-wrapper-->
            <div class="main-wrapper">
                <div id="div-wrapper">
                    <!--<div id="hide"><button id="btn-like">Like</button><button id="btn-pass">Pass</button></div>-->
                    <i><h2 class="tagline"><i class="fa fa-building"></i> <?php print $cname; ?></h2></i>
                    <div class="stars" data-rating="0"><?php echo $ave_rating ?> - <i class="fa fa-star" aria-hidden="true"></i></div>
                    <hr>
                    <section class="section about-section">
                        <h2 class="section-title"><i class="fa fa-user"></i>About the Company</h2>
                        <div class="summary">
                            <p align="justify" style="font-size: 14.5px;" ><?php print nl2br($c_overview); ?></p>
                           <input type="hidden" name="accno" id="accno" value="<?php print $accno; ?>">
                        </div><!--//summary-->
                    </section><!--//section-->
                    <hr>
                    <br>
                    <section class="section Reviews">
                        <h2 class="section-title"><i class="fa fa-check"></i>Reviews <b>(<?php echo $cnt ?> Total Review/s)</b></h2>
                        
                    <div class="row" style="margin-top:5px;">
                        <div class="col-sm-12">
                        <div class="well well-sm col-sm-12">
                            <div class="text-center">
                                <a class="btn btn-success btn-green" href=#reviews-anchor" id="open-review-box">Leave a Review</a>
                            </div>
                        
                            <div class="row" id="post-review-box" style="display:none;">
                                <div class="col-sm-12">
                                    <form accept-charset="UTF-8" id="reviews-form" method="post">                    
                                        
                                        <p><b>Overall Rating:</b></p><div class="stars starrr" data-rating="0"></div>
                                        <input type="hidden" name="company" value=<?php echo $accno; ?>>
                                        <input id="ratings-hidden" name="rating" type="hidden">
                                        <p><b>Name: </b></p>
                                        <input class="form-control animated"  type="text" id="name" name="name" placeholder="Type your name here" required> 
                                        <p><b>Title of your review: </b></p>
                                        <input class="form-control animated" id="title"  type="text" name="title" placeholder="If you could say it in one sentence, what would you say?" maxlength="100" required> 
                                        <p><b>Your review: </b></p>
                                        <textarea class="form-control animated" cols="50" id="comment" name="comment" placeholder="Enter your review here..." rows="10" maxlength="3000" onKeyPress="return taLimit(this)" onKeyUp="return taCount(this,'myCounter')" required></textarea>
                                        <B><p align=right style="font-size: 15px;"><span id=myCounter>3000</span>/3000 &nbsp</B></p>
                        
                                        <div class="text-center">
                                            <br>
                                            <a class="btn btn-danger" href="#" id="close-review-box" style="display:none; margin-right: 10px;">
                                            <span class="glyphicon glyphicon-remove"></span> Cancel</a>
                                            <button class="btn btn-success btn-green" type="submit" id="save-review"><span class="glyphicon glyphicon-ok" ></span> Save Review</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>  
                        </div>
                    </div>
                </div>
            </div>
               <!--//FOR NEW REVIEWS-->         
            

            
    </div>
    <br>
                                                    <!--//ETO YUNG DIV NG REVIEWS-->
    <div class="panel comments" id="review-panel" style="box-shadow: 0px 1px 35px -15px rgba(163,163,163,1);">
        <div class="panel-head">
            <center><h3>Comments and Reviews</h3></center>
            <hr class="star-light">                                            <!--//ETO YUNG REVIEWS-->
        </div>
        <div class="panel-content">
            <?php 
                $reviewss = "SELECT * FROM `reviews` where emp_accno=:accno ORDER BY `reviews`.`date` DESC";
                $db_obj->setQuery($reviewss);
                $res = $db_obj->executeQuery($params,true);
                $cnt = $db_obj->returnCount();
                    if($cnt !== 0){
                        foreach ($res as $row) {
                            $name2 = $row['name'];
                            $title2 = $row['title'];
                            $comment2 = $row['body']; 
                            $date2 = $row['date'];
                            $rating2 = $row['rating']; 

                            print "<p><span style='color: #4CAC9D; font-size: 18px;'><i><b>\"$title2\"</b></i></span>
                            <span style='font-size: 16px;''> - $name2 ($date2)</span>
                            <div disabled='true' class='stars' style='font-size: 18px; text-align: left;''>
                                $rating2 - <i class='fa fa-star' aria-hidden='true'></i>
                            </div>
                            <div style='font-size: 16px;'>
                                <br><b>Review:</b><br>
                                <p align='justify'> $comment2 </p>
                            </div>
                            <hr>";
                        }
                        print "<hr class='star-primary'><center><a href='#review-panel'>Top of Reviews</a></center>";
                    } 
                    else {
                        print "<br><p align='center' style='font-size: 16px;'>Be the first to review this company!</p>";
                    }
            ?>     
        </div>
            
    </div>
                           
                    
</section>


<script type="text/javascript">

//SCRIPT PARA SA LIMIT NG INPUT SA TEXTBOX
maxL=3000;
var bName = navigator.appName;
function taLimit(taObj) {
    if (taObj.value.length==maxL) return false;
    return true;
}

function taCount(taObj,Cnt) { 
    objCnt=createObject(Cnt);
    objVal=taObj.value;
    if (objVal.length>maxL) objVal=objVal.substring(0,maxL);
    if (objCnt) {
        if(bName == "Netscape"){    
            objCnt.textContent=maxL-objVal.length;}
        else{objCnt.innerText=maxL-objVal.length;}
    }
    return true;
}
function createObject(objId) {
    if (document.getElementById) return document.getElementById(objId);
    else if (document.layers) return eval("document." + objId);
    else if (document.all) return eval("document.all." + objId);
    else return eval("document." + objId);
}
</script>