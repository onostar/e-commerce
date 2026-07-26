<?php
    include "server.php";
    session_start();
    if(isset($_POST['subscribe'])){
        $email = htmlspecialchars(stripslashes($_POST['subscribe_email']));

        $check_subscription = $connectdb->prepare("SELECT * FROM users WHERE email = :email AND subscriber = 1");
        $check_subscription->bindvalue("email", $email);
        $check_subscription->execute();
        if($check_subscription->rowCount() > 0){
            echo "<script>alert('You are Already Subscribed to Updates!');
            window.open('../view/main.php', '_parent');</script>";
        }else{
            $subscribe = $connectdb->prepare("UPDATE users SET subscriber = 1 WHERE email = :email");
            $subscribe->bindvalue("email", $email);
            $subscribe->execute();
            if($subscribe){
                echo "<script>alert('You have successfully Subscribed to Updates! You will now receive notifications for new items');
                window.open('../view/main.php', '_parent');</script>";
            }
        }
    }
    