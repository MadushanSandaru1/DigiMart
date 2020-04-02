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

    if(isset($_GET['setDefault'])){
        $id = $_GET['setDefault'];
        
        $sql = "UPDATE `customer_mail_info` SET `is_default`= 0 WHERE `customer_id` = '{$_SESSION['digimart_current_user_id']}'";
        mysqli_query($conn, $sql);
        
        $sql = "UPDATE `customer_mail_info` SET `is_default`= 1 WHERE `customer_id` = '{$_SESSION['digimart_current_user_id']}' AND `id` = $id";
        mysqli_query($conn, $sql);
        
        header('Location: customer_mail.php');
    }

    if(isset($_POST['btnSubmit'])){
        $name = $_POST['mailName'];
        $street1 = $_POST['mailStreet1'];
        $street2 = $_POST['mailStreet2'];
        $city = $_POST['mailCity'];
        $zip = $_POST['mailZip'];
        $mobile = $_POST['mailMobile'];
        
        $sql = "INSERT INTO `customer_mail_info`(`customer_id`, `name`, `street_1`, `street_2`, `city`, `zip_code`, `mobile_no`) VALUES ('{$_SESSION['digimart_current_user_id']}', '{$name}', '{$street1}', '{$street2}', '{$city}', $zip, '{$mobile}')";
        
        mysqli_query($conn, $sql);
        
        header('Location: customer_mail.php');
    }

    if(isset($_GET['remove'])){
        $id = $_GET['remove'];
        $sql = "UPDATE `customer_mail_info` SET `is_deleted`= 1 WHERE `id` = '{$id}'";
        
        mysqli_query($conn, $sql);
        
        header('Location: customer_mail.php');
    }

?>

<!DOCTYPE html>
<html>
<head>
    <!-- title -->
	<title>My Mail Address | DigiMart</title>
    
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

        .dropDownLink a {
            text-decoration: none;
            color: #dd123d;
            border: 1px solid #dd123d;
            border-radius: 10px;
        }
        
        .dropDownLink a:hover:not(.active) {
            background-color: #dd123d;
            color: white;
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
            <h4 class="text-danger mb-3"><i class="far fa-address-card"></i> My Mail Address</h4>
            
            <div id="accordion" class="mt-4">
                <div class="m-3 <?php if(isset($_COOKIE['theme']) && ($_COOKIE['theme']=='dark')) echo "bg-dark"; ?>">
                    <div class="dropDownLink ml-4 mb-2">
                        <a class="py-2 px-5" data-toggle="collapse" href="#collapseOne">
                            Add Address
                        </a>
                    </div>
                    <div id="collapseOne" class="collapse" data-parent="#accordion">
                        <div class="row mw-100 p-2" id="product-container">

                            <div class="col-md-6 col-sm-12">
                                <div class="custom-control custom-checkbox">
                                    <form action="customer_mail.php" method="post">
                                        <div class="">
                                            <div class="form-group">
                                                <input type="text" class="form-control mailInput" maxlength="100" name="mailName" id="mailName" placeholder="NAME *" required>
                                            </div>
                                            <div class="form-group">
                                                <input type="text" class="form-control mailInput" maxlength="100" name="mailStreet1" id="mailStreet1" placeholder="STREET 1">
                                            </div>
                                            <div class="form-group">
                                                <input type="text" class="form-control mailInput" maxlength="100" name="mailStreet2" id="mailStreet2" placeholder="STREET 2">
                                            </div>
                                            <div class="form-group">
                                                <input type="text" class="form-control mailInput" maxlength="100" name="mailCity" id="mailCity" placeholder="CITY *" required>
                                            </div>
                                            <div class="form-group">
                                                <input type="number" class="form-control mailInput" maxlength="11" name="mailZip" id="mailZip" placeholder="ZIP CODE *" required>
                                            </div>
                                            <div class="form-group">
                                                <input type="text" class="form-control mailInput" maxlength="10" name="mailMobile" id="mailMobile" placeholder="MOBILE NO *" required>
                                            </div>
                                            <div class="form-group">
                                                <input type="submit" value="Add Address" class="btn btn-outline-danger paymentInput px-5" id="btnSubmit" name="btnSubmit">
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            
            <div class="row mw-100 p-2" id="product-container">
                <?php

                    $flag = 0;

                    $query2 = "SELECT * FROM `customer_mail_info` WHERE `customer_id` = '{$_SESSION['digimart_current_user_id']}' AND `is_deleted` = 0 ORDER BY `is_default` DESC";

                    $result = $conn->query($query2);

                    while ($row = $result->fetch_assoc()) {
                        $flag = 1;

                ?>

                <div class="">
                    <div class="col-12 d-flex pl-5" id="mailCard">
                        <div class="card border-danger m-2 <?php if(isset($_COOKIE['theme']) && ($_COOKIE['theme']=='dark'))echo "text-white bg-dark"; ?>">
                            <div class="card-header d-flex justify-content-between" id="card-header<?php echo $row['id']; ?>">
                                <label><?php if($row['is_default']==1) echo "<i class='far fa-bookmark'></i> Default Address"; else echo "<a class='text-danger' href='customer_mail.php?setDefault=".$row['id']."'>Set as default</a>"; ?></label>
                            </div>
                            <div class="card-body text-danger">
                                <h5 class="card-title"><?php echo $row['name']; ?></h5>
                                <address>
                                    <?php echo $row['street_1'].','; ?><br> 
                                    <?php echo $row['street_2'].','; ?><br>
                                    <?php echo $row['city'].'.'; ?><br>
                                    <?php echo $row['zip_code']; ?><br>
                                    <?php echo '<b>'.$row['mobile_no'].'</b>'; ?>
                                </address>
                                <div class="d-flex justify-content-end">
                                    <a href="customer_mail.php?remove=<?php echo $row['id']; ?>" class=" text-danger" data-toggle="tooltip" data-placement="bottom" title="Remove"><i class="far fa-trash-alt fa-lg"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <?php } ?>


            </div>
        </div>

        
    </div>
    
    <?php
        require_once('footer.php');
    ?>
    
</body>
</html>