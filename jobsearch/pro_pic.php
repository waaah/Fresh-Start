<?php
session_start();
if(!isset($_SESSION['action']))
{
	header('location:index.php');
}
?>
<html>
<script src="sweetalert-master/dist/sweetalert.min.js"></script>
<link rel="stylesheet" href="sweetalert-master/dist/sweetalert.css">
<link class="jsbin" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1/themes/base/jquery-ui.css" rel="stylesheet" type="text/css" />
<script class="jsbin" src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
<script class="jsbin" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.0/jquery-ui.min.js"></script>
<title>Choose Profile Picture</title>
<style>
img {
    border-radius: 50%;
}
body {
    background-image:    url(back3.jpg);
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
<form action=pro_pic.php method=post enctype="multipart/form-data">
<center>
	<fieldset>
		<legend><h2><span class="number" style='margin-bottom:15px'>!</span>Upload User Profile Pic</h2></legend>
		<br><font size=15>Hello! <?php print $_SESSION['name']; ?></font>
		<br><br><input type=file name=upload onchange="readURL(this)" id=upload >
		<br><br><b> Please upload a file and press OK when done (Note:You can press OK even without uploading a file).
		<br><br><input type=submit name='submit' class=button>
	</fieldset>
</center>
</form>
</html>
<!-- jQuery -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

    <!-- Morris Charts JavaScript -->
    <script src="js/plugins/morris/raphael.min.js"></script>
    <script src="js/plugins/morris/morris.min.js"></script>
    <script src="js/plugins/morris/morris-data.js"></script>
	<script language=javascript>
	function readURL(input) {
		var fuData = document.getElementById('upload');
        var FileUploadPath = fuData.value;
		var Extension = FileUploadPath.substring(
                    FileUploadPath.lastIndexOf('.') + 1).toLowerCase();
		if(Extension == "gif" || Extension == "png" || Extension == "bmp"
                    || Extension == "jpeg" || Extension == "jpg" || Extension == "pdf")
		{
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#blah')
                        .attr('src', e.target.result)
                };

                reader.readAsDataURL(input.files[0]);
            }
        
		}
		else
		{
			swal("Error!",'Please upload a valid picture or pdf file of your DTI Form. Otherwise, your request will not be accepted!',"Error!");
		}
	}
	</script>
<?php
include('dbconnect.php');
if(isset($_POST['submit']))
{
	if($_FILES['upload']['name'])
	{
		$a = $_SESSION['type'];
		$b = $_SESSION['accno'];
		mkdir("uploads/$a/$b"); 
			if($a=='company')
			{
				$table='company_tbl'; 
			}
			else if($a=='applicant')
			{
				$table='emp_tbl';
			}
			$imageFileType = pathinfo($_FILES['upload']['name'], PATHINFO_EXTENSION);
			if($imageFileType == "jpg" || $imageFileType == "png" || $imageFileType == "jpeg" || $imageFileType == "gif")
			{
				if(!file_exists("profile/upload/".$_FILES["upload"]["name"]))
				{
					if(move_uploaded_file($_FILES['upload']['tmp_name'],"uploads/$a/$b" ."/".$_FILES["upload"]["name"]))
					{
					$filename =$_FILES["upload"]["name"];
					$query = "UPDATE $table SET pic='$filename' where accno=$b";
					mysql_query($query);
					print "<script language=javascript>
							document.getElementById('blah').src='uploads/$a/$b/$filename';
							sweetAlert({
								title: 'Registration Complete',
								text: 'Press Ok to go back to main page',
								type: 'success'
								},
						function () {
									window.location.href = 'index.php?logout=true';
										});
							</script>";
					}
					else
					{
					print "<script language = javascript>
					sweetAlert('Error','Upload Unsuccessful','error');
					</script>";
					}
				}
				else
				{
					print "<script language = javascript>
					sweetAlert('Sorry','You have uploaded the same type of file','error');
					</script>";
				}
				
			}
			else
			{
				print "<script language = javascript>
					sweetAlert('File is not an image','It must be either jpg,jpeg,png and gif','error');
					</script>";
			}
			
	}
	else
	{
		$a = $_SESSION['type'];
		$b = $_SESSION['accno'];
		if($a=='company')
		{
			$table='employer_tbl'; 
		}
		else if($a=='applicant')
		{
			$table='applicant_tbl';
		}
		$query = "UPDATE $table SET pic='default.jpg' where accno=$b";
		mysql_query($query);
		copy('default.jpg', ".../default.jpg");
		print "<script language = javascript>
				sweetAlert({
								title: 'Registration Complete',
								text: 'Press Ok to go back to main page',
								type: 'success'
								}).then(
						function () {
								window.location.href = 'index.php?logout=true';
								});
			   </script>";
		}	
		session_unset();
		session_destroy();
	}
		
?>
			