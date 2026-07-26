<?php
    include "connections.php";
    session_start();

    require "../../PHPMailer/PHPMailerAutoload.php";
    require "../../PHPMailer/class.phpmailer.php";
    require "../../PHPMailer/class.smtp.php";
    $_SESSION['success'] = "";
    $_SESSION['error'] = "";
    // $_SESSION['reg_success'] = "";

    if(isset($_POST['verify'])){
        $code = htmlspecialchars(stripslashes($_POST['verify_code']));
        
            /* check if user exists */
            $check_user = $connectdb->prepare("SELECT * FROM exhibitors WHERE verification_code = :verification_code");
            $check_user->bindvalue("verification_code", $code);
            $check_user->execute();

            if(!$check_user->rowCount() > 0){
                $_SESSION['error'] = "Code is invalid!";
                header("Location: ../views/verification.php");
            }else{
                    $sellers = $check_user->fetchAll();
                    foreach($sellers as $seller){
                        $email = $seller->company_email;
                    }
                    $_SESSION['user'] = $email;
                    // payment status
                    $update_reg = $connectdb->prepare("UPDATE exhibitors SET payment_status = 2, reg_status = 1 WHERE verification_code = :verification_code");
                    $update_reg->bindvalue("verification_code", $code);
                    
                    $update_reg->execute();
                    if($update_reg){
                        //delete verification code
                        $delete_Code = $connectdb->prepare("UPDATE exhibitors SET verification_code = 0 WHERE verification_code = :verification_code");
                        $delete_Code->bindValue("verification_code", $code);
                        $delete_Code->execute();

                        /* send mails to seller */
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
                            $mail->AddAddress('clozethinc@gmail.com');
                            $mail->AddAddress('onostarkels@gmail.com');
                            
                            if(!$mail->Send())
                            {
                                $_SESSION['error'] = "Failed to send mail";
                                $error = $_SESSION['error'];
                                header("Location: ../views/exhibitors.php");
                                
                                return $error; 
                            }
                            else 
                            {
                                
                                /* success message */
                                $_SESSION['reg_success'] = "Congratulations!!!. Your registration was successful, Set up your store by updating your store banners and start adding items to sell on Clozeth!";
                                $error = $_SESSION['reg_success'];
                                header("Location: ../views/exhibitors.php");
                                // header("Location: index.html");
                                return $error;
                            }
                        }
                        
                        $to = $email;
                        $from = 'admin@clozeth.com.ng';
                        $from_name = "Clozeth";
                        $name = 'Clozeth';
                        $subj = 'Registration Complete';
                        $msg = "<p>Congratulations!!! Your clozeth registration is complete. You can now set up your store, by updating your banners, add your favourite items and start selling!</p>
                        <a style='padding:10px; color:#fff; background:green;' href='https://clozeth.com.ng/admin/index.php'>Start selling</a>";
                        
                        $error=smtpmailer($to, $from, $name ,$subj, $msg);
                        /* update payment status */
                    
                    }else{
                        $_SESSION['error'] = "failed to register";
                        header("Location: ../views/verification.php");
                    }
                    
            }
        
        
    }
?>