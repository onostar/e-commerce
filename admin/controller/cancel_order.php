<?php
    include "connections.php";
    require "../../PHPMailer/PHPMailerAutoload.php";
require "../../PHPMailer/class.phpmailer.php";
require "../../PHPMailer/class.smtp.php";
    session_start();

    if(isset($_GET['order'])){
        $item_id = $_GET['order'];
        $cancel_order = $connectdb->prepare("UPDATE orders SET order_status = -1, delivery_date = CURDATE() WHERE order_id = :order_id");
        $cancel_order->bindvalue('order_id', $item_id);
        $cancel_order->execute();

        if($cancel_order){
           /*  echo "<script>alert('Order cancelled!');
            window.open('admin.php', '_parent');</script>"; */
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
            $get_name = $connectdb->prepare("SELECT first_name, last_name , email FROM shoppers WHERE user_id = :user_id");
            $get_name->bindvalue("user_id", $customer);
            $get_name->execute();
            $names = $get_name->fetchAll();
            foreach($names as $name){
                $full_name = $name->first_name . " " . $name->last_name;
                $customer_email = $name->email;
            }
            
            //send notification and email to customer
            $subject = "Order Cancelled";

            $details = "Hello $full_name, unfortunately your order for '$item_name' (Order No: $order_id) has been cancelled. If payment was made online, any eligible refund will be processed according to our refund policy. We sincerely apologize for the inconvenience and appreciate your understanding.";
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

            $subj = "Order Cancellation Notice - ".$order_id;

            $msg='
            <div style="
            max-width:700px;
            margin:auto;
            font-family:Arial,Helvetica,sans-serif;
            background:#ffffff;
            border:1px solid #eaeaea;
            border-radius:15px;
            overflow:hidden;">

            <!-- HEADER -->

            <div style="
            background:linear-gradient(135deg,#D9534F,#F0AD4E);
            padding:35px;
            text-align:center;
            color:#fff;">

            <img src="https://rivicos.com/images/logo.png"
            style="height:60px;margin-bottom:15px;">

            <h2 style="margin:0;">

            Your Order Has Been Cancelled

            </h2>

            <p style="
            margin-top:10px;
            font-size:16px;
            line-height:1.7;">

            We sincerely apologize for the inconvenience.

            </p>

            </div>

            <!-- BODY -->

            <div style="padding:35px;">

            <p style="font-size:16px;">

            Hello <strong>'.$full_name.'</strong>,

            </p>

            <p style="
            line-height:1.9;
            color:#555;">

            We regret to inform you that your order has been cancelled and will no longer be processed for delivery.

            </p>

            <table
            width="100%"
            cellpadding="12"
            style="
            margin:25px 0;
            border-collapse:collapse;
            background:#F8FAFD;
            border-radius:10px;">

            <tr>

            <td width="35%">

            <strong>Order Number</strong>

            </td>

            <td>

            '.$order_id.'

            </td>

            </tr>

            <tr>

            <td>

            <strong>Status</strong>

            </td>

            <td style="
            color:#D9534F;
            font-weight:bold;">

            Cancelled

            </td>

            </tr>

            <tr>

            <td>

            <strong>Cancelled Items</strong>

            </td>

            <td>

            All items in this order

            </td>

            </tr>

            </table>

            <div style="
            background:#FFF6F6;
            padding:22px;
            border-left:4px solid #D9534F;
            border-radius:10px;
            margin-top:25px;">

            <h3 style="margin-top:0;">

            Why was my order cancelled?

            </h3>

            <p style="
            margin:0;
            line-height:1.9;
            color:#555;">

            An order may be cancelled due to one or more of the following reasons:

            </p>

            <ul style="
            margin-top:12px;
            line-height:2;
            color:#555;">

            <li>One or more products became unavailable.</li>

            <li>Stock could not be confirmed.</li>

            <li>A payment or verification issue occurred.</li>

            <li>An unexpected operational issue prevented fulfillment.</li>

            </ul>

            </div>

            <div style="
            margin-top:30px;
            padding:20px;
            background:#F5FBFF;
            border-left:4px solid #1674D5;
            border-radius:10px;">

            <h3 style="margin-top:0;">

            What happens next?

            </h3>

            <ul style="
            padding-left:18px;
            line-height:2;
            color:#555;">

            <li>If payment has already been made, any eligible refund will be processed according to our refund policy.</li>

            <li>You may place a new order at any time once the products become available.</li>

            <li>If you have any questions, our customer support team will gladly assist you.</li>

            </ul>

            </div>

            <p style="
            margin-top:30px;
            line-height:1.9;
            color:#555;">

            We sincerely apologize for the inconvenience and appreciate your understanding.

            Thank you for choosing <strong>Rivicos Pharmacy & Supermarket</strong>. We look forward to serving you again.

            </p>

            <div style="
            margin-top:35px;
            padding:20px;
            background:#F8F9FA;
            text-align:center;
            border-radius:10px;">

            <strong>Need Help?</strong>

            <br><br>

            📞 +234 705 522 0617

            <br>

            ✉ support@rivicos.com

            </div>

            <hr style="
            margin:35px 0;
            border:none;
            border-top:1px solid #eee;">

            <p style="
            font-size:12px;
            color:#888;
            text-align:center;">

            This is an automated email from the Rivicos Order Management System.

            </p>

            </div>

            </div>

            ';

            smtpmailer($to,$from,$from_name,$subj,$msg);
            echo "<div class='success'><p>Order cancelled! <i class='fas fa-thumbs-up'></i></p></div>";
            
        }else{
            echo "<p style='background:red; color:#fff; padding:5px'>Filed to cance order <i class='fas fa-thumbs-down'></i></p>";
        }
    }