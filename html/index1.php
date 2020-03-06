<?php

    require_once('../connection/connection.php');

    session_start();

    $alertStatus = 0;

    if(isset($_GET['currency'])){
        setcookie("currency_type", $_GET['currency'], time() + (86400 * 30), "/");
        header('Location: '.$_SERVER['PHP_SELF']);
    }

    if(isset($_GET['theme'])){
        setcookie("theme", $_GET['theme'], time() + (86400 * 30), "/");
        header('Location: '.$_SERVER['PHP_SELF']);
    }

    if(isset($_POST['btnAddCart'])){
        $alertStatus = 1;
    }
?>

<!DOCTYPE html>
<html>
<head>
    <!-- title -->
	<title>Home | DigiMart</title>
    
    <!-- title icon -->
    <link rel="icon" type="image/ico" href="../image/logo.png"/>
    
    <!-- Bootstrap CSS -->
    <link type="text/css" href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- CSS -->
    <link type="text/css" href="../css/navbar.css" rel="stylesheet">
    <link type="text/css" href="../css/main.css" rel="stylesheet">
    
    <!-- google font -->
    <link href='https://fonts.googleapis.com/css?family=Abel' rel='stylesheet'>
    <link href='https://fonts.googleapis.com/css?family=Eagle Lake' rel='stylesheet'>
    <link href='https://fonts.googleapis.com/css?family=ABeeZee' rel='stylesheet'>
    <link href='https://fonts.googleapis.com/css?family=Atomic Age' rel='stylesheet'>
    <link href='https://fonts.googleapis.com/css?family=Blinker' rel='stylesheet'>
    
    <!-- Fontawesome icons -->
    <script src="https://kit.fontawesome.com/faf1c6588d.js" crossorigin="anonymous"></script>

    <!-- jQuery -->
    <script src="../vendor/jquery/jquery-3.4.1.min.js"></script>
    <script src="../vendor/bootstrap/js/bootstrap.js"></script>
    
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
        
        #categoryList tr td {
            background-color: rgba(221,18,60,0.1);            
        }
        
        #categoryList tr td:hover {
            background-color: rgba(221,18,60,0.1);            
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
            background:none;
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
            background:<?php if(isset($_COOKIE['theme']) && ($_COOKIE['theme']=='dark'))echo "#121633"; else echo "#fff"; ?>;
            font-size:18px;
            line-height:50px;
            width:50px;
            height:50px;
            border:1px solid rgba(221,18,61,1);
            border-radius:50%;
            margin:0 2px;
            display:block;
            transition:all .3s ease 0s;
        }
        
        .product-grid .social li a:hover {
            background:#dd123d;
            color:<?php if(isset($_COOKIE['theme']) && ($_COOKIE['theme']=='dark'))echo "#121633"; else echo "#fff"; ?>;
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
        
        @media only screen and (max-width: 600px) {
            .sidebar-item {
                width: 50%;
                overflow-x:hidden;
            }
        }
        
        .toastNotify {
            position: fixed;
            top: 10px;
            right: 10px;
            z-index: 1;
            border: 1px solid #dd123d;
            display: <?php if($alertStatus == 1) echo "block"; else echo "none"; ?>;
            
            -webkit-animation: cssAnimation 8s forwards; 
            animation: cssAnimation 8s forwards;
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
    
    <div class="toastNotify <?php if(isset($_COOKIE['theme']) && ($_COOKIE['theme']=='dark'))echo "bg-dark"; else echo "bg-white"; ?> col-7 col-sm-6 col-md-4 col-lg-3" data-autohide="false">
        <div class="toast-header <?php if(isset($_COOKIE['theme']) && ($_COOKIE['theme']=='dark'))echo "bg-dark"; ?>">
            <strong class="mr-auto text-danger">Thank you!</strong>
            <small class="text-muted"></small>
            <button type="button" class="ml-2 mb-1 close text-danger" data-dismiss="toast">&times;</button>
        </div>

        <div class="toast-body <?php if(isset($_COOKIE['theme']) && ($_COOKIE['theme']=='dark'))echo "text-white"; ?>">
            Your message has been sent.
        </div>
    </div>
    
    <?php
        require_once('../html/header_half.php"');
    ?>
    
    <div class="container-fluid">
        <div class="row p-4">
            <div class="col-3">
                <div class="sidebar-item scrollbar-deep-purple bordered-deep-purple thin">
                    <div class="make-me-sticky p-3 shadow-sm <?php if(isset($_COOKIE['theme']) && ($_COOKIE['theme']=='dark'))echo "bg-dark"; ?>">
                        <h5 class="categoryTopic <?php if(isset($_COOKIE['theme']) && ($_COOKIE['theme']=='dark'))echo "text-light"; ?>"><i class="fas fa-list"></i> Categories</h5>
                        <hr>
                        <input class="form-control form-control-sm mb-3 <?php if(isset($_COOKIE['theme']) && ($_COOKIE['theme']=='dark'))echo "bg-dark"; ?>" id="categorySearch" type="text" placeholder="Search...">
                        <table class="w-100">
                            <tbody id="categoryList">
                                <?php
                                    $sql = "SELECT * FROM `category` WHERE `is_deleted` = 0";

                                    $result = mysqli_query($conn, $sql);

                                    if (mysqli_num_rows($result) > 0) {
                                        while($row = mysqli_fetch_assoc($result)) {
                                            echo "<tr>
                                                <td class= 'item-type'><a href='#' class='text-secondary item-name'><img src='../image/category/". $row['icon']."' width='25px'> ". $row['type']."</a></td>
                                            </tr>";
                                        }
                                    } else {
                                        echo "<tr>
                                                <td class= 'item-type'><a class='text-secondary item-name'> No Category</a></td>
                                            </tr>";
                                    }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            
            <div class="col-9">
                <div class="content-section">
                    
                    
                    <h3 class="mb-3 text-center item-head <?php if(isset($_COOKIE['theme']) && ($_COOKIE['theme']=='dark'))echo "text-white"; ?>">Laptops</h3>
                    <hr>
                    
                    <div class="row">
                        
                        <?php
                            $sql = "SELECT p.`id`, p.`name`, p.`image`,p.`price`, b.`name` AS 'brand', c.`type` FROM `product` p, `brand` b, `category` c WHERE p.`brand_id` = b.`id` AND p.`category_id` = c.`id` AND p.`is_deleted` = 0";

                            $result = mysqli_query($conn, $sql);

                            if (mysqli_num_rows($result) > 0) {
                                while($row = mysqli_fetch_assoc($result)) {
                        ?>
                        
                        <div class="col-lg-4 col-md-6 col-sm-12 my-2">
                            <div class="product-grid shadow-sm <?php if(isset($_COOKIE['theme']) && ($_COOKIE['theme']=='dark'))echo "bg-dark"; else echo "bg-light"; ?> rounded">
                                <div class="product-image">
                                    <a href="html/product.php">
                                        <img class="p-1" src="../image/product/<?php echo $row['image']; ?>">
                                    </a>
                                    <ul class="social">
                                        <li><a href="#" data-toggle="tooltip" data-placement="bottom" title="Add to Quot"><i class="fas fa-box"></i></a></li>
                                        <li><a href="#" data-toggle="tooltip" data-placement="bottom" title="Add to Cart"><i class="fas fa-cart-plus"></i></a></li>
                                    </ul>
                                    <!--span class="product-new-label">New</span-->
                                    
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
                                    <h3 class="title text-secondary">- <?php echo strtoupper($row['type']); ?> -</h3>
                                    <h4 class="<?php if(isset($_COOKIE['theme']) && ($_COOKIE['theme']=='dark'))echo "text-white"; else echo "text-dark"; ?>"><?php echo $row['name']; ?></h4>
                                    <div class="price text-danger">
                                        <h2><small>LKR </small><?php echo $row['price']; ?></h2>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <?php
                                }
                            } else {
                                echo "<h4 class='text-danger'>No Items</h4>";
                            }
                        ?>
                        
                    </div>
                
                </div>
            </div>
        </div>
    </div>
    
    <?php
        require_once('../html/footer.php');
    ?>
    
</body>
</html>