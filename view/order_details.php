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
        $title = $full_name. " - Order details";
?>
<!DOCTYPE html>
<html lang="en">
<head>

        <?php
            include "../head.php";
        ?>
    <link rel="stylesheet" href="../fontawesome-free-5.15.1-web/css/all.css">
    <link rel="stylesheet" href="../fontawesome-free-6.0.0-web/css/all.css">
    <link rel="icon" type="image/png" href="../images/logo.png" size="32X32">
    <link rel="stylesheet" href="../controller/style.css">
    
</head>
<body>
    <?php include "header.php";?>

    <?php include "mobile_menu.php";?>

    
    <main>
        <section id="itemContent">
            
            <div class="itemInfo">
                <?php
                    if(isset($_GET['order'])){
                        $order_id = $_GET['order'];
                    

                        $view_item = $connectdb->prepare("SELECT orders.customer, orders.item_id, orders.quantity, orders.item_price, orders.company, orders.order_date, orders.order_number, orders.order_status, orders.delivery_date, orders.order_id, orders.dispense_date, menu.item_name, menu.item_foto, menu.payment_option, users.company_name, menu.item_category FROM orders, menu, users WHERE orders.order_id = :order_id AND orders.item_id = menu.item_id AND menu.company = users.user_id ORDER BY orders.order_date DESC");
                        $view_item->bindvalue('order_id', $order_id);
                        $view_item->execute();

                        $items = $view_item->fetchAll();
                        foreach($items as $item): 
                ?>
                <?php
                    $restaurant_name = $item->company_name;
                    $get_category = $connectdb->prepare("SELECT category FROM categories WHERE category_id = :category_id");
                    $get_category->bindvalue("category_id",$item->item_category);
                    $get_category->execute();
                    $cat = $get_category->fetch();
                    $category = $cat->category;
                    $item_name = $item->item_name;
                ?>
                <figure class="item_details"> 
                    <div class="item_pics" id="history_pics">
                        <img src="<?php echo '../items/'.$item->item_foto?>" alt="<?php echo $item->item_name?>" loading="lazy">
                    </div>
                    <form>
                        <figcaption>
                            <div class="menu_logo">
                                <img src="../images/logo.png" alt="company">
                                
                            </div>
                            <div class="clear"></div>
                            <p><span>Order#:</span> <?php echo $item->order_number?></p>
                            <p><span>Name:</span> <?php echo $item->item_name?></p>
                            <p><span>Qty:</span> <?php echo $item->quantity;?></p>
                            <p><span>Unit price:</span> ₦<?php echo number_format($item->item_price)?></p>
                            <p><span>Total Amount:</span> ₦<?php echo number_format($item->item_price * $item->quantity);?></p>
                            <p><span>Company:</span> <?php echo $item->company_name?></p>
                            <p><span>Payment Option:</span> <?php echo $item->payment_option?></p>
                            <!-- <p><span>Order date:</span> <?php echo date("jS M, Y", strtotime($item->order_date))?></p> -->
                            <a href="javascript:void(0)" id="track">Track item <i class="fas fa-cart-plus"></i></a>
                            <?php
                                if($item->order_status == 0){
                            ?>
                            <a class="cancel_order" href="javascript:void(0)" title="Cancel Order" onclick="cancelOrder('<?php echo $item->order_id?>')">Cancel Order <i class="fas fa-plane-slash"></i></a>
                            <?php }?>
                            <?php 
                                if($item->order_status == 2){
                            ?>
                            <a href="javascript:void(0)" onclick="viewItem('<?php echo $item->item_id?>')" id="track" style="background:green">Add review <i class="fas fa-star"></i><i class="fas fa-star"></i></a>
                            <?php }?>
                            <p class="dm"><?php echo "<a target='_blank' href='https://wa.me/+2348071172386' title='Message Store owner'><i class='fab fa-whatsapp'></i> Send us a DM</a>";?></p>
                        </figcaption>
                    </form>
                </figure>
                <div class="item_descriptions" id="trackItem">
                    <hr>
                    <h3>Order details</h3>
                    <ul>
                        <li>Order Placed on <?php echo date("jS M, Y", strtotime($item->order_date));?> <i class='fas fa-check'></i></li>
                        <li>Order Processing <i class='fas fa-check'></i></li>
                        <li><?php
                            if($item->order_status == 2){
                                echo "Order Shipped for delivery on ".date("jS M, Y", strtotime($item->dispense_date)) . " <i class='fas fa-check'></i>";
                            }elseif($item->order_status == -1){
                                echo "<span>Order Shipped for delivery <i class='fas fa-ban'></i></span>";
                            }else{
                                echo "<span>Order Shipped for delivery <i class='fas fa-spinner'></i></span>";
                            }
                        ?></li>
                        <li><?php
                            if($item->order_status == 1){
                                echo "Order Delivered to destination on ".date("jS M, Y", strtotime($item->delivery_date)) . "<i class='fas fa-check'></i>";
                            }elseif($item->order_status == -1){
                                echo "<span style='color:red;'>Order Cancelled by seller on ".date("jS M, Y", strtotime($item->delivery_date)) . " <i style='color:red' class='fas fa-plane-slash'></i></span>";
                            }else{
                                echo "<span>Order Delivered to Destination <i class='fas fa-spinner'></i></span>";
                            }
                        ?></li>
                    </ul>
                </div>
                <?php endforeach; }?>
            </div>
        </section>
        <section id="just_in">
            <?php
                 $select_featured = $connectdb->prepare("SELECT * FROM menu WHERE /* item_name != :item_name AND  */item_category LIKE '%$item->item_category%'AND item_id != :item_id ORDER BY time_created LIMIT 6");
                 $select_featured->bindvalue("item_id", $item->item_id);
                 $select_featured->execute();
                 if($select_featured->rowCount() > 0){
            ?>
            <h2>Items you may like</h2>
            <div class="all_items">

                <?php
                    $shows = $select_featured->fetchAll();
                    foreach($shows as $show):
                ?>
                <figure>
                    <a href="javascript:void(0);" onclick="showItems('<?php echo $show->item_id?>')">
                        <img src="<?php echo '../items/'.$show->item_foto?>" alt="Item" loading="lazy">

                    </a>
                    <form action="../controller/cart.php" method="POST">
                        <input type="hidden" name="cart_item_id" id="cart_item_id" value="<?php echo $show->item_id?>">
                        <input type="hidden" name="cart_item_name" id="cart_item_name" value="<?php echo $show->item_name?>">
                        <input type="hidden" name="cart_item_price" id="cart_item_price" value="<?php echo $show->item_prize?>">
                        <input type="hidden" name="cart_item_restaurant" id="cart_item_restaurant" value="<?php echo $show->company?>">
                        <input type="hidden" name="customer" id="customer" value="<?php echo $id?>">
                        <input type="hidden" id="quantity" name="quantity" value="1">
                        <figcaption>
                            <div class="todo">
                                <p class="first"><?php echo $show->item_name?></p>
                                <p><i class="fas fa-store"></i> Realcare</p>
                                <!-- <p><?php echo $show->item_category?></p> -->
                                <span>₦ <?php echo number_format($show->item_prize)?></span>
                            </div>
                            <button type="submit" name="add_to_cart" id="add_to_cart" title="add to cart" class="add_cart"><i class="fas fa-shopping-cart"></i></button>
                        </figcaption>
                    </form>
                </figure>
                
                <?php endforeach ?>
            </div>
            <?php }?>
            <!-- <button id="view_more">View more</button>
            <button id="show_less">Show less</button> -->
        </section>
        <!-- <section id="shop" class="row">
            
        </section> -->
        
    </main>
    <?php
        /* if(isset($_SESSION['error_box'])){
            echo "<div class='error_box'><p>" . $_SESSION['error_box'] . "</p>
            <button id='close_error'>Ok</button></div>";
            unset($_SESSION['error_box']);
        } */
    ?>
    <footer>
        <?php include "footer.php";?>
    </footer>
    <!-- <script src="bootstrap.min.js"></script> -->
    <script src="../controller/jquery.js"></script>
    <script src="../controller/script.js"></script>
    
</body>
</html>

<?php
    }else{
        header("Location: ../index.php");
    }
?> 