<?php
require $_SERVER['DOCUMENT_ROOT'] ."/DBConnectionString/dbconnect_class.php";
if(!isset($_SESSION['accno'])){
	header("Refresh:0;/jobsearch/");
}
?>
<!DOCTYPE html>
<html>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Introduction</title>
	<script
	  src="https://code.jquery.com/jquery-3.2.1.min.js"
	  integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4="
	  crossorigin="anonymous"></script>
	<link rel="stylesheet" type="text/css" href="css/loader.css">
	<style type="text/css">
		@import url('https://fonts.googleapis.com/css?family=Roboto');
		@import url('https://fonts.googleapis.com/css?family=Open+Sans');
		html{
		  background: url(bg.jpg) no-repeat center center fixed;
		  background-size: cover;
		  -webkit-background-size: cover;
		  -moz-background-size: cover;
		  -o-background-size: cover;
		  background-size: cover;
		}
		body{
			overflow-y: none;
		}
		.intro{
			margin:30px;
			font-family: 'Open Sans', sans-serif;
			color: white;
			text-shadow:
		       3px 3px 0 #000,
		     -1px -1px 0 #000,  
		      1px -1px 0 #000,
		      -1px 1px 0 #000,
		       1px 1px 0 #000;
		}
		.main >  h1{
			font-size: 3.5em;
		}
		.main p{
			font-size: 1.8em;
		}
		.button {
		  border: none;
		  padding:15px;
		  font-size: 16px;
		  color: white;
		  background: #179b77;
		  -webkit-transition: all 0.2s ease;
		  -moz-transition: all 0.2s ease;
		  -o-transition: all 0.2s ease;
		  transition: all 0.2s ease;
		}
		.ripple{position:relative;overflow:hidden;transform:translate3d(0,0,0)}.ripple:after{content:"";display:block;position:absolute;width:100%;height:100%;top:0;left:0;pointer-events:none;background-image:radial-gradient(circle,#000 10%,transparent 10.01%);background-repeat:no-repeat;background-position:50%;transform:scale(10,10);opacity:0;transition:transform .5s,opacity 1s}.ripple:active:after{transform:scale(0,0);opacity:.2;transition:0s}

		.button.btn-large{
			width: 150px;
			font-size: 1.9em;
		}
		
		@media screen and (max-width: 671px){
			.main{
				text-align: center;
			}
			.main > h1{
				font-size: 3.3em;
			}
			.main > p{
				font-size: 1.7em;
			}
			.button.btn-large{
				display: block;
				width: 100%;
				margin-bottom:10px; 
			}
		}
		.bottom{
		  text-align: right;
		  margin-top: 20px;
		}
		footer.copyright{
			position: absolute;
			bottom: 0;
			margin-bottom: 20px;

		}
		@media screen and (max-width: 476px){
			.main > h1{
				font-size: 3.1em;
			}
			.main > p{
				font-size: 1.5em;
			}
		}
		/*.intro .text{
			-webkit-transform: translateY(130%);
			transform: translateY(130%);
			-webkit-transition-timing-function: ease-in;
			transition-timing-function: ease-in;
			-webkit-transition: 0.2s;
			transition: 0.2s;
		}*/
		.fadeOut{
			transition: all ease-out .5s;
			opacity: 0;
		}
		.pageLoader{
			text-align: center;
			background-color: white;
			position: fixed;
			width: 100%;
			height: 100%; 
			top:0;
			left: 0;
			right: 0;
			z-index: 999;
			overflow-y: none;
		}
		.top-navbar{
			background: #179B77;
			top: 0;
			height: 80px;
			position: fixed;
			top: 0;
			left: 0;
			right: 0;
			display: block;
		}
		.top-navbar > ul{
			display: inline-block;
			list-style: none;

		}
		.logo{
			height: 80px;
			display: inline;
		}
		.main{
			margin-top: 130px;
		}
		/* loader */	
		.spinner {
		  margin: 100px auto;
		  width: 50px;
		  height: 40px;
		  text-align: center;
		  font-size: 10px;
		}

		.spinner > div {
		  background-color: #333;
		  height: 100%;
		  width: 6px;
		  display: inline-block;
		  
		  -webkit-animation: sk-stretchdelay 1.2s infinite ease-in-out;
		  animation: sk-stretchdelay 1.2s infinite ease-in-out;
		}

		.spinner .rect2 {
		  -webkit-animation-delay: -1.1s;
		  animation-delay: -1.1s;
		}

		.spinner .rect3 {
		  -webkit-animation-delay: -1.0s;
		  animation-delay: -1.0s;
		}

		.spinner .rect4 {
		  -webkit-animation-delay: -0.9s;
		  animation-delay: -0.9s;
		}

		.spinner .rect5 {
		  -webkit-animation-delay: -0.8s;
		  animation-delay: -0.8s;
		}

		@-webkit-keyframes sk-stretchdelay {
		  0%, 40%, 100% { -webkit-transform: scaleY(0.4) }  
		  20% { -webkit-transform: scaleY(1.0) }
		}

		@keyframes sk-stretchdelay {
		  0%, 40%, 100% { 
		    transform: scaleY(0.4);
		    -webkit-transform: scaleY(0.4);
		  }  20% { 
		    transform: scaleY(1.0);
		    -webkit-transform: scaleY(1.0);
		  }
		}
	</style>
</head>
<body>
	<section class="pageLoader">
		<div class="cssload-loader">		 
			Loading...
		</div>
	</section> 
	<div class="top-navbar">
		<img src="freshstartlogo.png" class="logo">
		<ul class="options">
			<li class="background"></li>
		</ul>
	</div>
	<section class="intro div-slidable">
		<div class="main">
			<h1>Welcome to the Fresh Start Job Finding System!</h1>
			<p>Hello User, this is probably your first time for using this system. So let us take you to a quick tour of our system.</p>
			<p>Press [OK>>], if you wish to be informed of our systems functionalities, otherwise press [Skip>>] to proceed to your user profile.</p>
			<div class="bottom">
				<button class="button btn-large ripple" id="toInstruction" name="toInstruction">OK</button>
				<button id="toProfile" type="button" class="button btn-large ripple" name="toProfile">Skip</button>
			</div>
		</div>
	</section>
</body>
<script type="text/javascript">
	window.onload = function(){
		var loader = document.getElementsByClassName('pageLoader')[0];
		setTimeout(function(){
			loader.style.display = "none";
		},2000)
	}
	
	$(function(){
		$('#toProfile').click(function(){
			$.post("server-side-communication/intro-server.php",{toProfile:true},function(response){
				location.href = "/jobsearch/profile/"+response;
			})

		})
		$('#toInstruction').click(function(){
			$.post("server-side-communication/intro-server.php",{toInstruction:true},function(response){
				location.href = "/jobsearch/help/faq-template/"+response;
			})
				
		})
	})
</script>
</html>