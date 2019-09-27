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
        $middlename = $userData['DATA'][0]['MIDDLENAME'];
        $email = $userData['DATA'][0]['EMAIL'];
        $regDate = $userData['DATA'][0]['REGDATE'];

        $fullname = $firstname . " " . $middlename . " " . $lastname;
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
                <div>
                    <a href="dashboard.php">Summary</a>
                </div>
                <div>
                    <a href="expenditure.php">Expenditure</a>
                </div>
                <div class="active">
                    <a href="categories.php">Categories</a>
                </div>
                <div>
                    <a href="settings.php">Settings</a>
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
    <div class="ui uk-padding-small">
        <div class="ui_main">
            <div class="section-tours" id="section-tours">
                <div class="uk-width-1-1@s uk-flex uk-flex-between uk-flex-bottom titles">
                    <h4 class="uk-margin-remove">

                    </h4>
                    <h2 class="uk-text-bold uk-margin-remove ">
                        Categories
                    </h2>
                </div>
                <div class="uk-height-1-1 dash-content">
                    <div class="uk-width-1-1@s uk-overflow-auto">
                        <table class="uk-table uk-table-hover uk-table-middle uk-table-divider">
                            <thead>
                            <tr>
                                <th class="uk-width-small">S/N</th>
                                <th>Name</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>1</td>
                                <td>Carrots</td>
                            <tr>
                                <td>1</td>
                                <td>Carrots</td>
                            </tr>
                            <tr>
                                <td>1</td>
                                <td>Carrots</td>
                            </tr>
                            </tbody>
                        </table>

                        <div class="uk-margin">
                            <button class="uk-button uk-button-theme" uk-toggle="target: #expend">Add Category</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="expend" class="uk-flex-top" uk-modal>
        <div class="uk-modal-dialog uk-modal-body uk-margin-auto-vertical">

            <button class="uk-modal-close-default" type="button" uk-close></button>

            <form class="uk-form-stacked uk-width-1-1@s uk-child-width-1-1@l">
                <div class="uk-margin">
                    <label class="uk-form-label" for="euname">NAME</label>
                    <div class="uk-form-controls">
                        <input class="uk-input" style="color: black;" id="euname" type="text"
                               placeholder="Add Category name">
                    </div>
                </div>

                <div class="uk-margin">
                    <button class="uk-button uk-button-theme uk-width-1-1@s">Add Expenditure</button>
                </div>
            </form>
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
                            <a href="dashboard.php">Summary</a>
                        </div>
                        <div>
                            <a href="expenditure.php">Expenditure</a>
                        </div>
                        <div class="active">
                            <a href="categories.php">Categories</a>
                        </div>
                        <div>
                            <a href="settings.php">Settings</a>
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

<script src="assets/js/app.js"></script>
</body>
</html>

