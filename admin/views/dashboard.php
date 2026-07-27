<div id="dashboard">
    <div class="cards" id="card4">
        <a href="javascript:void(0)" onclick="showPage('revenue_report.php')">
            <div class="infos">
                <p><i class="fas fa-coins"></i> Daily Revenue</p>
                <p>
                <?php
                    $get_revenue = $connectdb->prepare("SELECT SUM(quantity * item_price) as total FROM orders WHERE order_status != -1 AND date(order_date) = CURDATE()");
                    $get_revenue->execute();
                    $rows = $get_revenue->fetchAll();
                    foreach($rows as $row){
                        $amount = $row->total;
                    }
                        echo "₦".number_format($amount, 2);
                ?>
                </p>
            </div>
        </a>
    </div> 
    <div class="cards" id="card1">
        <a href="javascript:void(0)" onclick="showPage('pending_order.php')"class="page_navs">
            <div class="infos">
                <P><i class="fas fa-cart-arrow-down"></i> Incoming Orders</P>
                <p>
                <?php
                    $orders = $connectdb->prepare("SELECT * FROM orders WHERE company = :company AND order_status = 0");
                    $orders->bindvalue('company', $user->user_id);
                    $orders->execute();
                    echo $orders->rowCount();
                ?>
                </p>
            </div>
        </a>
    </div> 
    <div class="cards" id="card5">
        <a href="javascript:void(0)" onclick="showPage('confirm_delivery.php')"class="page_navs" data-page="confirmDelivery">
            <div class="infos">
                <P><i class="fas fa-truck-loading"></i> Pending Delivery</P>
                <p>
                <?php
                    $orders = $connectdb->prepare("SELECT * FROM orders WHERE company = :company AND order_status = 1");
                    $orders->bindvalue('company', $user->user_id);
                    $orders->execute();
                    echo $orders->rowCount();
                ?>
                </p>
            </div>
        </a>
    </div> 
    <div class="cards" id="card0">
        <a href="javascript:void(0)" onclick="showPage('delivery_report.php')">
            <div class="infos">
            <P><i class="fas fa-truck"></i> Daily Deliveries</P>
                <p>
                <?php
                    $orders = $connectdb->prepare("SELECT * FROM orders WHERE company = :company AND order_status = 2 AND date(deliverY_date) = CURDATE()");
                    $orders->bindvalue('company', $user->user_id);
                    $orders->execute();
                    echo $orders->rowCount();
                ?>
                </p>
            </div>
        </a>
    </div> 
    
    
</div>
<!--show summary report -->
<div id="paid_receipt" class="displays management">
    <!-- <hr> -->
    
    <div class="daily_monthly">
        <div class="daily_report allResults">
            <h3>Daily Orders</h3>
            <table>
                <thead style="background:var(--buttonColor)">
                    <tr>
                        <td>S/N</td>
                        <td>Date</td>
                        <td>Orders</td>
                        <td>Revenue</td>
                    </tr>
                </thead>
                <?php
                    $get_daily = $connectdb->prepare("SELECT COUNT(order_id) AS customers, SUM(item_price * quantity) AS revenue, order_date FROM orders WHERE company = :company AND order_status != -1 GROUP BY date(order_date) ORDER BY order_date DESC");
                    $get_daily->bindvalue("company", $user->user_id);
                    $get_daily->execute();
                        $n = 1;
                    $dailys = $get_daily->fetchAll();
                    foreach($dailys as $daily):

                ?>
                <tbody>
                    <tr>
                        <td style="text-align:center; color:red"><?php echo $n?></td>
                        <td style="color:var(--moreColor)"><?php echo date("d-M-Y",strtotime($daily->order_date))?></td>
                        <td style="text-align:center"><?php echo $daily->customers?></td>
                        <td style="color:red"><?php echo "₦".number_format($daily->revenue)?></td>
                    </tr>
                </tbody>
                <?php $n++; endforeach;?>

                
            </table>
            <?php 
                $check_order = $get_daily->rowCount();
                if(!$check_order){
                echo "<p style='font-weight:bold; color:chocolate; text-transform:capitalize; font-size:1rem; text-align:center; margin-top:10px;'>No record found!</p>";
                }
            ?>
        </div>
        <div class="monthly_report allResults">
            <h3 style="border-radius:20px 20px 0 0;">Monthly Order Reports</h3>
            <table>
                <thead style="background:var(--buttonColor)">
                    <tr>
                        <td>S/N</td>
                        <td>Month</td>
                        <td>Orders</td>
                        <td>Revenue</td>
                        <td>Daily Average</td>
                    </tr>
                </thead>
                <?php
                    $get_monthly = $connectdb->prepare("SELECT COUNT(order_id) AS customers, SUM(item_price * quantity) AS revenue, order_date, COUNT(order_date) AS deliveries, COUNT(DISTINCT order_date) AS daily_average FROM orders WHERE company = :company  AND order_status != -1 GROUP BY MONTH(order_date), YEAR(order_date) ORDER BY YEAR(order_date), MONTH(order_date) DESC");
                    $get_monthly->bindvalue("company", $user->user_id);
                    $get_monthly->execute();
                    $n = 1;
                    $monthlys = $get_monthly->fetchAll();
                    foreach($monthlys as $monthly):

                ?>
                <tbody>
                    <tr>
                        <td style="text-align:center; color:red"><?php echo $n?></td>
                        <td><?php echo date("M, Y", strtotime($monthly->order_date))?></td>
                        <td style="text-align:center"><?php echo $monthly->customers?></td>
                        <td><?php echo "₦".number_format($monthly->revenue)?></td>
                        <td style="color:red"><?php
                            $average = $monthly->revenue/$monthly->daily_average;
                            echo "₦".number_format($average);
                        ?></td>
                    </tr>
                </tbody>
                <?php $n++; endforeach;?>

                
            </table>
            <?php 
                $check_order = $get_monthly->rowCount();
                if(!$check_order){
                echo "<p style='font-weight:bold; color:chocolate; text-transform:capitalize; font-size:1rem; text-align:center; margin-top:10px;'>No record found!</p>";
                }
            ?>
        </div>
    </div>
</div>