<?php 
    include "controller/server.php";
    include "admin/views/cache_control.php";

    session_start(); 
    $title = "Sign in";
    if(isset($_SESSION['user'])){
        header("Location: index.php");
    }else{
    


date_default_timezone_set("Africa/Lagos");

$hour = date("H");

if($hour >= 5 && $hour < 12){
    $greeting = "Good Morning";
    $icon = "🌅";
}elseif($hour >= 12 && $hour < 17){
    $greeting = "Good Afternoon";
    $icon = "☀️";
}elseif($hour >= 17 && $hour < 21){
    $greeting = "Good Evening";
    $icon = "🌙";
}else{
    $greeting = "Welcome";
    $icon = "✨";
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include "head.php"?>
    <link rel="stylesheet" href="fontawesome-free-5.15.1-web/css/all.css">
    <link rel="icon" type="image/png" href="images/icon.png" size="32X32">
    <link rel="stylesheet" href="controller/style.css?v=<?php echo APP_VERSION;?>">
    
</head>     
<body> 
<style>
    .modern-form{

    width:100%;

}

.modern-form h2{

    font-size:34px;

    color:#173D7A;

    margin-bottom:10px;

}

.subtitle{

    color:#777;

    margin-bottom:35px;

}

.form-group{

    margin-bottom:22px;

}

.form-group label{

    display:block;

    margin-bottom:8px;

    font-weight:600;

}

.input-box{

    display:flex;

    align-items:center;

    border:1px solid #ddd;

    border-radius:14px;

    overflow:hidden;

    transition:.3s;

    background:#fff;

}

.input-box:hover,

.input-box:focus-within{

    border-color:#1674D5;

    box-shadow:0 0 0 4px rgba(22,116,213,.08);

}

.input-box i{

    width:55px;

    text-align:center;

    color:#888;

}

.input-box input{

    flex:1;

    border:none;

    outline:none;

    padding:17px 12px;

    font-size:15px;

}

.togglePassword{

    cursor:pointer;

    padding-right:18px;

    color:#888;

}

.pass{

    display:flex;

    justify-content:space-between;

    align-items:center;

    margin-bottom:8px;

}

.pass a{

    text-decoration:none;

    color:#1674D5;

    font-size:14px;

}

.pass a:hover{

    text-decoration:underline;

}

.remember{

    margin-bottom:25px;

    color:#666;

}

.login-btn{

    width:100%;

    border:none;

    padding:18px;

    border-radius:50px;

    background:linear-gradient(90deg,#1674D5,#8DCE1F);

    color:#fff;

    font-size:17px;

    font-weight:600;

    cursor:pointer;

    transition:.35s;

}

.login-btn:hover{

    transform:translateY(-3px);

    box-shadow:0 15px 35px rgba(22,116,213,.25);

}

.divider{

    text-align:center;

    margin:30px 0;

    position:relative;

}

.divider span{

    background:#fff;

    padding:0 15px;

    position:relative;

    color:#777;

}

.divider:before{

    content:"";

    position:absolute;

    width:100%;

    height:1px;

    background:#ddd;

    top:50%;

    left:0;

}

.create-account{

    display:block;

    text-align:center;

    padding:15px;

    border:2px solid #1674D5;

    color:#1674D5;

    border-radius:50px;

    text-decoration:none;

    font-weight:600;

    transition:.3s;

}

.create-account:hover{

    background:#1674D5;

    color:#fff;

}

.secure-note{

    margin-top:25px;

    text-align:center;

    color:#777;

    font-size:14px;

}
.adds{

    position:relative;

}

.hero-overlay{

    position:absolute;

    inset:0;

    background:rgba(0,0,0,.45);

    color:#fff;

    display:flex;

    flex-direction:column;

    justify-content:center;

    align-items:center;

    padding:40px;

    text-align:center;

}

.hero-overlay h2{

    font-size:36px;

    margin-bottom:15px;

}

.hero-overlay p{

    font-size:18px;

    margin-bottom:30px;

}

.hero-features{

    line-height:2;

    font-size:17px;

}
</style>

    <main id="reg_body">
        <section class="reg_log">
            
            <div class="login_page">
                <h1>
                    <a href="index.php">
                        <img src="images/logo.png" alt="logo">
                    </a>
                </h1>
                
                <!-- <h2>Welcome!</h2>
                <p>Sign in to continue</p> -->
                <?php
                    if(isset($_SESSION['success'])){
                        echo "<p class='success'>" . $_SESSION['success']. "</p>
                         <script>
                            setTimeout(function(){
                                $('.success').hide();
                            }, 5000);
                        </script>";
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
                <form action="controller/login.php" method="POST" class="modern-form">

                <h2><?php echo $icon . " " . $greeting; ?> 👋</h2>

                <p class="subtitle">
                    Welcome back! Sign in to continue shopping on
                    <strong>Rivicos</strong>.
                </p>

                <!-- Email -->

                <div class="form-group">

                    <label>Email Address</label>

                    <div class="input-box">

                        <i class="fas fa-envelope"></i>

                        <input
                            type="email"
                            name="email"
                            id="email"
                            placeholder="you@example.com"
                            required
                            value="<?php
                                if(isset($_SESSION['email'])){
                                    echo $_SESSION['email'];
                                    unset($_SESSION['email']);
                                }
                            ?>"
                        >

                    </div>

                </div>

                <!-- Password -->

                <div class="form-group">

                    <div class="pass">

                        <label>Password</label>

                        <a href="view/forgot_password.php">

                            Forgot Password?

                        </a>

                    </div>

                    <div class="input-box">

                        <i class="fas fa-lock"></i>

                        <input
                            type="password"
                            name="user_password"
                            id="user_password"
                            placeholder="Enter your password"
                            required
                        >

                        <span class="togglePassword" onclick="togglePassword()">

                            <i class="fas fa-eye"></i>

                        </span>

                    </div>

                </div>

                <!-- Remember -->

                <div class="remember">

                    <label>

                        <input type="checkbox">

                        Remember Me

                    </label>

                </div>

                <button
                    type="submit"
                    name="submit_login"
                    class="login-btn">

                    <i class="fas fa-sign-in-alt"></i>

                    Sign In

                </button>

                <div class="divider">

                    <span>OR</span>

                </div>

                <a href="registration.php" class="create-account">

                    <i class="fas fa-user-plus"></i>

                    Create New Account

                </a>

                <div class="secure-note">

                    <i class="fas fa-shield-alt"></i>

                    Secure Login • SSL Protected

                </div>

            </form>
                <!-- <div class="signup_option">
                    <p>Don't have an account yet? <a href="registration.php">Signup now</a></p>
                </div> -->
                <div id="foot">
                    <p >&copy;<?php echo Date("Y");?> Rivicos. All Rights Reserved.</p>

                </div>

            </div>
           <div class="adds">

    <img src="images/online_shop3.jpg">

    <div class="hero-overlay">

        <h2>Everything You Need in One Place</h2>

        <p>

            Groceries • Pharmacy • Household Essentials

        </p>

        <div class="hero-features">

            ✔ Fast Delivery

            ✔ Secure Payments

            ✔ Trusted Products

            ✔ Amazing Discounts

        </div>

    </div>

</div>
        </section>
    </main>
    <script src="controller/jquery.js"></script>
    <script src="controller/script.js"></script>
</body>
</html>
<?php }?>