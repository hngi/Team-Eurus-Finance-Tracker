<?php
$message = '';
    
if(isset($_POST['submit_btn'])){
    include('connection.php');
        $name = mysqli_escape_string($conn, $_POST ['name']);
        $email = mysqli_escape_string($conn, $_POST['email']);
        $title = mysqli_escape_string($conn, $_POST['title']);
        $message1 = mysqli_escape_string($conn, $_POST['message1']);
        if(empty($name) || empty($email) ||
        empty($title) || empty($message1)){
            die ("All fields are Required");
            }
            elseif ( strlen ( $name ) < 3 || strlen ( $name ) > 20) {
                $message .= '<div class="alert alert-danger" role="alert">Name must be between 3 and 20 characters</div>';
                }
                elseif ( strlen ( $email ) < 3 || strlen( $email ) > 50) {
                $message .= '<div class="alert alert-danger" role="alert">Email must be between 3 and 50 characters</div>';
                }
                elseif ( strlen ( $title ) < 3|| strlen ( $title ) > 25) {
                $message .= '<div class="alert alert-danger" role="alert">Title must be between 3 and 25 characters</div>';
                }
                elseif ( strlen ( $message1 ) < 15 || strlen ( $message1 ) > 200) {
                $message .= '<div class="alert alert-danger" role="alert">Password must be between 15 and 200 characters</div>';
                }
        $sql = "INSERT INTO contact(name , email, title, message1, created_at)
        VALUES('$name', 
                '$email',
                '$title',
                '$message1',
                 NOW())";
                $result = mysqli_query($conn , $sql);
        if($result){
        $message .= '<div class="alert alert-success" role="alert">
        Record Saved Successfully <button class="btn"><a href = "#">Home</a></button></div>';
        }
        else{
            $message .= '<div class="alert alert-danger" role="alert">
            Record not Saved ' . mysqli_error($conn) . '<button class="btn"><a href = "login.html">dashboard</a></button>
            </div>';
        }
        
    }
 ?>
<!DOCTYPE html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Welcome</title>
                <meta name="viewport" content="width=device-width, initial-scale=1">
                <link rel="stylesheet" type="text/css" media="screen" href="css/bootstrap.min.css" />
                <link rel="stylesheet" type="text/css" media="screen" href="css/main.css" />
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