<?php
    session_start();
    include "../controller/connections.php";
    $company = $_SESSION['company'];
?>
<div id="itemList" class="displays allResults">
<div class="info"></div>

    <h2>Item List</h2>
        <hr>
    <div class="search">
        <input type="search" id="searchRoom" placeholder="Enter keyword">
        <a class="download_excel" href="javascript:void(0)" onclick="convertToExcel('item_table', 'List of items')"title="Download to excel"><i class="fas fa-file-excel"></i></a>
    </div>
        <table id="data_table" class="searchTable">
            <thead>
                <tr>
                    <td>S/N</td>
                    <td>Category</td>
                    <td>Item name</td>
                    <td>Item Link</td>
                    <td>Price</td>
                    <td>Status</td>
                    <!-- <td>Featured</td> -->
                    
                </tr>
            </thead>
            <tbody>
                <?php
                    $get_item = $connectdb->prepare("SELECT * FROM menu ORDER BY item_name");
                    // $get_item->bindvalue("company", $company);
                    $get_item->execute();
                    $n = 1;
                    
                    $items = $get_item->fetchAll();

                    foreach($items as $item):
                ?>
                <tr>
                    <td style="text-align:center; color:red"><?php echo $n?></td>
                    <td><?php 
                        $get_cat = $connectdb->prepare("SELECT category FROM categories WHERE category_id = :category_id");
                        $get_cat->bindvalue("category_id", $item->item_category);
                        $get_cat->execute();
                        $cat = $get_cat->fetch();
                        echo $cat->category;
                    ?></td>
                    <td>
                        <a href="javascript:void(0);" onclick="getItem('<?php echo $item->item_id?>')" title="Edit item name" style="color:var(--tertiaryColor)"><?php echo strtoupper($item->item_name);?></a>
                    </td>
                    <td><?php echo "<a style='color:var(--moreColor)' href='../../item_info.php?item=".$item->item_id."' target='_blank'>View/copy item</a>";?></td>
                    <td style="color:var(--tertiaryColor)"><?php echo "₦ ".number_format($item->item_prize)?></td>
                        
                    <td>
                        <?php
                            if($item->item_status == 0){
                        ?>
                        Available <a href="javascript:void(0);" onclick="disableItem('<?php echo $item->item_id?>')" title="Disable this item"><i class="fas fa-power-off"></i></a>
                        <?php 
                            }else{
                        ?>
                        Disabled <a href="javascript:void(0);" onclick="activateItem('<?php echo $item->item_id?>')" title="Activate this item" style="color:green"><i class="fas fa-toggle-on"></i></a>
                        <?php }?>
                        <a href="javascript:void(0)" onclick="deleteItem('<?php echo $item->item_id?>')" title="Delete item" style="color:red"><i class="fas fa-trash"></i></a>

                    </td>
                    <!-- <td>
                        <?php
                            // if($item->featured_item == 0){
                        ?>
                        No <a href="javascript:void(0);" onclick="makeFeatured('<?php echo $item->item_id?>')" title="make featured item" style="color:green"><i class="fas fa-toggle-on"></i></a>
                        <?php 
                            // }else{
                        ?>
                        Yes <a href="javascript:void(0);" onclick="removeFeatured('<?php echo $item->item_id?>')" title="Remove from featured" style="color:red"><i class="fas fa-power-off"></i></a>
                        <?php /* } */?>
                       
                    </td> -->
                </tr>
                <?php $n++; endforeach;?>
            </tbody>
        </table>
        <?php
            if(!$get_item->rowCount() > 0){
                echo "<p class='no_result'>'No result found!'</p>";
            }
        ?>
    </div>