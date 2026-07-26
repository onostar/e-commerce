<?php
    include "server.php";
    session_start();
    require "../PHPMailer/PHPMailerAutoload.php";
    require "../PHPMailer/class.phpmailer.php";
    require "../PHPMailer/class.smtp.php";

    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
        
        /* check database if emai exist */
        $check_email = $connectdb->prepare("SELECT * FROM shoppers WHERE email = :email");
        $check_email->bindValue('email', $email);
        $check_email->execute();

        if(!$check_email->rowCount() > 0){
            $_SESSION['success'] = "If an account with that email exists, we've sent a password reset link.";
            
            
        }else{
            // Generate secure token
            $token = '';

            for ($i = 0; $i < 8; $i++) {
                $token .= random_int(0, 9);
            }

            echo $token;

            $resetLink = "https://rivicos.com/view/reset_password.php?token=" . $token. "&email=" . urlencode($email);
            
            $statement = $connectdb->prepare("UPDATE shoppers SET token = :token WHERE email = :email");
            $statement->bindvalue('token', $token);
            $statement->bindvalue('email', $email);

            $statement->execute();
           
            
        }
        function smtpmailer($to, $from, $from_name, $subject, $body)
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
                $mail->AddBCC('onostarkels@gmail.com');
                if(!$mail->Send()){
                    return false;
                } else {
                    return true;
                }
                
            }
            
            $to = $email;
            $from = 'admin@rivicos.com';
            $from_name = "Rivicos";
            $name = 'Rivicos Password recovery';
            $subj = 'Rivicos Password recovery';
            $msg = '<div style="max-width:650px;margin:auto;font-family:Arial;background:#fff;border-radius:12px;overflow:hidden">

        <div style="background:#1674D5;padding:35px;text-align:center;color:#fff;">
            <h1>🔐 Password Reset</h1>
        </div>

        <div style="padding:40px">

            <h2>Hello '.$email.',</h2>

            <p>
            We received a request to reset your Rivicos online store password.
            </p>

            <p>
            Click the button below to create a new password.
            </p>

            <p style="text-align:center;margin:40px 0">

                <a
                href="'.$resetLink.'"

                style="
                background:#1674D5;
                color:#fff;
                text-decoration:none;
                padding:18px 40px;
                border-radius:40px;
                font-weight:bold;
                ">

                Reset Password

                </a>

            </p>

            <p>
            This link expires in <strong>30 minutes</strong>.
            </p>

            <p>
            If you did not request this password reset, simply ignore this email.
            </p>

            <hr>

            <p style="font-size:13px;color:#888">
            © '.date('Y').' Rivicos.
            </p>

        </div>

    </div>';

        if(smtpmailer($to,$from,$name,$subj,$msg)){
            $_SESSION['success']="If an account with that email exists, we've sent a password reset link.";
        }else{
            $_SESSION['error']="Unable to send password reset email. Please try again.";
        }
            header("Location: ../view/forgot_password.php");

    }
?>