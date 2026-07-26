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
        $title = $fullname . " - Search Result";
    }else{
        $title = " Search Results";
    }
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
        <section id="searchResults">
            <?php
            
                if(isset($_GET['search_items'])){
                    $item_search = ucwords(htmlspecialchars(stripslashes($_GET['search_items'])));

                    $search_query = $connectdb->prepare("SELECT * FROM menu WHERE  item_name LIKE '%$item_search%' AND item_status = 0/*  OR categories.category LIKE '%$item_search% */ ORDER BY RAND()");
                    $search_query->execute();   
                }

            ?>
            <h2>Showing results for "<strong><?php echo $item_search?></strong>"</h2>
            <hr>
            <div class="results">
                
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
                                <p><?php echo $show->item_name?></p>
                                
                                <span>₦<?php echo number_format($show->item_prize)?></span>

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
    <script src="../controller/script.js?v=<?php echo APP_VERSION?>"></script>
    
</body>
</html>
