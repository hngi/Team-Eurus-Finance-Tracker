<?php

/**
 * @author Mofehintolu MUMUNI for team Eurus
 * 
 * @description Datetime class that helps provide datetime functionality
 * @slack @Bits_and_Bytes
 * @copyright 2019
 */


namespace src\helpers;


class Datetime{
    
    
    
     /**
     * Subtract days from given date and return timestamp
     * 
     * @params $date
     * 
     * @params $number_of_days
     * 
     * @retuns timestamp
     * 
     * 
     **/

    function subtractDays($date,$number_of_days)
    {
        $presentDateTimestamp = strtotime($date);
        
        $pastDateTimestamp = $presentDateTimestamp - ($number_of_days*(60*60*24));
        
        return $pastDateTimestamp;
       
    }
    
    /**
     * Add days to given date and return timestamp
     * 
     * @params $date
     * 
     * @params $number_of_days
     * 
     * @retuns timestamp
     * 
     * 
     **/
    function addDays($date,$number_of_days)
    {
        $presentDateTimestamp = strtotime($date);
        
        $futureDateTimestamp = $presentDateTimestamp + ($number_of_days*(60*60*24));
        
        return $futureDateTimestamp;
    }
    
    function registration_date($timestamp){
    $array = getdate($timestamp);
    $reg_date = $array['mday']."-".$array['mon']."-".$array['year'];
    return $reg_date;
    }
    
    
    
    
    function get_present_date($timestamp){
        $array = getdate($timestamp);
        $reg_date = $array['mday']."-".$array['mon']."-".$array['year'];
        return $reg_date;
    }
    
   
     function reformat_date_needed_to_day_month_year($date_needed){
        $date = explode("/", $date_needed);
        
        //format date to month/day/year format
        $new_date = $date[2]."-".$date[1]."-".$date[0];
 
        return $new_date;
        
    }
    
    
    function reformat_date_needed_to_year_month_day($date_needed){
        $date = explode("-", $date_needed);
        
        //format date to month/day/year format
        $new_date = $date[2]."/".$date[1]."/".$date[0];
 
        return $new_date;
        
    }
    
    
    function get_day_of_week($type,$value)
    {
    if($type == "timestamp")
    {
       $day_of_week = date('l',$value); 
        
    }
    
    if($type == "date")
    {
       $stamp = strtotime($value);
        
      $day_of_week = date('l',$stamp);   
        
    }   
      
      return $day_of_week;
        
    }
    
    


    function number_of_days_between_dates($start_date,$end_date)
        {
        $from_date = strtotime($start_date);
        $to_date = strtotime($end_date);
        
        $day_diff = $to_date - $from_date;
        $date_diff = floor($day_diff/(60*60*24));
        
        return $date_diff;
        }



        function get_days_in_month($timestamp)
        { 
          $days_in_month = date("t",$timestamp);
          
          return $days_in_month;
            
        }
    
    
    
     function check_valid_date_past($next_due_date_for_payment){
   
    $date_of_payment = date('j-n-Y');
    
    $payment_date = date_create($date_of_payment);
    $next_payment = date_create($next_due_date_for_payment);
    
    $diff = date_diff($payment_date,$next_payment);
    $difference_value = $diff->format("%R%a");
    $length_of_difference_value = strlen($difference_value);
    $value_without_arithmetic_operator = substr($difference_value,($length_of_difference_value-($length_of_difference_value-1)));
   
    
    if($difference_value <= 0)
    {
       $valid_attendance = "true";
       return $valid_attendance;
    }
    else
    {
      $valid_attendance = "false";
      return $valid_attendance;
    }
        
    }
    
    
    
 }


?>