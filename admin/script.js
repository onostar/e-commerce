//animations on scroll
// window.onscroll = function(){changeHeader();
// }
/*change header */
function changeHeader(){
    if(document.body.scrollTop > 5 || document.documentElement.scrollTop > 5){
        document.getElementById('mainHeader').className = 'new_header';
        /* document.getElementById('h1').style.width = '15%'; */
        /* document.querySelector('.logo').className = 'new-logo'; */
    }
    else{
        document.getElementById('mainHeader').className = 'main_header';
        /* document.getElementById('h1').style.width = '25%'; */
        /* document.querySelector('.logo').className = 'logo'; */
    }
}
/* submit appointment form */
/* $(document).ready(function(){
    $("#book").click(function(){
        let customer_name = document.getElementById("customer_name").value;
        let customer_phone = document.getElementById("customer_phone").value;
        let customer_mail = document.getElementById("customer_mail").value;
        let service = document.getElementById("service").value;
        let appointment_date = document.getElementById("appointment_date").value;
        let appointment_address = document.getElementById("appointment_address").value;
        let notes = document.getElementById("notes").value;
        // alert(notes);

        $.ajax({
            type: "POST",
            url: "appointment.php",
            data: {customer_name:customer_name, customer_phone:customer_phone, customer_mail:customer_mail, service:service, appointment_date:appointment_date, appointment_address:appointment_address, notes:notes},
            success: function(response){
                $(".result").html(response);
            }
        });
        // $(".appointment_page").show();
        return false;
    })
}) */

//display home page after intro
/* setTimeout(function(){
    $(".main").show();
    $(".loader").hide();
}, 3000) */
//display login on desktop page
$(document).ready(function(){
    $("#loginDiv").click(function(){
        $(".login_option").toggle();
        // alert("work");
    });
    
});
//toggle all submenu
/* show frequenty asked questions */
function toggleMenu(subMenu){
    let menus = document.querySelectorAll(".subMenu");
    menu_id = document.getElementById(subMenu);
    if(menu_id.style.display == "block"){
         menu_id.style.display = "none";
    }else{
         menus.forEach(function(menu){
              menu.style.display = "none";
         })
         menu_id.style.display = "block";
    }
}
/* get hotels from upload payment form */
function showHotels(hotel){
    if(hotel == "yes"){
        document.getElementById("hotels").style.display = "block";
    }else{
        document.getElementById("hotels").style.display = "none";
    }
}
/* toggle password */
function togglePassword(){
    let pw = document.getElementById("password");
    if(pw.type === "password"){
        pw.type = "text";
    }else{
        pw.type = "password";
    }
}
/* search users withour refreshing page */
$(document).ready(function(){
    $("#searchBtn").click(function(){
        let search_user = document.getElementById("search_items").value;
        // alert(search);
         $.ajax({
            type : "POST",
            url : "../controller/search_result.php",
            data: {search_user:search_user},
            success: function(response){
                $(".allResults").html(response);
                $("#dashboard").hide();
            }
        })
        return false;
    })
})
// bulk request for accomodation without refresh
// $(document).ready(function(){
//     $("#request_bulk").click(function(){
//         let requester = document.getElementById("requester").value;
//         let pcn_id = document.getElementById("pcn_id").value;
//         let pcn_id = document.getElementById("user_hotel").value;
//         let pcn_id = document.getElementById("user_room").value;
//         // alert(search);
//          $.ajax({
//             type : "POST",
//             url : "../controller/request_hotel.php",
//             data: {requester:requester, pcn_id:pcn_id, user_hotel:user_hotel, user_room:user_room},
//             success: function(response){
//                 $(".info").html(response);
//                 // $("#dashboard").hide();
//             }
//         })
//         return false;
//     })
// })
/* update profile withour refreshing page */
/* $(document).ready(function(){
    $("#searchBtn").click(function(){
        let search = document.getElementById("search_items").value;

        $.ajax({
            type : "POST",
            url : "../controller/search_result.php",
            data: {search:search},
            success: function(response){
                $(".allResults").html(response);
                $("#dashboard").hide();
            }
        })
        return false;
    })
}) */
/* new way to toggle different menu on the page */
/* function showPage(page){
    //hide all pages when one displays
    document.getElementById("dashboard").style.display = "none";
    // page.preventDefault();
    document.querySelectorAll('.displays').forEach(div =>{
        div.style.display = "none";
    });
    // $(`#${page}`).load(`admin.php #${page}`);
    // refreshDiv(page);
    document.querySelector(`#${page}`).style.display = "block";

}
//make links clickable to get to its respective page
document.addEventListener("DOMContentLoaded", function(){
    document.querySelectorAll(".page_navs").forEach(navs => {
        navs.onclick = function(){
            showPage(this.dataset.page);
            $("#paid_receipt").hide();
            // document.querySelector(".booth").style.display = "none";

        }
    })
}) */

//show pages dynamically with xhttp request
function showPage(page){
     let xhr = false;
     if(window.XMLHttpRequest){
          xhr = new XMLHttpRequest();
     }else{
          xhr = new ActiveXObject("Microsoft.XMLHTTP");
     }
     if(xhr){
          $(".contents").html("<div class='processing'><div class='loader'></div></div>");
          xhr.onreadystatechange = function(){
               if(xhr.readyState == 4 && xhr.status == 200){
                    document.querySelector(".contents").innerHTML = xhr.responseText;
               }
          }
          xhr.open("GET", page, true );
          xhr.send(null);
     }
}
/* refresh the div clicked */
/* function refreshDiv(theDiv){
    $(`#${theDiv}`).load(`admin.php #${theDiv}`);
} */
// display login on mobile
$(document).ready(function(){
    $("#mobile_log #loginDiv").click(function(){
        $("#mobile_log .login_option").toggle();
        // console.log("Working");
    }); 
});

/* display mobile menu */
function displayMenu(){
    let main_menu = document.getElementById("mobile_log");
    if(window.innerWidth <= "800"){
         $("#menu_icon").click(function(){
              if(main_menu.style.display == "block"){
                   $(".main_menu").hide();
                   $("#menu_icon").html("<a href='javascript:void(0)'><i class='fas fa-bars'></i></a>");
              }else{
                   $(".main_menu").show();
                   $("#menu_icon").html("<a href='javascript:void(0)'><i class='fas fa-close'></i></a>");
              }
         })
              
         
    }
    
}
displayMenu();
//checck the screen width 
function checkMobile(){
    let screen_width = window.innerWidth;
    if(screen_width <= "800"){
         // alert(screen_width);
         $("#contents").click(function(){
              $(".main_menu").hide();
              $("#menu_icon").html("<a href='javascript:void(0)'><i class='fas fa-bars'></i></a>");
         
         })
    }
}
checkMobile();
/* toggle inididvual menus */
$(document).ready(function(){
    $(".addMenu").click(function(){
        $(".nav1Menu").toggle();
        $(".nav2Menu").hide();
        $("#nav3Menu").hide();
        // $("#nav4Menu").hide();
    });
});

