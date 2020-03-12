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
	<title>About | DigiMart</title>
    
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
            <h1 class="display-4 text-danger"><img src="../image/about.png" width="60px"> About</h1>
        </div>
        
        <!--Carousel Wrapper-->
        <div id="carousel-example-2" class="carousel slide carousel-fade z-depth-1-half" data-ride="carousel">
            <!--Slides-->
            <div class="carousel-inner" role="listbox">
                <div class="carousel-item active">
                    <div class="view">
                        <img class="d-block w-100" src="../image/carousel/1.jpg" alt="First slide">
                        <div class="mask rgba-black-light"></div>
                    </div>
                </div>
                <div class="carousel-item">
                    <!--Mask color-->
                    <div class="view">
                        <img class="d-block w-100" src="../image/carousel/2.jpg" alt="Second slide">
                        <div class="mask rgba-black-light"></div>
                    </div>
                </div>
                <div class="carousel-item">
                    <!--Mask color-->
                    <div class="view">
                        <img class="d-block w-100" src="../image/carousel/3.jpg" alt="Third slide">
                        <div class="mask rgba-black-light"></div>
                    </div>
                </div>
                <div class="carousel-item">
                    <!--Mask color-->
                    <div class="view">
                        <img class="d-block w-100" src="../image/carousel/4.jpg" alt="Fourth slide">
                        <div class="mask rgba-black-light"></div>
                    </div>
                </div>
            </div>
            <!--/.Slides-->
            <!--Controls-->
            <a class="carousel-control-prev" href="#carousel-example-2" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#carousel-example-2" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
            <!--/.Controls-->
        </div>
        <!--/.Carousel Wrapper-->
        
    </div>
    
    <div class="container-fluid aboutDescription mt-4">
        <div class="container pt-5 pb-4">
            <p class="text-justify <?php if(isset($_COOKIE['theme']) && ($_COOKIE['theme']=='dark'))echo "text-light"; ?>">
                
                &emsp;&emsp;&emsp;&emsp;Established in 2008, Nanotek Computer Solutions has strived to be one of the leading retailers for branded &amp; customizable computers and related products in today’s market. Our many years of experience has provided us with the expertise to cater you; our valued customers with the latest technology, while providing an excellent service that would culminate in providing you the best available products. Nanotek Computer Solutions has always been the stable backdrop for many PC enthusiasts in the face of rising enthusiasm for high-end computer gaming and custom-built PCs. Thus, enabling the dreams of making one's own computer that would fit all of one's needs come true.
                
                <br><br>
                
                &emsp;&emsp;&emsp;&emsp;We believe in your passion, as fellow PC enthusiasts, we would be more than glad to provide you with any assistance when you're looking for branded computer solutions. If you visit our store, it would be possible for you to see for yourself the latest products that we have in our showroom, sourced from the international market.  We specialize in making available the latest technology as soon as it is released worldwide. In fact, you would be able to observe that most products on our shelves are less than 30 days old! It is this quality and the service that has earned Nanotek Computer Solutions the untarnished reputation that it has had throughout the years.
                
                <br><br>
                
                &emsp;&emsp;&emsp;&emsp;Whether you're building your own gaming PC or hoping to upgrade the computer you have for your desired purpose, Nanotek Computer Solutions has the ability to offer you the ideal solution that will meet your expectations. The premium hardware that we offer would be of outstanding quality and the brands that we choose would speak for themselves. We give you not only the ability to be exposed to such high-end hardware, but also ensure that we offer them at reasonable prices. It is our thought that every individual who has the passion for high-end computers deserves to experience great high-end hardware. With the latest computer products brought from the top-grade brands all over the world, we promise you on delivering the best available options for your dream gaming rig.
                
                <br><br>
                
                &emsp;&emsp;&emsp;&emsp;We have understood what it means to be trusted by thousands of customers, and we intend on keeping that trust by continuing to provide you with the best products for affordable prices. We make it our responsibility to attend to your requirements of structuring the ideal PC for you. The personalized experience that you can have at Nanotek as a customer is unparalleled. The business owners are also actively involved in providing advice to choose and customize your ideal computer. Our fervent hope would be to let you have the best product for the budget at your hand, and we know that our direct involvement in letting you have a wider understanding on the products would contribute to this greatly.
                
                <br><br>
                
                &emsp;&emsp;&emsp;&emsp;Technology today plays a significant role in evolving the world.  We at Nanotek Computer Solutions always execute our promises keeping you as our topmost priority, and we believe that adapting to the tech scene in the world on par with the international scale has given us the opportunity to be who we are today; a pioneer in the field of computer products in the country.
            
            </p>
        </div>
    </div>
    
    <?php
        require_once('footer.php');
    ?>
    
</body>
</html>