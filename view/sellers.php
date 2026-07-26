<?php
    require "../controller/server.php";
    session_start();
    $_SESSION['current_page'] = $_SERVER['REQUEST_URI'];


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Get your own online store on clozeth and display your products to the world. Upload items, manage orders and deliver to clients">
    <meta name="keywords" content="Fashion, fashion store, clothings, men, women, men wears, women wears, jewellry, jewellries, rings, earings, wrist watch, eye glass, glass, shoes, order, ordering">
    <title>
        <?php
            if(isset($_SESSION['user'])){
                $user = $_SESSION['user'];
                $user_info = $connectdb->prepare("SELECT * FROM shoppers WHERE email = :email");
                $user_info->bindvalue('email', $user);
                $user_info->execute();
                $view = $user_info->fetch();
                echo $view->first_name . " " . $view->last_name. " - Sell on Clozeth";
            }else{
                echo "Sell on Clozeth";
            }
         ?>

    </title>
    <!-- <link rel="stylesheet" href="bootstrap.min.css"> -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="../fontawesome-free-5.15.1-web/css/all.css">
    <link rel="stylesheet" href="../fontawesome-free-6.0.0-web/css/all.css">
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
                    <img src="../images/sell_online.jpg" alt="order & track banner">
                </div>
                <figcaption>
                    <h2>Become a seller on Clozeth</h2>
                    <i class="fas fa-box-check"></i>
                <figcaption>
            </figure>
            <div class="all_helps">
                <div class="help_links">
                    <p class="help_link active_help" data-page="placeOrder">Why sell on clozeth</p>
                    
                </div>
                <div class="help_details" id="placeOrder">
                    <div class="place_order_tips">
                        <div class="tips_img">
                            <img src="../images/online_shop2.jpg" alt="order tips">
                        </div>
                        <div class="order_tips">
                            <p><strong>Ready to sell? Launch your brand today on clozeth with great benefits.</strong></p>
                            <ul>
                                <li><i class="fas fa-check"></i> Get connected with more customers</li>
                                <li><i class="fas fa-check"></i> Sell more products with different designs</li>
                                <li><i class="fas fa-check"></i> Top notch 24/7 online seller support</li>
                                <li><i class="fas fa-check"></i> Improve your revenue by reaching out to more customers</li>
                                <li><i class="fas fa-check"></i> Free online/offline training</li>
                                <li><i class="fas fa-check"></i> Manage your orders and your customer records</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="how_it_works">
                    <p class="help_link">How it works</p>
                    <div class="how_works">
                        <div class="steps">
                            <img src="../images/online_store.jpg" alt="seller">
                            <h4>Step 1: Register a free account</h4>
                            <p>Fill in the registration form with your details (company name, phone number, etc) to get free access to sell on clozeth.</p>
                        </div>
                        <div class="steps">
                            <img src="../images/sell_online.jpg" alt="seller">
                            <h4>Step 2: Become an e-commerce expert</h4>
                            <p>Go through the training and activate your account to start uploading items</p>
                        </div>
                        <div class="steps">
                            <img src="../images/place_order3.jpg" alt="seller">
                            <h4>Step 3: Add your products and sell</h4>
                            <p>Upload your best sellng products with prices and description and start selling</p>
                        </div>
                        <div class="steps">
                            <img src="../images/onlinie_shop.jpg" alt="seller">
                            <h4>Step 4: Benefit from our marketing and promotions</h4>
                            <p>Get more customers, and insights from our promotions.</p>
                        </div>
                    </div>
                </div>
                
                <div class="start_selling">
                    <a href="../admin/views/company_registration.php">Start selling</a>
                </div>
                
            </div>
        </section>
        
    </main>
    <?php include "footer.php"?>
    <script src="../controller/jquery.js"></script>
    <script src="../controller/script.js"></script>
    
</body>
</html>
