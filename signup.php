<?php
$message = '';
    
if(isset($_POST['submit_btn'])){
    include('connection.php');
        $fname = mysqli_escape_string($conn, $_POST ['fname']);
        $uname = mysqli_escape_string($conn, $_POST['uname']);
        $email = mysqli_escape_string($conn, $_POST['email']);
        $password1 = mysqli_escape_string($conn, $_POST['password1']);
        $cnfpassword = mysqli_escape_string($conn, $_POST['cnfpassword']);
        if(empty($fname) || empty($uname) || empty($email) ||
        empty($password1) || empty($cnfpassword)){
            die ("All fields are Required");
            }
            elseif ( strlen ( $fname ) < 3 || strlen ( $fname ) > 20) {
                $message .= '<div class="alert alert-danger" role="alert">Name must be between 3 and 20 characters</div>';
                }
                elseif ( strlen ( $uname ) < 3 || strlen( $uname ) > 30) {
                $message .= '<div class="alert alert-danger" role="alert">Username must be between 3 and 30 characters</div>';
                }
                elseif ( strlen ( $email ) < 3 || strlen( $email ) > 50) {
                $message .= '<div class="alert alert-danger" role="alert">Email must be between 3 and 50 characters</div>';
                }
                elseif ( strlen ( $password1 ) < 6 || strlen ( $password1 ) > 15) {
                $message .= '<div class="alert alert-danger" role="alert">Password must be between 6 and 15 characters</div>';
                }
                elseif ( strlen ( $cnfpassword ) < 6 || strlen ( $cnfpassword ) > 15) {
                $message .= '<div class="alert alert-danger" role="alert">Password must be between 6 and 15 characters</div>';
                }
                if($password1 == $cnfpassword){
                    $password1 = md5 ($password1);
                    $cnfpassword = md5 ($cnfpassword);
                }
                else{
                    die  ("Error: Password doesnt match" ."<br>". $sql."<br>".mysqli_error($conn));
                }
        
        $sql = "INSERT INTO signup(fname , uname, email, password1, cnfpassword, created_at)
        VALUES('$fname', 
                '$uname',
                '$email',
                '$password1',
                '$cnfpassword',
                 NOW())";
                $result = mysqli_query($conn , $sql);
        if($result){
        $message .= '<div class="alert alert-success" role="alert">
        Record Saved Successfully <button class="btn"><a href = "#">Home</a></button></div>';
        }
        else{
            $message .= '<div class="alert alert-danger" role="alert">
            Record not Saved ' . mysqli_error($conn) . '<button class="btn"><a href = "login.html">Login</a></button>
            </div>';
        
        }
        
    }
 ?>
<!DOCTYPE html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Login Page</title>
                <meta name="viewport" content="width=device-width, initial-scale=1">
                <link rel="stylesheet" type="text/css" media="screen" href="css/bootstrap.min.css" />
                <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" 
                integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">    
                <link rel="stylesheet" type="text/css" media="screen" href="css/main.css" />
                <script type="text/javascript" src = "validation.js"></script>
                <script src="jquery/jquery.min.js"></script>
                <script src="popper/popper.min.js"></script>
                <script src="js/bootstrap.js"></script> 
            </head>
<body>
<?php 
echo $message; 
?>  
</body>
</html>