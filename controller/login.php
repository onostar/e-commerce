<?php
    session_start();
    require "server.php";

    function validate($field){
        if(!isset($_POST[$field])){
            return false;
        }else{
            return htmlspecialchars(stripslashes($_POST[$field]));
        }
    }
    if(isset($_POST['submit_login'])){
        $email = strtolower(validate('email'));
        $password = validate('user_password');
        $_SESSION['email'] = $email;
        /* check validity of user */
        /* $check_user = $connectdb->prepare("SELECT * FROM shoppers WHERE email = :email AND user_password = :user_password");
        $check_user->bindvalue('email', $email);
        $check_user->bindvalue('user_password', $user_password);
        $check_user->execute();

        if($check_user->rowCount() > 0){
            $_SESSION['user'] = $email;
            header("Location: ".$_SESSION['current_page']);
        }else{
            $_SESSION['error'] = "Invalid Username or Password!";
            header("Location: ../login_page.php");
        } */

        //check if its an admin
        if($email == "admin@rivicos.com"){
            //admin login
            //new admin hashed password login
            $get_pwd = $connectdb->prepare("SELECT company_password FROM users WHERE company_email = :company_email");
            $get_pwd->bindValue("company_email", $email);
            $get_pwd->execute();

            if($get_pwd->rowCount() > 0){
                $user_password = $get_pwd->fetch();
                if($user_password->company_password == "123"){
                    $_SESSION['user'] = $email;
                    header("Location: ../admin/change_password.php");
                }else{
                    $hashedPwd = $user_password->company_password;
                    $check_pwd = password_verify($password, $hashedPwd);

                    if($check_pwd == false){
                        $_SESSION['error'] = "Error! Wrong Password!";
                        header("Location: ../login_page.php");
                    }else{
                        $get_user = $connectdb->prepare("SELECT * FROM users WHERE company_email = :company_email AND company_password = :company_password");
                        $get_user->bindValue("company_email", $email);
                        $get_user->bindValue("company_password", $hashedPwd);
                        $get_user->execute();

                        if($get_user->rowCount() > 0){
                            $_SESSION['user'] = $email;
                            header("Location: ../admin/views/user.php");

                        }else{
                            $_SESSION['error'] = "Error! Invalid username or password";
                            header("Location: ../login_page.php");
                        }
                    }
                }
            }else{
                $_SESSION['error'] = "Error! Invalid username or password";
                header("Location: ../login_page.php");
            }

        }else{
            //shoppers login
            //new login type for hashed password
            $get_pwd = $connectdb->prepare("SELECT user_password FROM shoppers WHERE email = :email");
            $get_pwd->bindValue("email", $email);
            $get_pwd->execute();

            if($get_pwd->rowCount() > 0){
                $user_password = $get_pwd->fetch();
                $hashedPwd = $user_password->user_password;
                $check_pwd = password_verify($password, $hashedPwd);

                if($check_pwd == false){
                    $_SESSION['error'] = "Error! Wrong Password!";
                    header("Location: ../login_page.php");
                }else{
                    $get_user = $connectdb->prepare("SELECT * FROM shoppers WHERE email = :email AND user_password = :user_password");
                    $get_user->bindValue("email", $email);
                    $get_user->bindValue("user_password", $hashedPwd);
                    $get_user->execute();

                    if($get_user->rowCount() > 0){
                        $_SESSION['user'] = $email;
                        header("Location: ".$_SESSION['current_page']);

                    }else{
                        $_SESSION['error'] = "Error! Invalid username or password";
                        header("Location: ../login_page.php");
                    }
                }
                
            }else{
                $_SESSION['error'] = "Error! Invalid username or password";
                header("Location: ../login_page.php");
            }
        }
    }
        
        
    