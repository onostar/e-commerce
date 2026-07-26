<?php
    
    include "connections.php";
    session_start();

    if(isset($_SESSION['my_company'])){
        $my_company = $_SESSION['my_company'];
    }
    $from_date = $_POST['from_date'];
    $to_date = $_POST['to_date'];
    $n = 1;
    $select_deliveries = $connectdb->prepare("SELECT shoppers.first_name, shoppers.last_name, shoppers.email, shoppers.address, shoppers.city, orders.order_id, orders.customer_email, orders.item_name, orders.quantity, orders.item_price, orders.company, orders.order_date, orders.delivery_date FROM shoppers, orders WHERE orders.company = :company AND shoppers.email = orders.customer_email AND orders.order_status = 1 AND orders.delivery_date BETWEEN '$from_date' AND '$to_date' ORDER BY orders.delivery_date DESC");
    $select_deliveries->bindvalue('company', $my_company);
    $select_deliveries->execute();

    // $rows = $select_deliveries->fetchAll();
    // foreach($rows as $row):
?>

<?php echo "<h2>Delivery Register from '" . date("M jS, Y", strtotime($from_date)) . "' to '" . date("M jS, Y", strtotime($to_date)) ."'</h2>";?>
<hr>

<div class="search">
    <input type="search" id="searchDeliveries" placeholder="Enter keyword">
</div>
<table id="deliveriesTable">

    <thead>
        <tr>
            <td>S/N</td>
            <td>Customer</td>
            <td>item</td>
            <td>Qty</td>
            <td>Amount</td>
            <td>Address</td>
            <td>Date</td>
        </tr>
    </thead>

    <?php
        $n = 1;
        if($select_deliveries){
            $rows = $select_deliveries->fetchAll();
            foreach($rows as $row):
    ?>

<tbody>
    <tr>
        <td style="color:red; text-align:center"><?php echo $n?></td>
        <td><?php echo $row->first_name . " " . $row->last_name;?></td>
        <td><?php echo $row->item_name?></td>
        <td><?php echo $row->quantity?></td>
        <td>₦ <?php echo $row->item_price?></td>
        <td><?php echo $row->address . "<br>" . $row->city;?></td>
        <td><?php echo date("jS M, Y", strtotime($row->delivery_date))?></td>
        
    </tr>
    
</tbody>
<?php $n++; endforeach;?>

</table>


<?php 
    $check_order = $select_deliveries->rowCount();
    if(!$check_order){
        echo "<p style='font-weight:bold; color:chocolate; text-transform:capitalize; font-size:1.3rem; text-align:center; margin-top:10px;'>No record found!</p>";
    }
    if($select_deliveries){
        $totalAmount = $connectdb->prepare("SELECT SUM(item_price) AS total_price FROM orders WHERE company = :company AND order_status = 1 AND delivery_date BETWEEN '$from_date' AND '$to_date'");
        $totalAmount->bindvalue('company', $my_company);
        $totalAmount->execute();

        $amounts = $totalAmount->fetchAll();
        foreach($amounts as $amount){
            echo "<p style='color:green; font-size:1.3rem; text-align:right; text-decoration:underline; font-weight:bold; margin-top:30px;'>Total = ₦ ". number_format($amount->total_price, 2) . "</p>";
        }
    }
}
?>