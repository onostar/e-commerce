<?php
    require "../controller/server.php";
    session_start();
    $_SESSION['current_page'] = $_SERVER['REQUEST_URI'];
    if(isset($_SESSION['user'])){
        $user = $_SESSION['user'];
        $user_info = $connectdb->prepare("SELECT * FROM shoppers WHERE email = :email");
        $user_info->bindvalue('email', $user);
        $user_info->execute();
        $views = $user_info->fetchAll();
        foreach($views as $view){
            $full_name = $view->first_name. " ". $view->last_name;
            $id = $view->user_id;
        }
        $title = $full_name. " - Help center - Payments";
    }else{
        $title =  " | Help center - Payments";
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
<?php
            include "../head.php";
        ?>
    <link rel="stylesheet" href="../fontawesome-free-5.15.1-web/css/all.css">
    <link rel="icon" type="image/png" href="../images/logo.png" size="32X32">
    <link rel="stylesheet" href="../controller/style.css">
    
</head>
<body>
    <?php include "header.php";?>

    <?php include "mobile_menu.php";?>

    <main>
        <section id="helpNotes">
            <figure class="help_banner">
                <div class="help_img">
                    <img src="../images/payment2.webp" alt="order & track banner">
                </div>
                <figcaption>
                    <h2>How to make payments</h2>
                    <i class="fas fa-truck-moving"></i>
                <figcaption>
            </figure>
            <div class="all_helps">
                <div class="help_links">
                    <p class="help_link active_help" data-page="placeOrder">Payments for orders</p>
                    
                </div>
                <div class="help_details" id="placeOrder">
                    <div class="place_order_tips">
                        <div class="tips_img">
                            <img src="../images/payment.png" alt="order tips">
                        </div>
                        <div class="order_tips">
                            <p>Items ordered are paid for using your cart checkout. Payment can be made using various methods such as credit/debit cards, bank transfers, or other supported payment options.</p>
                        </div>
                    </div>
                </div>
                
                
                
            </div>
        </section>
        
    </main>
    <?php include "footer.php"?>
    <script src="../controller/jquery.js"></script>
    <script src="../controller/script.js"></script>
    
</body>
</html>
