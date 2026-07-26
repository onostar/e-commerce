<?php
    require "../controller/server.php";
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
        $title = $full_name. " - Order history";
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
    <link rel="stylesheet" href="../controller/style.css">
    
</head>
<body>
    <?php include "header.php";?>

    <?php include "mobile_menu.php";?>

    <main>
    <section id="history">
            <h2>My Order history</h2>
            <hr>
            <p class="successful">
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
            </p>
            <div class="order_history">
                <?php
                    $select_orders = $connectdb->prepare("SELECT orders.customer, orders.item_id, orders.quantity, orders.item_price, orders.company, orders.order_date, orders.order_number, orders.order_status, orders.delivery_date, orders.order_id, menu.item_name, menu.item_foto FROM orders, menu WHERE orders.item_id = menu.item_id AND orders.customer = :customer ORDER BY orders.order_date DESC");
                    $select_orders->bindvalue('customer', $id);
                    $select_orders->execute();

                    $rows = $select_orders->fetchAll();
                    foreach($rows as $row):
                ?>

                <figure>
                    <a href="javascript:void(0)" title="View Order details" onclick="viewOrder('<?php echo $row->order_id?>')"><img src="<?php echo '../items/'.$row->item_foto?>" alt="my order" loading="lazy"></a>
                    <figcaption>
                        <div class="order_details">
                            <h4>Order#: <?php echo $row->order_number;?></h4>
                            <p id="name"><?php echo $row->item_name;?></p>
                            
                            <p>Qty: <?php echo $row->quantity;?></p>
                            <p>Price: ₦<?php echo number_format($row->item_price);?></p>
                            <!-- <p>Total Amount: ₦<?php echo number_format($row->item_price * $row->quantity);?></p> -->
                            <p>Ordered on <?php echo date("jS M, Y", strtotime($row->order_date))?></p>
                            <!-- <p>Ordered: <?php echo date("M jS, Y", strtotime($row->order_date));?></p> -->
                            <div class="status_order" id="status_flex"> 
                                <?php 
                                    $order_status = 
                                    $row->order_status;
                                    if($order_status == 2){
                                        echo "<p style='background:green;'>Delivered <i class='fas fa-truck'></i></p>";
                                    }elseif($order_status == -1){
                                        echo "<p style='background:red;'>Cancelled <i class='fas fa-plane-slash'></i></p>";
                                    }elseif($order_status == 1){
                                        echo "<p style='background:hsl(180, 81%, 24%, .8);'>On transit <i class='fas fa-plane'></i></p>";
                                    }else{
                                        echo "<p style='background:hsla(202, 81%, 22%, .9);'>Processing <i class='fas fa-spinner'></i></p>";
                                ?>
                                    <a style="border-radius:10px;"class="cancel_order" id="showHistory" href="javascript:void(0);" title="Cancel Order" onclick="cancelOrder('<?php echo $row->order_id?>')">Cancel Order <i class="fas fa-plane-slash"></i></a>
                                <?php }?>
                            </div>
                        </div>
                        <div class="status_order">
                            <a href="javascript:void(0)" title="View Order details" onclick="viewOrder('<?php echo $row->order_id?>')">Show details <i class="fas fa-eye"></i></a>
                        </div>
                    </figcaption>
                </figure>
                <?php
                    endforeach;
                    
                    if(!$select_orders->rowCount()){
                        echo "<p style='font-weight:bold; color:chocolate; text-transform:capitalize; font-size:1.1; text-align:center; margin-top:10px;'>No record found!</p>";
                    }
                ?>
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

<?php
    }else{
        header("Location: ../index.php");
    }
?> 