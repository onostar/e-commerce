<?php
    require "controller/server.php";
    include "../admin/views/cache_control.php";
    session_start();
    $_SESSION['current_page'] = $_SERVER['REQUEST_URI'];
    /* get item details */
    if(isset($_GET['item'])){
        $item_id = $_GET['item'];
        $get_name = $connectdb->prepare("SELECT * FROM menu WHERE item_id = :item_id");
        $get_name->bindvalue("item_id", $item_id);
        $get_name->execute();
        $namess = $get_name->fetchAll();
        foreach($namess as $names){
            $item = $names->item_name;
            $item_desc = $names->item_description;
            $item_img = $names->item_foto;
            $item_com = $names->company;
        }
        
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?php
     echo $item. ' - ' .$item_desc?>">
    <meta name="keywords" content="Rivicos, online supermarket Nigeria, supermarket Benin City, groceries online, grocery delivery, food delivery, beverages, household essentials, toiletries, personal care, baby products, pharmacy, health products, supermarket near me, online shopping Nigeria, Rivicos supermarket, Rivicos online store, Rivicos delivery service, Rivicos products, Rivicos offers, Rivicos discounts, Rivicos deals, Rivicos promotions, Rivicos specials, Rivicos fresh foods, Rivicos beverages, Rivicos household items, Rivicos baby care, Rivicos personal care, Rivicos pharmacy items">
    <title>
        <?php
            
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
                echo $full_name. " - ".$item;
            }else{
                echo "Rivicos | ". $item;
            }
            
         ?>

    </title>
    <!-- <link rel="stylesheet" href="bootstrap.min.css"> -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="fontawesome-free-5.15.1-web/css/all.css">
    <link rel="stylesheet" href="fontawesome-free-6.0.0-web/css/all.css">
    <link rel="icon" type="image/png" href="<?php echo 'items/'.$item_img?>" size="32X32">
    <link rel="stylesheet" href="controller/style.css?v=<?php echo APP_VERSION?>">
    
</head>
<body>
    <?php include "header.php";?>

    <?php include "mobile_menu.php";?>

    
    <main>
        <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@500;600;700;800&family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

