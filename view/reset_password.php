<?php 
    include "../controller/server.php";
    include "../admin/views/cache_control.php";
    session_start(); 
    $title = " Reset Password"
?>

<!DOCTYPE html>
<html lang="en">
<head>
   
    <?php include "../head.php"?>
    <link rel="stylesheet" href="../fontawesome-free-5.15.1-web/css/all.css">
    <link rel="icon" type="image/png" href="../images/logo.png" size="32X32">
    <link rel="stylesheet" href="../controller/style.css?v=<?php echo APP_VERSION?>">
    
</head>     
<body> 
    <style>
        /* ===========================
   PAGE ICON
=========================== */

.page-icon{

    width:85px;
    height:85px;
    margin:20px auto;

    border-radius:50%;

    background:linear-gradient(135deg,#1674D5,#8DCE1F);

    display:flex;
    justify-content:center;
    align-items:center;

    color:#fff;

    font-size:24px;

    box-shadow:0 18px 40px rgba(22,116,213,.20);

}

/* ===========================
   TITLES
=========================== */

.login_page h2{

    font-size:32px;

    margin-top:20px;

    color:#173D7A;

}

.subtitle{

    color:#777;

    line-height:1.8;

    margin:15px 0 35px;

    font-size:15px;

}

/* ===========================
   ALERTS
=========================== */

.alert-success{

    background:#E8F8EF;

    color:#198754;

    padding:15px;

    border-radius:12px;

    margin-bottom:20px;

}

.alert-error{

    background:#FDECEC;

    color:#dc3545;

    padding:15px;

    border-radius:12px;

    margin-bottom:20px;

}

/* ===========================
   FORM
=========================== */

.form-group{

    margin-bottom:15px;

}

.form-group label{

    display:block;

    margin-bottom:8px;

    font-weight:600;

    color:#444;

}

/* ===========================
   INPUT BOX
=========================== */

.input-box{

    display:flex;

    align-items:center;

    background:#fff;

    border:1px solid #ddd;

    border-radius:15px;

    overflow:hidden;

    transition:.35s;

}

.input-box:hover{

    border-color:#1674D5;

}

.input-box:focus-within{

    border-color:#1674D5;

    box-shadow:0 0 0 4px rgba(22,116,213,.12);

}

.input-box i:first-child{

    width:55px;

    text-align:center;

    color:#888;

    font-size:18px;

}

.input-box input{

    flex:1;

    border:none;

    outline:none;

    background:transparent;

    padding:17px 10px;

    font-size:15px;

}

.input-box input::placeholder{

    color:#999;

}

.input-box span{

    width:55px;

    text-align:center;

    cursor:pointer;

    color:#888;

    transition:.3s;

}

.input-box span:hover{

    color:#1674D5;

}

/* ===========================
   PASSWORD STRENGTH
=========================== */

.password-strength{

    margin-top:12px;

}

.strength-bar{

    width:0%;

    height:8px;

    background:#ddd;

    border-radius:30px;

    transition:.4s;

}

#strength-text{

    display:block;

    margin-top:8px;

    color:#777;

    font-size:13px;

}

/* ===========================
   PASSWORD MATCH
=========================== */

#passwordMatch{

    display:block;

    margin-top:10px;

    font-size:14px;

    font-weight:600;

}

/* ===========================
   BUTTON
=========================== */

.login-btn{

    width:100%;

    height:58px;

    border:none;

    border-radius:16px;

    background:linear-gradient(
        135deg,
        #1674D5,
        #0F8CA1,
        #8DCE1F
    );

    background-size:250% 250%;

    color:#fff;

    font-size:16px;

    font-weight:600;

    cursor:pointer;

    display:flex;

    justify-content:center;

    align-items:center;

    transition:.35s;

    position:relative;

    overflow:hidden;

    animation:gradientMove 5s ease infinite;

}

.login-btn:hover{

    transform:translateY(-3px);

    box-shadow:0 18px 40px rgba(22,116,213,.30);

}

.login-btn:active{

    transform:scale(.98);

}

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

    left:160%;

}

.login-btn i{

    margin-right:10px;

}

.btn-loader{

    display:none;

    align-items:center;

    gap:10px;

}

/* ===========================
   HELP BOX
=========================== */

.help-box{

    margin-top:35px;

    display:flex;

    gap:18px;

    background:#F8FAFD;

    border-left:5px solid #1674D5;

    padding:20px;

    border-radius:14px;

}

.help-box i{

    color:#1674D5;

    font-size:24px;

    margin-top:4px;

}

.help-box strong{

    display:block;

    margin-bottom:10px;

}

.help-box ul{

    padding-left:18px;

    margin:0;

}

.help-box li{

    margin-bottom:8px;

    color:#666;

}

/* ===========================
   LINKS
=========================== */

.signup_option{

    margin-top:30px;

    text-align:center;

}

.signup_option p{

    margin-bottom:10px;

}

.signup_option a{

    color:#1674D5;

    text-decoration:none;

    font-weight:600;

}

.signup_option a:hover{

    text-decoration:underline;

}

/* ===========================
   FOOTER
=========================== */

#foot{

    margin-top:35px;

    text-align:center;

    color:#888;

    font-size:14px;

}

/* ===========================
   ANIMATION
=========================== */

@keyframes gradientMove{

0%{

background-position:left;

}

50%{

background-position:right;

}

100%{

background-position:left;

}

}

