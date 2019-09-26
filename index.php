<?php 
session_start();

include"controller_dependency.php";

//instantiate controller class and select apprioprate class
 $objLogin = factory::LoginController();

 //instantiate controller class and select apprioprate class
 $objReg = factory::RegisterController();
 
$token = $_SESSION['token'] = md5(rand(1,10000000));

if(!isset($_SESSION['ID'])){

?>
<!doctype html>
<html class="no-js" lang="en">
<head>
    <meta charset="utf-8"/>
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eurus Wallet | Welcome</title>
    <link rel="stylesheet" href="assets/css/app.css">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700,800&display=swap" rel="stylesheet">
    <link rel="favicon" href="./assets/images/logo.svg">
    <link rel="apple-touch-icon" href="./assets/images/favicon.svg">
    <link href="./assets/images/favicon.svg" rel="icon">
    <link rel="apple-touch-icon" href="./assets/images/favicon.svg">
    <link rel="apple-touch-icon" sizes="152x152" href="./assets/images/favicon.svg">
    <link rel="apple-touch-icon" sizes="180x180" href="./assets/images/favicon.svg">
    <link rel="apple-touch-icon" sizes="167x167" href="./assets/images/favicon.svg">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400&display=swap" rel="stylesheet">
</head>
<body>
<!--Preloader-->
<div id="introLoader" class="introloader">
    <div class="loader-container">
        <div class="spinner">
            <img src="assets/images/logo.svg" alt="">
        </div>
    </div>
</div>
<div id="particles-js" class="uk-position-fixed"></div>
<section>
    <header>
        <nav class="uk-flex uk-flex-between uk-padding uk-flex-middle uk-position-z-index">
            <div>
                <img src="./assets/images/logo.svg" alt="">
            </div>
            <div>
                
                
              <!----- START PHP CODE ----->

              <?php

              if(isset($_POST['user_login']))
                  {
                 if($_SERVER['REQUEST_METHOD'] == "POST")
                 {
                 if((isset($_POST['emailLogin'])) && (isset($_POST['passwordLogin'])) && ($_POST['emailLogin'] != null) && ($_POST['passwordLogin'] != null))
                 {
                     if($token == $_SESSION['token'])
                     {
                         
                          //CALL UP LOGIN FUNCTION
                             $responseArray = $objLogin->Login($_POST['emailLogin'],$_POST['passwordLogin']);
                             
                          //GET VALUES FROM THE RESPONSE ARRAY 
                         if(is_array($responseArray))
                             {
                              $login_status = $responseArray[0];
          
                             if($login_status == "SUCCESS")
                             {
                                  echo'<script> window.location = "dashboard";
                                  </script>';
             
                             }
                              elseif($login_status == "FAILURE")
                                  {
                                      if(isset($_SESSION['ID']))
                                      {
                                          session_destroy();
                                      }
                                          echo'<p style="color: red;">Error!</p>';
                                          echo"<script> var password_wrong = setInterval(function(){generate_alert('Password or email is not valid', 'password-error', 'red');}, 1000); 
                                          setTimeout(function(){cancel_timed_alert('password-error', password_wrong);}, 10000);</script>";
                              
                      
                                  }
                                  else
                                  {
                                      if(isset($_SESSION['ID']))
                                      {
                                          session_destroy();
                                      }
                                      echo'<p style="color: red;">Error!</p>';
                                      echo"<script> var password_wrong = setInterval(function(){generate_alert('Password or email is not valid', 'password-error', 'red');}, 1000); 
                                      setTimeout(function(){cancel_timed_alert('password-error', password_wrong);}, 10000);</script>";
                             
                                  }
                             
                             }
                          
                                  
                          }
                          else{
                              echo'<p style="color: red;">Error!</p>';
                              echo"<script> var email_var = setInterval(function(){generate_alert('Login not successful', 'info', 'red');}, 1000); 
                              setTimeout(function(){cancel_timed_alert('info', email_var);}, 10000);</script>";
                          }
          
                          }
                          else{
                              echo'<p style="color: red;">Error!</p>';
                              echo"<script> var email_var = setInterval(function(){generate_alert('Login not successful check your inputs', 'info', 'red');}, 1000); 
                              setTimeout(function(){cancel_timed_alert('info', email_var);}, 10000);</script>";
                          }
          
                      }
                      else{
                          echo'<p style="color: red;">Error!</p>';
                          echo"<script> var email_var = setInterval(function(){generate_alert('Login not successful', 'info', 'red');}, 1000); 
                          setTimeout(function(){cancel_timed_alert('info', email_var);}, 10000);</script>";
                      }
          
                      }
          
          
                      //Handle registeration success
          
                      if(isset($_GET['login']) && isset($_GET['user']) && ($_GET['login'] === 'true') && ($_GET['user'] != null))
                      {
          
                          $fullname = (string) $_GET['user'];
                          
                          echo"<script> var email_var = setInterval(function(){generate_alert('$fullname your account registration was successful you can now login!', 'success', 'green');}, 1000); 
                      setTimeout(function(){cancel_timed_alert('info', email_var);}, 10000);</script>"; 
          
                      }
          
          
                          ?>
                          
          
                  <!----- END PHP CODE ----->
          

                      <!----- START PHP CODE FOR SIGNUP DEVELOPED BY MOFEHINTOLU-MUMUNI ----->

              <?php

            if(isset($_POST['user_signup']))
            {
            if($_SERVER['REQUEST_METHOD'] == "POST")
            {
                if((isset($_POST['email'])) && (isset($_POST['password'])) && ($_POST['email'] != null) && ($_POST['password'] != null) && (isset($_POST['firstname'])) && (isset($_POST['middlename'])) && ($_POST['firstname'] != null) && ($_POST['middlename'] != null) && (isset($_POST['lastname'])) && (isset($_POST['passwordConfirm'])) && ($_POST['lastname'] != null) && ($_POST['passwordConfirm'] != null) && (isset($_POST['terms'])) && ($_POST['terms'] != null))
                {
                    if(($token == $_SESSION['token']) && ($_POST['passwordConfirm'] === $_POST['password']))
                    {

                            //CALL UP REGISTER FUNCTION
                            $objReg->Register($_POST['firstname'],$_POST['lastname'],$_POST['middlename'],$_POST['email'],$_POST['password']);
                
                    }
                    else{
                        echo'<p style="color: red;">Error!</p>';
                        echo"<script> var email_var = setInterval(function(){generate_alert('Registration not successful, password missmatch!', 'info', 'red');}, 1000); 
                        setTimeout(function(){cancel_timed_alert('info', email_var);}, 10000);</script>";
                    }

                }
                else{
                        if(!isset($_POST['terms']))
                        {
                            echo'<p style="color: red;">Error!</p>';
                            echo"<script> var email_var = setInterval(function(){generate_alert('Registration not successful check your inputs and accept terms and conditions.', 'info', 'red');}, 1000); 
                            setTimeout(function(){cancel_timed_alert('info', email_var);}, 10000);</script>";
                        }
                        else
                        {
                            echo'<p style="color: red;">Error!</p>';
                            echo"<script> var email_var = setInterval(function(){generate_alert('Registration not successful check your inputs', 'info', 'red');}, 1000); 
                            setTimeout(function(){cancel_timed_alert('info', email_var);}, 10000);</script>";
                        }
                        
                    }

            }
            else{
                echo'<p style="color: red;">Error!</p>';
                echo"<script> var email_var = setInterval(function(){generate_alert('Registration not successful', 'info', 'red');}, 1000); 
                setTimeout(function(){cancel_timed_alert('info', email_var);}, 10000);</script>";
            }

            }

            ?>

  <!----- END PHP CODE ----->


                <!--- ALERTS --->

                <h6><i style="color: #44E615; text-align: center; background-color: #EAF9EA;"><strong id="success"></strong></i></h6>
                <h6><i style="color: #1BCEDA; text-align: center; background-color: #EAF9EA;"><strong id="info"></strong></i></h6>
                <h6><i style="color: #DA381B; text-align: center; background-color: #EAF9EA;"><strong id="email-error"></strong></i></h6>
                <h6><i style="color: #DA381B; text-align: center; background-color: #EAF9EA;"><strong id="password-error"></strong></i></h6>
                <h6><i style="color: #DA381B; text-align: center; background-color: #EAF9EA;"><strong id="failure"></strong></i></h6>
                <!--- ALERTS --->
            </div>
            <div>
                <button class="uk-button uk-button-theme-light" uk-toggle="target: #login">Login</button>
                <!---<button class="uk-button uk-button-theme uk-margin-medium-left" uk-toggle="target: #sign-up">Sign up</button>  --->
            </div>
        </nav>    <div class="uk-flex uk-flex-wrap uk-flex-middle viewport">
            <div class="uk-width-1-3@m uk-padding">
                <div>
                    <h2 class="uk-text-bold">A Simple Task</h2>
                    <p>Ever wondered what black hole your money goes into? With Eurus Wallet, you can track your spending
                        easily.</p>
                    <button class="uk-button uk-button-theme" uk-toggle="target: #sign-up">Try EurusWallet</button>
                </div>
            </div>
            <div class="uk-width-2-3@m bgdiv">
    
            </div>
        </div>
    </header>
    
    <!--Code for signup-->
    <div id="sign-up" uk-offcanvas="mode: reveal; overlay: true">
        <div class="uk-offcanvas-bar">
    
            <button class="uk-offcanvas-close" type="button" uk-close></button>
            <h3 class="uk-text-bold uk-margin-remove-top">Create Your Account</h3>
            <div class=" uk-width-1-1@s ">
                <form class="uk-form-stacked uk-width-1-1@s uk-child-width-1-1@l" action="" method="POST">
    
                    <div class="uk-margin">
                        <label class="uk-form-label" for="firstname">First Name</label>
                        <div class="uk-form-controls">
                            <input type="text" 
                            class="uk-input" style="color: black;" name="firstname" id ="fname" oninput="firstName()" placeholder="Enter your First Name"/>
                            <small style="color: black;"><p id="validfname"></p></small>
                        </div>
                    </div>

                


                    <div class="uk-margin">
                        <label  class="uk-form-label" for="middlename">Middle Name: </label>
                        <div class="uk-form-controls">
                             <input type="text"  class="uk-input" style="color: black;" 
                    name="middlename" id ="mname" oninput="middleName()" placeholder="Enter your Middle Name"/>
                            <small style="color: black;" ><p id="validmname"></p></small>
                        </div>
                    </div>
                    
               

                    <div class="uk-margin">
                       <label  class="uk-form-label" for="lastname">Last Name: </label>
                        <div class="uk-form-controls">
                            <input type="text" class="uk-input" style="color: black;"   
                    name="lastname" id ="lname" oninput="lastName()" placeholder="Enter your Last Name"/>
                            <small style="color: black;" ><p id="validlname"></p></small>
                        </div>
                    </div>
                    
                   
    
                    <div class="uk-margin">
                        <label  class="uk-form-label" for="email">E-mail: </label>
                        <div class="uk-form-controls">
                             <input type="email"  class="uk-input" style="color: black;"  
                    name="email" id ="email" oninput="emailPart()" placeholder="Enter your E-mail"/>
                            <small style="color: black;" ><p id="validemail"></p></small>
                        </div>
                    </div>
              
        
    
                    <div class="uk-margin">
                          <label  class="uk-form-label" for="password">Password: </label>
                        <div class="uk-form-controls">
                             <input type="password" class="uk-input" style="color: black;"   
                    name="password" id = "pswrd" oninput="passWord()" placeholder="Enter your Password"/>
                    <small style="color: black;" ><p id="validPasswrd"></p></small>
                        </div>
                    </div>
                    
                    
                    
                    
    
                    <div class="uk-margin">
                       <label class="uk-form-label" for="passwordConfirm">Confirm Password: </label>
                        <div class="uk-form-controls">
                            <input type="password" class="uk-input" style="color: black;"  
                    name="passwordConfirm" id = "pswrdConf" oninput="passWordConfirm()" placeholder="Confirm your Password"/>
                    <small style="color: black;" ><p id="validPasswrdConfirm"></p></small>
                        </div>
                    </div>
                    
                     <div class ="inline">
                        <input type="checkbox" name="terms" class="checkbox"/>
                        <small class="tandc" style="color: black;" >By signing I agree to
                            <a href ="#">Terms and Conditions</a></small>
                       </div>
                    
                   
                    <div class="uk-margin">
                        <button class="uk-button uk-button-theme uk-width-1-1@s" name="user_signup">Sign up</button>
                    </div>
                </form>
            </div>
            <div>
                <h4 class="uk-text-bold uk-margin-remove-bottom">Already have an account? <a href="#" uk-toggle="target: #login">Login</a></h4>
            </div>
        </div>
    </div>
    <!--Code for signup Updated by Mofehintolu Mumuni-->
    
    
    <!--Code for login-->
    <div id="login" uk-offcanvas="mode: reveal; overlay: true">
        <div class="uk-offcanvas-bar">
    
            <button class="uk-offcanvas-close" type="button" uk-close></button>
            <h3 class="uk-text-bold uk-margin-remove-top">Login to Your Account</h3>
            <div class=" uk-width-1-1@s ">
                <form class="uk-form-stacked uk-width-1-1@s uk-child-width-1-1@l" action="" method="Post">

                   
                    <div class="uk-margin">
                        <label  class="uk-form-label" for="emailLogin">E-mail: </label>
                        <div class="uk-form-controls">
                             <input type="email"  class="uk-input" style="color: black;"  
                    name="emailLogin" id ="emailLogin" oninput="emailPartLogin()" placeholder="Enter your E-mail"/>
                            <small style="color: black;" ><p id="validemailLogin"></p></small>
                        </div>
                    </div>
              
        
    
                    <div class="uk-margin">
                          <label  class="uk-form-label" for="passwordLogin">Password: </label>
                        <div class="uk-form-controls">
                             <input type="password" class="uk-input" style="color: black;"   
                    name="passwordLogin" id = "pswrdLogin" oninput="passWordLogin()" placeholder="Enter your Password"/>
                    <small style="color: black;" ><p id="validPasswrdLogin"></p></small>
                        </div>
                    </div>
    
                    <div class="uk-margin">
                        <button class="uk-button uk-button-theme uk-width-1-1@s" name="user_login">Login</button>
                    </div>
                </form>
            </div>
            <div>
                <h4 class="uk-text-bold uk-margin-remove-bottom">Don’t have an account? <a href="#" uk-toggle="target: #sign-up">Sign up</a></h4>
            </div>
        </div>
    </div>
    <!--Code for login-->
</section>

<script src="assets/js/app.js"></script>
<script src="js/backend_alert_controls.js"></script>

<script>
/////////////////signup  validation code developed by Mofehintolu-mumuni  ////////////

    function firstName(){
            let fname = document.querySelector("#fname").value;
            let fpattern =   /^[a-zA-Z]{2,20}$/;

                if(fpattern.test(String(fname).toUpperCase())  == true && !fname.length < 4   ){
                    ftext = "Valid First Name input";
                } else {
                    ftext = "Input not valid";
                }
            
               document.getElementById("validfname").innerHTML = ftext;

        }

         function middleName(){
            let mname = document.querySelector("#mname").value;
            let fpattern =     /^[a-zA-Z]{2,20}$/;

                if(fpattern.test(String(mname).toUpperCase())  == true && !fname.length < 4   ){
                    ftext = "Valid Middle Name input";
                } else {
                    ftext = "Input not valid";
                }
            
               document.getElementById("validmname").innerHTML = ftext;

        }

        function lastName(){
            let lname = document.querySelector("#lname").value;
            let fpattern =     /^[a-zA-Z]{2,20}$/;

                if(fpattern.test(String(lname).toUpperCase())  == true && !fname.length < 4   ){
                    ftext = "Valid Last Name input";
                } else {
                    ftext = "Input not valid";
                }
            
               document.getElementById("validlname").innerHTML = ftext;

        }

        function emailPart(){
            let email = document.querySelector("#email").value;
            let valid = document.querySelector("#validemail");
            let pattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,15}$/;

                if(pattern.test(String(email).toLowerCase()) == true){
                    text = "Valid Email input";
                } else {
                    text = "Add a valid email";
                }
            
               document.getElementById("validemail").innerHTML = text;
            }

            function passWord(){
            let password = document.querySelector("#pswrd").value;
            let tpattern =  /^(?=[^\s]*?[0-9])(?=[^\s]*?[a-zA-Z])[a-zA-Z0-9]{2,20}$/;
          

                if(tpattern.test(String(password))  == true  ){
                    ttext = "Valid Password input";
                } else {
                    ttext = "Password must contain letters and numbers only (20 characters max)";
                }
            
               document.getElementById("validPasswrd").innerHTML = ttext;

        }

        function passWordConfirm(){
            let password = document.querySelector("#pswrdConf").value;
            let passwordMain = document.querySelector("#pswrd").value;
            let tpattern =  /^(?=[^\s]*?[0-9])(?=[^\s]*?[a-zA-Z])[a-zA-Z0-9]{2,20}$/;
          

                if(tpattern.test(String(password))  == true  && (passwordMain === password) ){
                    ttext = "Password match";
                } else {
                        if(tpattern.test(String(password))  != true  && (passwordMain != password) )
                        {
                            ttext = "Password must contain letters and numbers only (20 characters max) and must match Password above";
               
                        }
                       else if(tpattern.test(String(password))  != true)
                        {
                            ttext = "Password must contain letters and numbers only (20 characters max)";
                        }
                        else if(passwordMain != password)
                        {
                            ttext = "Password Missmatch";
                        }
 
                }
            
               document.getElementById("validPasswrdConfirm").innerHTML = ttext;

        }
        


        /////////////////Login in validation code developed by Mofehintolu-mumuni  ////////////



        function emailPartLogin(){
                let emailLogin = document.querySelector("#emailLogin").value;
                let valid = document.querySelector("#validemailLogin");
                let pattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,15}$/;

                    if(pattern.test(String(emailLogin).toLowerCase()) == true){
                        text = "Valid Email input";
                    } else {
                        text = "Add a valid email";
                    }
                
                   document.getElementById("validemailLogin").innerHTML = text;
                }

                function passWordLogin(){
                let password = document.querySelector("#pswrdLogin").value;
                let tpattern =  /^(?=[^\s]*?[0-9])(?=[^\s]*?[a-zA-Z])[a-zA-Z0-9]{2,20}$/;
              

                    if(tpattern.test(String(password))  == true  ){
                        ttext = "Valid Password input";
                    } else {
                        ttext = "Password must contain letters and numbers only (20 characters max)";
                    }
                
                   document.getElementById("validPasswrdLogin").innerHTML = ttext;

            }

</script>
<?php
}
else{
    echo("<script>location.href = 'dashboard';</script>");
    header("location: dashboard");
}
?>
</body>
</html>
