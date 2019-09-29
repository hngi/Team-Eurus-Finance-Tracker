<?php


/**
 * @author Mofehintolu MUMUNI for team Eurus
 * 
 * @description Expenses controller that handles Expenses
 * @slack @Bits_and_Bytes
 * @copyright 2019
 */



//namespace src\Controllers;

use src\Sql\SqlQuery;

class ExpensesController extends SqlQuery{
    
    
    
    private $host = "localhost";
    private $username = "root";
    private $password = "";
    private $database = "eurusfinance";
    private $Link;
    private $table = "expenses";
    
    /*THE CODE BELOW CONSISTS OF ALL THE
    *NECESSARY FUNCTIONS NEEDED FOR 
    *ExpensesController CLASS
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
     * @params $user_id
     * 
     * 
     * 
     * */
    
    function monthlyExpenses($user_id = null)
    {
       
        $currentTimestamp = time();
        $currentDate = $this->get_present_date($currentTimestamp);
        $Month = explode("-",$currentDate)[1];
        $Year = explode("-",$currentDate)[2];
        
        
         $userExpensesArray = [];
         $expensesAmount = 0;
        
        //Hit database and get user expense data based on monhth and year
        $table_name = $this->table;
        $constraints = "user_id = '$user_id' AND month = $Month AND year = $Year ORDER BY rowid ASC";
        
        $selectDBValues = $this->select_multiple_where_constraints($table_name,$constraints);
        $query = $this->query($selectDBValues);
            
            if($query)
            {
                while($row = $this->fetch_array($query))
                {
                    $item = $row['item'];
                    $description = $row['description'];
                    $amount = $row['amount'];
                    $date = $row['date'];
                    $day = $row['day'];
                    $month = $row['month'];
                    $year = $row['year'];
                    
                    $userExpensesArray[] = ["ITEM"=>$item,"DESCRIPTION"=>$description,"AMOUNT"=>$amount,"DATE" => $date, "DAY"=> $day,"MONTH"=>$month,"YEAR"=>$year];
                }
                
                //continue computation
                if(!(sizeof($userExpensesArray) === 0))
                {
                    $computationAmount = $this->computeExpense($userExpensesArray);
                    $expensesAmount = $computationAmount;
                    
                    return [["STATUS"=> "SUCCESS", "TOTAL_EXPENSES" => $expensesAmount,"USER_DATA"=>$userExpensesArray]];
            
                }
                else
                {
                    return [["STATUS"=> "ERROR", "TOTAL_EXPENSES" => null,"USER_DATA"=>null]];
        
                }
                
        
            }
            else{
                 return [["STATUS"=> "ERROR", "TOTAL_EXPENSES" => null,"USER_DATA"=>null]];
        
            }
        
        
    }
    
    
    
    
    /**
     * 
     * @params $user_id may or may not be given
     * 
     * 
     * @return array []
     * 
     * */
    
