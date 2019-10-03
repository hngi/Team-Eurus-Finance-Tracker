            <?PHP
            require("factory.php");


          // START PHP CODE FOR SIGNUP DEVELOPED BY MOFEHINTOLU-MUMUNI 
            
            //instantiate controller class and select apprioprate class
            $objReg = factory::RegisterController();
      
            if((isset($_POST['email'])) && (isset($_POST['password'])) && ($_POST['email'] != null) && ($_POST['password'] != null) && (isset($_POST['firstname'])) && ($_POST['firstname'] != null) && (isset($_POST['lastname'])) && (isset($_POST['passwordConfirm'])) && ($_POST['lastname'] != null) && ($_POST['passwordConfirm'] != null) && (isset($_POST['terms'])) && ($_POST['terms'] != null)   && ($_POST['password'] == $_POST['passwordConfirm']))
            {
                    //CALL UP REGISTER FUNCTION
                $objReg->Register($_POST['firstname'],$_POST['lastname'],$_POST['email'],$_POST['password']);
  
            }
            else{
                $returnString = "Error! </br>";

                  

                    if(!isset($_POST['email']) || ($_POST['email'] == null))
                    {
                        $returnString .= "Invalid email selected </br>";
                    }


                    if(!isset($_POST['firstname']) || ($_POST['firstname'] == null))
                    {
                        $returnString .= "Firstname must me letters only, no spaces and between 2 and 20 letters max </br>";
                  
                    }

                    if(!isset($_POST['lastname']) || ($_POST['lastname'] == null))
                    {
                        $returnString .= "Lastname must me letters only, no spaces and between 2 and 20 letters max </br>";
                  
                    }

                    if(!isset($_POST['password']) || ($_POST['password'] == null))
                    {
                        $returnString .=  "Password must contain letters and numbers only (20 characters max) </br>";
                       
                       
                    }
                 
                    if($_POST['password'] != $_POST['passwordConfirm'])
                    {
                        $returnString .= "Password and password confirmation do not match </br>";
                    }

                    if(!isset($_POST['terms']) || ($_POST['terms'] == null))
                    {
                        $returnString .= "You must select  the terms and conditions </br>";
                    }

                    echo "<i style='color: red; text-align: center; background-color: #EAF9EA;'>".$returnString."</i>";
                
                }
                //Email Registration Done By Oluwafunmilola | Olulawlah//
            funtion send_mail($firstname,$lastname,$email,$password) {
                $from='Admin <admin@mofehintolumumuni.com>';
                $headers ='';
                $headers .= "From: $from\n";
                $headers .= "Reply-to: $from\n";
                $headers .= "Return-Path: $from\n";
                $headers .= "Message-ID: <" . md5(uniquid(time())) . "@" . $_SERVER['SERVER_NAME'] . ">\n";
                $headers .= "Date: " . date('r', time()) . "\n";
                $headers = "MIME-Version: 1.0" . "\r\n";
                $headers .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";

                $subject = "Welcome!";
                $message = "
                <p></p><br>
                Hi ".$firstname. "<br> Thank you for downloading Eurus Finance Tracker App. Your username is your ".$email." and your password : ".$password. "<br><br>";

                mail($email,$subject,$message,$headers);
            }
        ?>

  