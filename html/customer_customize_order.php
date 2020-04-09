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
        
        $sql = "UPDATE `customize_order` SET `is_canceled`= 1 WHERE `id` = {$itemId}";
        
        mysqli_query($conn, $sql);
        
        $sql = "UPDATE `customize_order_product` SET `is_deleted`= 1 WHERE `customize_order_id` = {$itemId}";
        
        mysqli_query($conn, $sql);
        
        header('Location: customer_customize_order.php');
    }
        
    if(isset($_GET['receivedOrderId'])){
        $orderId = $_GET['receivedOrderId'];
        $itemId = $_GET['receivedItem'];
        
        $sql = "UPDATE `customize_order` SET `is_received`= 1 WHERE `id` = {$orderId}";
        echo $sql;
        mysqli_query($conn, $sql);
        
        header('Location: customer_customize_order.php');
    }

    if(isset($_GET['removeItem'])){
        $itemId = $_GET['removeItem'];
        
        $sql = "UPDATE `customize_order` SET `is_deleted`= 1 WHERE `id` = {$itemId}";
        
        mysqli_query($conn, $sql);
        
        $sql = "UPDATE `customize_order_product` SET `is_deleted`= 1 WHERE `customize_order_id` = {$itemId}";
        
        mysqli_query($conn, $sql);
        
        header('Location: customer_customize_order.php');
    }
?>

<!DOCTYPE html>
<html>
<head>
    <!-- title -->
	<title>My Customize Order | DigiMart</title>
    
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
                    <li class="nav-item mx-5">
                        <a class="nav-link" href="customer_order.php">My Order</a>
                    </li>
                    <li class="nav-item active mx-5">
                        <a class="nav-link" href="customer_customize_order.php">My Customize Order</a>
                    </li>
                    <li class="nav-item mx-5">
                        <a class="nav-link" href="customer_message_center.php">Message Center <span class="badge badge-pill badge-danger"><?php if($unreadMsgCount!=0) echo $unreadMsgCount; ?></span></a>
                    </li>
                </ul>
            </div>
        </nav>
        
    </div>
    
    <div class="container">
        <h3 class="text-danger mb-3"><i class="fas fa-stream"></i> My Customize Order</h3>
        <table class="table <?php if(isset($_COOKIE['theme']) && ($_COOKIE['theme']=='dark')) echo "text-white table-dark"; ?>">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col" colspan="2">Order Details</th>
                    <th scope="col">Order Action</th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody>
                
                <?php
                
                    $i=1;
                
                    $query2 = "SELECT * FROM `customize_order` WHERE `customer_id` = '{$_SESSION['digimart_current_user_id']}' AND `is_deleted` = 0 ORDER BY `date_time` DESC";

                    $result = $conn->query($query2);
                
                    if (mysqli_num_rows($result) > 0) {
                        while ($row = $result->fetch_assoc()) {
                ?>
                
                
                <div id="accordion" class="mt-4">
                    <tr>
                        <th scope="row"><?php echo $i; ?></th>
                        <td>
                            <address>
                                <a class="text-secondary">Order ID: <b class="<?php if($row['is_canceled']!=0) echo "text-secondary"; else echo "text-danger"; ?>"><?php echo $row['id']; ?></b></a><br>
                                <a class="text-secondary">Order time: <b class="<?php if($row['is_canceled']!=0) echo "text-secondary"; else echo "text-danger"; ?>"><?php echo $row['date_time']; ?></b></a><br>
                                <a data-toggle="collapse" href="#collapse<?php echo $i; ?>"class='btn btn-outline-danger btn-sm'>More Details</a>
                            </address>
                        </td>
                        <td>
                            <address>
                                <a class="text-secondary">Unit Price: <b class="<?php if($row['is_canceled']!=0) echo "text-secondary"; else echo "text-danger"; ?>">LKR <?php echo number_format($row['unit_price'],2); ?></b></a><br>
                                <a class="text-secondary">Quentity: <b class="<?php if($row['is_canceled']!=0) echo "text-secondary"; else echo "text-danger"; ?>"><?php echo $row['quantity']; ?></b></a><br>
                                <a class="text-secondary">Order amount: <b class="<?php if($row['is_canceled']!=0) echo "text-secondary"; else echo "text-danger"; ?>">LKR <?php echo number_format($row['quantity']*$row['unit_price'],2); ?></b></a>
                            </address>
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
                                            echo "<a href='customer_customize_order.php?cancelOrder={$row['id']}' onclick=\"return confirm('Do you want to cancel this order?.');\" class='btn btn-outline-danger btn-sm'>Cancel Order</a>";
                                        } else {
                                            echo "<h6 class=''>Confirmed <i class='far fa-check-circle'></i></h6>";

                                            if($row['is_posted']==0){
                                                echo "<a class='text-secondary'>Not yet posted</a>";
                                            } else {
                                                echo "<h6 class=''>Posted <i class='fas fa-truck'></i></h6>";

                                                if($row['is_received']==0){
                                                    echo "<a class='text-secondary'>Not yet received</a>";
                                                    echo "<a href='customer_customize_order.php?receivedItem={$row['id']}&receivedOrderId={$row['id']}' onclick=\"return confirm('Do you received this item?.');\" class='btn btn-outline-danger btn-sm'>Received</a>";
                                                } else {
                                                    echo "<h6 class=''>Received <i class='far fa-handshake'></i></h6>";
                                                }
                                            }
                                        }
                                    }

                                ?>
                            </div>
                        </td>
                        <td class="d-flex justify-content-center">
                            <?php if(($row['is_canceled']!=0) || ($row['is_received']!=0)) echo "<a href='customer_customize_order.php?removeItem={$row['id']}' onclick=\"return confirm('This action will remove this item from your customize order list.');\" class='text-danger'><i class='far fa-trash-alt fa-lg'></i></a>"; ?>
                        </td>
                    </tr>
                    
                    <?php
                
                        $query3 = "SELECT p.`name`, p.`price`, ca.`type` FROM `customize_order_product` cu, `product` p, `category` ca WHERE cu.`product_id` = p.`id` AND ca.`id` = p.`category_id` AND cu.`customize_order_id` = {$row['id']}";

                        $result3 = $conn->query($query3);

                        while ($row3 = $result3->fetch_assoc()) {
                            
                    ?>
                    
                    <tr id="collapse<?php echo $i; ?>" class="collapse" data-parent="#accordion">
                        <td></td>
                        <td colspan="2"><a class="text-secondary"><?php echo $row3['type']; ?>: <b class="<?php if($row['is_canceled']!=0) echo "text-secondary"; else {if(isset($_COOKIE['theme']) && ($_COOKIE['theme']=='dark')) echo "text-white"; else echo "text-dark";} ?>"><?php echo $row3['name']; ?></b></a></td>
                        <td><a class="text-secondary">Unit Price: <b class="<?php if($row['is_canceled']!=0) echo "text-secondary"; else echo "text-danger"; ?>">LKR <?php echo number_format($row3['price'],2); ?></b></a></td>
                        <td></td>
                    </tr>
                    
                    <?php
                            
                        }
                    ?>
                    
                </div>
                
                
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