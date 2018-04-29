function logged_applicant(app_id){ 
  $("body").ready(function(){
    var window_location = window.location.pathname;
    if(app_id!=='employer'&&app_id!=='applicant'){
      $('#modal-login-applicant').removeClass('hide');
      $("#modal-overlay").addClass("overlay");
    }
    else if(app_id == "applicant"){
      $("#modal-overlay").addClass("overlay");
      $('#restricted_access').removeClass('hide');
    }
  })
}
function remove_card_animation($card,$containerClass,$paginationClass){
  $card.fadeOut('300',function(){
    $card.remove();
    var cnt = parseInt(document.getElementById('num-results').innerHTML);
    document.getElementById('num-results').innerHTML = cnt - 1; 
    pagination($containerClass,$paginationClass);
  });
}
$(function(){
  function applicant_matching(liked,$selector){
      var $card = $selector.parent().parent().parent().parent().parent().parent()
      $paginationClass = $("#applicantPagination");
      $containerClass = $(".applicant_list");
      if(liked){
        var id = $card.attr('id');
        $.post("/jobsearch/Like/like_functions/like_applicants.php",{receiver:id,liked:true},function(data){
          if(data!=="0"){
            swal("Error",data,"error")
          }
          else{
            swal("Success!","A match request has been sent","success")
            remove_card_animation($card,$containerClass,$paginationClass);          
          }
        })
      }
      else{
        remove_card_animation($card,$containerClass,$paginationClass); 
      }    
  }
  function company_matching(liked,$selector){
    var $card = $selector.parent().parent().parent().parent().parent().parent();
    $paginationClass = $("#jobsPagination");
      $containerClass = $(".jobs_list");
    if(liked){
      id = $card.attr('id');
      $.post("/jobsearch/Like/like_functions/like_employer.php",{receiver:id,liked:true},function(data){
        if(data!=="0"){
            swal("Error",data,"error")
        }
        else{
          swal("Success!", "A match request has been sent!", "success")
          remove_card_animation($card,$containerClass,$paginationClass); 
        }
      })
    }
    else{
      $card.fadeOut('300'); 
      remove_card_animation($card,$containerClass,$paginationClass); 
    }
  }
  $("body").on('click',".btn.btn-success.btn-circle.btn-lg",function(){
    var path = window.location.pathname;
    if(path=="/jobsearch/applicant_search.php"){
      applicant_matching(true,$(this));
    }
    else if(path == "/jobsearch/job_search.php"){
      company_matching(true,$(this));
    }
  })

  $("body").on('click','.btn.btn-danger.btn-circle.btn-lg',function(){
    var path = window.location.pathname;
    if(path==="/jobsearch/applicant_search.php"){
      applicant_matching(false,$(this));
    }
    else if(path === "/jobsearch/job_search.php"){
      company_matching(false,$(this));
    }
  })

  $('#close').addClass('hide');
  $('#modal-cancel-btn').click(function(e) {
      e.preventDefault();
      $('.modal-input').val('');
    })

    $('.login').click(function(){
    	$('#modal-login-applicant').removeClass('hide');
    	$("#modal-overlay").addClass("overlay");
    });
    $('.visible-icon').click(function() {
      var type = $('#modalpass').attr('type');
      if(type === "password"){
      	$("#modalpass").attr('type','text')
      	$("#close").removeClass('hide');
      	$("#open").addClass('hide');

      }
      else if(type=== "text"){
      	$("#modalpass").attr('type','password')
      	$("#open").removeClass('hide');
      	$("#close").addClass('hide');
      }
    })
    
    $('#signin-btn').click(function(){
        $('#modal-login-applicant').show();
        $('.top-btn').attr('disabled',true);
        $('.topbar-btn').attr('disabled',true);
        $('.main-wrapper').css('-webkit-filter','blur(5px) ');
        $('body').css('-webkit-filter','greyscale(50%'); 
        $('.main-wrapper').css('transition-duration','1s');
    })
    $("#modal-login-btn").click(function(e){
      e.preventDefault();
    	var pass = $("#modalpass").val()
    	var accno = $("#modalacc").val()
      var response;
      var location = window.location.pathname;
    	$.post("dbconnect.php",{modalacc:accno,modalpass:pass,signin:location},function(data){
    		$("#modal-login-btn").text("Loading...")
    		response = JSON.parse(data);
    		$("#navbar-main").html("<div style='margin-top:15px'></div>" +response[1]);
    	}).done(function(data){
    		if(response[0] ==='true'){
    			$("#modal-overlay").removeClass("overlay");
    			$('#modal-login-applicant').addClass('hide');		
    		}
    		else{
    			alert("Invalid username and password")
    		}
    		$("#modal-login-btn").text("Login")
    	})
    })
    $('#exit-modal').click(function(){
        $('#modal-login-applicant');
        $('#modal-login-applicant').addClass('hide');            
    	  $("#modal-overlay").removeClass("overlay");
    })
})