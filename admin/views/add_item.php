<?php
    include "../controller/connections.php";
    session_start();
    $company = $_SESSION['company'];
?>
<div id="add_items" class="displays">
    
    <div class="info"></div>
    <div class="add_user_form">
        <h3 style="text-align:center">Add items to store</h3>
        <section id="addCatForm"  enctype="multipart/form-data">
            
            <div class="inputs">
                <input type="hidden" name="company" id="company" value="<?php echo $company;?>">
                <div class="data">
                    <label for="category">Select Category</label>
                    <select name="item_category" id="item_category" required>
                        <option value=""selected>Choose a category</option>
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
                <div class="data">
                    <label for="items">Enter Item name</label>
                    <input type="text" name="item" id="item">
                </div>
            </div>
                <div class="inputs">
                    <div class="data">
                        <label for="item_price">Item Price (NGN)</label>
                        <input type="text" name="item_price" id="item_price">
                    </div>
                    <input type="hidden" name="payment_option" id="payment_option" value="Full pyment">
                    <!-- <div class="data">
                        <label for="payment_option">Payment Options</label>
                        <select name="payment_option" id="payment_option" required>
                            <option value="" selected>Select a payment option</option>
                            <option value="pay on delivery">Pay on Delivery</option>
                            <option value="50% upfront">Pay 50% upfront </option>
                            <option value="Full pyment">Full payment </option>
                        </select>
                    </div>
                </div> -->
                    <div class="data">
                        <label for="delivery_time">Delivery time frame</label>
                        <select name="delivery_time" id="delivery_time" required>
                            <option value="" SELECTED>Select delivery time</option>
                            <option value="1 to 7 days">1 to 7 days</option>
                            <option value="4 to 14 day">8 to 14 days </option>
                            <!-- <option value="Within 2 weeks">Within 2 weeks </option> -->
                        </select>
                    </div>
                </div>
                <div class="inputs">
                    <div class="data">
                        <label for="item_foto">Item Image (Not more than 2000mb)</label>
                        <input type="file" name="item_foto" id="item_foto" required>
                    </div>
                    <div class="data">
                        <label for="other_foto">Second Image (Not more than 2000mb)</label>
                        <input type="file" name="other_foto" id="other_foto">
                    </div>
                </div>
                <div class="inputs">
                    <div class="data" style="width:100%">
                        <label for="item_desc">Item description</label>
                        <textarea rows="4" type="text" name="item_desc" id="item_desc" required placeholder="Give proper description and features of the product"></textarea>
                    </div>
                    
                </div>  
            <div class="inputs">
                <div class="data">
                    <button id="addItem" name="addItem" style="background:green;color:#fff;padding:8px;font-size:.9rem;border:none;border-radius: 15px;box-shadow: 2px 2px 2px #c4c4c4;" onclick="addItem()">Add item <i class="fas fa-folder-plus"></i></button>
                </div>
            </div>
            
                            </section>
    </div>
</div>