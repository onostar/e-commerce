<?php
    include "../controller/connections.php";
?>
<div id="highest_selling">
<?php
    
    if(isset($_SESSION['success'])){
        echo $_SESSION['success'];
    }

?>
    <div class="select_date">
        <!-- <form method="POST"> -->
        <section>    
            <div class="from_to_date">
                <label>Select From Date</label><br>
                <input type="date" name="from_date" id="from_date"><br>
            </div>
            <div class="from_to_date">
                <label>Select to Date</label><br>
                <input type="date" name="to_date" id="to_date"><br>
            </div>
            <button type="submit" name="search_date" id="search_date" onclick="search('search_highest.php')">Search <i class="fas fa-search"></i></button>
        </section>
    </div>

    <div class="info" style="width:80%; margin:0!important"></div>
    <div class="displays allResults new_data" style="width:80%;">
        <h2>Today's Top selling items</h2>
        <hr>
        <div class="search">
            <input type="search" placeholder="Enter keyword" onkeyup="searchData(this.value)">
            <a class="download_excel" href="javascript:void(0)" onclick="convertToExcel('cancelledTable', 'Most ordered items')"title="Download to excel"><i class="fas fa-file-excel"></i></a>
        </div>
        <table id="cancelledTable" class="searchTable">
            <thead>
                <tr style="background:var(--tertiaryColor)">
                    <td>S/N</td>
                    <td>item</td>
                    <td>Qty</td>
                    <td>Total Amount</td>
                </tr>
            </thead>

            <tbody>
            <?php
                $n = 1;
                $select_order = $connectdb->prepare("SELECT item_id, item_price, delivery_date, SUM(quantity) AS total_quantity, SUM(quantity * item_price) AS total_amount FROM orders WHERE dispense_date = CURDATE() GROUP BY item_id ORDER BY total_quantity DESC");
                $select_order->execute();
                $rows = $select_order->fetchAll();
                if(gettype($rows) == 'array'){
                foreach($rows as $row):
            ?>
                <tr>
                    <td style="text-align:center; color:red"><?php echo $n?></td>
                    <td>
                        <?php
                            //get item name
                            $get_name = $connectdb->prepare('SELECT item_name FROM menu WHERE item_id = :item_id');
                            $get_name->bindValue("item_id", $row->item_id);
                            $get_name->execute();
                            $name = $get_name->fetch();
                            echo $name->item_name;
                        ?>
                    </td>
                    <td style="color:green; text-align:center"><?php echo $row->total_quantity?></td>
                    <td style="color:var(--tertiaryColor)">
                        <?php echo "₦". number_format($row->total_amount, 2);?>
                    </td>
                    
                </tr>
            <?php $n++; endforeach; }?>

            </tbody>

        </table>
        
        <?php
            if(!$select_order->rowCount() > 0){
                echo "<p class='no_result'>No record found</p>";
            }
        ?>
    </div>
</div>