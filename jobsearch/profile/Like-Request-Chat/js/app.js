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


