<?php


/**
 * @author Mofehintolu MUMUNI team Eurus
 * 
 * @description Dashboard Controller that handles pulling user details to the frontend
 * 
 * @slack @Bits_and_Bytes
 * @copyright 2019
 */



//namespace src\Controllers;

use src\Sql\SqlQuery;

class DashboardController extends SqlQuery{
    
    
    
    private $host = "localhost";
    private $username = "root";
    private $password = "";
    private $database = "eurusfinance";
    private $Link;
    private $user_table = "users";
    
    /*THE CODE BELOW CONSISTS OF ALL THE
    *NECESSARY FUNCTIONS NEEDED FOR 
    *DashboardController CLASS
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
    * @params $_SESSION[ID] $user_id 
    * 
    * @returns USER DETAILS @ARRAY
    * 
    * 
    *
    * */
    
    function GetUserDetails($user_id)
       {
        $user_id = $this->sanitize_32_character_id($user_id);
        
        if($user_id != null)
        {
            $user_id = $this->sql_escape_string($user_id);
        
            $table_name = $this->user_table;
            $db_column = "user_id";
            $value_to_check = $user_id;
            
            $check_user_existence = $this->check_user_existence($table_name,$db_column,$value_to_check);
            
            if($check_user_existence === "true")
            {
                //get user details from database using $user_id
                
                $get_user_details_statement = $this->select_all_where($table_name,$db_column,$value_to_check);
                $get_user_details_query = $this->query($get_user_details_statement);
                
                $user_details_array = [];
                
                while($row = $this->fetch_array($get_user_details_query))
                {
                    $first_name = $row['first_name'];
                    $last_name = $row['last_name'];
                    $user_email = $row['user_email'];
                    $registration_date = $row['registration_date'];
                }
                
                $user_details_array[] = ['FIRSTNAME'=> $first_name,'LASTNAME'=>$last_name, 'EMAIL'=>$user_email,'REGDATE'=>$registration_date];
                
                if(sizeof($user_details_array) === 1)
                {
                    return ['STATUS'=> 'SUCCESS','DATA'=> $user_details_array];
                }
                else
                {
                     if(isset($_SESSION['ID'])){
    
                    //destroy session and include login
                    session_destroy();
                        }
                   return ['STATUS'=> 'FAILURE','DATA'=> []]; 
                }
            }
            else
                {
                    if(isset($_SESSION['ID'])){
    
                    //destroy session and include login
                    session_destroy();
                        }
                   return ['STATUS'=> 'FAILURE','DATA'=> []]; 
                }
        }
        else
                {
                    if(isset($_SESSION['ID'])){
    
                    //destroy session and include login
                    session_destroy();
                        }
                   return ['STATUS'=> 'FAILURE','DATA'=> []]; 
                }
 
        
       }
  
      
   
   





    
    }


?>