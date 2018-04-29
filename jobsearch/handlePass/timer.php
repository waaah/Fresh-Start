<?php
  require $_SERVER['DOCUMENT_ROOT'] ."/DBConnectionString/dbconnect_class.php";
  if(isset($_GET['email'])){
    $db_obj = new DatabaseConnection();
    $db_obj->setQuery("select * from password_rec_timeout where email=:email");
    $res = $db_obj->executeQuery(array(':email'=>$_GET['email']),true);
    if($db_obj-> returnCount() < 1){
      header("location:email-verif.php");
    }
    else{
    }
  }
  else{
    header("location:email-verif.php");
  }
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="">
  <meta name="author" content="">
  <title>Countdown Timer</title>
  <script src="/jobsearch/profile/sweetalert2/sweetalert2.min.js"></script>
  <link rel="stylesheet" href="/jobsearch/profile/sweetalert2/sweetalert2.min.css">
  
</head>
<body>
  <h1><?php print $_GET['email']; ?> cannot use the change password feature for:</h1>
  <div id="clockdiv">
    <div>
      <span class="minutes"></span>
      <div class="smalltext">Minutes</div>
    </div>
    <div>
      <span class="seconds"></span>
      <div class="smalltext">Seconds</div>
    </div>
  </div>
  <h2>Click <a href="email-verif.php">here</a> to return to password recovery.</h2>
</body>
  <script type="text/javascript" src="moment.js"></script>
  <script type="text/javascript" src="timer.js"></script>
  <link rel="stylesheet" type="text/css" href="timer.css">
  <script type="text/javascript" src="/jobsearch/materialize/js/jquery-3.2.1.js"></script>
  <script type="text/javascript">
    <?php
      $time = date_create($res[0]['time']);
      $hour = $time->format('H');
      $minute = $time->format('i');
      $seconds = $time->format('s');
   ?>
   var hour = <?php print $hour;?>;
   var minute = <?php print $minute;?>;
   var seconds = <?php print $seconds?>;
   var time = {
    hour:hour,
    minute:minute,
    seconds:seconds
   }
   initializeDateTime(time);
  </script>
  
</html>