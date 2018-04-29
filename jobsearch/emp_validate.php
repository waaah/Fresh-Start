<?php
ob_start();
require $_SERVER['DOCUMENT_ROOT'] ."/DBConnectionString/dbconnect_class.php";
if(!isset($_SESSION['unregistered_accno'])){
	header("location:index.php");
}

?>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="">
<meta name="author" content="">
<script src="sweetalert2/sweetalert2.min.js"></script>
<link rel="stylesheet" href="sweetalert2/sweetalert2.min.css">


<script class="jsbin" src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
<script class="jsbin" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.0/jquery-ui.min.js"></script>
<!-- Bootstrap styles -->
<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">

<!-- Uploader -->
<script src="uploader/js/plugins/sortable.js" type="text/javascript"></script>
<script src="uploader/js/fileinput.js" type="text/javascript"></script>
<script src="uploader/js/locales/fr.js" type="text/javascript"></script>
<script src="uploader/js/locales/es.js" type="text/javascript"></script>

<link href="uploader/css/fileinput.css" media="all" rel="stylesheet" type="text/css"/>

<title>Upload DTI or SEC Permit</title>
<style>

*, *:before, *:after {
  -moz-box-sizing: border-box;
  -webkit-box-sizing: border-box;
  box-sizing: border-box;
}

