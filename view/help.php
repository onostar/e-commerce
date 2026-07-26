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
    <link rel="stylesheet" href="../controller/style.css">
    
</head>
<body>
    <?php include "header.php";?>

    <?php include "mobile_menu.php";?>

    <main>
        <section id="helpNotes">
            <figure class="help_banner">
                <div class="help_img">
                    <img src="../images/place_order3.jpg" alt="order & track banner">
                </div>
                <figcaption>
                    <h2>How to Place & track orders</h2>
                    <i class="fas fa-truck-moving"></i>
                    <!-- <img src="../images/tracking_order.png" alt="orders"> -->
                <figcaption>
            </figure>
            <div class="all_helps">
                <div class="help_links">
                    <p class="help_link active_help" data-page="placeOrder">Place order</p>
                    <p class="help_link" data-page="trackOrder">Track order</p>
                    <p class="help_link" data-page="DeliveryTimeline">Delivery time line</p>
                    <p class="help_link" data-page="FAQ">Frequently asked questions</p>
                </div>
                <div class="help_details" id="placeOrder">
                    <div class="place_order_tips">
                        <div class="tips_img">
                            <img src="../images/place_order2.jpg" alt="order tips">
                        </div>
                        <div class="order_tips">
                            <p><strong>To place an order, kindly follow the steps below:</strong></p>
                            <ol>
                                <li>search for an item you want</li>
                                <li>Click on view item to view details or click on the add to cart icon</li>
                                <li>Proceed to your cart by clicking on the cart icon top right of your screen</li>
                                <li>Complete order by clicking on confirm order</li>
                                <li>Proceed to payment</li>
                                <li>Complete payment and wait for delivery</li>
                            </ol>
                        </div>
                    </div>
                </div>
                <div class="help_details" id="trackOrder">
                    <div class="place_order_tips">
                        <div class="tips_img">
                            <img src="../images/track_order.png" alt="order tips">
                        </div>
                        <div class="order_tips">
                            <p>To track your orders kindly follow the steps below</p>
                            <ol>
                                <li>From your account, click on <strong>my orders</strong></li>
                                <li>Click on show details on the order you wish to track</li>
                                <li>Click on track item button to see the delivery details of your order</li>
                                
                            </ol>
                        </div>
                    </div>
                </div>
                <div class="help_details" id="DeliveryTimeline">
                    <p>Delivery timelines varies with different products. Your order delivery is dependent on immediate availability of product.</p>
                    <p>You can check the delivery status of the product y tracking it from your account.</p>
                </div>
                <div class="help_details" id="FAQ">
                    <h3>How can we be of help?</h3>
                    <div id="helpCenter">
                        <ul>
                            <!-- <li>
                                <h4 data-page="how_add_items" class="faqs"> How do i contact a seller <i class="fas fa-chevron-down"></i></h4>
                                <p id="how_add_items" class="faq_notes">Click on an item you want to order and click on send us a dm to contact the seller. Or Click on companies or stores on the home page and select your desired seller to communicate with.<br>
                                Now click on the whatsapp icon to start chatting with the seller.
                                </p>
                            </li> -->
                            <li>
                                <h4 data-page="how_change_price" class="faqs">Can i add more than one item to my cart? <i class="fas fa-chevron-down"></i></h4>
                                <p id="how_change_price" class="faq_notes">Yes! Simply select the item you want to order and add to cart. Search for another and add to cart.<br>When you are done, head on to your cart to complete your order</p>
                            </li>
                            <li>
                                <h4 data-page="how_deactivate" class="faqs">How do i make payments <i class="fas fa-chevron-down"></i></h4>
                                <p id="how_deactivate" class="faq_notes">Payments on Rivicos online store is done on your check out.<br>
                            Click on your cart, you will see the total due. click on make payment, you can use your card or online transfer to teh account displayed on the screen, to complete your order.</p>
                            </li>
                            <li>
                                <h4 data-page="how_incoming_orders" class="faqs">Can i order items without signing in? <i class="fas fa-chevron-down"></i></h4>
                                <p id="how_incoming_orders" class="faq_notes">No. You must login for you to be able to add items to your cart. However, you can view the item info.</p>
                            </li>
                            <li>
                                <h4 data-page="how_deliveries" class="faqs">Are prices on Rivicos online store negotiable? <i class="fas fa-chevron-down"></i></h4>
                                <p id="how_deliveries" class="faq_notes">Prices for products are non-negotiable on Rivicos Online store. However, you can communicate with the Admin via whatsapp and establish a transaction.</p>
                            </li>
                            <li>
                                <h4 data-page="how_cancel_order" class="faqs">Are there any hidden cost if i order from Rivicos? <i class="fas fa-chevron-down"></i></h4>
                                <p id="how_cancel_order" class="faq_notes">All item prices are fixed and no extra charges from Rivicos. However, extra charges such as delivery fee may be charged by the seller</p>
                            </li>
                        </ul>
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
