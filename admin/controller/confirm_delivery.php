<?php
    include "connections.php";
    session_start();
    require "../../PHPMailer/PHPMailerAutoload.php";
    require "../../PHPMailer/class.phpmailer.php";
    require "../../PHPMailer/class.smtp.php";

    if(isset($_GET['order'])){
        $item_id = $_GET['order'];
        $dispense_item = $connectdb->prepare("UPDATE orders SET order_status = 2, delivery_date = CURDATE() WHERE order_id = :order_id");
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
                $customer_email = $name->email;
            }
            //send notification and email to customer
            $subject = "Order Delivered";

            $details = "Hello $full_name, we're pleased to confirm that your order '$item_name' (Order No: $order_id) has been successfully delivered. Thank you for shopping with Rivicos Pharmacy & Supermarket. We hope you enjoy your purchase and look forward to serving you again.";
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
                $mail->Host = 'premium355.web-hosting.com';
                $mail->Port = 465; 
                $mail->Username = 'orders@rivicos.com';
                $mail->Password = 'yMcmb@her0123!';   
        
        
                $mail->IsHTML(true);
                $mail->From="orders@rivicos.com";
                $mail->FromName=$from_name;
                $mail->Sender=$from;
                $mail->AddReplyTo($from, $from_name);
                $mail->Subject = $subject;
                $mail->Body = $body;
                $mail->AddAddress($to);
                // $mail->AddAddress('onostarkels@gmail.com');
                
                if(!$mail->Send())
                {
                    $error ="Please try Later, Error Occured while Processing...";
                    return $error; 
                }
                else 
                {
                    
                    /* success message */
                    $error = "<div class='success'><p>Order Delivered! <i class='fas fa-thumbs-up'></i></p></div>";
                    // header("Location: index.html");
                    return $error;
                }
            }
            
            $to   = $customer_email;
            $from = 'orders@rivicos.com';
            $from_name = "Rivicos";
            $name = 'Rivicos order delivery';
            $subj = "Delivery Confirmed - Order ".$order_id;

            $msg='
            <div style="
            max-width:700px;
            margin:auto;
            font-family:Arial,Helvetica,sans-serif;
            background:#ffffff;
            border:1px solid #EAEAEA;
            border-radius:15px;
            overflow:hidden;">

            <!-- HEADER -->

            <div style="
            background:linear-gradient(135deg,#28A745,#1674D5);
            padding:35px;
            text-align:center;
            color:#fff;">

            <img src="https://rivicos.com/images/logo.png"
            style="height:60px;margin-bottom:15px;">

            <h2 style="margin:0;">

            Your Order Has Been Delivered

            </h2>

            <p style="
            margin-top:10px;
            font-size:16px;
            line-height:1.7;">

            Thank you for shopping with Rivicos Pharmacy & Supermarket.

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

            We are delighted to let you know that your order has been successfully delivered.

            We hope everything arrived in excellent condition and meets your expectations.

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

            <strong>Delivered Item</strong>

            </td>

            <td>

            '.$item_name.'

            </td>

            </tr>

            <tr>

            <td>

            <strong>Status</strong>

            </td>

            <td style="
            color:#28A745;
            font-weight:bold;">

            Delivered Successfully

            </td>

            </tr>

            </table>

            <div style="
            background:#F5FBFF;
            padding:20px;
            border-left:4px solid #1674D5;
            border-radius:10px;
            margin-top:25px;">

            <h3 style="margin-top:0;">

            We Value Your Feedback

            </h3>

            <p style="
            margin:0;
            line-height:1.8;
            color:#555;">

            Your opinion helps us improve.

            If you are satisfied with your experience, we would love to hear your feedback. If anything wasnt quite right, please let us know so we can make it right.

            </p>

            </div>

            <div style="
            margin-top:30px;
            padding:20px;
            background:#F9FFF5;
            border-radius:10px;">

            <h3 style="margin-top:0;">

            Need Further Assistance?

            </h3>

            <p style="
            margin:0;
            line-height:1.8;
            color:#555;">

            If you have any questions regarding this order or need assistance with another purchase, our support team is always ready to help.

            </p>

            </div>

            <p style="
            margin-top:30px;
            line-height:1.9;
            color:#555;">

            Thank you once again for choosing <strong>Rivicos Pharmacy & Supermarket</strong>.

            We truly appreciate your trust and look forward to serving you again soon.

            </p>

            <div style="
            margin-top:35px;
            padding:20px;
            background:#F8F9FA;
            text-align:center;
            border-radius:10px;">

            <strong>Customer Support</strong>

            <br><br>

            📞 +234 705 522 0617

            <br>

            ✉ support@rivicos.com

            <br>

            🌐 https://rivicos.com

            </div>

            <hr style="
            margin:35px 0;
            border:none;
            border-top:1px solid #eee;">

            <p style="
            font-size:12px;
            color:#888;
            text-align:center;">

            This email was automatically generated by the Rivicos Order Management System.

            </p>

            </div>

            </div>

            ';
            
            $error=smtpmailer($to, $from, $name ,$subj, $msg);
            echo "<div class='success'><p>Order Delivered! <i class='fas fa-thumbs-up'></i></p></div>";
        }else{
            echo "failed to deliver";
            // header("Location: ../views/admin.php");
        }
    }