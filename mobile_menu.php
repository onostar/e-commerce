<div id="mobile_menu">
            
    <aside id="asideLeft">
        <div class="login">
            <?php 
                if(isset($_SESSION['user'])){
            ?>
                <button id="loginDiv" title="View profile"></i> 
                <?php 
                    $statement = $connectdb->prepare("SELECT * FROM shoppers WHERE email = :email");
                    $statement->bindvalue('email', $user);
                    $statement->execute();
                    $infos = $statement->fetchAll();
                    foreach($infos as $info){
                        echo "$icon $greeting, $info->first_name";
                    }
                    
                ?>
                
                <a class="logout" title="Logout" href="controller/logout.php"><i class="fas fa-power-off"></i></a>
                
            <?php
                }else{    
            ?>
            <button id="loginDiv"><i class="far fa-user"></i> <a href="login_page.php">Sign in</a> <i class="fas fa-sign-in-alt"></i></button>
            <?php }?>
        </div>
        <nav id="index_nav">
            <ul>
                <?php if(isset($_SESSION['user'])){
                ?>
                <li class="user"><a href="view/account.php" class="signupBtn"><i class="fas fa-user-cog"></i> My Profile</a></li>
                <li class="user"><a href="view/order_history.php" class="signupBtn"><i class="fas fa-cart-arrow-down"></i> My orders</a></li>
                
                <?php
                    }else{    
                ?>
                <!-- <li><a href="view/sellers.php"><i class="fas fa-shop"></i>Become a Seller</a></li> -->
                <?php }
                    include "categories.php";
                ?>
                    
            </ul>
        </nav>
        <hr>
        <nav id="help">
            <ul>
                <li>
                        <a href="view/help_center.php" title="Get in touch">
                            <i class="far fa-question-circle"></i>
                            <div class="note">
                                <h3>Help center</h3>
                                <p>Ask Rivicos</p>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="view/report_product.php" title="who we are">
                            <i class="fas fa-street-view"></i>
                            <div class="note">
                                <h3>Report product</h3>
                                <p>Drop your complaint</p>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="view/refunds.php">
                            <i class="fas fa-hand-holding-usd"></i>
                            <div class="note">
                                <h3>Refunds</h3>
                                <p>Money back guarantee</p>
                            </div>
                        </a>
                    </li>                
                <!-- <li>
                    <a href="javascript:void(0);">
                        <i class="fas fa-hand-holding-usd"></i>
                        <div class="note">
                            <h3>Sell on CLozeth</h3>
                            <p>Show your products to buyers</p>
                        </div>
                    </a>
                </li> -->                          
            </ul>
        </nav>
    </aside>
    
</div>
<!-- cart and notification for mobile -->
<?php if(isset($_SESSION['user'])){?>
<div class="cart_not">
    <a href="view/shopping_cart.php" title="view cart" class="mobile_cart"><i class="fas fa-shopping-cart"></i><span id="cart_value">
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
    <!-- notification -->
    <?php if(isset($_SESSION['user'])){?>
        <div class="notification">
            <a href="view/notifications.php" title="Notifications">
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
</div>
<?php }?>