    function weeklyExpenses($user_id = null)
    { 
       
        $currentTimestamp = time();
       
        $currentDate = $this->get_present_date($currentTimestamp);
        $dayOfTheWeek = $this->get_day_of_week('timestamp',$currentTimestamp);
        
        $startDate = '';
        $endDate = $currentDate;
        
        //switch error checker
        $switch_error_array = [];
        
        switch($dayOfTheWeek)
        {
            case 'Sunday': 
            $subDays = 0;
            $startDate = $this->get_present_date($this->subtractDays($currentDate,$subDays));
            
            break;
            
            case 'Monday': 
            $subDays = 1;
            $startDate = $this->get_present_date($this->subtractDays($currentDate,$subDays));
            
            break;
            
            case 'Tuesday': 
            $subDays = 2;
            $startDate = $this->get_present_date($this->subtractDays($currentDate,$subDays));
            
            break;
            
            case 'Wednesday': 
            $subDays = 3;
            $startDate = $this->get_present_date($this->subtractDays($currentDate,$subDays));
            
            break;
            
            case 'Thursday': 
            $subDays = 4;
            $startDate = $this->get_present_date($this->subtractDays($currentDate,$subDays));
            
            break;
            
            case 'Friday':
            $subDays = 5;
            $startDate = $this->get_present_date($this->subtractDays($currentDate,$subDays));
            
            break;
            
            case 'Saturday':
            $subDays = 6;
            $startDate = $this->get_present_date($this->subtractDays($currentDate,$subDays));
            
            break;
            
            default : $switch_error_array[] = 'error';
        }
        
        
        
        if(sizeof($switch_error_array) > 0)
        {
            return [["STATUS"=> "ERROR", "TOTAL_EXPENSES" => null,"USER_DATA"=>null]];
        }
        
        
        //check start and end dates if they are in the same month and year for sql query selection
        $startDateMonth = explode("-",$startDate)[1];
        $startDateYear = explode("-",$startDate)[2];
        
        $endDateMonth = explode("-",$endDate)[1];
        $endDateYear = explode("-",$endDate)[2];
        
        //user expenses array to hold user data
        $userExpensesArray = [];
        
        
        
        if(($startDateMonth === $endDateMonth) && ($startDateYear === $endDateYear))
        {
            
         $yearSelect = $startDateYear;
         $monthSelect = $startDateMonth;
         
          //get details from db and use for computation
            $table_name = $this->table;
            $constraints = "user_id = '$user_id' AND month = $monthSelect AND year = $yearSelect ORDER BY rowid ASC";
            
            $selectDBValues = $this->select_multiple_where_constraints($table_name,$constraints);
            $query = $this->query($selectDBValues);
            
            //check if query waas executed
            if($query)
            {
                while($row = $this->fetch_array($query))
                {
                    $item = $row['item'];
                    $description = $row['description'];
                    $amount = $row['amount'];
                    $date = $row['date'];
                    $day = $row['day'];
                    $month = $row['month'];
                    $year = $row['year'];
                    
                    $userExpensesArray[] = ["ITEM"=>$item,"DESCRIPTION"=>$description,"AMOUNT"=>$amount,"DATE" => $date, "DAY"=> $day,"MONTH"=>$month,"YEAR"=>$year];
                }
                
                
            }
            else{
                 return [["STATUS"=> "ERROR", "TOTAL_EXPENSES" => null,"USER_DATA"=>null]];
            }
         
        }
        else
        {
            
         if(($startDateMonth != $endDateMonth) || ($startDateYear != $endDateYear))
        {
            $firstMonth = $startDateMonth;
            $firstYear = $startDateYear;
            
            $secondMonth = $endDateMonth;
            $secondtYear = $endDateYear;
            
            //get details from db and use for computation
            $table_name = $this->table;
            $constraints = "user_id = '$user_id' AND month BETWEEN $firstMonth AND $secondMonth AND year BETWEEN $firstYear AND $secondtYear ORDER BY rowid ASC";
            
            $selectDBValues = $this->select_multiple_where_between_constraints($table_name,$constraints);
            $Secondquery = $this->query($selectDBValues);
            
            if($Secondquery)
            {
                while($row = $this->fetch_array($Secondquery))
                {
                    $item = $row['item'];
                    $description = $row['description'];
                    $amount = $row['amount'];
                    $date = $row['date'];
                    $day = $row['day'];
                    $month = $row['month'];
                    $year = $row['year'];
                    
                    $userExpensesArray[] = ["ITEM"=>$item,"DESCRIPTION"=>$description,"AMOUNT"=>$amount,"DATE" => $date, "DAY"=> $day,"MONTH"=>$month,"YEAR"=>$year];
                }
                
               
            }
            else{
                return [["STATUS"=> "ERROR", "TOTAL_EXPENSES" => null,"USER_DATA"=>null]];
            }
            
        } 
        
        }
        
 
        //continue computation using core computation algorithm
        $computationFeedback = $this->expenseComputationAlgorithm($startDate,$endDate,$userExpensesArray);
       
        return $computationFeedback;
        
    }
    
    
    
