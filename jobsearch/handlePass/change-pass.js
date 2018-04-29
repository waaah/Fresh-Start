$(function(){
  /*For change password*/
  //for the password change form
  
  $("#change-pass").validate({
    rules: {
      pass:{
        minlength:8
      },
      conf_pass: {
        minlength:8,
        equalTo:"#pass"
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
    submitHandler:function(form){
      swal({
        text:"Do you want to confirm your changes?",
        showCancelButton:true,
        type:"question",
        title:"Question"
      }).then(function(){
        swal({
          title:"Loading...",
          allowOutsideClick:false
        })
        swal.showLoading();
        data = {
          save_pass:true,
          password:$("#pass").val()
        }
        $.post("server-pass-change.php",data,function(success){
          swal.close();
          if(success == "1"){
            swal({
              title:"Success",
              text:"Password has been changed! Press OK to return to our main page",
              type:"success"
            })
            .then(function(){
              location.href = "/jobsearch/";
            });
          }
          else{
            swal("Error","Password could not be changed","error")
          }
        })
      });
    }
  });

});