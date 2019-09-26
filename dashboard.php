
<?php 
session_start();

include"controller_dependency.php";

//instantiate controller class and select apprioprate class
 $obj = factory::DashboardController();

if(isset($_SESSION['ID'])){

  $userData = $obj->GetUserDetails($_SESSION['ID']);

  if($userData['STATUS'] === 'SUCCESS')
  {
    $firstname = $userData['DATA'][0]['FIRSTNAME'];
    $lastname = $userData['DATA'][0]['LASTNAME'];
    $middlename = $userData['DATA'][0]['MIDDLENAME'];
    $email = $userData['DATA'][0]['EMAIL'];
    $regDate = $userData['DATA'][0]['REGDATE'];

    $fullname = $firstname." ".$middlename." ".$lastname;
  }

  if($userData['STATUS'] === 'FAILURE')
  {
   //redirect to login page
   echo("<script>location.href = 'index';</script>");
    header("location: index");
  }

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
    <link rel="favicon" href="./assets/logo.svg">
    <link rel="apple-touch-icon" href="./assets/favicon.svg">
    <link href="./assets/favicon.svg" rel="icon">
    <link rel="apple-touch-icon" href="./assets/favicon.svg">
    <link rel="apple-touch-icon" sizes="152x152" href="./assets/favicon.svg">
    <link rel="apple-touch-icon" sizes="180x180" href="./assets/favicon.svg">
    <link rel="apple-touch-icon" sizes="167x167" href="./assets/favicon.svg">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400&display=swap" rel="stylesheet">
<body>
<!--Preloader-->
<div id="introLoader" class="introloader">
    <div class="loader-container">
        <div class="spinner">
            <img src="assets/logo.svg" alt="">
        </div>
    </div>
</div>
<div id="particles-js" class="uk-position-fixed" hidden></div>
<section class="uk-flex">
    <a href="#" class="menu-toggle" uk-icon="icon: menu; ratio: 2" uk-toggle="target: #sidebar"></a>
    <div class="sidebar">
        <div>
            <div class="logo">
                <img src="./assets/logo.svg" alt="">
            </div>
            <div class="links">
            <div>
                    <a href="expenditure">Add Expenditure</a>
                </div>    
            <!-- <div class="active">
                    <a href="dashboard">Summary</a>
                </div>
                
                <div>
                    <a href="categories">Categories</a>
                </div>
                <div>
                    <a href="">Settings</a>
                </div> -->
            </div>
        </div>
        <div>
        <h2 >USER DETAILS</h2>
        <h3 ><?php echo $fullname; ?></h3>
        <p >Your email address is: <?php echo $email; ?></p>
        <p>Your date of registration is: <?php echo $regDate; ?></p>
        </div>

        <div>
          <!-- <div class="avatar-details">
                <div class="avatar">
                    <img src="./assets/avatar.png" alt="">
                </div>
                <div class="details">
                    <h3 class="uk-text-bold">Sean Paul</h3>
                </div>
            </div> --> 
            <div class="links logout">
                <div>
                <a href="logout">Logout</a>
                </div>
            </div>
        </div>
    </div>
    
    <!--Code for signup-->    <div class="ui uk-padding-small">
        <div class="ui_main">
            <div class="section-tours" id="section-tours">
                <div class="uk-width-1-1@s uk-flex uk-flex-between uk-flex-bottom titles">
                    <h4 class="uk-margin-remove">
                        Expenditure
                    </h4>
                    <h2 class="uk-text-bold uk-margin-remove ">
                        Overview
                    </h2>
                </div>
                <ul class="uk-flex uk-flex-wrap uk-child-width-1-3@m uk-width-1-1@s ui-cards" uk-switcher="animation: uk-animation-fade">
                    <li>
                        <a class="card">
                            <div class="card__side card__side--1">
                                <p class="card__text card__text-1 ">This week</p>
                                <h4 class="card__heading">
                                    <span class="card__heading--span card__heading--span-1">₦0.00</span>
                                </h4>
    
                            </div>
    
                        </a>
                    </li>
    
                    <li>
                        <a class="card">
                            <div class="card__side card__side--2">
                                <p class="card__text card__text-2">This month</p>
                                <h4 class="card__heading">
                                    <span class="card__heading--span card__heading--span-2">₦0.00</span>
                                </h4>
    
                            </div>
    
                        </a>
                    </li>
                    <li class="">
                        <a class="card">
                            <div class="card__side card__side--3">
                                <p class="card__text card__text-3">This year</p>
                                <h4 class="card__heading">
                                    <span class="card__heading--span card__heading--span-3">₦0.00</span>
                                </h4>
    
                            </div>
    
                        </a>
                    </li>
                </ul>
                <ul class="uk-switcher uk-margin">
                    <li>
                        <h3 class="weekbg">This Week</h3>
                        <table class="uk-table uk-table-divider uk-table-hover">
                            <tbody>
                            <tr>
                                <td>Cell & Broadband</td>
                                <td>₦0.00</td>
                            </tr>
                            <tr>
                                <td>Toiletries</td>
                                <td>₦0.00</td>
                            </tr>
                            <tr>
                                <td>Utility Bills</td>
                                <td>₦0.00</td>
                            </tr>
                            </tbody>
                        </table>
    
                        <div class="uk-margin">
                            <button class="uk-button uk-button-theme">Export to PDF</button>
                        </div>
                    </li>
                    <li>
    
                        <h3 class="monthbg">This Month</h3>
                        <table class="uk-table uk-table-divider uk-table-hover">
                            <tbody>
                            <tr>
                                <td>Category</td>
                                <td>₦0.00</td>
                            </tr>
                            <tr>
                                <td>Category</td>
                                <td>₦0.00</td>
                            </tr>
                            <tr>
                                <td>Category</td>
                                <td>₦0.00</td>
                            </tr>
                            </tbody>
                        </table>
    
                        <div class="uk-margin">
                            <button class="uk-button uk-button-theme">Export to PDF</button>
                        </div>
                    </li>
                    <li>
    
                        <h3 class="yearbg">This Year</h3>
                        <table class="uk-table uk-table-divider uk-table-hover">
                            <tbody>
                            <tr>
                                <td>Category</td>
                                <td>₦0.00</td>
                            </tr>
                            <tr>
                                <td>Category</td>
                                <td>₦0.00</td>
                            </tr>
                            <tr>
                                <td>Category</td>
                                <td>₦0.00</td>
                            </tr>
                            </tbody>
                        </table>
    
                        <div class="uk-margin">
                            <button class="uk-button uk-button-theme">Export to PDF</button>
                        </div>
                    </li>
                </ul>
                <button class="uk-button uk-button-theme">Export to PDF</button>
    
            </div>
        </div>
    </div>
    <div id="sidebar" uk-offcanvas="mode: reveal; overlay: true">
        <div class="uk-offcanvas-bar dashboard">

            <button class="uk-offcanvas-close" type="button" uk-close></button>
            <div class="canvas">
                <div>
                    <div class="logo">
                        <img src="./assets/logo.svg" alt="">
                    </div>
                    <div class="links">
                         <div>
                        <a href="expenditure">Add Expenditure</a>
                    </div>    
                 <!--    <div class="active">
                            <a href="">Summary</a>
                        </div>
                        
                        <div>
                            <a href="">Categories</a>
                        </div>
                        <div>
                            <a href="">Settings</a>
                        </div> --> 
                    </div>
                </div>
                <div>
                    <!-- <div class="avatar-details">
                <div class="avatar">
                    <img src="./assets/avatar.png" alt="">
                </div>
                <div class="details">
                    <h3 class="uk-text-bold">Sean Paul</h3>
                </div>
            </div> --> 
                    <div class="links logout">
                        <div>
                            <a href="logout">Logout</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script src="assets/js/app.js"></script>
<script>
  function logout()
  {
    window.location = "logout";
        
  }
  </script>
  <?php
    }
    else{
        echo("<script>location.href = 'index';</script>");
        header("location: index");
    }
    ?>
</body>
</html>
