
function initializeClock(id, endtime) {
  var clock = document.getElementById(id);
  var minutesSpan = clock.querySelector('.minutes');
  var secondsSpan = clock.querySelector('.seconds');

  
  var now = moment();
  var time_remaining;
  function updateClock() {
    time_remaining = moment.duration(endtime.diff(now.add(1,'second'))); 

    if(time_remaining.seconds() < 0){
      swal({
        allowOutsideClick:false,
        text:"Loading...",

      });
      swal.showLoading();
      clearInterval(timeinterval);
      var data = {
        email:getParameterByName('email'),
        action:'delete'
      }

      $.post("timer_time_tracking.php",data,function(res){
      }).done(function(res){
        swal.close();
        if(res){
          location.href = "email-verif.php"
        }
        else{
          swal("Error",res,"error")
        }
      })
    }
    else{
      minutesSpan.innerHTML = ('0' + time_remaining.minutes()).slice(-2);
      secondsSpan.innerHTML = ('0' + time_remaining.seconds()).slice(-2);  
    }
      
        
  }
  function getParameterByName(name,url)
  {
      if(!url) url = window.location.href;
      name = name.replace(/[\[\]]/g, "\\$&");
      var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
      results = regex.exec(url);
      if (!results) return null;
      if (!results[2]) return '';
      return decodeURIComponent(results[2].replace(/\+/g, " "));
  }

  updateClock();
  var timeinterval = setInterval(updateClock, 1000);
 
}
//start data in the database
function initializeDateTime(dateTime){
  var deadline = moment({hour: dateTime.hour, minute: dateTime.minute, seconds: dateTime.seconds}).add(30,'minutes');
  initializeClock('clockdiv', deadline);
}
