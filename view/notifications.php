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
    <link rel="stylesheet" href="../controller/style.css?v<?php echo APP_VERSION?>">
    
</head>
<body>
    <?php include "header.php";?>

    <?php include "mobile_menu.php";?>

    <main>
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@500;600;700;800&family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

<section id="notification">

    <style>
        #notification{
            --primary: #1674D5;
            --primary-dark: #0f5cab;
            --primary-tint: #E9F3FE;
            --secondary: #8DCE1F;
            --secondary-tint: #F0FAE1;
            --ink: #12203A;
            --muted: #6C7A93;
            --bg: #F5F8FC;
            --surface: #ffffff;
            --line: #E7EDF6;
            --gradient: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);

            font-family: 'Nunito', system-ui, sans-serif;
            color: var(--ink);
            background: var(--bg);
            padding: 20px 4vw 60px;
            display: block;
        }

        #notification h2{
            font-family: 'Poppins', system-ui, sans-serif;
        }

        #notification hr{
            display: none;
        }

        .notif_header{
            max-width: 720px;
            margin: 0 auto 16px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .notif_header h2{
            font-size: 1.3rem;
            font-weight: 700;
            margin: 0;
        }

        .unread_pill{
            background: var(--gradient);
            color: #fff;
            font-size: .74rem;
            font-weight: 700;
            padding: 4px 12px;
            border-radius: 999px;
        }

        .notifications{
            max-width: 720px;
            margin: 0 auto;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .notify a{
            display: flex;
            align-items: flex-start;
            gap: 14px;
            background: var(--surface);
            border-radius: 16px;
            box-shadow: 0 3px 14px rgba(18,32,58,.05);
            padding: 16px;
            text-decoration: none;
            color: inherit;
            position: relative;
            transition: box-shadow .15s ease, transform .1s ease;
        }

        .notify a:hover{
            box-shadow: 0 8px 22px rgba(18,32,58,.09);
        }

        .notify a:active{
            transform: scale(.995);
        }

        /* unread accent bar */
        .notify.unread a{
            box-shadow: 0 3px 14px rgba(22,116,213,.10);
        }

        .notify.unread a::before{
            content: '';
            position: absolute;
            left: 0;
            top: 12px;
            bottom: 12px;
            width: 3px;
            border-radius: 999px;
            background: var(--gradient);
        }

        .not_sum{
            display: flex;
            align-items: flex-start;
            gap: 14px;
            flex: 1;
            min-width: 0;
        }

        .not_sum > i{
            flex-shrink: 0;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: .95rem;
            background: var(--primary-tint);
            color: var(--primary);
        }

        .notify.unread .not_sum > i{
            background: var(--gradient);
            color: #fff;
        }

        .not_details{
            min-width: 0;
            flex: 1;
        }

        .not_details h3{
            font-family: 'Poppins', sans-serif;
            font-size: .92rem;
            font-weight: 600 !important;
            color: var(--ink);
            margin: 0 0 4px;
        }

        .notify.unread .not_details h3{
            font-weight: 700 !important;
        }

        .not_details p{
            margin: 0;
            font-size: .84rem;
            color: var(--muted);
            font-weight: 400 !important;
            overflow: hidden;
            text-overflow: ellipsis;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
        }

        .not_details p span{
            color: var(--primary);
            font-weight: 700;
            margin-left: 4px;
            white-space: nowrap;
        }

        .notify_date{
            flex-shrink: 0;
            font-size: .72rem;
            color: var(--muted);
            font-weight: 600;
            margin: 2px 0 0;
            white-space: nowrap;
        }

        .clear{
            display: none;
        }

        .no_notification{
            max-width: 720px;
            margin: 0 auto;
            background: var(--surface);
            border-radius: 16px;
            padding: 44px 20px;
            text-align: center;
            color: var(--muted);
            font-weight: 700;
        }

        @media (max-width: 480px){
            .notify a{
                flex-wrap: wrap;
                gap: 10px;
            }

            .notify_date{
                margin-left: 54px;
            }
        }
    </style>

    <?php
        $select_not = $connectdb->prepare("SELECT SUBSTRING_INDEX (details, ' ', 7) AS details, notification_id, status, notification_date, subject, customer FROM notifications WHERE customer = :customer ORDER BY notification_date DESC");
        $select_not->bindvalue('customer', $id);
        $select_not->execute();

        $rows = $select_not->fetchAll();
        $unread_count = 0;
        foreach($rows as $r){
            if($r->status == 0) $unread_count++;
        }
    ?>

    <div class="notif_header">
        <h2>Messages / Notifications</h2>
        <?php if($unread_count > 0): ?>
        <span class="unread_pill"><?php echo $unread_count; ?> new</span>
        <?php endif; ?>
    </div>
    <hr>

    <div class="notifications">
        <?php
            foreach($rows as $row):
        ?>

        <div class="notify <?php echo $row->status == 0 ? 'unread' : ''; ?>">
            <a href="javascript:void(0)" onclick="viewNotification('<?php echo $row->notification_id?>')">
                <div class="not_sum">
                    <i class="fas fa-bell"></i>
                    <div class="not_details">
                        <h3><?php echo $row->subject?></h3>
                        <p><?php echo $row->details?><span>......More</span></p>
                    </div>
                </div>
                <p class="notify_date"><?php echo date("jS M, Y", strtotime($row->notification_date));?></p>
            </a>
        </div>
        <?php
            endforeach;

            if(!$select_not->rowCount()){
                echo "<p class='no_notification'>No notification!</p>";
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