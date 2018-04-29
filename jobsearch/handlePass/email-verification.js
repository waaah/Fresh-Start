$(function(){
  //initialize
    $('select').material_select();
    $("#card1").show();
    $("#card2").hide();
    $("#card3").hide();
})
$(function(){

  jQuery.validator.addMethod("emailValidation",function(value,element,param){
    var emailFormat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
    if(value.match(emailFormat)){
      return true
    }
    else{
      return false;
    }
  },"Invalid Email Format!");
  jQuery.validator.addMethod("notEmpty",function(value,element,param){
    return value !== null;
  },"Please select a value for this field.");
  //for the password-recovery-form//
  $("#user-type").validate({
    //For custom messages
    rules: {
      sel_user_type:{
        notEmpty:true
      }
    },
    errorElement : 'div',
    errorPlacement: function(error, element) {
      var placement = $(element).data('error');
      if (placement) {
        $(placement).append(error)
      } else {
        error.insertAfter(element);
      }
    },
    submitHandler: function(form){
        swal({
          allowOutsideClick:false,
          title:"Loading..."
        })
        swal.showLoading();
        var data = {
          usertype:$("#sel_user_type").val(),
          action: "Set User Type"
        }
        $.post("server-email-verification.php",data,function(res){
          $("#card2").show();
          $("#card1").hide();
          swal.close();
        })        
    }
  });
  $("#user-email").validate({
    rules: {
        conf_email: {
            required: true,
            emailValidation:true
        }
    },
    //For custom messages
    errorElement : 'div',
    errorPlacement: function(error, element) {
      var placement = $(element).data('error');
      if (placement) {
        $(placement).append(error)
      } else {
        error.insertAfter(element);
      }
    },
    submitHandler: function(form){
        swal({
          allowOutsideClick:false,
          title:"Loading..."
        })
        swal.showLoading();
        var data = {
          email: $("#user-email #conf_email").val(),
          action: "Set User Email"
        }
        $.post("server-email-verification.php",data,function(res){
          if(res != "null"){
            data['action'] = 'check';
            $.post("timer_time_tracking.php",data,function(result){
            }).done(function(result){
              if(result == "1"){
                proceedToNext();
                swal.close();
              }
              else{
                location.href = "timer.php?email="+data.email;
              }
            })  
          }
          else{
            swal("Sorry","The email you entered was invalid","error");
          }
          //function to proceed to next card
          function proceedToNext(){
            $("#card3").show();
            $("#card2").hide();
            var element = "<option value='' disabled selected>Choose your question</option>";
            console.log(res);
            res = JSON.parse(res);
            for (var i = 0; i < res.length; i++) {
              element +="<option>"+res[i].question+"</option>";
            }
            $("#select-question").html(element);
            $("#select-question").trigger('contentChanged');
            $("#tries").show();
          }
        })        
    }
  });
  $("#send-verification").validate({
    //For custom messages
    rules: {
      conf_answer:{
        required:true
      },
      select_question:{
        notEmpty:true
      }
    },
    errorElement : 'div',
    errorPlacement: function(error, element) {
      var placement = $(element).data('error');
      if (placement) {
        $(placement).append(error)
      } else {
        error.insertAfter(element);
      }
    },
    submitHandler: function(form){
        //Shows Loading if then asks user
        swal({
          allowOutsideClick:false,
          title:"Loading..."
        })
        swal.showLoading();
        var data = {
          question: $("#send-verification #select-question").val(),
          answer: $("#send-verification #conf_answer").val(),
          action: "Verify Question"
        }
        console.log(data)
        $.post("server-email-verification.php",data,function(data_count){
        }).done(function(data_count){
          console.log(data_count);
          data_count = parseInt(data_count);
          if(data_count > 0){
            swalVerification();  
          }
          else{
            var numtries = parseInt($("#num_tries").text()) - 1;
            $("#num_tries").text(numtries);
            if(numtries != 0){
              swal("Error","Sorry, your security question answer is not valid. You have only "+numtries+" attempt(s) remaining.","error");  
            }
            else{
              //saving unaccessable data to database 
              swal({
                allowOutsideClick:false,
                title:"Loading..."
              });
              var $email = {
                email:$("#user-email #conf_email").val(),
                action:"save"
              }
              swal.showLoading();
              $.post("timer_time_tracking.php",$email,function(){
              }).done(function(result){
                swal.hideLoading();
                if(result == true){
                   closeTimer();
                }
                else{
                  swal("Error!",result,"error");
                }
                
              })

              //close timer
              function closeTimer(){
                var closeInSeconds = 3,timer;
                var displayText = "You have exhausted all of your attempts. The page will be redirected in #1 seconds";
                swal({
                  title:"Redirection!",
                  html:displayText.replace(/#1/, closeInSeconds),
                  type:"info",
                  allowOutsideClick:false,
                  timer:3000,
                  showConfirmButton:false
                }).catch(swal.noop);
                //set timeout before redirecting
                setTimeout(function(){
                  location.href = "timer.php?email="+$email.email
                },3100)
                //interval for timer in the sweet alert.
                timer = setInterval(function(){
                  closeInSeconds--;
                  if(closeInSeconds < 0){
                    clearInterval(closeInSeconds);
                  }
                  $('.swal2-content').text(displayText.replace(/#1/, closeInSeconds))
                },1000);
              }
              
            }

          }
        })
        function swalVerification(){
          var error;
          swal({
              title:"Confirmation",
              text:"Do you want to send a confirmation email",
              allowOutsideClick:false,
              showCancelButton:true,
              showLoaderOnConfirm:true,
              type:"question",
              preConfirm:function(){
                return new Promise(function(resolve,reject){
                  data ={
                    action:"Validate Email"
                  }
                  $.post("server-email-verification.php",data,function(response){
                    error = response;
                  }).done(function(response){
                    resolve();
                  })
                })
              }
            }).then(function(){
              error = JSON.parse(error);
              console.log(error)
              if(error.isSuccess){
                swal("Success","Email has been sent. Please refer to your email address for more details","success").then(function(){
                  location.href="/jobsearch/";
                })
              }
              else{
                swal("Error",error.errorType,"error")
              }
            })
        }
                
    }
  });
  $("#user-email .previous").click(function(){
    $("#card1").show();
    $("#card2").hide();
  })

  $("#send-verification .previous").click(function(){
    $("#card2").show();
    $("#card3").hide();
    $("#tries").hide();
  })
  $('select').on('contentChanged',function(){
    $(this).material_select();
  })
});