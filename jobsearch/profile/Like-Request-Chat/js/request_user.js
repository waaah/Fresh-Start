function setUserFunctions(accno,usertype)
{
	//firebase controllers
	const request_controller = database.ref('/Request-Controller/');
	const match_controller = database.ref('/Matches-Controller/');
	const notification_controller = database.ref('/Notification-Controller/');
	const credentials = {
		userType:usertype,
		accno:accno,
		folder:"/jobsearch/profile/Like-Request-Chat/php-server/"
	}
	var userType = "applicant";
	function testParse(string){
		try{
			var json = JSON.parse(string);
		}
		catch(e){
			return null
		}
		return json;
	}
	function tabulateData(array,tdSpan,tdIndexes,links,id){
		if(array==null){
			return "<td colspan="+tdSpan+">No records were found.</td>";
		}
		else{
			var tableInsert = '';
			var len = array.length;
			var src = null;
			for (var i = 0; i < len; i++) {
				//inserts a new table row
				var currentRow = array[i];
				tableInsert+="<tr id="+currentRow['request_id']+">";
				if(currentRow['who_requester'] == 'company'){
					currentRow['who_requester'] = 'employer';
				}
				if(currentRow.pic == ""){
					if(credentials.userType == "employer")
						source = "<img src='/jobsearch/employee.png' width=100px style='border-radius:50%'>";
					else
						source = "<img src='/jobsearch/employer.png' width=100px style='border-radius:50%'>";
				}
				else{
					source= "<img src='/jobsearch/profile/upload/"+currentRow.pic+"' width=100px>"
				}
				tableInsert+= "<td>"+source;
				if(credentials.userType == "applicant")
					tableInsert+= "<td>" +currentRow.lname +"," +currentRow.fname +"</td>";
				else
					tableInsert+= "<td><a href='/jobsearch/resume/load.php?accno="+currentRow['accno']+"'>" +currentRow.lname +"," +currentRow.fname +"</td>";
				
				//for inserting specified indexes
			
				if(tdIndexes != null){
					for (var j = 0; j < tdIndexes.length; j++) {
						tableInsert+= "<td><a href='"+links[j]+currentRow[id[j]]+"' target='_blank'>"+currentRow[tdIndexes[j]] +"</a></td>";
					}	
				}
				
				//end of inserting specified indexes
				//insert a td with buttons
				tableInsert+='<td>';
				if(credentials.userType != currentRow['who_requester']){
					tableInsert+="<button type='button' class='btn btn-success btn-circle btn-lg accept_request' requestNo='"+currentRow['request_id']+"' otherAccno='"+currentRow['accno']+"'>";
					tableInsert+="<i class='glyphicon glyphicon-thumbs-up'></i></button>";
					tableInsert+="<button type='button' class='btn btn-danger btn-circle btn-lg reject_request' requestNo='"+currentRow['request_id']+"' otherAccno='"+currentRow['accno']+"'>";
					tableInsert+="<i class='glyphicon glyphicon-thumbs-down'></i></button>";
				}
				else{
					tableInsert+="<button type='button' class='btn btn-danger btn-circle btn-lg remove_request' requestNo='"+currentRow['request_id']+"' otherAccno='"+currentRow['accno']+"'>";
					tableInsert+="<i class='glyphicon glyphicon-thumbs-up'></i></button>";
				}
				tableInsert+="</td>";
				tableInsert+="</tr>";	
				
				//doesn't insert a new table row	
			}
			return tableInsert;
		}
	}
	//necessary functions or class-like function
	var notifications = new function(){
		var self = this;
		this.setNotifType = function(notifType){
			self.notifType = notifType;
		}
		this.addNotification = function(notif_accno,text){
			if(self.notifType != null){
				var parameters = {
					notif_accno:notif_accno,
					notif_text:text,
					notif_type:self.notifType
				}

				$.post(credentials.folder+'insertNotif.php',parameters,function(response){
					console.log(response)
					var response = testParse(response);
					if(response != null){
						console.log(notif_accno);
						notification_controller.child(notif_accno).push({
							notification:text,
							time:response[":r_time"],
							date:response[":r_date"],
							owner:notif_accno
						})
					}

				}).done(function(response){
					self.notifType = null;
				})
			}
			else{
				console.log("set notification type first.")
			}
			
		},
		this.getNotifications = function(all = true){
			$.post(credentials.folder+"printNotif.php",{printNotif:true,printAll:all},function(data){
				if(all == true)
					self.setNotifications(data);
				else{
					self.notify(data);
				}
			})
		},
		this.notify = function(data){
			var notyf = new Notyf({delay:4000});
			data = testParse(data);
			if(data !=null){
				notyf.confirm("You have "+data.length+" unread notifications.");	
			}
			
		}
		this.setNotifications = function(data){
			data = testParse(data);
			var len = 0;
			var items ="";
			if(data != null){
				for (var i = 0; i < data.length; i++) {
					items += self.setNotifHTML(data[i])
					if(data[i].unread=="true")
						len++;
				}
			}
			else{
				items = "<li><center>No Notifications</center></li>"
			}
			$("#notificationsBody .notifications").html(items);
			$("#my-notif-count").html(len);
		},
		this.setNotifHTML = function(currentRow){
			var link = "";
			if(currentRow.pic == ""){
				if(credentials.userType == "applicant"){
					link = "/jobsearch/employer.png"
				}
				else{
					link = "/jobsearch/employee.png"	
				}
			}
			else{
				link = "/jobsearch/profile/upload/"+currentRow.pic;
			}
			return "<a class='link-notif'>"
					 +"<li class='notification-single' id='$notif_id' style='padding-left:-20px;'>"
				        +"<div class='media-left'>"
				          +"<div class='media-object'>"
				            +"<img src='"+link+"' class='img-circle w3-small' width=60px alt='Name'>"
				          +"</div>"
				        +"</div>"
				        +"<div class='media-body'>"
				          +"<strong class='notification-title'>"+currentRow.fname+" "+currentRow.lname+"</strong>"
				          +"<p class='notification-desc'>"+currentRow.notif_text+"</p>"
				          +"<div class='notification-meta'>"
				            +"<i class='fa fa-calendar-o' aria-hidden='true'></i><small class='timestamp'>&nbsp;"+currentRow.date_received+"</small>"
				          +"</div>"
				          +"<div class='notification-meta'>"
				            +"<i class='fa fa-clock-o' aria-hidden='true'></i><small class='timestamp'>&nbsp;"+currentRow.time_received+"</small>"
				          +"</div>"
				        +"</div>"
				      +"</div>"
				      +"<hr>"
				  +"</li>"
				  +"</a>";
		}
		
	}
	//this is for processing requests
	var request = new function(){
		var self = this;
		this.processData = function(){
			var server_folder = (credentials.userType == "applicant") ? "get-applicant-requests.php" : "get-company-requests.php";
			$.post(credentials.folder+server_folder,{toServer:true},function(response){
				var response = testParse(response);
				(credentials.userType == "applicant") ? self.returnApplicantRequestData(response) : self.returnCompanyRequestData(response);
			})
		}
		this.returnApplicantRequestData = function(data){
			console.log(data)
			self.JobRequestTable(data.jobs);
			self.ApplicationRequestTable(data.employer);
		},
		this.returnCompanyRequestData = function(data){
			console.log(data["applicant_requested"]);
			self.CompanyRequestTable(data.requesting_applicants);
			self.RequestedApplicantTable(data.applicant_requested);
		}
		this.ApplicationRequestTable = function(array){
			var tdIndexes = ["cname"];
			var id = ['accno'];
			//sets the value of the table//
			var links = ["/jobsearch/view/review/reviews.php?code="];
			$("tbody#list-companies").html(tabulateData(array,5,tdIndexes,links,id));	
			var count = (array == null) ? 0 : array.length;
			$("count#company-request-count").html(count);
			$("count#company-request-count-narrowed").html(count);
		},
		this.JobRequestTable = function(array){
			var tdIndexes = ["cname","job_name"];
			var links = ["/jobsearch/view/review/reviews.php?code=","/jobsearch/view/viewjob/job_view.php?job_id="];
			var id = ['accno','id'];
			$("tbody#job-request-list").html(tabulateData(array,5,tdIndexes,links,id));	
			var count = (array == null) ? 0 : array.length;
			$("count#my-job-requests").html(count);
			$("count#my-job-requests-narrowed").html(count);
		},
		this.CompanyRequestTable = function(array){
			//this is for the applicants requesting a job
			var tdIndexes = ["job_name"];
			var links = ["/jobsearch/view/viewjob/job_view.php?job_id="];
			var id = ['id'];
			$("tbody#requesting-applicants").html(tabulateData(array,4,tdIndexes,links,id));	
			var count = (array == null) ? 0 : array.length;
			$("count#count-applicant-requesters").html(count);
			$("count#count-applicant-requesters-narrowed").html(count);
		},
		this.RequestedApplicantTable = function(array){
			//this is for the requested applicants
			$("tbody#requested-applicants").html(tabulateData(array,3));	
			var count = (array == null) ? 0 : array.length;
			$("count#requested-applicants-count").html(count);
			$("count#requested-applicants-narrowed").html(count);
		},
		this.processMatch = function(requestResponse,request_id,resolve,userFunction){
			var $data = {
				startMatch:true,
				requestResponse:requestResponse,
				request_id:request_id
			};
			$.post(credentials.folder+"processRequest.php",$data,function(response){
				userFunction(response);
				resolve();
			});
		},
		this.requestAlert = function($params){
			var $userResponse;
			swal({
				title:$params.title,
				text:$params.text,
				type:$params.type,
				showCancelButton:true,
				allowOutsideClick:false,
				showLoaderOnConfirm:true,
				preConfirm: function(){
					return new Promise(function(resolve,reject){
						self.processMatch($params.response,$params.requestId,resolve,function(data){
							$userResponse = testParse(data);
						});
					})
				}
			}).then(function(){
				if($userResponse.successful){
					request_controller.limitToFirst(1).once('value', function(snapshot){
						var children = snapshot.val();
						for(child in children){
							var firstChild = child;
						}
						request_controller.child(firstChild).remove();
					});
					if($params.response === "accept"){
						var message = {
							message:"Hello! I would like to thank you for accepting my match request. I am looking forward to having a pleasant conversation with you.",
							sender:$params.otherAccno
						}
						match_controller.child($userResponse.requestId).push(message)
						$.post(credentials.folder+"save-message.php",message,function(){
							notifications.setNotifType("Accept User");
							notifications.addNotification($params.otherAccno,"This user has accepted your match proposal. Both users may now engage in chat.")	
						})
					}
					else{
						notifications.setNotifType("Reject/Remove User");
						notifications.addNotification($params.otherAccno,"This user has rejected your proposal.")
					}
					swal("Congratulations","User transaction transaction has been successful","success");
				}
				else{
					swal("Sorry",$userResponse.message,"error");
				}
				
			}).catch(swal.noop);
		}
		
	}
	var matches = new function(){
		var self = this;
		this.processData = function(){
			var fileLocation = (credentials.userType == "applicant") ? "get-applicant-matches.php" : "get-company-matches.php"
			$.post(credentials.folder+fileLocation,{toServer:true},function(response){
				if(testParse(response)){
					var data = (credentials.userType=="applicant")? testParse(response).employer : testParse(response).applicants;
					self.returnMatches(data);
				}
			})
		},
		this.returnMatches = function(data){
			var items='';
			if(data != null){
				console.log(data);
				for (var i = 0; i < data.length; i++) {
					items+=self.chatList(data,i);
				}
				console.log(items)
			}
			else{
				items = "<center>There are no users that are matched with you.</center>"
			}
			$("#chatListUL").html(items);	
					
		},
		this.chatList = function(data,i){
			var source = "<img src='/jobsearch/profile/upload/"+data[i].pic+"' alt='User Avatar' id='my_match_pic' width=60px class='img-circle pull-left'/>";
			var reply = "";
			if(data[i].pic == ""){
				if(credentials.userType == "applicant"){
					source = "<img src='/jobsearch/employer.png' alt='User Avatar' id='my_match_pic' width=60px class='img-circle pull-left'/>";
				}
				else{
					source = "<img src='/jobsearch/employee.png' alt='User Avatar' id='my_match_pic' width=60px class='img-circle pull-left'/>";
				}
			}
			
			reply = (data[i].who_requester == credentials.userType) ? "<span class='fa fa-mail-reply'></span>" : "My Message:";
			
				
			return "<li class='left clearfix' id='chatListSingle' user-id='"+data[i].match_id+"' accno='"+data[i].accno+"'><span class='chat-img pull-left'></span>"
	            +source+"<a data-toggle='modal' data-toggle='modal' data-dismiss='modal' data-target='#directChat'>"
	                     +"<div class='chat-body clearfix'>"
	                      +"<div class='row'>"
	                       +"<div class='header col-sm-9'>"
	                          +"<strong class='primary-font otherUserChatLink' id='"+data[i].accno+"'>"
	                           +data[i].lname+","+data[i].fname+"<div class='headingName'></div></strong>"
	                           +reply+"&nbsp;"+data[i]["latestMessage"]+"<i class='text-muted'></i><br>"
	                            +"<small class='text-muted'>"
	                               +"<span class='glyphicon glyphicon-calendar'>"+data[i]["dateSent"]+"</span><br>"
	                               +"<span class='glyphicon glyphicon-time'>"+data[i]["timeSent"]+"</span>"
	                             +"</small>"
	                       +"</div>"
	                      +"</a>"
	                       +"<div class='col-sm-3'>"
	                       +"<center><button class='btn btn-success unmatch-user'"
	                       +"match-id='"+data[i].match_id+"''>"
	                       +"Unmatch with User</button></center>"
	                       +"</div>"
	                      +"</div>"
	                     +"</div>"
	                   
	                 +"</li>";
		}
	}

	//This entire level is for intercepting changes in the database.

	//Trigger Request Controller if a request is added in firebase
	request_controller.on("value",function(){
		request.processData();
	})
	notification_controller.on("value",function(){
		notifications.getNotifications();
		notifications.getNotifications(false);
	})
	//Trigger Match Controller if a match is added in firebase
	match_controller.on("value",function(){
		matches.processData();
	})

	$('tbody').on('click','.accept_request',function(){
		var $requestId = $(this).attr("requestNo");
		var $accno = $(this).attr("otherAccno");
		request.requestAlert({
			title:"Confirmation",
			type:"question",
			text:"Do you want to accept this users match request",
			response:"accept",
			requestId:$requestId,
			otherAccno:$accno
		})
		
	})
	$('tbody').on('click','.reject_request',function(){
		var $requestId = $(this).attr("requestNo");
		var $accno = $(this).attr("otherAccno");
		request.requestAlert({
			title:"Confirmation",
			type:"question",
			text:"Do you want to reject this users match request",
			response:"reject",
			requestId:$requestId,
			otherAccno:$accno
		})
	})
	$('tbody').on('click','.remove_request',function(){
		var $requestId = $(this).attr("requestNo");
		var $accno = $(this).attr("otherAccno");
		request.requestAlert({
			title:"Confirmation",
			type:"question",
			text:"Do you want to remove this request?",
			response:"remove",
			requestId:$requestId,
			otherAccno:$accno
		})
	})
	$("#notificationLink").click(function(){
		//shows the exit button first
		$("#my-notif-exit").show("fast",function(){
			//then the container
			$("#notificationContainer").show("slow", function(){
				//once the data is shown, data is fetched from firebase
				$.post(credentials.folder+"setNotification.php",{setNotification:true},function(response){
					$("#my-notif-count").html("0")
				});
			});
		});
	})
	$("#my-notif-exit").click(function(){
		$("#notificationContainer").hide("slow",function(){
			$("#my-notif-exit").fadeOut("fast");
		})
	})
	$("#openChatList").on('click',function(){
		console.log('openChatList')
		$("#my-notif-exit").trigger('click');
	})
	$("#chatListUL").on('click','.unmatch-user',function(){
		var match_id = $(this).attr("match-id");
		var user_data = {
			match_id:match_id,
			removeMatch:true
		};
		swal({
			text:"Do you want to unmatch this user?"
			+"Once both users are unmatched, it cannot "
			+"be undone. Do you still want to continue anyway?",
			title:"Warning",
			type:"warning",
			showCancelButton:true,
			allowOutsideClick:false,
			showLoaderOnConfirm:true,
			preConfirm:function(){
				return new Promise(function(reject,resolve){
					$.post("/jobsearch/profile/Like-Request-Chat/php-server/request-server.php",user_data,function(data){
						data = JSON.parse(data);
						if(data.isSuccess){
							match_controller.child(user_data.match_id).set(null)
							swal("Success","Both users are now unmatched","success");
						}
						else{
							swal("Error",data.error,"error");
						}
					});
				});
			}
		})
	});

	//chat
var Message;
var $chatRoom;
var otherLineAccno;
var newfirebaseRef = firebase.database();

$(function(){
    $("#chatListUL").on('click','#chatListSingle',function(){
        clearMessages();
        var otherimageSrc = $(this).find("#my_match_pic").attr("src");
        otherLineAccno = $(this).attr("accno");
        $("#top-image").attr("src",otherimageSrc);
        $("#this-image").attr("src",otherimageSrc);
        $chatRoom = $(this).attr("user-id");
        getAllMessagesOnce($chatRoom);
    });
});
(function(){
    var Message;
    Message = function (arg) {
        this.text = arg.text, this.message_side = arg.message_side;
        this.draw = function (_this) {
            return function () {
                var $message;
                $message = $($('.message_template').clone().html());
                $message.addClass(_this.message_side).find('.text').html(_this.text);
                $('.messages').append($message);
                return setTimeout(function () {
                    return $message.addClass('appeared');
                }, 0);
            };
        }(this);
        return this;
    };
    getAllMessagesOnce = function($chatRoom){
        
        newfirebaseRef.ref('/Matches-Controller/'+$chatRoom).once('value', function(snap) {
            snap.forEach(function(childSnapShot){
                var body = childSnapShot.child('message').val();
                var sender = childSnapShot.child('sender').val();
                message_side = (sender != accno) ? 'left' : 'right';
                sendMessage(body,message_side);
            });
        });
        //$('.messages').animate({ scrollTop: $messages.prop('scrollHeight') }, 300);
    }
    saveMessage = function (text){
        var parameters = {
            message:text,
            sender:accno
        }
        $.post("/jobsearch/profile/Like-Request-Chat/php-server/save-message.php",parameters,function(response){
            response = JSON.parse(response);
            console.log(response);
            if(response.saved == true){
                newfirebaseRef.ref("/Matches-Controller/").child($chatRoom).push(parameters);
                notifications.setNotifType("Message User");
                notifications.addNotification(otherLineAccno,"has sent you a new message. To view the complete message please go to the chat room.")
            }
        })
    };

    getMessageText = function () {
        var $message_input;
        $message_input = $('.message_input');
        return $message_input.val();
    };
    sendMessage = function (text,side,saveToDatabase,animate) {
        var $messages, message;
        if (text.trim() === '') {
            return;
        }
        $('.message_input').val('');
        $messages = $('.messages');
        message = new Message({
            text: text,
            message_side:side
        });
        message.draw();
        //save to database
        if(saveToDatabase){
            saveMessage(text);   
        }
        if(animate){
        	$messages.animate({ scrollTop: $messages.prop('scrollHeight') }, 300);
        }

        
    };
    clearMessages = function(){
        $('.messages').empty();
    };
    $('.send_message').click(function (e) {
        var message_val = $('.message_input').val().trim();
        if(message_val!==""){
            sendMessage(getMessageText(),"right",true,true);
        }
        else{
            swal("Error!","Please enter a message","error")        
        }
    });
    $('.message_input').keyup(function (e) {
        var obj = $(this)
        var val = obj.val();
        if (e.which === 13) {
            if(val.trim()!==""){
                sendMessage(getMessageText(),"right",true,true);
            }
            else{
                swal("Error!","Please enter a message","error").then(function(){
                    obj.blur();
                })        
            }
        }
        
    });
    newfirebaseRef.ref("/Matches-Controller/").on("value",function(){
		if($chatRoom != undefined){
			newfirebaseRef.ref("/Matches-Controller/"+$chatRoom).limitToLast(1).once("child_added",function(snapshot){
				var value = snapshot.val();
				if(credentials.accno != value.sender)
					sendMessage(value.message,"left",false,true);
			})
		}
	});
}).call(this)
			
}