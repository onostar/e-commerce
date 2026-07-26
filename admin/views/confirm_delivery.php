<?php
    include "../controller/connections.php";
?>
<div id="deliveries">
<?php
    
    if(isset($_SESSION['success'])){
        echo $_SESSION['success'];
    }

?>

    <div class="info" style="width:80%; margin:0!important"></div>
    <div class="displays allResults" style="width:80%;">
        <h2>Confirm outgoing deliveries</h2>
        <hr>
        <div class="search">
            <input type="search" placeholder="Enter keyword" onkeyup="searchData(this.value)">
            <a class="download_excel" href="javascript:void(0)" onclick="convertToExcel('deliveryTable', 'Outgoing deliveries')"title="Download to excel"><i class="fas fa-file-excel"></i></a>
        </div>
        <table id="deliveryTable" class="searchTable">
            <thead>
                <tr style="background:var(--tertiaryColor)">
                <td>S/N</td>
                <td>Order No.</td>
                <td>Customer</td>
                <td>Phone No.</td>
                <td>item</td>
                <td>Qty</td>
                <td></td>
                </tr>
            </thead>

            <tbody>
            <?php
                $n = 1;
                $select_order = $connectdb->prepare("SELECT shoppers.first_name, shoppers.last_name, shoppers.phone_number, orders.order_id, orders.customer, orders.item_id, orders.order_number, orders.order_date, orders.order_status, orders.quantity, menu.item_name FROM shoppers, orders, menu WHERE shoppers.user_id = orders.customer AND orders.item_id = menu.item_id AND orders.order_status = 1 ORDER BY orders.dispense_date DESC");
                $select_order->execute();
                $rows = $select_order->fetchAll();
                if(gettype($rows) == 'array'){
                foreach($rows as $row):
            ?>
                <tr>
                    <td style="text-align:center; color:red"><?php echo $n?></td>
                    <td><a  style="color:var(--otherColor)" href="javascript:void" title="view details"><?php echo $row->order_number?></a></td>
                    <td><?php echo $row->first_name. " ". $row->last_name?></td>
                    <td><?php echo "<a href='https://wa.me/+234".$row->phone_number."' title='Chat on whatsapp' target='_blank'>$row->phone_number</a>"?></td>
                    <td>
                        <?php
                            echo $row->item_name;
                        ?>
                    </td>
                    <td style="text-align:center; color:green"><?php echo $row->quantity?></td>
                    <td>
                        <a style="background:green; color:#fff; padding:5px 8px; border-radius:5px;font-size:.7rem" href="javascript:void(0)" title="View order details" onclick="confirmDelivery('<?php echo $row->order_id?>')"><i class="fas fa-check-square"></i></a>
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