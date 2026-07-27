<?php
    session_start();
    date_default_timezone_set("Africa/Lagos");
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
    if(isset($_POST['add_review'])){
        
        $item = validate('item');
        $customer = validate('customer');
        $description = validate('details');
        $date = date("Y-m-d H:i:s");

        //get customer details
        $get_customer = $connectdb->prepare("SELECT * FROM shoppers WHERE user_id = :user_id");
        $get_customer->bindValue("user_id", $customer);
        $get_customer->execute();
        $custs = $get_customer->fetchAll();
        foreach($custs as $cust){
            $full_name = $cust->last_name ." ". $cust->first_name;
            $email = $cust->email;
        }
        //get item details
        $get_item = $connectdb->prepare("SELECT * FROM menu WHERE item_id = :item_id");
        $get_item->bindValue("item_id", $item);
        $get_item->execute();
        $rows = $get_item->fetchAll();
        foreach($rows as $row){
            $item_name = $row->item_name;
        }
       
       //check if review already exists for this client
       $get_review = $connectdb->prepare("SELECT * FROM reviews WHERE item = :item AND customer = :customer");
       $get_review->bindValue("item", $item);
       $get_review->bindValue("customer", $customer);
       $get_review->execute();
       if($get_review->rowCount() > 0){
            $_SESSION['error'] = "You have already posted a review for this item";
            header("Location: ../view/item_review.php?item=$item");
        }else{
            $statement = $connectdb->prepare("INSERT INTO reviews (item, customer, details, post_date) VALUES (:item, :customer, :details, :post_date)");

            $statement->bindvalue('customer', $customer);
            $statement->bindvalue('item', $item);
            $statement->bindvalue('details', $description);
            $statement->bindvalue('post_date', $date);
            $statement->execute();
            if($statement){
                function smtpmailer($to, $from, $from_name, $subject, $body)
            {
                $mail = new PHPMailer();
                $mail->IsSMTP();
                $mail->SMTPAuth = true; 
        
                $mail->SMTPSecure = 'ssl'; 
                $mail->Host = 'premium355.web-hosting.com';
                $mail->Port = 465; 
                $mail->Username = 'admin@realcarepharmacy.com';
                $mail->Password = 'yMcmb@her0123!';   
        
        
                $mail->IsHTML(true);
                $mail->From="admin@rivicos.com";
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
                    
                    $_SESSION['reported'] = "Thanks for your review. Do shop more with us";
                   /*  header("Location: ../view/report_product.php"); */
                    $error = $_SESSION['reported'];
                    /* unlink($ssn_folder);
                    unlink($dlf_folder);
                    unlink($dlb_folder); */
                    // header("Location: ../index.php");
                    return $error;
                }
            }
            
            $to   = 'info@rivicos.com';
            $from = 'admin@rivicos.com';
            $from_name = "Rivicos";
            $name = 'Rivicos customer review';
            $subj = "Rivicos review from $full_name";
            $msg = "<p>You have a review for $item_name from $full_name<br><br> <a style='background:green;padding:10px; color:#fff' href='https://rivicos.com/view/item_info.php?item=$item'>View</a></p>";          
            $error=smtpmailer($to, $from, $name ,$subj, $msg);
            }
            
        }
    }

