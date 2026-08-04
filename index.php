<?php
    session_start();
    require "controller/server.php";
    include "admin/views/cache_control.php";
    $_SESSION['current_page'] = $_SERVER['REQUEST_URI'];
    $_SESSION['order_page'] = $_SERVER['REQUEST_URI'];

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
        $title = $full_name. " -  Great stores, Great prices";
    }else{
        $title = " Great stores, Great prices";
    }
    date_default_timezone_set("Africa/Lagos");

$hour = date("H");

if($hour >= 5 && $hour < 12){
    $greeting = "Good Morning";
    $icon = "🌅";
}elseif($hour >= 12 && $hour < 17){
    $greeting = "Good Afternoon";
    $icon = "☀️";
}elseif($hour >= 17 && $hour < 21){
    $greeting = "Good Evening";
    $icon = "🌙";
}else{
    $greeting = "Welcome";
    $icon = "✨";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include "head.php"?>
    <link rel="stylesheet" href="fontawesome-free-5.15.1-web/css/all.css">
    <link rel="stylesheet" href="fontawesome-free-6.0.0-web/css/all.css">
    <link rel="stylesheet" href="fontawesome-free-6.0.0-web/css/all.min.css">
    <link rel="icon" type="image/png" href="images/icon.png" size="32X32">
    <link rel="stylesheet" href="controller/style.css?v=<?php echo APP_VERSION;?>">
    
</head>
<style>
    #splash-screen{
    position:fixed;
    inset:0;
    background:#fff;
    z-index:999999;
    display:flex;
    justify-content:center;
    align-items:center;
    transition:.8s;
}

.splash-content{
    text-align:center;
}

.splash-content img{
    width:220px;
    animation:logoZoom 1s ease;
}

.splash-content h1{
    margin-top:15px;
    font-size:42px;
    color:#183A7A;
    font-weight:700;
    animation:fadeUp 1.2s;
}

.splash-content p{
    color:#666;
    letter-spacing:3px;
    margin-top:8px;
}

.loader{
    width:220px;
    height:6px;
    background:#eee;
    margin:30px auto;
    border-radius:50px;
    overflow:hidden;
}

.loader span{
    display:block;
    width:0%;
    height:100%;
    background:linear-gradient(90deg,#1976D2,#8BC34A);
    animation:loading 2.5s forwards;
}

.hideSplash{
    opacity:0;
    visibility:hidden;
}

@keyframes logoZoom{
    0%{
        transform:scale(.4);
        opacity:0;
    }
    70%{
        transform:scale(1.08);
    }
    100%{
        transform:scale(1);
        opacity:1;
    }
}

@keyframes fadeUp{
    from{
        transform:translateY(20px);
        opacity:0;
    }
    to{
        transform:translateY(0);
        opacity:1;
    }
}

@keyframes loading{
    from{
        width:0%;
    }
    to{
        width:100%;
    }
}
#general_cat{
    width:100%;
    overflow:hidden;
    padding:20px 0;
    background:#fff;
}

.cat-track{
    display:flex;
    width:max-content;
    animation:scrollCategories 30s linear infinite;
}

.cat-track:hover{
    animation-play-state:paused;
}

.cat-track figure{
    flex:0 0 auto;
    width:200px;
    height:180px;
    margin:0 12px;
    background:#fff;
    border-radius:15px;
    overflow:hidden;
    text-align:center;
    box-shadow:0 6px 20px rgba(0,0,0,.08);
    transition:.3s;
}

.cat-track figure:hover{
    transform:translateY(-6px);
}

.cat-track figure img{
    width:100%;
    height:80%;
    object-fit:fill;
}

.cat-track figure figcaption{
    padding:5px;
    font-weight:normal;
    color:#222;
}

@keyframes scrollCategories{

    from{
        transform:translateX(0);
    }

    to{
        transform:translateX(-50%);
    }

}
@media(max-width:768px){

.cat-track figure{
    height:150px;
    width:150px;

}

.cat-track figure img{

    height:80%;

}

.cat-track{

    animation-duration:30s;

}

}
</style>
<body>
    
    <!-- <div class="loader">-->
        <?php if(isset($_SESSION['user'])){ ?>
       <div id="splash-screen">
            <div class="splash-content">

                <img src="images/logo.png" alt="Rivicos">
                <p><?php echo $icon. " " . $greeting. " ". $full_name; ?></p>
                <h1>Welcome back to Rivicos Supermarket</h1>

                <p>SHOP BETTER. LIVE SMARTER.</p>

                <div class="loader">
                    <span></span>
                </div>

            </div>
        </div>
        <?php }else{?>
       <div id="splash-screen">
            <div class="splash-content">

                <img src="images/logo.png" alt="Rivicos">

                <h1>Rivicos Supermarket</h1>

                <p>SHOP BETTER. LIVE SMARTER.</p>

                <div class="loader">
                    <span></span>
                </div>

            </div>
        </div>
        <?php }?>
    <!-- </div> -->
