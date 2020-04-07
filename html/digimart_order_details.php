<?php

    require_once('../connection/connection.php');

    session_start();

    date_default_timezone_set("Asia/Colombo");
    $alert = "";
    $alertStatus = 0;

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

    if(isset($_GET['postOrder'])){
        $itemId = $_GET['postOrder'];
        
        $sql = "UPDATE `order_product` SET `is_posted`= 1 WHERE `id` = {$itemId}";
        
        mysqli_query($conn, $sql);
        
        header('Location: digimart_order_details.php');
    }

    if(isset($_GET['deleteOrder'])){
        
        $itemId = $_GET['deleteOrder'];
        
        $sql = "UPDATE `order_product` SET `is_deleted`= 2 WHERE `id` = {$itemId}";
        
        mysqli_query($conn, $sql);
        
        header('Location: digimart_order_details.php');
    }

?>

<!DOCTYPE html>
<html>
<head>
    <!-- title -->
	<title>Order Details | DigiMart</title>
    
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
        
        .toastNotify {
            position: fixed;
            top: 10px;
            right: 10px;
            z-index: 1;
            border: 1px solid #dd123d;
            display: <?php if($alertStatus != 0) echo "block"; else echo "none"; ?>;
            
            -webkit-animation: cssAnimation 8s forwards; 
            animation: cssAnimation 8s forwards;
        }
        
        @keyframes cssAnimation {
            0%   {opacity: 1;}
            50%  {opacity: 0.7;}
            100% {opacity: 0;}
        }
        
        @-webkit-keyframes cssAnimation {
            0%   {opacity: 1;}
            50%  {opacity: 0.7;}
            100% {opacity: 0;}
        }
        
    </style>
    
    <script>
        $(document).ready(function(){
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>
    
    
</head>
    
<body>
    
    <div class="toastNotify <?php if(isset($_COOKIE['theme']) && ($_COOKIE['theme']=='dark'))echo "bg-dark"; else echo "bg-white"; ?> col-7 col-sm-6 col-md-4 col-lg-3" data-autohide="false">
        <div class="toast-header <?php if(isset($_COOKIE['theme']) && ($_COOKIE['theme']=='dark'))echo "bg-dark"; ?>">
            <strong class="mr-auto text-danger">Successful!</strong>
            <small class="text-muted"></small>
            <button type="button" class="ml-2 mb-1 close text-danger" data-dismiss="toast">&times;</button>
        </div>

        <div class="toast-body <?php if(isset($_COOKIE['theme']) && ($_COOKIE['theme']=='dark'))echo "text-white"; ?>">
            Data has been created.
        </div>
    </div>
    
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
            <h4 class="text-danger mb-3"><i class="fas fa-file-invoice-dollar"></i> Order Details</h4>
            
            <div class="row mw-100 p-2" id="product-container">
                
                <div class="col">
                    <a href="../report/tcpdf_lib/examples/order_report_format.php" target="_blank" class="btn btn-sm btn-outline-danger px-5 text-danger">Get Daily Order Report</a>
                </div>
            
            </div>
            
            
            <table class="table table-striped <?php if(isset($_COOKIE['theme']) && ($_COOKIE['theme']=='dark')) echo "text-white table-dark"; ?>">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Product</th>
                        <th scope="col">Product Action</th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <tbody>

                    <?php

                        $i=1;

                        $query2 = "SELECT o.*, p.`name`, p.`image`  FROM `order_product` o, `product` p WHERE o.`product_id` = p.`id` AND (o.`is_deleted` = 0 OR o.`is_deleted` = 1) ORDER BY o.`date_time` DESC";

                        $result = $conn->query($query2);

                        if (mysqli_num_rows($result) > 0) {
                            while ($row = $result->fetch_assoc()) {
                    ?>


                    <tr>
                        <th scope="row"><?php echo $i; ?></th>
                        <td>
                            <address>
                                <a class="text-secondary">Order ID: <b class="<?php if($row['is_canceled']!=0) echo "text-secondary"; else echo "text-danger"; ?>"><?php echo $row['id']; ?></b></a><br>
                                <a class="text-secondary">Order time: <b class="<?php if($row['is_canceled']!=0) echo "text-secondary"; else echo "text-danger"; ?>"><?php echo $row['date_time']; ?></b></a><br>
                                <a class="text-secondary">Ordered by: <b class="<?php if($row['is_canceled']!=0) echo "text-secondary"; else echo "text-danger"; ?>"><?php echo $row['customer_id']; ?></b></a>
                            </address>
                        </td>
                        <td>
                            <a class="text-secondary">Order amount: <b class="<?php if($row['is_canceled']!=0) echo "text-secondary"; else echo "text-danger"; ?>">LKR <?php echo number_format($row['quantity']*$row['unit_price'],2); ?></b></a>
                        </td>
                        <td class="d-flex justify-content-center">
                            <?php if(($row['is_canceled']!=0) || ($row['is_received']!=0)) echo "<a href='digimart_order_details.php?deleteOrder={$row['id']}' onclick=\"return confirm('This action will remove this item from order list.');\" class='text-danger'><i class='far fa-trash-alt fa-lg'></i></a>"; ?>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"></th>
                        <td class="d-flex justify-content-start">
                            <img src="../image/product/<?php echo $row['image']; ?>" width="110px;">
                            <div class="ml-3 d-flex flex-column">
                                <h6 class="<?php if($row['is_canceled']!=0) echo "text-secondary"; ?>"><?php echo $row['name']; ?></h6>
                                <a class="text-secondary">Product ID: <b class="<?php if($row['is_canceled']!=0) echo "text-secondary"; else echo "text-danger"; ?>"><?php echo $row['product_id']; ?></b></a>
                                <a class="text-secondary">Quentity: <b class="<?php if($row['is_canceled']!=0) echo "text-secondary"; else echo "text-danger"; ?>"><?php echo $row['quantity']; ?></b></a>
                                <a class="text-secondary">Unit price: <b class="<?php if($row['is_canceled']!=0) echo "text-secondary"; else echo "text-danger"; ?>">LKR <?php echo $row['unit_price']; ?></b></a>
                            </div>
                        </td>
                        <td>
                            <div class="d-flex flex-column">
                                <?php
                                    $date = date_create($row['date_time']);
                                    $date = date_format($date,"Y-m-d");

                                    if($row['is_canceled']!=0){
                                        echo "<a class='text-secondary'>Canceled <i class='far fa-times-circle'></i></a>";
                                    } else {
                                        if(date("Y-m-d")==$date){
                                            echo "<a class='text-secondary'>Not yet confirmed</a>";
                                        } else {
                                            echo "<h6 class=''>Confirmed <i class='far fa-check-circle'></i></h6>";

                                            if($row['is_posted']==0){
                                                echo "<a class='text-secondary'>Not yet posted</a>";
                                                echo "<a href='digimart_order_details.php?postOrder={$row['id']}' onclick=\"return confirm('This action will mark as this item order posted?..');\" class='btn btn-outline-danger btn-sm'>Post Order</a>";
                                            } else {
                                                echo "<h6 class=''>Posted <i class='fas fa-truck'></i></h6>";

                                                if($row['is_received']==0){
                                                    echo "<a class='text-secondary'>Not yet received</a>";
                                                } else {
                                                    echo "<h6 class=''>Received <i class='far fa-handshake'></i></h6>";
                                                }
                                            }
                                        }
                                    }

                                ?>
                            </div>
                        </td>
                        <td></td>
                    </tr>


                    <?php
                                $i++;
                            }
                        }

                    ?>

                </tbody>
            </table>
            
            
            
        </div>

        
    </div>
    
    <?php
        require_once('footer.php');
    ?>
    
</body>
</html>