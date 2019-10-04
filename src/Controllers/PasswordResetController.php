<?php


/**
 * @author Oluwafunmilola for team Eurus
 * 
 * @description PasswordReset Controller that handles login
 * @slack @Olulawlah
 * @copyright 2019
 */


//namespace src\Controllers;

use src\Sql\SqlQuery;

class PasswordResetController extends SqlQuery{
    
    
    
    private $host = "localhost";
    private $username = "root";
    private $password = "";
    private $database = "eurusfinance";
    private $Link;
    private $user_table = "users";
    
    /*THE CODE BELOW CONSISTS OF ALL THE
    *NECESSARY FUNCTIONS NEEDED FOR 
    *PasswordResetController CLASS
    */
    
      
    

     /**
    *
    * @params string $query_statement 
    * 
    * @returns sql query
    * 
    * 
    *
    * */
    
   function query($query_statement){
        $mysqli_query = mysqli_query($this->Link,$query_statement);
        return $mysqli_query;
        
    }
   
     /**
    *
    * @params string $variable 
    * 
    * @returns string
    * 
    * 
    *
    * */

  function sql_escape_string($variable){
        $escaped_string = mysqli_real_escape_string($this->Link,$variable);
        return $escaped_string;
        
    }
   
  
    /**
    *
    * @params null
    * 
    * @returns sql connection
    * 
    * 
    *
    * */
    
  private function connnect_to_db(){
    
    $link = mysqli_connect($this->host, $this->username, $this->password, $this->database)or die("Cannot connect to database");
   return $link;
  }


     /**
    *
    * @params null
    * 
    * @returns null
    * 
    * 
    *
    * */
    
     function __construct() {
 
        $link = $this->connnect_to_db();
        //return$link;
  
         $this->Link = $link;
     }
     
     
      /**
    *
    * @params null
    * 
    * @returns null
    * 
    * 
    *
    * */
    
     function __destruct()
     {
        $this->sql_close_connection();
     }
     
     
     
    /**
    *
    * @params null
    * 
    * @returns null
    * 
    * 
    *
    * */
    
      function sql_close_connection() {
        mysqli_close($this->Link); 
        
     }
   
   
   

     /**
    *
    * @params $table_name
    * @params $db_column
    * @params $value_to_check
    * 
    * @returns string
    * 
    * 
    *
    * */
    
    // Accept email of user whose password is to be reset
    // Send email to user to reset their password

    if (isset($_POST['reset-password'])) {
        $email = mysqli_real_escape_string($db, $_POST['email']);
        $query = "SELECT email FROM users Where email='$email'";
        $results = mysqli_query($db, $query);

    if (empty($email)) {
        array_push($errors, "Your email is required");
    }else if(mysqli_num_rows($results) <= 0) {
        array_push($errors, "Sorry, no user exists on our system with that email");
    }
    // generate a uique random token of length 100
    $token = bin2hex(random_bytes(50));

    if (count($errors) == 0) {
        //store token in the password-reset database table against the user's email
        $sql = "INSERT INTO password_reset(email, token) VALUES ('$email', '$token')";
        $results = mysqli_query($db, $sql);

    // Send email to user with the token in a link they can click on
    $to = $email;
    $subject = "Reset your password on eurus.com";
    $msg = "Hi there, click on this <a href=\"new_password.php?token=" . $token . "\">link</a> to reset your password on our site";
    $msg = "wordwrap($msg,70)";
    $headers = "From: admin@localhost.com";
    mail($to, $subject, $msg, $headers);
    header('location: pending.php?email=' . $email);
    }
}  

// Enter a new password
if (isset($_POST['new_password'])) {
    $new_pass = mysqli_real_escape_string($db, $_POST['new_pass']);
    $new_pass_c = mysqli_real_escape_string($db, $_POST['new_pass_c']);

    $token = $_SESSION['token'];
    if (empty($new_pass) || empty($new_pass_c)) array_push($errors, "Password is required");
    if ($new_pass !== $new_pass_c) array_push($errors, "Password does not match");
    if (count($errors) == 0) {

        $sql = "SELECT email FROM password_reset WHERE token='$token' LIMIT 1";
        $results = mysqli_query($db, $sql);
        $email = mysqli_fetch_assoc($results)['email'];

        if ($email) {
            $new_pass = md5($new_pass);
            $sql = "UPDATE users SET password= '$new_pass' WHERE email='$email'";
            $results = mysqli_query($db, $sql);
            header('location: index.php');
        }
    }
}

?>