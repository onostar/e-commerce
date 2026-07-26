<?php
    include "../controller/connections.php";
    $date = date("Y-m-d H:i:s");
    $banner = htmlspecialchars(stripslashes($_POST['banners']));
    $company = htmlspecialchars(stripslashes(($_POST['company'])));
    $item_foto = $_FILES['item_foto']['name'];
    $item_foto_folder = "../../items/".$item_foto;
    $photo_size = $_FILES['item_foto']['size'];
    $allowed_ext = array('png', 'jpg', 'jpeg', 'webp');
    /* get current file extention */
    $file_ext = explode('.', $item_foto);
    $file_ext = strtolower(end($file_ext));

        if(in_array($file_ext, $allowed_ext)){
            if($photo_size <= 2000000){
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
                if($compress){
                    $update_banner = $connectdb->prepare("UPDATE users SET $banner = :$banner WHERE user_id = :user_id");
                    $update_banner->bindvalue("$banner", $item_foto);
                    $update_banner->bindvalue("user_id", $company);
                    $update_banner->execute();
                    if($update_banner){
                        echo "<p><span>$banner</span> updated successfully</p>";
                    }else{
                        echo "<p class='exist'>Failed to add item</p>";
                    }
                }else{
                    echo "<p class='exist'>Failed to compress image</p>";
                }
            }else{
                echo "<p class='exist'>File too large</p>";
            }
        }else{
            echo "<p class='exist'>Image format not supported</p>";

        }                    