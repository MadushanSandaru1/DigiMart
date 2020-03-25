<?php

    require_once('../connection/connection.php');

    session_start();

    date_default_timezone_set("Asia/Colombo");

    if(isset($_GET['currency'])){
        setcookie("currency_type", $_GET['currency'], time() + (86400 * 30), "/");
        header('Location: '.$_SERVER['PHP_SELF']);
    }

    if(isset($_GET['theme'])){
        setcookie("theme", $_GET['theme'], time() + (86400 * 30), "/");
        header('Location: '.$_SERVER['PHP_SELF']);
    }

    $unreadMsgCount = 0;

    if(isset($_SESSION['digimart_current_user_id'])){
        
        $sql = "SELECT COUNT(*) AS 'unreadMsg' FROM `customer_message` WHERE `to` = '{$_SESSION['digimart_current_user_id']}' AND `is_unread` = 1 AND `is_deleted` = 0";
        
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_assoc($result)) {
                $unreadMsgCount = $row['unreadMsg'];
            }
        }
    }

    if(isset($_GET['cancelOrder'])){
        $itemId = $_GET['cancelOrder'];
        
        $sql = "UPDATE `order_product` SET `is_canceled`= 1 WHERE `id` = {$itemId}";
        
        mysqli_query($conn, $sql);
        
        header('Location: customer_order.php');
    }
        
    if(isset($_GET['receivedItem'])){
        $itemId = $_GET['receivedItem'];
        
        $sql = "UPDATE `order_product` SET `is_received`= 1 WHERE `id` = {$itemId}";
        
        mysqli_query($conn, $sql);
        
        header('Location: customer_order.php');
    }

    if(isset($_GET['removeItem'])){
        $itemId = $_GET['removeItem'];
        
        $sql = "UPDATE `order_product` SET `is_deleted`= 1 WHERE `id` = {$itemId}";
        
        mysqli_query($conn, $sql);
        
        header('Location: customer_order.php');
    }
?>

<!DOCTYPE html>
<html>
<head>
    <!-- title -->
	<title>My Order | DigiMart</title>
    
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
        
        .display-4 {
            font-family: 'Atomic Age';
        }
        
    </style>
    
    <script>
        $(document).ready(function(){
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>
    
    
</head>
    
<body>
    
    <?php
        require_once('header_half.php');
    ?>
    
    
    <div class="container-fluide">
        
        <nav class="navbar navbar-expand-lg <?php if(isset($_COOKIE['theme']) && ($_COOKIE['theme']=='dark'))echo "navbar-dark bg-dark"; else echo "navbar-light bg-light"; ?> my-3">
            <div class="collapse navbar-collapse d-flex justify-content-center" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item mx-5">
                        <a class="nav-link" href="customer_account.php">My Account</a>
                    </li>
                    <li class="nav-item active mx-5">
                        <a class="nav-link" href="customer_order.php">My Order</a>
                    </li>
                    <li class="nav-item mx-5">
                        <a class="nav-link" href="customer_message_center.php">Message Center <span class="badge badge-pill badge-danger"><?php if($unreadMsgCount!=0) echo $unreadMsgCount; ?></span></a>
                    </li>
                </ul>
            </div>
        </nav>
        
    </div>
    
    <div class="container">
        <h3 class="text-danger mb-3"><i class="fas fa-stream"></i> My Order</h3>
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
                
                    $query2 = "SELECT o.*, p.`name`, p.`image`  FROM `order_product` o, `product` p WHERE o.`product_id` = p.`id` AND o.`customer_id` = '{$_SESSION['digimart_current_user_id']}' AND o.`is_deleted` = 0 ORDER BY o.`date_time` DESC";

                    $result = $conn->query($query2);
                
                    if (mysqli_num_rows($result) > 0) {
                        while ($row = $result->fetch_assoc()) {
                ?>
                
                
                <tr>
                    <th scope="row"><?php echo $i; ?></th>
                    <td>
                        <address>
                            <a class="text-secondary">Order ID: <b class="<?php if($row['is_canceled']!=0) echo "text-secondary"; else echo "text-danger"; ?>"><?php echo $row['id']; ?></b></a><br>
                            <a class="text-secondary">Order time: <b class="<?php if($row['is_canceled']!=0) echo "text-secondary"; else echo "text-danger"; ?>"><?php echo $row['date_time']; ?></b></a>
                        </address>
                    </td>
                    <td>
                        <a class="text-secondary">Order amount: <b class="<?php if($row['is_canceled']!=0) echo "text-secondary"; else echo "text-danger"; ?>">LKR <?php echo number_format($row['quantity']*$row['unit_price'],2); ?></b></a>
                    </td>
                    <td class="d-flex justify-content-center">
                        <?php if(($row['is_canceled']!=0) || ($row['is_received']!=0)) echo "<a href='customer_order.php?removeItem={$row['id']}' onclick=\"return confirm('This action will remove this item from your order list.');\" class='text-danger'><i class='far fa-trash-alt fa-lg'></i></a>"; ?>
                    </td>
                </tr>
                <tr>
                    <th scope="row"></th>
                    <td class="d-flex justify-content-start">
                        <img src="../image/product/<?php echo $row['image']; ?>" width="100px;">
                        <div class="ml-3 d-flex flex-column">
                            <h6 class="<?php if($row['is_canceled']!=0) echo "text-secondary"; ?>"><?php echo $row['name']; ?></h6>
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
                                        echo "<a href='customer_order.php?cancelOrder={$row['id']}' onclick=\"return confirm('Do you want to cancel this order?.');\" class='btn btn-outline-danger btn-sm'>Cancel Order</a>";
                                    } else {
                                        echo "<h6 class=''>Confirmed <i class='far fa-check-circle'></i></h6>";

                                        if($row['is_posted']==0){
                                            echo "<a class='text-secondary'>Not yet posted</a>";
                                        } else {
                                            echo "<h6 class=''>Posted <i class='fas fa-truck'></i></h6>";

                                            if($row['is_received']==0){
                                                echo "<a class='text-secondary'>Not yet received</a>";
                                                echo "<a href='customer_order.php?receivedItem={$row['id']}' onclick=\"return confirm('Do you received this item?.');\" class='btn btn-outline-danger btn-sm'>Received</a>";
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
    
    <?php
        require_once('footer.php');
    ?>
    
</body>
</html>