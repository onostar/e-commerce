<?php
    include "../controller/connections.php";
?>
<div id="Pending_orders">
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
            <button type="submit" name="search_date" id="search_date" onclick="search('search_revenue.php')">Search <i class="fas fa-search"></i></button>
        </section>
    </div>

    <div class="info" style="width:80%; margin:0!important"></div>
    <div class="displays allResults new_data" style="width:80%;">
        <h2>Revenue report for today</h2>
        <hr>
        <div class="search">
            <input type="search" placeholder="Enter keyword" onkeyup="searchData(this.value)">
            <a class="download_excel" href="javascript:void(0)" onclick="convertToExcel('revenueTable', 'Revenue report')"title="Download to excel"><i class="fas fa-file-excel"></i></a>
        </div>
        <table id="drevenueTable" class="searchTable">
            <thead>
                <tr style="background:var(--newColor)">
                <td>S/N</td>
                <td>Order No.</td>
                <td>Customer</td>
                <td>Item</td>
                <td>Qty</td>
                <td>Price</td>
                <td>Amount</td>
                <td>Time</td>
                <td>Status</td>
                </tr>
            </thead>

            <tbody>
            <?php
                $n = 1;
                $select_order = $connectdb->prepare("SELECT shoppers.first_name, shoppers.last_name, shoppers.phone_number, orders.order_id, orders.customer, orders.item_id, orders.order_number, orders.order_date, orders.order_status, orders.quantity, orders.item_price, orders.quantity, menu.item_name FROM shoppers, orders, menu WHERE shoppers.user_id = orders.customer AND orders.item_id = menu.item_id AND orders.order_status != -1 AND date(orders.order_date) = CURDATE()ORDER BY orders.order_date DESC");
                $select_order->execute();
                $rows = $select_order->fetchAll();
                if(gettype($rows) == 'array'){
                foreach($rows as $row):
            ?>
                <tr>
                    <td style="text-align:center; color:red"><?php echo $n?></td>
                    <td><a  style="color:var(--otherColor)" href="javascript:void" onclick="showPage('ordered_items.php?order=<?php echo $row->order_number?>')"title="view details"><?php echo $row->order_number?></a></td>
                    <td><?php echo $row->first_name. " ". $row->last_name?></td>
                    <td>
                        <?php
                           echo $row->item_name;
                        ?>
                    </td>
                    <td style="text-align:center; color:green"><?php echo $row->quantity?></td>
                    <td style="color:red">
                        <?php echo "₦". number_format($row->item_price, 2);?>
                    </td>
                    <td style="color:var(--tertiaryColor)">
                        <?php echo "₦". number_format($row->quantity * $row->item_price, 2);?>
                    </td>
                    <td><?php echo date("h:ia", strtotime($row->order_date))?></td>
                    <td>
                        <?php
                            if($row->order_status == 0){
                        ?>
                        <p style="color:var(--primaryColor);"><i class="fas fa-spinner"></i> Processing</p>
                        <?php }elseif($row->order_status == 1){?>
                        <p style="color:var(--newColor);"><i class="fas fa-truck"></i> Shipped</p>
                        <?php }else{?>
                        <p style="color:green;"><i class="fas fa-check-square"></i> Delivered</p>
                        <?php }?>
                    </td>
                </tr>
            <?php $n++; endforeach; }?>

            </tbody>

        </table>
        <?php
        if($select_order->rowCount() > 0){
        // get sum
        $get_total = $connectdb->prepare("SELECT SUM(item_price * quantity) AS total FROM orders WHERE date(order_date) = CURDATE()");
        $get_total->execute();
        $amounts = $get_total->fetchAll();
        
        if(gettype($amounts) == "array"){
            
            foreach($amounts as $amount){
                $paid_amount = $amount->total;
                
            }
            echo "<p class='sum_amount' style='text-decoration:underline; color:green; text-align:center;font-size:1.2rem;'><strong>Total</strong>: ₦".number_format($paid_amount, 2)."</p>";
        }
    }
    ?>
        <?php
            if(!$select_order->rowCount() > 0){
                echo "<p class='no_result'>No record found</p>";
            }
        ?>
        
    </div>
    
</div>