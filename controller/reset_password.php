<?php
    include "server.php";
    session_start();
    if($_SERVER['REQUEST_METHOD'] === 'POST'){

        $email = htmlspecialchars(stripslashes($_POST['user_email']));
        $token = htmlspecialchars(stripslashes($_POST['token']));
        // $curPwd = htmlspecialchars(stripslashes($_POST['current_password']));
        $newPwd = htmlspecialchars(stripslashes($_POST['user_password']));
        $rePwd = htmlspecialchars(stripslashes($_POST['retype_password']));
        if($rePwd !== $newPwd){
            $_SESSION['error'] = "Passwords do not match!";
            header("Location: ../view/reset_password.php?token=" . $token . "&email=" . urlencode($email));
            exit();
        }else{
            if(strlen($newPwd) >= 6){
                $hashedPwd = password_hash($newPwd, PASSWORD_DEFAULT);
                $update_password = $connectdb->prepare("UPDATE shoppers SET user_password = :user_password, token = 0 WHERE email = :email");
                $update_password->bindvalue('user_password', $hashedPwd);
                $update_password->bindvalue('email', $email);
                $update_password->execute();

                if($update_password){
                    $_SESSION['success'] = "Password Changed successfully, please login";
                    header("Location:../login_page.php");
                }else{
                    $_SESSION['error'] = "Failed to change password";
                    header("Location: ../view/reset_password.php?token=" . $token . "&email=" . urlencode($email));
                }
                
            }else{
                $_SESSION['error'] = "Password too short!";
                header("Location: ../view/reset_password.php?token=" . $token . "&email=" . urlencode($email));
            }
        }
    }
 
?>