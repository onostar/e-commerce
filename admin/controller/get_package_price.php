<?php
    include "connections.php";
    
    if(isset($_POST['package_id']) && !empty($_POST['package_id'])){
        $package = $_POST['package_id'];
        $plan = $_POST['store_plans'];
        $get_price = $connectdb->prepare("SELECT * FROM plan_package WHERE package_id = :package_id AND plan = :plan");
        $get_price->bindvalue("package_id", $package);
        $get_price->bindvalue("plan", $plan);
        $get_price->execute();
        
        $prices = $get_price->fetchAll();
        foreach($prices as $price):
    
?>
        <p id="prices">₦<?php echo number_format($price->package_price)?></p>
        <p id="url"><strong>Duration:</strong> <span style="color:red"><?php echo $price->duration . " days"?></span></p>
        
         <?php endforeach;?>

<?php }else{
    echo  "<p id='prices'>Select booth</p>";
}