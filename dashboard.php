<?php
session_start();
date_default_timezone_set('Africa/Lagos');
/**
 * @author Mofehintolu MUMUNI
 * 
 * @description Register controller that handles registration
 * @slack @Bits_and_Bytes
 * @copyright 2019
 */

include "controller_dependency.php";

//instantiate controller class and select apprioprate class
$obj = factory::DashboardController();

if (isset($_SESSION['ID'])){

$userData = $obj->GetUserDetails($_SESSION['ID']);

if ($userData['STATUS'] === 'SUCCESS') {
    $firstname = $userData['DATA'][0]['FIRSTNAME'];
    $lastname = $userData['DATA'][0]['LASTNAME'];
    $email = $userData['DATA'][0]['EMAIL'];
    $regDate = $userData['DATA'][0]['REGDATE'];

    $fullname = $firstname . " " . $lastname;
}

if ($userData['STATUS'] === 'FAILURE') {
    //redirect to login page
    echo("<script>location.href = 'index';</script>");
    header("location: index");
}

//instantiate controller class and select apprioprate class
$objExpense = factory::ExpensesController();

$weeklyExpensesArray = $objExpense->weeklyExpenses($_SESSION['ID']);
$monthlyExpensesArray = $objExpense->monthlyExpenses($_SESSION['ID']);
$yearlyExpensesArray = $objExpense->yearlyExpenses($_SESSION['ID']);

//handle weekly expenses
if(($weeklyExpensesArray[0]['STATUS'] == "ERROR") || ($weeklyExpensesArray[0]['TOTAL_EXPENSES'] == null))
{
    $weeklyExpense = "₦0.00";
}

            
if((count($weeklyExpensesArray[0]['USER_DATA']) > 0) && (is_array($weeklyExpensesArray[0]['USER_DATA']) == "TRUE") && ($weeklyExpensesArray[0]['STATUS'] == 'SUCCESS'))
{
    $weeklyExpense = "₦".$objExpense->format_number($weeklyExpensesArray[0]['TOTAL_EXPENSES']).".00";
}

//handle monthly expenses

if(($monthlyExpensesArray[0]['STATUS'] == "ERROR") || ($monthlyExpensesArray[0]['TOTAL_EXPENSES'] == null))
{
    $monthlyExpense = "₦0.00";
}

            
if((count($monthlyExpensesArray[0]['USER_DATA']) > 0) && (is_array($monthlyExpensesArray[0]['USER_DATA']) == "TRUE") && ($monthlyExpensesArray[0]['STATUS'] == 'SUCCESS'))
{
    $monthlyExpense = "₦".$objExpense->format_number($monthlyExpensesArray[0]['TOTAL_EXPENSES']).".00";
}


//handle yearly expenses
if(($yearlyExpensesArray[0]['STATUS'] == "ERROR") || ($yearlyExpensesArray[0]['TOTAL_EXPENSES'] == null))
{
    $yearlyExpense = "₦0.00";
}

            
if((count($yearlyExpensesArray[0]['USER_DATA']) > 0) && (is_array($yearlyExpensesArray[0]['USER_DATA']) == "TRUE") && ($yearlyExpensesArray[0]['STATUS'] == 'SUCCESS'))
{
    $yearlyExpense = "₦".$objExpense->format_number($yearlyExpensesArray[0]['TOTAL_EXPENSES']).".00";
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
    <link rel="favicon" href="./assets/images/logo.svg">
    <link rel="apple-touch-icon" href="./assets/images/favicon.svg">
    <link href="./assets/images/favicon.svg" rel="icon">
    <link rel="apple-touch-icon" href="./assets/images/favicon.svg">
    <link rel="apple-touch-icon" sizes="152x152" href="./assets/images/favicon.svg">
    <link rel="apple-touch-icon" sizes="180x180" href="./assets/images/favicon.svg">
    <link rel="apple-touch-icon" sizes="167x167" href="./assets/images/favicon.svg">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400&display=swap" rel="stylesheet">
<body>
<!--Preloader-->
<div id="introLoader" class="introloader">
    <div class="loader-container">
        <div class="spinner">
            <img src="assets/images/logo.svg" alt="">
        </div>
    </div>
</div>
<div id="particles-js" class="uk-position-fixed" hidden></div>
<section class="uk-flex">
    <a href="#" class="menu-toggle" uk-icon="icon: menu; ratio: 2" uk-toggle="target: #sidebar"></a>
    <div class="sidebar">
        <div>
            <div class="logo">
                <img src="./assets/images/logo.svg" alt="">
            </div>
            <div class="links">
                        <div class="active">
                            <a href="dashboard">Summary</a>
                        </div>
                        <div>
                            <a href="expenditure">Add Expenditure</a>
                        </div>
                       

                      <!--  <div>
                          <a href="search">Custom Search</a>
                         </div> -->
                <!--<div>
                    <a href="settings.php">Settings</a>
                </div> -->
            </div>
        </div>
        <!--<div>
            <h2>USER DETAILS</h2>
            <h3></h3>
            <p>Your email address is: <?php /*echo $email; */?></p>
            <p>Your date of registration is: <?php /*echo $regDate; */?></p>
        </div>-->

        <div>
            <div class="avatar-details">
                <div class="avatar">
                    <img src="./assets/images/avatar.png" alt="">
                </div>
                <div class="details">
                    <h3 class="uk-text-bold"><?php echo $fullname; ?></h3>
                </div>
            </div>
            <div class="links logout">
                <div>
                    <a href="logout">Logout</a>
                </div>
            </div>
        </div>
    </div>

    <div class="ui uk-padding-small">
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
                <ul class="uk-flex uk-flex-wrap uk-child-width-1-3@m uk-width-1-1@s ui-cards"
                    uk-switcher="animation: uk-animation-fade">
                    <li>
                        <a class="card">
                            <div class="card__side card__side--1">
                                <p class="card__text card__text-1 ">This week</p>
                                
                                <h4 class="card__heading">
                                    <span style="color:black;"><?php echo$weeklyExpense; ?></span>
                                </h4>

                            </div>

                        </a>
                    </li>

                    <li>
                        <a class="card">
                            <div class="card__side card__side--2">
                                <p class="card__text card__text-2">This month</p>
                                <h4>
                                <p style="color:black;"><?php echo date("F",time()); ?></p>
                                   </h4>
                                
                                <h4 class="card__heading">
                                    <span style="color:black;"><?php echo $monthlyExpense; ?></span>
                                    
                                </h4>

                            </div>

                        </a>
                    </li>
                    <li class="">
                        <a class="card">
                            <div class="card__side card__side--3">
                                <p class="card__text card__text-3">This year</p>
                                <h4>
                                <p style="color:black;"><?php echo date("Y",time()); ?></p>
                                   </h4>
                                <h4 class="card__heading">
                                    <span style="color:black;"><?php echo $yearlyExpense; ?></span>
                                </h4>

                            </div>

                        </a>
                    </li>
                </ul>
                <ul class="uk-switcher uk-margin">
                   
                
                <li>
                        <h3 class="weekbg">This Week</h3>
                        <?php

                            
                if((count($weeklyExpensesArray[0]['USER_DATA']) > 0) && (is_array($weeklyExpensesArray[0]['USER_DATA']) == "TRUE") && ($weeklyExpensesArray[0]['STATUS'] == 'SUCCESS'))
                {
                    $weeklyCount = sizeof($weeklyExpensesArray[0]['USER_DATA']);
                   
                    $start = 0;
                    $weeklyNumber = 0;
                    echo'<table class="uk-table uk-table-hover uk-table-middle uk-table-divider">
                    <thead>
                    <tr>
                        <th class="uk-width-small">S/N</th>
                        <th>ITEM</th>    
                        <th>Description</th>
                        <th>Amount</th>    
                        <th>Date</th> 
                    </tr>
                    </thead>
                    <tbody>';
                    while($start < $weeklyCount)
                    {   
                    

                    $innerWeeklyArray = $weeklyExpensesArray[0]['USER_DATA'][$start];

                    $innerWeeklyCount = sizeof($innerWeeklyArray);

                    $innerWeeklyStart = 0;

                    while($innerWeeklyStart < $innerWeeklyCount)
                    {
                        $weeklyNumber += 1;

                        $weeklyItem = $innerWeeklyArray[$innerWeeklyStart]['ITEM'];
                        $weeklyAmount = $objExpense->format_number($innerWeeklyArray[$innerWeeklyStart]['AMOUNT']);
                        $weeklyDescription = $innerWeeklyArray[$innerWeeklyStart]['DESCRIPTION'];
                        $weeklyDate = $innerWeeklyArray[$innerWeeklyStart]['DATE'];
                            echo'<tr>
                                <td>'.$weeklyNumber.'</td>
                                <td>'.$weeklyItem.'</td>
                                <td>'.$weeklyDescription.'</td>
                                <td >₦<i>'.$weeklyAmount.'</i>.00</td> 
                                <td ><i>'.$weeklyDate.'</i></td>
                            </tr>';
                    


                        $innerWeeklyStart++;
                    }

                 
                        $start++; 
                    }
                    echo'</tbody>
                    </table>';
                }



                        ?>

                       <!--- <div class="uk-margin">
                            <button class="uk-button uk-button-theme">Export to PDF</button>
                        </div> -->
                    </li>



                    <li>

                        <h3 class="monthbg">This Month</h3>
                        <p class="monthbg"><?php echo date("F",time()); ?></p>
                        <?php

                            
        if((count($monthlyExpensesArray[0]['USER_DATA']) > 0) && (is_array($monthlyExpensesArray[0]['USER_DATA']) == "TRUE") && ($monthlyExpensesArray[0]['STATUS'] == 'SUCCESS'))
        {
            $monthlyCount = sizeof($monthlyExpensesArray[0]['USER_DATA']);
        
            $start = 0;
            $monthlyNumber = 0;
            echo'<table class="uk-table uk-table-hover uk-table-middle uk-table-divider">
            <thead>
            <tr>
                <th class="uk-width-small">S/N</th>
                <th>ITEM</th>    
                <th>Description</th>
                <th>Amount</th>    
                <th>Date</th> 
            </tr>
            </thead>
            <tbody>';
            while($start < $monthlyCount)
            {   
            

            $showMonthlyArray = $monthlyExpensesArray[0]['USER_DATA'][$start];

            $monthlyNumber += 1;

            $monthlyItem = $showMonthlyArray['ITEM'];
            $monthlyAmount = $objExpense->format_number($showMonthlyArray['AMOUNT']);
            $monthlyDescription = $showMonthlyArray['DESCRIPTION'];
            $monthlyDate = $showMonthlyArray['DATE'];

                echo'<tr>
                    <td>'.$monthlyNumber.'</td>
                    <td>'.$monthlyItem.'</td>
                    <td>'.$monthlyDescription.'</td>
                    <td >₦<i>'.$monthlyAmount.'</i>.00</td> 
                    <td ><i>'.$monthlyDate.'</i></td>
                </tr>';


                $start++; 
            }
            echo'</tbody>
            </table>';
        }



        ?>

                        <!--- <div class="uk-margin">
                            <button class="uk-button uk-button-theme">Export to PDF</button>
                        </div> -->
                    </li>
                    <li>

                        <h3 class="yearbg">This Year</h3>
                        <p class="monthbg"><?php echo date("Y",time()); ?></p>
         <?php

            if((count($yearlyExpensesArray[0]['USER_DATA']) > 0) && (is_array($yearlyExpensesArray[0]['USER_DATA']) == "TRUE") && ($yearlyExpensesArray[0]['STATUS'] == 'SUCCESS'))
                {
            $yearlyCount = sizeof($yearlyExpensesArray[0]['USER_DATA']);
        
            $start = 0;
            $yearlyNumber = 0;
            echo'<table class="uk-table uk-table-hover uk-table-middle uk-table-divider">
            <thead>
            <tr>
                <th class="uk-width-small">S/N</th>
                <th>ITEM</th>    
                <th>Description</th>
                <th>Amount</th>    
                <th>Date</th> 
            </tr>
            </thead>
            <tbody>';
            while($start < $yearlyCount)
            {   
            

            $yearlyArray = $yearlyExpensesArray[0]['USER_DATA'][$start];

            $yearlyNumber += 1;

            $yearlyItem = $yearlyArray['ITEM'];
            $yearlyAmount = $objExpense->format_number($yearlyArray['AMOUNT']);
            $yearlyDescription = $yearlyArray['DESCRIPTION'];
            $yearlyDate = $yearlyArray['DATE'];

                echo'<tr>
                    <td>'.$yearlyNumber.'</td>
                    <td>'.$yearlyItem.'</td>
                    <td>'.$yearlyDescription.'</td>
                    <td >₦<i>'.$yearlyAmount.'</i>.00</td> 
                    <td ><i>'.$yearlyDate.'</i></td>
                </tr>';


                $start++; 
            }
            echo'</tbody>
            </table>';
        }
            ?>

                        <!--- <div class="uk-margin">
                            <button class="uk-button uk-button-theme">Export to PDF</button>
                        </div> -->
                    </li>
                </ul>

            </div>
        </div>
    </div>
    <div id="sidebar" uk-offcanvas="mode: reveal; overlay: true">
        <div class="uk-offcanvas-bar dashboard">

            <button class="uk-offcanvas-close" type="button" uk-close></button>
            <div class="canvas">
                <div>
                    <div class="logo">
                        <img src="./assets/images/logo.svg" alt="">
                    </div>
                    <div class="links">
                        <div>
                            <a href="expenditure">Add Expenditure</a>
                        </div>
                        <div class="active">
                            <a href="dashboard">Summary</a>
                        </div>

                        <!--  <div>
                          <a href="search">Custom Search</a>
                         </div> -->

                       <!-- <div>
                            <a href="settings">Settings</a>
                        </div> --->
                    </div>
                </div>
                <div>
                    <div class="avatar-details">
                        <div class="avatar">
                            <img src="./assets/images/avatar.png" alt="">
                        </div>
                        <div class="details">
                            <h3 class="uk-text-bold"><?php echo $fullname; ?></h3>
                        </div>
                    </div>
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
    function logout() {
        window.location = "logout";

    }
</script>
<?php
}
else {
    echo("<script>location.href = 'index';</script>");
    header("location: index");
}
?>
</body>
</html>
