<?php

    require_once('../connection/connection.php');

    session_start();

    date_default_timezone_set("Asia/Colombo");
    $alert = "";
    $alertStatus = "none";

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

    if(isset($_POST['btnSubmit'])){
        
        $firstName = $_POST['firstName'];
        $lastName = $_POST['lastName'];
        
        $sql = "UPDATE `customer` SET `first_name`= '{$firstName}', `last_name`= '{$lastName}' WHERE `id` = '{$_SESSION['digimart_current_user_id']}' AND `is_deleted` = 0";
        
        mysqli_query($conn, $sql);
        
        $sql = "SELECT * FROM `customer` WHERE `id` = '{$_SESSION['digimart_current_user_id']}' AND `is_deleted` = 0";
        
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_assoc($result)) {
                $_SESSION['digimart_current_user_first_name'] = $row['first_name'];
                $_SESSION['digimart_current_user_last_name'] = $row['last_name'];
            }
        }
        
        $alert = "Changed";
        $alertStatus = "block";
    }

?>

<!DOCTYPE html>
<html>
<head>
    <!-- title -->
	<title>My Account | DigiMart</title>
    
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
            <h4 class="text-danger mb-3"><i class="fas fa-user-cog"></i> My Account Setting</h4>
            <div class="row mw-100 p-2" id="product-container">
                
                <div class="col-12">
                    <div class="col-md-6 col-sm-12">
                        <div class="custom-control custom-checkbox">
                            <form action="customer_account.php" method="post">
                                <div class="">
                                    <div class="form-group">
                                        <label for="userId" class="<?php if(isset($_COOKIE['theme']) && ($_COOKIE['theme']=='dark'))echo "text-white"; ?>">User Id</label>
                                        <input type="text" class="form-control"  name="userId" id="userId" value="<?php echo $_SESSION['digimart_current_user_id']; ?>" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="email" class="<?php if(isset($_COOKIE['theme']) && ($_COOKIE['theme']=='dark'))echo "text-white"; ?>">Email</label>
                                        <input type="email"class="form-control" name="email" id="email" value="<?php echo $_SESSION['digimart_current_user_email']; ?>" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="firstName" class="<?php if(isset($_COOKIE['theme']) && ($_COOKIE['theme']=='dark'))echo "text-white"; ?>">First Name</label>
                                        <input type="text" class="form-control" name="firstName" id="firstName" value="<?php echo $_SESSION['digimart_current_user_first_name']; ?>" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="lastName" class="<?php if(isset($_COOKIE['theme']) && ($_COOKIE['theme']=='dark'))echo "text-white"; ?>">Last Name</label>
                                        <input type="text" class="form-control" name="lastName" id="lastName" value="<?php echo $_SESSION['digimart_current_user_last_name']; ?>" required>
                                    </div>
                                    <div class="form-group">
                                        <input type="submit" value="Change Name" class="btn btn-outline-danger paymentInput px-5" id="btnSubmit" name="btnSubmit">
                                    </div>
                                </div>
                            </form>
                            
                            <div class="alert alert-danger" role="alert" style="display:<?php echo $alertStatus; ?>;">
                                <?php echo $alert; ?>
                            </div>
                            
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