<?php
    include "../controller/connections.php";
    session_start();
    $company = $_SESSION['company'];
?>
<div id="add_items" class="displays">
    
    <div class="info"></div>
    <div class="add_user_form">
        <h3 style="text-align:center">Update front page cover photos</h3>
        <section id="addCatForm"  enctype="multipart/form-data">
            
            <div class="inputs">
                <input type="hidden" name="company" id="company" value="<?php echo $company;?>">
                <div class="data">
                    <label for="category">Select Banner</label>
                    <select name="banners" id="banners" required>
                        <option value="">Select banner</option>
                        <option value="banner1">First banner</option>
                        <option value="banner2">Second banner</option>
                        <option value="banner3">Third banner</option>
                        <option value="banner4">Fourth banner</option>
                    </select>
                </div>
                <div class="data">
                    <label for="other_foto">Upload image</label>
                    <input type="file" name="item_foto" id="item_foto">
                </div>
            </div> 
            <div class="inputs">
                <div class="data">
                    <button id="updateBanner" name="addItem" style="background:green;color:#fff;padding:8px;font-size:.9rem;border:none;border-radius: 15px;box-shadow: 2px 2px 2px #c4c4c4;" onclick="updateBanner()">Update <i class="fas fa-folder-plus"></i></button>
                </div>
            </div>
            
        </section>
    </div>
</div>