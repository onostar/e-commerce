<?php
    include "connections.php";
    session_start();

    $_SESSION['success'] = "";
    $_SESSION['error'] = "";
    if(isset($_POST['update'])){
        $first_name = ucwords(htmlspecialchars(stripslashes($_POST['first_name'])));
        $last_name = ucwords(htmlspecialchars(stripslashes($_POST['last_name'])));
        $whatsapp = htmlspecialchars(stripslashes($_POST['whatsapp']));
        $other_number = htmlspecialchars(stripslashes($_POST['other_number']));
        $state = ucwords(htmlspecialchars(stripslashes($_POST['res_state'])));
        $email = htmlspecialchars(stripslashes($_POST['user_email']));
        $gender = htmlspecialchars(stripslashes($_POST['gender']));
        $passport = $_FILES['passport']['name'];
        $passport_folder = "../passports/".$passport;
        $id = $_POST['user_id'];
        // $code = strtoupper(substr($state, 0, 3));
        // $cur_time = Date("Y");
        // $reg_number = $code."/".$cur_time ."/00".$id;
        /* update profile */
        if(move_uploaded_file($_FILES['passport']['tmp_name'], $passport_folder)){

            $update_profile = $connectdb->prepare("UPDATE users SET first_name = :first_name, last_name = :last_name, whatsapp = :whatsapp, other_number = :other_number, res_state = :res_state, user_email = :user_email, passport = :passport, gender = :gender WHERE user_id = :user_id");
            $update_profile->bindvalue("first_name", $first_name);
            $update_profile->bindvalue("last_name", $last_name);
            $update_profile->bindvalue("whatsapp", $whatsapp);
            $update_profile->bindvalue("other_number", $other_number);
            $update_profile->bindvalue("res_state", $state);
            $update_profile->bindvalue("user_email", $email);
            $update_profile->bindvalue("passport", $passport);
            // $update_profile->bindvalue("reg_number", $reg_number);
            $update_profile->bindvalue("gender", $gender);
            $update_profile->bindvalue("user_id", $id);
            $update_profile->execute();

            if($update_profile){
                $_SESSION['success'] = "Profile updated successfully!";
                header("Location: ../views/user.php");
            }else{
                $_SESSION['error'] = "Update failed";
                header("Location: ../views/user.php");
            }
        }else{
            $_SESSION['error'] = "image upload failed";
            header("Location: ../views/user.php");
        }
    }else{
        $_SESSION['error'] = "update failed!";
        header("Location: ../views/user.php");

    }
        

    

?>