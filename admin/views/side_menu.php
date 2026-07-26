
    <div class="login">
        <button id="loginDiv"><i class="far fa-user"></i> Account <i class="fas fa-chevron-down"></i></button>
        <div class="login_option">
            <div>
                <button id="loginBtn"><a href="../controller/logout.php">Log out</a></button>
                
            </div>
        </div>
    </div>
    <nav>
        <h3><a href="user.php" title="Home"><i class="fas fa-home"></i> Main Menus</a></h3>
        <ul>
            
            <li><a href="javascript:void(0);" id="addCat" title="Add items" class="page_navs"onclick="showPage('add_category.php')"><i class="fas fa-layer-group"></i>Add Category</a></li>
            <li><a href="javascript:void(0);" id="addCat" title="Add items" class="page_navs"onclick="showPage('add_item.php')"><i class="fas fa-folder-plus"></i>Add New Item</a></li>
            <li><a href="javascript:void(0);" id="addCat" title="Update banner" class="page_navs"onclick="showPage('update_banners.php')"><i class="fas fa-photo-video"></i>Update banner</a></li>
            <li><a href="javascript:void(0);" id="addCat" title="Update item photos" class="page_navs"onclick="showPage('update_fotos.php')"><i class="fas fa-photo-film"></i>Update item photos</a></li>
            <li><a href="javascript:void(0);" id="itemsBtn" class="page_navs" onclick="showPage('item_list.php')"><i class="fas fa-list"></i> Item list</a></li>
            <!-- <li><a href="javascript:void(0);" class="page_navs" onclick="showPage('item_price.php')"><i class="fas fa-tag"></i> Manage prices</a></li> -->
            <li><a href="javascript:void(0);" class="page_navs" onclick="showPage('pending_order.php')"><i class="fas fa-cart-arrow-down"></i> Manage Orders</a></li>
            <li><a href="javascript:void(0);" class="page_navs" onclick="showPage('confirm_delivery.php')"><i class="fas fa-truck-moving"></i> Confirm Delivery</a></li>
            <li><a href="javascript:void(0);" onclick="toggleMenu('reportMenu')" class="allMenus" title="reports"><span><i class="fas fa-clipboard-list"></i> Reports </span><span class="second_icon"><i class="fas fa-chevron-down more_option"></i></span></a>
                <ul class="subMenu" id="reportMenu">
                    <li><a href="javascript:void(0);" class="page_navs" onclick="showPage('delivery_report.php')"><i class="fas fa-clipboard-list"></i> Delivery report</a></li>
                    <li><a href="javascript:void(0);" class="page_navs" onclick="showPage('revenue_report.php')"><i class="fas fa-coins"></i> Revenue report</a></li>
                    <li><a href="javascript:void(0);" class="page_navs" onclick="showPage('cancelled_orders.php')"><i class="fas fa-shop-slash"></i> Cancelled Orders</a></li>
                    <li><a href="javascript:void(0);" class="page_navs" onclick="showPage('highest_selling.php')"><i class="fas fa-chart-line"></i> Highest Selling</a></li>
                    <li><a href="javascript:void(0);" class="page_navs" onclick="showPage('customer_list.php')"><i class="fas fa-users"></i> Customer list</a></li>
                </ul>
            </li>
            <li><a href="javascript:void(0);" id="updateUser" class="page_navs" data-page="profile" onclick="showPage('update_profile.php')"><i class="fas fa-user"></i> Update Profile</a></li>
        </ul>
    </nav>