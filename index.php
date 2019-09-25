<?php
include('signup.php');
?>
<!doctype html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eurus Wallet | Welcome</title>
    <script src="https://kit.fontawesome.com/86802d6cfb.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" 
    integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" href="assets/css/app.css">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" 
    integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" 
    integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>  
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700,800&display=swap" rel="stylesheet">
    <link rel="favicon" href="./assets/logo.svg">
    <link rel="apple-touch-icon" href="./assets/favicon.svg">
    <link href="./assets/favicon.svg" rel="icon">
    <link rel="apple-touch-icon" href="./assets/favicon.svg">
    <link rel="apple-touch-icon" sizes="152x152" href="./assets/favicon.svg">
    <link rel="apple-touch-icon" sizes="180x180" href="./assets/favicon.svg">
    <link rel="apple-touch-icon" sizes="167x167" href="./assets/favicon.svg">
</head>

<body>
    <!--Preloader-->
    <div id="introLoader" class="introloader">
        <div class="loader-container">
            <div class="spinner">
                <img src="assets/logo.svg" alt="">
            </div>
        </div>
    </div>
    <div id="particles-js" class="uk-position-fixed"></div>
    <section>
        <header>
            <nav class="uk-flex uk-flex-between uk-padding uk-flex-middle uk-position-z-index">
                <div>
                    <img src="./assets/logo.svg" alt="">
                </div>
                <div>
                    <button class="uk-button uk-button-theme-light" uk-toggle="target: #login">Login</button>
                    <button  class="uk-button uk-button-theme uk-margin-medium-left" uk-toggle="target: #sign-up">Sign
                        up</button>
                </div>
            </nav>
            <div class="uk-flex uk-flex-wrap uk-flex-middle viewport">
                <div class="uk-width-1-3@m uk-padding">
                    <div>
                        <h2 class="uk-text-bold">A Simple Task</h2>
                        <p>Ever wondered what black hole your money goes into? With Eurus Wallet, you can track your
                            spending easily.</p>
                        <button class="uk-button uk-button-theme">Try EurusWallet</button>
                    </div>
                </div>
                <div class="uk-width-2-3@m bgdiv">

                </div>
            </div>
        </header>
        <div id="sign-up" uk-offcanvas="mode: reveal; overlay: true">
            <div class="uk-offcanvas-bar">
                <button class="uk-offcanvas-close" type="button" uk-close></button>
                <h3 style="color: black; font-weight: bolder;">Create your account</h3>
                <form class="uk-form" method="POST"id = "regForm" name="regForm" onsubmit = "return validateForm()" action="#">
                <div class="input-group my-1">
                    <div class="input-group-prepend">
                    <span class="input-group-text" id="fname" >
                    <i class="fas fa-user"></i>
                    </span>
                    </div>     
                    <input type="text" name="fname" class="form-control" id="fname" placeholder="Fullname">
                    </div>
                    <div class="input-group my-1">
                    <div class="input-group-prepend">
                    <span class="input-group-text" id="uname" >
                    <i class="fas fa-user"></i>
                                        </span>
                    </div>     
                    <input type="text" name="uname" class="form-control" id="uname" placeholder="e.g. Joeboy">
                    </div>
                    <div class="input-group my-1">
                    <div class="input-group-prepend">
                    <span class="input-group-text" id="email" >
                    <i class="fas fa-envelope"></i>
                    </span>
                    </div>
                    <input type="email" class="form-control" id="email" name = "email" placeholder="Enter your Email" aria-describedby="emailHelp">
                    </div>
                    <div class="input-group my-1">
                        <div class="input-group-prepend">
                        <span class="input-group-text" id="password1" >
                        <i class="fas fa-user-lock"></i>                        
                        </span>
                        </div>
                        <input type="password" class="form-control" id="password1" name = "password1" placeholder="Enter Password">
                        </div>    
                        <div class="input-group my-1">
                        <div class="input-group-prepend">
                        <span class="input-group-text" id="cnfpassword" >
                        <i class="fas fa-unlock-alt"></i>                   
                        </span>
                        </div>
                        <input type="password" class="form-control" id="cnfpassword" name ="cnfpassword" placeholder="Confirm Password">
                        </div> 
                        <label for="check" class="form-check-label"> <small>By signing in I agree to<strong><a href="#">Terms and Conditions</a></strong></small>Agree to Terms</label>
                            <?php if(!isset($_POST['check'])){ ?>
                            <input type="checkbox" id="check" name="check" value="yes"/>
                            <label for="check" class="error">You must agree to terms</label>
                            <?php } ?> <br />   
                <button type="submit" id="submit_btn" name = "submit_btn" class="uk-button uk-button-theme uk-margin-medium-left" uk-toggle="target: " style="color: white;" >Sign
                    up</button>
            </form>
           <!--Link this button to the dashboard--> 
            
        </div>
        </div>
        <div id="login" uk-offcanvas="mode: reveal; overlay: true">
            <div class="uk-offcanvas-bar">

                <button class="uk-offcanvas-close" type="button" uk-close></button>

                <h3>Title</h3>

                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore
                    et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut
                    aliquip ex ea commodo consequat.</p>

            </div>
        </div>
    </section>

    <script src="assets/js/app.js"></script>
</body>

</html>