//animations on scroll
window.onscroll = function(){
    displayTotop();
    // displayFeatured(), displayAllItems(), , displayPopular();
}

/* show order details */
$(document).ready(function(){
    $("#track").click(function(){
        page = document.getElementById("trackItem");
        $("#trackItem").toggle();

        if(page.display = "none"){
            page.scrollIntoView();
        }
        // alert("work");
    })
})

function showDetails(){
    document.getElementById("track").addEventListener("click", function(){
        document.getElementById("trackItem").style.display = "block";
    })
}
//display login on desktop page
$(document).ready(function(){
    $("#loginDiv").click(function(){
        $(".login_option").toggle();
    });
    $("#bannerContents, main").click(function(){
        $(".login_option").hide();
    })
});
//display home page after intro
setTimeout(function(){
    $(".main").show();
    $(".loader").hide();
}, 3000)
window.addEventListener("load", function(){

    setTimeout(function(){

        document
            .getElementById("splash-screen")
            .classList.add("hideSplash");

    },2800);

});
/* view more featured */
/* $(document).ready(function(){
    $("#viewMore").click(function(){
        let moreFeatured = document.getElementById("moreFeatured").value;
        $.ajax({
            type:"POST",
            url: "more_featured.php",
            data:{moreFeatured:moreFeatured},
            success: function(response){
                $(".featured").hide();
                $(".all_feat").html(response);
            }
        })
        // alert(moreFeatured);
        return false;
        
    })
}) */
//display login on mobile
$(document).ready(function(){
    $("#mobile_menu #loginDiv").click(function(){
        $("#mobile_menu .login_option").toggle();
    });
});
/* display mobile menu */
$(document).ready(function(){
    $(".menu_icon").click(function(){
        $("#mobile_menu").toggle();
    });
    $("#banner, main").click(function(){
        $("#mobile_menu").hide();
        
    })
})
//display login first prompt
function loginFirst(){
    $("#loginPrompt").show();
}
// close login first prompt box
$(document).ready(function(){
    $("#closeBox").click(function(){
        $("#loginPrompt").hide();
    })
})
//display login first prompt when user cick on categories
$(document).ready(function(){
    $("#index_nav ul li").click(function(){
        loginFirst();
    })
})
/* //display more featured items
$(document).ready(function(){
    $("#view_more").click(function(){
        $(".featured").css("height", "auto");
        $("#view_more").hide();
        $("#show_less").show();
    })
})
//display less featured items
$(document).ready(function(){
    $("#show_less").click(function(){
        $(".featured").css("height", "280px");
        $("#view_more").show();
        $("#show_less").hide();

    })
})
//display more general items
$(document).ready(function(){
    $("#more").click(function(){
        $(".all_items").css("height", "auto");
        $("#more").hide();
        $("#less").show();
    })
})
//display less general items
$(document).ready(function(){
    $("#less").click(function(){
        $(".all_items").css("height", "280px");
        $("#more").show();
        $("#less").hide();

    })
})

//display more popular items
$(document).ready(function(){
    $("#more_popular").click(function(){
        $(".popular_items").css("height", "auto");
        $("#more_popular").hide();
        $("#less_popular").show();

    })
})
//display less popular items
$(document).ready(function(){
    $("#less_popular").click(function(){
        $(".popular_items").css("height", "280px");
        $("#more_popular").show();
        $("#less_popular").hide();

    })
}) */

//view notification details
function viewNotification(notify_id){
    window.open("not_details.php?notify_id="+notify_id, "_parent");
    return;
}

//show item information
function showItems(item_id){
    window.open("item_info.php?item="+item_id, "_parent");
    return;
}

//show store items 
function showMenus(store_id){
    window.open("exhibitor_menu.php?company="+store_id, "_parent");
    return;
}
//show store items from front page
function showStore(store_id){
    window.open("view/exhibitor_menu.php?company="+store_id, "_parent");
    return;
}

//add item to cart
/* $(document).ready(function(){
    $("#add_to_cart").click(function(){
        let cart_item_name = document.getElementById('cart_item_name').value;
        let cart_item_price = document.getElementById('cart_item_price').value;
        let cart_item_restaurant = document.getElementById('cart_item_restaurant').value;
        let customer_email = document.getElementById('customer_email').value;
        
        
        //   alert("work");
        $.ajax({
            type: "POST",
            url: "cart.php",
            data: {cart_item_name:cart_item_name, cart_item_price:cart_item_price, cart_item_restaurant:cart_item_restaurant,customer_email:customer_email},
            success: function(response){
                $(".info").html(response);
            }
        });
        /* $("#itemToDelete").focus();
        $("#itemToDelete").val(''); */
        // return false;
    // })

