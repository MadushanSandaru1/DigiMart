<?php

    require_once('../connection/connection.php');

    session_start();

    date_default_timezone_set("Asia/Colombo");

    if(isset($_GET['theme'])){
        setcookie("theme", $_GET['theme'], time() + (86400 * 30), "/");
        header('Location: '.$_SERVER['PHP_SELF']);
    }

    $unreadMsgCount = 0;

    if(isset($_SESSION['digimart_current_user_id'])){
        
        $sql = "SELECT COUNT(*) AS 'unreadMsg' FROM `customer_message` WHERE `to` = 'digimart' AND `is_unread` = 1 AND `is_deleted` = 0";
        
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_assoc($result)) {
                $unreadMsgCount = $row['unreadMsg'];
            }
        }
    }

?>

<!DOCTYPE html>
<html>
<head>
    <!-- title -->
	<title>Manage DigiMart | DigiMart</title>
    
    <!-- title icon -->
    <link rel="icon" type="image/ico" href="../image/logo.png"/>
    
    <!-- Bootstrap CSS -->
    <link type="text/css" href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- CSS -->
    <link type="text/css" href="../css/navbar.css" rel="stylesheet">
    
    <!-- google font -->
    <link href='https://fonts.googleapis.com/css?family=Alata' rel='stylesheet'>
    <link href='https://fonts.googleapis.com/css?family=Atomic Age' rel='stylesheet'>
    <link href='https://fonts.googleapis.com/css?family=Abel' rel='stylesheet'>
    
    <!-- Fontawesome icons -->
    <script src="https://kit.fontawesome.com/faf1c6588d.js" crossorigin="anonymous"></script>

    <!-- jQuery -->
    <script src="../vendor/jquery/jquery-3.4.1.min.js"></script>
    <script src="../vendor/bootstrap/js/bootstrap.js"></script>
    
    <style>
        body {
            /*background-image: url('../image/back.gif');
            background-image: url('../image/back.png');*/
            <?php if(isset($_COOKIE['theme']) && ($_COOKIE['theme']=='dark'))echo "background-color: #404550"; ?>
        }
        
        .aboutDescription {
            background-color: rgba(221,18,60,0.1);
            font-family: 'Abel';
            font-size: 20px;
        }
        
        .sidebar {
            width: 200px;
            position: fixed;
            overflow: auto;
        }

        .sidebar a {
            text-decoration: none;
            color: #dd123d;
        }
        
        .sidebar a:hover:not(.active) {
            background-color: #dd123d;
            color: white;
        }

        div.content {
            margin-left: 220px;
            min-height: 500px;
        }
        
        @media screen and (max-width: 700px) {
            .sidebar {
                width: 100%;
                height: auto;
                position: relative;
                margin-bottom: 10px;
            }
            
            .sidebar a {
                float: left;
            }
            
            div.content {
                margin-left: 0;
            }
        }
        
        @media screen and (max-width: 400px) {
            .sidebar a {
                text-align: center;
                float: none;
            }
        }
        
        .form-control {
            border-color: #dd123d;
            color: #dd123d;
            background:none!important;
        }
        
        .form-control:focus {
            border-color: #dd123d;
            color: #dd123d;
        }
        
    </style>
    
    <script>
        $(document).ready(function(){
            $('[data-toggle="tooltip"]').tooltip();
        });
        
        function passwordVisible() {
            var x = document.getElementById("currentPassword");
            var y = document.getElementById("newPassword");
            var z = document.getElementById("confirmPassword");
            
            if (x.type === "password") {
                x.type = "text";
                y.type = "text";
                z.type = "text";
            } else {
                x.type = "password";
                y.type = "password";
                z.type = "password";
            }
        }
        
        $(document).ready(function(){
            $("#confirmPassword").keyup(function(){
                if ($("#newPassword").val() != $("#confirmPassword").val()) {
                    $("#match-msg").html("Password do not match").css("color","red");
                    $("#btnSubmitPassword").attr('disabled','disabled');
                }else{
                    $("#match-msg").html("Password matched").css("color","green");
                    $("#btnSubmitPassword").removeAttr('disabled');
                }
            });
        });
    </script>
    
    
</head>
    
