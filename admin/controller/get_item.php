<?php
    include "connections.php";
    session_start();


    if(isset($_GET['item'])){
        $item = $_GET['item'];
        //get item name
        $get_name = $connectdb->prepare("SELECT * FROM menu WHERE item_id = :item_id");
        $get_name->bindValue("item_id", $item);
        $get_name->execute();
        $rows = $get_name->fetchAll();
        foreach($rows as $row){
            $name = $row->item_name;
            $category = $row->item_category;
            $option = $row->payment_option;
            $delivery = $row->delivery_time;
            $description = $row->item_description;
            $price = $row->item_prize;
            $item_foto = $row->item_foto;
            $other_foto = $row->other_foto;
        }
        //get category
        $get_cate = $connectdb->prepare("SELECT category FROM categories WHERE category_id = :category_id");
        $get_cate->bindValue("category_id", $category);
        $get_cate->execute();
        $cat = $get_cate->fetch();
        $item_Category = $cat->category;
        ?>
        <style>
            .addUserForm img{
                width:100%;
                height:80px!important;
            }
        </style>
        <div class="add_user_form priceForm" style="width:100%; margin:0">
        <h3>Edit <?php echo $name?></h3>
        <!-- <form method="POST" id="addUserForm"> -->
        <section class="addUserForm">
            <div class="inputs" style="gap:.5rem; text-align:left; align-items:flex-start; justify-content:left">
                <div class="data" style="width:32%">
                <label for="category">Category</label>
                    <select name="item_category" id="item_category">
                        <option value="<?php echo $category?>"selected><?php echo $item_Category?></option>
                        <?php
                            $get_cat = $connectdb->prepare("SELECT * FROM categories ORDER BY category");
                            $get_cat->execute();
                            $cats = $get_cat->fetchAll();
                            foreach($cats as $cat):
                        ?>
                        <option value="<?php echo $cat->category_id?>"><?php echo $cat->category?></option>
                        <?php endforeach?>
                    </select>
                </div>
                <div class="data" style="width:32%">
                    <input type="hidden" name="item" id="item" value="<?php echo $item?>">
                    <label for="name">Item name</label>
                    <input type="text" name="item_name" id="item_name" value="<?php echo $name?>">
                </div>
                <div class="data" style="width:32%">
                    
                    <label for="price">Price</label>
                    <input type="text" name="price" id="price" value="<?php echo $price?>">
                </div>
                <!-- <div class="data" style="width:32%">                   
                    <label for="option">Payment Option</label>
                    <select name="option" id="option">
                        <option value="<?php echo $option?>"selected><?php echo $option?></option>
                        <option value="pay on delivery">Pay on Delivery</option>
                            <option value="50% upfront">Pay 50% upfront </option>
                            <option value="Full pyment">Full payment </option>
                    </select>
                </div> -->
                <input type="hidden" name="option" id="option" value="<?php echo $option?>">
                <div class="data" style="width:32%">                   
                    <label for="delivery">Delivery time</label>
                    <select name="delivery" id="delivery">
                        <option value="<?php echo $delivery?>"><?php echo $delivery?></option>
                        <option value="1 to 7 days">1 to 7 days</option>
                            <option value="8 to 14 day">8 to 14 days </option>
                            <!-- <option value="Within 2 weeks">Within 2 weeks </option> -->
                    </select>
                </div>
                <div class="data" style="width:65%">
                    <label for="descritpion">Description</label>
                    <textarea name="descritpion" id="description" rows="5"><?php echo $description?></textarea>
                </div>
                <div class="data" style="width:28%">
                    <label for="category">First photo</label>
                    <img src="<?php echo '../../items/'.$item_foto?>" alt="First photo" loading="lazy">
                    <input type="file" id="first_foto" name="first_foto">
                </div>
                <div class="data" style="width:28%">
                    <label for="category">Second photo</label>
                    <img src="<?php echo '../../items/'.$other_foto?>" alt="Second photo" loading="lazy">
                    <input type="file" id="second_foto" name="second_foto">
                </div>
                <div class="data">
                    <button type="button" id="add_dep" name="add_dep" onclick="editName()">Save record <i class="fas fa-layer-group"></i></button>
                    <a href="javascript:void(0)" title="close form" style='background:red; padding:10px; border-radius:10px; color:#fff' onclick="closeForm()">Close <i class='fas fa-close'></i></a>

                </div>
            </div>
            
    </section>    
    </div>
    <?php
        
    }
?>