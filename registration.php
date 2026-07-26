<?php
    session_start();
    require "controller/server.php";
    include "admin/views/cache_control.php";

    $title = "Register Account";
    if(isset($_SESSION['user'])){
        header("Location: index.php");
    }else{
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include "head.php"?>
    <link rel="stylesheet" href="fontawesome-free-5.15.1-web/css/all.css">
    <link rel="icon" type="image/png" href="images/icon.png" size="32X32">
    <link rel="stylesheet" href="controller/style.css?v=<?php echo APP_VERSION ?>">
    
</head>     
<body> 
    <style>
        .modern-form{
    width:100%;
}

.modern-form h2{
    font-size:30px;
    color:#173D7A;
    margin-bottom:10px;
}

.subtitle{
    color:#777;
    margin-bottom:35px;
}

.row{
    display:flex;
    gap:20px;
}

.form-group{
    flex:1;
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
    background:#fff;
    transition:.3s;
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

.input-box input,
.input-box select{
    width:100%;
    border:none;
    outline:none;
    padding:16px 12px;
    font-size:15px;
    background:none;
}

.togglePassword{
    cursor:pointer;
    padding-right:18px;
    color:#888;
}

.field-error{
    display:block;
    color:#d62828;
    margin-top:6px;
}

.password-strength{
    margin:20px 0;
}

.strength-bar{
    height:8px;
    background:#eee;
    border-radius:20px;
    margin-top:8px;
}

#strength-fill{
    display:block;
    height:100%;
    width:35%;
    border-radius:20px;
    background:linear-gradient(90deg,#1674D5,#8DCE1F);
}

.register-btn{
    width:100%;
    border:none;
    padding:18px;
    border-radius:50px;
    background:linear-gradient(90deg,#1674D5,#8DCE1F);
    color:#fff;
    font-size:17px;
    font-weight:600;
    cursor:pointer;
    transition:.3s;
}

.register-btn:hover{
    transform:translateY(-3px);
    box-shadow:0 15px 35px rgba(22,116,213,.3);
}

.secure-note{
    margin-top:20px;
    text-align:center;
    color:#777;
    font-size:14px;
}


@media(max-width:768px){

.row{
    flex-direction:column;
}

}
    </style>
    <main id="reg_body">
        <section class="reg_log">
                
            <div class="login_page" id="reg_form">
                <h1>
                    <a href="index.php">
                        <img src="images/logo.png" alt="logo">
                    </a>
                </h1>
                
                <h2>Welcome Shopper!</h2>
                <!-- <p>Register an Account to start shopping</p> -->
                <?php 
                    if(isset($_SESSION['success'])){
                        echo "<p class='success'>" . $_SESSION['success']. "</p>";
                        unset($_SESSION['success']);
                    }
                ?>
                <?php
                    if(isset($_SESSION['error'])){
                        echo "<p class='error'>" . $_SESSION['error']. "</p>";
                        unset($_SESSION['error']);
                    }
                ?>
                <form action="controller/register.php" method="POST" id="exh_register" class="modern-form">

    <h2>Create Your Account</h2>

    <p class="subtitle">
        Join Rivicos and start shopping thousands of supermarket and pharmacy products.
    </p>

    <!-- First & Last Name -->
    <div class="row">

        <div class="form-group">
            <label>First Name</label>
            <div class="input-box">
                <i class="fas fa-user"></i>
                <input
                    type="text"
                    name="first_name"
                    placeholder="John"
                    required
                    value="<?php if(isset($_SESSION['first_name'])){ echo $_SESSION['first_name']; unset($_SESSION['first_name']); }?>"
                >
            </div>
        </div>

        <div class="form-group">
            <label>Last Name</label>
            <div class="input-box">
                <i class="fas fa-user"></i>
                <input
                    type="text"
                    name="last_name"
                    placeholder="Doe"
                    required
                    value="<?php if(isset($_SESSION['last_name'])){ echo $_SESSION['last_name']; unset($_SESSION['last_name']); }?>"
                >
            </div>
        </div>

    </div>

    <!-- Email & Phone -->

    <div class="row">

        <div class="form-group">
            <label>Email Address</label>
            <div class="input-box">
                <i class="fas fa-envelope"></i>

                <input
                    type="email"
                    name="email"
                    placeholder="you@example.com"
                    required
                    value="<?php if(isset($_SESSION['user_email'])){ echo $_SESSION['user_email']; unset($_SESSION['user_email']); }?>"
                >

            </div>
        </div>

        <div class="form-group">
            <label>Phone Number</label>

            <div class="input-box">

                <i class="fas fa-phone"></i>

                <input
                    type="tel"
                    name="phone_number"
                    placeholder="08012345678"
                    onchange="checkNumber(this.value)"
                    required
                    value="<?php if(isset($_SESSION['phone_number'])){ echo $_SESSION['phone_number']; unset($_SESSION['phone_number']); }?>"
                >

            </div>

            <?php
            if(isset($_SESSION['phoneError'])){
                echo "<small class='field-error'>".$_SESSION['phoneError']."</small>";
                unset($_SESSION['phoneError']);
            }
            ?>

        </div>

    </div>

    <!-- State -->

    <div class="form-group">

    <label>State</label>

    <div class="input-box">

        <i class="fas fa-map-marker-alt"></i>

        <select name="city" id="city" required>

            <option value="" selected disabled>Select Your State</option>

            <!-- North Central -->
            <optgroup label="North Central">
                <option value="Benue">Benue</option>
                <option value="Kogi">Kogi</option>
                <option value="Kwara">Kwara</option>
                <option value="Nasarawa">Nasarawa</option>
                <option value="Niger">Niger</option>
                <option value="Plateau">Plateau</option>
                <option value="Federal Capital Territory">Federal Capital Territory (FCT)</option>
            </optgroup>

            <!-- North East -->
            <optgroup label="North East">
                <option value="Adamawa">Adamawa</option>
                <option value="Bauchi">Bauchi</option>
                <option value="Borno">Borno</option>
                <option value="Gombe">Gombe</option>
                <option value="Taraba">Taraba</option>
                <option value="Yobe">Yobe</option>
            </optgroup>

            <!-- North West -->
            <optgroup label="North West">
                <option value="Jigawa">Jigawa</option>
                <option value="Kaduna">Kaduna</option>
                <option value="Kano">Kano</option>
                <option value="Katsina">Katsina</option>
                <option value="Kebbi">Kebbi</option>
                <option value="Sokoto">Sokoto</option>
                <option value="Zamfara">Zamfara</option>
            </optgroup>

            <!-- South East -->
            <optgroup label="South East">
                <option value="Abia">Abia</option>
                <option value="Anambra">Anambra</option>
                <option value="Ebonyi">Ebonyi</option>
                <option value="Enugu">Enugu</option>
                <option value="Imo">Imo</option>
            </optgroup>

            <!-- South South -->
            <optgroup label="South South">
                <option value="Akwa Ibom">Akwa Ibom</option>
                <option value="Bayelsa">Bayelsa</option>
                <option value="Cross River">Cross River</option>
                <option value="Delta">Delta</option>
                <option value="Edo">Edo</option>
                <option value="Rivers">Rivers</option>
            </optgroup>

            <!-- South West -->
            <optgroup label="South West">
                <option value="Ekiti">Ekiti</option>
                <option value="Lagos">Lagos</option>
                <option value="Ogun">Ogun</option>
                <option value="Ondo">Ondo</option>
                <option value="Osun">Osun</option>
                <option value="Oyo">Oyo</option>
            </optgroup>

        </select>

    </div>

</div>

    <!-- Address -->

    <div class="form-group">

        <label>Delivery Address</label>

        <div class="input-box">

            <i class="fas fa-home"></i>

            <input
                type="text"
                name="address"
                placeholder="Enter your address"
                required
                value="<?php if(isset($_SESSION['address'])){ echo $_SESSION['address']; unset($_SESSION['address']); }?>"
            >

        </div>

    </div>

    <!-- Password -->

    <div class="row">

        <div class="form-group">

            <label>Password</label>

            <div class="input-box">

                <i class="fas fa-lock"></i>

                <input
                    type="password"
                    name="user_password"
                    id="user_password"
                    placeholder="Create Password"
                    required
                >

                <span class="togglePassword" onclick="togglePassword()">
                    <i class="fas fa-eye"></i>
                </span>

            </div>

            <?php
            if(isset($_SESSION['passwordError'])){
                echo "<small class='field-error'>".$_SESSION['passwordError']."</small>";
                unset($_SESSION['passwordError']);
            }
            ?>

        </div>

        <div class="form-group">

            <label>Confirm Password</label>

            <div class="input-box">

                <i class="fas fa-lock"></i>

                <input
                    type="password"
                    name="confirm_password"
                    placeholder="Confirm Password"
                    required
                >

            </div>

            <?php
            if(isset($_SESSION['confirmPwErr'])){
                echo "<small class='field-error'>".$_SESSION['confirmPwErr']."</small>";
                unset($_SESSION['confirmPwErr']);
            }
            ?>

        </div>

    </div>

    <div class="password-strength">

        <span>Password Strength</span>

        <div class="strength-bar">
            <span id="strength-fill"></span>
        </div>
        <small id="strength-text">Weak Password</small>
    </div>

    <button type="submit" name="submit_reg" class="register-btn">

        <i class="fas fa-user-plus"></i>

        Create My Account

    </button>

    <div class="secure-note">

        <i class="fas fa-shield-alt"></i>

        Your information is securely encrypted.

    </div>

</form>
                <div class="signup_option">
                    <p>Already have an account? <a href="login_page.php">Login now</a></p>
                </div>
                <div id="foot">
                    <p>&copy;<?php echo Date("Y");?> Rivicos. All Rights Reserved.</p>

                </div>

            </div>
            <div class="adds" id="reg_adds">
                <img src="images/online_shop2.jpg" alt="login banner">
                
            </div>
        </section>
    </main>
   
    <script src="controller/jquery.js"></script>
    <script src="controller/script.js"></script>
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
        document.querySelector(".modern-form").addEventListener("submit",function(){
            var password = document.getElementById("user_password").value;
            var confirmPassword = document.querySelector("input[name='confirm_password']").value;
            if(password !== confirmPassword){
                alert("Passwords do not match!");
                return false; // Prevent form submission
            }
        });
    </script>
</body>
</html>
<?php }?>