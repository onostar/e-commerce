<?php
    include "../controller/connections.php";
?>
<div id="customers">
<?php
    
    if(isset($_SESSION['success'])){
        echo $_SESSION['success'];
    }

?>

    <div class="info" style="width:80%; margin:0!important"></div>
    <div class="displays allResults" style="width:80%;">
        <h2>List of customers</h2>
        <hr>
        <div class="search">
            <input type="search" placeholder="Enter keyword" onkeyup="searchData(this.value)">
            <a class="download_excel" href="javascript:void(0)" onclick="convertToExcel('customerTable', 'Customer List')"title="Download to excel"><i class="fas fa-file-excel"></i></a>
        </div>
        <table id="customerTable" class="searchTable">
            <thead>
                <tr style="background:var(--tertiaryColor)">
                <td>S/N</td>
                <td>Customer</td>
                <td>Phone No.</td>
                <td>Address</td>
                </tr>
            </thead>

            <tbody>
            <?php
                $n = 1;
                $select_order = $connectdb->prepare("SELECT * FROM shoppers ORDER BY reg_date DESC");
                $select_order->execute();
                $rows = $select_order->fetchAll();
                if(gettype($rows) == 'array'){
                foreach($rows as $row):
            ?>
                <tr>
                    <td style="text-align:center; color:red"><?php echo $n?></td>
                    <td><?php echo $row->first_name. " ". $row->last_name?></td>
                    <td><?php echo "<a href='https://wa.me/+234".$row->phone_number."' title='Chat on whatsapp' target='_blank'>$row->phone_number</a>"?></td>
                    <td><?php echo $row->address?></td>
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