<?php

/**
 * @author Mofehintolu MUMUNI for team Eurus
 * 
 * @description Class factory that helps load other classes
 * @slack @Bits_and_Bytes
 * 
 * @design pattern: Factory design pattern
 * 
 * @copyright 2019
 */



date_default_timezone_set('Africa/Lagos'); 

include"helpers/Datetime.php";

include"helpers/sanitize.php";

include"Sql/SqlQuery.php";

include"Controllers/RegisterController.php";

include"Controllers/LoginController.php";

include"Controllers/DashboardController.php";

include"Controllers/ExpensesController.php";

include"Controllers/PasswordResetController.php";
class factory{
 
 
 public static function RegisterController()
 {
    return new RegisterController;
 }
    
 
 public static function LoginController()
 {
    return new LoginController;
 }
 
  
 public static function DashboardController()
 {
    return new DashboardController;
 }


 public static function ExpensesController()
 {
    return new ExpensesController;
 }
    

 }
 
 


?>