// }) */

/* login */
/* $(document).ready(function(){
    $("#submit_login").click(function(){
        let email = document.getElementById("email").value;
        let user_password = document.getElementById("user_password").value;
        $.ajax({
            type : "POST",
            url : "controller/login.php",
            data : {email:email, user_password:user_password},
            success : function(response){
                $(".error").html(response);
            }
        })
        return false;
    })
    
}) */
//display update user details by clicking on edit address
$(document).ready(function(){
    $("#editDetails").click(function(){
        // alert('hello');
        $(".update_details").show();
        $(".profile_details").hide();
        $("#close_update").click(function(){
            $(".profile_details").show();
            $(".update_details").hide();
        })
    })
})
//display change password
$(document).ready(function(){
    $("#changePasword").click(function(){
        // alert('hello');
        $(".change_password").toggle();
       
    })
})

/* authentication for whatsa number */
function checkNumber(id){
    if(id.length > 11){
        alert("Phone number is too long");
        $(id).focus();
        return;
    }else if(id.length < 11){
        alert("Phone number is too short");
        $(id).focus();
        return;
    }
}
//multiply item on shopping cart
function getCartTotal(){
    let itemTotal = document.getElementById("itemTotal").innerText;
    let total_amount = document.getElementById("total_amount");
    // let discount = document.getElementById("discount").innerText;
    let delivery = parseFloat(document.getElementById("delivery_fee").value);
    // remove the comma
    itemTotal = itemTotal.replace(/,/g, '');
    let grandTotal = document.getElementById("grandTotal");
    let thisTotal = parseFloat(itemTotal) + delivery;
    // add comma to the total
    grandTotal.innerText = thisTotal.toLocaleString()+".00";
    total_amount.value = thisTotal;
    // alert(delivery);
}
getCartTotal();

//delete item from cart
function removeCartItem(cart_id){
    let remove_item = confirm("Do you want to remove this item from cart?");
    if(remove_item){
        window.open('remove_cart_item.php?cart_item='+cart_id, '_parent');
        return;
    }
    
}

//hide suuccess message
// setTimeout()
//get total amount of items in cart
/* function cartItemTotal(){
    let totalPrice = document.querySelectorAll('.totalprice');

} */
// close error pop up box from cart
$(document).ready(function(){
    $("#close_error").click(function(){
        $(".error_box").hide();
    })
})

//display featured items on scroll
function displayFeatured(){
    if(document.body.scrollTop > 50 || document.documentElement.scrollTop > 50){
        document.getElementById("featured").style.display = "block";
    }else{
        document.getElementById("featured").style.display = "none";
    }
}
//display shop items on scroll
function displayAllItems(){
    if(document.body.scrollTop > 50 || document.documentElement.scrollTop > 50){
        document.getElementById("all_items").style.display = "block";
    }else{
        document.getElementById("all_items").style.display = "none";
    }
}
//display popular items on scroll
function displayPopular(){
    if(document.body.scrollTop > 20 || document.documentElement.scrollTop > 20){
        document.getElementById("popular").style.display = "block";
    }else{
        document.getElementById("popular").style.display = "none";
    }
}
//display to top button{
function displayTotop(){
    if(document.body.scrollTop > 100 || document.documentElement.scrollTop > 100){
        document.querySelector(".toTop").style.display = "block";
    }else{
        document.querySelector(".toTop").style.display = "none";
    }
}
/* $(document).ready(function(){
    $("#subscribe").click(function(){
        let subscribe_email = document.getElementById("subscribe_email").value;
        alert(subscribe_email);
        /* $.ajax({
            type: "POST",
            url: "subscribe.php",
            data: {subscribe_email:subscribe_email},
            success: function(response){
                $(".result").html(response);
            }
        }) 
        return false;
    })
    
}) */

//confirm order
/* function confirmOrder(user){
    let confirm_order = confirm("Do you want to confirm your order");
    if(confirm_order){
        window.open("order.php?user="+confirm_order, "_parent");
        return
    }
} */

/* toggle password */
function togglePassword(){
    let pw = document.getElementById("user_password");
    if(pw.type === "password"){
        pw.type = "text";
    }else{
        pw.type = "password";
    }
}

/* view order details */
function viewOrder(order){
    window.open("order_details.php?order="+order, "_parent");
    return;
}
/* view order details */
/* function viewItem(item){
    window.open("item_review.php?item="+item, "_parent");
    return;
} */