    /**
     * 
     * @params $user_id
     * 
     * 
     * */
    
    function yearlyExpenses($user_id = null)
    {
        
        $currentTimestamp = time();
        $currentDate = $this->get_present_date($currentTimestamp);
        $Month = explode("-",$currentDate)[1];
        $Year = explode("-",$currentDate)[2];
        
        
         $userExpensesArray = [];
         $expensesAmount = 0;
        
        //Hit database and get user expense data based on monhth and year
        $table_name = $this->table;
        $constraints = "user_id = '$user_id' AND year = $Year ORDER BY rowid ASC";
        
        $selectDBValues = $this->select_multiple_where_constraints($table_name,$constraints);
        $query = $this->query($selectDBValues);
            
            if($query)
            {
                while($row = $this->fetch_array($query))
                {
                    $item = $row['item'];
                    $description = $row['description'];
                    $amount = $row['amount'];
                    $date = $row['date'];
                    $day = $row['day'];
                    $month = $row['month'];
                    $year = $row['year'];
                    
                    $userExpensesArray[] = ["ITEM"=>$item,"DESCRIPTION"=>$description,"AMOUNT"=>$amount,"DATE" => $date, "DAY"=> $day,"MONTH"=>$month,"YEAR"=>$year];
                }
                
                //continue computation
                if(!(sizeof($userExpensesArray) === 0))
                {
                    $computationAmount = $this->computeExpense($userExpensesArray);
                    $expensesAmount = $computationAmount;
                    
                    return [["STATUS"=> "SUCCESS", "TOTAL_EXPENSES" => $expensesAmount,"USER_DATA"=>$userExpensesArray]];
            
                }
                else
                {
                    return [["STATUS"=> "ERROR", "TOTAL_EXPENSES" => null,"USER_DATA"=>null]];
        
                }
                
        
            }
            else{
                 return [["STATUS"=> "ERROR", "TOTAL_EXPENSES" => null,"USER_DATA"=>null]];
        
            }
    }
    
   



        

    function computeExpense($userExpensesArray,$check_date = null)
    {
        if($check_date != null)
        {
            $expenseAmount = 0;
            $userDataArray = [];

            //pass varibales to array using pointers &$expenseAmount,&$userDataArray
            //so it can be visible inside the closure

            $dateExpenseArray = [$check_date,&$expenseAmount,&$userDataArray];
            array_map(function($userExpenseRowArray) use ($dateExpenseArray)
            {
                $check_date = $dateExpenseArray[0];
     
                if($userExpenseRowArray['DATE'] == $check_date)
                {
                   $dateExpenseArray[1] += $userExpenseRowArray['AMOUNT'];
                   $dateExpenseArray[2][] = $userExpenseRowArray;

                }
            },$userExpensesArray);
            
            return [$expenseAmount,$userDataArray];
        }
        else
        {
            $expenseAmount = 0;
            //pass varibales to array using pointers &$expenseAmount
            //so it can be visible inside the closure
            $dateExpenseArray = [&$expenseAmount];
            array_map(function($userExpenseRowArray) use ($dateExpenseArray)
            {
               
               $dateExpenseArray[0] += $userExpenseRowArray['AMOUNT'];
                  
                
            },$userExpensesArray);
            
            return $expenseAmount;
        }
    
    
    }

    
    /**
     * @params $startDate
     * @params $endDate
     * 
     * @params $userExpensesArray
     * 
     * @retruns array[]
     * 
     * **/

