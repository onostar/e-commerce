<?php
    include "server.php";
    session_start();
    require "../PHPMailer/PHPMailerAutoload.php";
    require "../PHPMailer/class.phpmailer.php";
    require "../PHPMailer/class.smtp.php";

    if(isset($_GET['cancel'])){
        $item_id = $_GET['cancel'];
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
            $get_name = $connectdb->prepare("SELECT first_name, last_name FROM shoppers WHERE user_id = :user_id");
            $get_name->bindvalue("user_id", $customer);
            $get_name->execute();
            $names = $get_name->fetchAll();
            foreach($names as $name){
                $full_name = $name->first_name . " " . $name->last_name;
            }
            //get company details
            $get_company = $connectdb->prepare("SELECT company_email, company_name FROM users WHERE user_id = :user_id");
            $get_company->bindvalue("user_id", $companys);
            $get_company->execute();
            $sellers = $get_company->fetchAll();
            foreach($sellers as $seller){
                $seller_com = $seller->company_name;
                $seller_mail = $seller->company_email;
            }
            // echo $seller_mail;
            //send notification and email to customer
            /* $subject = "Order Cancelled";
            $details = "Hello $seller, an order '$item_name', with order number: $order_id has been Cancelled for some reason by the shopper. "; */
            // $mailHeader = "FROM: Admin";
            
            //send notification
            /* $send_notification = $connectdb->prepare("INSERT INTO notifications (customer_email, subject, details) VALUES(:customer_email, :subject, :details)");
            $send_notification->bindvalue("customer_email", $customer);
            $send_notification->bindvalue("subject", $subject);
            $send_notification->bindvalue("details", $details);
            $send_notification->execute();
            //send mail
            mail($customer, $subject, $details, $mailHeader) or die("Error!");
            $_SESSION['success'] = "Item Dispensed!";
            header("Location: ../views/admin.php"); */
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
                    $_SESSION['success'] = "Order Cancelled!";
                    $error = $_SESSION['success'];
                    header("Location: ../view/order_history.php");
                    // header("Location: index.html");
                    return $error;
                }
            }
            
            $to   = $seller_mail;
            $from = 'orders@realcarepharmacy.com';
            $from_name = "Realcare";
            $name = 'Realcare Cancelled Order';
            $subj = "$item_name order Cancelled";
            $msg = "<p>Hello $seller_com, an order '$item_name', with order number: $order_id has been Cancelled for some reason by $full_name. </p>";
            
            $error=smtpmailer($to, $from, $name ,$subj, $msg);
        }else{
            $_SESSION['error'] = "failed to cancel";
            header("Location: ../views/order_history.php");
        }
    }