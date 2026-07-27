<?php
    include "connections.php";
    session_start();
require "../../PHPMailer/PHPMailerAutoload.php";
require "../../PHPMailer/class.phpmailer.php";
require "../../PHPMailer/class.smtp.php";
    if(isset($_GET['order'])){
        $item_id = $_GET['order'];
        $cancel_order = $connectdb->prepare("UPDATE orders SET order_status = -1, delivery_date = CURDATE() WHERE order_number = :order_number");
        $cancel_order->bindvalue('order_number', $item_id);
        $cancel_order->execute();

        if($cancel_order){
           /*  echo "<script>alert('Order cancelled!');
            window.open('admin.php', '_parent');</script>"; */
            $get_customer = $connectdb->prepare("SELECT * FROM orders WHERE order_number = :order_number");
            $get_customer->bindvalue("order_number", $item_id);
            $get_customer->execute();
            $shows = $get_customer->fetchAll();
            foreach($shows as $show){
            $customer = $show->customer;
            $order_id = $show->order_number;
            $item = $show->item_id;
            $companys = $show->company;
            }
            //get item name
            /* $get_item = $connectdb->prepare("SELECT item_name FROM menu WHERE item_id = :item_id");
            $get_item->bindValue("item_id", $item);
            $get_item->execute();
            $row = $get_item->fetch();
            $item_name = $row->item_name; */
            //get customer name
            $get_name = $connectdb->prepare("SELECT first_name, last_name, email FROM shoppers WHERE user_id = :user_id");
            $get_name->bindvalue("user_id", $customer);
            $get_name->execute();
            $names = $get_name->fetchAll();
            foreach($names as $name){
                $full_name = $name->first_name . " " . $name->last_name;
                $customer_email = $name->email;

            }
            
            //send notification and email to customer
           $subject = "Order Cancelled";

            $details = "Hello $full_name, we regret to inform you that your order ($order_id) has been cancelled and will not be delivered. If payment was made online, any eligible refund will be processed according to our refund policy. We sincerely apologize for the inconvenience and thank you for choosing Rivicos.";
            $mailHeader = "FROM: Admin";
            
            //send notification
            $send_notification = $connectdb->prepare("INSERT INTO notifications (customer, subject, details) VALUES(:customer, :subject, :details)");
            $send_notification->bindvalue("customer", $customer);
            $send_notification->bindvalue("subject", $subject);
            $send_notification->bindvalue("details", $details);
            $send_notification->execute();
            //send mail
            // mail($customer, $subject, $details, $mailHeader) or die("Error!");
            function smtpmailer($to,$from,$from_name,$subject,$body){

                $mail = new PHPMailer();

                $mail->IsSMTP();

                $mail->SMTPAuth = true;

                $mail->SMTPSecure = "ssl";

                $mail->Host = "premium355.web-hosting.com";

                $mail->Port = 465;

                $mail->Username = "orders@rivicos.com";

                $mail->Password = "yMcmb@her0123!";

                $mail->IsHTML(true);

                $mail->From = "orders@rivicos.com";

                $mail->FromName = $from_name;

                $mail->Sender = $from;

                $mail->AddReplyTo($from,$from_name);

                $mail->Subject = $subject;

                $mail->Body = $body;

                $mail->AddAddress($to);

                if(!$mail->Send()){

                    return false;

                }

                return true;

            }
            $to = $customer_email;

            $from = "orders@rivicos.com";

            $from_name = "Rivicos Supermarket";

            $subj = "Item Cancellation Notice - ".$order_id;
            echo "<div class='success'><p>Order cancelled! <i class='fas fa-thumbs-up'></i></p></div>";
            
        }else{
            echo "<p style='background:red; color:#fff; padding:5px'>Filed to cance order <i class='fas fa-thumbs-down'></i></p>";
        }
    }