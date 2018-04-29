
Array.prototype.ifSameValues = function(){
	for(var i = 1; i< this.length;i++)
	{
		if(this[i] !== this[0]){
			return false;
		}
	}
	return true;
}
function autoFill(id,storageName){
	console.log(storageName)
	var availableTags = JSON.parse(localStorage.getItem(storageName));
	$( "#"+id ).autocomplete({
      	source:availableTags,
    });
    $.ui.autocomplete.filter = function (array, term) {
        var matcher = new RegExp("^" + $.ui.autocomplete.escapeRegex(term), "i");
        return $.grep(array, function (value) {
            return matcher.test(value.label || value.value || value);
        });
    };
	$("#"+id).autocomplete('widget').addClass('fixedheight');	
	$("#"+id).removeClass("ui-widget");
}


//================== Filters ======================================= //

function skillsFilter(input){
	filterCheck('skills','skills_list',input);
}
function educationFilter(input){
	filterCheck('education','education_list',input);
}

function filterCheck(storageName,pageName,input){
	var id = input.getAttribute('id');
	var availableTags;
	if(localStorage.getItem(storageName) === null){
		console.log('empty')
		$.post("/jobsearch/rule-based-functions/"+pageName+".php",function(data){
			availableTags = JSON.parse(data);
			localStorage.setItem(storageName,data)
		}).done(function(data){
			autoFill(id,storageName);
		})
	}
	else{
		autoFill(id,storageName);
	}
}

//========================End of Filter============================================



function filter(inputElement,selectElement){
	var th_value = selectElement.value;
	var index = 1;
	if(th_value){
		if(th_value === "Full Name")
			index = 1;
		if(th_value === "Company Name" || th_value === "Job Name")
			index = 2;
	}
	var found_one_element = false;
	var id = inputElement.getAttribute('id');
	var input = document.getElementById(id);
	var filter = input.value.toLowerCase();
	var table_id = document.getElementById(id).parentElement.nextElementSibling.getAttribute('id');
	var table = document.getElementById(table_id);
	var tr = table.getElementsByTagName("tr");
	var col_count = table.querySelector("thead tr").children.length
	var num_found = 0,hidden = false;

	if(!table.querySelector("tbody tr #no_request")){
		for(i=1;i<tr.length;i++){
			var td = tr[i].getElementsByTagName("td")[index];
			if(td){
				if(td.innerHTML.toLowerCase().indexOf(filter) > -1)
				{
					found_one_element = true;
					tr[i].style.display = "";
					num_found +=1;
				}
				else{
					tr[i].style.display = "none";
					hidden = true;
				}
			}
		}
		var none_found = table.querySelector("#none_found");
		if(!found_one_element){
			if(!none_found && hidden){
    			var create_td = document.createElement("td")
    			create_td.appendChild(document.createTextNode("No Results Found"))
    			create_td.setAttribute("id","none_found")
    			create_td.setAttribute("colspan",col_count);
    			table.appendChild(create_td)
			}
		}
		else{
			if(none_found){
				table.removeChild(none_found);
			}
		}
		inputElement.parentElement.previousElementSibling.getElementsByTagName('count')[0].innerHTML = num_found;
	}
}

function button_edit(job_id){
	$.post("profile_import.php?display_what=job",{id:job_id},function(response){
		var data = $.parseJSON(response);
		var count=0;
		$("#jobsModal").find("#edit_saved_jobs").children("input, textarea, select").each(function(){
			$(this).val(data[count]);
			count+=1;									
		});
		var specs = data[6].split(',');
		$("#edit_job_select_spec").each(function() { this.selectedIndex = 0 });
		for(var i=0;i<=specs.length;i++){
			$("#edit_job_select_spec option[value='" + specs[i] + "']").attr("selected", true);
		}
		var requirements = data[7].split(',*');

		$("#requirements_text_fields_edit").empty();
		for(var i=1;i<requirements.length;i++){
			$("#requirements_text_fields_edit").append("<div style='padding-bottom:10px'><div class='left-inner-addon'><i class='glyphicon glyphicon-asterisk'></i><input class='form-control requirements edit' name='edit_requirement' id='edit_requirement'></div></div>");
			$(".form-control.requirements.edit").last().val(requirements[i]);
			
		}
		$("#edit_job_select_spec").selectpicker('refresh')
		$("#jobsModal").modal("show");
		$("#hidden_job_id").val(job_id);
		});
}
function profile_submit(action,myData,frmname)
{
		var tempname = frmname;
		frmname+=" #errors";
		var url = "profile_security.php?action="+action;
		$.post(url,myData,function(response){									
		var error = $.parseJSON(response); 
		window.scrollTo(0,0);
		if(!error.ifSameValues())
		{
			$(frmname).text('');
			for(var i=0;i<error.length;i++)
			{
				if(error[i] != ""){
					$(frmname).eq(i).text(error[i]).css("color", "red");
					$(frmname).eq(i).prev().css({"border":"1px solid red"});							
				}
			}
		}
		else
		{
			$(frmname).text('');
			swal({
				title: "Confirm Submission",
				text: "Are you sure you want to submit",
				type: "info",
				showCancelButton: true,
				closeOnConfirm: false,
				showLoaderOnConfirm: true,
				}).then(function(){
					var url2 = "profile_import.php?action="+action;
					$.post(url2,myData,function(response){})
						.done(function(response){
							sweetAlert({
								title:"Success",
								text: "Data has been saved",
								type:"success"
							}).
							then(function(){
									location.reload();
								});
							})
								
						});
						
		}
		});
		window.scrollTo(0,0);		
}	
function checkifFilled(frmName){
	sweetAlert({
				title:"Error",
				confirmButtonText:'OK',
				text: "Please complete the respective fields",
				type:"error"
				})
				.then(function(){
					$(frmName+" :text,:input[type=number],:input[type=date],textarea,:checkbox").each(function(){
							if($.trim($(this).val()).length == 0){
								window.scrollTo(0,0);
								$(this).css({"border":"1px solid red"});
							}
					});
				});
}
function redRemove(frmName){
	$(frmName+" :input").keyup(function(){
		if($(this).val() != ""){
			$(this).css({ "border": ''});
			$(this).next().text('');
		}							
	});
	
	$('select').change(function(){		
		$(this).css({ "border": ''});									
	});
}
function reloadTop(){
	window.scrollTo(0,0);			
}
function delete_field(selector,id,list_type){
	var successtag ='#success';
	var response = '';
	if(list_type == 'skills'){
		successtag = "#success_skills"
	}
	swal({
			title: "Confirm Submission",
			text: "Are you sure you want to delete this?",
			type: "info",
			showCancelButton: true,
			showLoaderOnConfirm: true,
			allowOutsideClick:false,
			preConfirm:function(){
				return new Promise(function(resolve,reject){
					setTimeout(function(){
						$.post("profile_edit.php?action=delete",{id:id,type_of_field:list_type},function(data){										
							$(selector).empty();
							$(successtag).html('Success! Record has been deleted').removeClass("hide").hide().fadeIn("slow").fadeOut(5000);
							response = 	data;
						}).
						done(function(){
							resolve();
						});
					},1000)
				})
			}
		})
		.then(function(){
			if(parseInt(response)===1){
				swal({
					title: "Success",
					text: "Data has been saved!",
					type: "success",
					allowOutsideClick:false,
				}).then(function(){
					reloadTop();
				})
			}
			else{
				swal({
					title: "Success",
					text: response,
					type: "success",
					allowOutsideClick:false,
				}).then(function(){
					reloadTop();
				})
			}
		});
}
