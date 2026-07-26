<?php
    include "connections.php";
    session_start();


    if(isset($_GET['item'])){
        $item = $_GET['item'];
        //get item name
        $get_name = $connectdb->prepare("SELECT item_name FROM menu WHERE item_id = :item_id");
        $get_name->bindValue("item_id", $item);
        $get_name->execute();
        $row = $get_name->fetch();
        $name = $row->item_name;
        $update_status = $connectdb->prepare("UPDATE menu SET item_status = 0 WHERE item_id = :item_id");
        $update_status->bindvalue("item_id", $item);
        $update_status->execute();

        if($update_status){
            echo "<div class='success'><p>$name enabled Successfully! <i class='fas fa-thumbs-up'></i></p></div>";
        }else{
            echo "<p>Unable to activate item</p>";
            // header("Location: ../views/exhibitors.php");

        }
    }
?>