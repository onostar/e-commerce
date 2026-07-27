<?php
    session_start();
    include "cache_control.php";
    $title = "Rivicos Online store";
    require "../controller/connections.php";
    if(isset($_SESSION['user'])){
        $username = $_SESSION['user'];
    $user_details = $connectdb->prepare("SELECT * FROM users WHERE company_email = :company_email");
    $user_details->bindvalue("company_email", $username);
    $user_details->execute();

    $users = $user_details->fetchAll();
    foreach($users as $user):
        $_SESSION['company'] = $user->user_id;
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <?php include "../head.php"?>
    <link rel="stylesheet" href="../fontawesome-free-5.15.1-web/css/all.css">
    <link rel="stylesheet" href="../../fontawesome-free-6.0.0-web/css/all.css">
    <link rel="icon" type="image/png" href="../../images/icon.png" size="32X32">
    <link rel="stylesheet" href="../style.css?v=<?php echo APP_VERSION;?>">
   
</head>
<body>
    <!-- <div class="loader">
        <img src="images/psn_logo.jpg" alt="PSN">
        <h2>Welcome to PSN national Conference registration</h2>
    </div> -->
    <main>
    
        <header>
            <h1 class="logo">
                <a href="user.php" title="Home">
                    <img src="../images/logo.png" alt="Logo" class="img-fluid">
                </a>
            </h1>
            <h2 id="desktop_h2">Rivicos Pharmacy & Supermarket</h2>
            <h2 id="mobile_h2">Rivicos Supermarket</h2>
            <!-- <div class="other_menu">
                <a href="#" title="User type"><?php echo $user->user_type?></a>
            </div> -->
            <div class="login">
                <button id="loginDiv"><i class="far fa-user"></i> Account <i class="fas fa-chevron-down"></i></button>
                <div class="login_option">
                    <div>
                        <a class="password_link page_navs" href="javascript:void(0)" data-page="update_password" onclick="showPage('update_password.php')">Change password <i class="fas fa-key"></i></a>

                        <button id="loginBtn"><a href="../controller/logout.php">Log out</a></button>
                    </div>    
                </div>
            </div>
            <!-- <div class="cart" id="user_data">
                <a href="javascript:void(0);" title="<?php echo "Pharm. " .$user->last_name;?>" id="user_name">
                     <span><?php echo $user->company_name?></span> 
                    <div class="user_img">
                        <img src="<?php echo "../passports/".$user->passport;?>" alt="passport">
                    </div>
                </a>
            </div> -->
            <div class="menu_icon" id="menu_icon">
                <a href="javascript:void(0)"><i class="fas fa-bars"></i></a>
            </div>
        </header>
    
        
        <div class="admin_main">
            <aside class="main_menu" id="mobile_log">

                <?php include "side_menu.php"?>
            </aside>
            <div class="contents">
            <section id="contents">
                <div class="success_message">
                    <p>
                        <?php
                            if(isset($_SESSION['success'])){
                                echo $_SESSION['success'];
                                unset($_SESSION['success']);
                            }
                        ?>
                    </p>
                </div>
                <div class="error_message">
                    <p>
                        <?php
                            if(isset($_SESSION['error'])){
                                echo $_SESSION['error'];
                                unset($_SESSION['error']);
                            }
                        ?>
                    </p>
                </div>
                <?php
                    if(isset($_SESSION['error_note'])){
                        echo "<p class='error_note'>" . $_SESSION['error_note'] . "</p>";
                        unset($_SESSION['error_note']);
                    }
                ?>
                
                <div class="quick_links" id="quickLinks">
                    <div class="links page_navs" onclick="showPage('add_item.php')">
                        <i class="fas fa-folder-plus"></i>
                        <p>Add item</p>
                    </div>
                    <div class="links page_navs" onclick="showPage('add_category.php')">
                        <i class="fas fa-layer-group"></i>
                        <p>Category</p>
                    </div>
                    <div class="links page_navs" onclick="showPage('item_price.php')">
                        <i class="fas fa-tag"></i>
                        <p>Prices</p>
                    </div>
                    <div class="links page_navs" onclick="showPage('pending_order.php')">
                        <i class="fas fa-cart-arrow-down"></i>
                        <p>Orders</p>
                    </div>
                    <div class="links page_navs" onclick="showPage('confirm_delivery.php')">
                        <i class="fas fa-truck-moving"></i>
                        <p>Delivery</p>
                    </div>
                    <div class="links page_navs" onclick="showPage('item_list.php')">
                        <i class="fas fa-list"></i>
                        <p>Items</p>
                    </div>
                    <div class="links page_navs" onclick="showPage('customer_list.php')">
                        <i class="fas fa-users"></i>
                        <p>customers</p>
                    </div>
                    <div class="links page_navs" onclick="showPage('highest_selling.php')">
                        <i class="fas fa-chart-line"></i>
                        <p>Top orders</p>
                    </div>
                </div>
                <?php include "dashboard.php"?>
                
            </section>
            </div>
        </div>
        
            
        
        
            
        
    </main>
    <script src="../jquery.js"></script>
    <script src="../jquery.table2excel.js"></script>
    <!-- <script src="../Chart.min.js"></script>  -->
    <script src="../script.js?v=<?php echo APP_VERSION;?>"></script>

    <script>
        //hide success or error message after 2 seconds
        setTimeout(function(){
            $(".success_message").hide();
            $(".error_message").hide();
            $(".error_note").hide();
            $("#reg_success").hide();
        }, 3000);
    </script>
    
</body>
</html>

<?php 
    endforeach;
    }else{
        header("Location: ../../index.php");
    }
?>