/* ===========================
   MOBILE
=========================== */

@media(max-width:768px){

.login_page{

    padding:30px 25px;

}

.login_page h2{

    font-size:27px;

}

.page-icon{

    width:70px;

    height:70px;

    font-size:28px;

}

.subtitle{

    font-size:14px;

}

.input-box input{

    font-size:14px;

}

.login-btn{

    height:54px;

}

}
    </style>
    <?php
        if(isset($_SESSION['user'])){
            header("Location: index.php");
        }else{
            if(!isset($_GET['token']) || !isset($_GET['email'])){
                $_SESSION['error'] = "Invalid password reset link!";
                header("Location: forgot_password.php");
            }else{
                $token = $_GET['token'];
                $email = $_GET['email'];
                $check_token = $connectdb->prepare("SELECT * FROM shoppers WHERE token = :token AND email = :email");
                $check_token->bindValue('token', $token);
                $check_token->bindValue('email', $email);
                $check_token->execute();
                if($check_token->rowCount() == 0){
                    $_SESSION['error'] = "Invalid password reset link!";
                    header("Location: forgot_password.php");
                }else{
           
    ?>
    <main id="reg_body">
        <section class="reg_log">
            
            <div class="login_page">
                <h1>
                    <a href="../index.php">
                        <img src="../images/logo.png" alt="logo">
                    </a>
                </h1>
                
                <h2>Create a New Password</h2>

                <p class="subtitle">
                Choose a strong password that you haven't used before.
                For your security, this password will replace your previous one immediately.
                </p>
                <!-- <p>Reset your password</p> -->
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
                
                <form action="../controller/reset_password.php" method="POST">
                    <!-- <div class="data"> -->
                        <!-- <label for="username">Enter email address</label> -->
                        <input type="hidden" name="token" id="token" required value="<?php echo $token?>">
                        <input type="hidden" name="user_email" id="user_email" required value="<?php echo $email?>">
                        
                    <!-- </div> -->
                    <div class="form-group">

                        <label>New Password</label>

                        <div class="input-box">

                            <i class="fas fa-lock"></i>

                            <input
                                type="password"
                                name="user_password"
                                id="user_password"
                                placeholder="Enter your new password"
                                required
                            >

                            <span onclick="togglePassword()">
                                <i class="fas fa-eye"></i>
                            </span>

                        </div>

                    </div>
                    <div class="password-strength">

                        <div class="strength-bar"></div>

                        <small id="strength-text">

                            Password Strength

                        </small>

                    </div>
                    <div class="form-group">

                        <label>Confirm Password</label>

                        <div class="input-box">

                            <i class="fas fa-check-circle"></i>

                            <input
                                type="password"
                                name="retype_password"
                                id="confirm_password"
                                placeholder="Confirm your password"
                                required
                            >

                        </div>

                    </div>
                    <small id="passwordMatch"></small>
                    <button type="submit"
                    name="change_password"
                    class="login-btn">

                    <span class="btn-text">

                    <i class="fas fa-key"></i>

                    Update Password

                    </span>

                    <span class="btn-loader">

                    <i class="fas fa-spinner fa-spin"></i>

                    Updating...

                    </span>

                    </button>
                    
                </form>
                <div class="help-box">

                <i class="fas fa-lightbulb"></i>

                <div>

                <strong>Password Tips</strong>

                <ul>

                <li>Use at least 8 characters.</li>

                <li>Include uppercase and lowercase letters.</li>

                <li>Add numbers and symbols.</li>

                <li>Avoid using your name or phone number.</li>

                </ul>

                </div>

                </div>
                <div class="signup_option">
                    <p>Don't have an account yet? <a href="../registration.php">Signup now</a></p>
                </div>
                <div id="foot">
                    <p >&copy;<?php echo Date("Y");?> Rivicos. All Rights Reserved.</p>

                </div>

            </div>
            <div class="adds">
                <img src="../images/online_shop3.jpg" alt="clozeth login banner">
            </div>
        </section>
    </main>
    <?php 
            }
        }
    }?>
    <script src="../controller/jquery.js"></script>
    <script src="../controller/script.js"></script>
    <script>
            const password = document.getElementById("user_password");

password.addEventListener("keyup", function(){

    let value = password.value;

    let score = 0;

    if(value.length >= 6) score++;
    if(/[A-Z]/.test(value)) score++;
    if(/[a-z]/.test(value)) score++;
    if(/[0-9]/.test(value)) score++;
    if(/[^A-Za-z0-9]/.test(value)) score++;

    let bar = document.querySelector(".strength-bar");
    let text = document.getElementById("strength-text");

    if(score <= 2){
        bar.style.width="30%";
        bar.style.background="#dc3545";
        text.innerHTML="Weak Password";
    }
    else if(score <= 4){
        bar.style.width="70%";
        bar.style.background="#ffc107";
        text.innerHTML="Medium Password";
    }
    else{
        bar.style.width="100%";
        bar.style.background="#28a745";
        text.innerHTML="Strong Password";
    }

});
const confirmPassword = document.getElementById("confirm_password");

confirmPassword.addEventListener("keyup", function(){

    let result = document.getElementById("passwordMatch");

    if(confirmPassword.value === password.value){

        result.style.color="green";
        result.innerHTML="✓ Passwords match";

    }else{

        result.style.color="red";
        result.innerHTML="✕ Passwords do not match";

    }

});
    </script>
</body>
</html>