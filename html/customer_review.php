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

?>

<!DOCTYPE html>
<html>
<head>
    <!-- title -->
	<title>My Review | DigiMart</title>
    
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
                    <li class="nav-item active mx-5">
                        <a class="nav-link" href="customer_account.php">My Account</a>
                    </li>
                    <li class="nav-item mx-5">
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
        <h3 class="text-danger mb-3"><i class="far fa-user-circle"></i> My Account</h3>
        
        <div class="sidebar shadow-lg d-flex flex-column rounded-lg <?php if(isset($_COOKIE['theme']) && ($_COOKIE['theme']=='dark')) echo "bg-dark"; ?>">
            <a class="p-3" href="customer_account.php">My Account Setting</a>
            <a class="p-3" href="customer_review.php">My Review</a>
            <a class="p-3" href="customer_mail.php">My Mail Address</a>
            <a class="p-3" href="customer_payment.php">My Payment Card</a>
            <a class="p-3" href="customer_change_password.php">Change Password</a>
        </div>
        
        <div class="content p-1 mb-5 rounded-lg shadow-lg <?php if(isset($_COOKIE['theme']) && ($_COOKIE['theme']=='dark')) echo "bg-dark"; ?>">
            <h4 class="text-danger mb-3"><i class="far fa-star"></i> My Review</h4>
            <table class="table table-striped <?php if(isset($_COOKIE['theme']) && ($_COOKIE['theme']=='dark')) echo "text-white table-dark"; ?>">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Order Details</th>
                        <th scope="col">Feedback</th>
                    </tr>
                </thead>
                <tbody>

                    <?php

                        $i=1;

                        $query2 = "SELECT o.*, r.*, p.`name`, p.`image`  FROM `order_product` o, `product` p, `product_review` r WHERE o.`product_id` = p.`id` AND o.`customer_id` = '{$_SESSION['digimart_current_user_id']}' AND r.`product_id` = o.`product_id` AND r.`customer_id` = o.`customer_id` AND o.`is_received` = 1 AND o.`is_canceled` = 0 AND o.`is_deleted` = 0 ORDER BY o.`date_time` DESC";

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
                            <div class="d-flex flex-column text-danger">
                                <h6 class=''>
                                    <?php
                                        $rate = $row['review_value'];
                                        
                                        for($i=1;$i<6;$i++) {
                                            if($rate>=$i) {
                                                echo "<i class='fas fa-star fa-sm'></i>";
                                            }
                                            else {
                                                echo "<i class='far fa-star fa-sm'></i>";
                                            }
                                        }
                                    ?>
                                </h6>
                                <h6 class=''><?php echo $row['review_text']; ?></h6>
                            </div>
                        </td>
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