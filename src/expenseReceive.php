<?PHP
            require("factory.php");


          // START PHP CODE FOR ADD EXPENDITURE DEVELOPED BY MOFEHINTOLU-MUMUNI 
     
              $objExpense = factory::ExpensesController();

              if((isset($_POST['description'])) && ($_POST['description'] != null)  && (isset($_POST['item'])) && (isset($_POST['amount'])) && ($_POST['item'] != null) && ($_POST['amount'] != null) && (isset($_POST['id'])) && ($_POST['id'] != null))
              {
                 $objExpense->addExpense($_POST['description'],$_POST['amount'],$_POST['item'],$_POST['id']);
                

              }
              else {
                  $returnString = "Errors! </br>";

        
                  if(!isset($_POST['item']) || ($_POST['item'] == null))
                  {
                      $returnString .=  "Provide an item to add to expenditure list </br>";
                     
                     
                  }

                  if(!isset($_POST['amount']) || ($_POST['amount'] == null))
                  {
                      $returnString .= "Amount cannot be left blank </br>";
                
                  }

                  if(!isset($_POST['description']) || ($_POST['description'] == null))
                  {
                      $returnString .= "Description cannot be left empty </br>";
                  }

                  if(!isset($_POST['id']) || ($_POST['id'] == null))
                  {
                      $returnString .= "Internal server error </br>";
                  }


                 echo "<i style='color: red; text-align: center; background-color: #EAF9EA;'>".$returnString."</i>";
          
              }

         
        ?>

  