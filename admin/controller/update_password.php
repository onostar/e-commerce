<?php
    session_start();
    include "connections.php";

    if(isset($_SESSION['company'])){
        $company = $_SESSION['company'];
        $username = Ucwords(htmlspecialchars(stripslashes($_POST['username'])));
        $cur_password = htmlspecialchars(stripslashes($_POST['current_password']));
        $new_password = htmlspecialchars(stripslashes($_POST['new_password']));
        // $retype_password = htmlspecialchars(stripslashes($_POST['retype_password']));
        //get company details
        $get_details = $connectdb->prepare("SELECT * FROM users WHERE user_id = :user_id");
        $get_details->bindValue("user_id", $company);
        $get_details->execute();
        $rows = $get_details->fetchAll();
        foreach($rows as $row){
            $com_password = $row->company_password;
        }
        $check_pwd = password_verify($cur_password, $com_password);

        if($check_pwd == false){
            echo "<script>
                alert('Current password is incorrect. Please try again');
            </script>";
            echo "<p style='color:red'>Current password is incorrect!.</p>";
            exit();
            
        }else{
            //update password
            $hashed_pwd = password_hash($new_password, PASSWORD_DEFAULT);
           
            $update_password = $connectdb->prepare("UPDATE users SET company_password = :company_password WHERE user_id = :user_id");
            $update_password->bindvalue("user_id", $company);
            $update_password->bindvalue("company_password", $hashed_pwd);
            $update_password->execute();

            if($update_password){
                echo "<p style='background:green; color:#fff; text-decoration:none'>Password updated successfully! Kindly refresh your page to login again</p>";
                session_unset();
                session_destroy();
            }else{
                echo "<p style='color:red'>Password Update failed</p>";
               
            }
        }
        
    }else{
        header("Location: ../index.php");
    }