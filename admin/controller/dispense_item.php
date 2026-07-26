<?php
    include "connections.php";
    session_start();
    require "../../PHPMailer/PHPMailerAutoload.php";
    require "../../PHPMailer/class.phpmailer.php";
    require "../../PHPMailer/class.smtp.php";

    if(isset($_GET['order'])){
        $item_id = $_GET['order'];
        $dispense_item = $connectdb->prepare("UPDATE orders SET order_status = 1, dispense_date = CURDATE() WHERE order_id = :order_id");
        $dispense_item->bindvalue('order_id', $item_id);
        $dispense_item->execute();

        if($dispense_item){
            /* echo "<script>alert('Item dispensed!');
            window.open('admin.php', '_parent');</script>"; */
            //get customer name
            $get_customer = $connectdb->prepare("SELECT * FROM orders WHERE order_id = :order_id");
            $get_customer->bindvalue("order_id", $item_id);
            $get_customer->execute();
            $shows = $get_customer->fetchAll();
            foreach($shows as $show){
            $customer = $show->customer;
            $order_id = $show->order_number;
            $item = $show->item_id;
            $companys = $show->company;
            }
            //get item name
            $get_item = $connectdb->prepare("SELECT item_name FROM menu WHERE item_id = :item_id");
            $get_item->bindValue("item_id", $item);
            $get_item->execute();
            $row = $get_item->fetch();
            $item_name = $row->item_name;
            //get customer name
            $get_name = $connectdb->prepare("SELECT * FROM shoppers WHERE user_id = :user_id");
            $get_name->bindvalue("user_id", $customer);
            $get_name->execute();
            $names = $get_name->fetchAll();
            foreach($names as $name){
                $full_name = $name->first_name . " " . $name->last_name;
                $email = $name->email;

            }
            //send notification and email to customer
            $subject = "Item Dispensed for delivery";
            $details = "Hello $full_name, your order '$item_name', with order number: $order_id has been dispensed for delivery to your address. \n Thanks for your business. Do Shop more with Us";
            // $mailHeader = "FROM: Admin";
            
            //send notification
            $send_notification = $connectdb->prepare("INSERT INTO notifications (customer, subject, details) VALUES(:customer, :subject, :details)");
            $send_notification->bindvalue("customer", $customer);
            $send_notification->bindvalue("subject", $subject);
            $send_notification->bindvalue("details", $details);
            $send_notification->execute();

            //send mail
            function smtpmailer($to, $from, $from_name, $subject, $body){
                $mail = new PHPMailer();
                $mail->IsSMTP();
                $mail->SMTPAuth = true; 
        
                $mail->SMTPSecure = 'ssl'; 
                $mail->Host = 'www.realcarepharmacy.com';
                $mail->Port = 465; 
                $mail->Username = 'orders@realcarepharmacy.com';
                $mail->Password = 'yMcmb@her0123!';   
        
        
                $mail->IsHTML(true);
                $mail->From="orders@realcarepharmacy.com";
                $mail->FromName=$from_name;
                $mail->Sender=$from;
                $mail->AddReplyTo($from, $from_name);
                $mail->Subject = $subject;
                $mail->Body = $body;
                $mail->AddAddress($to);
                $mail->AddAddress('onostarkels@gmail.com');
                
                if(!$mail->Send())
                {
                    $error ="Please try Later, Error Occured while Processing...";
                    return $error; 
                }
                else 
                {
                    
                    /* success message */
                   $error = "<div class='success'><p>Order cancelled! <i class='fas fa-thumbs-up'></i></p></div>";
                    // header("Location: index.html");
                    return $error;
                }
            }
            
            $to   = $email;
            $from = 'orders@realcarepharmacy.com';
            $from_name = "Realcare";
            $name = 'Realcare order';
            $subj = "$item_name dispensed for delivery";
            $msg = "<p>Hello $full_name, your order '$item_name', with order number: $order_id has been dispensed for delivery to your address. <br>Your item will BE delivered to you shortly! Thanks for your business. Do Shop more with Realcare</p>";
            
            $error=smtpmailer($to, $from, $name ,$subj, $msg);
        }else{
            $_SESSION['error'] = "failed to dispense";
            header("Location: ../views/admin.php");
        }
    }