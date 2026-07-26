<?php
    include "../controller/connections.php";
?>
<div id="edit_item_price">
<?php
    
    if(isset($_SESSION['success'])){
        echo $_SESSION['success'];
    }

?>

    <div class="info" style="width:80%; margin:0!important"></div>
    <div class="displays allResults" style="width:80%;">
        <h2>Manage Item prices</h2>
        <hr>
        <div class="search">
            <input type="search" id="searchGuestPayment" placeholder="Enter keyword" onkeyup="searchData(this.value)">
            <a class="download_excel" href="javascript:void(0)" onclick="convertToExcel('priceTable', 'Item Price list')"title="Download to excel"><i class="fas fa-file-excel"></i></a>
        </div>
        <table id="priceTable" class="searchTable">
            <thead>
                <tr style="background:var(--newColor)">
                    <td>S/N</td>
                    <td>Category</td>
                    <td>item</td>
                    <td>Retail price (₦)</td>
                    <td></td>
                </tr>
            </thead>

            <tbody>
            <?php
                $n = 1;
                $select_item = $connectdb->prepare("SELECT * FROM menu ORDER BY item_name");
                $select_item->execute();
                $rows = $select_item->fetchAll();
                if(gettype($rows) == "array"){
                foreach($rows as $row):
            ?>
                <tr>
                    <td style="text-align:center;"><?php echo $n?></td>
                    
                    <td>
                        <?php 
                             //get category
                             $get_cat = $connectdb->prepare("SELECT category FROM categories WHERE category_id = :category_id");
                             $get_cat->bindValue("category_id", $row->item_category);
                             $get_cat->execute();
                             $detail = $get_cat->fetch();
                             echo $detail->category;
                        ?>
                    </td>
                    <td><?php echo $row->item_name?></td>
                    <td>
                        <?php echo number_format($row->item_prize);?>
                    </td>
                    <td class="prices" style="margin:5px auto">
                        <a style="background:var(--moreColor)!important; color:#fff!important; padding:5px 8px; border-radius:5px" href="javascript:void(0)" title="modify price" data-form="check<?php echo $row->item_id?>" class="each_prices" onclick="getForm('<?php echo $row->item_id?>', 'get_item_details.php');"><i class="fas fa-pen"></i></a>
                    </td>
                </tr>
            <?php $n++; endforeach; }?>

            </tbody>

        </table>
        
        <?php
            if(gettype($rows) == "string"){
                echo "<p class='no_result'>'$rows'</p>";
            }
        ?>
    </div>
</div>