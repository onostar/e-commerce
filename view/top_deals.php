<?php
    require "../controller/server.php";
    include "../admin/views/cache_control.php";
    session_start();
    $_SESSION['current_page'] = $_SERVER['REQUEST_URI'];
    $_SESSION['order_page'] = $_SERVER['REQUEST_URI'];

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
        $title = $fullname . " - Top deals";
    }else{
        $title = " Top deals";
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
   
    <?php include "../head.php"?>
    <link rel="stylesheet" href="../fontawesome-free-5.15.1-web/css/all.css">
    <link rel="icon" type="image/png" href="../images/logo.png" size="32X32">
    <link rel="stylesheet" href="../controller/style.css?v=<?php echo APP_VERSION?>">
    
</head>
<body>
    <?php include "header.php";?>

    <?php include "mobile_menu.php";?>

    <main id="exhibitor_store" class="other_deals">
        <section id="banner">
            <div class="slide">
                <div class="slides">
                    <div class="slide_img">
                        <img src="../images/banner3.png" alt="banner">
                    </div>
                    <div class="description">
                        <!-- <h2>Top deals</h2>
                        <p>Get the best deals for the best products available</p> -->
                        <div class="links">
                            <!-- <a href="#just_in"><i class="fas fa-shopping-cart"></i> Shop Now</a> -->
                            <!-- <a href="contact.php"><i class="fas fa-photo-video"></i> Learn more</a> -->
                        </div>
                        
                    </div>
                </div>
                
                
            </div>
        </section>
        

        <!-- show top deals for this company -->
        <?php
            $search_deals = $connectdb->prepare("SELECT * FROM menu WHERE item_status = 0 AND item_prize < previous_price ORDER BY RAND() DESC");
            $search_deals->execute();
            if($search_deals->rowCount() > 0){
                
        ?>
        <section id="just_in">
            <!-- <div class="featured_float">
                <h2>Top Deals</h2>
            </div> -->
            <div class="featured">
                <?php
                    
                    $rows = $search_deals->fetchAll();
                    foreach($rows as $row):
                ?>
                
                <figure>
                    <a href="item_info.php?item=<?php echo $row->item_id ?>">
                        <img src="<?php echo '../items/'.$row->item_foto?>" alt="<?php echo $row->item_name?>" loading="lazy">

                        
                        <figcaption>
                            <div class="todo">
                                <p><?php echo $row->item_name?></p>
                                <span>₦<?php echo number_format($row->item_prize)?></span>
                                <span class="previous_price">₦<?php echo number_format($row->previous_price)?></span>
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
            <!-- <form action="controller/more_featured.php" method="POST">
                <input type="hidden" name="moreFeatured" value="1" id="moreFeatured">
                <button type="submit" id="viewMore" name="viewMore">View more</button>
                
            </form> -->
            
        </section>
        <?php }?>
        

        
    </main>
    <footer>
        <?php include "footer.php";?>
    </footer>
    <script src="../controller/jquery.js"></script>
    <script src="../controller/script.js"></script>
    
</body>
</html>
