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
            $id = $view->user_id;
            $fullname = $view->first_name . " " . $view->last_name;
        }
    $title = $fullname. " - Shopping cart";
?>
<!DOCTYPE html>
<html lang="en">
<head>
   
    <?php include "../head.php"?>
    <link rel="stylesheet" href="../fontawesome-free-5.15.1-web/css/all.css">
    <link rel="stylesheet" href="../fontawesome-free-6.0.0-web/css/all.css">
    <link rel="icon" type="image/png" href="../images/logo.png" size="32X32">
    <link rel="stylesheet" href="../controller/style.css?v=<?php echo APP_VERSION?>">
    
</head>
<body>
    <?php include "header.php";?>
    
    <?php include "mobile_menu.php";?>

    <main>
    <section id="shoppingCart">
            <h2>My shopping cart</h2>
            <hr>
            <p class="successful">
                <?php
                    if(isset($_SESSION['success'])){
                        echo $_SESSION['success'];
                        unset($_SESSION['success']);
                    }
                ?>
                <?php
                    if(isset($_SESSION['error'])){
                        echo $_SESSION['error'];
                        unset($_SESSION['error']);
                    }
                ?>
            </p>
            <div class="shop_cart">
                
                <div class="cart_items">
                    <?php
                        $cart_items = $connectdb->prepare("SELECT menu.item_foto, menu.item_name, menu.company, menu.item_id, cart.cart_id, cart.item, cart.customer, menu.item_prize, cart.item_price, cart.quantity, cart.company FROM menu, cart WHERE menu.item_id = cart.item AND menu.company = cart.company AND cart.customer = :customer");
                        $cart_items->bindvalue('customer', $id);
                        $cart_items->execute();

                        if($cart_items->rowCount() > 0){
                            $views = $cart_items->fetchAll();
                            foreach($views as $view):
                        
                        
                    ?>
                    <figure>
                        <img src="<?php echo '../items/'.$view->item_foto?>" alt="item">

                        <figcaption>
                            <p style="text-transform:uppercase"><strong><?php echo strtoupper($view->item_name)?></strong></p>
                            <!-- <p><i class="fas fa-shop"></i></p> -->
                            <p>Qty: <span id="prizing"><?php echo $view->quantity?></span></p>
                            <p>Unit price: ₦<span class="totalprice"><?php echo number_format($view->item_price)?></span></p>
                            <p style="color:green">Total amount: ₦<span id="totalprice" class="totalprice"><?php echo number_format($view->item_price * $view->quantity)?></span></p>
                            <div class="action">
                                <form >
                                    <input type="number" name="quantity" id="quantity" value="<?php echo $view->quantity?>" oninput="updateQty(this.value, '<?php echo $view->item?>', '<?php echo $view->cart_id?>')">
                                    <input type="hidden" name="cart_id" value="<?php echo $view->cart_id?>">
                                    <input type="hidden" name="item" value="<?php echo $view->item?>">
                                    <!-- <input type="hidden" name="item_prize" value="<?php echo $view->item_prize?>"> -->
                                    <!-- <button type="submit" name="update_qty" title="update Quantity" id="update_qty">Update</button> -->
                                </form>
                                
                                <a onclick="removeCartItem('<?php echo $view->cart_id?>')" href="javascript:void(0);" title="Remove item" id="remove_item"><i class="fas fa-trash"></i></a>
                            </div>
                            
                        </figcapiton>
                    </figure>
                    <?php
                        endforeach;
                    
                        }else{
                            echo "<p class='empty'>Your cart is empty!</p>";
                        }    
                    ?>
                    
                </div>
                <!-- GETTING TOTAL -->
                <div class="total">
                    <?php
                        if($cart_items->rowCount() > 0):
                    ?>
                    <h3>Amount Due</h3>
                    <hr>
                    <p class="total_per_item">Total: <span class="itemsTotal" id="itemTotals">₦<span id="itemTotal"> <?php
                        $get_total = $connectdb->prepare("SELECT SUM(item_price * quantity) AS total_prize FROM cart WHERE customer = :customer");
                        $get_total->bindvalue('customer', $id);
                        $get_total->execute();
                        $totals = $get_total->fetchAll();
                        foreach($totals as $total){
                    echo number_format($total->total_prize, 2);}?></span></span></p>
                    <select name="delivery_option" id="delivery_option" style="padding:4px; width:100%" onchange="selectDelivery(this.value)">
                        <option value="">Select Delivery Option</option>
                        <option value="Pick up">Pick up</option>
                        <option value="Home Delivery">Home Delivery</option>
                    </select>
                    <p class="total_per_item">Delivery fee: <span><span id="delivery">₦2,000.00</span></span></p>
                    <input type="hidden" id="delivery_fee" value="2000">
                    <!-- <p class="total_per_item">Discount: <span> ₦ <span id="discount">0.00</span></span></p> -->
                    <hr>
                    <p class="total_per_item" style="font-weight:bold;">Grand Total:<span id="item_grand_total">₦<span id="grandTotal"></span></span></p>
                    <input type="hidden" id="total_amount" name="total_amount">
                    <hr>
                    
                    <div class="order_or_clear">
                        <section class="order_form">
                            <input type="hidden" name="customer" id="customer" value="<?php echo $id?>">
                            <input type="hidden" name="email_address" id="email_address" value="<?php echo $user?>">
                            <div id="del_address">
                                <label>Delivery Address: <i class="fas fa-pen"></i></label>
                                <input type="text" name="address" id="address" value="<?php 
                                    $get_address = $connectdb->prepare("SELECT address FROM shoppers WHERE user_id = :user_id");
                                    $get_address->bindvalue("user_id", $id);
                                    $get_address->execute();
                                    $user_address = $get_address->fetch();
                                    echo $user_address->address;
                                ?>">
                            </div>
                            <div class="clear_buttons">
                            <button onclick="order()"type="button" name="order" id="order">Proceed to Payment <i class="fas fa-wallet"></i></button>
                            <div  class="clear_cart_form">
                                <input type="hidden" name="customer_clear" id="customer_clear" value="<?php echo $id;?>">
                                <button onclick="clearCart()"name="clear_cart" id="clear_cart">Clear Cart <i class="fas fa-trash"></i></button>
                            </div>
                            </div>
                        </section>
                        
                    </div>
                </div>
                <?php endif;?>
            </div>
            
        </section>
        <!-- <section id="featured">
            
            <h2>Featured cuisines</h2>
            <div class="featured">
                <?php
                    /* $select_featured = $connectdb->prepare("SELECT * FROM menu WHERE featured_item = 1");
                    $select_featured->execute();
                    $rows = $select_featured->fetchAll();
                    foreach($rows as $row): */
                ?>
                <figure>
                    <a href="javascript:void(0);" onclick="showItems('<?php echo $row->item_id?>')">
                        <img src="<?php echo 'items/'.$row->item_foto;?>" alt="featured item">
                        <figcaption>
                            <p><?php echo $row->item_name?></p>
                            <span>₦ <?php echo $row->item_prize?></span>
                        </figcaption>
                    </a>
                </figure>
                
                <?php //endforeach ?>
            </div>
            <button id="view_more">View more</button>
            <button id="show_less">Show less</button>
        </section>
        <section id="shop" class="row">
            
        </section> -->
        
    </main>
    <footer>
        <?php include "footer.php";?>
    </footer>
    
    <script src="../controller/jquery.js"></script>
    <script src="../controller/script.js?v=<?php echo APP_VERSION?>"></script>
    <script src="https://dropin.vpay.africa/dropin/v1/initialise.js"></script>

</body>
</html>

<?php
    }else{
        header("Location: ../index.php");
    }
?> 