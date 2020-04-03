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

    if(isset($_POST['btnSubmit'])){
        
        $firstName = $_POST['firstName'];
        $lastName = $_POST['lastName'];
        
        if($_SESSION['digimart_current_user_role'] == 'admin') {
            $sql = "UPDATE `admin` SET `first_name`= '{$firstName}', `last_name`= '{$lastName}' WHERE `id` = '{$_SESSION['digimart_current_user_id']}' AND `is_deleted` = 0";
        } else {
            $sql = "UPDATE `inventory_officer` SET `first_name`= '{$firstName}', `last_name`= '{$lastName}' WHERE `id` = '{$_SESSION['digimart_current_user_id']}' AND `is_deleted` = 0";
        }
        
        mysqli_query($conn, $sql);
        
        if($_SESSION['digimart_current_user_role'] == 'admin') {
            $sql = "SELECT * FROM `admin` WHERE `id` = '{$_SESSION['digimart_current_user_id']}' AND `is_deleted` = 0";
        } else {
            $sql = "SELECT * FROM `inventory_officer` WHERE `id` = '{$_SESSION['digimart_current_user_id']}' AND `is_deleted` = 0";
        }
        
        
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_assoc($result)) {
                $_SESSION['digimart_current_user_first_name'] = $row['first_name'];
                $_SESSION['digimart_current_user_last_name'] = $row['last_name'];
            }
        }
        
        $alert = "Name Changed.";
        $alertStatus = 1;
    }

    if(isset($_POST['btnSubmitPassword'])){
        
        $currentPwd = $_POST['currentPassword'];
        $newPwd = $_POST['newPassword'];
        
        $h_currentPwd = md5($currentPwd);
        $h_newPwd = md5($newPwd);
        
        $sql = "SELECT * FROM `user` WHERE `username` = '{$_SESSION['digimart_current_user_email']}' AND `password` = '{$h_currentPwd}' AND `is_deleted` = 0";
        
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) != 1) {
            $alert = "Current password is incorrect. Try agin.";
            $alertStatus = 2;
        } else {
            $sql = "UPDATE `user` SET`password`= '{$h_newPwd}' WHERE `username` = '{$_SESSION['digimart_current_user_email']}' AND `is_deleted` = 0";
            
            mysqli_query($conn, $sql);
            
            $alert = "Password changed.";
            $alertStatus = 1;
        }
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
        require_once('digimart_header_half.php');
    ?>
    
    
    <div class="container-fluide">
        
        <nav class="navbar navbar-expand-lg <?php if(isset($_COOKIE['theme']) && ($_COOKIE['theme']=='dark'))echo "navbar-dark bg-dark"; else echo "navbar-light bg-light"; ?> my-3">
            <div class="collapse navbar-collapse d-flex justify-content-center" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item active mx-5">
                        <a class="nav-link" href="digimart_account.php">My Account</a>
                    </li>
                    <li class="nav-item mx-5">
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
        <h3 class="text-danger mb-3"><i class="far fa-user-circle"></i> My Account</h3>
        
        <div class="sidebar shadow-lg d-flex flex-column rounded-lg <?php if(isset($_COOKIE['theme']) && ($_COOKIE['theme']=='dark')) echo "bg-dark"; ?>">
            <a class="p-3" href="digimart_account.php">My Account Setting</a>
            <a class="p-3" href="digimart_contact_message.php">Contact Message</a>
        </div>
        
        <div class="content p-1 mb-5 rounded-lg shadow-lg <?php if(isset($_COOKIE['theme']) && ($_COOKIE['theme']=='dark')) echo "bg-dark"; ?>">
            <h4 class="text-danger mb-3"><i class="fas fa-user-cog"></i> My Account Setting</h4>
            <div class="row mw-100 p-2" id="product-container">
                
                <div class="col-md-6 col-sm-12">
                        <div class="custom-control custom-checkbox">
                            <form action="digimart_account.php" method="post">
                                <div class="">
                                    <div class="form-group">
                                        <label for="userId" class="<?php if(isset($_COOKIE['theme']) && ($_COOKIE['theme']=='dark'))echo "text-white"; ?>">User Id</label>
                                        <input type="text" class="form-control"  name="userId" id="userId" value="<?php echo $_SESSION['digimart_current_user_id']; ?>" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="email" class="<?php if(isset($_COOKIE['theme']) && ($_COOKIE['theme']=='dark'))echo "text-white"; ?>">Email</label>
                                        <input type="email" class="form-control" name="email" id="email" value="<?php echo $_SESSION['digimart_current_user_email']; ?>" readonly>
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
                            
                        </div>
                    
                    </div>
                    
                    <div class="col-md-6 col-sm-12">
                        <div class="custom-control custom-checkbox">
                            <form action="digimart_account.php" method="post">
                                <div class="">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" onclick="passwordVisible()" name="mailRadio" id="showPwd">
                                        <label class="custom-control-label <?php if(isset($_COOKIE['theme']) && ($_COOKIE['theme']=='dark'))echo "text-white"; ?>" for="showPwd">Show Password</label>
                                    </div>
                                    <div class="form-group">
                                        <input type="password" class="form-control"  name="currentPassword" id="currentPassword" placeholder="CURRENT PASSWORD *" required>
                                    </div>
                                    <div class="form-group">
                                        <input type="password" class="form-control" name="newPassword" id="newPassword" placeholder="NEW  PASSWORD *" required>
                                    </div>
                                    <div class="form-group">
                                        <input type="password" class="form-control" name="confirmPassword" id="confirmPassword" placeholder="CONFIRM NEW  PASSWORD *" required>
                                        <small id="match-msg"></small>
                                    </div>
                                    <div class="form-group">
                                        <input type="submit" value="Change Password" class="btn btn-outline-danger paymentInput px-5" id="btnSubmitPassword" name="btnSubmitPassword" disabled>
                                    </div>
                                </div>
                            </form>
                            
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