<?php
    require "../controller/server.php";
    session_start();
    $_SESSION['current_page'] = $_SERVER['REQUEST_URI'];
    $_SESSION['order_page'] = $_SERVER['REQUEST_URI'];


    if(isset($_SESSION['user'])){
        $user = $_SESSION['user'];
    }
?>
<?php
    if(isset($_GET['company'])){
        $company = $_GET['company'];
    }
        $search_restaurant = $connectdb->prepare("SELECT * FROM exhibitors WHERE reg_number = :reg_number");
        $search_restaurant->bindvalue("reg_number", $company);
        $search_restaurant->execute();
        $shows = $search_restaurant->fetchAll();
        foreach($shows as $show):
        

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?php
        if($show->about == ""){
            echo 'Clozeth is an online platform made for the purpose of ordering fashion wears, men and women clothing, bed sheets, jewellries, etc from all kinds of retailers and wholesalers in Nigeria and Abroad from whereever you are through your mobile phone, tablet or pc">
        <meta name="keywords" content="Fashion, fashion store, clothings, men, women, men wears, women wears, jewellry, jewellries, rings, earings, wrist watch, eye glass, glass, shoes, order, ordering';
        }else{
            echo $show->about;
        }
    ?>">
    <title>Clozeth | <?php echo $show->company_name?> Store</title>
    <!-- <link rel="stylesheet" href="bootstrap.min.css"> -->
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w==" crossorigin="anonymous" referrerpolicy="no-referrer" /> -->
    <link rel="stylesheet" href="../fontawesome-free-5.15.1-web/css/all.css">
    <link rel="icon" type="image/png" href="<?php echo "../admin/logos/".$show->company_logo?>" size="32X32">
    <link rel="stylesheet" href="../controller/style.css">
    
