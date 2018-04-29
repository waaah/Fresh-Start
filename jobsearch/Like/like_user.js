$(function(){
	function sendNotif($data){
		const notification_controller = database.ref('/Notification-Controller/');
		var parameters = {
			notif_accno:$data.target,
			notif_text:"has sent you a match request. Please refer to the matches tab for more information",
			notif_type:"Send Request"
		}
		return $.post('/jobsearch/profile/Like-Request-Chat/php-server/insertNotif.php',parameters,function(response){
			var response = JSON.parse(response);
			if(response != null){
				notification_controller.child(parameters.notif_accno).push({
					notification:parameters.notif_text,
					time:response[":r_time"],
					date:response[":r_date"],
					owner:parameters.notif_accno
				})
			}
		})
	}
	function likeUser(target,jobID){
		var $data = {
			target:target,
			isJob:(location.pathname == "/jobsearch/job_search.php") ? 1:0,
			jobId: jobID,
			sendToServer:true,
			sendRequest:true
		}
		swal({
			type:"warning",
			title:"Warning!",
			text:"Are you sure you want to send a match request with this user. Once this request is sent, it cannot be reset! Do you want to continue anyway?",
			showCancelButton:true,
			showLoaderOnConfirm:true,
			preConfirm:function(){
				return new Promise(function(resolve,reject){
					$.post("/jobsearch/Like/like.php",$data,function(response){
					})
					.done(function(response){
						console.log(response);
						response = JSON.parse(response);
						if(response.isSuccess == 1){
							sendNotif($data).done(function(){
								database.ref("Request-Controller").push({
									byJob:$data.isJob,
									type:"Send Job Request."
								}).then(function(){
									swal("Success","Request is sent to the user!","success").then(function(){
										fadeCard($data.target);
									});	
								})
								
							})
						}
						else{
							if(response.changeRequest){
								resendRequest($data);
							}
							else{
								swal("Error",response.reason,"error")	
							}
							
						}
					})
				})
			},
			allowOutsideClick:false
		}).catch(swal.noop);	
	}
	//prompts the user if he wants to send another request
	function resendRequest($data){
		$data.retrySend = true;
		swal({
			type:"warning",
			title:"Request Replacement",
			text:"Do you want to overwrite\
			your previous request and replace it with this one instead? Please\
			take note that once this process is done it cannot be undone. Regardless, are you still willing to continue?",
			showCancelButton:true,
			showLoaderOnConfirm:true,
			allowOutsideClick:false,
			preConfirm:function(){
				return new Promise(function(resolve,reject){
					$.post("/jobsearch/Like/like.php",$data,function(data){
						data = JSON.parse(data);
						if(data.isSuccess){
							swal("Success",data.reason,"success").then(function(){
								fadeCard($data.target);
							});
						}
						else{
							swal("Error",data.reason,"error");
						}
					})
				})
			}
		})
	}

	function fadeCard(accno){
		var $card = $("#card-"+accno),container = null;
		var current_location = window.location.pathname
		$card.fadeOut();
		$card.remove();
		if(current_location == "/jobsearch/job_search.php")
			container = '#job-container';
		else if(current_location == "/jobsearch/applicant_search.php")
			container = '#applicant-container';

		pagination(null,$(container));
	}
	$(".content-xaas").on("click","button.like",function(){
		likeUser($(this).attr("user-id"),$(this).attr("job-id"));
	})
	$(".content-xaas").on("click","button.ignore",function(){
		fadeCard($(this).attr("user-id"));
	})
	$("#like-job").on("click",function(){
		likeUser($(this).attr("user-id"),$(this).attr("job-id"));
	})	
})
