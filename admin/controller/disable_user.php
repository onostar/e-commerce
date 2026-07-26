<?php
    include "connections.php";
    session_start();


    if(isset($_GET['user'])){
        $user = $_GET['user'];
        $update_status = $connectdb->prepare("UPDATE exhibitors SET payment_status = 0 WHERE exhibitor_id = :exhibitor_id");
        $update_status->bindvalue("exhibitor_id", $user);
        $update_status->execute();

        if($update_status){
            $_SESSION['success'] = "user deactivated";
            header("Location: ../views/admin.php");
        }else{
            $_SESSION['error'] = "Unable deactivate user";
            header("Location: ../views/admin.php");

        }
    }
?>