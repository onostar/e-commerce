<?php
    include "../controller/connections.php";
    $from = htmlspecialchars(stripslashes($_POST['from_date']));
    $to = htmlspecialchars(stripslashes($_POST['to_date']));


    $select_order = $connectdb->prepare("SELECT shoppers.first_name, shoppers.last_name, shoppers.phone_number, orders.order_id, orders.customer, orders.item_id, orders.order_number, orders.order_date, orders.order_status, orders.delivery_address, SUM(orders.item_price * orders.quantity) AS amount FROM shoppers, orders WHERE shoppers.user_id = orders.customer AND orders.order_status = 2 AND date(orders.delivery_date) BETWEEN '$from' AND '$to' GROUP BY orders.order_number ORDER BY orders.order_date DESC");
    $select_order->execute();
    $rows = $select_order->fetchAll();
    $n = 1;
?>
<h2>Delivery Report between '<?php echo date("jS M, Y", strtotime($from)) . "' and '" . date("jS M, Y", strtotime($to))?>'</h2>
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
                <td>Date</td>
                <td>Time</td>
                <!-- <td></td> -->
                </tr>
            </thead>
        <tbody>
<?php
    if(gettype($rows) === 'array'){
    foreach($rows as $row){

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
                    <td><?php echo date("d-m-Y", strtotime($row->order_date))?></td>
                    <td><?php echo date("h:ia", strtotime($row->order_date))?></td>
                    
                    <!-- <td>
                        <a style="background:var(--tertiaryColor); color:#fff; padding:3px; border-radius:10px;font-size:.7rem" href="javascript:void(0)" title="View order details" onclick="showPage('ordered_items.php?order=<?php echo $row->order_number?>')">View <i class="fas fa-eye"></i></a>
                    </td> -->
                </tr>
            <?php $n++; }}?>
        </tbody>
    </table>
<?php
    
    if(gettype($rows) == 'string'){
        echo "<p class='no_result'>'No record found'</p>";
    }
?>