//cancel order
function cancelOrder(order_id){
    let cancel = confirm("Are you sure you want to Cancel this order?", "");
    if(cancel){
        window.open("../controller/cancel_order.php?cancel="+order_id, "_parent");
        return;
    }
    
}

// close add to cart success box
setTimeout(function(){
    $(".success_box").hide();
},3000);

//click to view item fotos

//clear cart
function clearCart(){
    let customer_cart = document.getElementById("customer_clear").value;
    let clear = confirm("Are you sure you want to clear your cart?", "");
    if(clear){
        window.open("../controller/clear_cart.php?customer="+customer_cart+"", "_parent");
    }else{
        return;
    }
}
//generate random characters
function generateString(length) {
     // random characters
     const characters ='ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
    let result = ' ';
    const charactersLength = characters.length;
    for ( let i = 0; i < length; i++ ) {
        result += characters.charAt(Math.floor(Math.random() * charactersLength));
    }

    return result;
}
//confirm order
function order(){
    let customer = document.getElementById("customer").value;
    let email_address = document.getElementById("email_address").value;
    let address = document.getElementById("address")?.value || "";
    let delivery_option = document.getElementById("delivery_option").value;
    let total_amount = document.getElementById("total_amount").value;
    let today = new Date();
    let transNum = generateString(5)+customer+today.getTime();
    if(delivery_option == ""){
        alert("Please select delivery option");
        $("#delivery_option").focus();
        return;
    }else if(delivery_option == "Home Delivery" && address.length == 0){
        alert("Please input delivery address");
        $("#address").focus();
        return;
    }else if(total_amount <= 0){
        alert("Your cart is empty");
        return;
    }else{
        let order = confirm("Are you sure you want to confirm this order?", "");
        if(order){
            const options = {
                amount: total_amount,
                currency: 'NGN',
                domain: 'live',
                key: 'a345d8cf-7df8-4276-a59d-b4bf1d35e8e9',
                email: email_address,
                transactionref: transNum,
                customer_logo: 'https://www.rivicos.com/images/logo.png',
                 customer_service_channel: '+2347055220617, support@rivicos.com',
                 txn_charge: 3,
                 txn_charge_type: 'percentage',
                 onSuccess: function(response) { 
                    $.ajax({
                        type: "POST",
                        url: "../controller/order.php",
                        data: {customer:customer, address:address, delivery_option:delivery_option, total_amount:total_amount, email_address:email_address, transNum:transNum},
                       /*  success : function(response){
                            $("#shoppingCart").html(response);
                        } */
                    })
                    alert('Payment Successful!', response.message);
                    window.open("../view/shopping_cart.php", "_parent");
                     return;
                 },
                onExit: function(response) {    console.log('Hello World!',
            response.message); }
            }
         
            if(window.VPayDropin){
                const {open, exit} = VPayDropin.create(options);
                open();                    
            }
        }else{
            return
        }
    }
    
}

//update quantity on sopping cart
/* function updateQuantity(){
    let item = document.getElementById("item").value;
    let cart_id = document.getElementById("cart_id").value;
    let quantity = document.getElementById("quantity").value;
    // let customer = document.getElementById("customer").value;
    
    
    if(quantity.length == 0){
        alert("please input quantity!");
        $("#quantity").focus();
        return;
    }else if(quantity <= 0){
        alert("Quantity cannot be less than or equal to zero!");
        $("#quantity").focus();
        return;
    }else{
        $.ajax({
            type : "POST",
            url : "../controller/update_quantity.php",
            data : {cart_id:cart_id, quantity:quantity, item:item},
            success : function(response){
                $("#cart"+cart_id).html(response);
            }
        })
    }
} */

function updateQty(quantity, item, cart){
    if(parseFloat(quantity) > 0){
        window.open("../controller/update_quantity.php?item="+item+"&quantity="+quantity+"&cart="+cart, "_self");
    }
    
}

//select delivery option
function selectDelivery(delivery_option){
    let delivery = document.getElementById("delivery");
    let delivery_fee = document.getElementById("delivery_fee");
    let del_address = document.getElementById("del_address");
    let address = document.getElementById("address");
    if(delivery_option == "Pick up"){
        delivery_fee.value = 0;
        delivery.innerText = "₦0.00"
        del_address.style.display = "none";
        address.removeAttribute("required");
        address.value = "";
        
    }else{
        delivery_fee.value = 2000;
        delivery.innerText = "₦2,000.00"
        del_address.style.display = "block";
        address.setAttribute("required", "required");
    }
    getCartTotal();
}