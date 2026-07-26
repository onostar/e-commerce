<?php
    include "connections.php";
    session_start();


    $plan = ucwords(htmlspecialchars(stripslashes($_POST['plan'])));
    
    /* check if  plan exsits */
    $check_booth = $connectdb->prepare("SELECT * FROM plans WHERE plan = :plan");
    $check_booth->bindvalue("plan", $plan);
    $check_booth->execute();
    if($check_booth->rowCount() > 0){
        echo "<p class='exist'><span>".$plan."</span> already exists!</p>";
    }else{
        $add_booth = $connectdb->prepare("INSERT INTO  plans (plan) VALUES (:plan)");
        $add_booth->bindvalue("plan", $plan);
        $add_booth->execute();
        if($add_booth){
            echo "<p><span>".$plan."</span> added Successfully!</p>";
        }else{
            echo "failed to add booth";
        }
    }
?>