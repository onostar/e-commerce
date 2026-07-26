<h3>Shop by Categories</h3>
                
    <!-- <h3>Categories</h3> -->
    <?php
        $get_categories = $connectdb->prepare("SELECT * FROM categories ORDER BY category ASC");
        $get_categories->execute();
        $cats = $get_categories->fetchAll();
        foreach($cats as $cat):
    ?>
        <li>
            <form action="view/categories.php" method="GET">
                <input type="hidden" name="item_cat" value="<?php echo $cat->category_id?>">
                <?php 
                    if($cat->category == "Perfumes"){
                        echo "<i class='fas fa-spray-can'></i>";
                    }elseif($cat->category == "Books"){
                        echo "<i class='fas fa-book'></i>";
                    }elseif($cat->category == "Glasses"){
                        echo "<i class='fas fa-glasses'></i>";
                    }elseif($cat->category == "Soaps"){
                        echo "<i class='fas fa-soap'></i>";
                    }elseif($cat->category == "Wines"){
                        echo "<i class='fas fa-wine-bottle'></i>";
                    }elseif($cat->category == "Jewelries"){
                        echo "<i class='fas fa-gem'></i>";
                    }elseif($cat->category == "Wrist Watches"){
                        echo "<img src='images/wrist-watch.png'>";
                    }elseif($cat->category == "Shoes"){
                        echo "<img src='images/sport-shoe.png'>";
                    }elseif($cat->category == "Multivitamins"){
                        echo "<i class='fas fa-tablets'></i>";
                    }elseif($cat->category == "Supplements"){
                        echo "<i class='fas fa-capsules'></i>";
                    }elseif($cat->category == "Cosmetics"){
                        echo "<i class='fas fa-spray-can'></i>";
                    }elseif($cat->category == "Toys"){
                        echo "<i class='fas fa-gamepad'></i>";
                    }elseif($cat->category == "Kids Fashion"){
                        echo "<img src='images/baby-clothes.png'>";
                    }elseif($cat->category == "Children"){
                        echo "<i class='fas fa-child'></i>";
                    }elseif($cat->category == "Body Spray"){
                        echo "<i class='fas fa-spray-can'></i>";
                    }elseif($cat->category == "Snacks"){
                        echo "<i class='fas fa-cookie'></i>";
                    }elseif($cat->category == "Fresh Food"){
                        echo "<i class='fas fa-apple-alt'></i>";
                    }elseif($cat->category == "Household Essentials"){
                        echo "<i class='fas fa-home'></i>";
                    }else{
                ?>
                <i class="fas fa-shopping-cart"></i>
                <?php }?>
                    <input type="submit" value="<?php echo strtoupper($cat->category)?>" name="check_category">
            </form> 
        </li>
        
        
        <?php endforeach;?>
        <?php if(isset($_SESSION['user'])){
            echo "";
        }else{    
        ?>
        <!-- <li><a href="view/sellers.php"><i class="fas fa-shop"></i>Become a Seller</a></li> -->
        <?php }?>