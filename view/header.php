<?php
    date_default_timezone_set("Africa/Lagos");

$hour = date("H");

if($hour >= 5 && $hour < 12){
    $greeting = "Good Morning";
    $icon = "🌅";
}elseif($hour >= 12 && $hour < 17){
    $greeting = "Good Afternoon";
    $icon = "☀️";
}elseif($hour >= 17 && $hour < 21){
    $greeting = "Good Evening";
    $icon = "🌙";
}else{
    $greeting = "Welcome";
    $icon = "✨";
}

?>
<section class="top_head" id="topHeader">
        <div class="social_media">
           <p>
                <span>Call us </span>(+234) 705 522 0617
            </p>
            <p>
                info@rivicos.com
            </p>
        </div>
        
    </section>
    <header>
        <h1 class="logo">
            <a href="../index.php" title="home">
                <img src="../images/logo.png" alt="home" class="img-fluid">
            </a>
        </h1>
        <div class="search">
            <form class="form-inline" action="search_result.php" method="GET">
                <input type="search" name="search_items" placeholder="search products">
                <button type="submit" name="search" class="main_searchbtn">Search <i class="fas fa-search"></i></button>
                <button type="submit" name="search" class="mobilesearchbtn" ><i class="fas fa-search"></i></button>
            </form>
            
        </div>
        <!-- login menu -->
        <div class="login">
            <?php 
                if(isset($_SESSION['user'])){    
            ?>
            <button id="loginDiv"><i class="far fa-user"></i> 
            <?php 
                $statement = $connectdb->prepare("SELECT * FROM shoppers WHERE email = :email");
                $statement->bindvalue('email', $user);
                $statement->execute();
                $infos = $statement->fetchAll();
                foreach($infos as $info){
                    echo "$greeting,  $info->first_name";
                }
                    
            ?> 
            <i class="fas fa-chevron-down"></i></button>
        <div class="login_option" id="account">
            <div>
                <a href="account.php" class="signupBtn">My Profile</a>
                <a href="order_history.php" class="signupBtn">My orders</a>
               <button id="logoutBtn"><a href="../controller/logout.php" title="Sign out">Logout <i class="fas fa-sign-out"></i></a></button>
                
            </div>
        </div>
            <?php
                }else{
            ?>
            <button id="loginDiv"><i class="far fa-user"></i> Sign in <i class="fas fa-chevron-down"></i></button>
            <div class="login_option">
                <div>
                    <button id="loginBtn"><a href="../login_page.php">Login<i class="fas fa-sign-in-alt"></i></a></button>
                    <h3>Or</h3>
                    <a href="../registration.php" id="signupBtn"><i class="fas fa-paper-plane"></i> Create an account</a>
                </div>
            </div>
            <?php } ?>
        </div>
        <!-- notification -->
        <?php if(isset($_SESSION['user'])){?>
            <div class="notification">
                <a href="notifications.php" title="Notifications">
                <i class="fas fa-bell"></i>
                    <span>
                        <?php
                            $get_not = $connectdb->prepare("SELECT * FROM notifications WHERE customer =:customer AND status = 0");
                            $get_not->bindvalue("customer", $id);
                            $get_not->execute();

                            echo $get_not->rowCount();
                        ?>
                    </span>
                    
                </a>
            </div>
        <?php }?>
        <!-- cart -->
        <?php if(isset($_SESSION['user'])){?>
            <div class="cart">
                <a href="shopping_cart.php" title="view cart"><i class="fas fa-shopping-cart"></i> Cart <span id="cart_value">
                    <?php
                        $cart_num = $connectdb->prepare("SELECT * FROM cart WHERE customer = :customer");
                        $cart_num->bindvalue('customer', $id);
                        $cart_num->execute();

                        if($cart_num->rowCount() > 0){
                            echo $cart_num->rowCount();
                        }else{
                            echo "0";
                        }
                    ?>
                </span></a>
            </div>
        <?php 
            }else{    
        ?>
        <div class="cart">
            <a href="../login_page.php?item=Please login to view cart" title="view cart"><i class="fas fa-shopping-cart"></i> Cart <span id="cart_value">0</span></a>
        </div>
        <?php }?>
        <!-- menu icon -->
        <div class="menu_icon">
            <a href="javascript:void(0)"><i class="fas fa-bars"></i></a>
        </div>
    </header>