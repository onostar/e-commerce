<?php
    require "../controller/server.php";
    include "../admin/views/cache_control.php";
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
        $title = $full_name. " - Help center";
    }else{
        $title =  " | Help center";
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
    <link rel="stylesheet" href="../controller/style.css?v=<?php echo APP_VERSION?>">
    
</head>
<body>
    <style>
        .help-header{

text-align:center;

margin-bottom:40px;

}

.page-icon{

width:90px;

height:90px;

margin:auto;

border-radius:50%;

background:linear-gradient(135deg,#1674D5,#8DCE1F);

display:flex;

align-items:center;

justify-content:center;

color:#fff;

font-size:38px;

box-shadow:0 20px 40px rgba(22,116,213,.2);

}

.help-header h1{

margin:25px 0 10px;

font-size:38px;

color:#173D7A;

}

.help-header p{

color:#777;

font-size:17px;

max-width:650px;

margin:auto;

line-height:1.8;

}
    </style>
    <?php include "header.php";?>

    <?php include "mobile_menu.php";?>

    <main>
        <section id="help_center">
            <div class="help-header">

        <div class="page-icon">
            <i class="fas fa-headset"></i>
        </div>

        <h1>Help Center</h1>

        <p>

            Find answers, track your orders, manage payments,
            or contact our support team.

        </p>

    </div>
            <input type="search" placeholder="Describe your issues">

            <div class="help_popular">
                <div class="help_pop">
                    <a href="help.php" title="How to place orders">
                        <i class="fas fa-cart-plus"></i>
                        <p>Place order</p>
                    </a>
                </div>
                <div class="help_pop">
                    <a href="help.php#trackOrder" class="help_link" data-page="trackOrder" title="How to track orders">
                        <i class="fas fa-truck-moving"></i>
                        <p>Track order</p>
                    </a>
                </div>
                <div class="help_pop">
                    <a href="order_cancellation.php" title="Policies for order cancellation">
                        <i class="fas fa-luggage-cart"></i>
                        <p>Order cancellation</p>
                    </a>
                </div>
                <div class="help_pop">
                    <a href="refunds.php" title="Refund policies">
                        <i class="fas fa-hand-holding-usd"></i>
                        <p>Refunds & Returns</p>
                    </a>
                </div>
                <div class="help_pop">
                    <a href="payments.php" title="How to make payment">
                        <i class="fas fa-credit-card"></i>
                        <p>Payments</p>
                    </a>
                </div>
            </div>
        </section>
        
    </main>
    <?php include "footer.php"?>
    <script src="../controller/jquery.js"></script>
    <script src="../controller/script.js"></script>
    
</body>
</html>
