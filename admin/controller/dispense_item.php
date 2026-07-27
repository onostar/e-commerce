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
            $subject = "🚚 Your Order is Ready for Delivery";

            $details = "Good news! Your order '".$item_name."' (Order No: ".$order_id.") has been processed and dispatched for delivery. Our delivery personnel will arrive shortly. Thank you for shopping with Rivicos.";
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
                   $error = "<div class='success'><p>Order Dispensed Successfully! <i class='fas fa-thumbs-up'></i></p></div>";
                    // header("Location: index.html");
                    return $error;
                }
            }
            
            $to   = $email;
            $from = 'orders@rivicos.com';
            $from_name = "Rivicos Supermarket";
            $name = 'Rivicos order';
           $subj = "Your Order is On Its Way! - ".$order_id;
            $msg='
            <div style="
            max-width:700px;
            margin:auto;
            font-family:Arial,Helvetica,sans-serif;
            background:#ffffff;
            border-radius:15px;
            overflow:hidden;
            border:1px solid #e8e8e8;">

            <div style="
            background:linear-gradient(135deg,#1674D5,#8DCE1F);
            padding:40px;
            text-align:center;
            color:#fff;">

            <h1 style="margin:0;">
            🚚 Your Order is On Its Way!
            </h1>

            <p style="margin-top:10px;font-size:16px;">
            Great news! Your order has been prepared and handed over for delivery.
            </p>

            </div>

            <div style="padding:40px;">

            <h2 style="color:#173D7A;">

            Hello '.$full_name.',

            </h2>

            <p style="line-height:1.8;color:#555;">

            Thank you for shopping with
            <strong>Rivicos Supermarket & Pharmacy.</strong>

            We are pleased to let you know that your order has been successfully processed and is now out for delivery.

            </p>

            <div style="
            background:#F8FAFD;
            padding:25px;
            border-radius:12px;
            margin:30px 0;">

            <h3 style="margin-top:0;color:#173D7A;">

            Delivery Information

            </h3>

            <table width="100%" cellpadding="10">

            <tr>

            <td width="35%"><strong>Order Number</strong></td>

            <td>'.$order_id.'</td>

            </tr>

            <tr>

            <td><strong>Product</strong></td>

            <td>'.$item_name.'</td>

            </tr>

            <tr>

            <td><strong>Status</strong></td>

            <td style="color:#28A745;font-weight:bold;">
            Ready for Delivery
            </td>

            </tr>

            <tr>

            <td><strong>Estimated Delivery</strong></td>

            <td>Very Soon</td>

            </tr>

            </table>

            </div>

            <div style="
            background:#EAF8EE;
            padding:22px;
            border-left:5px solid #28A745;
            border-radius:10px;">

            <h3 style="margin-top:0;">

            What Happens Next?

            </h3>

            <p style="line-height:1.8;">

            ✅ Our delivery personnel is on the way.

            <br><br>

            ✅ Kindly keep your phone available in case our rider needs directions.

            <br><br>

            ✅ Please inspect your order before confirming receipt.

            </p>

            </div>

            <div style="text-align:center;margin:40px 0;">

            <a href="https://rivicos.com/view/order_history.php"

            style="
            display:inline-block;
            padding:18px 45px;
            background:#1674D5;
            color:#fff;
            text-decoration:none;
            border-radius:40px;
            font-weight:bold;
            font-size:16px;">

            View My Orders

            </a>

            </div>

            <hr style="margin:35px 0;">

            <p>

            Need assistance?

            </p>

            <p>

            📞 <strong>+234 705 522 0617</strong><br>

            📧 support@rivicos.com

            </p>

            <p style="font-size:13px;color:#888;margin-top:35px;">

            © '.date("Y").' Rivicos Supermarket & Pharmacy.

            <br>

            Thank you for choosing Rivicos.

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