</head>
<body>
    <?php include "header.php";?>

    <?php include "mobile_menu.php";?>

    <main id="exhibitor_store">
        <section id="banner">
            <div class="slide">
                <div class="slides">
                    <div class="slide_img">
                        <img src="<?php echo '../banners/'.$show->banner1?>" alt="banner">
                    </div>
                    <div class="description">
                        <h2>Welcome to <?php echo $show->company_name?> Store</h2>
                        <p><?php echo $show->banner_description?></p>
                        <div class="links">
                            <a href="#searchResults"><i class="fas fa-shopping-cart"></i> Shop Now</a>
                            <!-- <a href="contact.php"><i class="fas fa-photo-video"></i> Learn more</a> -->
                        </div>
                        
                    </div>
                    <div class="seller_logo">
                        <img src="<?php echo "../admin/logos/".$show->company_logo?>" alt="company logo">
                    </div>
                </div>
                <div class="slides">
                    
                    <div class="slide_img">
                        <img src="<?php echo '../banners/'.$show->banner2?>" alt="banner">
                    </div>
                    <div class="description">
                        <h2><?php echo $show->company_name?></h2>
                        <p><?php echo $show->banner_description?></p>
                        <div class="links">
                            <a href="#searchResults"><i class="fas fa-shopping-cart"></i> Shop Now</a>
                            <!-- <a href="contact.php"><i class="fas fa-photo-video"></i> Learn more</a> -->
                        </div>
                        
                    </div>
                    <div class="seller_logo">
                        <img src="<?php echo "../admin/logos/".$show->company_logo?>" alt="company logo">
                    </div>
                    
                </div>
                <div class="slides">
                    
                    <div class="slide_img">
                        <img src="<?php echo '../banners/'.$show->banner3?>" alt="banner">
                    </div>
                    <div class="description">
                        <h2><?php echo $show->company_name?></h2>
                        <p><?php echo $show->banner_description?></p>
                        <div class="links">
                            <a href="#searchResults"><i class="fas fa-shopping-cart"></i> Shop Now</a>
                            <!-- <a href="contact.php"><i class="fas fa-photo-video"></i> Learn more</a> -->
                        </div>
                        
                    </div>
                    <div class="seller_logo">
                        <img src="<?php echo "../admin/logos/".$show->company_logo?>" alt="company logo">
                    </div>
                </div>
                
            </div>
        </section>
        <!-- show just in -->
        <?php
                $search_new = $connectdb->prepare("SELECT menu.item_name, menu.company, menu.item_category, menu.item_prize, menu.previous_price, menu.item_foto, menu.item_id, exhibitors.company_name, exhibitors.exhibitor_id FROM menu, exhibitors WHERE menu.item_status = 0 AND exhibitors.reg_number = :reg_number AND exhibitors.exhibitor_id = menu.company ORDER BY time_created DESC LIMIT 6");
                $search_new->bindvalue("reg_number", $company);
                $search_new->execute();
                 
                if($search_new->rowCount() > 0){
                   
            ?>
            <section class="new_goods">
                <div class="featured_float">
                    <h3>Just in</h3>
                </div>
                <div class="featured">
                    
                    <?php
                        
                        $showss = $search_new->fetchAll();
                        foreach($showss as $shows):
                    ?>
                    <!-- check company status -->
                    <?php
                        $get_company = $connectdb->prepare("SELECT payment_status FROM exhibitors WHERE exhibitor_id = :exhibitor_id");
                        $get_company->bindvalue("exhibitor_id", $shows->company);
                        $get_company->execute();
                        $company_stat = $get_company->fetch();
                        $company_status = $company_stat->payment_status;
                        if($company_status == 2){
                    ?>
                    <figure>
                            <img src="<?php echo '../items/'.$shows->item_foto?>" alt="new item">
                        </a>
                        
                            <figcaption>
                                <div class="todo">
                                    <p class="first"><?php echo $shows->item_name?></p>
                                    <!-- <p><i class="fas fa-store"></i> <?php echo $shows->company_name?></p> -->
                                    <p><i class="fas fa-layer-group"></i> <?php
                                    $get_category = $connectdb->prepare("SELECT category FROM categories WHERE category_id = :category_id");
                                    $get_category->bindvalue("category_id",$shows->item_category);
                                    $get_category->execute();
                                    $cat = $get_category->fetch(); echo $cat->category;?></p>
                                    <span>₦ <?php echo number_format($shows->item_prize)?></span>
                                </div>
                            </figcaption>
                            <div class="view_add">
                            <a class="view_item" href="javascript:void(0)" title="show item details" onclick="showItems('<?php echo $shows->item_id?>')">View item <i class="fas fa-eye"></i></a>
                            <form action="../controller/cart.php" method="POST">
                            <input type="hidden" name="cart_item_id" id="cart_item_id" value="<?php echo $shows->item_id?>">
                            <input type="hidden" name="cart_item_name" id="cart_item_name" value="<?php echo $shows->item_name?>">
                            <input type="hidden" name="cart_item_price" id="cart_item_price" value="<?php echo $shows->item_prize?>">
                            <input type="hidden" name="cart_item_restaurant" id="cart_item_restaurant" value="<?php echo $shows->company?>">
                            <input type="hidden" name="customer_email" id="customer_email" value="<?php echo $user?>">
                            <input type="hidden" id="quantity" name="quantity" value="1">
                            <button title="add to cart" class="send_cart"><i class="fas fa-cart-plus"></i></button>
                            </form>
                        </div>
                            <!-- <?php
                                if($shows->item_prize < $shows->previous_price){
                            ?>
                            <div class="percentage">
                                <?php
                                    $percent = ($shows->item_prize / $shows->previous_price) * 100;
                                ?>
                                <p>-<?php echo $percent;?>%</p>
                            </div>
                            <?php }?> -->
                    </figure>
                    <?php }; endforeach?>

                </div>
                <?php }?>
            </section>

        <!-- show top deals for this company -->
        <?php
            $search_deals = $connectdb->prepare("SELECT menu.item_name, menu.company, menu.item_category, menu.item_prize, menu.item_id, menu.previous_price, menu.item_foto, exhibitors.company_name, exhibitors.exhibitor_id FROM menu, exhibitors WHERE menu.item_status = 0 AND exhibitors.reg_number = :reg_number AND exhibitors.exhibitor_id = menu.company AND menu.item_prize < menu.previous_price ORDER BY menu.item_name");
            $search_deals->bindvalue("reg_number", $company);
            $search_deals->execute();
            if($search_deals->rowCount() > 0){
                
        ?>
        <section id="just_in">
            <div class="featured_float">
                <h2>Top Deals</h2>
            </div>
            <div class="featured">
                <?php
                    
                    $rows = $search_deals->fetchAll();
                    foreach($rows as $row):
                ?>
                <!-- check company status -->
                <?php
                    $get_company = $connectdb->prepare("SELECT payment_status FROM exhibitors WHERE exhibitor_id = :exhibitor_id");
                    $get_company->bindvalue("exhibitor_id", $row->company);
                    $get_company->execute();
                    $company_stat = $get_company->fetch();
                    $company_status = $company_stat->payment_status;
                    if($company_status == 2){
                ?>
                <figure>
                        <img src="<?php echo '../items/'.$row->item_foto?>" alt="Top deals">
                        
                        <figcaption>
                            <div class="todo">
                                <p><?php echo $row->item_name?></p>
                                <!-- <p><i class="fas fa-layer-group"></i> <?php
                                $get_category = $connectdb->prepare("SELECT category FROM categories WHERE category_id = :category_id");
                                $get_category->bindvalue("category_id",$row->item_category);
                                $get_category->execute();
                                $cat = $get_category->fetch(); echo $cat->category;?></p> -->
                                <span>₦ <?php echo number_format($row->item_prize)?></span>
                                <span class="previous_price">₦ <?php echo number_format($row->previous_price)?></span>
                            </div>
                            
                        </figcaption>
                        <div class="view_add">
                            <a class="view_item" href="javascript:void(0)" title="show item details" onclick="showItems('<?php echo $row->item_id?>')">View item <i class="fas fa-eye"></i></a>
                            <form action="../controller/cart.php" method="POST">
                            <input type="hidden" name="cart_item_id" id="cart_item_id" value="<?php echo $row->item_id?>">
                            <input type="hidden" name="cart_item_name" id="cart_item_name" value="<?php echo $row->item_name?>">
                            <input type="hidden" name="cart_item_price" id="cart_item_price" value="<?php echo $row->item_prize?>">
                            <input type="hidden" name="cart_item_restaurant" id="cart_item_restaurant" value="<?php echo $row->company?>">
                            <input type="hidden" name="customer_email" id="customer_email" value="<?php echo $user?>">
                            <input type="hidden" id="quantity" name="quantity" value="1">
                            <button title="add to cart" class="send_cart"><i class="fas fa-cart-plus"></i></button>
                            </form>
                        </div>
                        <div class="percentage">
                            <?php
                                $percent = (($row->previous_price - $row->item_prize) / $row->previous_price) * 100;
                            ?>
                            <p>-<?php echo number_format($percent);?>%</p>
                        </div>
                </figure>
                
                <?php }; endforeach ?>
                
            </div>
            <!-- <form action="controller/more_featured.php" method="POST">
                <input type="hidden" name="moreFeatured" value="1" id="moreFeatured">
                <button type="submit" id="viewMore" name="viewMore">View more</button>
                
            </form> -->
            
        </section>
        <?php }?>
        <!-- Popular sales for this company -->
        <?php
            $search_pop = $connectdb->prepare("SELECT menu.item_name, menu.company, menu.item_category, menu.item_prize, menu.item_id, menu.previous_price, menu.item_foto, exhibitors.company_name, exhibitors.exhibitor_id, orders.item_name FROM menu, exhibitors, orders WHERE menu.item_status = 0 AND exhibitors.reg_number = :reg_number AND exhibitors.exhibitor_id = menu.company AND menu.item_name = orders.item_name GROUP BY orders.item_name HAVING SUM(orders.quantity) >= 3 ORDER BY orders.delivery_date LIMIT 6");
            $search_pop->bindvalue("reg_number", $company);
            $search_pop->execute();
            if($search_pop->rowCount() > 0){
                
        ?>
        <section id="popular">
            <div class="featured_float">
                <h2>Popular products</h2>
            </div>
            <div class="featured">
                <?php
                    
                    $rows = $search_pop->fetchAll();
                    foreach($rows as $row):
                ?>
                <!-- check company status -->
                <?php
                    $get_company = $connectdb->prepare("SELECT payment_status FROM exhibitors WHERE exhibitor_id = :exhibitor_id");
                    $get_company->bindvalue("exhibitor_id", $row->company);
                    $get_company->execute();
                    $company_stat = $get_company->fetch();
                    $company_status = $company_stat->payment_status;
                    if($company_status == 2){
                ?>
                <figure>
                        <img src="<?php echo '../items/'.$row->item_foto?>" alt="Top deals">
                        
                        <figcaption>
                            <div class="todo">
                                <p><?php echo $row->item_name?></p>
                                <!-- <p><i class="fas fa-layer-group"></i> <?php
                                $get_category = $connectdb->prepare("SELECT category FROM categories WHERE category_id = :category_id");
                                $get_category->bindvalue("category_id",$row->item_category);
                                $get_category->execute();
                                $cat = $get_category->fetch(); echo $cat->category;?></p> -->
                                <span>₦ <?php echo number_format($row->item_prize)?></span>
                                <?php if($row->item_prize < $row->previous_price){?>
                                <span class="previous_price">₦ <?php echo number_format($row->previous_price)?></span>
                                <?php }?>
                            </div>
                            
                        </figcaption>
                        <div class="view_add">
                            <a class="view_item" href="javascript:void(0)" title="show item details" onclick="showItems('<?php echo $row->item_id?>')">View item <i class="fas fa-eye"></i></a>
                            <form action="../controller/cart.php" method="POST">
                            <input type="hidden" name="cart_item_id" id="cart_item_id" value="<?php echo $row->item_id?>">
                            <input type="hidden" name="cart_item_name" id="cart_item_name" value="<?php echo $row->item_name?>">
                            <input type="hidden" name="cart_item_price" id="cart_item_price" value="<?php echo $row->item_prize?>">
                            <input type="hidden" name="cart_item_restaurant" id="cart_item_restaurant" value="<?php echo $row->company?>">
                            <input type="hidden" name="customer_email" id="customer_email" value="<?php echo $user?>">
                            <input type="hidden" id="quantity" name="quantity" value="1">
                            <button title="add to cart" class="send_cart"><i class="fas fa-cart-plus"></i></button>
                            </form>
                        </div>
                        <?php
                            if($row->item_prize < $row->previous_price){
                        ?>
                        <div class="percentage">
                            <?php
                                $percent = (($row->previous_price - $row->item_prize) / $row->previous_price) * 100;
                            ?>
                            <p>-<?php echo number_format($percent);?>%</p>
                        </div>
                        <?php }?>
                        
                    
                </figure>
                
                <?php }; endforeach ?>
                
            </div>
            <!-- <form action="controller/more_featured.php" method="POST">
                <input type="hidden" name="moreFeatured" value="1" id="moreFeatured">
                <button type="submit" id="viewMore" name="viewMore">View more</button>
                
            </form> -->
            
        </section>
        <?php }?>
        <!-- all items -->
        <section id="searchResults">
            
            <?php
                $search_query = $connectdb->prepare("SELECT menu.item_name, menu.company, menu.item_category, menu.item_prize, menu.previous_price, menu.item_foto, menu.item_id, exhibitors.company_name, exhibitors.exhibitor_id FROM menu, exhibitors WHERE menu.item_status = 0 AND exhibitors.reg_number = :reg_number AND exhibitors.exhibitor_id = menu.company ORDER BY menu.item_name");
                $search_query->bindvalue("reg_number", $company);
                $search_query->execute();
                 
                if(!$search_query->rowCount() > 0){
                    echo "<p class='no_result_exh'>'No item in this store!'</p>";
                }else{

                    echo "<h3>Check out more collections</h3>"
            ?>
            <div class="results featured">
                
                <?php
                    
                    $showss = $search_query->fetchAll();
                    foreach($showss as $shows):
                ?>
                <!-- check company status -->
                <?php
                    $get_company = $connectdb->prepare("SELECT payment_status FROM exhibitors WHERE exhibitor_id = :exhibitor_id");
                    $get_company->bindvalue("exhibitor_id", $shows->company);
                    $get_company->execute();
                    $company_stat = $get_company->fetch();
                    $company_status = $company_stat->payment_status;
                    if($company_status == 2){
                ?>
                <figure>
                        <img src="<?php echo '../items/'.$shows->item_foto?>" alt="featured item">
                  
                    
                        <figcaption>
                            <div class="todo">
                                <p class="first"><?php echo $shows->item_name?></p>
                                <!-- <p><i class="fas fa-store"></i> <?php echo $shows->company_name?></p> -->
                                <p><i class="fas fa-layer-group"></i> <?php
                                $get_category = $connectdb->prepare("SELECT category FROM categories WHERE category_id = :category_id");
                                $get_category->bindvalue("category_id",$shows->item_category);
                                $get_category->execute();
                                $cat = $get_category->fetch(); echo $cat->category;?></p>
                                <span>₦<?php echo number_format($shows->item_prize)?></span>
                                <?php if($shows->item_prize < $shows->previous_price){?>
                                    <span class="previous_price">₦<?php echo number_format($shows->previous_price)?></span>
                                <?php }?>
                            </div>
                            <!-- <button onclick="loginFirst();"><i class="fas fa-shopping-cart"></i></button> -->
                        </figcaption>
                        <div class="view_add">
                            <a class="view_item" href="javascript:void(0)" title="show item details" onclick="showItems('<?php echo $shows->item_id?>')">View item <i class="fas fa-eye"></i></a>
                            <form action="../controller/cart.php" method="POST">
                            <input type="hidden" name="cart_item_id" id="cart_item_id" value="<?php echo $shows->item_id?>">
                            <input type="hidden" name="cart_item_name" id="cart_item_name" value="<?php echo $shows->item_name?>">
                            <input type="hidden" name="cart_item_price" id="cart_item_price" value="<?php echo $shows->item_prize?>">
                            <input type="hidden" name="cart_item_restaurant" id="cart_item_restaurant" value="<?php echo $shows->company?>">
                            <input type="hidden" name="customer_email" id="customer_email" value="<?php echo $user?>">
                            <input type="hidden" id="quantity" name="quantity" value="1">
                            <button title="add to cart" class="send_cart"><i class="fas fa-cart-plus"></i></button>
                            </form>
                        </div>
                        <?php
                            if($shows->item_prize < $shows->previous_price){
                        ?>
                        <div class="percentage">
                            <?php
                                $percent = (($shows->previous_price - $shows->item_prize) / $shows->previous_price) * 100;
                            ?>
                            <p>-<?php echo number_format($percent);?>%</p>
                        </div>
                        <?php }?>
                </figure>
            <?php }; endforeach?>

            </div>
            <?php }?>
        </section>

        
    </main>
    
        <?php include "footer.php";?>
    
        <div class="exh_dm">
            <?php echo "<a target='_blank' href='https://wa.me/+234".$show->contact_phone."' title='Send us a DM'><img src='../images/whatsapp_icon.png' alt='Whatsapp icon'></a>";?>
        </div>
    <?php endforeach?>
    <script src="../controller/jquery.js"></script>
    <script src="../controller/script.js"></script>
    
</body>
</html>
