<?php
    include "connections.php";
    session_start();
    require "../../PHPMailer/PHPMailerAutoload.php";
    require "../../PHPMailer/class.phpmailer.php";
    require "../../PHPMailer/class.smtp.php";

    if(isset($_GET['order'])){
        $item_id = $_GET['order'];
        $dispense_item = $connectdb->prepare("UPDATE orders SET order_status = 1, dispense_date = CURDATE() WHERE order_number = :order_number");
        $dispense_item->bindvalue('order_number', $item_id);
        $dispense_item->execute();

        if($dispense_item){
            /* echo "<script>alert('Item dispensed!');
            window.open('admin.php', '_parent');</script>"; */
            //get customer name
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
            /* //get item name
            $get_item = $connectdb->prepare("SELECT item_name FROM menu WHERE item_id = :item_id");
            $get_item->bindValue("item_id", $item);
            $get_item->execute();
            $row = $get_item->fetch();
            $item_name = $row->item_name; */
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
           $subject = "Your Order is Out for Delivery";

            $details = "Hello $full_name, great news! Your order ($order_id) has been packed and dispatched for delivery. Please keep your phone available as our delivery rider may contact you shortly. Thank you for shopping with Rivicos.";
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
                   $error = "<div class='success'><p>All Order Dispensed Successfully! <i class='fas fa-thumbs-up'></i></p></div>";
                    // header("Location: index.html");
                    return $error;
                }
            }
            
            $to   = $email;
            $from = 'orders@rivicos.com';
            $from_name = "Rivicos Supermarket";
            $name = 'Rivicos order';
            $subj = "Your Rivicos Order is On Its Way!";

            $msg = '

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
            background:linear-gradient(135deg,#1674D5,#8DCE1F);
            padding:35px;
            text-align:center;
            color:#fff;">

            <img src="https://rivicos.com/images/logo.png"
            style="height:60px;margin-bottom:15px;">

            <h2 style="margin:0;">
            Your Order Has Been Dispatched
            </h2>

            <p style="
            margin-top:10px;
            font-size:16px;
            line-height:1.7;">

            Great news! Your order is now on its way.

            </p>

            </div>

            <!-- BODY -->
            <div style="padding:35px;">

            <p style="font-size:16px;">

            Hello <strong>'.$full_name.'</strong>,

            </p>

            <p style="line-height:1.8;color:#555;">

            We are pleased to let you know that all items in your order have been carefully packed and handed over for delivery.

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

            <td>'.$order_id.'</td>

            </tr>

            <tr>

            <td>
            <strong>Status</strong>
            </td>

            <td style="color:#198754;font-weight:bold;">

            🚚 Out for Delivery

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

            What happens next?

            </h3>

            <ul style="
            padding-left:18px;
            line-height:2;
            color:#555;">

            <li>Your delivery rider is heading to your delivery address.</li>

            <li>Please keep your phone available in case the rider needs to contact you.</li>

            <li>If you selected Cash on Delivery, kindly have the payment ready.</li>

            </ul>

            </div>

            <p style="
            margin-top:30px;
            line-height:1.8;
            color:#555;">

            Thank you for shopping with <strong>Rivicos Pharmacy & Supermarket</strong>.

            We truly appreciate your trust and look forward to serving you again.

            </p>

            <div style="
            margin-top:35px;
            padding:20px;
            background:#F9FFF2;
            border-radius:10px;
            text-align:center;">

            Need assistance?

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

            This email was automatically generated by the Rivicos Order Management System.

            </p>

            </div>

            </div>

            ';
            
            $error=smtpmailer($to, $from, $name ,$subj, $msg);
            echo "<div class='success'><p>Order Dispensed Successfully! <i class='fas fa-thumbs-up'></i></p></div>";
        }else{
            $_SESSION['error'] = "failed to dispense";
            header("Location: ../views/admin.php");
        }
    }