$(document).ready(function(){
    $(".addExh").click(function(){
        $(".nav2Menu").toggle();
        $(".nav1Menu").hide();
        $("#nav3Menu").hide();
        // $("#nav4Menu").hide();
    });
});
$(document).ready(function(){
    $(".guestMenu").click(function(){
        $(".nav3Menu").toggle();
        $(".nav2Menu").hide();
        $("#nav1Menu").hide();
        // $("#nav4Menu").hide();
    });
});
/* display mobile menu for backend*/
/* $(document).ready(function(){
    $(".menu_icon").click(function(){
        $("aside").toggle();
    });
    $("#contents").click(function(){
        $("aside").hide();
        
    })
}) */
$(document).ready(function(){
    $(".menu_icon").click(function(){
        $(".mobile_menu").toggle();
    });
    $("#contents").click(function(){
        $(".mobile_menu").hide();
        
    })
})



//display appointment form
$(document).ready(function(){
    $(".appointment").click(function(){
        $(".appointment_page").show();
    });
    $("#close").click(function(){
        $(".appointment_page").hide();
    })
})
//show item information
function showItems(item_id){
    window.open("item_info.php?item="+item_id, "_parent");
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

/* view slip */
function viewSlip(user){
    window.open("clearance.php?user="+user, "_blank");
    return;
}
/* view exhibitor */
function viewCompany(company){
    window.open("company_details.php?company="+company, "_blank");
    return;
}

//multiply item on shopping cart
/* function getCartTotal(){
    let itemTotal = document.getElementById("itemTotal").innerText;
    let discount = document.getElementById("discount").innerText;
    let delivery = document.getElementById("delivery").innerText;
    let grandTotal = document.getElementById("grandTotal");
    grandTotal.innerText = parseInt(itemTotal) + parseInt(discount) + parseInt(delivery);
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
 */
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

/* //display featured items on scroll
function displayFeatured(){
    if(document.body.scrollTop > 100 || document.documentElement.scrollTop > 100){
        document.getElementById("featured").style.display = "block";
    }else{
        document.getElementById("featured").style.display = "none";
    }
}
//display shop items on scroll
function displayAllItems(){
    if(document.body.scrollTop > 1000 || document.documentElement.scrollTop > 1000){
        document.getElementById("all_items").style.display = "block";
    }else{
        document.getElementById("all_items").style.display = "none";
    }
}
//display popular items on scroll
function displayPopular(){
    if(document.body.scrollTop > 500 || document.documentElement.scrollTop > 500){
        document.getElementById("popular").style.display = "block";
    }else{
        document.getElementById("popular").style.display = "none";
    }
}
 */
//display mission and vision on scroll
/* function displayMission(){
    if(document.body.scrollTop > 500 || document.documentElement.scrollTop > 500){
        document.getElementById("mission_vision").style.display = "block";
    }else{
        document.getElementById("mission_vision").style.display = "none";
    }
} */
$("document").ready(function(){
    $(".menu-icon").click(function(){
        $("#navigation").toggle();
    })
})
//display to top button{
function displayTotop(){
    if(document.body.scrollTop > 100 || document.documentElement.scrollTop > 100){
        document.querySelector(".toTop").style.display = "block";
    }else{
        document.querySelector(".toTop").style.display = "none";
    }
}

//view notification details
function viewNotification(notify_id){
    window.open("not_details.php?notify_id="+notify_id, "_parent");
    return;
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

/* show registration page on click of not a member */
function showForm(form){
    let pages = document.querySelectorAll(".reg_form form");
    pages.forEach(function(page){
        page.style.display = "none";
    })
    document.querySelector(`#${form}`).style.display = "block";
}
document.addEventListener("DOMContentLoaded", function(){
    let btns = document.querySelectorAll(".btns");
    btns.forEach(function(btn){
        btn.addEventListener("click", function(){
            showForm(this.dataset.form);
        })
    })
})

/* approve payments */
function approvePayment(user_id){
    let approve = confirm("Do you want to confirm this payment?", "");
    if(approve){
        $.ajax({
            type : "GET",
            url : "../controller/approve_payment.php?user="+user_id,
            success : function(response){
                $("#confirmPayment").html(response);
            }
        })
        setTimeout(function(){
            $("#confirmPayment").load("confirm_payment.php #confirmPayment");
        }, 2000);
        return false;
    }
}
/* decline payments */
function declinePayment(user_id){
    let approve = confirm("Do you want to decline this payment?", "");
    if(approve){
        $.ajax({
            type : "GET",
            url : "../controller/decline_payment.php?user="+user_id,
            success : function(response){
                $("#confirmPayment").html(response);
            }
        })
        setTimeout(function(){
            $("#confirmPayment").load("confirm_payment.php #confirmPayment");
        }, 2000);
        return false;
    }
}
/* approve exhibition payments */
function approveExhibitor(exh_id){
    let approve = confirm("Do you want to approve this payment?", "");
    if(approve){
        $.ajax({
            type : "POST",
            url :"../controller/approve_exhibitors.php?exhibitor="+exh_id,
            success : function(response){
                $("#approve_exhibitors").html(response);
            }
        })
        setTimeout(function(){
            $("#approve_exhibitors").load("confirm_exhibitor.php #approve_exhibitors");
        }, 2000);
    }
}
/* approve exhibition payments */
function declineExhibitor(exh_id){
    if(approve){
        $.ajax({
            type : "POST",
            url :"../controller/decline_exhibitors.php?exhibitor="+exh_id,
            success : function(response){
                $("#approve_exhibitors").html(response);
            }
        })
        setTimeout(function(){
            $("#approve_exhibitors").load("confirm_exhibitor.php #approve_exhibitors");
        }, 2000);
    }
}
/* approve hotel payment request */
function approveHotel(req_id){
    let approve = confirm("Do you want to confirm this payment?", "");
    if(approve){
        $.ajax({
            type : "GET",
            url : "../controller/approve_hotel_req.php?request="+req_id,
            success : function(response){
                $("#hotel_request").html(response);
            }
        })
        setTimeout(function(){
            $("#hotel_request").load("confirm_accomod.php #hotel_request");
        }, 2000);
        return false;
    }
}
/* decline hotel payment request */
function declineHotel(req_id){
    let approve = confirm("Do you want to decline this payment?", "");
    if(approve){
        $.ajax({
            type : "GET",
            url : "../controller/decline_hotel_req.php?request="+req_id,
            success : function(response){
                $("#hotel_request").html(response);
            }
        })
        setTimeout(function(){
            $("#hotel_request").load("confirm_accomod.php #hotel_request");
        }, 2000);
        return false;
    }
}
/* approve bulk request for hotel */
function approveBulk(req_id){
    let approve = confirm("Do you want to confirm this payment?", "");
    if(approve){
        $.ajax({
            type : "GET",
            url : "../controller/approve_bulk_req.php?request="+req_id,
            success : function(response){
                $("#bulk_request").html(response);
            }
        })
        setTimeout(function(){
            $("#bulk_request").load("confirm_bulk.php #bulk_request");
        }, 2000);
        return false;
    }
}
/* decline bulk request for hotel */
function declineBulk(req_id){
    let approve = confirm("Do you want to decline this payment?", "");
    if(approve){
        $.ajax({
            type : "GET",
            url : "../controller/decline_bulk_req.php?request="+req_id,
            success : function(response){
                $("#bulk_request").html(response);
            }
        })
        setTimeout(function(){
            $("#bulk_request").load("confirm_bulk.php #bulk_request");
        }, 2000);
        return false;
    }
}

/* approve onsite guest payments */
function approveGuest(user_id){
    let approve = confirm("Do you want to confirm this payment?", "");
    if(approve){
        $.ajax({
            type : "GET",
            url : "../controller/approve_guest.php?guest="+user_id,
            success : function(response){
                $("#confirmGuest").html(response);
            }
        })
        setTimeout(function(){
            $("#confirmGuest").load("approve_guest.php #confirmGuest");
        }, 2000);
        return false;
    }
}
/* approve guest payments */
function approvePaidGuest(user_id){
    let approve = confirm("Do you want to confirm this payment?", "");
    if(approve){
        $.ajax({
            type : "GET",
            url : "../controller/approve_paid_guest.php?guest="+user_id,
            success : function(response){
                $("#confirmGuest").html(response);
            }
        })
        setTimeout(function(){
            $("#confirmGuest").load("approve_paid_guests.php #confirmGuest");
        }, 2000);
        return false;
    }
}
/* decline payments */
function declineGuest(user_id){
    let approve = confirm("Do you want to decline this payment?", "");
    if(approve){
        $.ajax({
            type : "GET",
            url : "../controller/decline_guest.php?guest="+user_id,
            success : function(response){
                $("#confirmGuest").html(response);
            }
        })
        setTimeout(function(){
            $("#confirmGuest").load("confirm_guest.php #confirmGuest");
        }, 2000);
        return false;
    }
}
/* dispense item for admin */
function dispenseItem(order_id){
    let dispense = confirm("Are you sure you want to Dispense this item?", "");
    if(dispense){
        window.open("../controller/dispense_item.php?dispense="+order_id, "_parent");
        return;
    }
    
}
/* deactivate item */
function disableItem(item){
    let disable = confirm("Do you want to disable this item?");
    if(disable){
        $.ajax({
            type : "GET",
            url : "../controller/disable_item.php?item="+item,
            beforeSend : function(){
                $("#itemList").html("<div class='processing'><div class='loader'></div></div>");
            },
            success: function(response){
                $("#itemList").html(response);
                 setTimeout(function(){
                    showPage("item_list.php");
                }, 2000);
            }
        })
       
    }
}
/* activate item */
function activateItem(item){
    let disable = confirm("Do you want to enable this item?");
    if(disable){
        $.ajax({
            type : "GET",
            url : "../controller/activate_item.php?item="+item,
           beforeSend : function(){
                $("#itemList").html("<div class='processing'><div class='loader'></div></div>");
            },
            success: function(response){
                $("#itemList").html(response);
                 setTimeout(function(){
                    showPage("item_list.php");
                }, 2000);
            }
        })
       
    }
}
/* add featured item */
function makeFeatured(item){
    let disable = confirm("Do you want to Make this a featured item?");
    if(disable){
        $.ajax({
            type : "GET",
            url : "../controller/add_featured.php?item="+item,
            beforeSend : function(){
                $("#itemList").html("<div class='processing'><div class='loader'></div></div>");
            },
            success: function(response){
                $("#itemList").html(response);
                setTimeout(function(){
                    showPage("item_list.php");
                }, 1000);
            }
        })
        
    }
}
/* remove featured item */
function removeFeatured(item){
    let disable = confirm("Do you want to remove this item from featured list?");
    if(disable){
        $.ajax({
            type : "GET",
            url : "../controller/remove_featured.php?item="+item,
            beforeSend : function(){
                $("#itemList").html("<div class='processing'><div class='loader'></div></div>");
            },
            success: function(response){
                $("#itemList").html(response);
                setTimeout(function(){
                    showPage("item_list.php");
                }, 1000);
            }
        })
       
        return false;
    }
}
/* get item name */
function getItem(item){
    $.ajax({
        type : "GET",
        url : "../controller/get_item.php?item="+item,
        success: function(response){
            $(".info").html(response);
            window.scrollTo(0, 0);
        }
    })
    return false;
}

//edit item details
function editName(){
    let item = document.getElementById("item").value;
    let item_name = document.getElementById("item_name").value;
    let option = document.getElementById("option").value;
    let delivery = document.getElementById("delivery").value;
    let item_category = document.getElementById("item_category").value;
    let description = document.getElementById("description").value;
    let price = document.getElementById("price").value;
   /*  let first_foto = document.getElementById("first_foto").value;
    let second_foto = document.getElementById("second_foto").value; */
    if(item_name.length == 0 || item_name.replace(/^\s+|\s+$/g, "").length == 0){
        alert("Enter item name");
        $("#item_name").focus();
        return;
    }else if(delivery.length == 0 || delivery.replace(/^\s+|\s+$/g, "").length == 0){
        alert("PLease select delivery time");
        $("#delivery").focus();
        return;
    }else if(option.length == 0 || option.replace(/^\s+|\s+$/g, "").length == 0){
        alert("PLease select payment option");
        $("#option").focus();
        return;
    }else if(item_category.length == 0 || item_category.replace(/^\s+|\s+$/g, "").length == 0){
        alert("PLease select item category");
        $("#item_category").focus();
        return;
    }else if(parseFloat(price) <= 0){
        alert("PLease input item price");
        $("#price").focus();
        return;
    }else{
        var fd = new FormData();
        var files = $('#first_foto')[0].files[0];
        var files2 = $('#second_foto')[0].files[0];
        fd.append('first_foto',files);
        fd.append('second_foto',files2);
        fd.append('item',item);
        fd.append('item_name',item_name);
        fd.append('item_category',item_category);
        fd.append('price',price);
        fd.append('description',description);
        fd.append('option', option);
        fd.append('delivery',delivery);
        $.ajax({
            type : "POST",
            url : "../controller/edit_name.php",
            data: fd,
            contentType: false,
            processData: false,
            beforeSend : function(){
                $("#itemList").html("<div class='processing'><div class='loader'></div></div>");
            },
            success: function(response){
                if(response != 0){
                $("#itemList").html(response); 
                setTimeout(function(){
                    showPage("item_list.php");
                }, 1000);
                }else{
                    alert('files not uploaded');
                    return
                }
            },
        })
        
    }
}
//dispense item for users
function dispenseItemUser(order_id){
    let dispense = confirm("Are you sure you want to Dispense this item?", "");
    if(dispense){
        window.open("../controller/dispense_item_users.php?dispense="+order_id, "_parent");
        return;
    }
    
}
//cancel order
function cancelOrder(order_id){
    let cancel = confirm("Are you sure you want to Cancel this order?", "");
    if(cancel){
        window.open("../controller/cancel_order.php?cancel="+order_id, "_parent");
        return;
    }
    
}
//cancel order for users
function cancelOrderUser(order_id){
    let cancel = confirm("Are you sure you want to Cancel this order?", "");
    if(cancel){
        window.open("../controller/cancel_order_user.php?cancel="+order_id, "_parent");
        return;
    }
    
}
//download files to excel
function convertToExcel(table, title){
    $(`#${table}`).table2excel({
         filename: title
    });
}
/* authentication for whatsa number */
function checkNumber(id){
    if(id.length > 11){
        alert("The Number is too long");
        $(id).focus();
        return;
    }else if(id.length < 11){
        alert("The Number is too short");
        $(id).focus();
        return;
    }
}
/* add hotel without refresh */
function addHotel(){
    let hotel = document.getElementById("hotel").value;
    let website = document.getElementById("website").value;
    let hotel_address = document.getElementById("hotel_address").value;
    let contact_phone = document.getElementById("contact_phone").value;
    if(hotel.length == 0 || hotel.replace(/^\s+|\s+$/g, "").length == 0){
        alert("Please enter hotel name!");
        $("#hotel").focus();
        return;
   }else if(hotel_address.length == 0 || hotel_address.replace(/^\s+|\s+$/g, "").length == 0){
        alert("Please enter hotel address!");
        $("#hotel_address").focus();
        return;
   }else if(contact_phone.length == 0 || contact_phone.replace(/^\s+|\s+$/g, "").length == 0){
        alert("Please enter Phone numbers!");
        $("#contact_phone").focus();
        return;
   }else{
        $.ajax({
            type : "POST",
            url : "../controller/add_hotel.php",
            data : {hotel:hotel, website:website, hotel_address:hotel_address, contact_phone:contact_phone},
            success : function(response){
                $(".info").html(response);
            }
        })
        $("#hotel").val('');
        $("#website").val('');
        $("#hotel_address").val('');
        $("#contact_phone").val('');
        $("#hotel").focus();
        return false;
    }
}
/* add hall without refresh */
function addHall(){
    let hall = document.getElementById("hall").value;
    if(hall.length == 0 || hall.replace(/^\s+|\s+$/g, "").length == 0){
        alert("Please enter hall category!");
        $("#hall").focus();
        return;
    }else{
        $.ajax({
            type : "POST",
            url : "../controller/add_hall.php",
            data : {hall:hall},
            success : function(response){
                $(".info").html(response);
            }
        })
        $("#hall").val('');
        $("#hall").focus();
        return false;
    }
}
function addBooth(){
    let booth = document.getElementById("booth").value;
    let booth_hall = document.getElementById("booth_hall").value;
    let booth_price = document.getElementById("booth_price").value;
    if(booth_hall.length == 0 || booth_hall.replace(/^\s+|\s+$/g, "").length == 0){
        alert("Please select a booth");
        $("#booth_hall").focus();
        return;
    }else if(booth.length == 0 || booth.replace(/^\s+|\s+$/g, "").length == 0){
        alert("Please enter booth name");
        $("#booth").focus();
        return;
    }else if(booth_price.length == 0 || booth_price.replace(/^\s+|\s+$/g, "").length == 0){
        alert("Please enter booth price");
        $("#booth_price").focus();
    }else{
        $.ajax({
            type : "POST",
            url : "../controller/add_booth.php",
            data : {booth:booth, booth_hall:booth_hall, booth_price:booth_price},
            success : function(response){
                $(".info").html(response);
            }
        })
        $("#booth").val('');
        $("#booth_price").val('');
        $("#booth").focus();
        return false;
    }
}

/* show exhibition forms */
$(document).ready(function(){
    $("#exhBtn").click(function(){
        // alert("work");
        $("#exhibitors").show();
        $("#delegates").hide();
    })
})
/* show delegate */
$(document).ready(function(){
    $("#deleBtn").click(function(){
        // alert("work");
        $("#exhibitors").hide();
        $("#delegates").show();
    })
})
// alert("hello")

//search for data within table
function searchData(data){
    let $row = $(".searchTable tbody tr");
    let val = $.trim(data).replace(/ +/g, ' ').toLowerCase();
    $row.show().filter(function(){
         var text = $(this).text().replace(/\s+/g, ' ').toLowerCase();
         return !~text.indexOf(val);
    }).hide();
}
//search deliveries with date for admin
$(document).ready(function(){
    $("#search_date_admin").click(function(){
        let from_date_admin = document.getElementById('from_date_admin').value;
        let to_date_admin = document.getElementById('to_date_admin').value;
        
        //   alert(item + restaurant);
        $.ajax({
            type: "POST",
            url: "../controller/search_date_admin.php",
            data: {from_date_admin:from_date_admin, to_date_admin:to_date_admin},
            success: function(response){
                $(".new_data").html(response);
            }
        });
        /* $("#itemToDelete").focus();
        $("#itemToDelete").val(''); */
        return false;
    })

})
//search deliveries with date for users
$(document).ready(function(){
    $("#search_date").click(function(){
        let from_date = document.getElementById('from_date').value;
        let to_date = document.getElementById('to_date').value;
        
        //   alert(item + restaurant);
        $.ajax({
            type: "POST",
            url: "../controller/search_date.php",
            data: {from_date:from_date, to_date:to_date},
            success: function(response){
                $(".new_data").html(response);
            }
        });
        /* $("#itemToDelete").focus();
        $("#itemToDelete").val(''); */
        return false;
    })

})

//get item name from company select to add to featured
$(document).ready(function(){
    $("#featuredRestaurant").on('change', function(){
        let featuredRestaurant = $(this).val();
        // alert (featured_restaurant);
        if(featuredRestaurant){
            $.ajax({
                type: 'POST',
                url: '../controller/get_featured.php',
                data: {featuredRestaurant:featuredRestaurant},
                success: function(response){
                    $("#featuredItem").html(response);
                }
            })
            return false;
        }else{
            $("#featuredItem").html("<option value=''>Select company first</option>");
        }
    });
});
//add items to featured list without refresh
$(document).ready(function(){
    $("#add_feat").click(function(){
        let featuredRestaurant = document.getElementById('featuredRestaurant').value;
        let featuredItem = document.getElementById('featuredItem').value;
        // alert(featuredItem + featuredRestaurant);
        $.ajax({
            type: "POST",
            url: "../controller/add_featured.php",
            data: {featuredRestaurant:featuredRestaurant, featuredItem:featuredItem},
            success: function(response){
                $("#featuredTable").hide();
                $(".newTable").html(response);
                // $("#item_id").fade();
            }
        })
        $("#featuredItem").val('');
        return false;
    })
    
})
//get item id to remove from featured list
/* function removeFeatured(id){
    window.open("../controller/remove_featured.php?remove="+id, "_parent");
    return;
} */
/* setTimeout(function(){
    $(".main").show();
    $(".loader").hide();
}, 3000) */

// add events
function addEvent(){
    let event = document.getElementById("event").value;
    let venue = document.getElementById("venue").value;
    let event_date = document.getElementById("event_date").value;
    if(event.length == 0 || event.replace(/^\s+|\s+$/g, "").length == 0){
        alert("Please enter event title!");
        $("#event").focus();
        return;
   }else if(venue.length == 0 || venue.replace(/^\s+|\s+$/g, "").length == 0){
        alert("Please input event venue!");
        $("#venue").focus();
        return;
   }else if(event_date.length == 0 || event_date.replace(/^\s+|\s+$/g, "").length == 0){
        alert("Please input event date!");
        $("#event_date").focus();
        return;
   }else{
        $.ajax({
            type : "POST",
            url : "../controller/add_event.php",
            data : {event:event, venue:venue, event_date:event_date},
            success : function(response){
                $(".event_result").html(response);
            }
        })
        $("#event").val('');
        $("#event_date").val('');
        $("#venue").val('');
        $("#event").focus();
        return false;
    }
}
// add guest type
function addGuest(){
    let guest_type = document.getElementById("guest_type").value;
    let guest_fee = document.getElementById("guest_fee").value;
    
    $.ajax({
        type : "POST",
        url : "../controller/add_guest.php",
        data : {guest_type:guest_type, guest_fee:guest_fee},
        success : function(response){
            $(".guest_types").html(response);
        }
    })
    $("#guest_type").val('');
    $("#guest_fee").val('');
    $("#guest_type").focus();
    return false;
}

// view event attendnace
function viewMember(event){
    window.open("attendance.php?event="+event);
    return;
}
//get user to attend event
function getUser(user_id, event_id){
    let event = event_id;
    let user = user_id;
    if(user.length >= 3){
        $.ajax({
            type : "GET",
            url : "../controller/get_users.php?event="+event+"&user="+user,
            success : function(response){
                $(".users_result").html(response);
            }
        })
        return false;
    }else{
        return;
    }
}
//attend event
function attendEvent(event_id, user_id){
    let event = event_id;
    let user = user_id;
    if(user.length == 0 || user.replace(/^\s+|\s+$/g, "").length == 0){
        alert("Please enter barcode!");
        $("#user").focus();
        return;
    }else{
        if(user.length >= 6){
            $.ajax({
                type : "GET",
                url : "../controller/attend_event.php?event="+event+"&user="+user,
                success : function(response){
                    $(".user_info").html(response);
                }
            })
        }
    }
    /* setTimeout(function(){
        $("#events").load("events.php #events");
    }, 2000); */
    return false;
}
//onsite validation
function validate(user_id){
    // let event = event_id;
    let user = user_id;
    if(user.length == 0 || user.replace(/^\s+|\s+$/g, "").length == 0){
        alert("Please enter barcode or pcn!");
        $("#user").focus();
        return;
    }else{
        if(user.length >= 6){
            $.ajax({
                type : "GET",
                url : "../controller/onsite_validation.php?user="+user,
                success : function(response){
                    $(".user_info").html(response);
                }
            })
        }
    }
    /* setTimeout(function(){
        $("#events").load("events.php #events");
    }, 2000); */
    return false;
}
//print delegate tag
function printTag(pcn){
    window.open("../controller/print_tag.php?pcn="+pcn);
}

//print certificate
function printCertificate(id){
    window.open("../controller/print_certificate.php?id="+id);
}
//print delegate tags
function printAllTags(){
    window.open("../controller/download_tags.php");
}
//printe guest tags
function printGuestTags(){
    window.open("../controller/download_guest_tags.php");
}
//print exhibitors tags
function printExhTags(){
    window.open("../controller/download_exh_tags.php");
}
function printExhTag(ehxibitor){
    window.open("../controller/print_exh_tag.php?exhibitor="+ehxibitor);
}


/* get guest fee */
function getGuestFee(guest){
    let guest_type = guest;
    let country = document.getElementById("country");
    pcn = document.getElementById("pcn_number");
    if(guest_type){
    // alert(user_hotel);
        if(guest_type != 4){
            country.innerHTML = "<option value='Nigeria'>Nigeria</option>";
        }
        if(guest_type == 6){
            pcn.type = "text";
            document.querySelector("#guest_password label").style.display = "none";
            document.getElementById("user_password").type = "hidden";

        }else{
            pcn.type = "hidden";
            document.querySelector("#guest_password label").style.display = "block";
            document.getElementById("user_password").type = "password";
        }
        $.ajax({
            type : "POST",
            url : "../controller/get_guest_fee.php",
            data : {guest_type:guest_type},
            success: function(response){
                $("#price").html(response);
            }
        })
        return false;
    }else{
        return;
    }
}
//print guest tag
function printGuestTag(guest_id){
    window.open("../controller/print_guest_tag.php?guest="+guest_id);
}

//filter attendance
function filterAttendance(filter_value, url){
    let filter = filter_value;
    $.ajax({
        type : "POST",
        url : "../controller/"+url,
        data : {filter:filter},
        success : function(response){
            $(".filter_data").html(response);
        }
    })
    return false;
}

//filter regsitration
function filterRegistration(filter_value){
    let filter = filter_value;
    $.ajax({
        type : "POST",
        url : "../controller/filter_registration.php",
        data : {filter:filter},
        success : function(response){
            $("#filterResults").html(response);
        }
    })
    return false;
}

// random characters
const characters ='ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
//generate random characters
function generateString(length) {
    let result = ' ';
    const charactersLength = characters.length;
    for ( let i = 0; i < length; i++ ) {
        result += characters.charAt(Math.floor(Math.random() * charactersLength));
    }

    return result;
}
// vpay integration
function vpay(fee, user, user_email){
     transNum = generateString(10)+user
    const options = {
        amount: fee,
        currency: 'NGN',
        domain: 'live',
        key: '28e4f709-f24a-4903-b7a2-2f0434aee8ea',
        
email: user_email,
        transactionref: transNum,
        customer_logo:
'https://www.vpay.africa/static/media/vpayLogo.91e11322.svg',
        customer_service_channel: '+2348030007000, support@psnconference.org',
        txn_charge: 3,
        txn_charge_type: 'percentage',
        onSuccess: function(response) { alert('Payment Successful!',
response.message); 
        window.open("../controller/update_guest_status.php?user="+user+"&transref="+transNum, "_parent")
        return;
},
        onExit: function(response) { console.log('Hello World!',
response.message); }
    }
    
    if(window.VPayDropin){
        const {open, exit} = VPayDropin.create(options);
        open();                    
    }                
};
// onsite vpay integration
function onsiteVpay(fee, user, user_email){
     transNum = generateString(10)+user
    const options = {
        amount: fee,
        currency: 'NGN',
        domain: 'live',
        key: '28e4f709-f24a-4903-b7a2-2f0434aee8ea',
        
email: user_email,
        transactionref: transNum,
        customer_logo:
'https://www.vpay.africa/static/media/vpayLogo.91e11322.svg',
        customer_service_channel: '+2348030007000, support@psnconference.org',
        txn_charge: 3,
        txn_charge_type: 'percentage',
        onSuccess: function(response) { alert('Payment Successful!',
response.message); 
        window.open("../controller/update_onsite_reg.php?user="+user+"&transref="+transNum, "_parent")
        return;
},
        onExit: function(response) { console.log('Hello World!',
response.message); }
    }
    
    if(window.VPayDropin){
        const {open, exit} = VPayDropin.create(options);
        open();                    
    }
};

//submit survey form to data base
/* function submitSurvey(){

    let delegate = document.getElementById("delegate").value;
    let satisfaction = document.getElementById("satisfaction").value;
    let elements = document.getElementById("elements").value;
    let registration = document.getElementById("registration").value;
    let topics = document.getElementById("topics").value;
    let speakers = document.getElementById("speakers").value;
    if(satisfaction.length == 0 || satisfaction.replace(/^\s+|\s+$/g, "").length == 0){
        alert("Please select an option!");
        $("#satisfaction").focus();
        return;
   }else if(elements.length == 0 || elements.replace(/^\s+|\s+$/g, "").length == 0){
        alert("Please enter your response!");
        $("#elements").focus();
        return;
   }else if(registration.length == 0 || registration.replace(/^\s+|\s+$/g, "").length == 0){
        alert("Please enter your response!");
        $("#registration").focus();
        return;
   }else if(topics.length == 0 || topics.replace(/^\s+|\s+$/g, "").length == 0){
        alert("Please enter your response!");
        $("#topics").focus();
        return;
   }else if(speakers.length == 0 || speakers.replace(/^\s+|\s+$/g, "").length == 0){
        alert("Please select an option!");
        $("#speakers").focus();
        return;
   }else{
        $.ajax({
            type : "POST",
            url : "../controller/submit_survey.php",
            data : {delegate:delegate, satisfaction:satisfaction, registration:registration, elements:elements, topics:topics, speakers:speakers},
            success : function(response){
                $("#certificate").html(response);
            }
        })
        setTimeout(function(){
            $("#certificate").load("certificate.php #certificate");
        }, 2000)
        return false;
    }
} */
//submit survey to google form
function submitSurvey(user){
    window.open("../controller/submit_survey.php?user="+user, "_parent");
    return
    
}

//add exhibitors
function addExhibitor(){
    let company_name = document.getElementById("company_name").value;
    let company_address = document.getElementById("company_address").value;
    let company_phone = document.getElementById("company_phone").value;
    let contact_person = document.getElementById("contact_person").value;
    let designation = document.getElementById("designation").value;
    let contact_phone = document.getElementById("contact_phone").value;
    let company_email = document.getElementById("company_email").value;
    let staff_number = document.getElementById("staff_number").value;
    let booth_halls = document.getElementById("booth_halls").value;
    let booth_id = document.getElementById("booth_id").value;
    if(company_name.length == 0 || company_name.replace(/^\s+|\s+$/g, "").length == 0){
        alert("Please enter company name!");
        $("#company_name").focus();
        return;
   }else if(company_address.length == 0 || company_address.replace(/^\s+|\s+$/g, "").length == 0){
        alert("Please enter company_address!");
        $("#company-address").focus();
        return;
   }else if(company_phone.length == 0 || company_phone.replace(/^\s+|\s+$/g, "").length == 0){
        alert("Please enter company phone number!");
        $("#company_phone").focus();
        return;
   }else if(contact_person.length == 0 || contact_person.replace(/^\s+|\s+$/g, "").length == 0){
        alert("Please input contact person!");
        $("#contact_person").focus();
        return;
   }else if(designation.length == 0 || designation.replace(/^\s+|\s+$/g, "").length == 0){
        alert("Please select designation!");
        $("#designation").focus();
        return;
   }else if(contact_phone.length == 0 || contact_phone.replace(/^\s+|\s+$/g, "").length == 0){
        alert("Please input contact phone number!");
        $("#contact_phone").focus();
        return;
   }else if(company_email.length == 0 || company_email.replace(/^\s+|\s+$/g, "").length == 0){
        alert("Please input company email!");
        $("#company_email").focus();
        return;
   }else if(staff_number.length == 0 || staff_number.replace(/^\s+|\s+$/g, "").length == 0){
        alert("Please input number of staffs!");
        $("#staff_number").focus();
        return;
   }else if(booth_halls.length == 0 || booth_halls.replace(/^\s+|\s+$/g, "").length == 0){
        alert("Please select a hall!");
        $("#booth_hall").focus();
        return;
   }else if(booth_id.length == 0 || booth_id.replace(/^\s+|\s+$/g, "").length == 0){
        alert("Please select a booth!");
        $("#booth_hall").focus();
        return;
   }else{
        $.ajax({
            type : "POST",
            url : "../controller/reg_exhibitors.php",
            data : {company_name:company_name, company_email:company_email, company_address:company_address, company_phone:company_phone, contact_person:contact_person, contact_phone:contact_phone, designation:designation, staff_number:staff_number, booth_halls:booth_halls, booth_id:booth_id},
            success : function(response){
                $(".info").html(response);
            }
        })
        $("#company_name").focus();
        $("#company_name").val('');
        $("#company_phone").val('');
        $("#company_email").val('');
        $("#company_address").val('');
        $("#contact_person").val('');
        $("#contact_phone").val('');
        $("#designation").val('');
        $("#staff_number").val('');
        $("#booth_halls").val('');
        $("#booth_id").val('');
        return false;
    }
}
/* //display information
setTimeout(function(){
    document.getElementById("flashInfo").style.display = "block";
}, 10000); */
// close information
function closeInfo(){
    document.getElementById("flashInfo").style.display = "none";
}

//add departments
function addDepartment(){
    let department = document.getElementById("department").value;
    if(department.length == 0 || department.replace(/^\s+|\s+$/g, "").length == 0){
         alert("Please input category!");
         $("#department").focus();
         return;
    }else{
         $.ajax({
              type : "POST",
              url : "../controller/add_category.php",
              data : {department:department},
              success : function(response){
              $(".info").html(response);
              }
         })
    }
    $("#department").val('');
    $("#department").focus();
    return false;
}

// add items 
function addItem(){
    let company = document.getElementById("company").value;
    let item_category = document.getElementById("item_category").value;
    let item = document.getElementById("item").value;
    let item_price = document.getElementById("item_price").value;
    let payment_option = document.getElementById("payment_option").value;
    let delivery_time = document.getElementById("delivery_time").value;
    let item_foto = document.getElementById("item_foto").value;
    let other_foto = document.getElementById("other_foto").value;
    let item_desc = document.getElementById("item_desc").value;
    if(item_category.length == 0 || item_category.replace(/^\s+|\s+$/g, "").length == 0){
         alert("Please select item category!");
         $("#item_category").focus();
         return;
    }else if(item.length == 0 || item.replace(/^\s+|\s+$/g, "").length == 0){
         alert("Please enter item name");
         $("#item").focus();
         return;
    }else if(item_price.length == 0 || item_price.replace(/^\s+|\s+$/g, "").length == 0){
         alert("Please enter item price");
         $("#item_price").focus();
         return;
    }else if(payment_option.length == 0 || payment_option.replace(/^\s+|\s+$/g, "").length == 0){
         alert("Please select payment option");
         $("#payment_option").focus();
         return;
    }else if(delivery_time.length == 0 || delivery_time.replace(/^\s+|\s+$/g, "").length == 0){
         alert("Please select Delivery time frame");
         $("#delivery_time").focus();
         return;
    }else if(item_foto.length == 0 || item_foto.replace(/^\s+|\s+$/g, "").length == 0){
         alert("Please upload image");
         $("#item_foto").focus();
         return;
    }else if(other_foto.length == 0 || other_foto.replace(/^\s+|\s+$/g, "").length == 0){
         alert("Please upload second image");
         $("#other_foto").focus();
         return;
    }else{
         var fd = new FormData();
         var files = $('#item_foto')[0].files[0];
         var files2 = $('#other_foto')[0].files[0];
         fd.append('item_foto',files);
         fd.append('other_foto',files2);
         fd.append('item',item);
         fd.append('item_category',item_category);
         fd.append('item_price',item_price);
         fd.append('item_desc',item_desc);
         fd.append('payment_option',payment_option);
         fd.append('delivery_time',delivery_time);
         fd.append('company',company);
         $.ajax({
              url: '../controller/add_items.php',
              type: 'post',
              data: fd,
              contentType: false,
              processData: false,
              success: function(response){
                   if(response != 0){
                   $(".info").html(response); 
                   
                   }else{
                        alert('files not uploaded');
                        return
                   }
              },
         });
         
    }
    $("#item").val('');
    $("#item_price").val('');
    $("#delivery_time").val('');
    $("#payment_option").val('');
    $("#item_desc").val('');
    $("#item_foto").val('');
    $("#other_foto").val('');
    $("#item").focus();
    return false;    
}

//display any item form
function getForm(item, link){
    // alert(item_id);
    $.ajax({
         type : "GET",
         url : "../controller/"+link+"?item_id="+item,
         success : function(response){
              $(".info").html(response);
              window.scrollTo(0, 0);
         }
    })
    return false;

}

//close get details form
function closeForm(){
     
    $(".priceForm").hide();

}

//change product price
function changeItemPrice(){
    let item_id = document.getElementById("item_id").value;
    let sales_price = document.getElementById("sales_price").value;
    if(sales_price.length == 0 || sales_price.replace(/^\s+|\s+$/g, "").length == 0){
         alert("Please enter selling price!");
         $("#sales_price").focus();
         return;
    }else if(sales_price <= 0){
         alert("Prices can not be less than or  equal to 0");
         return;
    
    }else{
         $.ajax({
              type : "POST",
              url : "../controller/change_price.php",
              data: {item_id:item_id, sales_price:sales_price},
              success : function(response){
                   $("#edit_item_price").html(response);
              }
         })
         setTimeout(function(){
              $("#edit_item_price").load("item_price.php #edit_item_price");
         }, 1000);
         return false
    }
}

//dispense single items
function dispenseItem(order, invoice){
    let dispense = confirm("Are you sure you want to dispense this item?", "");
    if(dispense){
        $.ajax({
            type : "GET",
            url : "../controller/dispense_item.php?order="+order,
            success : function(response){
                $("#sales_details").html(response);
            }
        })
        setTimeout(function(){
            $("#sales_details").load("order_details.php?order="+invoice+ "#sales_details");
        }, 1000)
        return false;
    }
}
//cancel single order
function cancelOrder(order, invoice){
    let dispense = confirm("Are you sure you want to cancel this order?", "");
    if(dispense){
        $.ajax({
            type : "GET",
            url : "../controller/cancel_order.php?order="+order,
            success : function(response){
                $("#sales_details").html(response);
            }
        })
        setTimeout(function(){
            $("#sales_details").load("order_details.php?order="+invoice+ "#sales_details");
        }, 1000)
        return false;
    }
}
//dispense all items at once
function dispenseAll(invoice){
    let dispense = confirm("Are you sure you want to dispense all items?", "");
    if(dispense){
        $.ajax({
            type : "GET",
            url : "../controller/dispense_all.php?order="+invoice,
            success : function(response){
                $("#sales_details").html(response);
            }
        })
        setTimeout(function(){
            $("#sales_details").load("order_details.php?order="+invoice+ "#sales_details");
        }, 3000)
        return false;
    }
}

//cancel all orders
function cancelAllOrders(invoice){
    let dispense = confirm("Are you sure you want to cancel all orders?", "");
    if(dispense){
        $.ajax({
            type : "GET",
            url : "../controller/cancel_all.php?order="+invoice,
            success : function(response){
                $("#sales_details").html(response);
            }
        })
        setTimeout(function(){
            $("#sales_details").load("order_details.php?order="+invoice+ "#sales_details");
        }, 1000)
        return false;
    }
}
//confirm deliveries
function confirmDelivery(order){
    let dispense = confirm("Are you sure you want to confirm delivery for this item?", "");
    if(dispense){
        $.ajax({
            type : "GET",
            url : "../controller/confirm_delivery.php?order="+order,
            success : function(response){
                $("#deliveries").html(response);
            }
        })
        setTimeout(function(){
            $("#deliveries").load("confirm_delivery.php #deliveries");
        }, 1000)
        return false;
    }
}

//perform any type of search with just two date
function search(url){
    let from_date = document.getElementById('from_date').value;
    let to_date = document.getElementById('to_date').value;
    /* authentication */
    if(from_date.length == 0 || from_date.replace(/^\s+|\s+$/g, "").length == 0){
         alert("Please select a date!");
         $("#from_date").focus();
         return;
    }else if(to_date.length == 0 || to_date.replace(/^\s+|\s+$/g, "").length == 0){
         alert("Please select a date range!");
         $("#to_date").focus();
         return;
    }else{
         $.ajax({
              type: "POST",
              url: "../controller/"+url,
              data: {from_date:from_date, to_date:to_date},
              success: function(response){
              $(".new_data").html(response);
              }
         });
    }
    return false;
}


// update banner
function updateBanner(){
    let company = document.getElementById("company").value;
    let banners = document.getElementById("banners").value;
    let item_foto = document.getElementById("item_foto").value;
    if(banners.length == 0 || banners.replace(/^\s+|\s+$/g, "").length == 0){
         alert("Please select banner!");
         $("#banners").focus();
         return;
    }else if(item_foto.length == 0 || item_foto.replace(/^\s+|\s+$/g, "").length == 0){
         alert("Please upload image");
         $("#item_foto").focus();
         return;
    }else{
         var fd = new FormData();
         var files = $('#item_foto')[0].files[0];
         fd.append('item_foto',files);
         fd.append('banners',banners);
         fd.append('company',company);
         $.ajax({
              url: '../controller/update_banner.php',
              type: 'post',
              data: fd,
              contentType: false,
              processData: false,
              success: function(response){
                   if(response != 0){
                   $(".info").html(response); 
                   
                   }else{
                        alert('files not uploaded');
                        return
                   }
              },
         });
         
    }
    $("#banners").val('');
    $("#item_foto").val('');
    $("#banners").focus();
    return false;    
}

//get item to change details
function getItemDetails(item_name, url){
    let item = item_name;
    if(item.length >= 3){
         if(item){
              $.ajax({
                   type : "POST",
                   url :"../controller/"+url,
                   data : {item:item},
                   beforeSend : function(){
                    $("#sales_item").html("<p>Searching...</p>");
                   },
                   success : function(response){
                        $("#sales_item").html(response);
                   }
              })
              return false;
         }else{
              $("#sales_item").html("<p>Please enter atleast 3 letters</p>");
         }
    }
    
}

// update item photos
function updatePhoto(){
    let item = document.getElementById("item").value;
    let banners = document.getElementById("banners").value;
    let item_foto = document.getElementById("item_foto").value;
    if(banners.length == 0 || banners.replace(/^\s+|\s+$/g, "").length == 0){
         alert("Please select photo type!");
         $("#banners").focus();
         return;
    }else if(item_foto.length == 0 || item_foto.replace(/^\s+|\s+$/g, "").length == 0){
         alert("Please upload image");
         $("#item_foto").focus();
         return;
    }else{
         var fd = new FormData();
         var files = $('#item_foto')[0].files[0];
         fd.append('item_foto',files);
         fd.append('banners',banners);
         fd.append('item',item);
         $.ajax({
              url: '../controller/update_foto.php',
              type: 'post',
              data: fd,
              contentType: false,
              processData: false,
              success: function(response){
                   if(response != 0){
                   $("#update_foto").html(response); 
                   
                   }else{
                        alert('files not uploaded');
                        return
                   }
              },
         });
    }
    $("#banners").val('');
    $("#item_foto").val('');
    $("#banners").focus();
    setTimeout(function(){
        $("#update_foto").load("update_foto_form.php?item="+item+ "#update_foto");
     }, 1000);  
    return false;

}
// update password
function updatePassword(){
     let username = document.getElementById('username').value;
     let current_password = document.getElementById('current_password').value;
     let new_password = document.getElementById('new_password').value;
     let retype_password = document.getElementById('retype_password').value;
     /* authentication */
     if(current_password == 0 || current_password.replace(/^\s+|\s+$/g, "").length == 0){
          alert("Please enter current password");
          $("#current_password").focus();
          return;
     }else if(new_password == 0 || new_password.replace(/^\s+|\s+$/g, "").length == 0){
          alert("Please enter new password");
          $("#new_password").focus();
          return;
     }else if(new_password.length < 6){
          alert("New password must be greater or equal to 6 characters");
          $("#new_password").focus();
          return;
     }else if(retype_password == 0 || retype_password.replace(/^\s+|\s+$/g, "").length == 0){
          alert("Please retype new password");
          $("#retype_password").focus();
          return;
     }else if(new_password !== retype_password){
          alert("Passwords does not match!");
          $("#retype_password").focus();
          return;
     }else{
          $.ajax({
               type: "POST",
               url: "../controller/update_password.php",
               data: {username:username, current_password:current_password, new_password:new_password, retype_password:retype_password},
               beforeSend : function(){
                    $(".info").html("<div class='processing'><div class='loader'></div></div>");
               },
               success: function(response){
               $(".info").html(response);
               }
          });
     }
     return false;
}
// global/script.js
document.addEventListener("input", function(e) {
    if (e.target && e.target.id === "searchRoom") {
        const q = e.target.value.trim().toLowerCase();
        const table = document.querySelector("#data_table");
        if (!table) return;
        const tbody = table.querySelector("tbody");
        let visibleCount = 0;

        tbody.querySelectorAll("tr").forEach(row => {
            const tds = row.querySelectorAll("td");
            const category = tds[1]?.textContent.toLowerCase() || "";
            const item = tds[2]?.textContent.toLowerCase() || "";
            if (category.includes(q) || item.includes(q) || q === "") {
                row.style.display = "";
                visibleCount++;
            } else {
                row.style.display = "none";
            }
        });

        // "no results" message
        let noMsg = document.querySelector(".no_result_message");
        if (visibleCount === 0) {
            if (!noMsg) {
                noMsg = document.createElement("p");
                noMsg.className = "no_result_message";
                noMsg.textContent = "No matching results found.";
                noMsg.style.textAlign = "center";
                noMsg.style.marginTop = "10px";
                table.parentElement.appendChild(noMsg);
            }
        } else if (noMsg) {
            noMsg.remove();
        }
    }
});

//delete item
function deleteItem(item){
    let confirmdel = confirm("Are you sure you want to delete this item?", "");
    if(confirmdel){
        $.ajax({
            type : "GET",
            url : "../controller/delete_item.php?item="+item,
            beforeSend : function(){
                $("#itemList").html("<div class='processing'><div class='loader'></div></div>");
            },
            success : function(response){
                $("#itemList").html(response);
                setTimeout(function(){
                    showPage("item_list.php");
                }, 2000);
            }
        })
    }
    
}