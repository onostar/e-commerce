<?php 
    include "../controller/server.php";
    include "../admin/views/cache_control.php";

    session_start(); 
    $title = "Pasword recovery";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include "../head.php"?>
    <link rel="stylesheet" href="../fontawesome-free-5.15.1-web/css/all.css">
    <link rel="icon" type="image/png" href="../images/icon.png" size="32X32">
    <link rel="stylesheet" href="../controller/style.css?v=<?php echo APP_VERSION?>">
    
</head>     
<body> 
<style>
    .page-icon{

    width:80px;
    height:80px;

    margin:20px auto;

    border-radius:50%;

    background:linear-gradient(135deg,#1674D5,#8DCE1F);

    color:#fff;

    display:flex;

    align-items:center;

    justify-content:center;

    font-size:34px;

    box-shadow:0 15px 35px rgba(22,116,213,.2);

}

.subtitle{

    color:#666;

    line-height:1.8;

    margin-bottom:35px;

}

.alert-success{

    background:#E8F8EF;

    color:#1E7E34;

    padding:15px;

    border-radius:10px;

    margin-bottom:20px;

}

.alert-error{

    background:#FDECEC;

    color:#C62828;

    padding:15px;

    border-radius:10px;

    margin-bottom:20px;

}

.help-box{

    margin-top:30px;

    display:flex;

    gap:15px;

    background:#F8FAFD;

    border-left:4px solid #1674D5;

    padding:18px;

    border-radius:12px;

}

.help-box i{

    color:#1674D5;

    font-size:22px;

    margin-top:3px;

}

.help-box p{

    margin:6px 0 0;

    color:#777;

    line-height:1.7;

}
/* FORM GROUP */
.form-group{
    margin-bottom:25px;
}

.form-group label{
    display:block;
    margin-bottom:8px;
    font-size:15px;
    font-weight:600;
    color:#333;
}

/* INPUT CONTAINER */
.input-box{
    display:flex;
    align-items:center;
    background:#fff;
    border:1px solid #d9d9d9;
    border-radius:14px;
    overflow:hidden;
    transition:all .3s ease;
}

.input-box:hover{
    border-color:#1674D5;
}

.input-box:focus-within{
    border-color:#1674D5;
    box-shadow:0 0 0 4px rgba(22,116,213,.12);
}

/* ICON */
.input-box i{
    width:55px;
    text-align:center;
    color:#8a8a8a;
    font-size:18px;
}

/* INPUT */
.input-box input{
    flex:1;
    border:none;
    outline:none;
    background:transparent;
    padding:17px 18px 17px 0;
    font-size:15px;
    color:#333;
}

.input-box input::placeholder{
    color:#aaa;
}
.login-btn{

    width:100%;

    height:58px;

    border:none;

    border-radius:15px;

    background:linear-gradient(135deg,#1674D5,#8DCE1F);

    color:#fff;

    font-size:16px;

    font-weight:600;

    cursor:pointer;

    transition:.35s;

    display:flex;

    justify-content:center;

    align-items:center;

    position:relative;

    overflow:hidden;

}

.login-btn i{

    margin-right:10px;

}

.login-btn:hover{

    transform:translateY(-3px);

    box-shadow:0 18px 40px rgba(22,116,213,.30);

}

/* Click animation */

.login-btn:active{

    transform:scale(.98);

}

/* Shine Effect */

.login-btn::before{

    content:"";

    position:absolute;

    top:0;

    left:-120%;

    width:60%;

    height:100%;

    background:rgba(255,255,255,.25);

    transform:skewX(-25deg);

    transition:.8s;

}

.login-btn:hover::before{

    left:150%;

}

.btn-loader{

    display:flex;

    align-items:center;

    gap:10px;

}
</style>
    <main id="reg_body">
        <section class="reg_log">
            
            <div class="login_page">

    <h1>
        <a href="../index.php">
            <img src="../images/logo.png" alt="Rivicos Logo">
        </a>
    </h1>

    <div class="page-icon">
        <i class="fas fa-unlock-alt"></i>
    </div>

    <h2>Forgot Your Password?</h2>

    <p class="subtitle">
        No worries! Enter the email address associated with your Rivicos account and we'll send you a secure password reset link.
    </p>

    <?php
        if(isset($_SESSION['success'])){
            echo "<div class='alert-success'><i class='fas fa-check-circle'></i> ".$_SESSION['success']."</div>";
            unset($_SESSION['success']);
        }

        if(isset($_SESSION['error'])){
            echo "<div class='alert-error'><i class='fas fa-times-circle'></i> ".$_SESSION['error']."</div>";
            unset($_SESSION['error']);
        }
    ?>

                <form action="../controller/recover_password.php" method="POST" class="modern-form">

                    <div class="form-group">

                        <label>Email Address</label>

                        <div class="input-box">

                            <i class="fas fa-envelope"></i>

                            <input
                                type="email"
                                name="email"
                                placeholder="Enter your registered email"
                                required
                            >

                        </div>

                    </div>

                    <button type="submit" name="recover" class="login-btn">

    <span class="btn-text">
        <i class="fas fa-paper-plane"></i>
        Send Reset Link
    </span>

    <span class="btn-loader" style="display:none;">
        <i class="fas fa-spinner fa-spin"></i>
        Sending...
    </span>

</button>

                </form>

                <div class="help-box">

                    <i class="fas fa-info-circle"></i>

                    <div>

                        <strong>Didn't receive the email?</strong>

                        <p>
                            Check your Spam or Junk folder. If it's not there, wait a few minutes and try again.
                        </p>

                    </div>

                </div>

                <div class="signup_option">

                    <p>

                        Remember your password?

                        <a href="../login_page.php">

                            Sign In

                        </a>

                    </p>

                    <p>

                        Don't have an account?

                        <a href="../registration.php">

                            Create One

                        </a>

                    </p>

                </div>

                <div id="foot">

                    <p>

                        &copy;<?php echo date("Y"); ?>

                        Rivicos. All Rights Reserved.

                    </p>

                </div>

            </div>
            <div class="adds">
                <img src="../images/online_shop3.jpg" alt="clozeth login banner">

            </div>
        </section>
    </main>
    <script src="../controller/jquery.js"></script>
    <script src="../controller/script.js"></script>
</body>
</html>
<script>
    document.querySelector(".modern-form").addEventListener("submit",function(){

    document.querySelector(".btn-text").style.display="none";

    document.querySelector(".btn-loader").style.display="flex";

    document.querySelector(".login-btn").disabled=true;

});
</script>