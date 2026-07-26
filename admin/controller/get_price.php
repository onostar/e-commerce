<?php
    include "connections.php";
    
    if(isset($_POST['user_room']) && !empty($_POST['user_room'])){
        $room = $_POST['user_room'];
        $hotel = $_POST['user_hotel'];
        $get_price = $connectdb->prepare("SELECT hotels.hotel, hotels.website, hotels.hotel_address, rooms.hotel, rooms.room, rooms.price FROM hotels, rooms WHERE hotels.hotel = :hotel AND rooms.room = :room AND hotels.hotel = rooms.hotel ORDER BY room");
        $get_price->bindvalue("room", $room);
        $get_price->bindvalue("hotel", $hotel);
        $get_price->execute();
        
        $prices = $get_price->fetchAll();
        foreach($prices as $price):
    
?>
        <p id="prices">₦ <?php echo number_format($price->price)?></p>
        <div class="hotel_details">
            <i class="fas fa-computer"></i> <a id="url" href="<?php echo $price->website?>" target="_blank"title="Visit website"><?php echo $price->website?></a>
            <p><i class="fas fa-street-view"></i> <?php echo $price->hotel_address?></p>
        </div>
        <input type="hidden" name="amount" id="amount" value="<?php echo $price->price?>">
        
         <?php endforeach;?>

<?php }else{
    echo  "<p id='prices'>Select room</p>";
}