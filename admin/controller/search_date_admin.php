<?php
    
    include "connections.php";
    session_start();

    
    $from_date = $_POST['from_date_admin'];
    $to_date = $_POST['to_date_admin'];
    $n = 1;
    $select_deliveries = $connectdb->prepare("SELECT shoppers.first_name, shoppers.last_name, shoppers.email, shoppers.address, shoppers.city, orders.order_id, orders.customer_email, orders.item_name, orders.quantity, orders.item_price, orders.company, orders.order_date, orders.delivery_date FROM shoppers, orders WHERE shoppers.email = orders.customer_email AND orders.order_status = 1 AND orders.delivery_date = CURDATE() ORDER BY orders.delivery_date DESC");
    
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
            <td>Company</td>
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
        <td><?php 
            $get_company = $connectdb->prepare("SELECT company_name FROM exhibitors WHERE exhibitor_id = :exhibitor_id");
            $get_company->bindvalue("exhibitor_id", $row->company);
            $get_company->execute();
            $company = $get_company->fetch();
            echo $company->company_name;
        ?></td>
        <td>₦ <?php echo $row->item_price?></td>
        <td><?php echo $row->address . "<br>" . $row->city;?></td>
        <td><?php echo $row->delivery_date?></td>
        
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
        $totalAmount = $connectdb->prepare("SELECT SUM(item_price) AS total_price FROM orders WHERE order_status = 1 AND delivery_date BETWEEN '$from_date' AND '$to_date'");
        $totalAmount->execute();

        $amounts = $totalAmount->fetchAll();
        foreach($amounts as $amount){
            echo "<p style='color:green; font-size:1.3rem; text-align:right; text-decoration:underline; font-weight:bold; margin-top:30px;'>Total = ₦ ". number_format($amount->total_price, 2, ".") . "</p>";
        }
    }
}
?>