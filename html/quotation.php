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
	    
        $sql = "DELETE FROM `quotation` WHERE `customer_id` = '{$_SESSION['digimart_current_user_id']}' AND `id` = {$_GET['remove']}";
        
        mysqli_query($conn, $sql);
        
        header('Location: quotation.php');
    
    }

    //Remove All button submit
    if(isset($_GET['removeAll'])) {
	    
        $sql = "DELETE FROM `quotation` WHERE `customer_id` = '{$_SESSION['digimart_current_user_id']}'";
        
        mysqli_query($conn, $sql);
        
        header('Location: quotation.php');
    
    }

    //count quotation items
    if(isset($_SESSION['digimart_current_user_id'])) {
        $sql = "SELECT count(`customer_id`) AS 'quoteCount' FROM `quotation` WHERE `customer_id` = '{$_SESSION['digimart_current_user_id']}'";

        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_assoc($result)) {
                $quoteCount = $row['quoteCount'];
            }
        } else {
            $quoteCount = 0;
        }
    }

?>

<!DOCTYPE html>
<html>
    <head>
        <!-- title -->
        <title>Quotation | DigiMart</title>

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

            #getQuoteDisabled {
                display: block;
            }

            #getQuote {
                display: none;
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

                $query2 = "SELECT q.`id` AS 'quoteId', p.* FROM `quotation` q, `product` p WHERE q.`product_id` = p.`id` AND q.`customer_id` = '{$_SESSION['digimart_current_user_id']}' ORDER BY `date_time` DESC";

                $result = $conn->query($query2);

                while ($row = $result->fetch_assoc()) { 

            ?>

            function qtyPrice<?php echo $row['quoteId'] ?>() {

                if(document.getElementById("qty<?php echo $row['quoteId'] ?>").value == "" || document.getElementById("qty<?php echo $row['quoteId'] ?>").value == 0){
                    document.getElementById("qty<?php echo $row['quoteId'] ?>").value = 1;
                }

                var qty = document.getElementById("qty<?php echo $row['quoteId'] ?>").value;
                var price = parseFloat(document.getElementById("price<?php echo $row['quoteId'] ?>").value);
                var qtyPrice = qty*price;
                document.getElementById("qtyPrice<?php echo $row['quoteId'] ?>").innerHTML = "LKR " + qtyPrice.toFixed(2);
                document.getElementById("itemTotal<?php echo $row['quoteId'] ?>").innerHTML = qtyPrice.toFixed(2);
                document.getElementById("itemTotal1<?php echo $row['quoteId'] ?>").value = qtyPrice.toFixed(2);
                document.getElementById("itemQty<?php echo $row['quoteId'] ?>").innerHTML = qty;

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

                    $query2 = "SELECT q.`id` AS 'quoteId', p.* FROM `quotation` q, `product` p WHERE q.`product_id` = p.`id` AND q.`customer_id` = '{$_SESSION['digimart_current_user_id']}' ORDER BY `date_time` DESC";

                    $result = $conn->query($query2);

                    while ($row = $result->fetch_assoc()) { 

                ?>

                if(document.getElementById("check<?php echo $row['quoteId'] ?>").checked == true){
                    total = total + parseFloat(document.getElementById("itemTotal1<?php echo $row['quoteId'] ?>").value);
                    document.getElementById("itemId<?php echo $row['quoteId'] ?>").style.display = "block";
                    document.getElementById("itemTotal<?php echo $row['quoteId'] ?>").style.display = "block";
                    document.getElementById("card-footer<?php echo $row['quoteId'] ?>").style.background = "rgba(221,18,60,0.1)";
                    document.getElementById("card-header<?php echo $row['quoteId'] ?>").style.background = "rgba(221,18,60,0.1)";

                    var pQty = document.getElementById("qty<?php echo $row['quoteId'] ?>").value;
                    var pPrice = document.getElementById("price<?php echo $row['quoteId'] ?>").value;

                    productId.push("<?php echo $row['id'] ?>");
                    productQty.push(pQty);
                    productPrice.push(pPrice);


                } else {
                    document.getElementById("itemId<?php echo $row['quoteId'] ?>").style.display = "none";
                    document.getElementById("itemTotal<?php echo $row['quoteId'] ?>").style.display = "none";
                    document.getElementById("card-footer<?php echo $row['quoteId'] ?>").style.background = "rgba(0,0,0,.03)";
                    document.getElementById("card-header<?php echo $row['quoteId'] ?>").style.background = "rgba(0,0,0,.03)";

                }

                <?php } ?>

                document.getElementById("totalPrice").innerHTML = "LKR " + total.toFixed(2);

                var strLink = "/test/report/tcpdf_lib/examples/quotation_format.php?itemCount=" + productId.length + "&productId=" + productId + "&productPrice=" + productPrice + "&productQty=" + productQty + "&total=" + total;
                document.getElementById("getQuote").setAttribute("href",strLink);

                if(total != 0.0) {
                    document.getElementById("getQuote").style.display = "block";
                    document.getElementById("getQuoteDisabled").style.display = "none";
                } else {
                    document.getElementById("getQuote").style.display = "none";
                    document.getElementById("getQuoteDisabled").style.display = "block";
                }

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
                <h1 class="display-4 text-danger"><img src="../image/quote.png" width="60px"> Quotation</h1>
            </div>
        
        </div>

        <!-- page content row 2 -->
        <div class="container-fluid mt-4">

            <?php
            
                if(isset($_SESSION['digimart_current_user_email'])) {
                    
                    if($quoteCount <= 0){
            ?>

            <!-- quotation empty -->
            <div class="justify-content-center mb-2 px-5 <?php if(isset($_COOKIE['theme']) && ($_COOKIE['theme']=='dark'))echo "text-white"; ?>">
                <img src="../image/quote_empty.png" class="img-fluid mx-auto d-block" style="width:25%;">
                <h2 class="text-center">You don't have any items in your quotation. Let's get shopping!</h2>

                <div class="justify-content-center p-1 d-flex my-5">
                    <a href="../index.php" class="btn btn-outline-danger px-5">Start shopping</a>
                </div>
            </div>

            <?php
                    }
                    else {
            ?>
            
            <!-- quotation not empty -->
            <div class="container">

                <div class="row mt-3">

                    <div class="col-lg-8">

                        <!-- Remove All button -->
                        <div class="row justify-content-end mw-100" id="product-container">
                            <div class="mb-4 d-flex mx-2">
                                <a href='quotation.php?removeAll=1' onclick="return confirm('This action will remove all item from your quotation.');" class="btn btn-outline-danger w-100 px-5"><i class='far fa-trash-alt fa-lg'></i> Remove All</a>
                            </div>
                        </div>

                        <?php 

                            $query2 = "SELECT q.`id` AS 'quoteId', p.* FROM `quotation` q, `product` p WHERE q.`product_id` = p.`id` AND q.`customer_id` = '{$_SESSION['digimart_current_user_id']}' ORDER BY `date_time` DESC";

                            $result = $conn->query($query2);

                            while ($row = $result->fetch_assoc()) { 

                        ?>

                        <!-- items -->
                        <div class="row mw-100" id="product-container">
                            <div class="mb-4 d-flex mx-2 shadow-sm">
                                <div class="card <?php if(isset($_COOKIE['theme']) && ($_COOKIE['theme']=='dark'))echo "text-white bg-dark"; ?>">
                                    <div class="card-header d-flex justify-content-between" id="card-header<?php echo $row['quoteId'] ?>">
                                        <h6 class="lead">Product Id : <?php echo $row['id']; ?></h6>
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input checkItem" id="check<?php echo $row['quoteId'] ?>" onclick="qtyPrice<?php echo $row['quoteId'] ?>()" onchange="qtyPrice<?php echo $row['quoteId'] ?>()">
                                            <label class="custom-control-label" for="check<?php echo $row['quoteId'] ?>"></label>
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
                                            <input type="text" id="price<?php echo $row['quoteId'] ?>" value="<?php echo $row['price']; ?>" hidden>
                                            <div class="pl-3 form-group row d-flex justify-content-start">
                                                <label for="qty" class="col-form-label col-form-label-sm">Quentity </label>
                                                <input type="number" class="form-control form-control-sm col-3 mx-2 <?php if(isset($_COOKIE['theme']) && ($_COOKIE['theme']=='dark'))echo "text-white"; ?>" id="qty<?php echo $row['quoteId'] ?>" min="1" value="1" onchange="qtyPrice<?php echo $row['quoteId'] ?>()" onkeydown="qtyPrice<?php echo $row['quoteId'] ?>()" onkeyup="qtyPrice<?php echo $row['quoteId'] ?>()" onselect="qtyPrice<?php echo $row['quoteId'] ?>()">
                                                <h5 id="qtyPrice<?php echo $row['quoteId'] ?>" class="text-secondary">LKR <?php echo $row['price']; ?></h5>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card-footer text-right" id="card-footer<?php echo $row['quoteId'] ?>">
                                        <?php
                                            echo "<a href='quotation.php?remove={$row['quoteId']}' onclick=\"return confirm('This action will remove this item from your quotation.');\" class='text-danger'><i class='far fa-trash-alt fa-lg'></i></a>";
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <?php } ?>
                    
                    </div>

                    <!-- quotation summery div -->
                    <div class="shadow-lg p-4 mb-5 rounded-lg col-lg-4 h-100 <?php if(isset($_COOKIE['theme']) && ($_COOKIE['theme']=='dark'))echo "text-white bg-dark"; ?>">

                        <h2>Quotation</h2>

                        <div class="d-flex justify-content-between">
                            <div class="p-2 font-weight-bold">PRODUCT ID X QTY</div>
                            <div class="p-2 font-weight-bold">PRICE (LKR)</div>
                        </div>

                        <?php 

                            $query2 = "SELECT q.`id` AS 'quoteId', p.* FROM `quotation` q, `product` p WHERE q.`product_id` = p.`id` AND q.`customer_id` = '{$_SESSION['digimart_current_user_id']}' ORDER BY `date_time` DESC";

                            $result = $conn->query($query2);

                            while ($row = $result->fetch_assoc()) { 

                        ?>

                        <div class="d-flex justify-content-between">
                            <div class="p-2" id="itemId<?php echo $row['quoteId'] ?>"><?php echo $row['id'] ?> X <font id="itemQty<?php echo $row['quoteId'] ?>">1</font></div>
                            <div class="p-2" id="itemTotal<?php echo $row['quoteId'] ?>"><?php echo $row['price']; ?></div>
                            <input type="text" id="itemTotal1<?php echo $row['quoteId'] ?>" value="<?php echo $row['price']; ?>" hidden>
                        </div>

                        <?php } ?>

                        <div class="d-flex border-top mt-4 border-danger">
                            <div class="mr-auto p-2"><h5>Total</h5></div>
                            <div class="p-2"><h5 id="totalPrice"></h5></div>
                        </div>

                        <button id="getQuoteDisabled" class="btn btn-outline-danger w-100 mt-3" data-toggle="tooltip" data-placement="bottom" title="Select item" disabled>Get Quotation as PDF</button>
                        <a href='' id="getQuote" target="_blank" name="getQuote" class="btn btn-danger w-100 mt-3">Get Quotation as PDF</a>

                    </div>

                </div>

                <br>

            </div>
            
            <?php

                    }                
                }
                else {

            ?>

            <!-- quest user cannot use quotation -->
            <div class="justify-content-center mb-2 px-5 <?php if(isset($_COOKIE['theme']) && ($_COOKIE['theme']=='dark'))echo "text-white"; ?>">
                <img src="../image/cart_empty.png" class="img-fluid mx-auto d-block" style="width:25%;">
                <h2 class="text-center">You don't have any items in your quotation.</h2>
                <h3 class="text-center lead mt-4">Have an account? Sign in to see your items.</h3>

                <div class="justify-content-center p-1 d-flex my-5">
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