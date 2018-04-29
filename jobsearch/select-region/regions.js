function listRegions(){
	$.ajax({
		url:"/jobsearch/select-region/cities_list.php",
		type:"POST",
		success:function(data){
			var $selector = $("select[name='search_region']");
			var current_page = location.pathname; 
			$selector.html(data);
			$selector.prepend("<option selected disabled hidden>Select Region</option>");
			
			if(current_page == "/jobsearch/job_search.php"){
				$selector.material_select();
			}
		}
	});
}
function listCities(select_index,selector){
	$.ajax({
		url:"/jobsearch/select-region/cities_list.php",
		type:"POST",
		data:{reg_name:select_index,display_select:true},
		success:function(data){
			selector.empty();
			var current_page = location.pathname; 
			
			var cities= JSON.parse(data);
			for(var i = 0;i<cities.length;i++){
				selector.append("<option value'"+cities[i] +"'>" +cities[i] +"</option>")	
			}
			selector.prepend("<option selected disabled hidden>Select City</option>")
			
			if(current_page == "/jobsearch/job_search.php"){
				selector.material_select();
			}
			if(current_page == "/jobsearch/profile/applicant_profile.php"){
				selector.trigger('something');
			}
			
			
		}
	});
}
$(function(){	
	listRegions();
	$(document).on('change',"select[name='search_region']",function(){
		var region = $(this).val();
		var current_page = location.pathname; 
		if(current_page == "/jobsearch/job_search.php"){
			selector = $("select[name='search_city']");
		}
		else{
			selector = $(this).parent().find("select[name='search_city']");
		}
		console.log(selector)

		listCities(region,selector);
	})
	

});