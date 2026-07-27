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
        <section id="itemContent">
            <?php
                if(isset($_GET['item'])){
                    $item = $_GET['item'];
                    $get_item = $connectdb->prepare("SELECT * FROM menu WHERE item_id = :item_id");
                    $get_item->bindValue("item_id", $item);
                    $get_item->execute();
                    $rows = $get_item->fetchAll();
                    foreach($rows as $row){
                        $item_name = $row->item_name;
                        $price = $row->item_prize;
                    }
            ?>
            <div class="review_form">
                <h3>Add review for <?php echo $item_name?></h3>
                <form action="../controller/add_review.php" method="POST">
                    <input type="hidden" name="item" id="item" value="<?php echo $item?>">
                    <input type="hidden" name="customer" id="customer" value="<?php echo $id?>">
                    <textarea name="details" id="details" placeholder="Enter your review here" cols="30" rows="10"></textarea>
                    <button type="submit" name="add_review">Add review <i class="fas fa-star"></i><i class="fas fa-star"></i></button>
                </form>
            </div>
            
            <?php }?>
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
    <script src="../controller/script.js"></script>
    
</body>
</html>

<?php
    }else{
        header("Location: ../index.php");
    }
?> 