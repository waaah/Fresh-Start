$(function() {
  // Initialize form validation on the registration form.
  // It has the name attribute "registration"
  function calcAge(dateString){
    var birthday = new Date(dateString);
    var ageDifMs = Date.now() - birthday.getTime();
    var ageDate = new Date(ageDifMs);

    return Math.abs(ageDate.getFullYear()-1970); 
  }
  /*function getEmail(callback){
    $.ajax({
        type:"post",
        url:"/jobsearch/validation_function/js/email_validate.php",
        success:function(data){
          callback(data)
          console.log(data);
        }
      })
  }*/
  $("input[name='cnum'], input[name='pnum'], input[name='company_num'], input[id='min_salary_range'], input[id='max_salary_range'] ").on('keypress',function(e){
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
  
  //this is for computing and then validating a user's age
  jQuery.validator.addMethod("age_validator",function(value,element){
    age = calcAge(value)
    if(age>=18)
      return true
    else{
      return false     
    }
  },function(){return age+' is not an age of 18 and above';} );
  //end of age validation

  jQuery.validator.addMethod("confirmEmail",function(value,element){
    var value = value;
    var newvalue;
    getEmail(function(data){
      newvalue = data
    })
    return newvalue;
  },function(){"Sorry email already exists!"})
  

  
  //this function is for confirming if the passwords match
  jQuery.validator.addMethod("confPassword",function(value,element,param){
      var password = $(param).val();
      if(value===password){
        return true
      }
      else{
        return false
      }
  },"Your entered password and this field must match (Note: This field is case sensitive, so please check your capitalization, and then try again)");
  //end of password validation

  //this function is for email format validation
  jQuery.validator.addMethod("emailValidation",function(value,element,param){
    var emailFormat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
    return value.match(emailFormat) ? true : false
  },"Invalid Email Format!")
  //end of email validation

  //this is for comparing two different values
  jQuery.validator.addMethod("greaterThan", function(value, element, param) {
      if(parseInt(value) > parseInt($(param).val()))
        return true
      else 
        return false
  }, "Must be greater than minimum");
  //end of comparison between two values

  //this is for validating an element that is not equal to the default text
  jQuery.validator.addMethod("notEqual", function(value, element, param) {
    return this.optional(element) || value != param;
  }, "Please specify a different (non-default) value");
  // end of validation

  // telephone number validation
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
  // end of telephone number validation

  //this is for validating urls
  jQuery.validator.addMethod("url_validate",function(value,element){
    return this.optional( element ) || /^(?:(?:(?:https?|ftp):)?\/\/)(?:\S+(?::\S*)?@)?(?:(?!(?:10|127)(?:\.\d{1,3}){3})(?!(?:169\.254|192\.168)(?:\.\d{1,3}){2})(?!172\.(?:1[6-9]|2\d|3[0-1])(?:\.\d{1,3}){2})(?:[1-9]\d?|1\d\d|2[01]\d|22[0-3])(?:\.(?:1?\d{1,2}|2[0-4]\d|25[0-5])){2}(?:\.(?:[1-9]\d?|1\d\d|2[0-4]\d|25[0-4]))|(?:(?:[a-z\u00a1-\uffff0-9]-*)*[a-z\u00a1-\uffff0-9]+)(?:\.(?:[a-z\u00a1-\uffff0-9]-*)*[a-z\u00a1-\uffff0-9]+)*(?:\.(?:[a-z\u00a1-\uffff]{2,})).?)(?::\d{2,5})?(?:[/?#]\S*)?$/i.test( value );
  },"Must be valid url");
  //end of url validation
  
  //cellphone number validation
  jQuery.validator.addMethod("cell_length",function(value,element){
      return this.optional(element) || value.length == 10;        
  },"Cellphone number must have a valid length");
  //end of cellphone number validation
  //cellphone number validation
  jQuery.validator.addMethod("cell_start",function(value,element){
      return value.startsWith(9);        
  },"Cellphone number must start with 9");
  //end of cellphone number validation


  /*$("form[name='sign-up']").validate({
    // Specify validation rules
    rules: {
      // The key name on the left side is the name attribute
      // of an input field. Validation rules are defined
      // on the right side
      errorPlacement: function(error, element) {
        if (element.attr("name") != "gender" ){
            error.insertAfter(element);
        }           
      },
      fname:{
        required:true,
        minlength:2
      },
      pnum:{
        telNumberValidation:"input[name='pnum']"
      },
      company_num:{
        telNumberValidation:"input[name='company_num']"
      },
      lname:{
        required:true,
        minlength:2
      },
      gender:{
        required:true
      },
      email: {
        required: true,
        // Specify that email should be validated
        // by the built-in "email" rule
        emailValidation:true,
        remote:{
          type:"post",
          url:"/jobsearch/validation_function/js/email_validate.php",
          data:{
            type:function(){
              return (window.location.pathname === "/jobsearch/s_app.php") ? "applicant" : "company"
            },
            email:function(){
              return $("#email").val();
            }
          }
        }
      },
      password: {
        required: true,        
        minlength: 8,
      },
      conf_password:{
        confPassword:"#password",
        required: true,        
        minlength: 8,
      },
      description:{
        required: true,        
        minlength: 30
      },
      cnum:{
        cell_length:true
      },
      cname:{
          required: true,
          minlength: 3,
      },
      c_add:{
          required: true,
          minlength: 10
      },
      url:{
          url_validate:true
      },
      search_region:{
        required:true,
        notEqual:"Select Region"
      },
      search_city:{
        required:true,
        notEqual:"Select City"
      },
      min:{
        required:"true",
      },
      max:{
        required:"true",
        greaterThan:"#min"
      },
      bday:{
        required:true,
        age_validator:true
      },
      company_email:{
        emailValidation:true,
      }

    },


    // Specify validation error messages
    messages: {
      firstname: "Please enter your firstname",
      lastname: "Please enter your lastname",
      password: {
        required: "Please provide a password",
        minlength: "Your password must be at least 8 characters long"
      },
      description:{
        required: "Please a type brief summary",        
        minlength: "Must be more than or equal to 30 words"
      },
      cname:{
          required: "This is Required",
          minlength: "Must be more than 3 characters"
      },
      c_add:{
          required: "This field is required",
          minlength: "Must be more than 10 characters"
      },
      email:{
        remote:"Sorry this email is already in use. Please create another one"
      },
         
    },
    // Make sure the form is submitted to the destination defined
    // in the "action" attribute of the form when valid
    submitHandler: function(form) {
      //$('#sign-up').on('submit',function(e){
        function companyData(){
          var companyData = applicantData();
          delete companyData['description'];
          delete companyData['min'];
          delete companyData['max'];
          delete companyData['address'];
          delete companyData['pnum'];
          companyData['role'] = $("#role").val();
          companyData['cname'] = $("#cname").val();
          companyData['url'] = $("#url").val();
          companyData['edate'] = $("#edate").val();
          companyData['url'] = $("#url").val();
          companyData['edate'] = $("#edate").val();
          companyData['list_of_regions'] = $("#list_of_regions").val();
          companyData['list_of_cities'] = $("#list_of_cities").val();
          companyData['company_num'] = $("#company_num").val();
          companyData['company_email'] = $("#company_email").val();
          return companyData;
        }
        function applicantData(){
          var $accno = $("#accno").val();
          var $password = $("#password").val();
          var $gender = $("#gender").val();
          var $bday = $("#bday").val();
          var $lname = $("#lname").val();
          var $fname = $("#fname").val();
          var $address = $("#address").val();
          var $email = $("#email").val();
          var $pnum = $("#pnum").val();
          var $cnum = $("#cnum").val();
          var $desc = $("#description").val();
          var $min = $("#min").val();
          var $max = $("#max").val();
          var obj = {
            accno:$accno,
            password:$password,
            fname:$fname,
            lname:$lname,
            gender:$gender,
            bday:$bday,
            address:$address,
            email:$email,
            pnum:$pnum,
            cnum:$cnum,
            description:$desc,
            min:$min,
            max:$max
          }
          return obj;
        }
        var data;
        if(window.location.pathname == "/jobsearch/s_app.php"){ data = applicantData(); }
        else if(window.location.pathname == "/jobsearch/s_company.php"){ data = companyData();}
        console.log(data)
        data.captcha = grecaptcha.getResponse();
        swal({
          title:"Question:",
          text: 'Are you sure you want to continue? Once you press continue, all your results will be saved.',
          showCancelButton: true,
          confirmButtonText: 'Submit',
          showLoaderOnConfirm: true,
          type:"question",
          preConfirm: function () {
            return new Promise(function (resolve, reject) {
              setTimeout(function() {
                $.post("save_sign-up.php",data,function(data){
                  data = (data !== "" || data == null)? JSON.parse(data) : '';
                  if(data[0] == true){
                    swal({
                      title:"Success!",
                      text:"Registration has been successful! Press OK to go to the next step.",
                      type:"success",
                      allowOutsideClick:false
                    }).then(function(){
                      form.submit();
                    });    
                  }
                  else{
                    swal("Error!",data['message'],"error");
                    return false;
                  }
                })
              }, 2000)
            })
          },
          allowOutsideClick: false
        }).catch(swal.noop)
        
        
        
      //});
    }
  });*/
  //observe the dom for any class changes
  /*var observer = new MutationObserver(function(mutations){
    mutations.forEach(function(mutation){
      console.log(mutation.type)
    })
  });
  var target = $("input,textarea,select")[0];
  var config = { attributes: true, childList: true, characterData: true };
  observer.observe(target,config) */
  jQuery.validator.setDefaults({
    debug:true,
  });
  //this is for the applicant first step;

  var $firstStep = $("#first-step").validate({
    
    rules: {
      email: {
        required: true,
        // Specify that email should be validated
        // by the built-in "email" rule
        emailValidation:true,
        remote:{
          type:"post",
          url:"/jobsearch/validation_function/js/email_validate.php",
          data:{
            type:function(){
              var array_string = window.location.pathname.split('/');
              var array_len = array_string.length; 
              return (array_string[array_len-1] === "s_app.php") ? "applicant" : "company"
            },
            email:function(){
              return $("#email").val();
            }
          }
        }
      },
      password: {
        required: true,        
        minlength: 8,
      },
      conf_password:{
        confPassword:"#password",
        required: true,        
        minlength: 8,
      },
    },
    messages:{
      email:{
        remote:"Sorry this email is already in use. Please create another one"
      },
    }
  }); 

  $("#second-step").validate({
    
    rules:{
      fname:{
        required:true,
        minlength:2
      },
      lname:{
        required:true,
        minlength:2
      },
      bday:{
        required:true,
        age_validator:true
      },
      pnum:{
        required:false,
        telNumberValidation:"input[name='pnum']"
      },
      cnum:{
        cell_length:true,
        cell_start:true
      },

    },
    messages:{

    }
  })
  $("#third-step").validate({
    
    rules:{
      cnum:{
        cell_length:true,
        cell_start:true
      },
      description:{
        required: true,        
        minlength: 30
      },
      min_salary_range:{
        required:"true",
        max:199999,
        min:1000
      },
      max_salary_range:{
        required:"true",
        max:200000,
        min:1000,
        greaterThan:"#min_salary_range"
      },
      cname:{
          required: true,
          minlength: 3,
      },
      c_add:{
          required: true,
          minlength: 10
      },
      url:{
          url_validate:true
      },
      search_region:{
        required:true,
        notEqual:"Select Region"
      },
      search_city:{
        required:true,
        notEqual:"Select City"
      },
      company_num:{
        telNumberValidation:"input[name='company_num']"
      }
    },
    messages:{

    },
    submitHandler:function(){
      function isJSON(string){
        try {
          string = JSON.parse(string);
        }
        catch(e){
          return false;
        }
        return string;
      }
        function companyData(){
          var companyData = applicantData();
          delete companyData['description'];
          delete companyData['min-salary-range'];
          delete companyData['max-salary-range'];
          delete companyData['pnum'];
          companyData['role'] = $("#role").val();
          companyData['cname'] = $("#cname").val();
          companyData['url'] = $("#url").val();
          companyData['edate'] = $("#edate").val();
          companyData['region'] = $("#list_of_regions").val();
          companyData['city'] = $("#list_of_cities").val();
          companyData['company_num'] = $("#company_num").val();
          companyData['company_email'] = $("#company_email").val();
          return companyData;
        }
        function applicantData(){
          var $accno = $("#accno").val();
          var $password = $("#password").val();
          var $gender = $("#gender").val();
          var $bday = $("#bday").val();
          var $lname = $("#lname").val();
          var $fname = $("#fname").val();
          var $address = $("#address").val();
          var $email = $("#email").val();
          var $pnum = $("#pnum").val();
          var $cnum = $("#cnum").val();
          var $desc = $("#description").val();
          var $min = $("#min_salary_range").val();
          var $max = $("#max_salary_range").val();
          var obj = {
            accno:$accno,
            password:$password,
            fname:$fname,
            lname:$lname,
            gender:$gender,
            bday:$bday,
            address:$address,
            email:$email,
            pnum:$pnum,
            cnum:$cnum,
            description:$desc,
            max:$max,
            min:$min
          }
          return obj;
        }
        var array_string = window.location.pathname.split('/');
        var array_len = array_string.length;
        var data;
        if(array_string[array_len-1] == "s_app.php"){ data = applicantData(); }
        else if(array_string[array_len-1] == "s_company.php"){ data = companyData();}
        //saves the page location and captcha as part of the array
        data.captcha = grecaptcha.getResponse();
        data.pageLocation = array_string[array_len-1];
        //end of saving
        console.log(data);
        swal({
          title:"Question:",
          text: 'Are you sure you want to continue? Once you press continue, all your results will be saved.',
          showCancelButton: true,
          confirmButtonText: 'Submit',
          showLoaderOnConfirm: true,
          type:"question",
          preConfirm: function () {
            return new Promise(function (resolve, reject) {
              setTimeout(function() {
                //processses the data by using AJAX
                $.post("/jobsearch/signup/save_sign-up.php",data,function(data){
                  console.log(data);
                  data = isJSON(data);
                  if(data[0] == true){
                    swal({
                      title:"Success!",
                      text:"Registration has been successful! Press OK to validate your next step.",
                      type:"success",
                      allowOutsideClick:false
                    }).then(function(){
                      console.log(data);
                      location.href = "/jobsearch/signup/authenticate/security_questions.html";
                    });    
                  }
                  else{
                    swal("Error!",data['message'],"error");
                    return false;
                  }
                });
                //end of AJAX processing
              }, 2000)
            })
          },
          allowOutsideClick: false
        }).catch(swal.noop)
    }
  })
  //end of applicant first step

});

function isValid($formName,callback,parameter){
  if($formName.valid()){
    callback(parameter);
  }  
}

