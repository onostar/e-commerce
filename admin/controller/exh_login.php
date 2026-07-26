<?php
    include "connections.php";
    session_start();

   /*  $_SESSION['success'] = "";
    $_SESSION['error'] = "";
    $_SESSION['reg_success'] = ""; */


    if(isset($_POST['submit_login'])){
        $username = ucwords(htmlspecialchars(stripslashes($_POST['exh_username'])));
        $password = htmlspecialchars(stripslashes($_POST['password']));

        $get_user = $connectdb->prepare("SELECT * FROM users WHERE company_email = :company_email AND company_password = :company_password");
        $get_user->bindvalue("company_email", $username);
        $get_user->bindvalue("company_password", $password);
        $get_user->execute();
        $_SESSION['email'] = $username;
        if($get_user->rowCount() > 0){
            $_SESSION['user'] = $username;
            header("Location: ../views/user.php");
            $_SESSION['reg_success'] = "Welcome $username!";

            
        }else{
            $_SESSION['error'] = "Invalid Username or password";
            header("Location: ../index.php");
        }
         
    }




?>