<section id="itemContent">

    <style>
        :root{
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
            --gradient: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
        }

        #itemContent{
            font-family: 'Nunito', system-ui, sans-serif;
            color: var(--ink);
            background: var(--bg);
            padding: 0 0 96px;
            max-width: 480px;
            margin: 0 auto;
            min-height: 100vh;
            position: relative;
        }

        #itemContent h1, #itemContent h2, #itemContent h3,
        .item_name, .app_bar span{
            font-family: 'Poppins', system-ui, sans-serif;
        }

        /* ---------- App bar ---------- */
        .app_bar{
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 10px 16px 6px;
        }

        .app_bar span{
            font-weight: 700;
            font-size: 1rem;
            color: var(--ink);
        }

        .icon_btn{
            width: 38px;
            height: 38px;
            border-radius: 50%;
            background: var(--surface);
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 2px 10px rgba(18,32,58,.08);
            color: var(--ink);
            text-decoration: none;
            font-size: .95rem;
        }

        /* ---------- Hero image ---------- */
        .itemInfo{
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .item_pics{
            position: relative;
            width: 92%;
            margin: 4px 0 0;
            background: var(--surface);
            padding: 14px 10px 14px;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(18,32,58,.10), 0 2px 8px rgba(18,32,58,.06);
            box-sizing: border-box;
        }

        .item_pics::before{
            content: '';
            position: absolute;
            top: 0;
            left: 22px;
            right: 22px;
            height: 4px;
            border-radius: 0 0 6px 6px;
            background: var(--gradient);
        }

        .info_block,
        #cart_form{
            width: 100%;
        }

        .slide_foto{
            position: relative;
            overflow: hidden;
            background: linear-gradient(135deg, var(--primary-tint), #ffffff);
            aspect-ratio: 4 / 3;
            max-height: 280px;
            border-radius: 16px;
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
            left: 0;
            right: 0;
            display: flex;
            justify-content: space-between;
            transform: translateY(-50%);
            padding: 0 10px;
        }

        .arrows a{
            width: 34px;
            height: 34px;
            border-radius: 50%;
            background: rgba(255,255,255,.9);
            color: var(--ink);
            display: flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            font-size: .85rem;
            box-shadow: 0 3px 10px rgba(18,32,58,.15);
        }

        .delivery_chip{
            position: absolute;
            top: 14px;
            left: 14px;
            background: rgba(255,255,255,.95);
            color: #8B4634;
            font-weight: 700;
            font-size: .74rem;
            padding: 6px 12px;
            border-radius: 999px;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .dot_row{
            display: flex;
            justify-content: center;
            gap: 6px;
            margin-top: 6px;
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

        /* ---------- Info block ---------- */
        .info_block{
            padding: 10px 20px 0;
        }

        .cat_pill{
            display: inline-block;
            background: var(--secondary-tint);
            color: #5c8a10;
            font-weight: 700;
            font-size: .7rem;
            letter-spacing: .03em;
            text-transform: uppercase;
            padding: 4px 11px;
            border-radius: 999px;
            margin-bottom: 6px;
        }

        .item_name{
            font-size: 1.05rem;
            font-weight: 700;
            line-height: 1.25;
            margin: 0 0 6px;
            text-transform: none;
        }

        .price_row{
            display: flex;
            align-items: baseline;
            gap: 10px;
            margin-bottom: 10px;
        }

        .item_price{
            font-size: 1.4rem;
            font-weight: 800;
            color: var(--primary);
        }

        .price_row small{
            color: var(--muted);
            font-weight: 600;
            font-size: .82rem;
        }

        /* ---------- Segmented tabs ---------- */
        .tabs{
            display: flex;
            background: var(--surface);
            border-radius: 14px;
            padding: 4px;
            gap: 4px;
            box-shadow: 0 2px 10px rgba(18,32,58,.05);
            margin-bottom: 14px;
        }

        .tabs button{
            flex: 1;
            border: none;
            background: transparent;
            padding: 10px 0;
            font-family: 'Nunito', sans-serif;
            font-weight: 700;
            font-size: .86rem;
            color: var(--muted);
            border-radius: 10px;
            cursor: pointer;
            transition: background .15s ease, color .15s ease;
        }

        .tabs button.active{
            background: var(--gradient);
            color: #fff;
        }

        .tab_panel{
            display: none;
            background: var(--surface);
            border-radius: 16px;
            padding: 18px 18px 4px;
            margin-bottom: 18px;
        }

        .tab_panel.active{
            display: block;
        }

        .item_descriptions p{
            color: var(--muted);
            line-height: 1.6;
            margin: 0 0 14px;
            font-size: .92rem;
        }

        .fact_row{
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 0;
            border-top: 1px solid var(--line);
            font-size: .86rem;
            color: var(--muted);
        }

        .fact_row:first-child{
            border-top: none;
        }

        .fact_row i{
            width: 30px;
            height: 30px;
            border-radius: 50%;
            background: var(--primary-tint);
            color: var(--primary);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: .8rem;
        }

        .fact_row span{
            color: var(--ink);
            font-weight: 700;
        }

        /* ---------- Reviews ---------- */
        .customer_reviews{
            display: flex;
            flex-direction: column;
            gap: 12px;
            padding-bottom: 12px;
        }

        .reviews{
            border-bottom: 1px solid var(--line);
            padding-bottom: 12px;
        }

        .reviews:last-child{
            border-bottom: none;
        }

        .reviews h4{
            display: flex;
            align-items: center;
            gap: 10px;
            margin: 0 0 6px;
            font-size: .9rem;
            font-weight: 700;
        }

        .reviews h4::before{
            content: attr(data-initial);
            width: 30px;
            height: 30px;
            border-radius: 50%;
            background: var(--secondary);
            color: #274700;
            font-size: .78rem;
            font-weight: 800;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .reviews p{
            margin: 0 0 4px;
            color: var(--muted);
            font-size: .88rem;
            line-height: 1.5;
            padding-left: 40px;
        }

        .rev_date{
            font-size: .74rem;
            color: #a7b1c4 !important;
        }

        .no_reviews{
            color: var(--muted);
            font-size: .88rem;
            text-align: center;
            padding: 10px 0;
        }

        /* ---------- Sticky bottom action bar ---------- */
        .action_bar{
            position: fixed;
            left: 0;
            right: 0;
            bottom: 0;
            max-width: 480px;
            margin: 0 auto;
            background: var(--surface);
            border-top: 1px solid var(--line);
            padding: 12px 16px;
            display: flex;
            align-items: center;
            gap: 10px;
            box-shadow: 0 -6px 20px rgba(18,32,58,.06);
            z-index: 20;
        }

        .qty_stepper{
            display: flex;
            align-items: center;
            border: 1.5px solid var(--line);
            border-radius: 12px;
            overflow: hidden;
            flex-shrink: 0;
        }

        .qty_stepper button{
            width: 32px;
            height: 42px;
            border: none;
            background: #f2f5fa;
            color: var(--ink);
            font-size: 1.1rem;
            cursor: pointer;
        }

        .qty_stepper input{
            width: 36px;
            height: 42px;
            border: none;
            border-left: 1px solid var(--line);
            border-right: 1px solid var(--line);
            text-align: center;
            font-size: .95rem;
            font-weight: 700;
        }

        .add_cart{
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            background: var(--gradient);
            color: #fff;
            border: none;
            border-radius: 12px;
            height: 42px;
            font-family: 'Poppins', sans-serif;
            font-size: .92rem;
            font-weight: 600;
            cursor: pointer;
            transition: filter .15s ease;
        }

        .add_cart:hover{
            filter: brightness(1.05);
        }

        .add_cart:active{
            filter: brightness(.92);
        }

        .wa_btn{
            width: 42px;
            height: 42px;
            border-radius: 12px;
            background: var(--secondary-tint);
            color: #5c8a10;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.15rem;
            text-decoration: none;
            flex-shrink: 0;
        }

        /* ==================================================
           Desktop layout — a normal two-column product page,
           not a stretched-out phone screen.
           ================================================== */
        @media (min-width: 900px){
            #itemContent{
                width: 50vw;
                max-width: 1000px;
                min-width: 720px;
                margin: 0 auto;
                padding: 0 0 60px;
            }

            .app_bar{
                max-width: 100%;
                margin: 0 auto;
                padding: 22px 0 10px;
            }

            .itemInfo{
                max-width: 100%;
                margin: 0 auto;
                display: grid;
                grid-template-columns: 1fr 1fr;
                grid-template-areas:
                    "pics info"
                    "pics buy";
                column-gap: 40px;
                row-gap: 0;
                align-items: start;
            }

            /* left column: image slider */
            .item_pics{
                grid-area: pics;
                width: 100%;
                margin: 0;
                position: sticky;
                top: 24px;
                padding: 18px 18px 20px;
            }

            .item_pics::before{
                left: 30px;
                right: 30px;
            }

            .slide_foto{
                aspect-ratio: 4 / 5;
                max-height: 520px;
                border-radius: 20px;
            }

            .arrows a{
                width: 44px;
                height: 44px;
                font-size: 1rem;
            }

            .dot_row{
                margin-top: 14px;
            }

            /* right column, top: name, price, tabs, description/reviews */
            .info_block{
                grid-area: info;
                padding: 0;
            }

            .item_name{
                font-size: 1.7rem;
            }

            .price_row{
                margin-bottom: 22px;
            }

            .item_price{
                font-size: 2rem;
            }

            .tabs{
                max-width: 360px;
            }

            .tab_panel{
                padding: 24px 26px 6px;
            }

            /* right column, bottom: buy card, static instead of a fixed mobile bar */
            #cart_form{
                grid-area: buy;
            }

            .action_bar{
                position: static;
                left: auto;
                right: auto;
                max-width: none;
                margin: 20px 0 0;
                flex-direction: column;
                align-items: stretch;
                border: 1px solid var(--line);
                border-radius: 18px;
                padding: 22px;
                box-shadow: 0 8px 28px rgba(18,32,58,.08);
            }

            .action_bar .qty_stepper{
                align-self: flex-start;
                margin-bottom: 14px;
            }

            .qty_stepper button{
                width: 38px;
                height: 44px;
            }

            .qty_stepper input{
                width: 44px;
                height: 44px;
            }

            .add_cart{
                height: 48px;
                font-size: 1rem;
                margin-bottom: 10px;
            }

            .wa_btn{
                width: 100%;
                height: 44px;
                border-radius: 10px;
                gap: 8px;
                font-size: .9rem;
                font-weight: 700;
            }

            .wa_btn::after{
                content: 'Send us a Message';
            }
        }
    </style>

    <div class="app_bar">
        <span>Product details</span>
        <a class="icon_btn" href="javascript:history.back()"><i class="fas fa-arrow-left"></i></a>
    </div>

    <div class="itemInfo">
        <?php
            if(isset($_GET['item'])){
                $item_id = $_GET['item'];

                $view_item = $connectdb->prepare("SELECT * FROM menu WHERE item_id = :item_id");
                $view_item->bindvalue('item_id', $item_id);
                $view_item->execute();

                $items = $view_item->fetchAll();
                foreach($items as $item):
        ?>
        <?php
            $company = $item->company;
            //get company
            $company_name = "Rivicos Pharmacy & Supermarket";
            $get_category = $connectdb->prepare("SELECT category FROM categories WHERE category_id = :category_id");
            $get_category->bindvalue("category_id",$item->item_category);
            $get_category->execute();
            $cat = $get_category->fetch();
            $category = $cat->category;
            $item_name = $item->item_name;
        ?>

        <div class="item_pics">
            <div class="slide_foto">
                <img class="active" src="<?php echo '../items/'.$item->item_foto?>" alt="<?php echo htmlspecialchars($item_name)?>">
                <img src="<?php echo '../items/'.$item->other_foto?>" alt="<?php echo htmlspecialchars($item_name)?>">
                <span class="delivery_chip"><i class="fas fa-truck"></i> <?php echo $item->delivery_time?></span>
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

        <div class="info_block">
            <span class="cat_pill"><?php echo htmlspecialchars($category)?></span>
            <p class="item_name"><?php echo strtoupper($item->item_name)?></p>
            <div class="price_row">
                <span class="item_price">₦<?php echo number_format($item->item_prize)?></span>
                <small>· sold by <?php echo htmlspecialchars($company_name)?></small>
            </div>

            <div class="tabs">
                <button type="button" class="active" onclick="showTab('desc')">Description</button>
                <button type="button" onclick="showTab('rev')">Reviews</button>
            </div>

            <div class="tab_panel active" id="tab_desc">
                <div class="item_descriptions">
                    <p><?php echo $item->item_description;?></p>
                </div>
                <div class="fact_row"><i class="fas fa-truck"></i> Delivery time <span><?php echo $item->delivery_time?></span></div>
                <div class="fact_row"><i class="fas fa-store"></i> Sold by <span><?php echo htmlspecialchars($company_name)?></span></div>
            </div>

            <div class="tab_panel" id="tab_rev">
                <div class="customer_reviews">
                    <?php
                        $get_reviews = $connectdb->prepare("SELECT * FROM reviews WHERE item = :item");
                        $get_reviews->bindValue("item", $item_id);
                        $get_reviews->execute();
                        $rows = $get_reviews->fetchAll();
                        if(count($rows) === 0){
                            echo '<p class="no_reviews">No reviews yet for this item.</p>';
                        }
                        foreach($rows as $row){
                    ?>
                    <?php
                        //get customer name
                        $get_customer = $connectdb->prepare("SELECT first_name, last_name FROM shoppers WHERE user_id = :user_id");
                        $get_customer->bindValue("user_id", $row->customer);
                        $get_customer->execute();
                        $cust_names = $get_customer->fetchAll();
                        $fullname = '';
                        foreach($cust_names as $cust){
                            $fullname = $cust->last_name. " ".$cust->first_name;
                        }
                        $initial = $fullname !== '' ? strtoupper(substr($fullname, 0, 1)) : '?';
                    ?>
                    <div class="reviews">
                        <h4 data-initial="<?php echo $initial?>"><?php echo $fullname?></h4>
                        <p><?php echo $row->details?></p>
                        <p class="rev_date"><?php echo date("d-M-Y", strtotime($row->post_date));?></p>
                    </div>
                    <?php }?>
                </div>
            </div>
        </div>

        <form action="../controller/cart.php" method="POST" id="cart_form">
            <input type="hidden" name="cart_item_id" id="cart_item_id" value="<?php echo $item->item_id?>">
            <input type="hidden" name="cart_item_price" id="cart_item_price" value="<?php echo $item->item_prize?>">
            <input type="hidden" name="cart_item_restaurant" id="cart_item_restaurant" value="<?php echo $company?>">
            <input type="hidden" name="customer" id="customer" value="<?php echo $id?>">

            <div class="action_bar">
                <div class="qty_stepper">
                    <button type="button" onclick="stepQty(-1)" aria-label="Decrease quantity">&minus;</button>
                    <input type="number" id="quantity" title="Enter quantity" name="quantity" required value="1" min="1">
                    <button type="button" onclick="stepQty(1)" aria-label="Increase quantity">&plus;</button>
                </div>
                <button type="submit" name="add_to_cart" id="add_to_cart" title="Add to cart" class="add_cart">
                    <i class="fas fa-cart-plus"></i> Add to cart
                </button>
                <a class="wa_btn" target="_blank" href="https://wa.me/+2347055220617" title="Message us on whatsapp"><i class="fab fa-whatsapp"></i></a>
            </div>
        </form>

        <?php endforeach; }?>
    </div>
</section>

<script>
    (function(){
        const slides = document.querySelectorAll('.slide_foto img');
        const dots = document.querySelectorAll('.dot_row button');
        let current = 0;

        window.showSlide = function(index){
            if(!slides.length) return;
            current = (index + slides.length) % slides.length;
            slides.forEach((img, i) => img.classList.toggle('active', i === current));
            dots.forEach((d, i) => d.classList.toggle('active', i === current));
        };

        window.stepQty = function(delta){
            const input = document.getElementById('quantity');
            if(!input) return;
            const next = Math.max(1, (parseInt(input.value, 10) || 1) + delta);
            input.value = next;
        };

        window.showTab = function(name){
            document.querySelectorAll('.tabs button').forEach(b => b.classList.remove('active'));
            document.querySelectorAll('.tab_panel').forEach(p => p.classList.remove('active'));
            document.getElementById('tab_' + name).classList.add('active');
            event.target.classList.add('active');
        };

        const left = document.querySelector('.left_arrow');
        const right = document.querySelector('.right_arrow');
        if(left) left.addEventListener('click', () => { showSlide(current - 1); restartAutoplay(); });
        if(right) right.addEventListener('click', () => { showSlide(current + 1); restartAutoplay(); });
        dots.forEach((d, i) => d.addEventListener('click', () => { showSlide(i); restartAutoplay(); }));

        const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
        let autoplayTimer = null;

        function startAutoplay(){
            if(prefersReducedMotion || slides.length < 2) return;
            autoplayTimer = setInterval(() => showSlide(current + 1), 4000);
        }

        function restartAutoplay(){
            if(autoplayTimer) clearInterval(autoplayTimer);
            startAutoplay();
        }

        const gallery = document.querySelector('.item_pics');
        const supportsHover = window.matchMedia('(hover: hover)').matches;
        if(gallery && supportsHover){
            gallery.addEventListener('mouseenter', () => autoplayTimer && clearInterval(autoplayTimer));
            gallery.addEventListener('mouseleave', restartAutoplay);
        }

        startAutoplay();
    })();
</script>
        <section id="just_in">
            <?php
                 $select_featured = $connectdb->prepare("SELECT * FROM menu WHERE item_category LIKE '%$item->item_category%'AND item_name != :item_name ORDER BY RAND() LIMIT 5");
                 $select_featured->bindvalue("item_name", $item->item_name);
                 $select_featured->execute();
                 if($select_featured->rowCount() > 0){
            ?>
            <h2>Items you may like</h2>
            <div class="featured">

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
        
    </main>
    
    <footer>
        <?php include "footer.php";?>
    </footer>
    <!-- <script src="bootstrap.min.js"></script> -->
    <script src="controller/jquery.js"></script>
    <script src="controller/script.js"></script>
    <script>
        /* show next foto */
        $(document).ready(function(){
            $(".right_arrow").click(function(){
                document.querySelector(".slide_foto").style.left = "-100%";
            })
        })
        /* show previous page */
        $(document).ready(function(){
            $(".left_arrow").click(function(){
                document.querySelector(".slide_foto").style.left = "0%";
            })
        })
    </script>
</body>
</html>
