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
	<title>Sign In | DigiMart</title>
    
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
        
        
    </div>
    
    <?php
        require_once('footer.php');
    ?>
    
</body>
</html>