  function expenseComputationAlgorithm($startDate,$endDate,$userExpensesArray)
    {
   
    $daysBetweenStartAndEndDate = $this->number_of_days_between_dates($startDate,$endDate);
   
    
    $from_date = $startDate;
    
    $to_date = $endDate;
    

    $first_date_array = explode("-",$from_date);
    
    
    $second_date_array = explode("-",$to_date);
    
    $first_day = $first_date_array[0];
    $first_month = $first_date_array[1];
    $first_year = $first_date_array[2];
    
    $start_date_month_days_number = $this->get_days_in_month(strtotime($from_date));
    
    $second_day = $second_date_array[0];
    $second_month = $second_date_array[1];
    $second_year = $second_date_array[2];
    
    $end_date_month_days_number = $this->get_days_in_month(strtotime($to_date));
     
     

    $start = 0;
    
    $loop_day = $first_day;
    $loop_month = $first_month;
    $loop_year = $first_year;
    
    $month_date_days = $start_date_month_days_number;
    
    $end = $daysBetweenStartAndEndDate;
    
    //state grand user records array
    $grand_user_records_array = [];
    
    //esthablish user expenses holding array
     $user_expenses_array = [];
     
     $userDataArray = [];

    
            while($start <= $end)
            {
                if($start == 0)
                {
                  if($loop_day <= $month_date_days)
                  {
             
              $check_date = $loop_day."-".$loop_month."-".$loop_year;
              
              $computationReturnArray = $this->computeExpense($userExpensesArray,$check_date);
              
               if(count($computationReturnArray[1]) > 0)
              {
              $user_expenses_array[] = $computationReturnArray[0];
              
              $userDataArray[] = $computationReturnArray[1];
              }
           
              
                  } 
                }
                else
                {
                    $loop_day = $loop_day + 1;
                    
                   if($loop_day <= $month_date_days)
                  {
               
               $check_date = $loop_day."-".$loop_month."-".$loop_year;
              
              $computationReturnArray = $this->computeExpense($userExpensesArray,$check_date);
              
              if(count($computationReturnArray[1]) > 0)
              {
              $user_expenses_array[] = $computationReturnArray[0];
              
              $userDataArray[] = $computationReturnArray[1];
              }
              
             
            
          
                  }
                  else
                  {
                    
                    
                    $loop_day = 1;
                    $loop_month = $second_month;
                    $loop_year = $second_year;
                    
                   $month_date_days = $end_date_month_days_number;
                   //$month_date_days = $second_day;
                   
                 if($loop_day <= $month_date_days)
                  {
                 
                    $check_date = $loop_day."-".$loop_month."-".$loop_year;
              
                    $computationReturnArray = $this->computeExpense($userExpensesArray,$check_date);
                    
                   if(count($computationReturnArray[1]) > 0)
              {
              $user_expenses_array[] = $computationReturnArray[0];
              
              $userDataArray[] = $computationReturnArray[1];
              }
                  
                    }
                    
                  }
                    
                    
                }
                
                $start++;
            }
            
          
          
            //get $totalExpenses
           
           $totalExpenses = array_sum($user_expenses_array);
           
           $grand_user_records_array[] = ["STATUS" => "SUCCESS", "TOTAL_EXPENSES"=>$totalExpenses,'USER_DATA'=>$userDataArray];
           
           return $grand_user_records_array;
              
        }   


   
        function addExpense($description,$amount,$item,$user_id)
        {
           
            $amount = $this->sanitize_price($amount);
            $description = $this->sanitize_description( $description);
            $item = $this->sanitize_description($item);
            
            if(($amount != null) && ($description != null) && ($item != null))
            {
            $currentTimestamp = time();
            $date_start = $this->get_present_date($currentTimestamp);

            $amount = $this->sql_escape_string($amount);
            $description = $this->sql_escape_string($description);
            $item = $this->sql_escape_string($item);
            $date_start = $this->sql_escape_string($date_start);


            $day = explode("-",$date_start)[0];
            $month = explode("-",$date_start)[1];
            $year = explode("-",$date_start)[2];
            

            $table_name = $this->table;
        
            $columns = "user_id, 
                      item,
                      description,
                      amount,
                      date,
                      day,
                      month,
                      year";

            
            $values ="'$user_id',
                        '$item',
                        '$description',
                        '$amount',
                        '$date_start',
                        '$day',
                        '$month',
                        '$year'";
            
            $insertStatement = $this->insert($table_name,$columns,$values);
            $query = $this->query($insertStatement);
            
            if($query)
            {
               // $expenditureArray = ["ITEM"=>$item,"AMOUNT"=> $this->format_number($amount), "DESCRIPTION"=>$date_start,"DATE"=>$date_start];
               // return ["STATUS"=>"SUCCESS","PAYLOAD"=>$expenditureArray];
                echo "<i style='color: green; text-align: center; background-color: #EAF9EA;'>Expenditure saved successfully!</i>";
          
            }
            else {
                $returnString = "";

                $returnString .=  "Expenditure not stored successfully, network error </br>";
               // return ["STATUS"=>"ERROR","PAYLOAD"=>$returnString];
               echo "<i style='color: red; text-align: center; background-color: #EAF9EA;'>".$returnString."</i>";
          
            }
            
            
          
           
            }
            else {
                $returnString = "Error </br>";

      
                if($item == null)
                {
                    $returnString .=  "Provide an item to add to expenditure list</br>";
                   
                   
                }

                if($amount == null)
                {
                    $returnString .= "Amount cannot be left blank </br>";
              
                }

                if($description == null)
                {
                    $returnString .= "Description cannot be left empty </br>";
                }



                //return ["STATUS"=>"ERROR","PAYLOAD"=>$returnString];
                echo "<i style='color: red; text-align: center; background-color: #EAF9EA;'>".$returnString."</i>";
          
        
            }





        }
                








