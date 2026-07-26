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
            <button type="submit" name="search_date" id="search_date" onclick="search('search_delivery.php')">Search <i class="fas fa-search"></i></button>
        </section>
    </div>

    <div class="info" style="width:80%; margin:0!important"></div>
    <div class="displays allResults new_data" style="width:80%;">
        <h2>Delivery report for today</h2>
        <hr>
        <div class="search">
            <input type="search" placeholder="Enter keyword" onkeyup="searchData(this.value)">
            <a class="download_excel" href="javascript:void(0)" onclick="convertToExcel('deliveryTable', 'Delivery report')"title="Download to excel"><i class="fas fa-file-excel"></i></a>
        </div>
        <table id="deliveryTable" class="searchTable">
            <thead>
                <tr style="background:var(--newColor)">
                <td>S/N</td>
                <td>Order No.</td>
                <td>Customer</td>
                <td>Address</td>
                <td>Total items</td>
                <td>Total Amount</td>
                <td>Time</td>
                <!-- <td></td> -->
                </tr>
            </thead>

            <tbody>
            <?php
                $n = 1;
                $select_order = $connectdb->prepare("SELECT shoppers.first_name, shoppers.last_name, shoppers.phone_number, orders.order_id, orders.customer, orders.item_id, orders.order_number, orders.order_date, orders.order_status, orders.delivery_address, SUM(orders.item_price * orders.quantity) AS amount FROM shoppers, orders WHERE shoppers.user_id = orders.customer AND orders.order_status = 2 AND orders.delivery_date = CURDATE() GROUP BY orders.order_number ORDER BY orders.order_date DESC");
                $select_order->execute();
                $rows = $select_order->fetchAll();
                if(gettype($rows) == 'array'){
                foreach($rows as $row):
            ?>
                <tr>
                    <td style="text-align:center; color:red"><?php echo $n?></td>
                    <td><a  style="color:var(--otherColor)" href="javascript:void" onclick="showPage('ordered_items.php?order=<?php echo $row->order_number?>')"title="view details"><?php echo $row->order_number?></a></td>
                    <td><?php echo $row->first_name. " ". $row->last_name?></td>
                    <td><?php echo $row->delivery_address?></td>
                    <td style="text-align:center; color:green">
                        <?php
                            $get_items = $connectdb->prepare("SELECT item_id FROM orders WHERE order_number = :order_number AND order_status = 2");
                            $get_items->bindValue("order_number", $row->order_number);
                            $get_items->execute();
                            echo $get_items->rowCount();
                        ?>
                    </td>
                    <td style="color:var(--tertiaryColor)">
                        <?php echo "₦". number_format($row->amount, 2);?>
                    </td>
                    <td><?php echo date("h:ia", strtotime($row->order_date))?></td>
                    
                    <!-- <td>
                        <a style="background:var(--tertiaryColor); color:#fff; padding:3px; border-radius:10px;font-size:.7rem" href="javascript:void(0)" title="View order details" onclick="showPage('ordered_items.php?order=<?php echo $row->order_number?>')">View <i class="fas fa-eye"></i></a>
                    </td> -->
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