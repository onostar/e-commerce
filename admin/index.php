<?php 
    include "controller/connections.php";
    session_start();
    $title = "Admin Login" 
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
        
    <main id="reg_body">
        <section class="reg_log">
            
            <div class="login_page">
                <h1>
                    <a href="../index.php">
                        <img src="images/logo.png" alt="logo">
                    </a>
                </h1>
                
                <h2>Welcome!</h2>
                <p>Sign in to continue</p>
                <?php
                    if(isset($_SESSION['success'])){
                        echo "<p class='success'>" . $_SESSION['success']. "</p>";
                        unset($_SESSION['success']);
                    }
                    if(isset($_GET['item'])){
                        echo "<p class='success'>" . $_GET['item']. "</p>";
                        unset($_GET['item']);
                    }
                ?>
                <?php
                    if(isset($_SESSION['error'])){
                        echo "<p class='error'>" . $_SESSION['error']. "</p>";
                        unset($_SESSION['error']);
                    }
                ?>
                <form action="controller/exh_login.php" method="POST">
                    <div class="data">
                        <label for="username">Enter username</label>
                        <input type="text" name="exh_username" id="exh_username" required value="<?php if(isset($_SESSION['email'])){
                            echo $_SESSION['email'];
                            unset($_SESSION['email']);
                        }?>">
                        
                    </div>
                    <div class="data">
                        <div class="pass">
                            <label for="password">Password</label>
                            <a href="views/forgot_password.php" title="Recover your password">Forgot password?</a>
                        </div>
                        <input type="password" name="password" id="password" placeholder="*******" required><br>
                        <div class="show_password">
                            <a href="javascript:void(0)" onclick="togglePassword()"><i class="fas fa-eye"></i> Show password</a>
                        </div>
                        
                    </div>
                    <div class="data">
                        <button type="submit" id="submit_login" name="submit_login">Sign in <i class="fas fa-sign-in-alt"></i></button>

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
    <script src="jquery.js"></script>
    <script src="script.js"></script>
</body>
</html>