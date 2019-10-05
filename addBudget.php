<?php
session_start();

include "controller_dependency.php";

//instantiate controller class and select apprioprate class
$obj = factory::DashboardController();

if (isset($_SESSION['ID'])) {

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
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <link rel="stylesheet" href="/resources/demos/style.css">
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <script src="js/backend_alert_controls.js"></script>
  
  <script>
  /*$( function() {
    $( "#datepicker" ).datepicker();
  } );
  */
 


  
  </script>

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
            <div >
                <a href="dashboard">Summary</a>
            </div>
            <div class="">
                <a href="expenditure">Add Expenditure</a>
            </div>
            <div class="active">
                <a href="addbudget">Add Budget</a>
            </div>
            <div class="">
                <a href="budgetStatus">View Budget Status</a>
            </div>
          
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

    <!--Code for signup-->    <div class="ui uk-padding-small">
        <div class="ui_main">
            <div class="section-tours" id="section-tours">
                <div class="uk-width-1-1@s uk-flex uk-flex-between uk-flex-bottom titles">
                    <h4 class="uk-margin-remove">
                        &nbsp;
                    </h4>
                    <h2 class="uk-text-bold uk-margin-remove ">
                        Expenditure
                    </h2>
                </div>
                   
                <!--- ALERTS --->

                <h6><i style="color: #44E615; text-align: center; background-color: #EAF9EA;"><strong id="success"></strong></i></h6>
                <h6><i style="color: #DA381B; text-align: center; background-color: #EAF9EA;"><strong id="email-error"></strong></i></h6>
                <h6><i style="color: #DA381B; text-align: center; background-color: #EAF9EA;"><strong id="password-error"></strong></i></h6>
                <h6><i style="color: #DA381B; text-align: center; background-color: #EAF9EA;"><strong id="failure"></strong></i></h6>
                <!--- ALERTS --->

                <div class="uk-height-1-1 dash-content">
                    <div class="uk-width-1-1@s uk-overflow-auto">
                  
                    <table class="uk-table uk-table-hover uk-table-middle uk-table-divider">
                            <thead>
                            <tr>
                                <th class="uk-width-small">S/N</th>

                                <th>TYPE</th>
                                <th>Amount</th>
                              
                            </tr>
                            </thead>
                            
                            <tbody>
                               
                              
                          <tr>
                                <td>1</td>
 
                                <td id="showtype"></td>
                                <td >₦<i id="showamount"></i>.00</td>
                                
                            </tr>
                          
                            </tbody>
                      
                        </table>
                   
                        <div class="uk-margin">
                            <button class="uk-button uk-button-theme" uk-toggle="target: #expend">Add Budget</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="expend" class="uk-flex-top" uk-modal>
        <div class="uk-modal-dialog uk-modal-body uk-margin-auto-vertical">

            <button class="uk-modal-close-default" type="button" uk-close></button>

            <!-- <form class="uk-form-stacked uk-width-1-1@s uk-child-width-1-1@l" action="expenditure" method="POST"> -->
            <div  id="info">
            </div>    
           
                <div class="uk-margin">
                    <label class="uk-form-label" for="amount">BUDGET AMOUNT [Enter digits only, comma is not allowed as it would affect your amount]</label>
                    <div class="uk-form-controls">
                        <input class="uk-input" oninput="showamount();"  name="amount" step="1" min="1" max="10000000000000000000" style="color: black;" id="amount" type="number" placeholder="Add budget amount">
                    </div>
                </div>

                <div class="uk-margin">
                <label class="uk-form-label" for="type">Select a budget type</label>
                <div class="uk-form-controls">
              <select class="uk-input" onchange="showselect();" id="type">
              <option  value="WEEKLY">Weekly Budget</option>
              <option  value="MONTHLY">Monthly Budget</option>
              <option value="YEAR">Yearly Budget</option>
              </select>
              </div>
              </div>

         
             
                <div class="uk-margin">
                    <input class="uk-button uk-button-theme uk-width-1-1@s" type="submit" onclick="addBudget()" name="add" value="Add Expenditure">
                </div>
           <!--- </form> --->
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
                    <div >
                        <a href="dashboard">Summary</a>
                    </div>
                    <div class="">
                        <a href="expenditure">Add Expenditure</a>
                    </div>
                    <div class="active">
                        <a href="addbudget">Add Budget</a>
                    </div>
                    <div class="">
                        <a href="budgetStatus">View Budget Status</a>
                    </div>
 
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

      
        <?php

        $id = $_SESSION['ID'];

        ?> 

        <script>


            //Fire input methods DEVELOPED BY MOFEHINTOLU MUMUNI
           
        
        var tag  = "<?php echo $id; ?>";
        
      
         
            function formatnumber(itemValue)
            {
                return itemValue.toString().replace(/\B(?=(\d{3})+(?!\d))/g,",");
                
            }


            function showamount()
            {    
                var amountValue = $('#amount').val();
                var itemValueFormat = formatnumber(amountValue);
                $('#showamount').html(itemValueFormat);
            }


            function showselect()
            {
               
                var descriptionValue = $('#type').val();
                $('#showtype').html(descriptionValue+" BUDGET");
            }


        //Form submission code for add budget DEVELOPED BY MOFEHINTOLU MUMUNI

        function addBudget()
            {   
        let result = document.getElementById('info');
        result.innerHTML = null;

        var itemValue = $('#type').val();
        var amountValue = $('#amount').val();
        
        $.post('src/budgetReceive.php',
        {amount:amountValue,
        type :itemValue,
        id: tag 
        },
        function(data){
            $('#info').html(data);
         
            }
            );

         }




        //form submission code for registration
        </script>
<script src="assets/js/app.js"></script>
</body>
</html>