<?php
    session_start();
    if(isset($_SESSION['user'])){
        if(isset($_GET['item'])){
            $item = $_GET['item'];
            include "connections.php";
            //get item name
            $get_name = $connectdb->prepare("SELECT item_name FROM menu WHERE item_id = :item_id");
            $get_name->bindValue("item_id", $item);
            $get_name->execute();
            $row = $get_name->fetch();
            $name = $row->item_name;
            //check if item exisit in orders
             //get item name
            $check = $connectdb->prepare("SELECT * FROM orders WHERE item_id = :item_id");
            $check->bindValue("item_id", $item);
            $check->execute();
            $row = $check->rowCount();
            if($row > 0){
                echo "<p style='background:red;color:#fff; padding:4px; text-align:center; width:80%; margin:auto;'>$name already exist in customers order! Caanot be deleted </p>";
            }else{
                $delete = $connectdb->prepare("DELETE FROM menu WHERE item_id = :item_id");
                $delete->bindvalue('item_id', $item);
                $delete->execute();
                echo "<p style='background:green;color:#fff; padding:4px; text-align:center; width:80%; margin:auto;'>$name has been deleted from themenu successfully <i class='fas fa-thumbs-up'></i></p>";
            }

        }
    }else{
        echo "Your session has expired, Please login again";
        header("Location: ../index.php");
    }
?>