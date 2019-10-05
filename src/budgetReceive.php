<?PHP
            require("factory.php");


          // START PHP CODE FOR ADD EXPENDITURE DEVELOPED BY MOFEHINTOLU-MUMUNI 
     
              $objExpense = factory::BudgetController();

              if((isset($_POST['type'])) && ($_POST['type'] != null)  && (isset($_POST['amount'])) && ($_POST['amount'] != null) && (isset($_POST['id'])) && ($_POST['id'] != null))
              {
                 $objExpense->setBudget($_POST['id'],$_POST['amount'],$_POST['type']);
                //echo($_POST['description'].$_POST['amount'].$_POST['item'].$_POST['id']);

              }
              else {
                  $returnString = "Errors! </br>";

                  if(!isset($_POST['amount']) || ($_POST['amount'] == null))
                  {
                      $returnString .= "Budget amount cannot be left blank </br>";
                
                  }

                  if(!isset($_POST['type']) || ($_POST['type'] == null))
                  {
                      $returnString .= "Select a budget type. </br>";
                  }

                  if(!isset($_POST['id']) || ($_POST['id'] == null))
                  {
                      $returnString .= "Internal server error </br>";
                  }


                 echo "<i style='color: red; text-align: center; background-color: #EAF9EA;'>".$returnString."</i>";
          
              }

         
        ?>

  