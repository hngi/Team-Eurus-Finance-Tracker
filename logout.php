<?php 
    session_start();

    if(isset($_SESSION['ID'])){
    
        //destroy session and include login
        session_destroy();
        echo("<script>location.href = 'index';</script>");
        header("location: index");

    }
    else{
        echo("<script>location.href = 'index';</script>");
        header("location: index");
    }


?>