<body>
    
    <?php
        require_once('digimart_header_half.php');
    ?>
    
    
    <div class="container-fluide">
        
        <nav class="navbar navbar-expand-lg <?php if(isset($_COOKIE['theme']) && ($_COOKIE['theme']=='dark'))echo "navbar-dark bg-dark"; else echo "navbar-light bg-light"; ?> my-3">
            <div class="collapse navbar-collapse d-flex justify-content-center" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item mx-5">
                        <a class="nav-link" href="digimart_account.php">My Account</a>
                    </li>
                    <li class="nav-item active mx-5">
                        <a class="nav-link" href="digimart_manage_digimart.php">Manage DigiMart</a>
                    </li>
                    <li class="nav-item mx-5">
                        <a class="nav-link" href="digimart_message_center.php">Message Center <span class="badge badge-pill badge-danger"><?php if($unreadMsgCount!=0) echo $unreadMsgCount; ?></span></a>
                    </li>
                </ul>
            </div>
        </nav>
        
    </div>
    
    <div class="container">
        <h3 class="text-danger mb-3"><i class="fas fa-tasks"></i> Manage DigiMart</h3>
        
        <div class="sidebar shadow-lg d-flex flex-column rounded-lg <?php if(isset($_COOKIE['theme']) && ($_COOKIE['theme']=='dark')) echo "bg-dark"; ?>">
            <a class="p-3" href="digimart_manage_digimart.php">Dashboard</a>
            
            <?php
                if($_SESSION['digimart_current_user_role'] == "admin"){
            ?>
            
            <a class="p-3" href="digimart_admin.php">Administratior</a>
            <a class="p-3" href="digimart_inventory_officer.php">Inventory Officer</a>
            <a class="p-3" href="digimart_customer.php">Customer</a>
            <a class="p-3" href="digimart_transactions_details.php">Transactions Details</a>
            
            <?php
                } elseif ($_SESSION['digimart_current_user_role'] == "inventory_officer") {
            ?>
            
            <a class="p-3" href="digimart_brand.php">Brand</a>
            <a class="p-3" href="digimart_category.php">Category</a>
            <a class="p-3" href="digimart_product.php">Product</a>
            <a class="p-3" href="digimart_order_details.php">Order Details</a>
            
            <?php
                }
            ?>
            
            <a class="p-3" href="digimart_contact_message.php">Contact Message</a>
        </div>
        
        <div class="content p-1 mb-5 rounded-lg shadow-lg <?php if(isset($_COOKIE['theme']) && ($_COOKIE['theme']=='dark')) echo "bg-dark"; ?>">
            <h4 class="text-danger mb-3"><i class="fab fa-buffer"></i> Dashboard</h4>
            <div class="row mw-100 p-5" id="product-container">
            
                <div class="py-3 col-md-6 col-sm-12 card border-danger text-center <?php if(isset($_COOKIE['theme']) && ($_COOKIE['theme']=='dark'))echo "text-white bg-dark"; ?>">
                    <div class="card-body">
                        <?php
                            
                            $countResult = 0;
                        
                            if($_SESSION['digimart_current_user_role'] == "admin"){
                                $countResultSql = "SELECT SUM(`unit_price`*`quantity`) AS 'countResult' FROM `order_product` WHERE `is_received` = 1 AND `is_canceled` = 0 AND `is_deleted` = 0 AND `date_time` LIKE '".date("Y-m")."%'";
                            } elseif ($_SESSION['digimart_current_user_role'] == "inventory_officer") {
                                $countResultSql = "SELECT COUNT(`id`) AS 'countResult' FROM `order_product` WHERE `date_time` LIKE '".date("Y-m-d")."%' AND `is_canceled` = 0 AND `is_deleted` = 0";
                            }
                            
                            
                        
                            $countResultResult = mysqli_query($conn, $countResultSql);

                            if (mysqli_num_rows($countResultResult) > 0) {
                                while($countResultRow = mysqli_fetch_assoc($countResultResult)) {
                                    $countResult = $countResultRow['countResult'];
                                }
                            }
                        ?>
                        
                        <?php
                            if($_SESSION['digimart_current_user_role'] == "admin"){
                        ?>
                        
                        <h5 class="card-title">Monthly Income</h5>
                        <h3 class="card-text">LKR <?php echo number_format($countResult, 2); ?></h3>
                        
                        <?php
                            } elseif ($_SESSION['digimart_current_user_role'] == "inventory_officer") {
                        ?>
                        
                        <h5 class="card-title">Orders received today</h5>
                        <h3 class="card-text"><?php echo $countResult; ?></h3>
                        
                        <?php
                            }
                        ?>
                        
                    </div>
                </div>
            
            </div>
            
        </div>

        
    </div>
    
    <?php
        require_once('footer.php');
    ?>
    
</body>
</html>