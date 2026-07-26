<?php
    include "server.php";
    date_default_timezone_set("Africa/Lagos");
    session_start();
    require "../PHPMailer/PHPMailerAutoload.php";
    require "../PHPMailer/class.phpmailer.php";
    require "../PHPMailer/class.smtp.php";
    
    // if(isset($_POST['order'])){
        $customer = htmlspecialchars(stripslashes($_POST['customer']));
        $address = htmlspecialchars(stripslashes($_POST['address']));
        $options = htmlspecialchars(stripslashes($_POST['delivery_option']));
        $transNum = htmlspecialchars(stripslashes($_POST['transNum']));
        $total_amount = htmlspecialchars(stripslashes($_POST['total_amount']));
        $email_address = htmlspecialchars(stripslashes($_POST['email_address']));
        // $order_date = date("ymdhi");
        $date = date("Y-m-d H:i:s");
        $status = 0;
        /* $ran_num ="";
        for($i = 0; $i < 3; $i++){
            $random_num = random_int(0, 3);
            $ran_num .= $random_num;
        } */
        $order_num = "RC0".$transNum;
        //get orders from cart
        $get_orders = $connectdb->prepare("SELECT * FROM cart WHERE customer = :customer");
        $get_orders->bindValue("customer", $customer);
        $get_orders->execute();
        if($get_orders->rowCount() > 0){
            $rows = $get_orders->fetchAll();
            foreach($rows as $row){
                $item = $row->item;
                $quantity = $row->quantity;
                $price = $row->item_price;
                $company = $row->company;

                $confirm_order = $connectdb->prepare("INSERT INTO orders (customer, item_id, quantity, item_price, company, order_number, order_date, delivery_address, delivery_option) VALUES (:customer, :item_id, :quantity, :item_price, :company,:order_number, :order_date, :delivery_address, :delivery_option)");
                $confirm_order->bindvalue('customer', $customer);
                $confirm_order->bindvalue('item_id', $item);
                $confirm_order->bindvalue('order_number', $order_num);
                $confirm_order->bindvalue('order_date', $date);
                $confirm_order->bindvalue('quantity', $quantity);
                $confirm_order->bindvalue('delivery_address', $address);
                $confirm_order->bindvalue('item_price', $price);
                $confirm_order->bindvalue('company', $company);
                $confirm_order->bindvalue('delivery_option', $options);
                $confirm_order->execute();
            }
            if($confirm_order){
                /* update delivery address */
                /* $update_address = $connectdb->prepare("UPDATE shoppers SET address = :address WHERE user_id = :user_id");
                $update_address->bindvalue("address", $address);
                $update_address->bindvalue("user_id", $customer);
                $update_address->execute(); */
                //delete from cart
                $delete_cart = $connectdb->prepare("DELETE FROM cart WHERE customer = :customer");
                $delete_cart->bindvalue('customer', $customer);
                $delete_cart->execute();
                //send mail
                /* get customer details */
                $get_customer = $connectdb->prepare("SELECT * FROM shoppers WHERE user_id = :user_id");
                $get_customer->bindvalue('user_id', $customer);
                $get_customer->execute();
                $details = $get_customer->fetchAll();
                foreach($details as $detail){
                    $customer_name = $detail->first_name . ' ' . $detail->last_name;
                    $customer_mail = $detail->email;
                }
                /* get restaurant */
                $get_company = $connectdb->prepare("SELECT users.user_id, users.company_email, users.company_name, orders.company, orders.customer FROM users, orders WHERE orders.customer = :customer AND users.user_id = orders.company");
                $get_company->bindvalue('customer', $customer);
                $get_company->execute();
                $shows = $get_company->fetchAll();
                foreach($shows as $show){
                    $company_mail = $show->company_email;
                    $company = $show->company_name;
                }
    
                
                function smtpmailer($to, $from, $from_name, $subject, $body){
                $mail = new PHPMailer();
                $mail->IsSMTP();
                $mail->SMTPAuth = true; 
        
                $mail->SMTPSecure = 'ssl'; 
                $mail->Host = 'www.realcaresupermarket.com';
                $mail->Port = 465; 
                $mail->Username = 'orders@realcaresupermarket.com';
                $mail->Password = 'r3al@Care!234';   
        
        
                $mail->IsHTML(true);
                $mail->From="orders@realcaresupermarket.com";
                $mail->FromName=$from_name;
                $mail->Sender=$from;
                $mail->AddReplyTo($from, $from_name);
                $mail->Subject = $subject;
                $mail->Body = $body;
                $mail->AddAddress($to);
                $mail->AddAddress('onostarmedia@gmail.com');
                
                if(!$mail->Send())
                {
                    $error ="Please try Later, Error Occured while Processing...";
                    return $error; 
                }
                else 
                {
                    
                    /* success message */
                    $_SESSION['success'] = "You have placed your order. Thank You!";
                    $error = $_SESSION['success'];
                    
                    // header("Location: index.html");
                    return $error;
                }
               
            }
            
            $to   = 'realcaresupermarket@gmail.com';
            $from = 'orders@realcaresupermarket.com';
            $from_name = "Realcare Pharmacy & Supermarket";
            $name = 'Realcare Online Store';
            $subj = 'New order from '.$customer_name;
            $msg = "<p>You have a new order from $customer_name </p><br> <a href='https://realcaresupermarket.com/admin'>Click</a> to review and deliver order";
            
            $error=smtpmailer($to, $from, $name ,$subj, $msg);
             $_SESSION['success'] = "Your order was placed successfully. Thank you!";
                header("Location: ../view/shopping_cart.php");
                exit();
            }else{
                $_SESSION['error'] = "Failed to place order!";
                header("Location: ../view/shopping_cart.php");
            }
        }
        
        
    // }
?>