<?php
    require "../controller/server.php";
    session_start();
    $_SESSION['current_page'] = $_SERVER['REQUEST_URI'];

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Clozeth is an online platform made for the purpose of ordering fashion wears, men and women clothing, bed sheets, jewellries, etc from all kinds of retailers and wholesalers in Nigeria and Abroad from whereever you are through your mobile phone, tablet or pc">
    <meta name="keywords" content="Fashion, fashion store, clothings, men, women, men wears, women wears, jewellry, jewellries, rings, earings, wrist watch, eye glass, glass, shoes, order, ordering">
    <title>
        <?php
            if(isset($_SESSION['user'])){
                $user = $_SESSION['user'];
                $user_info = $connectdb->prepare("SELECT * FROM shoppers WHERE email = :email");
                $user_info->bindvalue('email', $user);
                $user_info->execute();
                $view = $user_info->fetch();
                echo $view->first_name . " " . $view->last_name. " - Clozeth Stores";
            }else{
                echo "Clozeth | Stores";
            }
         ?>

    </title>
    <!-- <link rel="stylesheet" href="bootstrap.min.css"> -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="../fontawesome-free-5.15.1-web/css/all.css">
    <link rel="icon" type="image/png" href="../images/logo.png" size="32X32">
    <link rel="stylesheet" href="../controller/style.css">
    
</head>
<body>
    <?php include "header.php";?>

    <?php include "mobile_menu.php";?>

    <main>
        <section id="searchResults">
            <?php
                
                    $search_query = $connectdb->prepare("SELECT * FROM exhibitors WHERE company_email != 'Admin@clozeth.com' AND payment_status = 2 ORDER BY reg_date");
                    $search_query->execute();
                    
                

            ?>
            <h2>Official stores on clozeth</h2>
            <hr>
            <div class="results">
                
                <?php 
                    $shows = $search_query->fetchAll();
                    foreach($shows as $show):
                ?>
                <figure>
                    <a href="javascript:void(0);" title="View store" onclick="showMenus('<?php echo $show->reg_number?>')">
                        <img class="stores" src="<?php echo '../admin/logos/'.$show->company_logo;?>" alt="stores">
                    </a>
                    <form>
                        <figcaption>
                            <div class="todo">
                                <p class="first"><?php echo $show->company_name?></p>
                                <p><i class="fas fa-street-view"></i> <?php echo $show->company_address?></p>
                                <!-- <p><i class="fas fa-map"></i> <?php echo $show->restaurant_location?></p> -->
                            </div>
                            <!-- <button type="submit" name="view_menu" id="view_menu" title="View Restaurant menu" class="view_menu"><i class="fas fa-document"></i></button> -->
                        </figcaption>
                    </form>
                </figure>
                
                <?php endforeach ?>
            </div>
        </section>

        
    </main>
    <footer>
        <?php include "footer.php";?>
    </footer>
    
    <script src="../controller/jquery.js"></script>
    <script src="../controller/script.js"></script>
    
</body>
</html>
