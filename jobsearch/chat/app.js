try{
    const config = {
      apiKey: "AIzaSyCTYC_jkOEQOpAz5_FIn42C10T9MrSDOz0",
      authDomain: " jobfinder-859ba.firebaseapp.com",
      databaseURL: "https://jobfinder-859ba.firebaseio.com/",
      storageBucket: "gs://jobfinder-859ba.appspot.com",
      messagingSenderId: "891080207303",
    };
    firebase.initializeApp(config);
    var database = firebase.database();
  }
catch(err){
  alert(err)
}
function chatObject{
  this.displayChatList = function(){
    return "chat list displayed";
  }
}

var chatList = new chatObject();
console.log(chatObject);

  //Not necessary script
  /*// Get elements
  const preObjects = document.getElementById('object');
  const headingName = document.getElementById('headingName');
  const here = document.getElementsByClassName('here');
  const preview = document.getElementById('preview');
  const accno = document.getElementById('accno');





  //Create references
  var anak = 'instance4';
  const dbRefObject = firebase.database().ref('/Matches/' + anak);
  const dbRefName = dbRefObject.child("name");
  //const dbRefPrev = dbRefObject.child('body');



  //Sync object changes
  dbRefObject.on('child_added', snap => {
    var sender = snap.child('sender').val();
    var body = snap.child('body').val();

    //$('.here').append("<center>" + body + "<br>");
     

    if (sender !== accno){
     $('.here').append("<center>"+sender + ": " + body + "<br>");
    }else{
    $('.here').append("<center>YOU:" + ": " + body + "<br>");
    }
    
    //preObjects.innerText = body;
    //JSON.stringify(snap.val(), null, 3);

  });
 /* dbRefName.on('value', snap => {
  headingName[0].innerText = snap.val();
  headingName[1].innerText = snap.val();
});
// Sync list changes
*/

}());
