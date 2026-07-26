<?php
    require "../controller/server.php";
    include "../admin/views/cache_control.php";
    session_start();
    $_SESSION['current_page'] = $_SERVER['REQUEST_URI'];
    if(isset($_SESSION['user'])){
        $user = $_SESSION['user'];
        $user_info = $connectdb->prepare("SELECT * FROM shoppers WHERE email = :email");
        $user_info->bindvalue('email', $user);
        $user_info->execute();
        $views = $user_info->fetchAll();
        foreach($views as $view){
            $full_name = $view->first_name. " ". $view->last_name;
            $id = $view->user_id;
        }
        $title = $full_name. " - Report product";
    }else{
        $title =  " | Report product";
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
<?php
            include "../head.php";
        ?>
    <link rel="stylesheet" href="../fontawesome-free-5.15.1-web/css/all.css">
    <link rel="icon" type="image/png" href="../images/logo.png" size="32X32">
    <link rel="stylesheet" href="../controller/style.css?v=<?php echo APP_VERSION?>">
    
</head>
<body>
    <style>
        .report-header{

text-align:center;

margin-bottom:40px;

}

.page-icon{

width:85px;

height:85px;

margin:auto;

border-radius:50%;

background:linear-gradient(135deg,#1674D5,#8DCE1F);

display:flex;

justify-content:center;

align-items:center;

color:#fff;

font-size:34px;

box-shadow:0 20px 40px rgba(22,116,213,.18);

}

.report-header h1{

margin:25px 0 10px;

font-size:34px;

color:#173D7A;

}

.report-header p{

color:#666;

max-width:650px;

margin:auto;

line-height:1.8;

}
.modern-report-card{

background:#fff;

padding:40px;

border-radius:22px;

box-shadow:0 20px 50px rgba(0,0,0,.08);

max-width:1200px;

margin:auto;

}
.form-group{

margin-bottom:25px;

}

.form-group label{

display:block;

margin-bottom:8px;

font-weight:600;

color:#333;

}

.form-group label i{

color:#1674D5;

margin-right:8px;

}

.input-box{

display:flex;

align-items:center;

border:1px solid #ddd;

border-radius:15px;

padding:0 15px;

transition:.3s;

background:#fff;

}

.input-box:focus-within{

border-color:#1674D5;

box-shadow:0 0 0 4px rgba(22,116,213,.12);

}

.input-box input,

.input-box select{

width:100%;

height:56px;

border:none;

outline:none;

background:none;

font-size:15px;

}
textarea{

width:100%;

border:1px solid #ddd;

border-radius:15px;

padding:18px;

resize:none;

transition:.3s;

font-size:15px;

}

textarea:focus{

border-color:#1674D5;

box-shadow:0 0 0 4px rgba(22,116,213,.12);

outline:none;

}
.report-btn{

width:100%;

height:60px;

border:none;

border-radius:16px;

background:linear-gradient(135deg,#1674D5,#8DCE1F);

color:#fff;

font-size:17px;

font-weight:600;

cursor:pointer;

transition:.35s;

display:flex;

justify-content:center;

align-items:center;

}

.report-btn:hover{

transform:translateY(-3px);

box-shadow:0 18px 40px rgba(22,116,213,.25);

}

.report-btn i{

margin-right:10px;

}

.btn-loader{

display:none;

}
.help-card{

margin-top:35px;

display:flex;

gap:20px;

padding:25px;

border-left:5px solid #1674D5;

background:#F8FAFD;

border-radius:16px;

}

.help-card i{

font-size:30px;

color:#1674D5;

}

.help-card h3{

margin-bottom:12px;

}

.help-card ul{

padding-left:18px;

}

.help-card li{

margin-bottom:8px;

color:#666;

}
    </style>
    <?php include "header.php";?>

    <?php include "mobile_menu.php";?>

    <main>
        <section id="help_center">
            <div class="report-header">

                <div class="page-icon">
                    <i class="fas fa-exclamation-circle"></i>
                </div>

                <h1>Report a Product</h1>

                <p>
                    Help us keep Rivicos safe and reliable.
                    Report suspicious, counterfeit or misleading products.
                </p>

            </div>

                <div class="modern-report-card">

                    <form action="../controller/report_issue.php" method="POST" enctype="multipart/form-data">
<div class="form-group">

<label>

<i class="fas fa-user"></i>

Full Name

</label>

<div class="input-box">

<input
type="text"
name="full_name"
placeholder="Enter your full name"
required>

</div>

</div>
<div class="form-group">

<label>

<i class="fas fa-phone"></i>

Phone Number

</label>

<div class="input-box">

<input
type="tel"
name="phone_number"
placeholder="08012345678"
required>

</div>

</div>
<div class="form-group">

<label>

<i class="fas fa-envelope"></i>

Email Address

</label>

<div class="input-box">

<input
type="email"
name="email_address"
placeholder="you@example.com"
required>

</div>

</div>
<div class="form-group">

<label>

<i class="fas fa-list"></i>

Reason

</label>

<div class="input-box">


<select name="reason" id="reason" required>
    <option value="" selected>Select a reason for your report</option>

    <optgroup label="Product Quality">
        <option value="Damaged or defective product">Damaged or Defective Product</option>
        <option value="Expired product">Expired Product</option>
        <option value="Poor product quality">Poor Product Quality</option>
        <option value="Wrong product received">Wrong Product Received</option>
        <option value="Missing item">Missing Item</option>
    </optgroup>

    <optgroup label="Product Information">
        <option value="Misleading product description">Misleading Product Description</option>
        <option value="Incorrect product image">Incorrect Product Image</option>
        <option value="Incorrect pricing">Incorrect Pricing</option>
        <option value="Incorrect product information">Incorrect Product Information</option>
    </optgroup>

    <optgroup label="Safety & Compliance">
        <option value="Counterfeit or fake product">Counterfeit or Fake Product</option>
        <option value="Prohibited or restricted product">Prohibited or Restricted Product</option>
        <option value="Health or safety concern">Health or Safety Concern</option>
    </optgroup>

    <optgroup label="Customer Experience">
        <option value="Late delivery">Late Delivery</option>
        <option value="Order not received">Order Not Received</option>
        <option value="Poor packaging">Poor Packaging</option>
        <option value="Rude customer service">Poor Customer Service</option>
    </optgroup>

    <optgroup label="Website Issues">
        <option value="Unable to place order">Unable to Place Order</option>
        <option value="Payment issue">Payment Issue</option>
        <option value="Website or app bug">Website or App Bug</option>
    </optgroup>

    <optgroup label="Other">
        <option value="Other">Other (Please specify)</option>
    </optgroup>

</select>

</div>

</div>
<div class="form-group">

<label>

<i class="fas fa-box"></i>

Product Name

</label>

<div class="input-box">

<input
type="text"
name="item_name"
placeholder="Product name">

</div>

</div>
<div class="form-group">

<label>

<i class="fas fa-comment-alt"></i>

Describe the Issue

</label>

<textarea

name="description"

placeholder="Explain the issue in detail..."

rows="6"

required>

</textarea>

</div>
<div class="form-group">

<label>

<i class="fas fa-camera"></i>

Attach Screenshot (Optional)

</label>

<div class="input-box">

<input
type="file"
name="product_image">

</div>

</div>
<button
class="report-btn"
type="submit"
name="send_report">

<span class="btn-text">

<i class="fas fa-paper-plane"></i>

Submit Report

</span>

<span class="btn-loader">

<i class="fas fa-spinner fa-spin"></i>

Sending...

</span>

</button>
                    </form>

                </div>
            </div>
            <div class="help-card">

<div>

<i class="fas fa-lightbulb"></i>

</div>

<div>

<h3>Tips for a Faster Review</h3>

<ul>

<li>Provide the correct product name.</li>

<li>Explain the issue clearly.</li>

<li>Avoid duplicate reports.</li>

<li>We'll investigate within 24–48 hours.</li>

</ul>

</div>

</div>
        </section>
        
    </main>
    <?php include "footer.php"?>
    <script src="../controller/jquery.js"></script>
    <script src="../controller/script.js"></script>
    
</body>
</html>
