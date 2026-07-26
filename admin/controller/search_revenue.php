<?php
    include "../controller/connections.php";
    $from = htmlspecialchars(stripslashes($_POST['from_date']));
    $to = htmlspecialchars(stripslashes($_POST['to_date']));


    $select_order = $connectdb->prepare("SELECT shoppers.first_name, shoppers.last_name, shoppers.phone_number, orders.order_id, orders.customer, orders.item_id, orders.order_number, orders.order_date, orders.order_status, orders.quantity, orders.item_price, orders.quantity, menu.item_name FROM shoppers, orders, menu WHERE shoppers.user_id = orders.customer AND orders.item_id = menu.item_id AND orders.order_status != 0 AND orders.order_status != -1 AND date(orders.dispense_date) BETWEEN '$from' AND '$to' ORDER BY orders.dispense_date DESC");
    $select_order->execute();
    $rows = $select_order->fetchAll();
    $n = 1;
?>
<h2>Revenue Report between '<?php echo date("jS M, Y", strtotime($from)) . "' and '" . date("jS M, Y", strtotime($to))?>'</h2>
    <hr>
    <div class="search">
            <input type="search" placeholder="Enter keyword" onkeyup="searchData(this.value)">
            <a class="download_excel" href="javascript:void(0)" onclick="convertToExcel('revenueTable', 'Revenue report')"title="Download to excel"><i class="fas fa-file-excel"></i></a>
        </div>
        <table id="revenueTable" class="searchTable">
            <thead>
                <tr style="background:var(--newColor)">
                <td>S/N</td>
                <td>Order No.</td>
                <td>Customer</td>
                <td>Item</td>
                <td>Qty</td>
                <td>Price</td>
                <td>Amount</td>
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
                    <td><?php echo date("d-m-Y", strtotime($row->order_date))?></td>
                    <td><?php echo date("h:ia", strtotime($row->order_date))?></td>
                </tr>
            <?php $n++; }}?>
        </tbody>
    </table>
<?php
    
    if(gettype($rows) == 'string'){
        echo "<p class='no_result'>'No record found'</p>";
    };
    if($select_order->rowCount() > 0){
        // get sum
        $get_total = $connectdb->prepare("SELECT SUM(item_price * quantity) AS total FROM orders WHERE date(dispense_date)BETWEEN '$from' AND '$to'");
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
