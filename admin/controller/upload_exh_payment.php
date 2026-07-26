<?php
    include "connections.php";
    session_start();
    require "../../PHPMailer/PHPMailerAutoload.php";
    require "../../PHPMailer/class.phpmailer.php";
    require "../../PHPMailer/class.smtp.php";
    $_SESSION['success'] = "";
    $_SESSION['error'] = "";

    if(isset($_POST['add_booth_pay'])){
        $user_id = htmlspecialchars(stripslashes($_POST['exhibitor_id']));
        $booth = htmlspecialchars(stripslashes($_POST['package_id']));
        $receipt = $_FILES['payment']['name'];
        $receipt_folder = "../exh_receipts/".$receipt;
        $receipt_size = $_FILES['payment']['size'];
        $allowed_ext = array("jpg", "png", "pdf", "jpeg");
        /* get file extension */
        $receipt_ext = explode('.', $receipt);
        $receipt_ext = strtolower(end($receipt_ext));
        if(in_array($receipt_ext, $allowed_ext)){
            if($receipt_size <= 1000000){
                 if(move_uploaded_file($_FILES['payment']['tmp_name'], $receipt_folder)){
                    /* insert into payment first */
                    $insert_receipt = $connectdb->prepare("INSERT INTO store_payments (exhibitor, package, payment_slip) VALUES (:exhibitor, :package, :payment_slip)");
                    $insert_receipt->bindvalue("exhibitor", $user_id);
                    $insert_receipt->bindvalue("package", $booth);
                    $insert_receipt->bindvalue("payment_slip", $receipt);
                    $insert_receipt->execute();
                    if($insert_receipt){
                        /* update status */
                        $update_status = $connectdb->prepare("UPDATE exhibitors set payment_status = 1, plan_package = :plan_package WHERE exhibitor_id = :exhibitor_id");
                        $update_status->bindvalue("plan_package", $booth);
                        $update_status->bindvalue("exhibitor_id", $user_id);
                        $update_status->execute();
                        if($update_status){
                            function smtpmailer($to, $from, $from_name, $subject, $body){
                                $mail = new PHPMailer();
                                $mail->IsSMTP();
                                $mail->SMTPAuth = true; 
                        
                                $mail->SMTPSecure = 'ssl'; 
                                $mail->Host = 'www.ippssolar.com';
                                $mail->Port = 465; 
                                $mail->Username = 'admin@clozeth.com.ng';
                                $mail->Password = 'yMcmb@her0123!';   
                        
                        
                                $mail->IsHTML(true);
                                $mail->From="admin@clozeth.com.ng";
                                $mail->FromName=$from_name;
                                $mail->Sender=$from;
                                $mail->AddReplyTo($from, $from_name);
                                $mail->Subject = $subject;
                                $mail->Body = $body;
                                $mail->AddAddress($to);
                                $mail->AddAddress('onostarkels@gmail.com@gmail.com');
                                $mail->AddAddress('clozethinc@gmail.com');
                                
                                if(!$mail->Send())
                                {
                                    $error ="Please try Later, Error Occured while Processing...";
                                    return $error; 
                                }
                                else 
                                {
                                    
                                    /* success message */
                                    $_SESSION['success'] = "Payment uploaded successfully";
                                    header("Location: ../views/exhibitors.php");
                                    $error = $_SESSION['success'];
                                    header("Location: ../views/exhibitors.php");
                                    // header("Location: index.html");
                                    return $error;
                                }
                            }
                            /* get company name */
                            $get_company = $connectdb->prepare("SELECT company_name FROM exhibitors WHERE exhibitor_id = :exhibitor_id");
                            $get_company->bindvalue("exhibitor_id", $user_id);
                            $get_company->execute();
                            $comp = $get_company->fetch();
                            $company = $comp->company_name;
                            $to   = 'clozethinc@gmail.com';
                            $from = 'admin@clozeth.com.ng';
                            $from_name = "Clozeth";
                            $name = 'Clozeth payment upload!';
                            $subj = "Payment from $company";
                            $msg = "<p>Hello Admin, You have a seller package payment from $company.<br>Kindly click on the link below to confirm payment.</p><br>
                            <a style='padding:10px 15px; background:rgb(3, 69, 75); color:#fff;' href='clozeth.com/admin/index.php'>Confirm payment</a>";
                            
                            $error=smtpmailer($to, $from, $name ,$subj, $msg);
                            
                        }else{
                            $_SESSION['error'] = "failed to upload receipt";
                            header("Location: ../views/exhibitors.php");

                        }
                    }else{
                        $_SESSION['error'] = "failed to insert payment";
                            header("Location: ../views/exhibitors.php");
                    }
                }else{
                    $_SESSION['error'] = "failed to upload receipt";
                    header("Location: ../views/exhibitors.php");
                }
            
            }else{
                $_SESSION['error'] = "Error! File too large";
                header("Location: ../views/exhibitors.php");
            }
        } else{
            $_SESSION['error'] = "Error! Invalid file type";
            header("Location: ../views/exhibitors.php");
        }

    }

?>