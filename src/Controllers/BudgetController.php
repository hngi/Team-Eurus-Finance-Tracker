<?php


/**
 * @author Mofehintolu MUMUNI for feature submission
 * 
 * @description Budget Controller that handles Budgets
 * @slack @Bits_and_Bytes
 * @copyright 2019
 */



//namespace src\Controllers;

use src\Sql\SqlQuery;

class BudgetController extends SqlQuery{
    
    
    
    private $host = "localhost";
    private $username = "root";
    private $password = "";
    private $database = "eurusfinance";
    private $Link;
    private $table = "expenses";

    private $budgets_table = "budgets";
    
    /*THE CODE BELOW CONSISTS OF ALL THE
    *NECESSARY FUNCTIONS NEEDED FOR 
    *BudgetController CLASS
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
   
    


     


     function checkWeeklyBudget($user_id)
     {
        $weeklyBudgetResponseArray = $this->getWeeklyBudgetAmount($user_id);

        if(is_array($weeklyBudgetResponseArray))
        {
            if($weeklyBudgetResponseArray['STATUS'] === 'SUCCESS')
            {
                $amount = $weeklyBudgetResponseArray['DATA']['AMOUNT'];
                $startDate = $weeklyBudgetResponseArray['DATA']['START_DATE'];
                $endDate = $weeklyBudgetResponseArray['DATA']['END_DATE'];

                //fire general weekly computation algorithm
                $weeklyExpensesArray = $this->weeklyExpenses($user_id);
                if($weeklyExpensesArray[0]['STATUS'] === 'SUCCESS')
                {
                    $totalWeeklyExpense = $weeklyExpensesArray[0]['TOTAL_EXPENSES'];
                   
                    if($amount > $totalWeeklyExpense)
                    {
                        $stateAmount = $amount - $totalWeeklyExpense;
                        $string = "<i style='color: green; text-align: center; background-color: #EAF9EA;'>You are within your weekly budget limit of ₦".$this->format_number($amount).".00 , you have ₦".$this->format_number($stateAmount).".00 left to spend on your budget. </i>";
                        
                        $weeklyExpensesArray[0]['BUDGET_AMOUNT'] = $amount;
                        $weeklyExpensesArray[0]['BUDGET_STRING'] = $string;
                        $weeklyExpensesArray[0]['WEEK_START'] = $startDate;
                        $weeklyExpensesArray[0]['WEEK_END'] = $endDate;

                        return $weeklyExpensesArray;
                    }
                     

                    if($amount === $totalWeeklyExpense)
                    {
                        $stateAmount = $amount - $totalWeeklyExpense;
                        $string = "<i style='color: green; text-align: center; background-color: #EAF9EA;'>You equalled your weekly budget limit of ₦".$this->format_number($amount).".00 , you have ₦".$this->format_number($stateAmount).".00 left to spend on your budget. </i>";
                        
                        $weeklyExpensesArray[0]['BUDGET_AMOUNT'] = $amount;
                        $weeklyExpensesArray[0]['BUDGET_STRING'] = $string;
                        $weeklyExpensesArray[0]['WEEK_START'] = $startDate;
                        $weeklyExpensesArray[0]['WEEK_END'] = $endDate;

                        return $weeklyExpensesArray;
                   
                    }


                    if($amount < $totalWeeklyExpense)
                    {
                        $stateAmount = $totalWeeklyExpense - $amount;
                        $string = "<i style='color: red; text-align: center; background-color: #EAF9EA;'>You exceeded your weekly budget limit of ₦".$this->format_number($amount).".00 , by ₦".$this->format_number($stateAmount).".00 </i>";
                   
                        $weeklyExpensesArray[0]['BUDGET_AMOUNT'] = $amount;
                        $weeklyExpensesArray[0]['BUDGET_STRING'] = $string;
                        $weeklyExpensesArray[0]['WEEK_START'] = $startDate;
                        $weeklyExpensesArray[0]['WEEK_END'] = $endDate;

                        return $weeklyExpensesArray;
                    
                    }


                }
                else
                {
                    return $weeklyExpensesArray;
                }


            }
            else
            {   //check value returned from initial function
                return [$weeklyBudgetResponseArray];
            }


        }
        else
        {   //check value returned from initial function
            return [["STATUS"=> "ERROR"]];
        }

     }


     function checkMonthlyBudget($user_id)
     {
        $monthlyBudgetResponseArray = $this->getMonthlyBudgetAmount($user_id);

        if(is_array($monthlyBudgetResponseArray))
        {
            if($monthlyBudgetResponseArray['STATUS'] === 'SUCCESS')
            {
                $amount = $monthlyBudgetResponseArray['DATA']['AMOUNT'];
                $month = $monthlyBudgetResponseArray['DATA']['MONTH'];
                $year = $monthlyBudgetResponseArray['DATA']['YEAR'];

                //fire general monthly computation algorithm
                $monthlyExpensesArray = $this->monthlyExpenses($user_id);
                if($monthlyExpensesArray[0]['STATUS'] === 'SUCCESS')
                {
                    $totalmonthlyExpense = $monthlyExpensesArray[0]['TOTAL_EXPENSES'];
                   
                    if($amount > $totalmonthlyExpense)
                    {
                        $stateAmount = $amount - $totalmonthlyExpense;
                        $string = "<i style='color: green; text-align: center; background-color: #EAF9EA;'>You are within your monthly budget limit of ₦".$this->format_number($amount).".00 , you have ₦".$this->format_number($stateAmount).".00 left to spend on your budget. </i>";
                        
                        $monthlyExpensesArray[0]['BUDGET_AMOUNT'] = $amount;
                        $monthlyExpensesArray[0]['BUDGET_STRING'] = $string;
                        $monthlyExpensesArray[0]['MONTH'] = $month;
                        $monthlyExpensesArray[0]['YEAR'] = $year;

                        return $monthlyExpensesArray;
                    }
                     

                    if($amount === $totalmonthlyExpense)
                    {
                        $stateAmount = $amount - $totalmonthlyExpense;
                        $string = "<i style='color: green; text-align: center; background-color: #EAF9EA;'>You equalled your monthly budget limit of ₦".$this->format_number($amount).".00 , you have ₦".$this->format_number($stateAmount).".00 left to spend on your budget. </i>";
                        
                        $monthlyExpensesArray[0]['BUDGET_AMOUNT'] = $amount;
                        $monthlyExpensesArray[0]['BUDGET_STRING'] = $string;
                        $monthlyExpensesArray[0]['MONTH'] = $month;
                        $monthlyExpensesArray[0]['YEAR'] = $year;

                        return $monthlyExpensesArray;
                   
                    }


                    if($amount < $totalmonthlyExpense)
                    {
                        $stateAmount = $totalmonthlyExpense - $amount;
                        $string = "<i style='color: red; text-align: center; background-color: #EAF9EA;'>You exceeded your monthly budget limit of ₦".$this->format_number($amount).".00 , by ₦".$this->format_number($stateAmount).".00 </i>";
                   
                        $monthlyExpensesArray[0]['BUDGET_AMOUNT'] = $amount;
                        $monthlyExpensesArray[0]['BUDGET_STRING'] = $string;
                        $monthlyExpensesArray[0]['MONTH'] = $month;
                        $monthlyExpensesArray[0]['YEAR'] = $year;

                        return $monthlyExpensesArray;
                    
                    }


                }
                else
                {
                    return $monthlyExpensesArray;
                }


            }
            else
            {
                return [$monthlyBudgetResponseArray];
            }


        }
        else
        {
            return [["STATUS"=> "ERROR"]];
        }
     }




     

     function checkYearlyBudget($user_id)
     {
        $yearlyBudgetResponseArray = $this->getYearlyBudgetAmount($user_id);

        if(is_array($yearlyBudgetResponseArray))
        {
            if($yearlyBudgetResponseArray['STATUS'] === 'SUCCESS')
            {
                $amount = $yearlyBudgetResponseArray['DATA']['AMOUNT'];
                $year = $yearlyBudgetResponseArray['DATA']['YEAR'];

                //fire general yearly computation algorithm
                $yearlyExpensesArray = $this->yearlyExpenses($user_id);
                if($yearlyExpensesArray[0]['STATUS'] === 'SUCCESS')
                {
                    $totalyearlyExpense = $yearlyExpensesArray[0]['TOTAL_EXPENSES'];
                   
                    if($amount > $totalyearlyExpense)
                    {
                        $stateAmount = $amount - $totalyearlyExpense;
                        $string = "<i style='color: green; text-align: center; background-color: #EAF9EA;'>You are within your yearly budget limit of ₦".$this->format_number($amount).".00 , you have ₦".$this->format_number($stateAmount).".00 left to spend on your budget. </i>";
                        
                        $yearlyExpensesArray[0]['BUDGET_AMOUNT'] = $amount;
                        $yearlyExpensesArray[0]['BUDGET_STRING'] = $string;
                        $yearlyExpensesArray[0]['YEAR'] = $year;

                        return $yearlyExpensesArray;
                    }
                     

                    if($amount === $totalyearlyExpense)
                    {
                        $stateAmount = $amount - $totalyearlyExpense;
                        $string = "<i style='color: green; text-align: center; background-color: #EAF9EA;'>You equalled your yearly budget limit of ₦".$this->format_number($amount).".00 , you have ₦".$this->format_number($stateAmount).".00 left to spend on your budget. </i>";
                        
                        $yearlyExpensesArray[0]['BUDGET_AMOUNT'] = $amount;
                        $yearlyExpensesArray[0]['BUDGET_STRING'] = $string;
                        $yearlyExpensesArray[0]['YEAR'] = $year;

                        return $yearlyExpensesArray;
                   
                    }


                    if($amount < $totalyearlyExpense)
                    {
                        $stateAmount = $totalyearlyExpense - $amount;
                        $string = "<i style='color: red; text-align: center; background-color: #EAF9EA;'>You exceeded your yearly budget limit of ₦".$this->format_number($amount).".00 , by ₦".$this->format_number($stateAmount).".00 </i>";
                   
                        $yearlyExpensesArray[0]['BUDGET_AMOUNT'] = $amount;
                        $yearlyExpensesArray[0]['BUDGET_STRING'] = $string;
                        $yearlyExpensesArray[0]['YEAR'] = $year;

                        return $yearlyExpensesArray;
                    
                    }


                }
                else
                {
                    return $yearlyExpensesArray;
                }


            }
            else
            {
                return [$yearlyBudgetResponseArray];
            }


        }
        else
        {
            return [["STATUS"=> "ERROR"]];
        }
     }








       /**
      * 
      * @param $user_id
      * 
      * @return response array
      *
      **/

