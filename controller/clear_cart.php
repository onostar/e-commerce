<?php
    include "server.php";
    session_start();

    if(isset($_GET['customer'])){
        $customer = $_GET['customer'];
        $delete_cart = $connectdb->prepare("DELETE FROM cart WHERE customer = :customer");
        $delete_cart->bindvalue('customer', $customer);
        $delete_cart->execute();

        if($delete_cart){
            // $_SESSION['success'] = "item Removed from cart!";
            
            header("Location: ../view/shopping_cart.php");
        }else{
            $_SESSION['error'] = "failed to remove";
            header("Location: ../view/shopping_cart.php");
        }
    }