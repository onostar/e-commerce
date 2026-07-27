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
                $orderItems='<table width="100%" cellpadding="12"
                style="border-collapse:collapse;">

                <tr style="background:#F5F7FA;">

                <th align="left">Product</th>

                <th align="center">Qty</th>

                <th align="right">Price</th>

                </tr>

                ';

                foreach($rows as $row){

                $getItem=$connectdb->prepare("SELECT item_name FROM menu WHERE item_id=:id");

                $getItem->bindValue("id",$row->item);

                $getItem->execute();

                $product=$getItem->fetch();

                $orderItems.='

                <tr>

                <td>'.$product->item_name.'</td>

                <td align="center">'.$row->quantity.'</td>

                <td align="right">

                ₦'.number_format($row->item_price*$row->quantity).'

                </td>

                </tr>

                ';

                }
                $orderItems.='</table>';
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
                $get_company = $connectdb->prepare("SELECT users.company_email, users.company_name FROM orders INNER JOIN users ON users.user_id = orders.company WHERE orders.customer=:customer LIMIT 1");
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
                $mail->addBCC('onostarmedia@gmail.com');
                
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
            
            /* $to   = 'rivicos@gmail.com';
            $from = 'orders@rivicos.com';
            $from_name = "Rivicos SUpermarket & Pharmacy";
            $name = 'Rivicos Online Store';
            $subj = 'New order from '.$customer_name;
            $msg = "<p>You have a new order from $customer_name </p><br> <a href='https://rivicos.com/login_page.php'>Click</a> to review and deliver order"; */
            /* Mail sent to admin */
            $subj = "🛒 New Order Received - ".$order_num;

            $msg='
            <div style="max-width:700px;
            margin:auto;
            font-family:Arial,Helvetica,sans-serif;
            background:#fff;
            border:1px solid #e5e5e5;
            border-radius:15px;
            overflow:hidden;">
            <div style="background:linear-gradient(135deg,#1674D5,#8DCE1F);
            padding:35px;
            text-align:center;
            color:#fff;">
            <h1 style="margin:0;">New Order Received</h1>
            <p style="margin-top:8px;">
            A customer has successfully placed an order.
            </p>
            </div>
            <div style="padding:35px;">
            <table width="100%" cellpadding="10" style="border-collapse:collapse;">
            <tr>
            <td width="35%"><strong>Order Number</strong></td>
            <td>'.$order_num.'</td>
            </tr>
            <tr>
            <td><strong>Customer</strong></td>
            <td>'.$customer_name.'</td>
            </tr>
            <tr>
            <td><strong>Email</strong></td>

            <td>'.$customer_mail.'</td>

            </tr>

            <tr>

            <td><strong>Delivery Option</strong></td>

            <td>'.$options.'</td>

            </tr>

            <tr>

            <td><strong>Delivery Address</strong></td>

            <td>'.$address.'</td>

            </tr>

            <tr>

            <td><strong>Total Amount</strong></td>

            <td style="color:#1674D5;font-size:20px;font-weight:bold;">
            ₦'.number_format($total_amount).'
            </td>

            </tr>

            <tr>

            <td><strong>Order Date</strong></td>

            <td>'.$date.'</td>

            </tr>

            </table>

            <hr style="margin:35px 0;">

            <h3>Order Items</h3>

            '.$orderItems.'

            <div style="margin-top:40px;text-align:center;">

            <a href="https://rivicos.com/login_page.php"

            style="
            display:inline-block;
            padding:18px 40px;
            background:#1674D5;
            color:#fff;
            text-decoration:none;
            border-radius:40px;
            font-weight:bold;">

            View Order Dashboard

            </a>

            </div>

            </div>

            </div>

            ';
            /* mail to send to customer */
            $customerSubject="🎉 Order Confirmation - ".$order_num;
            $customerMessage='
            <div style="max-width:700px;
            margin:auto;
            font-family:Arial,Helvetica,sans-serif;
            background:#fff;
            border-radius:15px;
            overflow:hidden;
            border:1px solid #eee;">

            <div style="
            background:linear-gradient(135deg,#1674D5,#8DCE1F);
            padding:45px;
            text-align:center;
            color:#fff;">

            <h1 style="margin:0;">
            🎉 Thank You For Shopping With Rivicos
            </h1>

            <p style="margin-top:10px;">
            Your order has been received successfully.
            </p>

            </div>

            <div style="padding:40px;">

            <h2>

            Hello '.$customer_name.',

            </h2>

            <p style="line-height:1.8;color:#555;">

            Thank you for choosing <strong>Rivicos Supermarket & Pharmacy</strong>.

            We have received your order and our team has started processing it.

            </p>

            <div style="
            background:#F7F9FC;
            padding:25px;
            border-radius:12px;
            margin:30px 0;">

            <h3 style="margin-top:0;">
            Order Summary
            </h3>

            <table width="100%" cellpadding="10">

            <tr>

            <td><strong>Order Number</strong></td>

            <td>'.$order_num.'</td>

            </tr>

            <tr>

            <td><strong>Order Date</strong></td>

            <td>'.$date.'</td>

            </tr>

            <tr>

            <td><strong>Delivery Method</strong></td>

            <td>'.$options.'</td>

            </tr>

            <tr>

            <td><strong>Delivery Address</strong></td>

            <td>'.$address.'</td>

            </tr>

            <tr>

            <td><strong>Total</strong></td>

            <td style="font-size:22px;
            font-weight:bold;
            color:#1674D5;">

            ₦'.number_format($total_amount).'

            </td>

            </tr>

            </table>

            </div>

            <h3>

            Items Ordered

            </h3>

            '.$orderItems.'

            <div style="
            margin-top:35px;
            background:#EAF8EE;
            padding:20px;
            border-left:5px solid #28A745;
            border-radius:10px;">

            <h3 style="margin-top:0;">
            What Happens Next?
            </h3>

            <p>

            ✅ Your order is being prepared.<br><br>

            ✅ We will contact you if we need any clarification.<br><br>

            ✅ You will receive your order as soon as it is ready for delivery.

            </p>

            </div>

            <div style="text-align:center;
            margin-top:40px;">

            <a href="https://rivicos.com/view/order_history.php"

            style="
            display:inline-block;
            padding:18px 45px;
            background:#1674D5;
            color:#fff;
            text-decoration:none;
            border-radius:40px;
            font-weight:bold;">

            View My Orders

            </a>

            </div>

            <hr style="margin:40px 0;">

            <p>

            Need assistance?

            </p>

            <p>

            📞 <strong>0705 522 0617</strong><br>

            📧 support@rivicos.com

            </p>

            <p style="color:#888;
            font-size:13px;">

            © '.date('Y').' Rivicos Supermarket & Pharmacy.<br>

            Thank you for shopping with us.

            </p>

            </div>

            </div>

            ';
            // Admin
            smtpmailer(
                "info@rivicos.com",
                "orders@rivicos.com",
                "Rivicos",
                $subj,
                $msg
            );

            // Customer
            smtpmailer(
                $customer_mail,
                "orders@rivicos.com",
                "Rivicos",
                $customerSubject,
                $customerMessage
            );
           /*  $error=smtpmailer($to, $from, $name ,$subj, $msg); */
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