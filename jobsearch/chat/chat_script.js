(function () {

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
    $(function () {
        function getAllMessagesOnce(){
            var newfirebaseRef = firebase.database().ref('/Matches'+chatRoom);
            newfirebaseRef.once('value', function(snap) {
                snap.forEach(function(childSnapShot){
                    var sender = childSnapShot.child('sender').val()
                    var body = childSnapShot.child('body').val()
                    if(sender !== accno){
                        message_side = "left";
                        sendMessage(body,"yes");
                    }
                    else{
                        message_side = "right";
                        sendMessage(body,"yes");
                    }
                })
            });
            $('.messages').animate({ scrollTop: $messages.prop('scrollHeight') }, 300);
        }
        var chatRoom = '';
        $("#chatListUL").on('click','#chatListSingle',function(){
            chatRoom = "/" + $(this).find("#otherUserChatLink .headingName").attr("id");
            $(".otherUsername").html($(this).find("#otherUserChatLink .headingName").text())
            var accno = $("#hidden_accno").val();
            clearMessages();
            var otherimageSrc = $(this).find("#my_match_pic").attr("src");
            $("#top-image").attr("src",otherimageSrc);
            $("#this-image").attr("src",otherimageSrc);
            getAllMessagesOnce();
        });

        function chatWhatever(task,date,time,roomName,message,accno){
            var myData = new Object();
            if(typeof date!=='undefined'||typeof time!=='undefined'){
                myData = {
                    date:date,
                    time:time,
                    roomName:roomName,
                    message:message,
                    who_sent:accno
                }
            }  
            myData["what_do_you_want_to_do"] = task;
            $.post("/jobsearch/chat/a.php",myData,function(response){    
            })
            .done(function(response){
                $("#chatListUL").html(response)
            })
            
        }

        $("#chatList").on('show.bs.modal', function(){           
            chatWhatever("print_chat_list");
        })
        var getMessageText, message_side, sendMessage,chatRoom;
        message_side = 'right';
        var accno = $("#hidden_accno").val();
        
        getMessageText = function () {
            var $message_input;
            $message_input = $('.message_input');
            return $message_input.val();
        };
        sendMessage = function (text,multiple) {
            var $messages, message;
            if (text.trim() === '') {
                return;
            }
            $('.message_input').val('');
            $messages = $('.messages');
            message_side = message_side === 'left' ? 'left' : 'right';
            
            message = new Message({
                text: text,
                message_side: message_side
            });
            message.draw();
            if(multiple == null){
                return $messages.animate({ scrollTop: $messages.prop('scrollHeight') }, 300);
            }
        };
        clearMessages = function(){
            $('.messages').empty();
        }
       
        /*function saveChatToSql(message){
            var time = new Date().toLocaleTimeString('en-US', { hour12: false});
            var dummy_date = new Date();
            var fulldate = dummy_date.getFullYear() +"-" +(dummy_date.getMonth()+1) +"-" + dummy_date.getDate()
            chatWhatever("update_chat_date_time",fulldate,time,chatRoom,message,accno)
        }*/
        $('.send_message').click(function (e) {
            var message_val = $('.message_input').val().trim();
            if(message_val!==""){
                var firebaseRef = firebase.database().ref('/Matches');
                var accno = $("#hidden_accno").val();
                saveChatToSql(getMessageText());
                Chat(chatRoom,getMessageText(),accno,$.now());
                message_side = "right";
                return sendMessage(getMessageText());
            }
            else{
               alert("Please enter a message first!")
            }
        });
        $('.message_input').keyup(function (e) {
            var val = $(this).val();
            if (e.which === 13) {
                if(val.trim()!==""){
                    var firebaseRef = firebase.database().ref('/Matches');
                    var accno = $("#hidden_accno").val();
                    saveChatToSql(getMessageText());
                    Chat(chatRoom,getMessageText(),accno,$.now());
                }
                else{
                    alert("Please enter a message")
                }
            }
            
        });
        
  // Get elements
  const preObjects = document.getElementById('object');
  const headingName = document.getElementById('headingName');
 
  var counter = 0;
  const dbRefObject = firebase.database().ref('/Matches/' + chatRoom);
  const dbRefName = dbRefObject.child("name");
  dbRefObject.on('child_changed', (snap)=>{
        var numChild = snap.numChildren() - 1;
        snap.forEach(function(childSnapShot){
            if(counter===numChild){
                var sender = childSnapShot.child('sender').val();
                var body = childSnapShot.child('body').val();
                //TO DISPLAY CONVERSATION
                if (sender === accno){
                    setTimeout(function () {
                        message_side = "right";
                        return sendMessage(body);
                    });
                }
                else{
                    setTimeout(function () {
                        message_side = "left";
                        return sendMessage(body);
                    });
                }    
            }
            counter++;
        });
        counter = 0;   
  });

  //Sync object changes
         
});

   


}).call(this);

function Chat(chatRoom, body, sender, timestamp) {
  firebase.database().ref('/Matches').child(chatRoom).push({
    body: body,
    sender: sender,
    timestamp : timestamp
  });

}


			