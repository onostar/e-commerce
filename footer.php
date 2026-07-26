<footer>
        <section class="mainFooter">
            <section class="mainFooter1">
                <div class="subscribe_category">
                    
                    <div class="category">
                        <!-- <h3>Quick Links</h3> -->
                        <div class="categories">
                            <!-- <li><a href="contact.php">Contact us</a></li> -->
                            <!-- <li><a href="view/sellers.php" title="Become a seller on Clozeth">Open an online store</a></li> -->
                            <li><a href="view/report_product.php" title="Report a product">Report a product</a></li>
                            <li><a href="view/exhibitors.php" title="View official stores">Stores</a></li>
                            <li><a href="javascript:void(0);" title="Terms and conditions">Terms & conditions</a></li>
                            <li><a href="view/help_center.php" title="help">Help center</a></li>
                        </div>
                    </div>
                </div>
            </section>
        </section>
        <div class="socialLinks">
            <a target="_blank" href="https://facebook.com/rivicos" title="Follow Rivicos on facebook" style="color:#4267B2"><i class="fab fa-facebook-square"></i></a>
            <a target="_blank" href="https://twitter.com/rivicos" title="Follow Rivicos on X" style="color:#1DA1F2"><i class="fab fa-twitter-square"></i></a>
            <a target="_blank" href="#" title="Follow Rivicos on instagram" style="color:#cd486b"><i class="fab fa-instagram-square"></i></a>
            <!-- <a target="_blank" href="#" title="Follow Clozeth on Linkedin" style="color:#0072b1"><i class="fab fa-linkedin"></i></a> -->
            <!-- <a target="_blank" href="#" title="Join us on whatsapp" style="color:#25D366"><i class="fab fa-whatsapp"></i></a> -->
        </div>
        <section class="secondaryFooter">
            <p>&copy;<?php echo date("Y")?> Rivicos supermarket. All Rights Reserved.</p>
        </section>
    </footer>

    
    <div class="toTop">
        <a href="#banner" title="Go to top"><i class="fas fa-chevron-up"></i></a>
    </div>
    <!-- check cart and display checkout button -->
    <?php
        if(isset($_SESSION['user'])){
            $cart_num = $connectdb->prepare("SELECT * FROM cart WHERE customer = :customer");
            $cart_num->bindvalue('customer', $id);
            $cart_num->execute();

            if($cart_num->rowCount() > 0){
                $get_total = $connectdb->prepare("SELECT SUM(item_price * quantity) AS total_prize FROM cart WHERE customer = :customer");
                $get_total->bindvalue('customer', $id);
                $get_total->execute();
                $totals = $get_total->fetchAll();
                foreach($totals as $total){
                    $total_price = $total->total_prize;
                }
            ?>
                <div class="checkout">
                    <a href="view/shopping_cart.php"><i class="fas fa-shopping-cart"></i> Checkout <?php echo "₦".number_format($total_price, 2)?></a>
                </div>
            <?php
            }
        }
    ?>
    <!-- add to cart success box -->
    <?php
        if(isset($_SESSION['cart_added'])){
    ?>
        <div class="success_box" id="success_box">
            <p>Item added to cart!</p>
            <i class="fas fa-check"></i>
        </div> 
            
    <?php 
        unset($_SESSION['cart_added']);
        }
    ?>
    <!-- already in cart failure box -->
    <?php
        if(isset($_SESSION['cart_already'])){
    ?>
        <div class="success_box" id="failure_box">
            <p>Item already in your cart!<br>Proceed to check out</p>
            <i class="fas fa-cancel"></i>
        </div> 
            
    <?php 
        unset($_SESSION['cart_already']);
        }
    ?>
    <!-- reports and review notifications -->
    <?php
        if(isset($_SESSION['reported'])){
    ?>
        <div class="success_box" id="success_box">
            <p><?php echo $_SESSION['reported']?></p>
            <i class="fas fa-check"></i>
        </div> 
            
    <?php 
        unset($_SESSION['reported']);
        }
    ?>
    <script>
        // close add to cart success box
        setTimeout(function(){
            $(".success_box").hide();
        },4000);
        // close already cart success box
        setTimeout(function(){
            $("#failure_box").hide();
        },4000);
    </script>
