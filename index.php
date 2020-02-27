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
    <link href='https://fonts.googleapis.com/css?family=Atomic Age' rel='stylesheet'>
    <link href='https://fonts.googleapis.com/css?family=Blinker' rel='stylesheet'>
    
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
            position: relative;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            overflow-y: scroll;
            max-height: 650px;
            
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
        
        #categoryList a {
            font-family: 'Abel';
            font-size: 20px;
        }
        
        #categoryList tr:hover {
            background-color: rgba(221,18,60,0.1);
            border-right: 5px solid #dd123d;
        }
        
        #categoryList tr td {
            height: 50px;
        }
        
        .categoryTopic {
            font-family: 'ABeeZee';
        }
        
        .item-type {
            background: linear-gradient(to left, rgba(221,18,61,0.1) 50%, white 50%);
            background-size: 200% 100%;
            background-position: left bottom;
            transition: all .5s ease-out;
            text-transform: capitalize;
        }
        
        .item-type:hover {
            background-position: right bottom;
        }
        
        .item-name {
            color: black;
            transition: all .6s ease-out;
            display: block;
        }
        
        .item-name:hover {
            color: white;
        }
        
        .item-head {
            font-family: 'Atomic Age';
        }
        
        /********************* item grid **********************/
        .product-grid {
            font-family:sans-serif;
            text-align:center;
            position:relative;
            z-index:1;
        }
        
        .product-grid:before {
            content:"";
            height:81%;
            width:100%;
            background:#fff;
            border:1px solid rgba(221,18,61,.4);
            opacity:0;
            position:absolute;
            top:0;
            left:0;
            z-index:-1;
            transition:all .5s ease 0s;
        }
        
        .product-grid:hover:before {
            opacity:1;
            height:100%;
        }
        
        .product-grid .product-image {
            position:relative;
        }
        
        .product-grid .product-image a {
            display:block;
        }
        
        .product-grid .product-image img {
            width:100%;
            height:auto;
        }
        
        .product-grid .social {
            width:120px;
            padding:0;
            margin:0 auto;
            list-style:none;
            opacity:0;
            position:absolute;
            right:0;
            left:0;
            bottom:-23px;
            transform:scale(0);
            transition:all .3s ease 0s;
        }
        
        .product-grid:hover .social {
            opacity:1;
            transform:scale(1);
        }
        
        .product-grid:hover .product-new-label,.product-grid:hover .product-rating-label,.product-grid:hover .title {
            opacity:0;
        }
        
        .product-grid .social li {
            display:inline-block;
        }
        
        .product-grid .social li a {
            color:#dd123d;
            background:#fff;
            font-size:18px;
            line-height:50px;
            width:50px;
            height:50px;
            border:1px solid rgba(221,18,61,.1);
            border-radius:50%;
            margin:0 2px;
            display:block;
            transition:all .3s ease 0s;
        }
        
        .product-grid .social li a:hover {
            background:#dd123d;
            color:#fff;
        }
        
        .product-grid .product-new-label {
            background-color:#dd123d;
            color:#fff;
            font-size:17px;
            padding:2px 10px;
            position:absolute;
            right:10px;
            top:10px;
            transition:all .3s;
        }
        
        .product-grid .product-rating-label {
            background-color: rgba(255,255,255,.5);
            position:absolute;
            right:10px;
            bottom:10px;
            transition:all .3s;
        }
        
        .fa-star, .fa-star-half-alt {
            display: list-item;
            list-style: none;
            margin-bottom: 5px;
        }
        
        .product-grid .product-content {
            z-index:-1;
            padding:15px;
            text-align:left;
        }
        
        .product-grid .title {
            font-size:14px;
            text-transform: capitalize;
            margin:0 0 7px;transition:all .3s ease 0s;
        }
        
        .product-grid .price {
            font-family: 'Blinker';
            letter-spacing:1px;
            margin-right:2px;
            display:inline-block;
        }
        
        .scrollbar-deep-purple::-webkit-scrollbar-track {
            -webkit-box-shadow: inset 0 0 6px rgba(0, 0, 0, 0.1);
            background-color: #fff;
            border-radius: 10px;
        }
        
        .scrollbar-deep-purple::-webkit-scrollbar {
            width: 12px;
            background-color: #fff;
        }
        
        .scrollbar-deep-purple::-webkit-scrollbar-thumb {
            border-radius: 10px;
            -webkit-box-shadow: inset 0 0 6px rgba(0, 0, 0, 0.1); 
            background-color: #dd123d;
        }
        
        .scrollbar-deep-purple {
            scrollbar-color: #dd123d #fff;
        }
        
        .bordered-deep-purple::-webkit-scrollbar-track {
            -webkit-box-shadow: none;
            border: 1px solid #dd123d;
        }
        
        .bordered-deep-purple::-webkit-scrollbar-thumb {
            -webkit-box-shadow: none;
        }
        
        .thin::-webkit-scrollbar {
            width: 6px;
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
    
    <div class="container-fluid">
        <div class="row p-4">
            <div class="col-3">
                <div class="sidebar-item scrollbar-deep-purple bordered-deep-purple thin">
                    <div class="make-me-sticky p-3 shadow-sm">
                        <h5 class="categoryTopic"><i class="fas fa-list"></i> Categories</h5>
                        <hr>
                        <input class="form-control form-control-sm mb-3" id="categorySearch" type="text" placeholder="Search...">
                        <table class="w-100">
                            <tbody id="categoryList">
                                <tr>
                                    <td class= "item-type"><a href="#" class="text-secondary item-name"><img src="image/category/laptop.png" width="25px"> Laptops</a></td>
                                </tr>
                                <tr>
                                    <td class= "item-type"><a href="#" class="text-secondary item-name"><img src="image/category/desktop_workstation.png" width="25px"> Desktop workstations</a></td>
                                </tr>
                                <tr>
                                    <td class= "item-type"><a href="#" class="text-secondary item-name"><img src="image/category/gaming_desktop.png" width="25px"> Gaming Desktops</a></td>
                                </tr>
                                <tr>
                                    <td class= "item-type"><a href="#" class="text-secondary item-name"><img src="image/category/laptop.png" width="25px"> Laptops</a></td>
                                </tr>
                                <tr>
                                    <td class= "item-type"><a href="#" class="text-secondary item-name"><img src="image/category/desktop_workstation.png" width="25px"> Desktop workstations</a></td>
                                </tr>
                                <tr>
                                    <td class= "item-type"><a href="#" class="text-secondary item-name"><img src="image/category/gaming_desktop.png" width="25px"> Gaming Desktops</a></td>
                                </tr>
                                <tr>
                                    <td class= "item-type"><a href="#" class="text-secondary item-name"><img src="image/category/laptop.png" width="25px"> Laptops</a></td>
                                </tr>
                                <tr>
                                    <td class= "item-type"><a href="#" class="text-secondary item-name"><img src="image/category/desktop_workstation.png" width="25px"> Desktop workstations</a></td>
                                </tr>
                                <tr>
                                    <td class= "item-type"><a href="#" class="text-secondary item-name"><img src="image/category/gaming_desktop.png" width="25px"> Gaming Desktops</a></td>
                                </tr>
                                <tr>
                                    <td class= "item-type"><a href="#" class="text-secondary item-name"><img src="image/category/laptop.png" width="25px"> Laptops</a></td>
                                </tr>
                                <tr>
                                    <td class= "item-type"><a href="#" class="text-secondary item-name"><img src="image/category/desktop_workstation.png" width="25px"> Desktop workstations</a></td>
                                </tr>
                                <tr>
                                    <td class= "item-type"><a href="#" class="text-secondary item-name"><img src="image/category/gaming_desktop.png" width="25px"> Gaming Desktops</a></td>
                                </tr>
                                <tr>
                                    <td class= "item-type"><a href="#" class="text-secondary item-name"><img src="image/category/laptop.png" width="25px"> Laptops</a></td>
                                </tr>
                                <tr>
                                    <td class= "item-type"><a href="#" class="text-secondary item-name"><img src="image/category/desktop_workstation.png" width="25px"> Desktop workstations</a></td>
                                </tr>
                                <tr>
                                    <td class= "item-type"><a href="#" class="text-secondary item-name"><img src="image/category/gaming_desktop.png" width="25px"> Gaming Desktops</a></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            
            <div class="col-9">
                <div class="content-section">
                    
                    
                    <h3 class="mb-3 text-center item-head">Laptops</h3>
                    <hr>
                    
                    <div class="row">
                        
                        <div class="col-lg-4 col-md-6 col-sm-12">
                            <div class="product-grid shadow-sm bg-white rounded">
                                <div class="product-image">
                                    <a href="#">
                                        <img class="" src="http://bestjquery.com/tutorial/product-grid/demo4/images/img-5.jpg">
                                    </a>
                                    <ul class="social">
                                        <li><a href="#" data-toggle="tooltip" data-placement="bottom" title="Add to Quot"><i class="fas fa-box"></i></a></li>
                                        <li><a href="#" data-toggle="tooltip" data-placement="bottom" title="Add to Cart"><i class="fas fa-cart-plus"></i></a></li>
                                    </ul>
                                    <span class="product-new-label">New</span>
                                    
                                    <span class="product-rating-label p-1 text-danger">
                                        <?php
                                            $rate = 2.5;
                                        
                                            for($i=5;$i>0;$i--) {
                                                if($rate>=$i) {
                                                    echo "<i class='fas fa-star fa-sm'></i>";
                                                }
                                                else {
                                                    echo "<i class='far fa-star fa-sm'></i>";
                                                }
                                            }
                                        
                                            echo $rate;
                                        ?>
                                    </span>
                                </div>
                                <div class="product-content">
                                    <h3 class="title text-secondary">- Desktop Workstations -</h3>
                                    <h4 class="text-dark">ASUS ROG STRIX SCAR III G531GW I9 WITH RTX 2070</h4>
                                    <div class="price text-danger">
                                        <h2><small>LKR </small>635000.00</h2>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        
                    </div>
                    
                    
                    
                </div>
            </div>
        </div>
    </div>
    
    <?php
        require_once('html/footer.php');
    ?>
    
</body>
</html>