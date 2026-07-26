<?php 
    include "controller/connections.php";
    session_start();
    $title = "Change Password" 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include "head.php"?>
    <link rel="stylesheet" href="fontawesome-free-5.15.1-web/css/all.css">
    <link rel="icon" type="image/png" href="images/logo.png" size="32X32">
    <link rel="stylesheet" href="style.css">
    
</head>     
<body> 
    <?php
        if(isset($_SESSION['user'])){
            $username = $_SESSION['user'];
    ?>
    <main id="reg_body">
        <section class="reg_log">
            
            <div class="login_page">
                <h1>
                    <a href="../index.php">
                        <img src="images/logo.png" alt="logo">
                    </a>
                </h1>
                
                <h2>Change your password</h2>
                <!-- <p>Sign in to continue</p> -->
                <?php
                    if(isset($_GET['item'])){
                        echo "<p class='success'>" . $_GET['item']. "</p>";
                        unset($_GET['item']);
                    }
                ?>
                <?php
                    if(isset($_SESSION['success'])){
                        echo "<p class='success succeed'>" . $_SESSION['success']. "</p>
                        <script>
                            setTimeout(function(){
                                $('.succeed').hide();
                                window.open('../login_page.php', '_parent');
                            }, 5000);
                        </script>
                        ";
                        unset($_SESSION['success']);
                    }
                
                    if(isset($_SESSION['error'])){
                        echo "<p class='error succeed'>" . $_SESSION['error']. "</p>
                        <script>
                            setTimeout(function(){
                                $('.succeed').hide();
                            }, 5000)
                        </script>";
                        unset($_SESSION['error']);
                    }
                ?>
                <form action="controller/reset_password.php" method="POST">
                    <div class="data" style="margin:10px 0!Important">
                        <label for="username">Username</label>
                        <input type="text" name="username" id="username" required value="<?php echo $username?>" readonly>
                        <!-- <input type="hidden" name="current_password" value="123"> -->
                        
                    </div>
                    <div class="data" style="margin:10px 0!Important">
                        <label for="new_password">Enter new Password</label>
                        <input type="password" name="new_password" id="password" class="password" placeholder="*******" required>
                        
                    </div>
                    <div class="data" style="margin:10px 0!Important">
                        <label for="password">Confirm Password</label>
                        <input type="password" name="retype_password" id="retype_password" class="password" placeholder="*******" required>
                        <div class="show_password">
                            <a href="javascript:void(0)" onclick="togglePassword()"><span class="icon"><i class="fas fa-eye"></i></span> <span class="icon_txt">Show password</span></a>
                        </div>
                    </div>
                    <div class="data">
                        <button type="submit" id="change_password" name="change_password">Change Password <i class="fas fa-sign-in-alt"></i></button>

                    </div>
                    
                </form>
                <!-- <div class="signup_option">
                    <p>Don't have an account yet? <a href="views/company_registration.php">Signup now</a></p>
                </div> -->
                <div id="foot">
                    <p >&copy;<?php echo Date("Y");?> Rivicos. All Rights Reserved.</p>

                </div>

            </div>
            <div class="adds">
                <img src="../images/online_shop2.jpg" alt="login banner">
            </div>
        </section>
    </main>
    <?php
        }else{
            header("Location: ../login_page.php");
        }
    ?>
    <script src="jquery.js"></script>
    <script src="script.js"></script>
</body>
</html>