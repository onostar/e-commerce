<div id="update_foto" class="displays" style="width:80%!important">

<?php
    include "../controller/connections.php";
    session_start();
    $company = $_SESSION['company'];
    if(isset($_GET['item'])){
        $item = $_GET['item'];
        $get_item = $connectdb->prepare("SELECT * FROM menu WHERE item_id = :item_id");
        $get_item->bindValue('item_id', $item);
        $get_item->execute();
        $rows = $get_item->fetchAll();
        foreach($rows as $row){
?>
    
    <div class="info"></div>
    <div class="add_user_form">
        <h3 style="text-align:center">Update <?php echo strtoupper($row->item_name)?> photos</h3>
        <section id="addCatForm"  enctype="multipart/form-data">
            
            <div class="inputs">
                <input type="hidden" name="item" id="item" value="<?php echo $item;?>">
                <div class="data">
                    <label for="category">First photo</label>
                    <img src="<?php echo '../../items/'.$row->item_foto?>" alt="First photo">
                </div>
                <div class="data">
                    <label for="category">Second photo</label>
                    <img src="<?php echo '../../items/'.$row->other_foto?>" alt="First photo">
                </div>
                <div class="data">
                    <label for="">Select Photo Type</label>
                    <select name="banners" id="banners" required>
                        <option value="">Select Photo</option>
                        <option value="item_foto">First Photo</option>
                        <option value="other_foto">Second Photo</option>
                    </select>
                </div>
                <div class="data">
                    <label for="other_foto">Upload image</label>
                    <input type="file" name="item_foto" id="item_foto">
                </div>
            </div> 
            <div class="inputs">
                <div class="data">
                    <button id="updateBanner" name="addItem" style="background:green;color:#fff;padding:8px;font-size:.9rem;border:none;border-radius: 15px;box-shadow: 2px 2px 2px #c4c4c4;" onclick="updatePhoto()">Update <i class="fas fa-folder-plus"></i></button>
                    <a style="background:brown; color:#fff; padding:8px; border-radius:10px" href="javascript:void(0)" title="Go back" onclick="showPage('update_fotos.php')">Close <i class="fas fa-close"></i></a>
                </div>
            </div>
            
        </section>
    </div>


<?php
        }
    }
?>
</div>