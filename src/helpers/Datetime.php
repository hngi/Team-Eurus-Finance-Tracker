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
    if($type == "timesatmp")
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



    
    
 }


?>