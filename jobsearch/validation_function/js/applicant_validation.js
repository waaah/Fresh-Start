
function calcAge(dateString) {
  var birthday = new Date(dateString);
  var ageDifMs = Date.now() - birthday.getTime();
  var ageDate = new Date(ageDifMs); // miliseconds from epoch
  return Math.abs(ageDate.getFullYear() - 1970);
}

var resp;
function swalSave(link,myData){
  swal({
      title: "Confirm Submission",
      text: "Are you sure you want to submit?",
      type: "info",
      showCancelButton: true,
      showLoaderOnConfirm: true,
      preConfirm: function () {
        return new Promise(function (resolve, reject) {
          setTimeout(function() {
             $.post(link,myData,function(response){
                resp = response;
             })
            .done(function(response) {
              resolve();
            })
            .fail(function(xhr, status, error) {
                swal("Error","An error has occured while processing data","error")
            });
          }, 2000);
        })
      },
      allowOutsideClick: false
    }).then(function(response){
      if(resp==="Data has been saved!"){
        swal({
              title:"Success",
              text:resp,
              type:"success",
              allowOutsideClick: false
            })
            .then(function(){
              location.reload();
              window.scrollTo(0,0);
        }); 
      }
      else{
        swal({
              title:"Error",
              text:"Sorry an error occured! In order to avoid any mishap please avoid using single and double quotes"+resp,
              type:"error",
              allowOutsideClick: false
            })
            .then(function(){
              location.reload();
              console.log(resp);
              window.scrollTo(0,0);
        });
      }
    });

}
$(function() {
  $("input[name='cnum'], input[name='pnum'], input[name='company_num'], input[name='home_num'], input[name='phone_number'], input[name='min_salary_range'], input[name='max_salary_range']").on('keypress',function(e){
    name = $(this).attr("name")
    if( (e.which > 47 && e.which < 58) || e.which == 9){
      return true;
    }
    else{
      if(name === 'cnum'){
        return false;
      }
      else{
        if(e.which == 45)
          return true;
        else
          return false;
      }
    }
  })

  $("input[type='number']").on('keypress',function(e){
      if(e.which == 9){
        return false;
      }
  });
  $.validator.addMethod("greaterThanZero",function(value,element){
    value = parseInt(value)
    if(value > 0){
      return true;
    }
    else{
      return false;
    }

  }, "Value entered must be greater than zero")
  jQuery.validator.addMethod("telNumberValidation",function(value,element,argument){
      var format = /^[0-9]{3}-?[0-9]{2}-?[0-9]{2}$/.test(value);
      if(format || value == ""){
        if(value.length == 7){
          var val_to_string = value.toString();
          var first_index = val_to_string.substring(0,3);
          var second_index = val_to_string.substring(3,5);
          var last_index = val_to_string.substring(5,7);
          $(argument).val(first_index +"-" +second_index +"-" +last_index);
        }
        return true;
      }
      else{
        return false;
      }
  },"Must be a 7-number combination or formatted in ###-##-##")
  // Initialize form validation on the registration form.
  // It has the name attribute "registration"
  jQuery.validator.addMethod("compareDate", function(value,element,param){
     var startDate = $(param).val().split("-");
     var endDate = value.split("-");
     var difference;
     for(var i = 0;i<3;i++){
          difference = endDate[i] - startDate[i]
          if(difference < 0){
            return false;
          }    
     }
    return true;
  },"End Date must be greater than Starting Date")

  jQuery.validator.addMethod("minlengthExcludeWhiteSpace", function(value, element, param) {
      if(value.trim().length>=param){
        return true
      }
      else
        return false
  }, "Sorry white spaces are not counted");
  
  jQuery.validator.addMethod("greaterThan", function(value, element, param) {
      if(parseInt(value) > parseInt($(param).val()))
        return true
      else 
        return false
  }, "Must be greater than minimum");
  
  jQuery.validator.addMethod("cell1",function(value,element){
      if(value.startsWith("09")||value.startsWith("+63")){
            return true;
      }      
      else{
            return false;
      }
  },"Cellphone Number must start with 09 or +63");
  jQuery.validator.addMethod("salary_type",function(value,element){
      if(value == ""){
        return true;
      }
      else{
        var value = parseInt(value);
        if(value > 1){
          return true;
        }
        else{
          return false;
        }
      }
  },"Salary must be greater than 1");

  jQuery.validator.addMethod("notEqual", function(value, element, param) {
      return this.optional(element) || value != param;
  }, "Please specify a different (non-default) value");
  
  jQuery.validator.addMethod("cell2",function(value,element){
      if(value.startsWith("9")){
        if(value.length==10)
              return true;
        else 
              return false;
      }
      else{
            return false;
      }          
  },"Cellphone number must have a valid length");
  
  jQuery.validator.addMethod("age_validator",function(value,element){
      age = calcAge(value)
      if(age>=18)
        return true
      else{
        return false     
      }
  },function(){return age+' is not an age of 18 and above';} );
  
  $("form[name='form_education']").validate({
    // Specify validation rules
    rules: {
      // The key name on the left side is the name attribute
      // of an input field. Validation rules are defined
      // on the right side
      university:"required",
      ed_end_year:{
        greaterThan:"#ed_start_year"
      },
    },
    // Specify validation error messages
    messages: {
      university:"Please enter the university name"
    },
    // Make sure the form is submitted to the destination defined
    // in the "action" attribute of the form when valid
    submitHandler: function(form) {
      var university = $('#university').val();
      var quali = $('#quali option:selected').text();
      var field_of_study = $('#field_of_study option:selected').text();
      var major = $('#major').val();
      var ed_end_year = $("#ed_end_year option:selected").text();
      var ed_start_year = $("#ed_start_year option:selected").text();             
      var myData = {
        "university":university,
        "quali":quali,
        "field_of_study":field_of_study,
        "ed_end_year":ed_end_year,
        "ed_start_year":ed_start_year,
        "major":major
      };
      swalSave("profile_import.php?action=save_education",myData)        
    }   
  });
  $("#save_seminars").validate({
    rules:{
      seminar_title:"required",
      seminar_address:"required",
      seminar_start:{
        required:true
      },
      seminar_end:{
        required:true,
        compareDate:"#seminar_start"
      },
      search_region:{
        notEqual:"Select Region",
        required:true
      },
      search_city:"required"
    },submitHandler:function(form){
      var seminar_title = $("#seminar_title").val();
      var seminar_end = $("#seminar_end").val();
      var seminar_start = $("#seminar_start").val();
      var seminar_address = $("#seminar_address").val();
      var region = $("#list_of_regions").val();
      var city = $("#list_of_cities").val();
      var myData = {
        "seminar_title":seminar_title,
        "seminar_end":seminar_end,
        "seminar_start":seminar_start,
        "seminar_address":seminar_address,
        "region":region,
        "city":city
      }
      swalSave("profile_import.php?action=save_seminar",myData)
    }

  })
  $("form[name='edit_saved_seminar']").validate({
    rules:{
      edit_seminar_title:"required",
      edit_seminar_address:"required",
      edit_seminar_start:{
        required:true
      },
      edit_seminar_end:{
        required:true,
        compareDate:"#edit_seminar_start"
      }
    },submitHandler:function(form){
      var seminar_title = $("#edit_seminar_title").val();
      var seminar_end = $("#edit_seminar_end").val();
      var seminar_start = $("#edit_seminar_start").val();
      var seminar_address = $("#edit_seminar_address").val();
      var region = $("#edit_saved_seminar #list_of_regions").val();
      var city = $("#edit_saved_seminar #list_of_cities").val();
      var id = $("#hidden_seminar_id").val()
      var myData = {
        "id":id,
        "seminar_title":seminar_title,
        "seminar_end":seminar_end,
        "seminar_start":seminar_start,
        "seminar_address":seminar_address,
        "region":region,
        "city":city
      }
      swalSave("profile_import.php?action=update_seminar",myData)
    }

  })
  $("#edit_saved_education").validate({
    // Specify validation rules
    rules: {
      // The key name on the left side is the name attribute
      // of an input field. Validation rules are defined
      // on the right side
      edit_university:"required",
      edit_ed_end_year:{
        greaterThan:"#edit_ed_start_year"
      },
    },
    // Specify validation error messages
    messages: {
      edit_university:"Please enter the university name"
    },
    // Make sure the form is submitted to the destination defined
    // in the "action" attribute of the form when valid
    submitHandler: function(form) {
      var university = $('#edit_university').val();
      var quali = $('#edit_quali option:selected').text();
      var field_of_study = $('#edit_f_study option:selected').text();
      var major = $('#edit_major').val();
      var ed_end_year = $("#edit_ed_end_year option:selected").text();
      var ed_start_year = $("#edit_ed_start_year option:selected").text();   
      var id = $("#hidden_education_id").val();          
      var myData = {
        "university":university,
        "quali":quali,
        "field_of_study":field_of_study,
        "ed_end_year":ed_end_year,
        "ed_start_year":ed_start_year,
        "major":major,
        "id":id
      };
      swalSave("profile_import.php?action=edit_education",myData);    
    }    
  });
  $("form[name='post_new_experience']").validate({
    rules:{
      position_title:{
        required:true,
        minlengthExcludeWhiteSpace:10
      },
      company_name:{
        required:true,
        minlengthExcludeWhiteSpace:10
      },
      role:{
        required:true,
        minlengthExcludeWhiteSpace:5
      },
      salary:{
        required:false,
        salary_type:true
      },
      start_year:{
        required:true
      },
      end_year:{
        greaterThan:"#start_year",
        required:false
      }
    },
    messages:{
      position_title:{
        required:"This field is required!",
        minlengthExcludeWhiteSpace:"Must be more than 10 characters!"     
      },
      company_name:{
        required:"This field is required!",
        minlengthExcludeWhiteSpace:"Must be more than 10 characters!"     
      },
      role:{
        required:"This field is required!",
        minlengthExcludeWhiteSpace:"Must be more than 5 characters!"     
      },
      salary:{
        salary_type:"Salary must be P 1 or above (This field could also be empty.)"     
      }
    },
    submitHandler: function(form) {
      var pos_title = $("#position_title").val();
      var company_name = $("#company_name").val();
      var start_year = $("#start_year option:selected").text();
      var end_year = $("#end_year option:selected").text();
      var spec = $("#spec option:selected").text();
      var role = $("#role").val();
      var pos_level = $("#pos_level option:selected").text();
      var salary = $("#salary").val();
      var exp = $("#exp").val();
      
      var myData ={
        "pos_title":pos_title,
        "company_name":company_name,
        "start_year":start_year,
        "end_year":end_year,
        "spec":spec,
        "role":role,
        "pos_level":pos_level,
        "salary":salary,
        "exp":exp
      }
      swalSave("profile_import.php?action=save_exp",myData);                  
    }
  });

  $("form[name='add_new_skills']").validate({
    rules:{
      skills_select:{
        required:true,
        minlengthExcludeWhiteSpace:2
      },
      prof_level:{
        required:true      
      }
    },
    messages:{
      skills_select:{
        required:"Skill Name is required",
        minlengthExcludeWhiteSpace:"Skill Name must be 2 characters or longer"
      },
      prof_level:{
        required:"Proficiency Level is required",
      }
    },
    submitHandler: function(form) {
      var prof_level = $("#prof_level").val();  
      var skills = $("#skills_select").val();
      var myData = {
        "prof_level":prof_level,
        "skills":skills
      };
      swalSave("profile_import.php?action=update_skills",myData);
    }
  });
  $("#edit_saved_skills").validate({
    rules:{
      edit_skills_select:{
        required:true,
        minlengthExcludeWhiteSpace:5
      },
      edit_prof_level:{
        required:true      
      }
    },
    messages:{
      edit_skills_select:{
        required:"Skill Name is required",
        minlengthExcludeWhiteSpace:"Skill Name must be 5 characters or longer"
      },
      edit_prof_level:{
        required:"Proficiency Level is required",
      }
    },
    submitHandler: function(form) {
      var prof_level = $("#edit_prof_level").val();  
      var skills = $("#edit_skills_select").val();
      var id = $("#hidden_skills_id").val();
      var myData = {
        "prof_level":prof_level,
        "skills":skills,
        "id":id
      };
      swalSave("profile_import.php?action=edit_skills",myData);
    }
  })
  $("#form_abtme").validate({
    rules:{
      firstname:{
        required:true,
        minlengthExcludeWhiteSpace:2
      },
      lastname:{
        required:true,
        minlengthExcludeWhiteSpace:2
      },
      cnum:{
        cell2:true
      },
      gender:"required",
      bday:{
        required:true,
        age_validator:true
      },
      min_salary_range:{
        required:true,
        min:1,
        max:199999
      },
      max_salary_range:{
        required:true,
        greaterThan:"#min_salary_range",
        min:1,
        max:200000
      },
      address:{
        required:true
      },
      email:"required",
      home_num:{
        telNumberValidation:true,
        required:false
      },
      self_desc:{
        minlength:40
      }
    },
    messages:{
      app_min_salary:{
        minlengthExcludeWhiteSpace:"Value must be greater than 1000!"
      }
    },
    submitHandler: function(form) {
      var fname = $( "#firstname" ).val();
      var lname = $( "#lastname" ).val();
      var cnum = $( "#cnum" ).val();
      var gender = $( "#gender" ).find(":selected").text();
      var bday = $( "#bday" ).val();
      var desc = $( "#self_desc" ).val();
      var min_salary = $( "#min_salary_range" ).val();
      var max_salary = $( "#max_salary_range" ).val();
      var address = $( "#address" ).val();
      var home_num = $( "#home_num" ).val();
      var age = calcAge(bday);
      var myData = {
        "fname":fname,
        "lname":lname,
        "c_num":cnum,
        "gender":gender,
        "bday":bday,
        "min_salary":min_salary,
        "max_salary":max_salary,
        "address":address,
        "home_num":home_num,
        "age":age,
        "desc":desc
      };
      swalSave("profile_import.php?action=update_a_profile",myData);
    }
  })
  $("#form_abtme_employer").validate({
    rules:{
      firstname:{
        required:true,
        minlengthExcludeWhiteSpace:2
      },
      lastname:{
        required:true,
        minlengthExcludeWhiteSpace:2
      },
      cnum:{
        cell2:true
      },
      gender:"required",
      bday:{
        required:true,
        age_validator:true
      },
      email:"required"
    },
    messages:{
    },
    submitHandler: function(form) {
      var fname = $( "#firstname" ).val();
      var lname = $( "#lastname" ).val();
      var cnum = $( "#cnum" ).val();
      var gender = $( "#gender" ).val();
      var bday = $( "#bday" ).val();
      var email = $( "#email" ).val();
      var age = calcAge(bday);
      var myData = {
        "fname":fname,
        "lname":lname,
        "c_num":cnum,
        "gender":gender,
        "bday":bday,
        "email":email,
        "age":age
      };
      swalSave("profile_import.php?action=update_e_profile",myData);
    }
  })
  $("#saved_company_profile").validate({
    rules:{
      role:{
        required:true,
        minlengthExcludeWhiteSpace:5
      },
      c_name:{
        required:true,
        minlengthExcludeWhiteSpace:5
      },
      c_address:{
        required:true,
        minlengthExcludeWhiteSpace:5
      },
      e_date:"required",
      region:"required",
      city:"required",
      c_address:"required",
      select_spec:"required",
      c_email:"required",
      search_region:{
        notEqual:"Select Region",
        required:true
      },
      search_city:"required"
    },
    submitHandler: function(form){
      var role = $( "#role" ).val();
      var c_name = $( "#c_name" ).val();
      var c_address = $( "#c_address" ).val();
      var region = $( "#list_of_regions" ).find(":selected").text();
      var city = $( "#list_of_cities" ).val();
      var e_date = $( "#e_date" ).val();
      var c_overview = $( "#c_overview" ).val();
      var select_spec = $( "#select_spec" ).val();
      var c_number = $( "#phone_number" ).val();
      var c_email = $( "#c_email" ).val();
      var myData = {
        "role":role,
        "c_name":c_name,
        "c_address":c_address,
        "region":region,
        "city":city,
        "e_date":e_date,
        "c_overview":c_overview,
        "select_spec":select_spec,
        "c_email":c_email,
        "c_number":c_number
      };
      swalSave("profile_import.php?action=update_e_profile_company",myData);
    }
  })
  $("#form_addjob").validate({
    rules:{
      jobname:{
        required:true,
        minlength:5,
        remote:{
        	url:"/jobsearch/profile/job_name_validator.php",
        	data:{
        		jobname: function(){
        			return $('#jobname').val()
        		}
        	},
        	type:"post"
        }
      },
      jobdetails:{
        required:true,
        minlengthExcludeWhiteSpace:30
      },
      min_salary:{
        required:true,
        min:1,
        max:199999
      },
      max_salary:{
        required:true,
        greaterThan:"#min_salary",
        min:1,
        max:200000
      },
      job_select_spec:{
        required:true
      },
      search_region:{
        notEqual:"Select Region",
        required:true
      },
      search_city:"required"
    },
    messages:{
      max_salary:{
        minlengthExcludeWhiteSpace:"Please enter an amount more than or equal to 999"
      },
      min_salary:{
        minlengthExcludeWhiteSpace:"Please enter an amount more than or equal to 999"
      },
      jobname:{
      	remote:"Sorry, this job name is already taken. Please try using another one."
      }
    },
    submitHandler: function(form){
      var jobname = $('#jobname').val();
      var jobdetails = $('#jobdetails').val();
      var min_salary = $('#min_salary').val();
      var max_salary = $('#max_salary').val();
      var employ_type = $('#employ_type').val();
      var responsibilities = $("#responsibilities").val();
      var requirements = '';
      $(".form-control.requirements.add").each(function(){
        requirements+= ",*" + $(this).val();
      })
      var specs = $("#job_select_spec").val();
      var spec = '';
      for(var i=0;i<specs.length;i++){
        spec= spec+specs[i]+","; 
      }
      spec = spec.substring(0, spec.length-1)
      var myData = {
        "jobname":jobname,
        "jobdetails":jobdetails,
        "min_salary":min_salary,
        "max_salary":max_salary,
        "employ_type":employ_type,
        "responsibilities":responsibilities,
        "requirements":requirements,
        "spec":spec
      };
      swalSave("profile_import.php?action=save_job",myData);
    }
  })

  $("#edit_saved_jobs").validate({
    rules:{
      edit_jobname:{
        required:true,
        minlengthExcludeWhiteSpace:10,
      },
      edit_jobdetails:{
        required:true,
        minlengthExcludeWhiteSpace:30
      },
      edit_min_salary:{
        required:true,
        min:1,
        max:200000
      },
      edit_max_salary:{
        required:true,
        greaterThan:"#edit_min_salary",
        min:1,
        max:200000
      },
      edit_job_select_spec:{
        required:true
      }
    },
    messages:{
      edit_max_salary:{
        minlengthExcludeWhiteSpace:"Please enter an amount more than or equal to 999"
      },
      edit_min_salary:{
        minlengthExcludeWhiteSpace:"Please enter an amount more than or equal to 999"
      }
    },
    submitHandler: function(form){
      var jobname = $('#edit_jobname').val();
      var jobdetails = $('#edit_jobdetails').val();
      var min_salary = $('#edit_min_salary').val();
      var max_salary = $('#edit_max_salary').val();
      var employ_type = $('#edit_employ_type').val();
      var id = $("#hidden_job_id").val();
      var requirements = '';
      var responsibilities = $('#edit_responsibilities').val();
      $(".form-control.requirements.edit").each(function(){
        requirements+= ",*" + $(this).val();
      })
      var specs = $("#edit_job_select_spec").val();
      var spec = '';
      for(var i=0;i<specs.length;i++){
        spec= spec+specs[i]+","; 
      }
      spec = spec.substring(0, spec.length-1)
      var myData = {
        "jobname":jobname,
        "jobdetails":jobdetails,
        "min_salary":min_salary,
        "max_salary":max_salary,
        "employ_type":employ_type,
        "responsibilities":responsibilities,
        "requirements":requirements,
        "spec":spec,
        "id":id
      };
      swalSave("profile_import.php?action=edit_jobs",myData);
    }
  })
})