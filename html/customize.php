<?php

    //connection start
    require_once('../connection/connection.php');

    //session variable start
    session_start();

    //set currency type as cookie in local machine
    if(isset($_GET['currency'])){
        setcookie("currency_type", $_GET['currency'], time() + (86400 * 30), "/");
        header('Location: '.$_SERVER['PHP_SELF']);
    }

    //set theme as cookie in local machine
    if(isset($_GET['theme'])){
        setcookie("theme", $_GET['theme'], time() + (86400 * 30), "/");
        header('Location: '.$_SERVER['PHP_SELF']);
    }

    //Remove button submit
    if(isset($_GET['remove'])) {
	    
        $sql = "DELETE FROM `shopping_cart` WHERE `customer_id` = '{$_SESSION['digimart_current_user_id']}' AND `id` = {$_GET['remove']}";
        
        mysqli_query($conn, $sql);
        
        header('Location: cart.php');
    
    }

    //Remove All button submit
    if(isset($_GET['removeAll'])) {
	    
        $sql = "DELETE FROM `shopping_cart` WHERE `customer_id` = '{$_SESSION['digimart_current_user_id']}'";
        
        mysqli_query($conn, $sql);
        
        header('Location: cart.php');
    
    }

    //count catr items
    if(isset($_SESSION['digimart_current_user_id'])) {
        $sql = "SELECT count(`customer_id`) AS 'cartCount' FROM `shopping_cart` WHERE `customer_id` = '{$_SESSION['digimart_current_user_id']}'";

        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_assoc($result)) {
                $cartCount = $row['cartCount'];
            }
        } else {
            $cartCount = 0;
        }
    }

    //PlaceOrder button submit
    if(isset($_GET['itemCount'])) {
        
        $i=0;
        $_SESSION['itemCount'] = $_GET['itemCount'];
        $_SESSION['total'] = $_GET['total'];
        $_SESSION['productId'] = array();
        $_SESSION['productPrice'] = array();
        $_SESSION['productQty'] = array();        
        
        $productId = explode(",",$_GET['productId']);
        $productPrice = explode(",",$_GET['productPrice']);
        $productQty = explode(",",$_GET['productQty']);
        
        while ($i < $_SESSION['itemCount']){
            $_SESSION['productId'][$i] = $productId[$i];
            $_SESSION['productPrice'][$i] = $productPrice[$i];
            $_SESSION['productQty'][$i] = $productQty[$i];
            
            $i++;
        }
        
        header('Location: mail_and_payment.php');
        
    }

?>

