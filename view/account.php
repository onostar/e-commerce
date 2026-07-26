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
        $title = $full_name. " - Profile";
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
    <section id="account">
            
            <hr>
            <p class="successful">
                <?php
                    if(isset($_SESSION['success'])){
                        echo $_SESSION['success'];
                        unset($_SESSION['success']);
                    }
                ?>
                <?php
                    if(isset($_SESSION['error'])){
                        echo $_SESSION['error'];
                        unset($_SESSION['error']);
                    }
                ?>
            </p>
            <div class="profile_details">
                <div class="userss" id="user_details">
                <h3>Account Details</h3>
                    <?php 
                        $show_details = $connectdb->prepare("SELECT * FROM shoppers WHERE email = :email");
                        $show_details->bindvalue('email', $user);
                        $show_details->execute();

                        $views = $show_details->fetchAll();
                        foreach($views as $view):
                    ?>
                    <h4><?php echo $view->first_name . " " . $view->last_name; ?></h4>
                    <p><?php echo $view->email;?></p>
                    <?php endforeach;?>
                </div>
                <div class="userss" id="user_address">
                    <h3>Address Book</h3>
                    <div class="add">
                        <div class="address" id="myAddress">
                            <h4>Your delivery address:</h4>
                            <?php 
                                $show_details = $connectdb->prepare("SELECT * FROM shoppers WHERE email = :email");
                                $show_details->bindvalue('email', $user);
                                $show_details->execute();

                                $views = $show_details->fetchAll();
                                foreach($views as $view):
                            ?>
                            <p><?php echo $view->address;?>,</p>
                            <p style="text-transform:uppercase;"><?php echo $view->city;?></p>
                            <p><?php echo $view->phone_number;?></p>
                           
                            <?php endforeach;?>
                        </div>
                        <div id="edit">
                            <a href="javascript:void(0);" title="Edit details" id="editDetails"><i class="fas fa-pen"></i></a>
                        </div>
                    </div>
                    
                </div>
                <div class="userss" id="change_password">
                    <a href="javascript:void(0);" title="Change your password" id="changePasword">Change password <i class="fas fa-key"></i></a>
                </div>
            </div>
            <div class="update_details" id="update">
                <?php
                    $user_details = $connectdb->prepare("SELECT * FROM shoppers WHERE email = :email");
                    $user_details->bindvalue('email', $user);
                    $user_details->execute();

                    $details = $user_details->fetchAll();
                    foreach($details as $detail):
                ?>
                <a href="javascript:void(0)" title="close section" id="close_update"><i class="fas fa-window-close"></i></a>
                <form action="../controller/update_profile.php" method="POST">
                    <div class="update">
                        <input type="hidden" name="email" value="<?php $get_user = $connectdb->prepare("SELECT * FROM shoppers WHERE email = :email");
                        $get_user->bindvalue('email', $user);
                        $get_user->execute();
                        $gets = $get_user->fetchAll();
                        foreach($gets as $get){
                            echo $get->email;
                        }
                        ?>">
                        <div class="update_data">
                            <label for="firstName">First Name</label><br>
                            <input type="text" name="firstName" id="firstName" value="<?php echo $detail->first_name;?>">
                        </div>
                        <div class="update_data">
                            <label for="lastName">Last Name</label><br>
                            <input type="text" name="lastName" id="lastName" value="<?php echo $detail->last_name;?>">
                        </div>
                    </div>
                    <div class="update">
                        <div class="update_data">
                            <label for="phone">Phone Number</label><br>
                            <input type="tel" name="phone" id="phone" value="<?php echo $detail->phone_number;?>">
                        </div>
                       <!--  <div class="update_data">
                            <label for="pharmacy">Pharmacy</label><br>
                            <input type="text" name="pharmacy" id="pharmacy" value="<?php echo $detail->pharmacy;?>">
                            
                        </div> -->
                        <div class="update_data">
                            <label for="address">Address</label><br>
                            <input type="text" name="address" id="address" value="<?php echo $detail->address;?>">
                        </div>
                    </div>
                    <div class="update">
                        
                        <div class="update_data">
                            <label for="city">State</label><br>
                            <select name="city" id="city">
                                <option selected value="<?php echo $detail->city;?>"><?php echo $detail->city;?></option>
                                <option value="" selected>Select state</option>
                                <option value="Abia">Abia</option>
                                <option value="Adamawa">Adamawa</option>
                                <option value="Akwa-ibom">Akwa-ibom</option>
                                <option value="Anambra">Anambra</option>
                                <option value="Bauchi">Bauchi</option>
                                <option value="Bayelsa">Bayelsa</option>
                                <option value="Benue">Benue</option>
                                <option value="Borno">Borno</option>
                                <option value="Cross rivers">Cross rivers</option>
                                <option value="Delta">Delta</option>
                                <option value="Ebonyi">Ebonyi</option>
                                <option value="Edo">Edo</option>
                                <option value="Ekiti">Ekiti</option>
                                <option value="Enugu">Enugu</option>
                                <option value="Gombe">Gombe</option>
                                
                                <option value="Imo">Imo</option>
                                <option value="Jigawa">Jigawa</option>
                                <option value="Kaduna">Kaduna</option>
                                <option value="Kano">Kano</option>
                                <option value="Katsina">Katsina</option>
                                <option value="Kebbi">Kebbi</option>
                                <option value="Kogi">Kogi</option>
                                <option value="Kwarra">Kwarra</option>
                                <option value="Lagos">Lagos</option>
                                <option value="Nassarawa">Nassarawa</option>
                                <option value="Niger">Niger</option>
                                <option value="Ogun">Ogun</option>
                                <option value="Ondo">Ondo</option>
                                <option value="Osun">Osun</option>
                                <option value="Oyo">Oyo</option>
                                <option value="Plateau">Plateau</option>
                                <option value="Rivers">Rivers</option>
                                <option value="Sokoto">Sokoto</option>
                                <option value="Taraba">Taraba</option>
                                <option value="Yobe">Yobe</option>
                                <option value="Zamfara">Zamfara</option>
                                <option value="FCT">FCT</option>
                            </select>
                        </div>
                    </div>
                    <button type="submit" id="update_profile" name="update_profile">Update Details</button>
                </form>
                <?php endforeach;?>
            </div>
            <!-- change password -->
            <div class="change_password">
                
                <form action="../controller/change_password.php" method="POST">
                    <h3>Change your password</h3>
                    <input type="hidden" name="email" value="<?php $get_user = $connectdb->prepare("SELECT * FROM shoppers WHERE email = :email");
                    $get_user->bindvalue('email', $user);
                    $get_user->execute();
                    $gets = $get_user->fetchAll();
                    foreach($gets as $get){
                        echo $get->email;
                    }
                    ?>">
                    <label for="currPwd">Current password</label><br>
                    <input type="password" name="current_password" id="current_password" required><br>
                    <label for="newPwd">New Password</label><br>
                    <input type="password" name="new_password" id="new_password" required><br>
                    <label for="rePwd">Retype Password</label><br>
                    <input type="password" name="retype_password" id="retype_password" required><br>
                    <button type="submit" name="change_password" id="change_password">Change Password</button>
                </form>
            </div>
        </section>
        
        
    </main>
    <footer>
        <?php include "footer.php";?>
    </footer>
    
    
    
    <script src="../controller/jquery.js"></script>
    <script src="../controller/script.js"></script>
    
</body>
</html>

<?php
    }else{
        header("Location: ../index.php");
    }
?> 