<?php
  $rand=mt_rand(1000,9999);
  if(isset($_SESSION['userDetails'])){
    print "Please finish your current account sign-up before creating a new account. Click <a href='/jobsearch/signup/authenticate/security_questions.html'>here</a> to go to step 2";
    exit();
  }
?>
<!DOCTYPE html>
<html>
<head>
  <title>Register as a new Company</title>
  <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script
  src="https://code.jquery.com/jquery-3.2.1.min.js"
  integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4="
  crossorigin="anonymous"></script>
  <script src='https://www.google.com/recaptcha/api.js'></script>
  <script src='applicant_validation.js'></script>
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.16.0/jquery.validate.min.js"></script>
  <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.min.js"></script>

  <script src="/jobsearch/sweetalert2/sweetalert2.min.js"></script>
  <link rel="stylesheet" href="/jobsearch/sweetalert2/sweetalert2.min.css">
  
  <script src="/jobsearch/select-region/regions.js"></script>
  <script src="/jobsearch/validation_function/js/password_strength_tester.js"></script>
  
  <link rel="stylesheet" href="styles.css">
  </head>
  <body>
  <div class="flex-container">
    <div class="flex-item left">
      <div class="container">
        <!-- <ul class="steps hidden">
            <li class="one-step active" number="1" id="step1">
              <span class="special">
                <span class="circle green" id="circle1">1</span>
                <strong>Step 1</strong>
                <small>Enter Account Details.</small>
              </span>
              <i></i>
            </li>
            <li class="one-step" number="2" id="step2">
              <span>
                <span class="circle green" id="circle2">2</span>
                <strong>Step 2</strong>
                <small>Enter Personal Details.</small>          
              </span><i></i>
            </li>
            <li class="one-step" number="3" id="step3">
              <span>
                <span class="circle green" id="circle3">3</span>
                <strong>Step 3</strong>
                <small>Enter Company Details.</small>
              </span><i></i>
            </li>
        </ul>-->
        
        <img src="/jobsearch/img/employer.png" class="logo">
        <h1>Create your own account today!</h1>
        <p>One man cannot do it all.</p>

      </div>
    </div>
    <div class="flex-item right">
     <div class="form-container">  
        <div class="form" step="1">
            <div class="top">
              <span class="number" style='margin-bottom:15px'>1</span><h2>Account Details</h2>
            </div>
            <div class="middle">
              <form name = "first-step" id="first-step">
              <input type="hidden" class="" value="<?php $myaccno =  date('Y').'112'.$rand; print $myaccno;?>" disabled data-validation-required-message="Please enter your account number." name="accno" id="accno">
              <div class="form-control-container">
                <label> Personal Email Address:</label>
                <input type="email" class="" placeholder="Your Work Email *" name="email" id="email" required data-validation-required-message="Please enter your work email address.">
              </div>
              <div class="form-control-container">
                <label for="password">* Password:</label>
                <input type="password" class="" id="password" placeholder="Your Password *" id="password" name="password" required data-validation-required-message="Please enter your password.">
                <span id="password_strength"></span>
              </div>
              <div class="form-control-container">
                <label for="password">* Confirm Password:</label>
                <input type="password" class="" placeholder="Confirm your password" id="conf_password" name="conf_password" required data-validation-required-message="Please enter your password.">
              </div>
              </form>
            </div>
            <div class="bottom">
              <button class="button ripple next" parent-form="first-step">Next</button>    
            </div>
        </div> 
        <div class="form hidden" step="2">
            <div class="top">
              <span class="number" style='margin-bottom:15px'>2</span><h1>Personal Details</h1>
            </div>
            <div class="middle">
              <form name = "second-step" id="second-step">
                <div class="form-control-container">
                  <label for="bio">First Name:</label>
                  <input type="text" class="" placeholder="First Name " name="fname" id="fname" required data-validation-required-message="Please enter your first name.">
                </div>
                <div class="form-control-container">
                  <label for="bio">Last Name:</label>
                  <input type="text" class="" placeholder="Last Name " name="lname" id="lname" required data-validation-required-message="Please enter your last name.">
                </div>
                <div class="form-control-container">
                  <label> Gender:</label>
                    <select name="gender" id="gender">
                      <option value="Male">Male</option>
                      <option value="Female">Female</option>
                    </select>
                </div>
                <div class="form-control-container">
                  <label> Birthday:</label>
                  <input type="date" class="" style='height:8%' name="bday" id="bday" min="1979-01-01" max="<?php print date("Y-m-d") ?>" required>
                </div>
                <div class="form-control-container">
                  <label> Cellphone Number:</label>
                  <div style="">
                    <input value="+63" type="text" disabled="" style="width:40px; !important;float:left">
                    <input type="tel" class="flex-element valid" placeholder="Your Phone Number *" name="cnum" id="cnum" required="" data-validation-required-message="Please enter your phone number." style="max-width: 500px;width: 61.4%;" aria-required="true" aria-invalid="false">
                    <br>
                  </div>
                </div>
                <div class="form-control-container">
                  <label for="bio">Job Title/Role:</label>
                  <input type="text" class="" placeholder="Your Role or Position " name="role" id="role" required data-validation-required-message="Please enter your role.">
                </div>
              </form>
            </div>
            <div class="bottom">
              <button class="button ripple previous">Previous</button>
              <button class="button ripple next" parent-form="second-step">Next</button>    
            </div>
        </div>
        <div class="form hidden" step="3">
            <div class="top">
               <span class="number" style='margin-bottom:15px'>3</span><h1>Company Details</h1>
            </div>
            <!--Entire form -->
            <form name="third-step" id="third-step">
              <div class="form-control-container middle">
                  <div class="form-control-container">
                    <label for="bio">Company Name:</label>
                    <input type="text" class="" placeholder="Company Name " name="cname" id="cname" required data-validation-required-message="Please enter your company name.">
                  </div>
                  <div class="form-control-container">
                    <label for="bio">Company Address:</label>
                    <input type="text" class="" placeholder="Company Address" name="address" id="address" required data-validation-required-message="Please enter your company address.">
                  </div>
                  <div class="form-control-container">
                    <label> Company Url:</label>
                    <input type="text"  placeholder="Format: https://www.yourcompany.com" name="url" id="url" required>
                  </div>
                  <div class="form-control-container">
                    <label>Establishment date:</label>
                    <input type="date"  style='height:8%' name="edate" min="1979-01-01" max="<?php print date("Y-m-d") ?>" id="edate" required>
                  </div>
                  <div class="form-control-container">
                    <label>Region:</label>
                    <select class="fields_filter" id="list_of_regions" name="search_region">
                    </select>
                    <label>City/Province:</label>
                    <select class="fields_filter" id="list_of_cities" name="search_city">           
                    </select>
                  </div>
                  <div class="form-control-container">
                    <label> Company Telephone Number:</label>
                    <input type="tel" class="" placeholder="Company Phone Number*" name="company_num" id="company_num" required>
                  </div>
                  <div class="form-control-container">
                    <label> Company Email Address:</label>
                    <input type="email" class="" placeholder="Company Email *" name="company_email" id="company_email" required data-validation-required-message="Please enter your work email address.">
                  </div>
                  <div class="form-control-container">
                    <label> User Captcha</label>
                    <div style="padding:20px;">
                      <center><div class="g-recaptcha" data-sitekey="6LeJ3TEUAAAAAEZ4FyovX08jmT9-35AjxbQyd8cZ" style="transform:scale(0.77);transform-origin:0 0"></div></center>
                    </div>
                  </div>
              </div>
              <div class="bottom">
                <button class="button ripple previous">Previous</button>
                <button class="button ripple" type="submit">Submit</button>
              </div>
            </form>
            <!--End of entire form -->
        </div>
        <br>
        <!--   -->  
      </div>

    </div>
  </div>
     
