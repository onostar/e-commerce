<?php
    session_start();
    include "connections.php";
    if(isset($_POST['change_password'])){
        $username = ucwords(htmlspecialchars(stripslashes($_POST['username'])));
        $new_password = htmlspecialchars(stripslashes($_POST['new_password']));
        $re_password = htmlspecialchars(stripslashes($_POST['retype_password']));


        if(strlen($new_password) < 6){
            $_SESSION['error'] = "Error! Password too short";
            header("Location: ../change_password.php");
        }elseif ($new_password !== $re_password) {
            $_SESSION['error'] = "Error! Password does not match";
            header("Location: ../change_password.php");
        }else{
            $hashed_pwd = password_hash($new_password, PASSWORD_DEFAULT);
            $change_password = $connectdb->prepare("UPDATE users SET company_password = :company_password WHERE company_email = :company_email");
            $change_password->bindValue("company_password", $hashed_pwd);
            $change_password->bindValue("company_email", $username);
            $change_password->execute();
            $_SESSION['success'] = "Password Changed Successfully! <br> Please login";
            unset($_SESSION['user']);
            header("Location: ../../login_page.php");
        }
        
    }
      