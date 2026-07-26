<?php
    include "connections.php";
    session_start();

        $new_prize = htmlspecialchars(stripslashes($_POST['sales_price']));
        $item_id = $_POST['item_id'];
        //get old price
        $get_old_price = $connectdb->prepare("SELECT item_prize FROM menu WHERE item_id = :item_id");
        $get_old_price->bindValue('item_id', $item_id);
        $get_old_price->execute();
        $pr = $get_old_price->fetch();
        $old_prize = $pr->item_prize;
        $update_price = $connectdb->prepare("UPDATE menu SET previous_price = :previous_price,  item_prize = :item_prize WHERE item_id = :item_id");
        $update_price->bindvalue('previous_price', $old_prize);
        $update_price->bindvalue('item_prize', $new_prize);
        $update_price->bindvalue('item_id', $item_id);
        $update_price->execute();

        if($update_price){
            echo "<div class='success'><p>Price changed successfully! <i class='fas fa-thumbs-up'></i></p></div>";
        }else{
            echo "<p style='background:red; color:#fff; padding:5px'>Filed to change price <i class='fas fa-thumbs-down'></i></p>";
        }