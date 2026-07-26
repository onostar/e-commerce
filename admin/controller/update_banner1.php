<?php
    include "connections.php";
    session_start();

    function validate($field){
        if(!isset($_POST[$field])){
            return false;
        }else{
            return htmlspecialchars(stripcslashes($_POST[$field]));
        }
    }
    
    /* $_SESSION['success'] = "";
    $_SESSION['error'] = ""; */
    if(isset($_POST['add_banner1'])){
        $description = ucwords(validate('banner_desc'));
        $company = validate('company');
        $banner = $_FILES['banner1']['name'];
        $banner_folder = "../../banners/".$banner;
        $banner_size = $_FILES['banner1']['size'];
        $allowed_ext = array("jpg", "png", "jpeg");
        $banner_ext = explode('.', $banner);
        $banner_ext = strtolower(end($banner_ext));
        if($banner_size <= 500000){
            if(in_array($banner_ext, $allowed_ext)){
                if(move_uploaded_file($_FILES['banner1']['tmp_name'], $banner_folder)){
                    $add_photo = $connectdb->prepare("UPDATE exhibitors SET banner_description = :banner_description, banner1 = :banner1 WHERE exhibitor_id = :exhibitor_id");
                    $add_photo->bindvalue('banner_description', $description);
                    $add_photo->bindvalue('banner1', $banner);
                    $add_photo->bindvalue('exhibitor_id', $company);
                    
                    $add_photo->execute();

                    if($add_photo){
                        $_SESSION['success'] = "Banner <strong></strong>  Updated Successfully!";
                        header("Location: ../views/exhibitors.php");

                        /* echo "<p><span>" . $restaurant . "</span> created successfully!"; */
                    }else{
                        $_SESSION['error'] = "$description not Uploaded!";
                        header("Location: ../views/exhibitors.php");
                        /* echo "<p>restaurant not created!</p>"; */

                    }
                }else{
                    /* echo "<p class='exist'>failed to upload logo!</p>"; */
                    $_SESSION['error'] = "Photo upload failed!";
                    header("Location: ../views/exhibitors.php");
                }
            }else{
                $_SESSION['error'] = "Error! File not supported";
                header("Location: ../views/exhibitors.php");
            }
        }else{
            $_SESSION['error'] = "Error! image should not be larger than 500kb";
            header("Location: ../views/exhibitors.php");
        }
            
        
    }
?>