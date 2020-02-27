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
	<title>Home | DigiMart</title>
    
    <!-- title icon -->
    <link rel="icon" type="image/ico" href="image/logo.png"/>
    
    <!-- Bootstrap CSS -->
    <link type="text/css" href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- CSS -->
    <link type="text/css" href="css/navbar.css" rel="stylesheet">
    <link type="text/css" href="css/main.css" rel="stylesheet">
    
    <!-- google font -->
    <link href='https://fonts.googleapis.com/css?family=Abel' rel='stylesheet'>
    <link href='https://fonts.googleapis.com/css?family=Eagle Lake' rel='stylesheet'>
    <link href='https://fonts.googleapis.com/css?family=ABeeZee' rel='stylesheet'>
    
    <!-- Fontawesome icons -->
    <script src="https://kit.fontawesome.com/faf1c6588d.js" crossorigin="anonymous"></script>

    <!-- jQuery -->
    <script src="vendor/jquery/jquery-3.4.1.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.js"></script>
    
    <style>
        body {
            /*background-image: url('image/back.gif');
            background-image: url('image/back.png');*/
            <?php if(isset($_COOKIE['theme']) && ($_COOKIE['theme']=='dark'))echo "background-color: #404550"; ?>
        }
        
        .sidebar-item {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            
            /* Position the items */
            // &:nth-child(2) { top: 25%; }
            // &:nth-child(3) { top: 50%; }
            // &:nth-child(4) { top: 75%; }
        }
        
        .make-me-sticky {
            position: -webkit-sticky;
            position: sticky;
            top: 0;
            border-radius: 10px;
        }
        
        .content-section h2 {
            padding-top: 200px;
        }
        
        #categoryList a {
            font-family: 'Abel';
            font-size: 20px;
        }
        
        #categoryList tr {
            background-color: #dd123d;
        }
        
        .categoryTopic {
            font-family: 'ABeeZee';
        }
    
    </style>
    
    <script>
        $(document).ready(function(){
            $('[data-toggle="tooltip"]').tooltip();
        });
        
        $(document).ready(function(){
            $("#categorySearch").on("keyup", function() {
                var value = $(this).val().toLowerCase();
                $("#categoryList tr").filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
            });
        });
    </script>
    
    
</head>
    
<body>
    
    <?php
        require_once('html/header_full.php');
    ?>
    
    <div class="container-fluid vh-100">
        <div class="row p-4">
            <div class="col-3">
                <div class="sidebar-item">
                    <div class="make-me-sticky p-3 shadow-sm">
                        <h5 class="categoryTopic"><i class="fas fa-list"></i> Categories</h5>
                        <hr>
                        <input class="form-control form-control-sm" id="categorySearch" type="text" placeholder="Search...">
                        <table class="w-100">
                            <tbody id="categoryList">
                                <tr>
                                    <td><a href="#" class="text-secondary"><i class="fas fa-laptop"></i> Laptops</a></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            
            <div class="col-9">
                <div class="content-section bg-secondary">
                    <h2>Content Section</h2>
                </div>
            </div>
        </div>
    </div>
    
    <?php
        require_once('html/footer.php');
    ?>
    
</body>
</html>