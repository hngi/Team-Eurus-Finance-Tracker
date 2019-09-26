<?php

/**
 * @author Mofehintolu MUMUNI for team Eurus
 * 
 * @description Class that contains all useful sql statements
 * @slack @Bits_and_Bytes
 * @copyright 2019
 */


namespace src\Sql;

use src\helpers\sanitizer;

class SqlQuery extends sanitizer{
    

//DATABASE ABSTRACTION METHODS

  function select_all_where($table_name,$db_column,$value_to_check)
  {
    $statement  = "SELECT * FROM $table_name WHERE $db_column ='$value_to_check'";
    return $statement;
  } 
      
  


            
   function single_update($table_name,$db_column_update,$update_value,$where_identifier_column,$where_identifier_value)
   {
    $statement = "UPDATE $table_name SET $db_column_update = '$update_value' WHERE $where_identifier_column = '$where_identifier_value'";
    return $statement;
   }
   
   
   
   
    function delete($table_name,$column,$value_to_check)
     {
      $statement = "DELETE FROM $table_name WHERE $column = '$value_to_check'";  
      return $statement;   
     }   
       
   
    
    function insert($table_name,$column_names,$insert_values)
    {
    $statement = "INSERT INTO $table_name ($column_names) VALUES ($insert_values)";
    return $statement;   
    }
    
    
    function multiple_update($table_name,$update_values,$where_column_to_check,$where_column_value)
    {
    $statement = "UPDATE $table_name SET $update_values WHERE $where_column_to_check = '$where_column_value'";
    return $statement;   
    }
    
    
    function select_all($table_name)
    {
        $statement = "SELECT * FROM $table_name";
        return $statement;
    }


   
    
    
        

   
   function fetch_array($query_result){
    $row = mysqli_fetch_array($query_result,MYSQLI_BOTH);
    return$row;
   }
   

  
 
   
   
   function sql_num_rows($query){
    $num_rows = mysqli_num_rows($query);
    return$num_rows;
    
   }
    
    
    
 }


?>