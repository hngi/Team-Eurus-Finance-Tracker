<?php


/**
 * @author Mofehintolu MUMUNI for team Eurus
 * 
 * @description Login Controller that handles login
 * @slack @Bits_and_Bytes
 * @copyright 2019
 */


//namespace src\Controllers;

use src\Sql\SqlQuery;

class LoginController extends SqlQuery{
    
    
    
    private $host = "localhost";
    private $username = "root";
    private $password = "";
    private $database = "eurusfinance";
    private $Link;
    private $user_table = "users";
    
    /*THE CODE BELOW CONSISTS OF ALL THE
    *NECESSARY FUNCTIONS NEEDED FOR 
    *LoginController CLASS
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
    
    function check_user_existence($table_name,$db_column,$value_to_check){
        $check = $this->select_all_where($table_name,$db_column,$value_to_check);
        $check_query = $this->query($check);
        $check_num_rows = $this->sql_num_rows($check_query);
        if($check_num_rows == 1){
            $flag = "true";
            return $flag;
            
        }
        else{
            $flag = "false";
            return $flag;
            
        }
  
    }
  
    
    
    /**
    *
    * @params $email
    * @params $password
    * 
    * @returns array on success
    *
    * */
        
   function Login($email,$password)
    {

        //sanitize inputs and cast them to lower case
        $clean_user_email = $this->sanitize_email($this->toLowercase($email));
        $clean_user_password = $this->sanitize_password($this->toLowercase($password));
        
        if(($clean_user_email != null) && ($clean_user_password != null))
        {
        
        //escape user email to prevent sql inject attack
        $clean_user_email = $this->sql_escape_string($clean_user_email);

        
        //check user existence with email
      
           $table_to_check = $this->user_table;
           $db_column_check = "user_email";
           $value_to_check = $clean_user_email;
           
           $check_email_status = $this->check_user_existence($table_to_check,$db_column_check,$value_to_check);
           
      //ensure strict match in both value and type
         if($check_email_status === "true"){
                
                //select user details from db 
              
                $login_statement = $this->select_all_where($table_to_check,$db_column_check,$value_to_check);
                $sql_query = $this->query($login_statement);
                if($sql_query){
                    $login_values = array();
                    
                    while($row = $this->fetch_array($sql_query)){
                        
                        $session_id = $row['user_id'];
                        $hased_password = $row['password'];
                          
                        $login_values[] = ['SESSION_ID' => $session_id, 'PASSWORD' => $hased_password];
                        
                        }
                    
                    $n = count($login_values);
                    
                    if($n == 1){
                        
                    
                        //check if password is correct
                        
                        $hased_password_form_db = $login_values[0]['PASSWORD'];
                        $check_password = $this->verify_password($clean_user_password, $hased_password_form_db);
                        
                        //ensure strict match in both value and type
                        
                        if($check_password === "true"){
                   
                                
                           //set up session variables and return success value in array
                            
                            $_SESSION['ID'] = $login_values[0]['SESSION_ID'];
                                                    
                            $response_array = array("SUCCESS");                     
                            
                            return $response_array;
                            
                    
                        }
                        else{
                            //return failure value in array                         
                            $response_array = array("FAILURE");                     
                            
                            return $response_array;
                                              
                        }
  
                    }
                    else{
                        echo'<p style="color: red;">Error!</p>';
                echo"<script> var info_no_user = setInterval(function(){generate_alert('Login not successful!', 'info', 'red');}, 1000); 
                setTimeout(function(){cancel_timed_alert('info', info_no_user);}, 10000);</script>";
                 
                        
                    }
                    
                }
                else{
                   echo'<p style="color: red;">Error!</p>';
                echo"<script> var info_no_user = setInterval(function(){generate_alert('Login not successful', 'info', 'red');}, 1000); 
                setTimeout(function(){cancel_timed_alert('info', info_no_user);}, 10000);</script>";
                 
                    
                }
                
                
            }
            else{
                echo'<p style="color: red;">Error!</p>';
                echo"<script> var info_no_user = setInterval(function(){generate_alert('Login not successful, account details does not exist, please Signup!', 'info', 'red');}, 1000); 
                setTimeout(function(){cancel_timed_alert('info', info_no_user);}, 10000);</script>";
                
            }
   

        }
        else{
                echo'<p style="color: red;">Error!</p>';
                echo"<script> var info_no_user = setInterval(function(){generate_alert('User input error, ensure you adhere to the rules of signup and login', 'info', 'red');}, 1000); 
                setTimeout(function(){cancel_timed_alert('info', info_no_user);}, 10000);</script>";
                
            }
    }





    
    }


?>