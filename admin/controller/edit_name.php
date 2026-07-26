<?php
    include "connections.php";
    session_start();


        $item = htmlspecialchars(stripslashes($_POST['item']));
        $item_name = strtoupper(htmlspecialchars(stripslashes($_POST['item_name'])));
        $item_category = htmlspecialchars(stripslashes($_POST['item_category']));
        $option = htmlspecialchars(stripslashes($_POST['option']));
        $delivery = htmlspecialchars(stripslashes($_POST['delivery']));
        $description = htmlspecialchars(stripslashes($_POST['description']));
        $item_prize = htmlspecialchars(stripslashes($_POST['price']));
        // $first_foto = $_FILES['first_foto']['name'];
        // $second_foto = $_FILES['second_foto']['name'];
        $allowed_ext = array('png', 'jpg', 'jpeg', 'webp');

         //get old price
        $get_old_price = $connectdb->prepare("SELECT item_prize FROM menu WHERE item_id = :item_id");
        $get_old_price->bindValue('item_id', $item);
        $get_old_price->execute();
        $pr = $get_old_price->fetch();
        $old_prize = $pr->item_prize;

        $update_status = $connectdb->prepare("UPDATE menu SET item_name = :item_name, item_category = :item_category, delivery_time = :delivery_time, payment_option = :payment_option, item_description = :item_description, item_prize= :item_prize WHERE item_id = :item_id");
        $update_status->bindvalue("item_id", $item);
        $update_status->bindvalue("item_name", $item_name);
        $update_status->bindvalue("item_category", $item_category);
        $update_status->bindvalue("delivery_time", $delivery);
        $update_status->bindvalue("payment_option", $option);
        $update_status->bindvalue("item_description", $description);
        $update_status->bindvalue("item_prize", $item_prize);
        $update_status->execute();

        if($update_status){
            //checkif oldprice is same with new price
            if($old_prize != $item_prize){
                $update_price = $connectdb->prepare("UPDATE menu SET previous_price = :previous_price WHERE item_id = :item_id");
                $update_price->bindvalue('previous_price', $old_prize);
                $update_price->bindvalue('item_id', $item);
                $update_price->execute();
            }
            //compress image function
            function compressImage($source, $destination, $quality){
                //get image info
                $imgInfo = getimagesize($source);
                $mime = $imgInfo['mime'];
                //create new image from file
                switch($mime){
                    case 'image/png':
                        $image = imagecreatefrompng($source);
                        imagejpeg($image, $destination, $quality);
                        break;
                    case 'image/jpeg':
                        $image = imagecreatefromjpeg($source);
                        imagejpeg($image, $destination, $quality);
                        break;
                    
                    case 'image/webp':
                        $image = imagecreatefromwebp($source);
                        imagejpeg($image, $destination, $quality);
                        break;
                    default:
                        $image = imagecreatefromjpeg($source);
                        imagejpeg($image, $destination, $quality);
                }
                //return compressed image
                return $destination;
            }
            //check if first foto was uploaded
            if(isset($_FILES['first_foto']) && $_FILES['first_foto']['name'] != ""){
                // $first_foto = $_FILES['first_foto']['name'];
                $first_foto = time() . "_" . basename($_FILES['first_foto']['name']);
                $item_foto_folder = "../../items/".$first_foto;
                /* get current file extention */
                $file_ext = explode('.', $first_foto);
                $file_ext = strtolower(end($file_ext));
                if(in_array($file_ext, $allowed_ext)){
                    //compress image
                    $compress = compressImage($_FILES['first_foto']['tmp_name'], $item_foto_folder, 80);
                    if($compress){
                        $update_foto = $connectdb->prepare("UPDATE menu SET item_foto = :item_foto WHERE item_id = :item_id");
                        $update_foto->bindvalue('item_foto', $first_foto);
                        $update_foto->bindvalue('item_id', $item);
                        $update_foto->execute();
                    }else{
                        echo "<p>Failed to compress first photo</p>";
                    }
                }else{
                    echo "<p>First photo format not supported</p>";
                }
               
            }
            //check for second foto
            if(isset($_FILES['second_foto']) && $_FILES['second_foto']['name'] != ""){
                $second_foto = time() . "_" . basename($_FILES['second_foto']['name']);
                $other_foto_folder = "../../items/".$second_foto;
                /* get current file extention */
                $file_ext = explode('.', $second_foto);
                $file_ext = strtolower(end($file_ext));
                if(in_array($file_ext, $allowed_ext)){
                    //compress image
                    $compress = compressImage($_FILES['second_foto']['tmp_name'], $other_foto_folder, 80);
                    if($compress){
                        $update_foto = $connectdb->prepare("UPDATE menu SET other_foto = :other_foto WHERE item_id = :item_id");
                        $update_foto->bindvalue('other_foto', $second_foto);
                        $update_foto->bindvalue('item_id', $item);
                        $update_foto->execute();
                    }else{
                        echo "<p>Failed to compress second photo</p>";
                    }
                }else{
                    echo "<p>Second photo format not supported</p>";
                }
            }
            echo "<div class='success'><p>Item updated successfully! <i class='fas fa-thumbs-up'></i></p></div>";
        }else{
            echo "<p>Unable to rename item</p>";
            // header("Location: ../views/exhibitors.php");

        }
?>