<?php
    include "server.php";
    session_start();

    // if(isset($_POST['update_qty'])){
    if(isset($_GET['quantity']) && isset($_GET['item']) && isset($_GET['cart'])){
        $new_qty = htmlspecialchars(stripslashes($_GET['quantity']));
        $item = htmlspecialchars(stripslashes($_GET['item']));
        $cart = htmlspecialchars(stripslashes($_GET['cart']));
        // $item_prize = htmlspecialchars(stripslashes($_POST['item_prize']));
        // $new_price = $new_qty * $item_prize;

        $update_qty = $connectdb->prepare("UPDATE cart SET quantity = :quantity/* , item_price = :item_price */ WHERE cart_id = :cart_id AND item = :item");

        $update_qty->bindvalue('quantity', $new_qty);
        // $update_qty->bindvalue('item_price', $new_price);
        $update_qty->bindvalue('cart_id', $cart);
        $update_qty->bindvalue('item', $item);
        $update_qty->execute();

        if($update_qty){

            header("Location: ../view/shopping_cart.php");
        }
        else{
            echo "update failed!";
        }
    }
?>