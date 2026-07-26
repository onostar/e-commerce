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
        $title = $full_name. " - Notification details";
?>
<!DOCTYPE html>
<html lang="en">
<head>

        <?php
            include "../head.php";
        ?>
    <link rel="stylesheet" href="../fontawesome-free-5.15.1-web/css/all.css">
    <link rel="icon" type="image/png" href="images/foodie.png" size="32X32">
    <link rel="stylesheet" href="../controller/style.css">
    
</head>
<body>
    <?php include "header.php";?>

    <?php include "mobile_menu.php";?>

    <main>
    <?php
        if(isset($_GET['notify_id'])){
            $notify_id = $_GET['notify_id'];
            $get_message = $connectdb->prepare("SELECT * FROM notifications WHERE notification_id = :notification_id");
            $get_message->bindvalue("notification_id", $notify_id);
            $get_message->execute();

            
            $views = $get_message->fetchAll();
            foreach($views as $view):
        
    ?>
        <section id="notification">
            <h2><?php echo $view->subject?></h2>
            <hr>
            
            <div class="message_details">
                <p><?php echo $view->details?>
                    
            </div>
            
        </section>
        <?php
            if($view->status == 0){
                $update_status = $connectdb->prepare("UPDATE notifications SET status = 1 WHERE notification_id = :notification_id");
                $update_status->bindvalue("notification_id", $notify_id);
                $update_status->execute();

            }
        ?>
        <?php endforeach; }?>
        
        
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