     function getWeeklyBudgetAmount($user_id)
     {
        $currentTimestamp = time();
        $currentDate = $this->get_present_date($currentTimestamp);

        $dayOfTheWeek = $this->get_day_of_week('timestamp',$currentTimestamp);
            
        $startDate = '';
        $endDate = '';
        
        //switch error checker
        $switch_error_array = [];
        
        switch($dayOfTheWeek)
        {
            case 'Sunday': 
            $subDays = 0;
            $addDays = 6;
            $startDate = $this->get_present_date($this->subtractDays($currentDate,$subDays));
            $endDate = $this->get_present_date($this->addDays($currentDate,$addDays));
            
            break;
            
            case 'Monday': 
            $subDays = 1;
            $addDays = 5;
            $startDate = $this->get_present_date($this->subtractDays($currentDate,$subDays));
            $endDate = $this->get_present_date($this->addDays($currentDate,$addDays));
            
            break;
            
            case 'Tuesday': 
            $subDays = 2;
            $addDays = 4;
            $startDate = $this->get_present_date($this->subtractDays($currentDate,$subDays));
            $endDate = $this->get_present_date($this->addDays($currentDate,$addDays));
            
            break;
            
            case 'Wednesday': 
            $subDays = 3;
            $addDays = 3;
            $startDate = $this->get_present_date($this->subtractDays($currentDate,$subDays));
            $endDate = $this->get_present_date($this->addDays($currentDate,$addDays));
            
            break;
            
            case 'Thursday': 
            $subDays = 4;
            $addDays = 2;
            $startDate = $this->get_present_date($this->subtractDays($currentDate,$subDays));
            $endDate = $this->get_present_date($this->addDays($currentDate,$addDays));
            
            break;
            
            case 'Friday':
            $subDays = 5;
            $addDays = 1;
            $startDate = $this->get_present_date($this->subtractDays($currentDate,$subDays));
            $endDate = $this->get_present_date($this->addDays($currentDate,$addDays));
            
            break;
            
            case 'Saturday':
            $subDays = 6;
            $addDays = 0;
            $startDate = $this->get_present_date($this->subtractDays($currentDate,$subDays));
            $endDate = $this->get_present_date($this->addDays($currentDate,$addDays));
            
            break;
            
            default : $switch_error_array[] = 'error';
        }
        
        
        
        if(sizeof($switch_error_array) > 0)
        {
            return ['STATUS'=> 'ERROR'];
       
        }


        $table_name = $this->budgets_table;
        $constraints = "user_id = '$user_id' AND type = 'WEEKLY' AND weekly_start_date = '$startDate' AND weekly_end_date = '$endDate'";
        

        $selectDBValues = $this->select_multiple_where_constraints($table_name,$constraints);
        $checkQuery = $this->query($selectDBValues);

        $weeklyAmountArray = [];

        if($checkQuery)
        {
            if($this->sql_num_rows($checkQuery) === 1)
            {
                while($row = $this->fetch_array($checkQuery))
                {
                    $amount = $row['amount'];
                    $type = $row['type'];
                    $weekly_start_date = $row['weekly_start_date'];
                    $weekly_end_date = $row['weekly_end_date'];

                    $weeklyAmountArray = ['AMOUNT'=>$amount, 'TYPE'=>$type, 'START_DATE'=>$weekly_start_date,'END_DATE'=>$weekly_end_date];
                
                }


                return ['STATUS'=> 'SUCCESS', 'DATA'=> $weeklyAmountArray];

            }
            else
            {
               
                    $amount = 0;
                    $type = 'WEEKLY';
                    $weekly_start_date = $startDate;
                    $weekly_end_date = $endDate;

                    $weeklyAmountArray = ['AMOUNT'=>$amount, 'TYPE'=>$type, 'START_DATE'=>$weekly_start_date,'END_DATE'=>$weekly_end_date];


                return ['STATUS'=> 'SUCCESS', 'DATA'=> $weeklyAmountArray];
            }
        }
        else
        {
            return ['STATUS'=> 'ERROR'];
        }


     }



