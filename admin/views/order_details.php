<div id="sales_details">
<?php
    include "../controller/connections.php";
    // if(isset($_SESSION['user'])){
        if(isset($_GET['order'])){
            $invoice = $_GET['order'];
        
        //get invoice details

?>

<div class="info"></div>
<div class="displays all_details">
    <!-- <div class="info"></div> -->
    <button class="page_navs" id="back" onclick="showPage('pending_order.php')" style="background:brown;border-radius:15px"><i class="fas fa-angle-double-left"></i> Back</button>
    <div class="guest_name">
        <div class="displays allResults" id="payment_det">
        <h3 style="background:var(--tertiaryColor); color:#fff; padding:10px;font-size:.9rem">Items with order No. <?php echo $invoice?></h3>
    <div id="history">
        <div class="order_history">
        <?php
            $n = 1;
            $select_order = $connectdb->prepare("SELECT shoppers.first_name, shoppers.last_name, shoppers.email, shoppers.address, shoppers.city, shoppers.phone_number, orders.order_id, orders.customer, orders.item_id, orders.quantity, orders.item_price, orders.company, orders.delivery_address, orders.order_date, orders.order_status,  menu.payment_option, menu.item_name, menu.item_foto FROM shoppers, orders, menu WHERE orders.order_number = :order_number AND orders.item_id = menu.item_id AND orders.order_status = 0 ORDER BY orders.order_date DESC");
            $select_order->bindValue("order_number", $invoice);
            $select_order->execute();
    if($select_order->rowCount() > 0){
            $rows = $select_order->fetchAll();
            foreach($rows as $row){
        ?>
            <figure>
                <a href="javascript:void(0)"><img src="<?php echo '../../items/'.$row->item_foto?>" alt="my order"></a>
                <figcaption>
                    <div class="order_details">
                        <p id="name"><?php echo $row->item_name;?></p>
                        
                        <p>Qty: <?php echo $row->quantity;?></p>
                        <p>Price: ₦<?php echo number_format($row->item_price);?></p>
                        <p>Total Amount: ₦<?php echo number_format($row->item_price * $row->quantity);?></p>
                        <p>Option: <?php echo  $row->payment_option;?></p>
                        <div class="status_order" id="status_flex"> 
                            <a class="cancel_order" href="javascript:void(0);" title="Dispense item" onclick="dispenseItem('<?php echo $row->order_id?>', '<?php echo $invoice?>')">Dispense <i class="fas fa-truck-loading"></i></a>
                            <a style="background:red;"class="cancel_order" href="javascript:void(0);" title="Cancel Order" onclick="cancelOrder('<?php echo $row->order_id?>', '<?php echo $invoice?>')">Cancel <i class="fas fa-plane-slash"></i></a>
                        </div>
                    </div>
                </figcaption>
            </figure>
            <?php }?>
        </div>
    </div>
        <div class="amount_due" id="due_bill" style="width:100%;">
            <div class="add_bill">
                <a href="javascript:void(0)" title="Dispense all items" onclick="dispenseAll('<?php echo $invoice?>')" style="background:var(--newColor)">Dispense all <i class="fas fa-check-double"></i></a>
                <a href="javascript:void(0)" title="Add order to bill" onclick="cancelAllOrders('<?php echo $invoice?>')" style="background:brown"> Cancel all <i class="fas fa-trash"></i></a>
            </div>
            <h2>Total Amount: 
            <?php
                //get total amount
                $get_total = $connectdb->prepare("SELECT SUM(quantity * item_price) AS total FROM orders WHERE order_number = :order_number AND order_status = 0");
                $get_total->bindvalue("order_number", $invoice);
                $get_total->execute();
                $details = $get_total->fetch();
                // foreach($details as $detail){
                    echo "₦".number_format($details->total, 2);
                // }
            ?>
            </h2>

            
        </div>
        <div class="customer_info">
            <h2 style="background:var(--moreColor); color:#fff; padding:10px;font-size:.9rem">Customer details</h2>
            <?php
                //ge customer id from orders table
                    $get_cus_id = $connectdb->prepare("SELECT customer FROM orders WHERE order_number = :order_number");
                    $get_cus_id->bindValue("order_number", $invoice);
                    $get_cus_id->execute();
                    $cus = $get_cus_id->fetch();
                    $customer = $cus->customer;
                    //get customer details
                    $get_customer = $connectdb->prepare("SELECT shoppers.first_name, shoppers.last_name, shoppers.email, shoppers.phone_number, orders.delivery_address, orders.delivery_option FROM shoppers, orders WHERE shoppers.user_id = :user_id AND shoppers.user_id = orders.customer AND orders.order_number = :order_number GROUP BY orders.order_number");
                    $get_customer->bindValue("user_id", $customer);
                    $get_customer->bindValue("order_number", $invoice);
                    $get_customer->execute();
                    $details = $get_customer->fetchAll();
                    foreach($details as $detail){
            ?>

            <div class="inputs">
                <div class="data">
                    <label for="">Name: </label>
                    <p><?php echo $detail->first_name." ".$detail->last_name?></p>
                </div>
                <div class="data">
                    <label for="">Contact No.: </label>
                    <p><?php echo "<a style='color:green' href='https://wa.me/+234".$row->phone_number."' title='Chat on whatsapp' target='_blank'>$detail->phone_number <i class='fab fa-whatsapp'></i></a>"?></p>
                </div>
                <div class="data">
                    <label for="">Delivery option: </label>
                    <p><?php echo $detail->delivery_option?></p>
                </div>
                <div class="data">
                    <label for="">Delivery Address: </label>
                    <p><?php echo $detail->delivery_address?></p>
                </div>
                <!-- <div class="data">
                    <label for="">Email: </label>
                    <p><?php echo $detail->email?></p>
                </div> -->
            </div>


            <?php } }else{?>
                <p style="text-align:center">No record found!</p>
            <?php }?>
        </div>
        </div>
        
    </div>
    
    
</div>
<?php

        
    }
/* }else{
    header("Location: ../index.php");
} */
?>
</div>