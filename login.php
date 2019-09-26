<?php

include "./includes/db.php"; ?>


<?php

if(isset($_POST['login'])) {

    
    $email = $_POST['email'];
    $password = $_POST['password'];

    $email = mysqli_real_escape_string($connection, $email);
    $password = mysqli_real_escape_string($connection, $password);

    $query = "SELECT * FROM users WHERE email = '{$email}'";
    $select_user_query = mysqli_query($connection, $query);

    if(!$select_user_query){

        die("QUERY FAILED". mysqli_error($connection));
    }

    while($row = mysqli_fetch_array($select_user_query)) {

         $db_email = $row['email'];
         $db_password = $row['password'];

    }

    if($email == $db_email && $password == $db_password){

        header("location: dashboard.php");
    } 

    

   



}



?>

<!DOCTYPE html>
<html>
<head>
	<title>Euroswallet | Finance tracker app </title>
</head>
<body>
               

                <div class="login">
                <h1>Login into your account</h1>
                    <form action="#" method="POST">
                        
                        <input type="email" placeholder="Email" name="email" required>
                        <input type="password" placeholder="Password" name="password" required>
                        <input type="submit" placeholder="Login" name="login">
                                                
                    </form>
                    <span>Don't have an account?</span><a href="Signup.php">Sign Up</a>
                </div>
</body>
</html>