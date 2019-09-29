<?php

/**
 * @author Mofehintolu MUMUNI for team Eurus
 * 
 * @description Sanitizer class that helps clean up user provided data
 * @slack @Bits_and_Bytes
 * @copyright 2019
 */

namespace src\helpers;

use src\helpers\Datetime;

class sanitizer extends Datetime{
    
        
    function sanitize_timestamp($number){
    if(strlen($number) == 10){
    $cleartag = strip_tags($number);
     
    if(ctype_digit($cleartag) == "TRUE"){
        
       if(preg_match("/^[0-9]{10}$/", $cleartag)) {
     return $cleartag;
    
     }
      else return null;
    
    }
   else return null;
   
     }
      else return null;
     
    }
        

    
    
    function strip($variable)
    {
        $clean_variable = strip_tags($variable);
        
        return $clean_variable;
    }


       
        function universal_name_sanitizer($number){
        if((strlen($number) <= 20) && (strlen($number) > 1)) {
        $new_string = strip_tags($number);
        if (preg_match("/^[a-zA-Z]{2,20}$/",$new_string)) {
        return $new_string;
        
         }
          else return null;
          }
          else return null;

       }
            
  
  
  
   function sanitize_email($old_string){      
    if($old_string <= 150)
    {
    $new_string = strip_tags($old_string);
            
    if (!filter_var($new_string, FILTER_VALIDATE_EMAIL)) 
    {
    return null;
    }
    elseif(filter_var($new_string, FILTER_VALIDATE_EMAIL)){
    $check = explode("@", "$new_string");
    $check_dns = checkdnsrr("$check[1]", "ANY");
    if ($check_dns) {
        return $new_string;
      }
      else return null;
    }
    
    }
    else return null;
    
     }
     
     
     
     
     
     
   /*function sanitize_email($old_string){      
    if($old_string <= 150)
    {
    $new_string = strip_tags($old_string);
            
    if (!filter_var($new_string, FILTER_VALIDATE_EMAIL)) 
    {
    return null;
    }
    elseif(filter_var($new_string, FILTER_VALIDATE_EMAIL)){
    $check = explode("@", "$new_string");
    return $new_string;
    }
    
    }
    else return null;
    
     }
     */
     

     
    function sanitize_description($string){
        $new_string = strip_tags($string);
        $string_length = strlen($new_string);
        if(($string_length>1) &&($string_length<=2000)){
            if(preg_match("/^[a-zA-Z0-9_,.!?&() ]{1,2000}$/",$new_string)){
                
                return $new_string;
                
            }
            else{
                
                return null;
            }
            
            
        }
        
        }
     
  
        function sanitize_price($number){
    
          if((strlen($number) > 0) && (strlen($number) <= 20)){
                 
             $cleartag = strip_tags($number);
    
                if(preg_match("/^[0-9]{1,20}$/", $cleartag)) {
              return $cleartag;
             
              }
               else return null;
           
            }else 
               {
                 return null;
               }
              
             }
             


        function sanitize_date($string){
            $new_string = strip_tags($string);
            $string_length = strlen($new_string);
            if(($string_length>0) && ($string_length<=10)){
                
                $string_array = explode("/",$new_string);

                $array_count = count($string_array);
                if($array_count==3){
                    //month
                  if(preg_match("/^[0-9]{1,2}$/",$string_array[0])){
                    
                    //day
                    if(preg_match("/^[0-9]{1,2}$/",$string_array[1])){
                    
                        //year
                    if(preg_match("/^[0-9]{1,4}$/",$string_array[2])){
                    
                    return $new_string; 
                    
                     
                  }
                       
                   else{
                    return null;
                }
                    
                   
                  }
                       
                   else{
                    return null;
                }
                    }
                       
                   else{
                    return null;
                }
  
                }
                else{
                    return null;
                }

            }
            else{
                    return null;
                }
            
            }
        

                
                 
    function sanitize_password($old_string) {
    $new_string = strip_tags($old_string);
    $length = strlen($new_string);
    if(($length <= 20) && ($length > 1)){
        if (preg_match("/^(?=[^\s]*?[0-9])(?=[^\s]*?[a-zA-Z])[a-zA-Z0-9]*$/", $new_string)) {
    return $new_string;
    }
    else return null;
    }
    else return null;
    
    }
    
    
    //Password hashing function
    
    function hash_password($password){
    $options = [
    'cost' => 12,
    ];
    
    $passwordhash = password_hash($password, PASSWORD_BCRYPT, $options);
    return $passwordhash;
        
    }
    
    
    function verify_password($user_password, $passwordhash){
        
        $boolean = password_verify($user_password, $passwordhash);
        if($boolean == "TRUE"){
            $match = 'true';
            return $match;
        }
        else{
            $match = 'false';
            return $match;
        }
        
    }
       
        
    function trim_white_spaces_and_capitalize_firstletter_of_a_string($string){
        $string = strtolower($string);
        $trimmed_string = trim($string);
        $capitalize_first_letters = ucwords($trimmed_string);
        return $capitalize_first_letters;
    }
    
    
    
     function trim_white_spaces_and_capitalize_firstletters_of_a_word($string){
        $string = strtolower($string);
        $trimmed_string = trim($string);
        $capitalize_first_letters = ucfirst($trimmed_string);
        return $capitalize_first_letters;
    }
    
    
    function sanitize_32_character_id($id_to_check){
            $id = strip_tags($id_to_check);
            $length_of_id = strlen($id);
            if($length_of_id == 32){
            if (preg_match("/^(?=[^\s]*?[0-9])(?=[^\s]*?[a-zA-Z])[a-zA-Z0-9]*$/", $id)){
                    
                    return $id;
                
                }
                else{
                    return null;
                }
                
            }
            else{
                return null;
            }
            
            }
        
        
        
       
        function convert_registration_date_to_words($registration_date){
        $new_reg_date = $registration_date;
        
        $timestamp = strtotime($new_reg_date);
        
        $array_time = getdate($timestamp);
        $day = $array_time['mday'];
        $date_string = "You joined Devpoint on ".$array_time['weekday'].". ".$array_time['month']." ".$day.",  ".$array_time['year'].". Thank you for your patronage";

        return $date_string;
    
        }
    
   
   
    function reorganize_date($date)
    {
      $date_array = explode("/",$date);  
      
      $new_date = $date_array[1]."-".$date_array[0]."-".$date_array[2];
      
      return $new_date;
    }
    
    
    
    function toLowercase($variable)
    {
        $variable = strtolower($variable);
        
        return $variable;
    }
   
    function format_number($number){
        
        $formatted_number = number_format($number);
        return $formatted_number;
    }

       function replace_string($search_value,$replace_value,$original_string)
       {
        $string = str_replace($search_value,$replace_value,$original_string);
        return $string;
       }

         function round_up(float $float_val)
         {
            $float_val = ceil($float_val);
            return $float_val;
         }
         
          function round_down(float $float_val)
         {
            $float_val = floor($float_val);
            return $float_val;
         }
         

    
     }



?>