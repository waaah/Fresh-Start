<?php
  session_start();
  include("dbconnect.php");
  $accno = $_SESSION['accno'];
  $utype = $_SESSION['utype'];
  $what_do = $_POST['what_do_you_want_to_do'];
  if($what_do=="print_chat_list"){
    if($utype=='employer'){
      $type = "employee.png";
      $query = "Select * from applicant_tbl app LEFT JOIN like_tbl liked ON app.accno = liked.applicant_id where  liked.company_id = '$accno' order by liked.date_messaged DESC, liked.time_messaged DESC";
    }
    else if($utype=='applicant'){
      $type = "employer.png";
      $query = "Select * from employer_tbl emp LEFT JOIN like_tbl liked ON emp.accno = liked.company_id where  liked.applicant_id = '$accno' order by liked.date_messaged DESC, liked.time_messaged DESC";
    }
    $res = mysql_query($query);
    while($row=mysql_fetch_array($res))
    {
      $fname = $row['fname'];
      $lname = $row['lname'];
      $like_id = $row['like_id'];
      $time = $row['time_messaged'];
      $date = $row['date_messaged'];
      $latest_message = $row['latest_message'];
      $who_sent = $row['who_sent'];
      $pic = $row['pic'];
      if($pic==''){
        $pic = "/jobsearch/$type";
      }
      else{
        $pic ='upload/'.$pic;
      }
      if($who_sent == $accno){
        $recepient = "You: ";
      }
      else{
        $recepient = "";
      }
        print "<li class='left clearfix' id='chatListSingle'><span class='chat-img pull-left'>
            <img src='$pic' alt='User Avatar' id='my_match_pic' width=60px class='img-circle profile' />
            </span>
          <a data-toggle='modal' data-toggle='modal' data-dismiss='modal' data-target='#directChat'>
            <div class='chat-body clearfix'>
              <div class='header'>
                <strong class='primary-font' id='otherUserChatLink'>
                  <div class='headingName' id='$like_id'> $fname $lname </div></strong>
                  <span class='fa fa-mail-reply'></span>&nbsp; <i class='text-muted'>$recepient $latest_message</i>
                    <small class='pull-right text-muted'>
                      <span class='glyphicon glyphicon-calendar'></span>$date<br>
                      <span class='glyphicon glyphicon-time'></span>$time
                    </small>
              </div>
            </div>
          </a>
        </li>";

    }
  }
  else if($what_do=="update_chat_date_time"){
    $date = $_POST['date'];
    $time = $_POST['time'];
    $message = $_POST['message'];
    $_message = mysql_real_escape_string($message);
    $who_sent = $_POST['who_sent'];
    $requester = $_SESSION['accno'];
    $requester_type = $_SESSION['utype'];
    $roomName = str_replace("/", "", $_POST['roomName']);
    $update = "Update like_tbl SET
                  time_messaged='$time',
                  date_messaged='$date',
                  latest_message='$_message',
                  who_sent = '$who_sent'
                where like_id='$roomName'"; 
    $res = mysql_query($update);
    $get_other_id = "select * from like_tbl where like_id='$roomName'";
    $result_query = mysql_query($get_other_id);
    while($row_id = mysql_fetch_array($result_query)){
      if($requester_type=='applicant'){
        $target = $row_id['company_id'];
      }
      else{
        $target = $row_id['applicant_id']; 
      }
    }
    $send_message = "Select * from notification where notif_type='Sent Message' and requester = '$requester' and target='$target'";
    $res2 = mysql_query($send_message);
    $cnt = mysql_num_rows($res2);
    if($cnt==0){
      //insert
      $new_query = "Insert into notification values('','has sent you a new message','Sent Message','$target','$requester','$date','$time','true')";
    }
    else{
      //update
      while($row = mysql_fetch_array($res2)){
        $notif_id = $row['notif_id'];
      }
      $new_query = "Update notification SET time_received='$time', date_received='$date',unread='true' where notif_id='$notif_id'"; 
    }
    mysql_query($new_query);
  }
?>