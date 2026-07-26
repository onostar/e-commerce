<?php
    include "connections.php";

    if(isset($_POST['store_plans']) && !empty($_POST['store_plans'])){
        $plan = $_POST['store_plans'];
        $get_package = $connectdb->prepare("SELECT * FROM plan_package WHERE plan = :plan ORDER BY plan");
        $get_package->bindvalue("plan", $plan);
        $get_package->execute();
        
        $packages = $get_package->fetchAll();
        foreach($packages as $package):
    
?>      
        <option value="<?php echo $package->package_id;?>"><?php echo $package->package;?></option>
         <?php endforeach;?>

<?php }else{
    echo "<option>Select booth</option>";
}