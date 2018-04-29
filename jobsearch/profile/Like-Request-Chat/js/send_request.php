<?php
	require "dbconnect.php"; 
?>
<!DOCTYPE html>
<html>
<head>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>

	<title>Send Request</title>
</head>
<body>
	Name:<input type="text" id="name">
	Requester:
	<select id="requester">
		<optgroup label="Applicant Accno"></optgroup>
		<?php
			$data = mysql_query("select accno from applicant_tbl");
			while($row = mysql_fetch_array($data)){
				print "<option value='".$row['accno']."'>" .$row['accno'] ."</option>";
			}
		?>
		<optgroup label="Employer Accno"></optgroup>
		<?php
			$data = mysql_query("select accno from employer_tbl");
			while($row = mysql_fetch_array($data)){
				print "<option value='".$row['accno']."'>" .$row['accno'] ."</option>";
			}
		?>
	</select>
	Target:
	<select id="target">
		<optgroup label="Applicant Accno"></optgroup>
		<?php
			$data = mysql_query("select accno from applicant_tbl");
			while($row = mysql_fetch_array($data)){
				print "<option value='".$row['accno']."'>" .$row['accno'] ."</option>";
			}
		?>
		<optgroup label="Employer Accno"></optgroup>
		<?php
			$data = mysql_query("select accno from employer_tbl");
			while($row = mysql_fetch_array($data)){
				print "<option value='".$row['accno']."'>" .$row['accno'] ."</option>";
			}
		?>
	</select>
	Is Job
	<input type="checkbox" id="isJob">
	<div class="job" id="job" style="display: none">
		Job Id:
		<input type="text" id="job_input">
	</div>
	<button id="send">Send!</button>

	<script src="https://www.gstatic.com/firebasejs/4.0.0/firebase.js"></script>
	<script src="/jobsearch/profile/Like-Request-Chat/js/app.js"></script>
	<script type="text/javascript">
		$(function(){
			$("#isJob").click(function(){
				if(!$("#isJob").is(":checked")){
					$("#job").hide();
				}
				else{
					$("#job").show();
				}
			})
			$("#send").click(function(){
				var data = {
					name:$("#name").val(),
					requester:$("#requester").val(),
					target:$("#target").val(),
					isJob:$("#isJob").is(":checked"),
					jobId: $("#isJob").is(":checked")? $("#job_input").val() : "",
					sendToServer:true
				}
				$.post("../php-server/request-server.php",data,function(response){
					console.log(data);
					alert(response);	
					if(response==1){
						database.ref("Request-Controller").push({
							byJob:data.isJob,
							type:"Send Job Request."
						})
					}
				})
				
			})
		})
	</script>
</body>
</html>