      /**
      * 
      * @param $user_id
      * 
      * @return response array
      *
      **/
     function getMonthlyBudgetAmount($user_id)
     {
        $currentTimestamp = time();
        $currentDate = $this->get_present_date($currentTimestamp);
        $currentMonth = explode("-",$currentDate)[1];
        $currentYear = explode("-",$currentDate)[2];

        $table_name = $this->budgets_table;
        $constraints = "user_id = '$user_id' AND type = 'MONTHLY' AND month = $currentMonth AND year = $currentYear";
        $selectDBValues = $this->select_multiple_where_constraints($table_name,$constraints);
        $checkQuery = $this->query($selectDBValues);

        $monthlyAmountArray = [];

        if($checkQuery)
        {
            if($this->sql_num_rows($checkQuery) === 1)
            {
                while($row = $this->fetch_array($checkQuery))
                {
                    $amount = $row['amount'];
                    $type = $row['type'];
                    $month = $row['month'];
                    $year = $row['year'];

                    $monthlyAmountArray = ['AMOUNT'=>$amount, 'TYPE'=>$type, 'MONTH'=>$month,'YEAR'=>$year];
                
                }


                return ['STATUS'=> 'SUCCESS', 'DATA'=> $monthlyAmountArray];

            }
            else
            {
               
                    $amount = 0;
                    $type = 'MONTHLY';
                    $month = $currentMonth;
                    $year = $currentYear;
                
                    $monthlyAmountArray = ['AMOUNT'=>$amount, 'TYPE'=>$type, 'MONTH'=>$month,'YEAR'=>$year];
               


                return ['STATUS'=> 'SUCCESS', 'DATA'=> $monthlyAmountArray];
            }
        }
        else
        {
            return ['STATUS'=> 'ERROR'];
        }


     }


