<?php
    include "connections.php";
 

    if(isset($_POST['featuredRestaurant']) && !empty($_POST['featuredRestaurant'])){
        $restaurant = $_POST['featuredRestaurant'];
        $select_item = $connectdb->prepare("SELECT item_name FROM menu WHERE company = :company ORDER BY item_name");
        $select_item->bindvalue('company', $restaurant);
        $select_item->execute();
        $rows = $select_item->fetchAll();
        foreach($rows as $row):
       

?>
        <option value="<?php echo $row->item_name?>"><?php echo $row->item_name?></option>

        <?php endforeach;?>
        <?php     
            }else{
                echo "<option>Select item</option>";
            }
        ?>