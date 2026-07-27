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
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@500;600;700;800&family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

<section id="shoppingCart">

    <style>
        #shoppingCart{
            --primary: #1674D5;
            --primary-dark: #0f5cab;
            --primary-tint: #E9F3FE;
            --secondary: #8DCE1F;
            --secondary-tint: #F0FAE1;
            --ink: #12203A;
            --muted: #3d3e3f;
            --bg: #F5F8FC;
            --surface: #ffffff;
            --line: #E7EDF6;
            --danger: #C0392B;
            --gradient: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);

            font-family: 'Nunito', system-ui, sans-serif;
            color: var(--ink);
            background: var(--bg);
            padding: 20px 4vw 100px;
            display: block;
        }

        #shoppingCart h2, #shoppingCart h3{
            font-family: 'Poppins', system-ui, sans-serif;
        }

        #shoppingCart hr{
            display: none;
        }

        .cart_header{
            max-width: 1080px;
            margin: 0 auto 16px;
        }

        .cart_header h2{
            font-size: 1.4rem;
            font-weight: 700;
            margin: 0;
        }

        /* ---------- Status banner ---------- */
        .status_banner{
            max-width: 1080px;
            margin: 0 auto 16px;
            padding: 12px 16px;
            border-radius: 12px;
            font-size: .9rem;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .status_banner.success{
            background: var(--secondary-tint);
            color: #4c7a12;
        }

        .status_banner.error{
            background: #FBEAE8;
            color: var(--danger);
        }

        /* ---------- Layout ---------- */
        .shop_cart{
            max-width: 1080px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: 1fr;
            gap: 20px;
        }

        .cart_items{
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        /* ---------- Cart item card ---------- */
        .cart_items figure{
            background: var(--surface);
            border-radius: 16px;
            box-shadow: 0 4px 18px rgba(18,32,58,.06);
            padding: 14px;
            display: flex;
            gap: 14px;
            margin: 0;
        }

        .cart_items figure img{
            width: 78px;
            height: 78px;
            object-fit: contain;
            background: var(--primary-tint);
            border-radius: 12px;
            flex-shrink: 0;
        }

        .cart_items figcaption{
            flex: 1;
            display: flex;
            flex-direction: column;
            gap: 2px;
        }

        .cart_items figcaption > p:first-child{
            font-family: 'Poppins', sans-serif;
            font-size: .9rem;
            font-weight: normal;
            margin: 0 0 4px;
        }

        .cart_items figcaption p{
            margin: 0;
            font-size: .85rem;
            color: var(--muted);
        }

        .cart_items figcaption p span{
            color: var(--ink);
            font-weight: 700;
        }

        .cart_items figcaption p[style*="green"]{
            color: var(--muted) !important;
            font-size: .9rem;
            font-weight: 700;
            margin-top: 2px;
        }

        .cart_items figcaption p[style*="green"] span{
            color: var(--muted) !important;
        }

        .action{
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-top: 10px;
        }

        .action form{
            margin: 0;
        }

        .qty_stepper{
            display: inline-flex;
            align-items: center;
            border: 1.5px solid var(--line);
            border-radius: 10px;
            overflow: hidden;
        }

        .qty_stepper button{
            width: 28px;
            height: 32px;
            border: none;
            background: #f2f5fa;
            color: var(--ink);
            font-size: 1rem;
            cursor: pointer;
        }

        .qty_stepper button:hover{
            background: var(--primary);
            color: #fff;
        }

        .action input[type="number"]{
            width: 38px;
            height: 32px;
            border: none;
            border-left: 1px solid var(--line);
            border-right: 1px solid var(--line);
            text-align: center;
            font-size: .88rem;
            font-weight: 700;
            -moz-appearance: textfield;
        }

        .action input[type="number"]::-webkit-outer-spin-button,
        .action input[type="number"]::-webkit-inner-spin-button{
            -webkit-appearance: none;
            margin: 0;
        }

        #remove_item{
            width: 34px;
            height: 34px;
            border-radius: 10px;
            background: #FBEAE8;
            color: var(--danger);
            display: flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            font-size: .9rem;
            transition: background .15s ease;
        }

        #remove_item:hover{
            background: var(--danger);
            color: #fff;
        }

        .empty{
            background: var(--surface);
            border-radius: 16px;
            padding: 40px 20px;
            text-align: center;
            color: var(--muted);
            font-weight: 600;
        }

        /* ---------- Order summary card ---------- */
        .total{
            background: var(--surface);
            border-radius: 18px;
            box-shadow: 0 8px 28px rgba(18,32,58,.08);
            padding: 22px;
        }

        .total h3{
            font-size: 1.05rem;
            font-weight: 700;
            margin: 0 0 14px;
        }

        .total_per_item{
            display: flex;
            align-items: center;
            justify-content: space-between;
            font-size: .9rem;
            color: var(--muted);
            margin: 0 0 12px;
        }

        .total_per_item span{
            color: var(--ink);
            font-weight: 700;
        }

        #delivery_option{
            width: 100%;
            padding: 11px 12px !important;
            border: 1.5px solid var(--line);
            border-radius: 10px;
            font-family: 'Nunito', sans-serif;
            font-size: .88rem;
            font-weight: 600;
            color: var(--ink);
            background: #fff;
            margin-bottom: 14px;
            appearance: none;
            background-image: url("data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='%236C7A93'><path d='M7 10l5 5 5-5z'/></svg>");
            background-repeat: no-repeat;
            background-position: right 10px center;
            background-size: 18px;
        }

        #item_grand_total{
            display: flex;
            align-items: center;
            justify-content: space-between;
            font-size: 1.05rem;
            font-weight: 800;
            margin: 4px 0 16px;
            padding-top: 12px;
            border-top: 1px dashed var(--line);
        }

        #item_grand_total span{
            color: var(--primary);
        }

        #del_address{
            margin-bottom: 16px;
        }

        #del_address label{
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: .8rem;
            font-weight: 700;
            color: var(--muted);
            margin-bottom: 6px;
        }

        #address{
            width: 100%;
            padding: 11px 12px;
            border: 1.5px solid var(--line);
            border-radius: 10px;
            font-family: 'Nunito', sans-serif;
            font-size: .88rem;
            color: var(--ink);
            box-sizing: border-box;
        }

        .clear_buttons{
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        #order{
            width: 100%;
            border: none;
            background: var(--gradient);
            color: #fff;
            font-family: 'Poppins', sans-serif;
            font-weight: 600;
            font-size: .95rem;
            padding: 14px 16px;
            border-radius: 12px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            transition: filter .15s ease;
        }

        #order:hover{
            filter: brightness(1.05);
        }

        #order:active{
            filter: brightness(.92);
        }

        #clear_cart{
            width: 100%;
            border: 1.5px solid var(--line);
            background: transparent;
            color: var(--muted);
            font-family: 'Nunito', sans-serif;
            font-weight: 700;
            font-size: .88rem;
            padding: 12px 16px;
            border-radius: 12px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            transition: border-color .15s ease, color .15s ease;
        }

        #clear_cart:hover{
            border-color: var(--danger);
            color: var(--danger);
        }

        /* ---------- Desktop: two-column layout ---------- */
        @media (min-width: 860px){
            .shop_cart{
                grid-template-columns: 1fr 360px;
                align-items: start;
                gap: 32px;
            }

            .total{
                position: sticky;
                top: 24px;
            }

            .cart_items figure img{
                width: 90px;
                height: 90px;
            }
        }
    </style>

    <div class="cart_header">
        <h2>My shopping cart</h2>
    </div>
    <hr>

    <?php
        $banner_class = '';
        $banner_icon = '';
        $banner_message = '';

        if(isset($_SESSION['success'])){
            $banner_class = 'success';
            $banner_icon = 'fa-circle-check';
            $banner_message = $_SESSION['success'];
            unset($_SESSION['success']);
        }elseif(isset($_SESSION['error'])){
            $banner_class = 'error';
            $banner_icon = 'fa-circle-exclamation';
            $banner_message = $_SESSION['error'];
            unset($_SESSION['error']);
        }
    ?>
    <?php if($banner_message !== ''): ?>
    <p class="successful status_banner <?php echo $banner_class?>"><i class="fas <?php echo $banner_icon?>"></i> <?php echo $banner_message?></p>
    <?php endif; ?>

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
                    <p>Unit price: ₦<span class="totalprice"><?php echo number_format($view->item_price)?></span></p>
                    <p style="color:green">Total amount: ₦<span id="totalprice" class="totalprice"><?php echo number_format($view->item_price * $view->quantity)?></span></p>
                    <div class="action">
                        <form>
                            <div class="qty_stepper">
                                <button type="button" onclick="stepCartQty(this, -1)" aria-label="Decrease quantity">&minus;</button>
                                <input type="number" name="quantity" id="quantity" value="<?php echo $view->quantity?>" oninput="updateQty(this.value, '<?php echo $view->item?>', '<?php echo $view->cart_id?>')">
                                <button type="button" onclick="stepCartQty(this, 1)" aria-label="Increase quantity">&plus;</button>
                            </div>
                            <input type="hidden" name="cart_id" value="<?php echo $view->cart_id?>">
                            <input type="hidden" name="item" value="<?php echo $view->item?>">
                        </form>

                        <a onclick="removeCartItem('<?php echo $view->cart_id?>')" href="javascript:void(0);" title="Remove item" id="remove_item"><i class="fas fa-trash"></i></a>
                    </div>

                </figcaption>
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
            <h3>Order summary</h3>
            <p class="total_per_item">Total: <span class="itemsTotal" id="itemTotals">₦<span id="itemTotal"> <?php
                $get_total = $connectdb->prepare("SELECT SUM(item_price * quantity) AS total_prize FROM cart WHERE customer = :customer");
                $get_total->bindvalue('customer', $id);
                $get_total->execute();
                $totals = $get_total->fetchAll();
                foreach($totals as $total){
            echo number_format($total->total_prize, 2);}?></span></span></p>
            <select name="delivery_option" id="delivery_option" onchange="selectDelivery(this.value)">
                <option value="">Select Delivery Option</option>
                <option value="Pick up">Pick up</option>
                <option value="Home Delivery">Home Delivery</option>
            </select>
            <p class="total_per_item">Delivery fee: <span><span id="delivery">₦2,000.00</span></span></p>
            <input type="hidden" id="delivery_fee" value="2000">
            <p class="total_per_item" id="item_grand_total">Grand Total:<span>₦<span id="grandTotal"></span></span></p>
            <input type="hidden" id="total_amount" name="total_amount">

            <div class="order_or_clear">
                <section class="order_form">
                    <input type="hidden" name="customer" id="customer" value="<?php echo $id?>">
                    <input type="hidden" name="email_address" id="email_address" value="<?php echo $user?>">
                    <div id="del_address">
                        <label>Delivery Address <i class="fas fa-pen"></i></label>
                        <input type="text" name="address" id="address" value="<?php
                            $get_address = $connectdb->prepare("SELECT address FROM shoppers WHERE user_id = :user_id");
                            $get_address->bindvalue("user_id", $id);
                            $get_address->execute();
                            $user_address = $get_address->fetch();
                            echo $user_address->address;
                        ?>">
                    </div>
                    <div class="clear_buttons">
                        <button onclick="order()" type="button" name="order" id="order">Proceed to Payment <i class="fas fa-wallet"></i></button>
                        <div class="clear_cart_form">
                            <input type="hidden" name="customer_clear" id="customer_clear" value="<?php echo $id;?>">
                            <button onclick="clearCart()" name="clear_cart" id="clear_cart">Clear Cart <i class="fas fa-trash"></i></button>
                        </div>
                    </div>
                </section>

            </div>
            <?php endif;?>
        </div>
    </div>

</section>

<script>
    function stepCartQty(button, delta){
        const stepper = button.closest('.qty_stepper');
        const input = stepper.querySelector('input[type="number"]');
        if(!input) return;
        const next = Math.max(1, (parseInt(input.value, 10) || 1) + delta);
        input.value = next;
        input.dispatchEvent(new Event('input', { bubbles: true }));
    }
</script>
        
        
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