        function addExpenseOld($description,$date_start,$amount,$item,$user_id)
        {
           
            $amount = $this->sanitize_price($amount);
            $description = $this->sanitize_description( $description);
            $item = $this->sanitize_description($item);
            $date_start = $this->sanitize_date($date_start);
 
            if(($amount != null) && ($description != null) && ($item != null) && ($date_start != null))
            {
           
            $dateValidator = $this->check_valid_date_past($this->reformat_date_needed_to_day_month_year($date_start));

            if($dateValidator != "false")
            {

            $amount = $this->sql_escape_string($amount);
            $description = $this->sql_escape_string( $description);
            $item = $this->sql_escape_string($item);
            $date_start = $this->sql_escape_string($date_start);



            $day = explode("-",$date_start)[0];
            $month = explode("-",$date_start)[1];
            $year = explode("-",$date_start)[2];
            

            $table_name = $this->table;
        
            $columns = "user_id, 
                      item,
                      description,
                      amount,
                      date,
                      day,
                      month,
                      year";

            
            $values ="'$user_id',
                        '$item',
                        '$description',
                        '$amount',
                        '$date_start',
                        '$day',
                        '$month',
                        '$year'";
            
            $insertStatement = $this->insert($table_name,$columns,$values);
            $query = $this->query($insertStatement);
            
            if($query)
            {
                $expenditureArray = ["ITEM"=>$item,"AMOUNT"=> $this->format_number($amount), "DESCRIPTION"=>$date_start,"DATE"=>$date_start];
                return ["STATUS"=>"SUCCESS","PAYLOAD"=>$expenditureArray];

            }
            else {
                $returnString = "";

                $returnString .=  "Expenditure not stored successfully, network error </br>";
                return ["STATUS"=>"ERROR","PAYLOAD"=>$returnString];
            }
            
            
            }
            {
                $returnString = "Error </br>";

                    $returnString .=  "Date must be present or past, not future </br>";
                    return ["STATUS"=>"ERROR","PAYLOAD"=>$returnString];
            }
           
            }
            else {
                $returnString = "Error </br>";

      
                if($item == null)
                {
                    $returnString .=  "Provide an item to add to expenditure list</br>";
                   
                   
                }

                if($amount == null)
                {
                    $returnString .= "Amount cannot be left blank </br>";
              
                }

                if($description == null)
                {
                    $returnString .= "Description cannot be left empty </br>";
                }


                if($date_start == null)
                {
                    $returnString .= "Select a valid date from calender </br>";
              
                }


                return ["STATUS"=>"ERROR","PAYLOAD"=>$returnString];
        
            }





        }
                     

    
    
    
    
    }


?>