       /**
      * 
      * @param $user_id
      * 
      * @return response array
      *
      **/
     function getYearlyBudgetAmount($user_id)
     {
        $currentTimestamp = time();
        $currentDate = $this->get_present_date($currentTimestamp);
       
        $currentYear = explode("-",$currentDate)[2];

        $table_name = $this->budgets_table;
        $constraints = "user_id = '$user_id' AND type = 'YEAR' AND year = $currentYear";
        $selectDBValues = $this->select_multiple_where_constraints($table_name,$constraints);
        $checkQuery = $this->query($selectDBValues);

        $yearlyAmountArray = [];

        if($checkQuery)
        {
            if($this->sql_num_rows($checkQuery) === 1)
            {
                while($row = $this->fetch_array($checkQuery))
                {
                    $amount = $row['amount'];
                    $type = $row['type'];
                    $year = $row['year'];

                    $yearlyAmountArray = ['AMOUNT'=>$amount, 'TYPE'=>$type,'YEAR'=>$year];
                
                }


                return ['STATUS'=> 'SUCCESS', 'DATA'=> $yearlyAmountArray];

            }
            else
            {
               
                    $amount = 0;
                    $type = 'YEAR';
                    $year = $currentYear;
                
                    $yearlyAmountArray = ['AMOUNT'=>$amount, 'TYPE'=>$type,'YEAR'=>$year];
               


                return ['STATUS'=> 'SUCCESS', 'DATA'=> $yearlyAmountArray];
            }
        }
        else
        {
            return ['STATUS'=> 'ERROR'];
        }
     }



