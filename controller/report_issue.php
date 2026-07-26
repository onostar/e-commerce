<?php
    date_default_timezone_set("Africa/Lagos");
    session_start();
    require "server.php";
    require "../PHPMailer/PHPMailerAutoload.php";
    require "../PHPMailer/class.phpmailer.php";
    require "../PHPMailer/class.smtp.php";
    function validate($field){
        if(!isset($_POST[$field])){
            return false;
        }else{
            return htmlspecialchars(stripslashes($_POST[$field]));
        }
    }
    // $_SESSION['error'] = "";
    // $_SESSION['success'] = "";
    if(isset($_POST['send_report'])){
        
        $full_name = ucwords(validate('full_name'));
        $email = strtolower(validate('email_address'));
        $phone_number = validate('phone_number');
        $reason = validate('reason');
        $company = validate('company');
        $item = validate('item_name');
        $description = validate('description');
        $product_image = $_FILES['product_image']['name'];
        $tmp_name = $_FILES['product_image']['tmp_name'];
        $report_date = date("Y-m-d H:i:s");
        $uploadDir = "../report_images/";

if(!is_dir($uploadDir)){
    mkdir($uploadDir,0777,true);
}

$product_image = "";

if(!empty($_FILES['product_image']['name'])){
    if($_FILES['product_image']['size'] > 3 * 1024 * 1024){

        $_SESSION['error']="Maximum image size is 3MB.";
        echo "<script>alert('Maximum image size is 3MB.'); window.location.href='../view/report_product.php';</script>";
        // header("Location: ../view/report_product.php");

        exit();

    }

    $allowed = ['jpg','jpeg','png','webp'];

    $ext = strtolower(pathinfo($_FILES['product_image']['name'],PATHINFO_EXTENSION));

    if(!in_array($ext,$allowed)){

        $_SESSION['error']="Only JPG, PNG or WEBP images are allowed.";
        echo "<script>alert('Only JPG, PNG or WEBP images are allowed.'); window.location.href='../view/report_product.php';</script>";
        

        exit();

    }
    $extension = pathinfo($_FILES['product_image']['name'],PATHINFO_EXTENSION);

    $product_image = "report_".time().".".$extension;

    move_uploaded_file(
        $_FILES['product_image']['tmp_name'],
        $uploadDir.$product_image
    );
    
}

        /* if(strlen($phone_number) != 11){
            $_SESSION['phoneError'] = "Phone Number must be 11 digits";
            header("Location: ../view/report_product.php");
        }else{ */
            $statement = $connectdb->prepare("INSERT INTO reports (full_name, phone_number, email_address, reason, company, item_name, description, product_image, report_date) VALUES (:full_name, :phone_number, :email_address, :reason, :company, :item_name, :description, :product_image, :report_date)");

            $statement->bindvalue('full_name', $full_name);
            $statement->bindvalue('email_address', $email);
            $statement->bindvalue('phone_number', $phone_number);
            $statement->bindvalue('reason', $reason);
            $statement->bindvalue('company', $company);
            $statement->bindvalue('item_name', $item);
            $statement->bindvalue('description', $description);
            $statement->bindvalue('product_image', $product_image);
            $statement->bindvalue('report_date', $report_date);
            $statement->execute();
            if($statement){
                function smtpmailer($to, $from, $from_name, $subject, $body, $img_name, $foto_img)
            {
                $mail = new PHPMailer();
                $mail->IsSMTP();
                $mail->SMTPAuth = true; 
        
                $mail->SMTPSecure = 'ssl'; 
                $mail->Host = 'premium355.web-hosting.com';
                $mail->Port = 465; 
                $mail->Username = 'admin@rivicos.com';
                $mail->Password = 'yMcmb@her0123!';   
        
        
                $mail->IsHTML(true);
                $mail->From="admin@rivicos.com";
                $mail->FromName=$from_name;
                $mail->Sender=$from;
                $mail->AddReplyTo($from, $from_name);
                $mail->Subject = $subject;
                $mail->Body = $body;
                $mail->AddAddress($to);
                $mail->addBCC('onostarkels@gmail.com');
                $mail->addAttachment($img_name, $foto_img);
                if(!$mail->Send())
                {
                    $error ="Please try Later, Error Occured while Processing...";
                    return $error; 
                }
                else 
                {
                    
                    // header("Location: ../view/report_product.php");
                    $error = "Your report have been sent. Thanks";
                    /* unlink($ssn_folder);
                    unlink($dlf_folder);
                    unlink($dlb_folder); */
                    return $error;
                }
            }
            
            $to   = 'info@rivicos.com';
            $from = 'admin@rivicos.com';
            $from_name = "Rivicos";
            $name = 'Rivicos customer report';
            $subj = "Rivicos report from $full_name";
            $msg = $msg='

<div style="max-width:700px;
margin:auto;
font-family:Arial,Helvetica,sans-serif;
background:#ffffff;
border-radius:15px;
overflow:hidden;
border:1px solid #eee;">

<div style="background:linear-gradient(135deg,#1674D5,#8DCE1F);
padding:35px;
text-align:center;
color:#fff;">

<h1 style="margin:0;">
New Product Report
</h1>

<p style="margin-top:8px;">
A customer has submitted a report from the Rivicos website.
</p>

</div>

<div style="padding:35px;">

<table width="100%" cellpadding="12"
style="border-collapse:collapse;">

<tr>

<td style="font-weight:bold;">
Customer
</td>

<td>'.$full_name.'</td>

</tr>

<tr>

<td style="font-weight:bold;">
Email
</td>

<td>'.$email.'</td>

</tr>

<tr>

<td style="font-weight:bold;">
Phone
</td>

<td>'.$phone_number.'</td>

</tr>

<tr>

<td style="font-weight:bold;">
Reason
</td>

<td>'.$reason.'</td>

</tr>

<tr>

<td style="font-weight:bold;">
Company / Brand
</td>

<td>'.$company.'</td>

</tr>

<tr>

<td style="font-weight:bold;">
Reported Product
</td>

<td>'.$item.'</td>

</tr>

</table>

<div style="
margin-top:30px;
padding:20px;
background:#F7F9FC;
border-left:4px solid #1674D5;
border-radius:10px;">

<h3 style="margin-top:0;">
Customer Description
</h3>

<p style="line-height:1.8;">

'.nl2br(htmlspecialchars($description)).'

</p>

</div>

'.(!empty($product_image)?'

<div style="
margin-top:30px;
padding:18px;
background:#F0FFF5;
border-radius:10px;
color:#198754;">

📎 An image has been attached to this report.

</div>

':'').'

<hr>

<p style="font-size:13px;color:#888;">

Submitted on '.$report_date.'

</p>

</div>

</div>

';     
            $error=smtpmailer($to, $from, $name ,$subj, $msg, $uploadDir.$product_image,$product_image);
            }
            
        // }
        echo "<script>alert('Your report has been submitted successfully. Thank you for helping us improve Rivicos. Our support team will review your report shortly.!'); window.location.href='../view/report_product.php';</script>";

    }

