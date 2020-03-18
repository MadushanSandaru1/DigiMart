<?php

    //require_once('connection/connection.php');

    session_start();

    if(isset($_GET['currency'])){
        setcookie("currency_type", $_GET['currency'], time() + (86400 * 30), "/");
        header('Location: '.$_SERVER['PHP_SELF']);
    }

    if(isset($_GET['theme'])){
        setcookie("theme", $_GET['theme'], time() + (86400 * 30), "/");
        header('Location: '.$_SERVER['PHP_SELF']);
    }
?>

<!DOCTYPE html>
<html>
<head>
    <!-- title -->
	<title>Cart | DigiMart</title>
    
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
    
    <div class="container">
        
        <div class="mt-4">
            <h1 class="display-4 text-danger"><img src="../image/cart.png" width="60px"> Shopping Cart</h1>
        </div>
        
        
        
    </div>
    
    <div class="container-fluid mt-4">
        
        <?php
        
            if(isset($_SESSION['digimart_current_user_email'])) {
                
        ?>
        
        <div class="justify-content-center mb-2 p-5" style="height: 300px;">
            <h2 class="text-center">You don't have any items in your shopping cart. Let's get shopping!</h2>
            
            <div class="justify-content-center p-1 d-flex mt-4">
                <a href="../index.php" class="btn btn-outline-danger px-5">Start shopping</a>
            </div>
        </div>
        
        <?php
                
            }
            else {
                
        ?>
        
        <div class="justify-content-center mb-2 p-5" style="height: 300px;">
            <h2 class="text-center">You don't have any items in your shopping cart.</h2>
            <h3 class="text-center lead mt-4">Have an account? Sign in to see your items.</h3>
            
            <div class="justify-content-center p-1 d-flex mt-4">
                <a href="join.php" class="btn btn-danger px-5 mr-5">Join</a>
                <a href="sign_in.php" class="btn btn-outline-danger px-5">Sign In</a>
            </div>
        </div>
        
        <?php
            
            }
        ?>
        
    </div>
    
    <?php
        require_once('footer.php');
    ?>
    
</body>
</html>