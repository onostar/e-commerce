<?php
    include "connections.php";
    session_start();


    $package = ucwords(htmlspecialchars(stripslashes($_POST['package'])));
    $booth_price = htmlspecialchars(stripslashes($_POST['package_price']));
    $plan = htmlspecialchars(stripslashes($_POST['package_plan']));
    $duration = htmlspecialchars(stripslashes($_POST['package_duration']));
    $features = htmlspecialchars(stripslashes($_POST['features']));
    /* check if hotel exsits */
    $check_booth = $connectdb->prepare("SELECT * FROM plan_package WHERE plan = :plan AND package = :package");
    $check_booth->bindvalue("plan", $plan);
    $check_booth->bindvalue("package", $package);
    $check_booth->execute();
    if($check_booth->rowCount() > 0){
        echo "<p class='exist'><span>".$package." package </span> already exists for ".$plan." plan!</p>";
    }else{
        $add_booth = $connectdb->prepare("INSERT INTO plan_package (plan, package, package_price, duration, features) VALUES (:plan, :package, :package_price, :duration, :features)");
        $add_booth->bindvalue("plan", $plan);
        $add_booth->bindvalue("package_price", $booth_price);
        $add_booth->bindvalue("duration", $duration);
        $add_booth->bindvalue("package", $package);
        $add_booth->bindvalue("features", $features);
        $add_booth->execute();
        if($add_booth){
            echo "<p><span>".$package." package</span> added Successfully!</p>";
        }else{
            echo "failed to add package";
        }
    }
?>