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
            $full_name = $view->first_name. " ". $view->last_name;
            $id = $view->user_id;
        }
        $title = $full_name. " -  All items";
    }else{
        $title = " All items";
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include "../head.php"?>
    <link rel="stylesheet" href="../fontawesome-free-5.15.1-web/css/all.css">
    <link rel="stylesheet" href="../fontawesome-free-6.0.0-web/css/all.css">
    <link rel="icon" type="image/png" href="../images/logo.png" size="32X32">
    <link rel="stylesheet" href="../controller/style.css?v=<?php echo APP_VERSION ?>">
    
</head>
<body>
    <?php include "header.php";?>

    <?php include "mobile_menu.php";?>

    <main>
        <section id="searchResults">
            <?php
                $search_query = $connectdb->prepare("SELECT SUBSTRING_INDEX(item_name, ' ', 4) AS item_name, item_id, item_prize, item_foto, previous_price FROM menu WHERE item_status = 0 ORDER BY RAND() DESC");
                $search_query->execute();
                    
            ?>
            <!-- <h2><strong>Check out more items from our collections</strong></h2> -->
            <!-- <hr> -->
            <div class="featured">
                
                <?php 
                    if(!$search_query->rowCount()){
                        echo "<p class='no_result'>'No result found!'</p>";
                    }
                    $shows = $search_query->fetchAll();
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
        </section>

        
    </main>
    <footer>
        <?php include "footer.php";?>
    </footer>

    <!-- <script src="bootstrap.min.js"></script> -->
    <script src="../controller/jquery.js"></script>
    <script src="../controller/script.js"></script>
    
</body>
</html>

