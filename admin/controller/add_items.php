<?php
    include "../controller/connections.php";
    date_default_timezone_set("Africa/Lagos");
    $date = date("Y-m-d H:i:s");
    $category = htmlspecialchars(stripslashes($_POST['item_category']));
    $item = strtoupper(htmlspecialchars(stripslashes(($_POST['item']))));
    $price = htmlspecialchars(stripslashes(($_POST['item_price'])));
    $company = htmlspecialchars(stripslashes(($_POST['company'])));
    $description = htmlspecialchars(stripslashes(($_POST['item_desc'])));
    $delivery = htmlspecialchars(stripslashes(($_POST['delivery_time'])));
    $payment = htmlspecialchars(stripslashes(($_POST['payment_option'])));
    // $item_foto = $_FILES['item_foto']['name'];
    $item_foto = time() . "_" . basename($_FILES['item_foto']['name']);

    $other_foto = time() . "_" . basename($_FILES['other_foto']['name']);
    $item_foto_folder = "../../items/".$item_foto;
    $other_foto_folder = "../../items/".$other_foto;
    $photo_size = $_FILES['item_foto']['size'];
    $other_size = $_FILES['other_foto']['size'];
    $allowed_ext = array('png', 'jpg', 'jpeg', 'webp');
    /* get current file extention */
    $file_ext = explode('.', $item_foto);
    $file_ext2 = explode('.', $other_foto);
    $file_ext = strtolower(end($file_ext));
    $file_ext2 = strtolower(end($file_ext2));

    //check if item already Exist
    $check = $connectdb->prepare("SELECT item_name FROM menu WHERE item_name = :item_name");
    $check->bindValue("item_name", $item);
    $check->execute();
    if($check->rowCount() > 0){
        echo "<p class='exist'><span>$item</span> already exists</p>";
    }else{
        if(in_array($file_ext, $allowed_ext) && in_array($file_ext2, $allowed_ext)){
            /* if($photo_size <= 200000 && $other_size <= 200000){ */
                //compress image
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
                $compress = compressImage($_FILES['item_foto']['tmp_name'], $item_foto_folder, 80);
                $compress = compressImage($_FILES['other_foto']['tmp_name'], $other_foto_folder, 80);
                if($compress){
                    $add_item = $connectdb->prepare("INSERT INTO menu (item_name, item_category, item_prize, company, item_foto, other_foto, item_description, payment_option, delivery_time, time_created) VALUES (:item_name, :item_category, :item_prize, :company, :item_foto, :other_foto, :item_description, :payment_option, :delivery_time, :time_created)");
                    $add_item->bindvalue("item_name", $item);
                    $add_item->bindvalue("item_category", $category);
                    $add_item->bindvalue("item_prize", $price);
                    $add_item->bindvalue("company", $company);
                    $add_item->bindvalue("item_foto", $item_foto);
                    $add_item->bindvalue("other_foto", $other_foto);
                    $add_item->bindvalue("item_description", $description);
                    $add_item->bindvalue("payment_option", $payment);
                    $add_item->bindvalue("delivery_time", $delivery);
                    $add_item->bindvalue("time_created", $date);
                    $add_item->execute();
                    if($add_item){
                        echo "<p><span>$item</span> created successfully</p>";
                    }else{
                        echo "<p class='exist'>Failed to add item</p>";
                    }
                }else{
                    echo "<p class='exist'>Failed to compress image</p>";
                }
            /* }else{
                echo "<p class='exist'>File too large</p>";
            } */
        }else{
            echo "<p class='exist'>Image format not supported</p>";

        }                    
    }