<?php
    include "connections.php";
    session_start();

        $email = htmlspecialchars(stripslashes($_POST['admin_email']));
        $curPwd = htmlspecialchars(stripslashes($_POST['current_password']));
        $newPwd = htmlspecialchars(stripslashes($_POST['new_password']));
        $rePwd = htmlspecialchars(stripslashes($_POST['retype_password']));
        
        /* check password */
        $check_password = $connectdb->prepare("SELECT * FROM exhibitors WHERE company_email = :company_email AND company_password = :company_password");
        $check_password->bindvalue('company_email', $email);
        $check_password->bindvalue('company_password', $curPwd);
        $check_password->execute();

        if($check_password->rowCount() > 0){
            if(strlen($newPwd) >= 6){
                if($rePwd === $newPwd){
                    $update_password = $connectdb->prepare("UPDATE exhibitors SET company_password = :company_password WHERE company_email = :company_email");
                    $update_password->bindvalue('company_password', $newPwd);
                    $update_password->bindvalue('company_email', $email);
                    $update_password->execute();

                    if($update_password){
                        session_unset();
                        session_destroy();
                        echo "<p>Password Changed Successfully!</p>";
                        header("Location:../index.php");
                    }else{
                        echo "<p class='exist'>Failed to change password</p>";
                    }
                }else{
                    echo "<p class='exist'>Password does not match!</p>";
                    /* echo "<script>Alert('Passwords doesn't Match');
                    window.open('account.php', '_parent')</script>"; */
                }
            }else{
                echo "<p class='exist'>Password too short!</p>";
            }
        }else{
            echo "<p class='exist'>Current password is incorrect!</p>";
           /*  echo "<script>Alert('Current password is incorrect!');
                window.open('account.php', '_parent')</script>"; */
        }

 
?>