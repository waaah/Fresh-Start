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
$uploadProfilePic = $('#upload-company-logo').croppie({
    enableExif: true,
    viewport: {
        width: 200,
        height: 100,
        type: 'square'
    },
    boundary: {
        width: 300,
        height: 300
    }
});

// for profile images
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
		swal({
		    title: "Confirm Submission",
		    text: "Are you sure you want to save this photo as your profile picture?",
		    type: "info",
		    showCancelButton: true,
		    showLoaderOnConfirm: true,
		    preConfirm: function () {
		      return new Promise(function (resolve, reject) {
		        setTimeout(function() {
		           //Start Ajax
					$.ajax({
						url: "ajaxpro.php",
						type: "POST",
						data: {"image":resp},
						success: function (data) {
							var imageUrl = "upload/"+data;
							$("#my-image").attr("src",imageUrl);
							$("#my-image2").attr("src",imageUrl);
							/*firebase.database().ref("/Image-Controller/").push({
								attempt:1;
							})*/
							//communicate to firebase for any changes in image
							resolve();
						}
					});
					//End Ajax
		        }, 2000)
		      })
		    },
		    allowOutsideClick: false
		  }).then(function(){
		  	swal("Success","Image has been saved","success");
		  })
		
	});
});
//end of profile images

$('#upload-company-logo-btn').on('change', function (e) {
	var FileUploadPath = $('#upload-company-logo-btn').val();	
	
	var Extension = FileUploadPath.substring(
                    FileUploadPath.lastIndexOf('.') + 1).toLowerCase();
	if(Extension == "gif" || Extension == "png" || Extension == "bmp"
                    || Extension == "jpeg" || Extension == "jpg")
	{
			$( "#save-company-logo" ).prop( "disabled", false );
            var reader = new FileReader();
			reader.onload = function (e) {
				$uploadProfilePic.croppie('bind', {
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

$('.upload-logo').on('click', function (ev) {
	$uploadProfilePic.croppie('result', {
		type: 'canvas',
		size: 'viewport'
	}).then(function (resp) {
		swal({
		    title: "Confirm Submission",
		    text: "Are you sure you want to submit this picture as your company logo?",
		    type: "info",
		    showCancelButton: true,
		    showLoaderOnConfirm: true,
		    preConfirm: function () {
		      return new Promise(function (resolve, reject) {
		        setTimeout(function() {
		           //Start Ajax
					$.ajax({
						url: "ajaxlogo.php",
						type: "POST",
						data: {"image":resp},
						success: function (data) {
							var imageUrl = "/jobsearch/profile/company-logo/"+data;
							$("#company-logo").attr("src",imageUrl);							
							resolve();
						}
					});
					//End Ajax
		        }, 2000)
		      })
		    },
		    allowOutsideClick: false
		  }).then(function(){
		  	swal("Success","Image has been saved","success");
		  })
		
	});
});