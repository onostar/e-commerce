<footer>
        <section class="mainFooter">
            <section class="mainFooter1">
                <div class="subscribe_category">
                    
                    <div class="category">
                        <!-- <h3>Quick Links</h3> -->
                        <div class="categories">
                            <!-- <li><a href="contact.php">Contact us</a></li> -->
                            <!-- <li><a href="sellers.php" title="Become a seller on Clozeth">Open an online store</a></li> -->
                            <li><a href="report_product.php" title="Report a product">Report a product</a></li>
                            <li><a href="exhibitors.php" title="View official stores">Stores</a></li>
                            <li><a href="javascript:void(0);" title="Terms and conditions">Terms & conditions</a></li>
                            <li><a href="help_center.php" title="Realcare help">Help center</a></li>
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
            <p>&copy;<?php echo date("Y")?> Rivicos Supermarket. All Rights Reserved.</p>
        </section>
    </footer>
    <!-- call us -->
    <div class="floating-contact">

        <a href="tel:+2347055220617" class="call-btn">

            <i class="fas fa-phone-alt"></i>

            <span>Call Us<br><strong>0705 522 0617</strong></span>

        </a>

    </div>
    
    <!-- <div class="toTop">
        <a href="#banner" title="Go to top"><i class="fas fa-chevron-up"></i></a>
    </div> -->
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
                    <a href="shopping_cart.php"><i class="fas fa-shopping-cart"></i> Checkout <?php echo "₦".number_format($total_price, 2)?></a>
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
    <!-- submission success messge  -->
    <?php
        if(isset($_SESSION['reported'])){
    ?>
        <div class="success_box" id="success_box">
            <p>Your ticket was submitted successfully. We will get in touch with you shortly!</p>
            <i class="fas fa-check"></i>
        </div> 
            
    <?php 
        unset($_SESSION['reported']);
        }
    ?>
<script>
  
            setTimeout(function(){
                $(".success_box").hide();
            }, 3000);
        
        /* show help center notes */
        function showHelp(notes){
            document.querySelectorAll('.help_details').forEach(div =>{
                div.style.display = "none";
            });
            /* document.querySelectorAll('.help_link').forEach(links =>{
                links.onclick = function(){
                    links.classList.add("active_help");
                }
            }); */
            document.querySelector(`#${notes}`).style.display = "block";

        }
        //make links clickable to get to its respective page
        document.addEventListener("DOMContentLoaded", function(){
            document.querySelectorAll(".help_link").forEach(helps => {
                helps.onclick = function(){
                    // helps.classList.add('.active_help');
                    showHelp(this.dataset.page);
                }
            })
        })


        /* show frequenty asked questions */
        function showFaq(faq){
            //hide all pages when one displays
            // page.preventDefault();
            document.querySelectorAll(".faq_notes").forEach(div =>{
                div.style.display = "none";
            });
            document.querySelector(`#${faq}`).style.display = "block";
            document.querySelectorAll(".faqs i").forEach(arrows =>{
                arrows.innerHTML = "<i class='fas fa-chevron-up></i>'";
            })

        }
        //make links clickable to get to its respective page
        document.addEventListener("DOMContentLoaded", function(){
            document.querySelectorAll(".faqs").forEach(faqs => {
                faqs.onclick = function(){
                    showFaq(this.dataset.page);
                }
            })
        })
        // close add to cart success box
        setTimeout(function(){
            $(".success_box").hide();
        },4000);
        // close already cart success box
        setTimeout(function(){
            $("#failure_box").hide();
        },4000);
</script>