     /**
      * 
      * @param $user_id
      * @param $amount
      * @param $type
      * 
      * @return response string
      *
      **/

     function setBudget($user_id,$amount,$type)
     {
         $amount = $this->sanitize_price($amount);
         $type = $this->sanitize_description($type);
        
         if(($type != null) && ($amount != null))
         {
            $currentTimestamp = time();
            $currentDate = $this->get_present_date($currentTimestamp);
            $amount = $this->sql_escape_string($amount);
            $currentMonth = explode("-",$currentDate)[1];
            $currentYear = explode("-",$currentDate)[2];


         if($type === 'WEEKLY')
         {
            $type = $this->sql_escape_string($type);

            $dayOfTheWeek = $this->get_day_of_week('timestamp',$currentTimestamp);
            
            $startDate = '';
            $endDate = '';
            
            //switch error checker
            $switch_error_array = [];
            
            switch($dayOfTheWeek)
            {
                case 'Sunday': 
                $subDays = 0;
                $addDays = 6;
                $startDate = $this->get_present_date($this->subtractDays($currentDate,$subDays));
                $endDate = $this->get_present_date($this->addDays($currentDate,$addDays));
                
                break;
                
                case 'Monday': 
                $subDays = 1;
                $addDays = 5;
                $startDate = $this->get_present_date($this->subtractDays($currentDate,$subDays));
                $endDate = $this->get_present_date($this->addDays($currentDate,$addDays));
                
                break;
                
                case 'Tuesday': 
                $subDays = 2;
                $addDays = 4;
                $startDate = $this->get_present_date($this->subtractDays($currentDate,$subDays));
                $endDate = $this->get_present_date($this->addDays($currentDate,$addDays));
                
                break;
                
                case 'Wednesday': 
                $subDays = 3;
                $addDays = 3;
                $startDate = $this->get_present_date($this->subtractDays($currentDate,$subDays));
                $endDate = $this->get_present_date($this->addDays($currentDate,$addDays));
                
                break;
                
                case 'Thursday': 
                $subDays = 4;
                $addDays = 2;
                $startDate = $this->get_present_date($this->subtractDays($currentDate,$subDays));
                $endDate = $this->get_present_date($this->addDays($currentDate,$addDays));
                
                break;
                
                case 'Friday':
                $subDays = 5;
                $addDays = 1;
                $startDate = $this->get_present_date($this->subtractDays($currentDate,$subDays));
                $endDate = $this->get_present_date($this->addDays($currentDate,$addDays));
                
                break;
                
                case 'Saturday':
                $subDays = 6;
                $addDays = 0;
                $startDate = $this->get_present_date($this->subtractDays($currentDate,$subDays));
                $endDate = $this->get_present_date($this->addDays($currentDate,$addDays));
                
                break;
                
                default : $switch_error_array[] = 'error';
            }
            
            
            
            if(sizeof($switch_error_array) > 0)
            {
                $returnString = "";
    
                $returnString .=  "Weekly budget amount not stored successfully, network error! </br>";
                // return ["STATUS"=>"ERROR","PAYLOAD"=>$returnString];
                echo "<i style='color: red; text-align: center; background-color: #EAF9EA;'>".$returnString."</i>";
           
            }


            $table_name = $this->budgets_table;
            $constraints = "user_id = '$user_id' AND type = 'WEEKLY' AND weekly_start_date = '$startDate' AND weekly_end_date = '$endDate'";
            $type = $this->sql_escape_string($type);

            $selectDBValues = $this->select_multiple_where_constraints($table_name,$constraints);
            $checkQuery = $this->query($selectDBValues);

            if($checkQuery)
            {

                if($this->sql_num_rows($checkQuery) === 1)
                {
                    //update records
                    $table_name = $this->budgets_table;
                    $update_values = "amount = $amount";
                    $constraints = "user_id = '$user_id' AND type = 'WEEKLY' AND weekly_start_date = '$startDate' AND weekly_end_date = '$endDate'";

                    $weeklyUpdateStatement = $this->multiple_update($table_name,$update_values,$constraints);
                    $weeklyUpdateQuery = $this->query($weeklyUpdateStatement);

                    if($weeklyUpdateQuery)
                    {
                        $returnString = "";
    
                        $returnString .=  "Weekly budget amount updated successfully</br>";
                        // return ["STATUS"=>"ERROR","PAYLOAD"=>$returnString];
                        echo "<i style='color: green; text-align: center; background-color: #EAF9EA;'>".$returnString."</i>";
                   
                    }
                    else
                    {
                        $returnString = "";
    
                        $returnString .=  "Weekly budget amount not updated successfully, network error! </br>";
                        // return ["STATUS"=>"ERROR","PAYLOAD"=>$returnString];
                        echo "<i style='color: red; text-align: center; background-color: #EAF9EA;'>".$returnString."</i>";
                    }

                }

                if($this->sql_num_rows($checkQuery) === 0)
                {
                    //insert records
                    $table_name = $this->budgets_table;;
     
                    $columns = "user_id, 
                                amount,
                                type,
                                weekly_start_date,
                                weekly_end_date,
                                month,
                                year";
                           
                    
                    $values ="'$user_id',
                                '$amount',
                                '$type',
                                '$startDate',
                                '$endDate',
                                'null',
                                'null'";
                    
                    $insertStatement = $this->insert($table_name,$columns,$values);
                    $insertQuery = $this->query($insertStatement);

                    if($insertQuery)
                    {
                        $returnString = "";
    
                        $returnString .=  "Weekly budget amount stored successfully.</br>";
                        // return ["STATUS"=>"ERROR","PAYLOAD"=>$returnString];
                        echo "<i style='color: green; text-align: center; background-color: #EAF9EA;'>".$returnString."</i>";
                    }
                    else
                    {
                        $returnString = "";
    
                        $returnString .=  "Weekly budget amount not stored successfully, network error! </br>";
                        // return ["STATUS"=>"ERROR","PAYLOAD"=>$returnString];
                        echo "<i style='color: red; text-align: center; background-color: #EAF9EA;'>".$returnString."</i>";
                    }

                }




            }
            else
            {
                $returnString = "";
    
                $returnString .=  "Weekly budget amount not stored successfully, network error! </br>";
                // return ["STATUS"=>"ERROR","PAYLOAD"=>$returnString];
                echo "<i style='color: red; text-align: center; background-color: #EAF9EA;'>".$returnString."</i>";
            }






         }





         if($type === 'YEAR')
         {
            $table_name = $this->budgets_table;
            $constraints = "user_id = '$user_id' AND type = 'YEAR' AND year = $currentYear";
            $type = $this->sql_escape_string($type);

            $selectDBValues = $this->select_multiple_where_constraints($table_name,$constraints);
            $query = $this->query($selectDBValues);

            if($query)
            {
                if($this->sql_num_rows($query) === 1)
                {
                    //update records
                    $table_name = $this->budgets_table;
                    $update_values = "amount = $amount";
                    $constraints = "user_id = '$user_id' AND type = 'YEAR' AND year = $currentYear";

                    $yearlyUpdateStatement = $this->multiple_update($table_name,$update_values,$constraints);
                    $yearlyUpdateQuery = $this->query($yearlyUpdateStatement);

                    if($yearlyUpdateQuery)
                    {
                        $returnString = "";
    
                        $returnString .=  "Budget amount for year ".$currentYear." updated successfully</br>";
                        // return ["STATUS"=>"ERROR","PAYLOAD"=>$returnString];
                        echo "<i style='color: green; text-align: center; background-color: #EAF9EA;'>".$returnString."</i>";
                   
                    }
                    else
                    {
                        $returnString = "";
    
                        $returnString .=  "Budget amount for year ".$currentYear." not updated successfully, network error! </br>";
                        // return ["STATUS"=>"ERROR","PAYLOAD"=>$returnString];
                        echo "<i style='color: red; text-align: center; background-color: #EAF9EA;'>".$returnString."</i>";
                    }

                }

                if($this->sql_num_rows($query) === 0)
                {
                    //insert records
                    $table_name = $this->budgets_table;;
     
                    $columns = "user_id, 
                                amount,
                                type,
                                weekly_start_date,
                                weekly_end_date,
                                month,
                                year";
                           
                            
                    
                    $values ="'$user_id',
                                '$amount',
                                '$type',
                                'null',
                                'null',
                                'null',
                                '$currentYear'";
                    
                    $insertStatement = $this->insert($table_name,$columns,$values);
                    $insertQuery = $this->query($insertStatement);

                    if($insertQuery)
                    {
                        $returnString = "";
    
                        $returnString .=  "Budget amount for year ".$currentYear." stored successfully.</br>";
                        // return ["STATUS"=>"ERROR","PAYLOAD"=>$returnString];
                        echo "<i style='color: green; text-align: center; background-color: #EAF9EA;'>".$returnString."</i>";
                    }
                    else
                    {
                        $returnString = "";
    
                        $returnString .=  "Budget amount for year ".$currentYear." not stored successfully, network error! </br>";
                        // return ["STATUS"=>"ERROR","PAYLOAD"=>$returnString];
                        echo "<i style='color: red; text-align: center; background-color: #EAF9EA;'>".$returnString."</i>"; 
                    }

                }

            }
            else
            {
                $returnString = "";
    
                $returnString .=  "Budget amount for year ".$currentYear." not stored successfully, network error! </br>";
                // return ["STATUS"=>"ERROR","PAYLOAD"=>$returnString];
                echo "<i style='color: red; text-align: center; background-color: #EAF9EA;'>".$returnString."</i>";
            }



        
         }






         if($type === 'MONTHLY')
         {
            $table_name = $this->budgets_table;
            $constraints = "user_id = '$user_id' AND type = 'MONTHLY' AND month = $currentMonth AND year = $currentYear";
            $type = $this->sql_escape_string($type);

            $selectDBValues = $this->select_multiple_where_constraints($table_name,$constraints);
            $query = $this->query($selectDBValues);

            if($query)
            {
                if($this->sql_num_rows($query) === 1)
                {
                    //update records
                    $table_name = $this->budgets_table;
                    $update_values = "amount = $amount";
                    $constraints = "user_id = '$user_id' AND type = 'MONTHLY' AND month = $currentMonth AND year = $currentYear";

                    $monthlyUpdateStatement = $this->multiple_update($table_name,$update_values,$constraints);
                    $monthlyUpdateQuery = $this->query($monthlyUpdateStatement);

                    if($monthlyUpdateQuery)
                    {
                        $returnString = "";
    
                        $returnString .=  "Montly Budget amount updated successfully.</br>";
                        // return ["STATUS"=>"ERROR","PAYLOAD"=>$returnString];
                        echo "<i style='color: green; text-align: center; background-color: #EAF9EA;'>".$returnString."</i>";
                   
                    }
                    else
                    {
                        $returnString = "";
    
                        $returnString .=  "Montly Budget amount not updated successfully, network error! </br>";
                        // return ["STATUS"=>"ERROR","PAYLOAD"=>$returnString];
                        echo "<i style='color: red; text-align: center; background-color: #EAF9EA;'>".$returnString."</i>";
                    }

                }
                
                if($this->sql_num_rows($query) === 0)
                {
                    //insert records
                    $table_name = $this->budgets_table;;
     
                    $columns = "user_id, 
                                amount,
                                type,
                                weekly_start_date,
                                weekly_end_date,
                                month,
                                year";
                           
                            
                    
                    $values ="'$user_id',
                                '$amount',
                                '$type',
                                'null',
                                'null',
                                '$currentMonth',
                                '$currentYear'";
                    
                    $insertStatement = $this->insert($table_name,$columns,$values);
                    $insertQuery = $this->query($insertStatement);

                    if($insertQuery)
                    {
                        $returnString = "";
    
                        $returnString .=  "Montly Budget amount stored successfully.</br>";
                        // return ["STATUS"=>"ERROR","PAYLOAD"=>$returnString];
                        echo "<i style='color: green; text-align: center; background-color: #EAF9EA;'>".$returnString."</i>";
                    }
                    else
                    {
                        $returnString = "";
    
                        $returnString .=  "Montly Budget amount not stored successfully, network error! </br>";
                        // return ["STATUS"=>"ERROR","PAYLOAD"=>$returnString];
                        echo "<i style='color: red; text-align: center; background-color: #EAF9EA;'>".$returnString."</i>"; 
                    }

                }

            }
            else
            {
                $returnString = "";
    
                $returnString .=  "Montly Budget amount not stored successfully, network error! </br>";
                // return ["STATUS"=>"ERROR","PAYLOAD"=>$returnString];
                echo "<i style='color: red; text-align: center; background-color: #EAF9EA;'>".$returnString."</i>";
            }


         }
         

        

         }
         else
         {
            $returnString = "Error </br>";

   
             if($type == null)
             {
                 $returnString .=  "Provide a budget type. </br>";
                
                
             }

             if($amount == null)
             {
                 $returnString .= "Amount cannot be left blank. </br>";
           
             }


             //return ["STATUS"=>"ERROR","PAYLOAD"=>$returnString];
             echo "<i style='color: red; text-align: center; background-color: #EAF9EA;'>".$returnString."</i>";
         }

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
     * @params $user_id
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
        
        //user expenses array 
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
        
 
        //continue computation
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