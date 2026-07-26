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
        $title = $full_name. " - Notifications";
?>
<!DOCTYPE html>
<html lang="en">
<head>

        <?php
            include "../head.php";
        ?>
    <link rel="stylesheet" href="../fontawesome-free-5.15.1-web/css/all.css">
    <link rel="icon" type="image/png" href="../images/logo.png" size="32X32">
    <link rel="stylesheet" href="../controller/style.css">
    
</head>
<body>
    <?php include "header.php";?>

    <?php include "mobile_menu.php";?>

    <main>
    <section id="notification">
            <h2>Messages / Notifications</h2>
            <hr>
            
            <div class="notifications">
                <?php
                    $select_not = $connectdb->prepare("SELECT SUBSTRING_INDEX (details, ' ', 7) AS details, notification_id, status, notification_date, subject, customer FROM notifications WHERE customer = :customer ORDER BY notification_date DESC");
                    $select_not->bindvalue('customer', $id);
                    $select_not->execute();

                    $rows = $select_not->fetchAll();
                    foreach($rows as $row):
                ?>

                <div class="notify">
                    <?php if($row->status == 0){?>
                    <a href="javascript:void(0)" onclick="viewNotification('<?php echo $row->notification_id?>')">
                        <div class="not_sum">
                            <i class="fas fa-bell"></i>
                            <div class="not_details">
                                <h3 style="font-weight:bolder"><?php echo $row->subject?></h3>
                                <p style="font-weight:bolder"><?php echo $row->details?><span>......More</span></p>
                                
                            </div>
                            
                        </div>
                        <p class="notify_date"><?php echo date("jS M, Y", strtotime($row->notification_date));?></p>
                        <div class="clear"></div>
                        
                    </a>
                    <?php }else{?>
                        <a href="javascript:void(0)" onclick="viewNotification('<?php echo $row->notification_id?>')">
                        <div class="not_sum">
                            <i class="fas fa-bell"></i>
                            <div class="not_details">
                                <h3 style="font-weight:normal"><?php echo $row->subject?></h3>
                                <p><?php echo $row->details?><span>......More</span></p>
                                
                            </div>
                        </div>
                        <p class="notify_date"><?php echo date("jS M, Y", strtotime($row->notification_date));?></p>
                        <div class="clear"></div>
                    </a>
                    <?php }?>
                </div>
                <?php
                    endforeach;
                    
                    if(!$select_not->rowCount()){
                        echo "<p style='font-weight:bold; color:chocolate; text-transform:capitalize; font-size:1.1rem; text-align:center; margin-top:10px;'>No notification!</p>";
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