<!--<div class="main"> -->
    <?php include "header.php";?>
    <!-- <p class="successful">
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
    </p> -->
    <section id="bannerContents">
        <aside id="asideLeft" class="main_cat">
            <nav id="index_nav">
                <ul>
                    <?php include "categories.php"?>
                </ul>
            </nav>
        </aside>
        
        <?php include "mobile_menu.php";?>
        <?php

            $get_banner = $connectdb->prepare("SELECT * FROM users");
            $get_banner->execute();
            $covers = $get_banner->fetchAll();
            foreach($covers as $cover){
                $banner1 = $cover->banner1;
                $banner2 = $cover->banner2;
                $banner3 = $cover->banner3;
                $banner4 = $cover->banner4;
            }
        ?>
        <section id="banner">
            <div class="slide">
                <div class="slides">
                    <div class="slide_img">
                        <img src="<?php echo 'items/'.$banner1?>" alt="banner" loading="lazy">
                    </div>
                    <div class="description">
                        <!-- <h2>Welcome to Rivicos Pharmacy & Supermarket</h2> -->
                        <!-- <p>All the best for a whole lot less</p> -->
                        <div class="links">
                            <!-- <a href="view/all_items.php"><i class="fas fa-shopping-cart"></i> Shop Now</a> -->
                            <!-- <a href="contact.php"><i class="fas fa-photo-video"></i> Learn more</a> -->
                        </div>
                        
                    </div>
                </div>
                <div class="slides">
                    <div class="slide_img">
                    <img src="<?php echo 'items/'.$banner2?>" alt="banner" loading="lazy">
                    </div>
                    <div class="description">
                    <!-- <h2></h2> -->
                        <!-- <p></p> -->
                        <div class="links">
                            <!-- <a class="appointment" href="view/all_items.php"><i class="fas fa-paper-plane"></i>shop now</a> -->
                            <!-- <a href="javascript:void(0);"><i class="fas fa-photo-video"></i> View Media</a> -->
                        </div>
                    </div>
                </div>
                <div class="slides">
                    <div class="slide_img">
                        <img src="<?php echo 'items/'.$banner3?>" alt="banner" loading="lazy">
                    </div>
                    <div class="description">
                    <!-- <h2>Your favorite brands & hottest trends</h2>
                        <p>Every product delivered to you</p> -->
                        <div class="links">
                            <!-- <a href="view/all_items.php"><i class="fas fa-shopping-cart"></i> Shop Now</a> -->
                            <!-- <a href="gallery.php"><i class="fas fa-photo-video"></i> Gallery</a> -->
                        </div>
                        
                    </div>
                </div>
                <div class="slides">
                    <div class="slide_img">
                        <img src="<?php echo 'items/'.$banner4?>" alt="banner" loading="lazy">
                    </div>
                    <div class="description">
                    <!-- <h2>Your favorite brands & hottest trends</h2>
                        <p>Every product delivered to you</p> -->
                        <div class="links">
                            <!-- <a href="view/all_items.php"><i class="fas fa-shopping-cart"></i> Shop Now</a> -->
                            <!-- <a href="gallery.php"><i class="fas fa-photo-video"></i> Gallery</a> -->
                        </div>
                        
                    </div>
                </div>
                
            </div>
        </section>
        <aside id="asideRight">
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
                </ul>
            </nav>
            <div id="adds">
                
                <img src="images/online_shop2.jpg" alt="adds">
                
            </div>
        </aside>
    </section>
    <section id="links">
        <div class="link_tags">
            <a href="javscript:void(0);">
                <i class="fas fa-users"></i>
                <p>Partners</p>
            </a>
        </div>
        <div class="link_tags">
            <a href="view/top_deals.php">
                <i class="fas fa-coins"></i>
                <p>Top deals</p>
            </a>
        </div>
        <div class="link_tags">
            <a href="#popular">
                <i class="fas fa-star"></i>
                <p>Popular</p>
            </a>
        </div>
        <div class="link_tags">
            <a href="#official_stores">    
                <i class="fas fa-home"></i>
                <p>Stores</p>
            </a>
        </div>
    </section>
    <main>
        <section id="general_cat">

            <div class="cat-track">

                <!-- First Set -->
                <figure>
                    <a href="#official_stores">
                        <img src="images/stores.webp">
                        <figcaption>Official Stores</figcaption>
                    </a>
                </figure>

                <figure>
                    <a href="view/all_categories.php?category=Household Essentials">
                        <img src="images/household.png">
                        <figcaption>Household Essentials</figcaption>
                    </a>
                </figure>

                <figure>
                    <a href="view/all_categories.php?category=Jewelries">
                        <img src="images/jewelries2.webp">
                        <figcaption>Jewelries</figcaption>
                    </a>
                </figure>

                <figure>
                    <a href="view/all_categories.php?category=Fresh Food">
                        <img src="images/fresh_food.png">
                        <figcaption>Fresh Foods</figcaption>
                    </a>
                </figure>

                <figure>
                    <a href="view/all_categories.php?category=Supplements">
                        <img src="images/supllement.png">
                        <figcaption>Supplements</figcaption>
                    </a>
                </figure>

                <figure>
                    <a href="view/all_categories.php?category=Children">
                        <img src="images/toys.jpg">
                        <figcaption>Children</figcaption>
                    </a>
                </figure>

                <figure>
                    <a href="view/all_categories.php?category=Cosmetics">
                        <img src="images/creams.webp">
                        <figcaption>Cosmetics</figcaption>
                    </a>
                </figure>
                <figure>
                    <a href="view/all_categories.php?category=Wines">
                        <img src="images/wines.jpg">
                        <figcaption>Wines</figcaption>
                    </a>
                </figure>

                <figure>
                    <a href="view/top_deals.php">
                        <img src="images/top_deals.jpg">
                        <figcaption>Top Deals</figcaption>
                    </a>
                </figure>

                <!-- Duplicate Everything -->
                <figure>
                    <a href="#official_stores">
                        <img src="images/stores.webp">
                        <figcaption>Official Stores</figcaption>
                    </a>
                </figure>

                <figure>
                    <a href="view/all_categories.php?category=Household Essentials">
                        <img src="images/household.png">
                        <figcaption>Household Essentials</figcaption>
                    </a>
                </figure>

                <figure>
                    <a href="view/all_categories.php?category=Jewelries">
                        <img src="images/jewelries2.webp">
                        <figcaption>Jewelries</figcaption>
                    </a>
                </figure>

                <figure>
                    <a href="view/all_categories.php?category=Fresh Food">
                        <img src="images/fresh_food.png">
                        <figcaption>Fresh Foods</figcaption>
                    </a>
                </figure>

                <figure>
                    <a href="view/all_categories.php?category=Supplements">
                        <img src="images/supllement.png">
                        <figcaption>Supplements</figcaption>
                    </a>
                </figure>

                <figure>
                    <a href="view/all_categories.php?category=Children">
                        <img src="images/toys.jpg">
                        <figcaption>Children</figcaption>
                    </a>
                </figure>

                <figure>
                    <a href="view/all_categories.php?category=Cosmetics">
                        <img src="images/creams.webp">
                        <figcaption>Cosmetics</figcaption>
                    </a>
                </figure>
                <figure>
                    <a href="view/all_categories.php?category=Wines">
                        <img src="images/wines.jpg">
                        <figcaption>Wines</figcaption>
                    </a>
                </figure>
                <figure>
                    <a href="view/top_deals.php">
                        <img src="images/top_deals.jpg">
                        <figcaption>Top Deals</figcaption>
                    </a>
                </figure>

            </div>

        </section>
        <!-- show some products randomly-->
        <section id="just_in">
            <div class="featured_float">
                <h2>Discover Selected Picks from our store</h2>
                <a href="view/all_items.php">View all</a>
            </div>
            <div class="featured">
                <?php
                    $select_featured = $connectdb->prepare("SELECT SUBSTRING_INDEX(item_name, ' ', 4) AS item_name, item_id, item_prize, item_foto FROM menu WHERE item_status = 0 ORDER BY RAND() DESC LIMIT 20");
                    $select_featured->execute();
                    $rows = $select_featured->fetchAll();
                    foreach($rows as $row):
                ?>
                
                <figure>
  
                    <a href="view/item_info.php?item=<?php echo $row->item_id ?>">
                        <img src="<?php echo 'items/'.$row->item_foto?>" alt="<?php echo $row->item_name?>" loading="lazy">

                    
                        
                        <figcaption>
                        
                            <div class="todo">
                                <p><?php echo $row->item_name?>..</p>
                                
                                <span>₦<?php echo number_format($row->item_prize)?></span>

                            </div>
                            
                        
                        </figcaption>
                    </a>
                        
                </figure>
                
                <?php endforeach ?>
                
            </div>
            <?php if($select_featured->rowCount() > 20){?>
            <div class="more_mobile">
                <a href="view/all_items.php">View More Products <i class="fas fa-cloud-download"></i></a>
            </div>
            <?php }?>
        </section>
        <!-- Popular items -->
        <?php
            $select_all = $connectdb->prepare("SELECT SUBSTRING_INDEX(item_name, ' ', 4) AS item_name, item_id, item_prize, item_foto, previous_price, item_category FROM menu RIGHT JOIN orders USING (item_id) WHERE menu.item_status = 0 GROUP BY item_id HAVING SUM(orders.quantity) >= 5  ORDER BY RAND() LIMIT 5");
            $select_all->execute();
            if($select_all->rowCount() > 0){
        ?>
        <section id="popular">
            <div class="featured_float">
                <h2>Top selling Items <i class="fas fa-star"></i><i class="fas fa-star"></i></h2>
            </div>
            <div class="all_items popular_items">
                <?php
                    /* $select_all = $connectdb->prepare("SELECT menu.item_name, menu.item_category, menu.restaurant_name, menu.item_prize, menu.item_foto, menu.item_id, orders.item_name FROM orders, menu WHERE menu.item_name = orders.item_name AND orders.quantity >= 2 GROUP BY orders.item_name"); */
                   
                    $rows = $select_all->fetchAll();
                    foreach($rows as $row):
                ?>
                <!-- check company status -->
                <figure>
                    <a href="view/item_info.php?item=<?php echo $row->item_id ?>">
                        <img src="<?php echo 'items/'.$row->item_foto?>" alt="<?php echo $row->item_name?>" loading="lazy">

                    
                    
                    <figcaption>
                    
                        <div class="todo">
                            <p><?php echo $row->item_name?>..</p>
                            <p><i class="fas fa-layer-group"></i> <?php
                            $get_category = $connectdb->prepare("SELECT category FROM categories WHERE category_id = :category_id");
                            $get_category->bindvalue("category_id",$row->item_category);
                            $get_category->execute();
                            $cat = $get_category->fetch(); echo $cat->category;?></p>
                            <span>₦ <?php echo number_format($row->item_prize)?></span>
                            <?php
                                if($row->item_prize < $row->previous_price):
                            ?>
                            <span class="previous_price">₦ <?php echo number_format($row->previous_price)?></span>
                        </div>
                        
                        <div class="percentage">
                        <?php
                            $percent = (($row->previous_price - $row->item_prize) / $row->previous_price) * 100;
                        ?>
                        <p>-<?php echo number_format($percent);?>%</p>
                        </div>
                        <?php endif?>
                    </figcaption>
                    </a>
                </figure>
                
                <?php endforeach ?>
                
            </div>
            <!-- <button id="more_popular">View more</button>
            <button id="less_popular">Show less</button> -->
        </section>
        <?php }?>
        <!-- show top deals -->
        <?php
            $search_deals = $connectdb->prepare("SELECT SUBSTRING_INDEX(item_name, ' ', 4) AS item_name, item_id, item_prize, item_foto, previous_price FROM menu WHERE item_status = 0 AND item_prize < previous_price ORDER BY RAND() DESC LIMIT 5");
            $search_deals->execute();
            if($search_deals->rowCount() > 0){
                
        ?>
        <section id="top_deals">
            <div class="featured_float">
                <h2 style="background:var(--buttonColor)">Top Deals</h2>
                <a href="view/top_deals.php">View all</a>
            </div>
            <div class="featured">
                <?php
                    
                    $rows = $search_deals->fetchAll();
                    foreach($rows as $row):
                ?>
                
                <figure>
                
                    <a href="view/item_info.php?item=<?php echo $row->item_id ?>">
                        <img src="<?php echo 'items/'.$row->item_foto?>" alt="<?php echo $row->item_name?>" loading="lazy">

                    
                        
                        <figcaption>
                        
                            <div class="todo">
                                <p><?php echo $row->item_name?>..</p>
                                <span>₦ <?php echo number_format($row->item_prize)?></span>
                                <span class="previous_price">₦ <?php echo number_format($row->previous_price)?></span>
                            </div>
                            
                        </figcaption>
                        <div class="percentage">
                            <?php
                                $percent = (($row->previous_price - $row->item_prize) / $row->previous_price) * 100;
                            ?>
                            <p>-<?php echo number_format($percent);?>%</p>
                        </div>
                    </a> 
                </figure>
                
                <?php endforeach ?>
                
            </div>
            <?php if($search_deals->rowCount() > 6){?>
            <div class="more_mobile">
                <a href="view/top_deals.php">More <i class="fas fa-cloud-download"></i></a>
            </div>
            <?php }?>
        </section>
        <?php }?>
        
       
        
        <!-- recommended for you -->
        <?php
            if(isset($_SESSION['user'])){
            $select_all = $connectdb->prepare("SELECT orders.customer, orders.item_id, orders.company, menu.item_id, menu.item_category, SUBSTRING_INDEX(menu.item_name, ' ', 4) AS item_name, menu.item_prize, menu.item_foto, menu.company, menu.item_description FROM orders, menu WHERE menu.item_status = 0 AND orders.customer = :customer AND menu.item_id =  orders.item_id AND menu.company = orders.company GROUP BY orders.item_id ORDER BY RAND() LIMIT 5");
            $select_all->bindvalue('customer', $id);
            $select_all->execute();
            if($select_all->rowCount() > 0){
        ?>

        <section id="recommendedItems">
        <h2>Recommended for you</h2>
            <div class="all_items">
                <?php
                    
                    $rows = $select_all->fetchAll();
                    foreach($rows as $row):
                ?>
                
                <figure>
                    <a href="view/item_info.php?item=<?php echo $row->item_id ?>">
                        <img src="<?php echo 'items/'.$row->item_foto?>" alt="<?php echo $row->item_name?>" loading="lazy">

                    
                    
                    <figcaption>
                        <div class="todo">
                            <p><?php echo $row->item_name?>..</p>
                            
                            <span>₦ <?php echo number_format($row->item_prize)?></span>
                        </div>
                        
                    </figcaption>
                    </a>
                </figure>
                
                <?php endforeach ?>
                
            </div>
        </section>
        <?php } }?>
        <!-- official stores -->
        <section class="official_stores" id="official_stores">
            <h3>Official Stores</h3>
            <div class="paid_stores">
                <a href="javascript:void(0)" title="View Store">

                    <figure>
                        <div class="com_img">
                            <img src="images/shop_owner.jpg" alt="Rivicos Supermarket & Pharmacy, Agbor Road" loading="lazy">
                        </div>
                        <figcaption>
                            <p>Rivicos Supermarket & Pharmacy, Agbor Road</p>
                        </figcaption>
                    </figure>
                </a>
                <a href="javascript:void(0)" title="View Store">

                    <figure>
                        <div class="com_img">
                            <img src="images/shop_owner.jpg" alt="Annyplus Pharmacy & Store, Ikhuen" loading="lazy">
                        </div>
                        <figcaption>
                            <p>Annyplus Pharmacy & Store, Ikhuen</p>
                        </figcaption>
                    </figure>
                </a>
                <a href="javascript:void(0)" title="View Store">

                    <figure>
                        <div class="com_img">
                            <img src="images/online_shop3.jpg" alt="Rivicos Supermarket & Pharmacy, GT branch, Agbor Road" loading="lazy">
                        </div>
                        <figcaption>
                            <p>Rivicos Supermarket & Pharmacy, GT branch, Agbor Road</p>
                        </figcaption>
                    </figure>
                </a>
            </div>
        </section>
    </main>
    <footer>
        <?php include "footer.php"; ?>
    </footer>
    <!-- <div id="loginPrompt">
        <p>Kindly Login to View Item!</p>
        <div class="log">
            <a href="registration.php" title="Login here">Login</a>
            <a href="javascript:void();" id="closeBox" title="Close box">Close</a>
        </div>
    </div> -->
<!-- </div> -->
    <script src="controller/jquery.js"></script>
    <script src="controller/script.js?v=<?php  echo APP_VERSION?>"></script>
</body>
</html>