body {
  
  background-image:url('img/back.png');
   	font-family: 'Century Gothic';
    background-size:     cover;                      
    background-repeat:   no-repeat;
    background-position: center center;     
	margin: 0px 0px 0px 0px;
}
@media screen and (max-width: 700px){
	form
	{
		margin: 20px;
		margin-top: 0px;
	}
}
form {
  max-width: 700px;
  margin: 10px auto;
  padding: 10px 20px;
  background: #f4f7f8;
  border-radius: 8px;
}
input, button{
	font-family: 'Century Gothic';
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
.logout{
	padding: 10px 10px 10px 10px;
	margin: 10px 10px 10px 10px;
	font-family: 'Century Gothic';
	text-align:right;


}
.top{
	background-color: #f4f7f8;
	height:7%;
	width:100%;
	margin: 0px 0px 0px 0px;
	box-shadow: 5px;
	padding-left: 90%;
}
.logo{
	background-image: url("img/back.png");
	height:15%;
	width:100%;
	margin: 5px 5px 5px 5px;
	box-shadow: 5px;
	border-radius: 20px;
	
}
a{
	color:white;
	font-weight: bold;
}
a:link {
    text-decoration: none;
    
}

a:visited {
    text-decoration: none;
}

a:hover {
    text-decoration: none;
}

a:active {
    text-decoration: none;
}
nav{
	background: #17BA9E;
	padding:1px;

}
</style>
</head>
<body>
<nav>
	<p class=logout><a href="index.php?logout=true">Logout</a></p>
</nav>
<form action=emp_validate.php method=post enctype="multipart/form-data">
<center>
<div class="logo">
<img src='img/freshstartlogo.png' style='height:100%;'>
</div>
<br><br>
		<h2><b>Last step! Before you can use your account, we need to verify whether you're a valid employer or not.</h2>
		<hr>
		<br><h1>Hello <?php print $_SESSION['unregistered_accno'];?>!</b></h1>

		<br><br>
		<?php
			$db_obj = new DatabaseConnection();
			$db_obj->setQuery("select * from temp_employer_tbl where accno=:accno");
			$parameter = array(':accno' => $_SESSION['unregistered_accno'] );
			$res = $db_obj->executeQuery($parameter,true);
			foreach ($res as $row) {
				if(empty($row['sec'])){
					print '<input id="upload" class="file" type="file">';
				}
				else{
					print "<b style='font-size:15px'>It appears that you have already uploaded your file. File cannot be changed be changed once it is uploaded. If you wish to consult our admin about this, send an email to freshstrt00@gmail.com. If you are satisfied with your file, please wait for a response from our admin in regards in to your request. Thank you and have a nice day</b>";
				}
			}
		?>
		
		<!-- <input type=file name=upload onchange="readURL(this)" id="upload" >-->		
		<br><br><b> Please upload your DTI or SEC Permit and press SUBMIT when done.</b><br> If you have already uploaded a photo, please wait for your account's approval (Usually takes 24 hours) and login again your account.
		<br><br>
		<!-- <button name='submit' class=button id="upload-button" type="button">Upload</button> -->
</center>
<center>
</form>
<?php
$item = "Please Wait for the approval of your request. The maximum response time is 24 hours. An email should be sent to your email address upon response to the request.";
print "<script>swal('Attention','$item','warning');</script>";
?>
</body>
</html>

    <script src="js/bootstrap.min.js"></script>

	<script language=javascript>
	$("#upload").fileinput({
		allowedFileExtensions:["jpg","png","pdf"]
	})
	/*function readURL(input) {
		var fuData = document.getElementById('upload');
        var FileUploadPath = fuData.value;
		var Extension = FileUploadPath.substring(
                    FileUploadPath.lastIndexOf('.') + 1).toLowerCase();
		if(Extension == "gif" || Extension == "png" || Extension == "bmp"
                    || Extension == "jpeg" || Extension == "jpg")
		{
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    //$('#blah').attr('src', e.target.result)
                };

                reader.readAsDataURL(input.files[0]);
            }
 
		}
		else
		{
			alert('upload valid file');
		}
	}*/
	$(".fileinput-upload").click(function(e){
		e.preventDefault();
		var filedata = $("#upload").prop('files')[0];
		var form_data = new FormData();
		var result;
		form_data.append('file',filedata)
		swal({
		    title: "Confirm Submission",
		    text: "Are you sure you want to submit this file? Once submitted, user file cannot be changed. Do you wish to continue?",
		    type: "info",
		    showCancelButton: true,
		    showLoaderOnConfirm: true,
		    preConfirm: function () {
		      return new Promise(function (resolve, reject) {
		        setTimeout(function() {
		           //Start Ajax
					$.ajax({
						url: "emp-validate-ajax.php",
						type: "POST",
						data: form_data,
						cache: false,
		                contentType: false,
		                processData: false,
						success: function (data) {
							result = data;
							resolve();
						}
					});
					//End Ajax
		        }, 2000)
		      })
		    },
		    allowOutsideClick: false
		  }).then(function(){
		  		if(result == "1"){
		  			swal("Success","File has been saved","success").then(function(){
				  		location.reload();
				  	});
		  		}
		  		else{
		  			swal("Error",result,"error");
		  		}
			  	
		  })
		})
	</script>

	
<?php
/*if(isset($_POST['submit']))
{
	if($_FILES['upload']['name'])
	{
		$b = $_SESSION['unregistered_accno'];
		$target_dir = "sec/";
			$imageFileType = pathinfo($_FILES['upload']['name'], PATHINFO_EXTENSION);
			if($imageFileType == "jpg" || $imageFileType == "png" || $imageFileType == "jpeg" || $imageFileType == "gif")
			{
				//to use
				if(!file_exists("sec/".$_FILES["upload"]["name"]))
				{
					if(move_uploaded_file($_FILES['upload']['tmp_name'],"sec/$b".$_FILES["upload"]["name"]))
					{
					$filename = $b . $_FILES["upload"]["name"];
					$query = "UPDATE temp_employer_tbl SET sec='$filename' where accno=$b";
					mysql_query($query);
					print "<script language=javascript>
							swal('Success','File Uploaded! Please Wait for the Confirmation before you can use your account','success');
						
							</script>";
					}
					else
					{
					print "<script language = javascript>
					swal('Error','Upload Unsuccessful','error');
					</script>";
					}
				}
				else
				{
					print "<script language = javascript>
					swal('Sorry','You have uploaded the same type of file','error');
					</script>";
				}
				//not to use
			}
			else
			{
				print "<script language = javascript>
					swal('File is not an image','It must be either jpg,jpeg,png and gif','error');
					</script>";
			}
			
	}
	else
	{
		
		print "<script language = javascript>
				swal('Sorry!','Please Upload your DTI or SEC Permit','error');
			   </script>";
		}	
	}
*/		
?>
			