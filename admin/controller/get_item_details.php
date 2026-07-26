<?php
    include "../controller/connections.php";
    if (isset($_GET['item_id'])){
        $id = $_GET['item_id'];
    

    $get_item = $connectdb->prepare("SELECT * FROM menu WHERE item_id = :item_id");
    $get_item->bindValue("item_id", $id);
    $get_item->execute();
    $rows = $get_item->fetchAll();
     if(gettype($rows) == 'array'){
        foreach($rows as $row):
            
        
    ?>
    <div class="add_user_form priceForm">
        <h3 style="background:var(--tertiaryColor)">Edit price for <?php echo strtoupper($row->item_name)?></h3>
        <section class="addUserForm" style="text-align:left;">
            <div class="inputs" style="flex-wrap:wrap; gap:.2rem; justify-content:left;">
                <!-- <div class="data item_head"> -->
                    <input type="hidden" name="item_id" id="item_id" value="<?php echo $row->item_id?>" required>
                <div class="data" style="width:30%">
                    <label for="sales_price">Selling price (NGN)</label>
                    <input type="text" name="sales_price" id="sales_price" value="<?php echo $row->item_prize?>">
                </div>
                <div class="data" style="width:auto">
                    <button type="submit" id="change_price" name="change_price" onclick="changeItemPrice()">Save <i class="fas fa-save"></i></button>
                    <a href="javascript:void(0)" title="close form" style='background:red; padding:10px; border-radius:5px; color:#fff' onclick="closeForm()">Return <i class='fas fa-angle-double-left'></i></a>
                </div>
                
            </div>
        </section>   
    </div>
    
<?php
    endforeach;
     }
    }    
?>