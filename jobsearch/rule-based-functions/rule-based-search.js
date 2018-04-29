var emptyResult = function(){
	return '<div class="card-panel large item">\
				<center><img src="img/monitor.png" class="empty-image">\
				<h3 class="bolded">Sorry! No more results were found.</h3></center>\
			</div>';
}
//change this according to the relevant and normal
var pagination = function(data = null,$containerClass){
	var self = this;
	if(data != null){
		this.size = data.length;
	}
	else{
		this.size = $containerClass.find(".exact").children().length + $containerClass.find(".relevant").children().length;
	}
	this.item_per_page = 10;
	this.current=1;
	var $paginationClass = $("#pagination");
	this.number_pagination = Math.ceil(this.size/this.item_per_page);
	$paginationClass.html(null);
	$("c#all").text(size);
	if(number_pagination > 0 && size > 0){
		$paginationClass.append("<li class='page-item disabled pagination_prev' disabled><i class='material-icons'>chevron_left</i></li>");
		var active = colorPagination();
		for(var i=1;i<=number_pagination;i++){
			$paginationClass.append("<li class='page-item "+active+"' id="+i+"><a class='page-link' link-pagenize=true>"+i+"</a></li>");
			active = 'waves-effect';
		}
		$paginationClass.append("<li class='page-item waves-effect pagination_next'><i class='material-icons'>chevron_right</i></li>");
	}
	else{
		$paginationClass.empty();
	}
	function hideChildren(){
		$containerClass.find("div.card-panel").each(function(){
			$(this).hide();	
		})
	}
	function colorPagination(){
		var location = window.location.pathname,color;
		if(location == "/jobsearch/job_search.php")
			color = 'active teal';
		else if(location == "/jobsearch/applicant_search.php")
			color = 'active blue';
		return color;
	}
	function movePagination(nextCurrentValue){
		$("#pagination #"+current).removeClass(colorPagination()).addClass('waves-effect');
		current = nextCurrentValue;
		$("#pagination #"+current).removeClass('waves-effect').addClass(colorPagination);
		hideChildren();
		//change this if items are 10 and above.
		if(current == number_pagination){
			$("li.pagination_next").removeClass('waves-effect');
			$("li.pagination_prev").addClass('waves-effect');
		}
		if(current == 1){
			$("li.pagination_prev").removeClass('waves-effect');
			$("li.pagination_next").addClass('waves-effect');
			$(name+" .exact .exact-label").show();
		}
		else{
			$(name+" .exact .exact-label").hide();
		}
		start = (current - 1) * 10;
		end = current * 10;
		$containerClass.find("div.card-panel").slice(start,end).show();
	}
	hideChildren();
	var start = 0,end = item_per_page;
	$containerClass.find("div.card-panel").slice(start,end).show();
	//when a div with class pagination next is clicked the items will move on to the next item
	$(".pagination_next").click(function(){
		if(current < number_pagination){
			var next_item = current + 1;
			movePagination(next_item);			
			$("li.pagination_prev").addClass('waves-effect');
		}		
	})
	$(".pagination_prev").click(function(){
		if(current > 1){
			var prev_item = current - 1;
			movePagination(prev_item);
			$("li.pagination_next").addClass('waves-effect');
		}
	})
	$("a.page-link").click(function(){
		var item_chosen = parseInt($(this).parent().attr("id"));
		movePagination(item_chosen);
	})
}
$(function(){
	function fillFields(data){
		function checkArray(data){
			try{
				//console.log(data);
				data = JSON.parse(data);
				
			}
			catch(e){
				data = null
			}
			finally{
				return data;	
			}
		}
		function container(){
			var $containerClass;
			var location = window.location.pathname;
			if(location == "/jobsearch/job_search.php"){
				$containerClass = $("#job-container");

			}
			else if(location == "/jobsearch/applicant_search.php"){
				$containerClass = $("#applicant-container");
			}
			return $containerClass;
		}
		data = checkArray(data);
		var first = true;
		if(data!=null){
			var $containerClass = container();
			if(isCompanySearch)
				$template = $("#company-template").template();
			else
				$template = $("#template").template();
			$containerClass.html(null);
			if(data.length == 0){
				$containerClass.append(emptyResult())
			}
			else{
				var name = "#"+$containerClass.attr("id");
				$(".empty-container").children().clone().appendTo($containerClass).show();
				
				data.forEach(function(sub_data){
					switch(sub_data.degreeOfMismatch){
						case 0:
							sub_data.resultType = "Exact Match";
							$.tmpl($template,sub_data).appendTo($(name+" .exact"));
							break;
						case 1:
							sub_data.resultType = "Relevant Result";
							$.tmpl($template,sub_data).appendTo($(name+" .relevant"));
							break;
						default:
							$.tmpl($template,sub_data).appendTo($(name+" .exact"));
							$("#card-"+sub_data.accno+" .exact-label").remove();
							break;
					}
					
				})
			}
			pagination(data,$containerClass);	
		}
		
	}
	var isCompanySearch = false;
	var indexToModify = null;
	var started = false;
	var experiencePointer=null;
	searchwithRule();
	var values = [];
	function searchwithRule(){
		started=true;
		var start_time = new Date().getTime();
		var array;
		var pagetype= window.location.pathname;
		swal({
			allowOutsideClick:false,
			showConfirmButton:false,
		});
		swal.showLoading();
		$.ajax({
			url:"/jobsearch/rule-based-functions/rules_engine.php",
			method:"POST",
			data: {values:values,type:pagetype,isCompanySearch:isCompanySearch},
			success: function(data){
				//console.log(data)
				fillFields(data);				
			}
			
		}).then(function(){
			swal.close();
			setTimeout(function(){
				$("#params_modal").modal('close');	
			},900)
			
		});
	}
	
	values.findIndex = function(field){
		var found = -1;
		for(var i = 0;i<values.length;i++){
			if(values[i][0]===field){
				found = i;
				break;
			}					
		}
		return found;
	}
	values.modifyArray = function(elementVal,field,indexToModify){
		var row = values.findIndex(field);
		if(indexToModify==null){		
			if(row===-1){
				values.push([field,elementVal])	
			}
			else{
				values[row][1] = elementVal;
			}
		}
		else if(typeof indexToModify === "number"){
			values[indexToModify][0] = field;
			values[indexToModify][1] = elementVal;
		}
		searchwithRule()
		indexToModify = null;
		//console.log(values);
		
	}

	values.deleteRow = function(index){
		var rowToSplice = values.findIndex(index);
		if(rowToSplice > -1){
			//console.log(values)
			values.splice(rowToSplice, 1);
		}
		searchwithRule();
	}

	var citySearched = null;
	$(document).on('change',"#search_region",function(){
		values.modifyArray($(this).val(),"region")
		values.deleteRow("city")

	})
		
	$(document).on('change',"#search_city",function(){
		if($(this).val() != null){
			values.modifyArray($(this).val(),"city")
		}
	})

	$(document).on('change',"#rating",function(){
		values.modifyArray($(this).val(),"rating")
	})
	$(document).on('change',"#list_of_specializations",function(){
		values.modifyArray($(this).val(),"specialization")
	})
	$(document).on('change',"#employ-type",function(){
		values.modifyArray($(this).val(),"employment")
	})
	$(document).on('click',"#filter-salary-job",function(){
		values.modifyArray($("#salary_range").val(),"salary");	
	})
	
	$(document).on('click',"#filter-btn",function(){
		var search_val = $("#search").val();
		var option = $("#search-select").val();
		if((search_val!=="" && option !== null)){
			values.modifyArray($("#search").val().trim(),$("#search-select").val(),indexToModify);
			indexToModify = values.findIndex($("#search-select").val()); 	
		}
		else{
			swal("Error","Cannot Search. Please fill up the fields properly","error");
		}
		
	})
	$(document).on('click',"#reset-filter-btn",function(){
		swal({
			title:"Confirmation",
			text:"Are you sure you want to reset your additional parameters?",
			type:"warning",
			showCancelButton:true
		}).then(function(){
			if(!isCompanySearch){
				var previousVal = $("#search-select").val();
				$("#search-select").val("default");
				$("#search-select").material_select();
				$("#search").val(null);
				values.deleteRow(previousVal);
			}
			else{
				$("#company-search").val(null);
				values.deleteRow("company_name");
			}
		})
		
	})
	
	$(document).on('click',"#clear_filters",function(){
		values.splice(0,7);
		$("select").val(0);
		$("#search_city option").not(":first").remove();
		$("input").not(":disabled").val(null)
		$("select").material_select();
		searchwithRule();
		
	})
	$(document).on('change',"#quali-obtained",function(){
		values.modifyArray($(this).val(),"qualification");
	})
	$(document).on('change',"#field-study",function(){
		values.modifyArray($(this).val(),"field-study");
	})
	$(document).on('click',"#filter-salary-app",function(){
		values.modifyArray($("#salary_range_app").val(),"app-salary");	
	})
	$(document).on('keyup change',"#skills",function(){
		if($(this).val().trim() !== '')
			values.modifyArray($(this).val(),"skills");
		else
			values.deleteRow('skills');
	})
	$(document).on('click',".exp-radio",function(){
		$("#search-select").val('univ_name');
		if($(".exp-radio:checked").attr("is_experienced")==="true"){							
			$("#search-select option[value='worked_at']").attr("disabled",false);
			$("#search-select option[value='pos_title']").attr("disabled",false);
			$("#search-select option[value='role']").attr("disabled",false);
			values.modifyArray("true","with-exp");
		}
		else{
			$("#search-select option[value='worked_at']").attr("disabled",true);
			$("#search-select option[value='pos_title']").attr("disabled",true);
			$("#search-select option[value='role']").attr("disabled",true);
			values.modifyArray("false","with-exp")
		}
	});
	$(".switch").find("input[type='checkbox']").on('click',function(e){
		var checkbox = $(this);
		var isChecked = checkbox.prop("checked");
		checkbox.prop("checked",!isChecked);
		swal({
			type:"question",
			title:"Change Search Type",
			text: isChecked? "Do you want to search for companies instead of jobs?" : "Do you want to revert back to searching jobs?",
			showCancelButton:true,
			showLoaderOnConfirm:true,
			allowOutsideClick:false,
			preConfirm:function(){
				return new Promise(function(resolve,reject){
					checkbox.prop("checked",isChecked);
					isCompanySearch = isChecked;
					values.splice(0,10);
					//commence search once values are changed.
					searchwithRule();
					//parameters are initialized.
					reinitializeParameters();
					//change company textboxes
					changeJobSearchFilters();
					//resolve search completely
					resolve();
					values.splice(0,7);
				})
			}
		}).then(function(){
		}).catch(swal.noop);
	});
	$(document).on("click","#company-filter-btn",function(){
		var toSearch = $("#company-search").val();
		
		if(toSearch != null){
			values.modifyArray(toSearch,"company_name");
			//console.log(toSearch);
			$("#company-search").val(toSearch);
		}
		else{
			swal("Sorry!","We cannot process your search. Please enter a value in the textbox","error");
		}
	})
	//this entire part is for the resizing of the window
	function screenResolution(){
		var width = $(this).width();
		var script = !isCompanySearch ? $("#search-params-template").text():$("#company-search-params-template").text();
		$("#params_modal").modal('close')
		if(width <= 992){
			$("#modal-content").html(script);
			$("#card-content").empty();
		}
		else{
			$("#modal-content").empty();
			$("#card-content").html(script);
		}
		if(!isCompanySearch){
			initilizeSlider();
		}
		$('select').material_select();
	}
	function initilizeSlider(){
		var slider = document.getElementById('slider');
		noUiSlider.create(slider, {
			start: 0,
			connect: true,
			range: {
				'min': 0,
				'max': 200000
			}
		});
		var stepSliderValueElement; 
		if(location.pathname =="/jobsearch/job_search.php"){
			stepSliderValueElement= document.getElementById('salary_range');
		}
		else{
			stepSliderValueElement= document.getElementById('salary_range_app');
		}
		slider.noUiSlider.on('update', function( values, handle ) {
			stepSliderValueElement.value = values[handle];
		});

		function setSliderHandle(i, value) {
			var r = [null,null];
			r[i] = value;
			slider.noUiSlider.set(r);
		}
		var inputs = [stepSliderValueElement];
		// Listen to keydown events on the input field.
		inputs.forEach(function(input, handle) {

			input.addEventListener('change', function(){
				setSliderHandle(handle, this.value);
			});

			input.addEventListener('keydown', function( e ) {

				var values = slider.noUiSlider.get();
				var value = Number(values[handle]);

				// [[handle0_down, handle0_up], [handle1_down, handle1_up]]
				var steps = slider.noUiSlider.steps();

				// [down, up]
				var step = steps[handle];

				var position;

				// 13 is enter,
				// 38 is key up,
				// 40 is key down.
				switch ( e.which ) {

					case 13:
						setSliderHandle(handle, this.value);
						break;

					case 38:

						// Get step to go increase slider value (up)
						position = step[1];

						// false = no step is set
						if ( position === false ) {
							position = 1;
						}

						// null = edge of slider
						if ( position !== null ) {
							setSliderHandle(handle, value + position);
						}

						break;

					case 40:

						position = step[0];

						if ( position === false ) {
							position = 1;
						}

						if ( position !== null ) {
							setSliderHandle(handle, value - position);
						}

						break;
				}
			});
		});
	}
	function reinitializeParameters(){
		screenResolution();
		listRegions();
	}
	function changeJobSearchFilters(){
		var filter = $(".search-field-with-select");
		filter.html(null);
		if(isCompanySearch){
			filter.html($("#company-extra-params").text());
		}	
		else{
			filter.html($("#job-extra-params").text());
		}
		$("select").material_select();
	}
	screenResolution();
	$(window).resize(function(){
		reinitializeParameters();
	})
	
	
})
//sorts the array according to 

