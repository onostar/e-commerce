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
        <section id="itemContent">
            
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
                    $company_name = "Realcare Pharmacy & Supermarket";
                    $get_category = $connectdb->prepare("SELECT category FROM categories WHERE category_id = :category_id");
                    $get_category->bindvalue("category_id",$item->item_category);
                    $get_category->execute();
                    $cat = $get_category->fetch();
                    $category = $cat->category;
                    $item_name = $item->item_name;
                ?>
                <figure class="item_details"> 
                    <div class="item_pics">
                        <div class="slide_foto">
                            <img src="<?php echo '../items/'.$item->item_foto?>" alt="Item">
                            <img src="<?php echo '../items/'.$item->other_foto?>" alt="Item">

                        </div>
                        <div class="arrows">
                            <a class="left_arrow" href="javascript:void(0)"><i class="fas fa-chevron-left"></i></a>
                            <a class="right_arrow" href="javascript:void(0)"><i class="fas fa-chevron-right"></i></a>
                        </div>
                    </div>
                    <form action="controller/cart.php" method="POST">
                        <input type="hidden" name="cart_item_id" id="cart_item_id" value="<?php echo $item->item_id?>">
                        <input type="hidden" name="cart_item_price" id="cart_item_price" value="<?php echo $item->item_prize?>">
                        <input type="hidden" name="cart_item_restaurant" id="cart_item_restaurant" value="<?php echo $company?>">
                        <input type="hidden" name="customer" id="customer" value="<?php echo $id?>">
                        <figcaption>
                            <!-- <div class="menu_logo">
                                <img src="../images/logo.png" alt="company">
                                
                            </div>
                            <div class="clear"></div> -->
                            <p style="font-size:.9rem"><?php echo strtoupper($item->item_name)?></p>
                            <!-- <p><span>Category:</span> <?php echo $category?></p> -->
                            <p style="color:var(--secondaryColor);font-size:.9rem">₦<?php echo number_format($item->item_prize)?></p>
                            <!-- <p><span>Company:</span> <?php echo $company_name?></p> -->
                            <!-- <p><span>Payment Option:</span> <?php echo $item->payment_option?></p> -->
                            <p><span>Delivery time:</span> <?php echo $item->delivery_time?></p>
                            <input type="number" id="quantity" title="Enter quantity" name="quantity" required value="1" style="width:15%!important">
                            <button type="submit" name="add_to_cart" id="add_to_cart" title="add to cart" class="add_cart" style="border-radius:10px; box-shadow:1px 1px 1px #222; border:1px solid #fff; padding:8px 10px"><i class="fas fa-cart-plus"></i></button>
                            <p class="dm"><a target='_blank' href='https://wa.me/+2348071172386' title='Message us on whatsapp'><i class='fab fa-whatsapp'></i> Send us a DM</a></p>
                        </figcaption>
                    </form>
                </figure>
                <div class="item_descriptions">
                    <hr>
                    <h3>More Descriptions</h3>
                    <p><?php echo $item->item_description;?></p>
                </div>
                <?php endforeach; }?>
            </div>
        </section>
        <div id="reviews">
            <h3>Customer reviews</h3>
            <div class="customer_reviews">
                <?php
                    $get_reviews = $connectdb->prepare("SELECT * FROM reviews WHERE item = :item");
                    $get_reviews->bindValue("item", $item_id);
                    $get_reviews->execute();
                    $rows = $get_reviews->fetchAll();
                    foreach($rows as $row){
                ?>
                <div class="reviews">
                    <h4>
                        <?php
                            //get customer name
                            $get_customer = $connectdb->prepare("SELECT first_name, last_name FROM shoppers WHERE user_id = :user_id");
                            $get_customer->bindValue("user_id", $row->customer);
                            $get_customer->execute();
                            $cust_names = $get_customer->fetchAll();
                            foreach($cust_names as $cust){
                                $fullname = $cust->last_name. " ".$cust->first_name;
                            }
                            echo $fullname;
                        ?>
                    </h4>
                    <p><?php echo $row->details?></p>
                    <p class="rev_date"><?php echo date("d-M-Y", strtotime($row->post_date));?></p>
                </div>
                <?php }?>
            </div>
        </div>
        <section id="just_in">
            <?php
                 $select_featured = $connectdb->prepare("SELECT * FROM menu WHERE item_category LIKE '%$item->item_category%'AND item_name != :item_name ORDER BY RAND() LIMIT 5");
                 $select_featured->bindvalue("item_name", $item->item_name);
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
