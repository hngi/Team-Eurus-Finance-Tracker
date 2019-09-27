<?php


/**
 * @author Mofehintolu MUMUNI for team Eurus
 * 
 * @description Register controller that handles registration
 * @slack @Bits_and_Bytes
 * @copyright 2019
 */



//namespace src\Controllers;

use src\Sql\SqlQuery;

class RegisterController extends SqlQuery{
    
    
    
    private $host = "localhost";
    private $username = "root";
    private $password = "";
    private $database = "eurusfinance";
    private $Link;
    private $user_table = "users";
    
    /*THE CODE BELOW CONSISTS OF ALL THE
    *NECESSARY FUNCTIONS NEEDED FOR 
    *RegisterController CLASS
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
    * @params $fname
    * @params $last_name
    * @params $middle_name
    * @params $email
    * @params $password
    * 
    * @returns null
    * 
    * 
    *
    * */
    
    function Register($fname,$last_name, $middle_name,$email,$password)
       {
        
        $fname = $this->universal_name_sanitizer($this->trim_white_spaces_and_capitalize_firstletter_of_a_string($fname));
        $last_name = $this->universal_name_sanitizer($this->trim_white_spaces_and_capitalize_firstletter_of_a_string($last_name));
        $middle_name = $this->universal_name_sanitizer($this->trim_white_spaces_and_capitalize_firstletter_of_a_string($middle_name));
        $email = $this->sanitize_email($this->toLowercase($email));
        $password = $this->sanitize_password($this->toLowercase($password));
        
         if(($fname != null) && ($last_name != null) && ($middle_name != null) && ($email != null) && ($password != null))
        {
          
        //hash passowrd
        $password = $this->hash_password($password);

        //create unique user_id
        $timestap = time();
        $user_rand = rand(1000000,5000000);
        $unique_ref_for_user_id = md5($timestap.$email.$user_rand);    
            
        $user_id = $unique_ref_for_user_id;
        
        //get_reg date 
        $reg_date = $this->registration_date($timestap);
        
        //escape variables to prevent sql injection
        
        $fname = $this->sql_escape_string($fname);
        $last_name = $this->sql_escape_string($last_name);
        $middle_name = $this->sql_escape_string($middle_name);
        $email = $this->sql_escape_string($email);
        $password = $this->sql_escape_string($password);
        $user_id = $this->sql_escape_string($user_id);
        $reg_date = $this->sql_escape_string($reg_date);
    
        
        
        //check existence of email 
           $table_to_check = $this->user_table;
           $db_column_check = "user_email";
           $value_to_check = $email;
           
           $check_email_status = $this->check_user_existence($table_to_check,$db_column_check,$value_to_check);
           
           if($check_email_status != "true")
           {
     
              //PERFORM INSERT STATEMENT
              $table_name = $this->user_table;
              
              $column_names = "user_id, 
                              first_name,
                              last_name,
                              middle_name,
                              password,
                              user_email,
                              registration_date";
              
              $insert_values = "'$user_id',
                                '$fname',
                                '$last_name',
                                '$middle_name',
                                '$password',
                                '$email',
                                '$reg_date'";
              
              $insert_statement = $this->insert($table_name,$column_names,$insert_values);
              $exe_statement = $this->query($insert_statement);
              
              if($exe_statement)
              {
                $fullname = $fname." ".$middle_name." ".$last_name;

            //SHOW SUCCESS MESSAGE
                echo"<script> var email_var = setInterval(function(){generate_alert('$fullname your registration was successful you can now login.', 'info', 'green');}, 1000); 
                setTimeout(function(){cancel_timed_alert('info', email_var);}, 10000);</script>";

              }
            else
            {
                 //give error message
             echo"<script> var email_var = setInterval(function(){generate_alert('Registration not successful.', 'info', 'red');}, 1000); 
            setTimeout(function(){cancel_timed_alert('info', email_var);}, 10000);</script>";   
            
            } 
           
            
           }
        else
        {
             //give error message
         echo"<script> var email_var = setInterval(function(){generate_alert('Registration not successful, email already exists', 'info', 'red');}, 1000); 
        setTimeout(function(){cancel_timed_alert('info', email_var);}, 10000);</script>";   
            
        }
        
        
        }
        else
        {
             //give error message
         echo"<script> var email_var = setInterval(function(){generate_alert('Registration not successful check your inputs and retry!', 'info', 'red');}, 1000); 
        setTimeout(function(){cancel_timed_alert('info', email_var);}, 10000);</script>";   
            
        }
        
        }
  
      
   
   





    
    }


?>