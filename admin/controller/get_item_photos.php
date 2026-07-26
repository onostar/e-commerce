<?php
    include "../controller/connections.php";
        $id = htmlspecialchars(stripslashes($_POST['item']));

    $get_item = $connectdb->prepare("SELECT * FROM menu WHERE item_name LIKE '%$id%' ORDER BY item_name LIMIT 30");
    // $get_item->bindValue("item_id", $id);
    $get_item->execute();
    if($get_item->rowCount() > 0){
        $rows = $get_item->fetchAll();
        foreach($rows as $row):
            
    ?>
    <div class="results">
        <a href="javascript:void(0)" onclick="showPage('update_foto_form.php?item=<?php echo $row->item_id?>')"> <?php echo $row->item_name." (Price => ₦".$row->item_prize.")"?></a>
    </div>
   <!--  <option onclick="showPage('update_foto_form.php?item=<?php echo $row->item_id?>')">
        <?php echo $row->item_name." (Price => ₦".$row->item_prize.")"?>
    </option> -->
    
<?php
    endforeach;
     }else{
        "No record found";
     } 
?>