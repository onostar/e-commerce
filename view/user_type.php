<?php 
    include "../controller/server.php";
    session_start(); 
    $title = "User type";
    if(isset($_SESSION['user'])){
        header("Location: ../index.php");
    }else{
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include "../head.php"?>
<link rel="stylesheet" href="../fontawesome-free-5.15.1-web/css/all.css">
    <link rel="icon" type="image/png" href="../images/logo.png" size="32X32">
    <link rel="stylesheet" href="../fontawesome-free-6.0.0-web/css/all.css">
    <link rel="stylesheet" href="../controller/style.css">
    
</head>     
<body> 
        
    <main id="reg_body">
        <section class="reg_log">
            
            <div class="login_page">
                <h1>
                    <a href="../index.php">
                        <img src="../images/logo.png" alt="logo">
                    </a>
                </h1>
                
                <h2>Choose user type!</h2>
                <p>I want to</p>
                <div class="user_type">
                    <a title="i want to shop for item" href="../login_page.php">
                        <img src="../images/shopper.jpg" alt="buyer">
                        <p>Shop for items <i class="fas fa-shopping-bag"></i></p>
                    </a>
                    <a href="../admin/index.php">
                        <img src="../images/seller.jpg" alt="seller">
                        <p>Sell my products <i class="fas fa-store-alt"></i></p>
                    </a>
                </div>
                <div id="foot">
                    <p >&copy;<?php echo Date("Y");?> Realcare. All Rights Reserved.</p>

                </div>

            </div>
            <div class="adds">
                <img src="../images/online_shop3.jpg" alt="login banner">
            </div>
        </section>
    </main>
    <script src="../controller/jquery.js"></script>
    <script src="../controller/script.js"></script>
</body>
</html>
<?php }?>