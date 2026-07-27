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
    <link rel="stylesheet" href="../controller/style.css?v=<?php echo APP_VERSION?>">
    
</head>
<body>
    <?php include "header.php";?>

    <?php include "mobile_menu.php";?>

    
    <main>
        <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@500;600;700;800&family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@500;600;700;800&family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

<section id="itemContent">

    <style>
        #itemContent{
            --primary: #1674D5;
            --primary-dark: #0f5cab;
            --primary-tint: #E9F3FE;
            --secondary: #8DCE1F;
            --secondary-tint: #F0FAE1;
            --ink: #12203A;
            --muted: #6C7A93;
            --bg: #F5F8FC;
            --surface: #ffffff;
            --line: #E7EDF6;
            --danger: #C0392B;
            --danger-tint: #FBEAE8;
            --gradient: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);

            font-family: 'Nunito', system-ui, sans-serif;
            color: var(--ink);
            background: var(--bg);
            padding: 20px 4vw 60px;
            display: block;
        }

        #itemContent h3{
            font-family: 'Poppins', system-ui, sans-serif;
        }

        #itemContent hr{
            display: none;
        }

        .itemInfo{
            max-width: 1080px;
            margin: 0 auto;
        }

        /* ---------- Layout ---------- */
        .item_details{
            display: grid;
            grid-template-columns: 1fr;
            gap: 16px;
            margin: 0 0 16px;
        }

        /* ---------- Product image slider ---------- */
        .item_pics{
            position: relative;
            background: var(--surface);
            border-radius: 18px;
            box-shadow: 0 4px 18px rgba(18,32,58,.06);
            padding: 16px;
        }

        .slide_foto{
            position: relative;
            overflow: hidden;
            border-radius: 12px;
            background: linear-gradient(135deg, var(--primary-tint), #ffffff);
            aspect-ratio: 4 / 3;
            max-height: 220px;
        }

        .slide_foto img{
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            object-fit: contain;
            opacity: 0;
            transition: opacity .35s ease;
        }

        .slide_foto img.active{
            opacity: 1;
        }

        .arrows{
            position: absolute;
            top: 50%;
            left: 8px;
            right: 8px;
            display: flex;
            justify-content: space-between;
            transform: translateY(-50%);
            margin-top: -8px;
        }

        .arrows a{
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: rgba(255,255,255,.92);
            color: var(--ink);
            display: flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            font-size: .8rem;
            box-shadow: 0 3px 10px rgba(18,32,58,.15);
        }

        .dot_row{
            display: flex;
            justify-content: center;
            gap: 6px;
            margin-top: 10px;
        }

        .dot_row button{
            width: 7px;
            height: 7px;
            border-radius: 50%;
            border: none;
            background: #d3ddec;
            padding: 0;
            cursor: pointer;
        }

        .dot_row button.active{
            width: 20px;
            border-radius: 999px;
            background: var(--gradient);
        }

        /* ---------- Order info card ---------- */
        .item_details form{
            margin: 0;
        }

        figcaption{
            background: var(--surface);
            border-radius: 18px;
            box-shadow: 0 4px 18px rgba(18,32,58,.06);
            padding: 20px;
        }

        .menu_logo{
            display: none;
        }

        .clear{
            display: none;
        }

        figcaption > p{
            display: flex;
            gap: 8px;
            margin: 0;
            padding: 9px 0;
            border-bottom: 1px solid var(--line);
            font-size: .88rem;
        }

        figcaption > p:first-of-type{
            padding-top: 0;
        }

        figcaption > p span{
            color: var(--muted);
            font-weight: 600;
            min-width: 118px;
            flex-shrink: 0;
        }

        figcaption > p:nth-of-type(5){
            font-weight: 800;
            color: var(--primary);
            font-size: .96rem;
        }

        /* ---------- Action buttons ---------- */
        #track, .cancel_order, .item_details .dm a{
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            width: 100%;
            box-sizing: border-box;
            margin-top: 12px;
            padding: 12px 16px;
            border-radius: 12px;
            font-family: 'Poppins', sans-serif;
            font-weight: 600;
            font-size: .9rem;
            text-decoration: none;
            cursor: pointer;
            transition: filter .15s ease, background .15s ease, color .15s ease;
        }

        #track{
            background: var(--gradient);
            color: #fff !important;
        }

        #track:hover{
            filter: brightness(1.05);
        }

        .cancel_order{
            background: transparent;
            color: var(--danger) !important;
            border: 1.5px solid var(--danger-tint);
        }

        .cancel_order:hover{
            background: var(--danger);
            color: #fff !important;
            border-color: var(--danger);
        }

        .item_details .dm{
            margin: 0;
        }

        .item_details .dm a{
            background: var(--secondary-tint);
            color: #4c7a12 !important;
            font-weight: 700;
        }

        .item_details .dm a:hover{
            filter: brightness(.96);
        }

        /* ---------- Order details / tracking timeline ---------- */
        .item_descriptions{
            background: var(--surface);
            border-radius: 18px;
            box-shadow: 0 4px 18px rgba(18,32,58,.06);
            padding: 20px 22px;
        }

        .item_descriptions h3{
            font-size: 1.05rem;
            font-weight: 700;
            margin: 0 0 18px;
        }

        .item_descriptions ul{
            list-style: none;
            margin: 0;
            padding: 0;
        }

        .item_descriptions li{
            position: relative;
            padding: 0 0 24px 34px;
            font-size: .9rem;
            color: var(--ink);
            font-weight: 600;
        }

        .item_descriptions li:last-child{
            padding-bottom: 0;
        }

        /* connecting line */
        .item_descriptions li::before{
            content: '';
            position: absolute;
            left: 10px;
            top: 22px;
            bottom: -2px;
            width: 2px;
            background: var(--line);
        }

        .item_descriptions li:last-child::before{
            display: none;
        }

        /* step dot / icon */
        .item_descriptions li i,
        .item_descriptions li span i{
            position: absolute;
            left: 0;
            top: 0;
            width: 22px;
            height: 22px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: .68rem;
            color: #fff;
            background: var(--muted);
        }

        /* completed steps: a fa-check icon as direct child of the li */
        .item_descriptions li > i.fa-check{
            background: var(--secondary);
        }

        .item_descriptions li span{
            font-weight: 600;
            color: var(--muted);
        }

        .item_descriptions li span i.fa-spinner{
            background: var(--primary);
        }

        .item_descriptions li span i.fa-ban,
        .item_descriptions li span i.fa-plane-slash{
            background: var(--danger);
        }

        .item_descriptions li span[style*="color:red"]{
            color: var(--danger) !important;
            font-weight: 700;
        }

        /* ---------- Desktop: two-column layout ---------- */
        @media (min-width: 860px){
            .item_details{
                grid-template-columns: 320px 1fr;
                align-items: start;
            }

            .item_pics{
                position: sticky;
                top: 24px;
            }

            .slide_foto{
                max-height: 280px;
            }

            #track, .cancel_order, .item_details .dm a{
                display: inline-flex;
                width: auto;
            }

            .action_row{
                display: flex;
                flex-wrap: wrap;
                gap: 10px;
                margin-top: 6px;
            }

            .action_row > *{
                margin-top: 0 !important;
            }
        }
    </style>

    <div class="itemInfo">
        <?php
            if(isset($_GET['order'])){
                $order_id = $_GET['order'];


                $view_item = $connectdb->prepare("SELECT orders.customer, orders.item_id, orders.quantity, orders.item_price, orders.company, orders.order_date, orders.order_number, orders.order_status, orders.delivery_date, orders.order_id, orders.dispense_date, menu.item_name, menu.item_foto, menu.other_foto, menu.payment_option, users.company_name, menu.item_category FROM orders, menu, users WHERE orders.order_id = :order_id AND orders.item_id = menu.item_id AND menu.company = users.user_id ORDER BY orders.order_date DESC");
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
                <div class="slide_foto">
                    <img class="active" src="<?php echo '../items/'.$item->item_foto?>" alt="<?php echo $item->item_name?>" loading="lazy">
                    <img src="<?php echo '../items/'.$item->other_foto?>" alt="<?php echo $item->item_name?>" loading="lazy">
                </div>
                <div class="arrows">
                    <a class="left_arrow" href="javascript:void(0)" aria-label="Previous photo"><i class="fas fa-chevron-left"></i></a>
                    <a class="right_arrow" href="javascript:void(0)" aria-label="Next photo"><i class="fas fa-chevron-right"></i></a>
                </div>
                <div class="dot_row">
                    <button type="button" class="active" onclick="showSlide(0)" aria-label="Photo 1"></button>
                    <button type="button" onclick="showSlide(1)" aria-label="Photo 2"></button>
                </div>
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

                    <div class="action_row">
                        <a href="javascript:void(0)" id="track">Track item <i class="fas fa-cart-plus"></i></a>
                        <?php
                            if($item->order_status == 0){
                        ?>
                        <a class="cancel_order" href="javascript:void(0)" title="Cancel Order" onclick="cancelOrder('<?php echo $item->order_id?>')">Cancel Order <i class="fas fa-plane-slash"></i></a>
                        <?php }?>
                        <?php
                            if($item->order_status == 2){
                        ?>
                        <a href="item_review.php?item=<?php echo $item->item_id?>"  id="track" style="background:var(--gradient)">Add review <i class="fas fa-star"></i><i class="fas fa-star"></i></a>
                        <?php }?>
                        <p class="dm"><?php echo "<a target='_blank' href='https://wa.me/+2347055220617' title='Message Store owner'><i class='fab fa-whatsapp'></i> Send us a Message</a>";?></p>
                    </div>
                </figcaption>
            </form>
        </figure>
        <div class="item_descriptions" id="trackItem">
            <hr>
            <h3>Order details</h3>
            <ul>
                <li><i class="fas fa-check"></i>Order Placed on <?php echo date("jS M, Y", strtotime($item->order_date));?></li>
                <li><i class="fas fa-check"></i>Order Processing</li>
                <li><?php
                    if($item->order_status == 1){
                        echo "<i class='fas fa-check'></i>Order Shipped for delivery on ".date("jS M, Y", strtotime($item->dispense_date));
                    }elseif($item->order_status == -1){
                        echo "<span>Order Shipped for delivery <i class='fas fa-ban'></i></span>";
                    }else{
                        echo "<span>Order Shipped for delivery <i class='fas fa-spinner'></i></span>";
                    }
                ?></li>
                <li><?php
                    if($item->order_status == 2){
                        echo "<i class='fas fa-check'></i>Order Delivered to destination on ".date("jS M, Y", strtotime($item->delivery_date));
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

<script>
    (function(){
        const slides = document.querySelectorAll('#itemContent .slide_foto img');
        const dots = document.querySelectorAll('#itemContent .dot_row button');
        let current = 0;

        window.showSlide = function(index){
            if(!slides.length) return;
            current = (index + slides.length) % slides.length;
            slides.forEach((img, i) => img.classList.toggle('active', i === current));
            dots.forEach((d, i) => d.classList.toggle('active', i === current));
        };

        const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
        const supportsHover = window.matchMedia('(hover: hover)').matches;
        let autoplayTimer = null;

        function startAutoplay(){
            if(prefersReducedMotion || slides.length < 2) return;
            autoplayTimer = setInterval(() => showSlide(current + 1), 4000);
        }

        function restartAutoplay(){
            if(autoplayTimer) clearInterval(autoplayTimer);
            startAutoplay();
        }

        const left = document.querySelector('#itemContent .left_arrow');
        const right = document.querySelector('#itemContent .right_arrow');
        if(left) left.addEventListener('click', () => { showSlide(current - 1); restartAutoplay(); });
        if(right) right.addEventListener('click', () => { showSlide(current + 1); restartAutoplay(); });
        dots.forEach((d, i) => d.addEventListener('click', () => { showSlide(i); restartAutoplay(); }));

        const gallery = document.querySelector('#itemContent .item_pics');
        if(gallery && supportsHover){
            gallery.addEventListener('mouseenter', () => autoplayTimer && clearInterval(autoplayTimer));
            gallery.addEventListener('mouseleave', restartAutoplay);
        }

        startAutoplay();
    })();
</script>
        <section id="just_in">
            <?php
                 $select_featured = $connectdb->prepare("SELECT * FROM menu WHERE /* item_name != :item_name AND  */item_category LIKE '%$item->item_category%'AND item_id != :item_id ORDER BY RAND() LIMIT 5");
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
                    <a href="item_info.php?item=<?php echo $show->item_id ?>">
                        <img src="<?php echo '../items/'.$show->item_foto?>" alt="<?php echo $show->item_name?>" loading="lazy">

                    

                   
                        <figcaption>
                            <div class="todo">
                                <p style="color:rgb(66, 66, 66)!important"><?php echo $show->item_name?>...</p>
                                
                                <span>₦ <?php echo number_format($show->item_prize)?></span>
                                <?php if($show->item_prize < $show->previous_price){?>
                                    <span class="previous_price">₦<?php echo number_format($show->previous_price)?></span>
                                <?php }?>
                            </div>

                            <?php
                                if($show->item_prize < $show->previous_price){
                            ?>
                            <div class="percentage">
                                <?php
                                    $percent = (($show->previous_price - $show->item_prize) / $show->previous_price) * 100;
                                ?>
                                <p style="color:#2e2d2d">-<?php echo number_format($percent);?>%</p>
                            </div>
                            <?php }?>
                        </figcaption>
                    </a> 
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
    <script src="../controller/script.js?v=<?php echo APP_VERSION?>"></script>
    
</body>
</html>

<?php
    }else{
        header("Location: ../index.php");
    }
?> 