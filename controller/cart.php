<?php
    include "server.php";
    date_default_timezone_set("Africa/Lagos");
    session_start();

    /* function validate($field){
        if(!isset($_POST[$field])){
            return false;
        }else{
            return htmlspecialchars(stripcslashes($_POST[$field]));
        }
    } */
    /* $_SESSION['success_box'] = "";
    $_SESSION['error_box'] = ""; */
    // if(isset($_POST['add_to_cart'])){
        $item_name = ucwords(htmlspecialchars(stripslashes($_POST['cart_item_name'])));
        $item_id = htmlspecialchars(stripslashes($_POST['cart_item_id']));
        $quantity = $_POST['quantity'];
        $item_price = ucwords(htmlspecialchars(stripslashes($_POST['cart_item_price'])));
        $company = ucwords(htmlspecialchars(stripslashes($_POST['cart_item_restaurant'])));
        $customer = ucwords(htmlspecialchars(stripslashes($_POST['customer'])));
        $date = date("Y-m-d H:i:s");
    if(isset($_SESSION['user'])){
        
        /* check user availability */
        $check_user = $connectdb->prepare("SELECT * FROM cart WHERE item = :item AND company = :company AND customer = :customer");
        
        $check_user->bindvalue('item', $item_id);
        $check_user->bindvalue('company', $company);
        $check_user->bindvalue('customer', $customer);
        $check_user->execute();

        if($check_user->rowCount() > 0){
            $_SESSION['cart_already'] = "";
            header("Location: ../view/item_info.php?item=".$item_id);
            

        }else{
            $add_cart = $connectdb->prepare("INSERT INTO cart (item, quantity, item_price, company, customer, date_added) VALUES (:item, :quantity, :item_price, :company, :customer, :date_added)");
            $add_cart->bindvalue('item', $item_id);
            $add_cart->bindvalue('item_price', $item_price);
            $add_cart->bindvalue('company', $company);
            $add_cart->bindvalue('customer', $customer);
            $add_cart->bindvalue('quantity', $quantity);
            $add_cart->bindvalue('date_added', $date);
            $add_cart->execute();

            if($add_cart){
                $_SESSION['cart_added'] = "";
                
                if(isset($_SESSION['order_page'])){
                    header("Location: ".$_SESSION['current_page']);
                    
                }else{
                    header("Location: ../view/item_info.php?item=".$item_id);
                }
            }else{
                echo "<script>alert('Item not added!');
                window.open('../view/item_info.php?item=".$item_id."', '_parent');</script>";
                // $_SESSION['error'] = "$category not added!";
                // header("Location: admin.php");

            }
        }
    }else{
        header("Location: ../login_page.php?item=Please login to continue");
    }
// }
?>