<!DOCTYPE html>
<html>
<head>
    <!-- title -->
	<title>Customize PC | DigiMart</title>
    
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
    
    <!-- Internal CSS -->
    <style>
        body {
            /*background-image: url('../image/back.gif');
            background-image: url('../image/back.png');*/
            <?php if(isset($_COOKIE['theme']) && ($_COOKIE['theme']=='dark'))echo "background-color: #404550"; ?>
        }
        
        .display-4 {
            font-family: 'Atomic Age';
        }
        
        .form-control-sm, .form-control-sm:focus {
            background-color: transparent;
        }
        
        #getPlaceOrderDisabled {
            display: block;
        }
        
        #getPlaceOrder {
            display: none;
        }
        
        .itemPrice {
            background-color: rgb(221,18,61);
            color: #fff;
            position:absolute;
            left: 15px;
        }
        
        .itemRadioButton label {
            cursor: pointer;
        }
        
        .itemRadioButton label:hover {
            box-shadow: 2px 2px 5px #dd123d;
        }
        
        .itemRadioButton label:active {
            border: 1px solid #dd123d;
        }
        
    </style>
    
    <!-- Script -->
    <script>
        //for tooltips
        $(document).ready(function(){
            $('[data-toggle="tooltip"]').tooltip();
        });
        
        //for calculate price of quantity
        <?php 

            $query2 = "SELECT c.`id` AS 'cartId', p.* FROM `shopping_cart` c, `product` p WHERE c.`product_id` = p.`id` AND c.`customer_id` = '{$_SESSION['digimart_current_user_id']}' ORDER BY `date_time` DESC";

            $result = $conn->query($query2);

            while ($row = $result->fetch_assoc()) { 

        ?>
        
        function qtyPrice<?php echo $row['cartId'] ?>() {
            
            if(document.getElementById("qty<?php echo $row['cartId'] ?>").value == "" || document.getElementById("qty<?php echo $row['cartId'] ?>").value == 0){
                document.getElementById("qty<?php echo $row['cartId'] ?>").value = 1;
            }
            
            var qty = document.getElementById("qty<?php echo $row['cartId'] ?>").value;
            var price = parseFloat(document.getElementById("price<?php echo $row['cartId'] ?>").value);
            var qtyPrice = qty*price;
            document.getElementById("qtyPrice<?php echo $row['cartId'] ?>").innerHTML = "LKR " + qtyPrice.toFixed(2);
            document.getElementById("itemTotal<?php echo $row['cartId'] ?>").innerHTML = qtyPrice.toFixed(2);
            document.getElementById("itemTotal1<?php echo $row['cartId'] ?>").value = qtyPrice.toFixed(2);
            document.getElementById("itemQty<?php echo $row['cartId'] ?>").innerHTML = qty;
            
            calculateTotal();
        }
        
        <?php } ?>
        
        //for calculate total price of selected item
        function calculateTotal() {
            
            var total = 0.0;
            
            var productId = [];
            var productQty = [];
            var productPrice = [];
            
            <?php
            
                $query2 = "SELECT c.`id` AS 'cartId', p.* FROM `shopping_cart` c, `product` p WHERE c.`product_id` = p.`id` AND c.`customer_id` = '{$_SESSION['digimart_current_user_id']}' ORDER BY `date_time` DESC";

                $result = $conn->query($query2);

                while ($row = $result->fetch_assoc()) { 

            ?>
            
            if(document.getElementById("check<?php echo $row['cartId'] ?>").checked == true){
                total = total + parseFloat(document.getElementById("itemTotal1<?php echo $row['cartId'] ?>").value);
                document.getElementById("itemId<?php echo $row['cartId'] ?>").style.display = "block";
                document.getElementById("itemTotal<?php echo $row['cartId'] ?>").style.display = "block";
                document.getElementById("card-footer<?php echo $row['cartId'] ?>").style.background = "rgba(221,18,60,0.1)";
                document.getElementById("card-header<?php echo $row['cartId'] ?>").style.background = "rgba(221,18,60,0.1)";
                
                var pQty = document.getElementById("qty<?php echo $row['cartId'] ?>").value;
                var pPrice = document.getElementById("price<?php echo $row['cartId'] ?>").value;
                
                productId.push("<?php echo $row['id'] ?>");
                productQty.push(pQty);
                productPrice.push(pPrice);
                
                
            } else {
                document.getElementById("itemId<?php echo $row['cartId'] ?>").style.display = "none";
                document.getElementById("itemTotal<?php echo $row['cartId'] ?>").style.display = "none";
                document.getElementById("card-footer<?php echo $row['cartId'] ?>").style.background = "rgba(0,0,0,.03)";
                document.getElementById("card-header<?php echo $row['cartId'] ?>").style.background = "rgba(0,0,0,.03)";
                
            }
            
            <?php } ?>
            
            document.getElementById("totalPrice").innerHTML = "LKR " + total.toFixed(2);
            
            var strLink = "cart.php?itemCount=" + productId.length + "&productId=" + productId + "&productPrice=" + productPrice + "&productQty=" + productQty + "&total=" + total;
            document.getElementById("getPlaceOrder").setAttribute("href",strLink);
            
            if(total != 0.0) {
                document.getElementById("getPlaceOrder").style.display = "block";
                document.getElementById("getPlaceOrderDisabled").style.display = "none";
            } else {
                document.getElementById("getPlaceOrder").style.display = "none";
                document.getElementById("getPlaceOrderDisabled").style.display = "block";
            }
        
        }
        
        //category by check status
        <?php
            $cate = array("Casing", "MotherBoard", "Processor", "1stRam", "2ndRam", "GraphicCard", "OpticalDrive", "1stStorage", "2ndStorage"); 
        
            foreach ($cate as $value) {
        ?>
        
        function click<?php echo $value; ?>(){
            document.getElementById("check<?php echo $value; ?>").checked = true;
        }
        
        <?php
            }
        ?>
        
        function checkAll() {
            
        }
        
    </script>
    
    </head>
    
    <body onload="calculateTotal()">

        <!-- import navbar -->
        <?php
            require_once('header_half.php');
        ?>

        <!-- page content row 1 | topic -->
        <div class="container">

            <div class="mt-4">
                <h1 class="display-4 text-danger"><img src="../image/customize.png" width="60px"> Customize PC</h1>
            </div>
        
        </div>

        <!-- page content row 2 -->
        <div class="container-fluid mt-4">

            <?php

                if(isset($_SESSION['digimart_current_user_email'])) {
                    
            ?>
            
            <!-- user signed in -->
            <div class="container">

                <div class="row mt-3">

                    <div class="col-lg-8">
                        
                        <div id="accordion">
                            
                            <!-- casing -->
                            <div class="card mb-2 <?php if(isset($_COOKIE['theme']) && ($_COOKIE['theme']=='dark'))echo "text-white bg-dark"; ?>">
                                <div class="card-header d-flex justify-content-between" id="headingCasing">
                                    <button class="btn btn-outline-danger w-50" data-toggle="collapse" data-target="#collapseCasing" aria-expanded="true" aria-controls="collapseCasing">
                                            Casing
                                    </button>
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input checkItem" id="checkCasing">
                                        <label class="custom-control-label" for="checkCasing"></label>
                                    </div>
                                </div>

                                <div id="collapseCasing" class="collapse" aria-labelledby="headingCasing" data-parent="#accordion">
                                    <div class="card-body d-flex flex-row">
                                        
                                        <div class="row">
                                        <?php 

                                            $queryCasing = "SELECT * FROM `product` WHERE `category_id` = 1 AND `is_deleted` = 0";

                                            $resultCasing = mysqli_query($conn, $queryCasing);

                                            while ($rowCasing = mysqli_fetch_assoc($resultCasing)) {
                                        ?>
                                        
                                            <div class="col-4 mb-2 itemRadioButton">
                                                <input type="radio" name="casing" value="<?php echo $rowCasing['id']; ?>" id="Casing<?php echo $rowCasing['id']; ?>" onclick="clickCasing()">
                                                <label for="Casing<?php echo $rowCasing['id']; ?>" data-toggle="tooltip" data-placement="bottom" title="<?php echo $rowCasing['name']; ?>">
                                                    <img class="card-img-top" src="../image/product/<?php echo $rowCasing['image']; ?>" alt="">
                                                    <span class="itemPrice p-1"><b>LKR <?php echo number_format($rowCasing['price'],2); ?></b></span>
                                                </label>
                                            </div>
                                        
                                        <?php
                                                
                                            }

                                        ?>
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>
                            
                            <!-- mother board -->
                            <div class="card mb-2 <?php if(isset($_COOKIE['theme']) && ($_COOKIE['theme']=='dark'))echo "text-white bg-dark"; ?>">
                                <div class="card-header d-flex justify-content-between" id="headingMotherBoard">
                                    <button class="btn btn-outline-danger w-50 collapsed" data-toggle="collapse" data-target="#collapseMotherBoard" aria-expanded="false" aria-controls="collapseMotherBoard">
                                            Mother Board
                                    </button>
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input checkItem" id="checkMotherBoard">
                                        <label class="custom-control-label" for="checkMotherBoard"></label>
                                    </div>
                                </div>
                                <div id="collapseMotherBoard" class="collapse" aria-labelledby="headingMotherBoard" data-parent="#accordion">
                                    <div class="card-body d-flex flex-row">
                                        
                                        <div class="row">
                                        <?php 

                                            $queryMotherBoard = "SELECT * FROM `product` WHERE `category_id` = 1 AND `is_deleted` = 0";

                                            $resultMotherBoard = mysqli_query($conn, $queryMotherBoard);

                                            while ($rowMotherBoard = mysqli_fetch_assoc($resultMotherBoard)) {
                                        ?>
                                        
                                            <div class="col-4 mb-2 itemRadioButton">
                                                <input type="radio" name="motherBoard" value="<?php echo $rowMotherBoard['id']; ?>" id="MotherBoard<?php echo $rowMotherBoard['id']; ?>" onclick="clickMotherBoard()">
                                                <label for="MotherBoard<?php echo $rowMotherBoard['id']; ?>" data-toggle="tooltip" data-placement="bottom" title="<?php echo $rowMotherBoard['name']; ?>">
                                                    <img class="card-img-top" src="../image/product/<?php echo $rowMotherBoard['image']; ?>" alt="">
                                                    <span class="itemPrice p-1"><b>LKR <?php echo number_format($rowMotherBoard['price'],2); ?></b></span>
                                                </label>
                                            </div>
                                        
                                        <?php
                                                
                                            }

                                        ?>
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Processor -->
                            <div class="card mb-2 <?php if(isset($_COOKIE['theme']) && ($_COOKIE['theme']=='dark'))echo "text-white bg-dark"; ?>">
                                <div class="card-header d-flex justify-content-between" id="headingProcessor">
                                    <button class="btn btn-outline-danger w-50 collapsed" data-toggle="collapse" data-target="#collapseProcessor" aria-expanded="false" aria-controls="collapseProcessor">
                                            Processor
                                    </button>
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input checkItem" id="checkProcessor">
                                        <label class="custom-control-label" for="checkProcessor"></label>
                                    </div>
                                </div>
                                <div id="collapseProcessor" class="collapse" aria-labelledby="headingProcessor" data-parent="#accordion">
                                    
                                    <div class="card-body d-flex flex-row">
                                        
                                        <div class="row">
                                        <?php 

                                            $queryProcessor = "SELECT * FROM `product` WHERE `category_id` = 1 AND `is_deleted` = 0";

                                            $resultProcessor = mysqli_query($conn, $queryProcessor);

                                            while ($rowProcessor = mysqli_fetch_assoc($resultProcessor)) {
                                        ?>
                                        
                                            <div class="col-4 mb-2 itemRadioButton">
                                                <input type="radio" name="Processor" value="<?php echo $rowProcessor['id']; ?>" id="Processor<?php echo $rowProcessor['id']; ?>" onclick="clickProcessor()">
                                                <label for="Processor<?php echo $rowProcessor['id']; ?>" data-toggle="tooltip" data-placement="bottom" title="<?php echo $rowProcessor['name']; ?>">
                                                    <img class="card-img-top" src="../image/product/<?php echo $rowProcessor['image']; ?>" alt="">
                                                    <span class="itemPrice p-1"><b>LKR <?php echo number_format($rowProcessor['price'],2); ?></b></span>
                                                </label>
                                            </div>
                                        
                                        <?php
                                                
                                            }

                                        ?>
                                        </div>
                                        
                                    </div>
                                    
                                </div>
                            </div>
                            
                            <!-- 1stRam -->
                            <div class="card mb-2 <?php if(isset($_COOKIE['theme']) && ($_COOKIE['theme']=='dark'))echo "text-white bg-dark"; ?>">
                                <div class="card-header d-flex justify-content-between" id="heading1stRam">
                                    <button class="btn btn-outline-danger w-50 collapsed" data-toggle="collapse" data-target="#collapse1stRam" aria-expanded="false" aria-controls="collapse1stRam">
                                            1<sup>st</sup> Ram
                                    </button>
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input checkItem" id="check1stRam">
                                        <label class="custom-control-label" for="check1stRam"></label>
                                    </div>
                                </div>
                                <div id="collapse1stRam" class="collapse" aria-labelledby="heading1stRam" data-parent="#accordion">
                                    
                                    <div class="card-body d-flex flex-row">
                                        
                                        <div class="row">
                                        <?php 

                                            $query1stRam = "SELECT * FROM `product` WHERE `category_id` = 1 AND `is_deleted` = 0";

                                            $result1stRam = mysqli_query($conn, $query1stRam);

                                            while ($row1stRam = mysqli_fetch_assoc($result1stRam)) {
                                        ?>
                                        
                                            <div class="col-4 mb-2 itemRadioButton">
                                                <input type="radio" name="1stRam" value="<?php echo $row1stRam['id']; ?>" id="1stRam<?php echo $row1stRam['id']; ?>" onclick="click1stRam()">
                                                <label for="1stRam<?php echo $row1stRam['id']; ?>" data-toggle="tooltip" data-placement="bottom" title="<?php echo $row1stRam['name']; ?>">
                                                    <img class="card-img-top" src="../image/product/<?php echo $row1stRam['image']; ?>" alt="">
                                                    <span class="itemPrice p-1"><b>LKR <?php echo number_format($row1stRam['price'],2); ?></b></span>
                                                </label>
                                            </div>
                                        
                                        <?php
                                                
                                            }

                                        ?>
                                        </div>
                                        
                                    </div>
                                    
                                </div>
                            </div>
                            
                            <!-- 2ndRam -->
                            <div class="card mb-2 <?php if(isset($_COOKIE['theme']) && ($_COOKIE['theme']=='dark'))echo "text-white bg-dark"; ?>">
                                <div class="card-header d-flex justify-content-between" id="heading2ndRam">
                                    <button class="btn btn-outline-danger w-50 collapsed" data-toggle="collapse" data-target="#collapse2ndRam" aria-expanded="false" aria-controls="collapse2ndRam">
                                            2<sup>nd</sup> Ram
                                    </button>
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input checkItem" id="check2ndRam">
                                        <label class="custom-control-label" for="check2ndRam"></label>
                                    </div>
                                </div>
                                <div id="collapse2ndRam" class="collapse" aria-labelledby="heading2ndRam" data-parent="#accordion">
                                    
                                    <div class="card-body d-flex flex-row">
                                        
                                        <div class="row">
                                        <?php 

                                            $query2ndRam = "SELECT * FROM `product` WHERE `category_id` = 1 AND `is_deleted` = 0";

                                            $result2ndRam = mysqli_query($conn, $query2ndRam);

                                            while ($row2ndRam = mysqli_fetch_assoc($result2ndRam)) {
                                        ?>
                                        
                                            <div class="col-4 mb-2 itemRadioButton">
                                                <input type="radio" name="2ndRam" value="<?php echo $row2ndRam['id']; ?>" id="2ndRam<?php echo $row2ndRam['id']; ?>" onclick="click2ndRam()">
                                                <label for="2ndRam<?php echo $row2ndRam['id']; ?>" data-toggle="tooltip" data-placement="bottom" title="<?php echo $row2ndRam['name']; ?>">
                                                    <img class="card-img-top" src="../image/product/<?php echo $row2ndRam['image']; ?>" alt="">
                                                    <span class="itemPrice p-1"><b>LKR <?php echo number_format($row2ndRam['price'],2); ?></b></span>
                                                </label>
                                            </div>
                                        
                                        <?php
                                                
                                            }

                                        ?>
                                        </div>
                                        
                                    </div>
                                    
                                </div>
                            </div>
                            
                            <!-- Graphic Card -->
                            <div class="card mb-2 <?php if(isset($_COOKIE['theme']) && ($_COOKIE['theme']=='dark'))echo "text-white bg-dark"; ?>">
                                <div class="card-header d-flex justify-content-between" id="headingGraphicCard">
                                    <button class="btn btn-outline-danger w-50 collapsed" data-toggle="collapse" data-target="#collapseGraphicCard" aria-expanded="false" aria-controls="collapseGraphicCard">
                                            Graphic Card
                                    </button>
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input checkItem" id="checkGraphicCard">
                                        <label class="custom-control-label" for="checkGraphicCard"></label>
                                    </div>
                                </div>
                                <div id="collapseGraphicCard" class="collapse" aria-labelledby="headingGraphicCard" data-parent="#accordion">
                                    
                                    <div class="card-body d-flex flex-row">
                                        
                                        <div class="row">
                                        <?php 

                                            $queryGraphicCard = "SELECT * FROM `product` WHERE `category_id` = 1 AND `is_deleted` = 0";

                                            $resultGraphicCard = mysqli_query($conn, $queryGraphicCard);

                                            while ($rowGraphicCard = mysqli_fetch_assoc($resultGraphicCard)) {
                                        ?>
                                        
                                            <div class="col-4 mb-2 itemRadioButton">
                                                <input type="radio" name="GraphicCard" value="<?php echo $rowGraphicCard['id']; ?>" id="GraphicCard<?php echo $rowGraphicCard['id']; ?>" onclick="clickGraphicCard()">
                                                <label for="GraphicCard<?php echo $rowGraphicCard['id']; ?>" data-toggle="tooltip" data-placement="bottom" title="<?php echo $rowGraphicCard['name']; ?>">
                                                    <img class="card-img-top" src="../image/product/<?php echo $rowGraphicCard['image']; ?>" alt="">
                                                    <span class="itemPrice p-1"><b>LKR <?php echo number_format($rowGraphicCard['price'],2); ?></b></span>
                                                </label>
                                            </div>
                                        
                                        <?php
                                                
                                            }

                                        ?>
                                        </div>
                                        
                                    </div>
                                    
                                </div>
                            </div>
                            
                            <!-- Optical Drive -->
                            <div class="card mb-2 <?php if(isset($_COOKIE['theme']) && ($_COOKIE['theme']=='dark'))echo "text-white bg-dark"; ?>">
                                <div class="card-header d-flex justify-content-between" id="headingOpticalDrive">
                                    <button class="btn btn-outline-danger w-50 collapsed" data-toggle="collapse" data-target="#collapseOpticalDrive" aria-expanded="false" aria-controls="collapseOpticalDrive">
                                            Optical Drive
                                    </button>
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input checkItem" id="checkOpticalDrive">
                                        <label class="custom-control-label" for="checkOpticalDrive"></label>
                                    </div>
                                </div>
                                <div id="collapseOpticalDrive" class="collapse" aria-labelledby="headingOpticalDrive" data-parent="#accordion">
                                    
                                    <div class="card-body d-flex flex-row">
                                        
                                        <div class="row">
                                        <?php 

                                            $queryOpticalDrive = "SELECT * FROM `product` WHERE `category_id` = 1 AND `is_deleted` = 0";

                                            $resultOpticalDrive = mysqli_query($conn, $queryOpticalDrive);

                                            while ($rowOpticalDrive = mysqli_fetch_assoc($resultOpticalDrive)) {
                                        ?>
                                        
                                            <div class="col-4 mb-2 itemRadioButton">
                                                <input type="radio" name="OpticalDrive" value="<?php echo $rowOpticalDrive['id']; ?>" id="OpticalDrive<?php echo $rowOpticalDrive['id']; ?>" onclick="clickOpticalDrive()">
                                                <label for="OpticalDrive<?php echo $rowOpticalDrive['id']; ?>" data-toggle="tooltip" data-placement="bottom" title="<?php echo $rowOpticalDrive['name']; ?>">
                                                    <img class="card-img-top" src="../image/product/<?php echo $rowOpticalDrive['image']; ?>" alt="">
                                                    <span class="itemPrice p-1"><b>LKR <?php echo number_format($rowOpticalDrive['price'],2); ?></b></span>
                                                </label>
                                            </div>
                                        
                                        <?php
                                                
                                            }

                                        ?>
                                        </div>
                                        
                                    </div>
                                    
                                </div>
                            </div>
                            
                            <!-- 1stStorage -->
                            <div class="card mb-2 <?php if(isset($_COOKIE['theme']) && ($_COOKIE['theme']=='dark'))echo "text-white bg-dark"; ?>">
                                <div class="card-header d-flex justify-content-between" id="heading1stStorage">
                                    <button class="btn btn-outline-danger w-50 collapsed" data-toggle="collapse" data-target="#collapse1stStorage" aria-expanded="false" aria-controls="collapse1stStorage">
                                            1<sup>st</sup> Storage
                                    </button>
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input checkItem" id="check1stStorage">
                                        <label class="custom-control-label" for="check1stStorage"></label>
                                    </div>
                                </div>
                                <div id="collapse1stStorage" class="collapse" aria-labelledby="heading1stStorage" data-parent="#accordion">
                                    
                                    <div class="card-body d-flex flex-row">
                                        
                                        <div class="row">
                                        <?php 

                                            $query1stStorage = "SELECT * FROM `product` WHERE `category_id` = 1 AND `is_deleted` = 0";

                                            $result1stStorage = mysqli_query($conn, $query1stStorage);

                                            while ($row1stStorage = mysqli_fetch_assoc($result1stStorage)) {
                                        ?>
                                        
                                            <div class="col-4 mb-2 itemRadioButton">
                                                <input type="radio" name="1stStorage" value="<?php echo $row1stStorage['id']; ?>" id="1stStorage<?php echo $row1stStorage['id']; ?>" onclick="click1stStorage()">
                                                <label for="1stStorage<?php echo $row1stStorage['id']; ?>" data-toggle="tooltip" data-placement="bottom" title="<?php echo $row1stStorage['name']; ?>">
                                                    <img class="card-img-top" src="../image/product/<?php echo $row1stStorage['image']; ?>" alt="">
                                                    <span class="itemPrice p-1"><b>LKR <?php echo number_format($row1stStorage['price'],2); ?></b></span>
                                                </label>
                                            </div>
                                        
                                        <?php
                                                
                                            }

                                        ?>
                                        </div>
                                        
                                    </div>
                                    
                                </div>
                            </div>
                            
                            <!-- 2ndStorage -->
                            <div class="card mb-2 <?php if(isset($_COOKIE['theme']) && ($_COOKIE['theme']=='dark'))echo "text-white bg-dark"; ?>">
                                <div class="card-header d-flex justify-content-between" id="heading2ndStorage">
                                    <button class="btn btn-outline-danger w-50 collapsed" data-toggle="collapse" data-target="#collapse2ndStorage" aria-expanded="false" aria-controls="collapse2ndStorage">
                                            2<sup>nd</sup> Storage
                                    </button>
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input checkItem" id="check2ndStorage">
                                        <label class="custom-control-label" for="check2ndStorage"></label>
                                    </div>
                                </div>
                                <div id="collapse2ndStorage" class="collapse" aria-labelledby="heading2ndStorage" data-parent="#accordion">
                                    
                                    <div class="card-body d-flex flex-row">
                                        
                                        <div class="row">
                                        <?php 

                                            $query2ndStorage = "SELECT * FROM `product` WHERE `category_id` = 1 AND `is_deleted` = 0";

                                            $result2ndStorage = mysqli_query($conn, $query2ndStorage);

                                            while ($row2ndStorage = mysqli_fetch_assoc($result2ndStorage)) {
                                        ?>
                                        
                                            <div class="col-4 mb-2 itemRadioButton">
                                                <input type="radio" name="2ndStorage" value="<?php echo $row2ndStorage['id']; ?>" id="2ndStorage<?php echo $row2ndStorage['id']; ?>" onclick="click2ndStorage()">
                                                <label for="2ndStorage<?php echo $row2ndStorage['id']; ?>" data-toggle="tooltip" data-placement="bottom" title="<?php echo $row2ndStorage['name']; ?>">
                                                    <img class="card-img-top" src="../image/product/<?php echo $row2ndStorage['image']; ?>" alt="">
                                                    <span class="itemPrice p-1"><b>LKR <?php echo number_format($row2ndStorage['price'],2); ?></b></span>
                                                </label>
                                            </div>
                                        
                                        <?php
                                                
                                            }

                                        ?>
                                        </div>
                                        
                                    </div>
                                    
                                </div>
                            </div>
                            
                        </div>

                        <?php 

                            $query2 = "SELECT c.`id` AS 'cartId', p.* FROM `shopping_cart` c, `product` p WHERE c.`product_id` = p.`id` AND c.`customer_id` = '{$_SESSION['digimart_current_user_id']}' ORDER BY `date_time` DESC";

                            $result = $conn->query($query2);

                            while ($row = $result->fetch_assoc()) { 

                        ?>

                        <!-- items -->
                        <div class="row mw-100" id="product-container">
                            <div class="mb-4 d-flex mx-2 shadow-sm">
                                <div class="card <?php if(isset($_COOKIE['theme']) && ($_COOKIE['theme']=='dark'))echo "text-white bg-dark"; ?>">
                                    <div class="card-header d-flex justify-content-between" id="card-header<?php echo $row['cartId'] ?>">
                                        <h6 class="lead">Product Id : <?php echo $row['id']; ?></h6>
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input checkItem" id="check<?php echo $row['cartId'] ?>" onclick="qtyPrice<?php echo $row['cartId'] ?>()" onchange="qtyPrice<?php echo $row['cartId'] ?>()">
                                            <label class="custom-control-label" for="check<?php echo $row['cartId'] ?>"></label>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-between p-1">
                                        <div class="col-4 card-img">
                                            <a href="#"><img class="card-img-top" src="../image/product/<?php echo $row['image'] ?>" alt=""></a>
                                        </div>
                                        <div class="py-2">
                                            <h4 class="card-title text-danger">
                                                <a href="#" class="text-danger"><?php echo $row['name']?></a>
                                            </h4>
                                            <h5>LKR <?php echo number_format($row['price'],2); ?></h5>
                                            <input type="text" id="price<?php echo $row['cartId'] ?>" value="<?php echo $row['price']; ?>" hidden>
                                            <div class="pl-3 form-group row d-flex justify-content-start">
                                                <label for="qty" class="col-form-label col-form-label-sm">Quentity </label>
                                                <input type="number" class="form-control form-control-sm col-3 mx-2 <?php if(isset($_COOKIE['theme']) && ($_COOKIE['theme']=='dark'))echo "text-white"; ?>" id="qty<?php echo $row['cartId'] ?>" min="1" value="1" onchange="qtyPrice<?php echo $row['cartId'] ?>()" onkeydown="qtyPrice<?php echo $row['cartId'] ?>()" onkeyup="qtyPrice<?php echo $row['cartId'] ?>()" onselect="qtyPrice<?php echo $row['cartId'] ?>()">
                                                <h5 id="qtyPrice<?php echo $row['cartId'] ?>" class="text-secondary">LKR <?php echo $row['price']; ?></h5>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card-footer text-right" id="card-footer<?php echo $row['cartId'] ?>">
                                        <?php
                                            echo "<a href='cart.php?remove={$row['cartId']}' onclick=\"return confirm('This action will remove this item from your shopping cart.');\" class='text-danger'><i class='far fa-trash-alt fa-lg'></i></a>";
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <?php } ?>
                    
                    </div>

                    <!-- card order summery div -->
                    <div class="shadow-lg p-4 mb-5 rounded-lg col-lg-4 h-100 <?php if(isset($_COOKIE['theme']) && ($_COOKIE['theme']=='dark'))echo "text-white bg-dark"; ?>">

                        <h2>Order Summery</h2>

                        <div class="d-flex justify-content-between">
                            <div class="p-2 font-weight-bold">PRODUCT ID X QTY</div>
                            <div class="p-2 font-weight-bold">PRICE (LKR)</div>
                        </div>

                        <?php 

                            $query2 = "SELECT c.`id` AS 'cartId', p.* FROM `shopping_cart` c, `product` p WHERE c.`product_id` = p.`id` AND c.`customer_id` = '{$_SESSION['digimart_current_user_id']}' ORDER BY `date_time` DESC";

                            $result = $conn->query($query2);

                            while ($row = $result->fetch_assoc()) { 

                        ?>

                        <div class="d-flex justify-content-between">
                            <div class="p-2" id="itemId<?php echo $row['cartId'] ?>"><?php echo $row['id'] ?> X <font id="itemQty<?php echo $row['cartId'] ?>">1</font></div>
                            <div class="p-2" id="itemTotal<?php echo $row['cartId'] ?>"><?php echo $row['price']; ?></div>
                            <input type="text" id="itemTotal1<?php echo $row['cartId'] ?>" value="<?php echo $row['price']; ?>" hidden>
                        </div>

                        <?php } ?>

                        <div class="d-flex border-top mt-4 border-danger">
                            <div class="mr-auto p-2"><h5>Total</h5></div>
                            <div class="p-2"><h5 id="totalPrice"></h5></div>
                        </div>

                        <button id="getPlaceOrderDisabled" class="btn btn-outline-danger w-100 mt-3" data-toggle="tooltip" data-placement="bottom" title="Select Specification" disabled>Place Order</button>
                        <a href='' id="getPlaceOrder" name="getPlaceOrder" class="btn btn-danger w-100 mt-3">Place Order</a>

                    </div>

                </div>

                <br>

            </div>
            
            <?php
                }
                else {

            ?>

            <!-- quest user cannot use customize PC -->
            <div class="justify-content-center mb-2 p-5 <?php if(isset($_COOKIE['theme']) && ($_COOKIE['theme']=='dark'))echo "text-white"; ?>" style="height: 300px;">
                <h2 class="text-center">You cannot get this service.</h2>
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

        <!-- footer -->
        <?php
            require_once('footer.php');
        ?>

    </body>
</html>