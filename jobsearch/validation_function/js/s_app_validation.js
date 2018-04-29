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
  $("input[name='cnum'], input[name='pnum'], input[name='company_num']").on('keypress',function(e){
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
    if(value.match(emailFormat)){
      return true
    }
    else{
      return false;
    }
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
      if(format){
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

  jQuery.validator.addMethod("cellnum_start",function(value,element){
      if(value.startsWith("9")){
            return true;
      }      
      else{
            return false;
      }        
  },"Cellphone number must start with 9");

  $("form[name='sign-up']").validate({
    // Specify validation rules
    rules: {
      // The key name on the left side is the name attribute
      // of an input field. Validation rules are defined
      // on the right side
      errorPlacement: function(error, element) {
        if (element.attr("name") != "gender" ){
            error.insertAfter(element.next());
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
        cell_length:true,
        cellnum_start:true
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
        
        
        
        
      //});
    }
  });
  
});