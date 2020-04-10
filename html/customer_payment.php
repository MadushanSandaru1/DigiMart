<?php

    require_once('../connection/connection.php');

    session_start();

    date_default_timezone_set("Asia/Colombo");
    $alert = "";
    $alertStatus = 0;

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

    if(isset($_GET['remove'])){        
        $sql = "UPDATE `customer_payment_info` SET `is_deleted`= 1 WHERE `customer_id` = '{$_SESSION['digimart_current_user_id']}'";
        
        mysqli_query($conn, $sql);
        
        header('Location: customer_payment.php');
    }

    if(isset($_POST['btnSubmit'])){
        $cardNo = $_POST['cardNo'];
        
        $sql = "UPDATE `customer_payment_info` SET `card_no`= '{$cardNo}' WHERE `customer_id` = '{$_SESSION['digimart_current_user_id']}'";
        
        $result = mysqli_query($conn, $sql);

        if ($result) {
            //if data inserted, display tooltips message as Successful
            $alert = "Payment card updated";
            $alertStatus = 1;
        }
        else {
            //if data not inserted, display tooltips message as Unsuccessful
            $alert = "Payment card not updated";
            $alertStatus = 2;
        }
    }

?>

<!DOCTYPE html>
<html>
<head>
    <!-- title -->
	<title>My Payment Card | DigiMart</title>
    
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
            <strong class="mr-auto text-danger"><?php if($alertStatus == 1) echo "Successful !"; else echo "Unsuccessful !"; ?></strong>
            <small class="text-muted"></small>
            <button type="button" class="ml-2 mb-1 close text-danger" data-dismiss="toast">&times;</button>
        </div>

        <div class="toast-body <?php if(isset($_COOKIE['theme']) && ($_COOKIE['theme']=='dark'))echo "text-white"; ?>">
            <?php echo $alert; ?>
        </div>
    </div>
    
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
        <h3 class="text-danger mb-3"><i class="far fa-user-circle"></i> My Account</h3>
        
        <div class="sidebar shadow-lg d-flex flex-column rounded-lg <?php if(isset($_COOKIE['theme']) && ($_COOKIE['theme']=='dark')) echo "bg-dark"; ?>">
            <a class="p-3" href="customer_account.php">My Account Setting</a>
            <a class="p-3" href="customer_review.php">My Review</a>
            <a class="p-3" href="customer_mail.php">My Mail Address</a>
            <a class="p-3" href="customer_payment.php">My Payment Card</a>
            <a class="p-3" href="customer_change_password.php">Change Password</a>
        </div>
        
        <div class="content p-1 mb-5 rounded-lg shadow-lg <?php if(isset($_COOKIE['theme']) && ($_COOKIE['theme']=='dark')) echo "bg-dark"; ?>">
            <h4 class="text-danger mb-3"><i class="far fa-credit-card"></i> My Payment Card</h4>
            <div class="row mw-100 p-2" id="product-container">

                <?php

                    $flag = 0;

                    $query2 = "SELECT * FROM `customer_payment_info` WHERE `customer_id` = '{$_SESSION['digimart_current_user_id']}' AND `is_deleted` = 0";

                    $result = $conn->query($query2);

                    while ($row = $result->fetch_assoc()) {
                        $flag = 1;

                ?>

                <div class="col-md-6 col-sm-12 mb-4">
                    <div class="card border-danger <?php if(isset($_COOKIE['theme']) && ($_COOKIE['theme']=='dark'))echo "text-white bg-dark"; ?>">
                        <div class="card-body text-danger">
                            <h5 class="card-title" id="bankCardNo"><?php echo $row['card_no']; ?></h5>
                            <img src="../image/paymentMethod.png" width="100px">
                        </div>
                        <div class="card-body d-flex justify-content-end">
                            <a href="customer_payment.php?remove=1" class=" text-danger" data-toggle="tooltip" data-placement="bottom" title="Remove"><i class="far fa-trash-alt fa-lg"></i></a>
                        </div>
                    </div>
                </div>

                <?php } ?>

                <div class="col-md-6 col-sm-12">
                    <div class="custom-control custom-checkbox">
                        <div id="paymentAnotherDiv">
                            <form action="customer_payment.php" method="post">
                                <div class="form-group">
                                    <input type="text" class="form-control paymentInput" maxlength="25" name ="cardName" id="cardName" placeholder="CARD HOLDER NAME *" required>
                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control paymentInput" maxlength="20" name ="cardNo" id="cardNo" placeholder="CARD NUMBER *" required>
                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control paymentInput" maxlength="5" name ="cardExp" id="cardExp" placeholder="EXPIRES *" required>
                                </div>
                                <div class="form-group">
                                    <input type="number" class="form-control paymentInput" name ="cardCvv" id="cardCvv" placeholder="CVV *" required>
                                </div>
                                <div class="form-group">
                                    <input type="submit" value="<?php if($flag==1) echo "Change Card"; else echo "Add Card"; ?>" class="btn btn-outline-danger paymentInput px-5" id="btnSubmit" name="btnSubmit">
                                </div>
                            </form>
                        </div>
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