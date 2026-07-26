<?php
    require "../controller/server.php";
    session_start();
    $_SESSION['current_page'] = $_SERVER['REQUEST_URI'];
    $_SESSION['order_page'] = $_SERVER['REQUEST_URI'];
    if(isset($_GET['category'])){
        $category = $_GET['category'];
        //cat id
        $get_cat = $connectdb->prepare("SELECT category_id FROM categories WHERE category = :category");
        $get_cat->bindValue("category", $category);
        $get_cat->execute();
        $cat = $get_cat->fetch();
        $cat_id = $cat->category_id;
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
        $title = $fullname . " - ". $category;
    }else{
        $title = $category;
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
   
    <?php include "../head.php"?>
    <link rel="stylesheet" href="../fontawesome-free-5.15.1-web/css/all.css">
    <link rel="stylesheet" href="../fontawesome-free-6.0.0-web/css/all.css">
    <link rel="icon" type="image/png" href="../images/logo.png" size="32X32">
    <link rel="stylesheet" href="../controller/style.css">
    
</head>
<body>
    <?php include "header.php";?>

    <?php include "mobile_menu.php";?>

    <main>
        <section id="searchResults">
            <?php
                

                    $search_query = $connectdb->prepare("SELECT SUBSTRING_INDEX(item_name, ' ', 4) AS item_name, item_id, item_prize, item_foto, previous_price FROM menu WHERE item_status = 0 AND item_category = :item_category ORDER BY RAND()");
                    $search_query->bindvalue("item_category", $cat_id);
                    $search_query->execute();
                    
                

            ?>
            <h2>Collections for <strong><?php echo $category;
            ?></strong></h2>
            <hr>
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
                                <p class="first"><?php echo $show->item_name?></p>
                                
                                <span>₦ <?php echo number_format($show->item_prize)?></span>
                            </div>
                            
                        </figcaption>
                    </a>
                </figure>
                <?php endforeach ?>
            </div>
        </section>

        
    </main>
    <?php include "footer.php"?>
    <script src="../controller/jquery.js"></script>
    <script src="../controller/script.js"></script>
    
</body>
</html>
<?php }?>