</body>
<!--
************************************************************

Comment Regarding Scripts

************************************************************ 
First set a button for validation, then once it is set, use next
-->
<script type="text/javascript">
    $(window).on("load",function(){
    })  
  $(function(){

    function returnFormName($this){
      return $("#" +$this.attr("parent-form"));
    }
    function next($this){
       var $current_form = $this.closest(".form");
       var $current_step = parseInt($current_form.attr("step"));
       //next steps
       var $next_step = $current_step + 1;
       var $next_form = $(".form[step="+$next_step+"]");
       $current_form.fadeOut(function(){
        $next_form.fadeIn("slow");
        $(".one-step[number="+$current_step+"]").removeClass("active")
        $(".one-step[number="+$next_step+"]").addClass("active")
       });
    }
    $("button.next").click(function(){
      //current forms
     var parentForm  = returnFormName($(this));
     isValid(parentForm,next,$(this))
    });
     //showing of forms
    $("button.previous").click(function(){
      //current steps
     var $current_form = $(this).closest(".form");
     var $current_step = parseInt($current_form.attr("step"));
     //next steps
     var $prev_step = $current_step - 1;
     var $prev_form = $(".form[step="+$prev_step+"]");
     //showing of forms
     $current_form.fadeOut(function(){
      $prev_form.fadeIn();
      $(".one-step[number="+$current_step+"]").removeClass("active")
      $(".one-step[number="+$prev_step+"]").addClass("active")
      $(".one-step[number="+$prev_step+"]").addClass("active")
     })
    })
  })
</script>
</html>