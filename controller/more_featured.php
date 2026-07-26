<?php
    include "server.php";
    session_start();
if(isset($_POST['viewMore'])){
    $featured = $_POST['moreFeatured'];

    $get_more = $connectdb->prepare("SELECT * FROM menu WHERE featured_item = :featured_item ORDER BY time_created DESC");
    $get_more->bindvalue("featured_item", $featured);
    $get_more->execute();
    $rows = $get_more->fetchAll();
    foreach($rows as $row):
?>
        <figure>
            <a href="javascript:void(0);" onclick="loginFirst();">
                <img src="<?php echo '../items/'.$row->item_foto;?>" alt="featured item">
                <figcaption>
                    <div class="todo">
                        <p><?php echo $row->item_name?></p>
                        <p><i class="fas fa-store"></i> <?php echo $row->restaurant_name?></p>
                        <span>₦ <?php echo number_format($row->item_prize)?></span>
                    </div>
                    <!-- <button title="add to cart" class="add_cart"><i class="fas fa-shopping-cart"></i></button> -->
                </figcaption>
            </a>
        </figure>
        
        <?php endforeach; ?>
        
    <!-- </div> -->
    <!-- <form action="more_featured.php">
        <input type="hidden" name="more_featured" value="1" id="more_featured">
        <button type="submit" id="view_more">View less</button>
        
    </form> -->

<?php }?>