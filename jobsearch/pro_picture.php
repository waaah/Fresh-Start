<?php
ob_start();
session_start();
include("dbconnect.php");
if(!isset($_SESSION['signup_accno'])&&!isset($_SESSION['action'])){
	header("location:index.php");
}
?>
<html lang="en">
<head>
  <title>Upload Your Profile Picture</title>
  <link rel="shortcut icon" href="img/profile.png">

  <script src="http://demo.itsolutionstuff.com/plugin/jquery.js"></script>
  <script src="http://demo.itsolutionstuff.com/plugin/croppie.js"></script>
  <link rel="stylesheet" href="http://demo.itsolutionstuff.com/plugin/bootstrap-3.min.css">
  <link rel="stylesheet" href="http://demo.itsolutionstuff.com/plugin/croppie.css">
  <script src="sweetalert2/sweetalert2.min.js"></script>
	<link rel="stylesheet" href="sweetalert2/sweetalert2.min.css">
</head>
<body>
<style>

body {
    background-image:    url(back3.png);
    background-size:     cover;                      
    background-repeat:   no-repeat;
    background-position: center center;     
	margin-top: 5%;
}
*, *:before, *:after {
  -moz-box-sizing: border-box;
  -webkit-box-sizing: border-box;
  box-sizing: border-box;
}

body {
  font-family: 'Nunito', sans-serif;
  color: #384047;
}
form {
  max-width: 70%;
  margin: 10px auto;
  padding: 10px 20px;
  background: #f4f7f8;
  border-radius: 8px;
}

fieldset {
  border: none;
}

legend {
  font-size: 1.4em;
  margin-bottom: 10px;
}
.number {
  background-color: #5fcf80;
  color: #fff;
  height: 30px;
  width: 30px;
  display: inline-block;
  font-size: 0.8em;
  margin-right: 4px;
  line-height: 30px;
  text-align: center;
  text-shadow: 0 1px 0 rgba(255,255,255,0.2);
  border-radius: 100%;
}
.button {
    background-color: #4CAF50; /* Green */
    border: none;
    color: white;
    padding: 15px 32px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 16px;
}
</style>
<center>
	<fieldset>
		<div class="container">
			<div class="panel panel-default">
			  <div class="panel-heading"><legend><h2><span class="number" style='margin-bottom:15px'>!</span>Upload User Profile Pic</h2></legend></div>
			  <div class="panel-body">

				<div class="row">
					<center>
						<br><font size=9>Hello! <?php print $_SESSION['name']; ?></font>
						<br><font size=5 color="red">(Please Proceed on uploading an image)</font>
					</center>
					<hr>
					<div class="col-md-4 text-center">
						<div id="upload-demo" style="width:350px"></div>
					</div>
					<div class="col-md-4" style="padding-top:30px;">
						<strong>Select Image:</strong>
						<br/>
						<input type="file" id="upload">
						<br/>
						<button class="btn btn-success upload-result" id="save-profile" disabled>Upload Image</button>
					</div>
					<div class="col-md-4" style="">
						<div id="upload-demo-i" style="background:#e1e1e1;width:300px;padding:30px;height:300px;margin-top:30px"></div>
					</div>

			  </div>
			</div>
		</div>
	</fieldset>

<script>
$uploadCrop = $('#upload-demo').croppie({
    enableExif: true,
    viewport: {
        width: 200,
        height: 200,
        type: 'circle'
    },
    boundary: {
        width: 300,
        height: 300
    }
});

$('#upload').on('change', function (e) {
	var FileUploadPath = $('#upload').val();	
	
	var Extension = FileUploadPath.substring(
                    FileUploadPath.lastIndexOf('.') + 1).toLowerCase();
	if(Extension == "gif" || Extension == "png" || Extension == "bmp"
                    || Extension == "jpeg" || Extension == "jpg")
	{
			$( "#save-profile" ).prop( "disabled", false );
            var reader = new FileReader();
			reader.onload = function (e) {
				$uploadCrop.croppie('bind', {
					url: e.target.result
					
				})
    	
			}
			reader.readAsDataURL(this.files[0]);    
        
        
	}
	else
	{
		alert('upload valid file');
	}
					    
});



$('.upload-result').on('click', function (ev) {
	$uploadCrop.croppie('result', {
		type: 'canvas',
		size: 'viewport'
	}).then(function (resp) {
		
		html = '<img src="' + resp + '" />';
		$("#upload-demo-i").html(html);
		
		$.ajax({
			url: "profile/ajaxpro.php",
			type: "POST",
			data: {"image":resp, "usertype":"<?php print $_SESSION["type"]; ?>","id":"<?php print $_SESSION['signup_accno']; ?>"},
			success: function (data) {
				var imageUrl = "profile/upload/"+data;
				
				sweetAlert({
							title:"Success",
							confirmButtonText:'OK',
							text: "Image has been saved",
							type:"success"
							})
							.then(function(){
								$uploadCrop.croppie('bind', {
									url: ''
								});
								
								<?php
									session_unset();
									session_destroy();
								?>
								window.location.href = 'pro_pic.php';
							});
			}
		});
	});
});
</script>