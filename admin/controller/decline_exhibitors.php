<?php
    include "connections.php";
    session_start();

    $_SESSION['success'] = "";
    $_SESSION['error'] = "";

    if(isset($_GET['exhibitor'])){

        $user_id = $_GET['exhibitor'];
        /* check if approved */
        
        $delete_payment = $connectdb->prepare("UPDATE exhibitors SET payment_status = -1 WHERE exhibitor_id = :exhibitor_id");

        $delete_payment->bindvalue("exhibitor_id", $user_id);
        $delete_payment->execute();

        if($delete_payment){
            $_SESSION['error'] = "Exhibitor payment declined!";
            header("Location: ../views/admin.php");
        }else{
            $_SESSION['error'] = "Failed to confirm payment!";
            header("Location: ../views/admin.php");
        }
        
        
    }
?>