<?php
    include "connections.php";
    session_start();

    /* function validate($field){
        if(!isset($_POST[$field])){
            return false;
        }else{
            return htmlspecialchars(stripcslashes($_POST[$field]));
        }
    } */
    
    $_SESSION['success'] = "";
    $_SESSION['error'] = "";
    // if(isset($_POST['add_categories'])){
        $category = ucwords(htmlspecialchars(stripslashes($_POST['department'])));

        /* check user availability */
        $check_user = $connectdb->prepare("SELECT * FROM categories WHERE category = :category");
        
        $check_user->bindvalue('category', $category);
        $check_user->execute();

        if($check_user->rowCount() > 0){
            echo "<p class='exist'><span>".$category."</span> already Exists!</p>";
            /* header("Location: admin.php"); */

        }else{
            $add_category = $connectdb->prepare("INSERT INTO categories (category) VALUES (:category)");
            $add_category->bindvalue('category', $category);
            $add_category->execute();

            if($add_category){
                echo "<p><span>".$category."</span> created successfully!</p>";
                // $_SESSION['success'] = "$category added Successfully!";
                // // header("Location: admin.php");
            }else{
                echo "<p class='exist'>Failed to create <span>".$category."</span></p>";
                // $_SESSION['error'] = "$category not added!";
                // header("Location: admin.php");

            }
        }
    
?>