<?php
    session_start();
    date_default_timezone_set("Africa/Lagos");
    require "server.php";
    require "../PHPMailer/PHPMailerAutoload.php";
    require "../PHPMailer/class.phpmailer.php";
    require "../PHPMailer/class.smtp.php";
    $date = date("Y-m-d H:i:s");
    function validate($field){
        if(!isset($_POST[$field])){
            return false;
        }else{
            return htmlspecialchars(stripslashes($_POST[$field]));
        }
    }
    $_SESSION['user_email'] = "";
    // $_SESSION['error'] = "";
    // $_SESSION['success'] = "";
    if(isset($_POST['submit_reg'])){
        
        $first_name = ucwords(validate('first_name'));
        $last_name = ucwords(validate('last_name'));
        $address = ucwords(validate('address'));
        $city = ucwords(validate('city'));
        $email = strtolower(validate('email'));
        $phone_number = validate('phone_number');
        $user_password = validate('user_password');
        $confirm_password = validate('confirm_password');
        /* sessions */
            $_SESSION['user_email'] = $email;
            $_SESSION['address'] = $address;
            $_SESSION['last_name'] = $last_name;
            $_SESSION['first_name'] = $first_name;
            $_SESSION['phone_number'] = $phone_number;
        /* check user existence */
        $check_user = $connectdb->prepare("SELECT * FROM shoppers WHERE email = :email");
        $check_user->bindvalue('email', $email);
        $check_user->execute();
        if($check_user->rowCount() > 0){
            $_SESSION['error'] = "User already Exists!";
            header ("Location: ../registration.php");
        }elseif(strlen($phone_number) != 11){
            $_SESSION['phoneError'] = "Phone Number must be 11 digits";
            header("Location: ../registration.php");
        }elseif(strlen($user_password) < 6){
            $_SESSION['passwordError'] = "Error: Password too short!";
            header("Location: ../registration.php");
        }elseif($user_password !== $confirm_password){
            $_SESSION['confirmPwErr'] = "Error: Password does not match!";
            header("Location: ../registration.php");
        }else{
            $hash_password = password_hash($user_password, PASSWORD_DEFAULT);
            $statement = $connectdb->prepare("INSERT INTO shoppers (first_name, last_name, email, phone_number, address, city, user_password, reg_date) VALUES (:first_name, :last_name, :email, :phone_number, :address, :city, :user_password, :reg_date)");

            $statement->bindvalue('first_name', $first_name);
            $statement->bindvalue('last_name', $last_name);
            $statement->bindvalue('email', $email);
            $statement->bindvalue('phone_number', $phone_number);
            $statement->bindvalue('address', $address);
            $statement->bindvalue('city', $city);
            $statement->bindvalue('user_password', $hash_password);
            $statement->bindvalue('reg_date', $date);
            $statement->execute();
            //send welcome mail to client
            //send mail
            function smtpmailer($to, $from, $from_name, $subject, $body){
                $mail = new PHPMailer();
                $mail->IsSMTP();
                $mail->SMTPAuth = true; 
        
                $mail->SMTPSecure = 'ssl'; 
                $mail->Host = 'premium355.web-hosting.com';
                $mail->Port = 465; 
                $mail->Username = 'contact@rivicos.com';
                $mail->Password = 'yMcmb@her0123!';   
    
                $mail->IsHTML(true);
                $mail->From="contact@rivicos.com";
                $mail->FromName=$from_name;
                $mail->Sender=$from;
                $mail->AddReplyTo($from, $from_name);
                $mail->Subject = $subject;
                $mail->Body = $body;
                $mail->AddAddress($to);
                $mail->addBCC('onostarkels@gmail.com');
                
                if(!$mail->Send())
                {
                    $_SESSION['success'] = "Registration successful! Please Login";
                    header("Location: ../login_page.php");
                }
                else 
                {
                    
                    /* success message */
                    $_SESSION['success'] = "Registration successful! Please Login";
                    header("Location: ../login_page.php");
                    // header("Location: index.html");
                    // return $error;
                }
            }
            
            $to   = $email;
            $from = 'contact@rivicos.com';
            $from_name = "Rivicos Supermarket & Stores";
            $name = 'Rivicos Supermarket';
            $subj = "Welcome to Rivicos - Your Account is Ready!";

        $msg = '
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Welcome to Rivicos</title>
</head>

<body style="margin:0;padding:0;background:#f4f7fb;font-family:Arial,Helvetica,sans-serif;">

<table width="100%" cellpadding="0" cellspacing="0" style="background:#f4f7fb;padding:40px 0;">
<tr>
<td align="center">

<table width="650" cellpadding="0" cellspacing="0" style="background:#ffffff;border-radius:12px;overflow:hidden;box-shadow:0 5px 20px rgba(0,0,0,.08);">

<tr>
<td style="background:#ffffff;padding:35px;text-align:center;border-bottom:1px solid #eee;">

<img src="https://rivicos.com/images/logo.png" width="95">

<h1 style="margin:20px 0 5px;color:#173D7A;font-size:32px;">
Welcome to Rivicos!
</h1>

<p style="color:#666;font-size:17px;">
Shop Better. Live Smarter.
</p>

</td>
</tr>

<tr>
<td style="padding:40px;">

<h2 style="color:#173D7A;">
Hello '.$first_name.',
</h2>

<p style="font-size:16px;color:#555;line-height:1.8;">

Thank you for creating your Rivicos account.

We are excited to have you join thousands of shoppers discovering quality supermarket and pharmacy products at unbeatable prices.

</p>

<table width="100%" cellpadding="0" cellspacing="0">

<tr>

<td>

<div style="background:#F7F9FC;border-left:4px solid #8DCE1F;padding:20px;margin:25px 0;border-radius:6px;">

<h3 style="margin-top:0;color:#173D7A;">
Your account is now ready.
</h3>

<p style="margin:0;color:#555;">

You can now:

</p>

<ul style="color:#555;line-height:2;">
<li>🛒 Browse thousands of products</li>
<li>💚 Shop trusted supermarket essentials</li>
<li>💊 Purchase pharmacy products</li>
<li>🚚 Enjoy fast and secure delivery</li>
<li>⭐ Save your favourite products</li>
</ul>

</div>

</td>

</tr>

</table>

<div style="text-align:center;margin:45px 0;">

<a href="https://rivicos.com/login_page.php"

style="background:#1674D5;
color:#fff;
text-decoration:none;
padding:16px 40px;
border-radius:40px;
display:inline-block;
font-size:17px;
font-weight:bold;">

Start Shopping

</a>

</div>

<p style="color:#777;font-size:15px;line-height:1.8;">

If you have any questions, simply reply to this email or contact our support team.

We are always happy to help.

</p>

<p style="margin-top:35px;line-height:1.8;color:#555;">

Warm regards,<br>

<strong style="color:#173D7A;">
The Rivicos Team
</strong>

</p>

</td>

</tr>

<tr>

<td style="background:#173D7A;color:#fff;text-align:center;padding:30px;">

<p style="margin:0;font-size:18px;font-weight:bold;">
Rivicos
</p>

<p style="margin:10px 0;font-size:14px;">
Your trusted Online Supermarket & Pharmacy
</p>

<p style="font-size:13px;color:#ddd;">

www.rivicos.com

</p>

<p style="font-size:12px;color:#bbb;margin-top:20px;">

© '.date('Y').' Rivicos. All Rights Reserved.

</p>

</td>

</tr>

</table>

</td>

</tr>

</table>

</body>
</html>
';
            
            $error=smtpmailer($to, $from, $name ,$subj, $msg);
           
        }
    }

