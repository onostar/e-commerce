<?php
    include "../controller/connections.php";
    $from = htmlspecialchars(stripslashes($_POST['from_date']));
    $to = htmlspecialchars(stripslashes($_POST['to_date']));


    $select_order = $connectdb->prepare("SELECT item_id, item_price, delivery_date, SUM(quantity) AS total_quantity, SUM(quantity * item_price) AS total_amount FROM orders WHERE dispense_date BETWEEN '$from' AND '$to' GROUP BY item_id ORDER BY total_quantity DESC");
    $select_order->execute();
    $rows = $select_order->fetchAll();
    $n = 1;
?>
<h2>Top selling items Between '<?php echo date("jS M, Y", strtotime($from)) . "' and '" . date("jS M, Y", strtotime($to))?>'</h2>
    <hr>
    <div class="search">
            <input type="search" placeholder="Enter keyword" onkeyup="searchData(this.value)">
            <a class="download_excel" href="javascript:void(0)" onclick="convertToExcel('cancelledTable', 'Most ordered items')"title="Download to excel"><i class="fas fa-file-excel"></i></a>
        </div>
        <table id="cancelledable" class="searchTable">
            <thead>
                <tr style="background:var(--newColor)">
                <td>S/N</td>
                <td>item</td>
                <td>Qty</td>
                <td>Total Amount</td>
                </tr>
            </thead>
        <tbody>
<?php
    if(gettype($rows) === 'array'){
    foreach($rows as $row){

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
            <?php $n++; }}?>
        </tbody>
    </table>
<?php
    
    if(gettype($rows) == 'string'){
        echo "<p class='no_result'>'No record found'</p>";
    }
?>
