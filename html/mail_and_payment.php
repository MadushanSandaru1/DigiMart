<?php

    require_once('../connection/connection.php');

    session_start();

    if(isset($_GET['currency'])){
        setcookie("currency_type", $_GET['currency'], time() + (86400 * 30), "/");
        header('Location: '.$_SERVER['PHP_SELF']);
    }

    if(isset($_GET['theme'])){
        setcookie("theme", $_GET['theme'], time() + (86400 * 30), "/");
        header('Location: '.$_SERVER['PHP_SELF']);
    }



    if(isset($_GET['remove'])) {
	    
        $sql = "DELETE FROM `shopping_cart` WHERE `customer_id` = '{$_SESSION['digimart_current_user_id']}' AND `id` = {$_GET['remove']}";
        
        mysqli_query($conn, $sql);
        
        header('Location: cart.php');
    
    }

    if(isset($_GET['removeAll'])) {
	    
        $sql = "DELETE FROM `shopping_cart` WHERE `customer_id` = '{$_SESSION['digimart_current_user_id']}'";
        
        mysqli_query($conn, $sql);
        
        header('Location: cart.php');
    
    }


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

    if(isset($_GET['buy'])) {

        $i = 0;
        
        if(is_array($_SESSION['productId'])) {
            while ($i < $_SESSION['itemCount']) {

                $inserQuery = "INSERT INTO `order_product`(`customer_id`, `product_id`, `quantity`, `unit_price`) VALUES ('{$_SESSION['digimart_current_user_id']}',{$_SESSION['productId'][$i]},{$_SESSION['productQty'][$i]},{$_SESSION['productPrice'][$i]})";

                $resultInsert = mysqli_query($conn, $inserQuery);

                if ($resultInsert) {
                    $deleteQuery = "DELETE FROM `shopping_cart` WHERE `customer_id` = '{$_SESSION['digimart_current_user_id']}' AND `product_id` = {$_SESSION['productId'][$i]}";

                    $result = mysqli_query($conn, $deleteQuery);

                } else {
                    //echo "Error: " . $sql . "<br>" . mysqli_error($conn);
                }

                $i++;
            }
        } else {
            $inserQuery = "INSERT INTO `order_product`(`customer_id`, `product_id`, `quantity`, `unit_price`) VALUES ('{$_SESSION['digimart_current_user_id']}',{$_SESSION['productId']},{$_SESSION['productQty']},{$_SESSION['productPrice']})";

            $resultInsert = mysqli_query($conn, $inserQuery);
        }
        
        $_SESSION['itemCount'] = null;
        $_SESSION['productId'] = null;
        $_SESSION['productPrice'] = null;
        $_SESSION['productQty'] = null;
        $_SESSION['total'] = null;
        
        header('Location: customer_order.php');
    }

?>

<!DOCTYPE html>
<html>
<head>
    <!-- title -->
	<title>Mail and Payment | DigiMart</title>
    
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
        
        .display-5 {
            font-family: 'Atomic Age';
        }
        
        .form-control-sm, .form-control-sm:focus {
            background-color: transparent;
        }
        
        #buyDisabled {
            display: block;
        }
        
        #buy {
            display: none;
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
        
    </style>
    
    <script>
        $(document).ready(function(){
            $('[data-toggle="tooltip"]').tooltip();
        });
        
        $(document).ready(function(){
            $('body').on('keyup', '.paymentInput', function(e){
                paymentAnotherCheck();
            });
        });
        
        $(document).ready(function(){
            $('body').on('keyup', '.mailInput', function(e){
                mailAnotherCheck();
            });
        });
        
        
        function paymentOrMailMethodChange() {
            
            if(($('#paymentDefault').is(':checked')) && ($('#mailDefault').is(':checked'))){
                $('#paymentAnotherDiv :input').attr('disabled', true);
                document.getElementById("bankCardNo").style.color = "rgba(221,18,60,1)";
                document.getElementById("buy").style.display = "block";
                document.getElementById("buyDisabled").style.display = "none";
            }
            
            if($('#paymentAnother').is(':checked')){
                $('#paymentAnotherDiv :input').removeAttr('disabled');
                document.getElementById("bankCardNo").style.color = "rgba(130,138,145,1)";
                document.getElementById("buy").style.display = "none";
                document.getElementById("buyDisabled").style.display = "block";
            }
            
        }
        
        function mailAnotherCheck() {
            var mailName = document.getElementById("mailName").value.length;
            var mailCity = document.getElementById("mailCity").value.length;
            var mailZip = document.getElementById("mailZip").value.length;
            var mailMobile = document.getElementById("mailMobile").value.length;
            
            if(mailName!=0 && mailCity!=0 && mailZip!=0 && mailMobile!=0) {
                document.getElementById("buy").style.display = "block";
                document.getElementById("buyDisabled").style.display = "none";
            } else {
                document.getElementById("buy").style.display = "none";
                document.getElementById("buyDisabled").style.display = "block";
            }
            
        }
        
        function paymentAnotherCheck() {
            var cardName = document.getElementById("cardName").value.length;
            var cardNo = document.getElementById("cardNo").value.length;
            var cardExp = document.getElementById("cardExp").value.length;
            var cardCvv = document.getElementById("cardCvv").value.length;
            
            if(cardName!=0 && cardNo!=0 && cardExp!=0 && cardCvv!=0) {
                document.getElementById("buy").style.display = "block";
                document.getElementById("buyDisabled").style.display = "none";
            } else {
                document.getElementById("buy").style.display = "none";
                document.getElementById("buyDisabled").style.display = "block";
            }
            
        }
    </script>
    
    
</head>
    
<body onload="paymentOrMailMethodChange()">
    
    <?php
        require_once('header_half.php');
    ?>
    
    <div class="container-fluid mt-5">
    
        <div class="container">
            
            <div class="row mt-3">

                <div class="col-lg-8 mb-4">
                    
                    <div class="p-3 shadow-lg rounded-lg <?php if(isset($_COOKIE['theme']) && ($_COOKIE['theme']=='dark'))echo "text-white bg-dark"; ?>">
                    
                        <div class="row mw-100 mx-3" id="product-container">
                            <h4>Mail Information</h4>
                        </div>

                        <div class="row mw-100 p-2" id="product-container">

                            <?php 

                                $query2 = "SELECT * FROM `customer_mail_info` WHERE `customer_id` = '{$_SESSION['digimart_current_user_id']}' AND `is_deleted` = 0 ORDER BY `is_default` DESC";

                                $result = $conn->query($query2);
                            
                                if (mysqli_num_rows($result) > 0) {
                                    while ($row = $result->fetch_assoc()) { 

                            ?>

                            <div class="col-6 d-flex" id="mailCard">
                                <div class="card border-danger <?php if(isset($_COOKIE['theme']) && ($_COOKIE['theme']=='dark'))echo "text-white bg-dark"; ?>">
                                    <div class="card-header d-flex justify-content-between" id="card-header<?php echo $row['id']; ?>">
                                        <div class="custom-control custom-checkbox">
                                            <input type="radio" class="custom-control-input"  name="mailRadio" id="mail<?php if($row['is_default']==1) echo "Default"; else echo $row['id']; ?>" <?php if($row['is_default']==1) echo "checked"; ?>>
                                            <label class="custom-control-label" for="mail<?php if($row['is_default']==1) echo "Default"; else echo $row['id']; ?>"><?php if($row['is_default']==1) echo "Default Address"; ?></label>
                                        </div>
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
                                    </div>
                                </div>
                            </div>

                            <?php
                                    }
                                } else {
                                    
                            ?>
                            
                            
                            <div class="col-6">
                                <div class="form-group">
                                    <input type="text" class="form-control mailInput" maxlength="100" id="mailName" placeholder="NAME *">
                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control mailInput" maxlength="100" id="mailStreet1" placeholder="STREET 1">
                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control mailInput" maxlength="100" id="mailStreet2" placeholder="STREET 2">
                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control mailInput" maxlength="100" id="mailCity" placeholder="CITY *">
                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control mailInput" maxlength="11" id="mailZip" placeholder="ZIP CODE *">
                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control mailInput" maxlength="10" id="mailMobile" placeholder="MOBILE NO *">
                                </div>
                                <div class="custom-control custom-checkbox mb-2">
                                    <input type="checkbox" class="custom-control-input" id="saveCard">
                                    <label class="custom-control-label" for="saveAddress">Save this address</label>
                                </div>
                                
                            </div>
                            
                            
                            <?php
                                    
                                }
                            
                            ?>


                        </div>
                    
                    </div>
                    
                    
                    <div class="p-3 mt-3 shadow-lg rounded-lg <?php if(isset($_COOKIE['theme']) && ($_COOKIE['theme']=='dark'))echo "text-white bg-dark"; ?>">
                    
                        <div class="row mw-100 mx-3 mt-3" id="product-container">
                            <h4>Payment Information</h4>
                        </div>

                        <div class="row mw-100 p-2" id="product-container">

                            <?php
                            
                                $flag = 0;

                                $query2 = "SELECT * FROM `customer_payment_info` WHERE `customer_id` = '{$_SESSION['digimart_current_user_id']}' AND `is_deleted` = 0";

                                $result = $conn->query($query2);

                                while ($row = $result->fetch_assoc()) {
                                    $flag = 1;

                            ?>

                            <div class="col-6">
                                <div class="custom-control custom-checkbox mb-2">
                                    <input type="radio" class="custom-control-input" onclick="paymentOrMailMethodChange()" onchange="paymentOrMailMethodChange()"  name="paymentRadio" id="paymentDefault" checked>
                                    <label class="custom-control-label" for="paymentDefault">Default Card</label>
                                </div>
                                <div class="card border-danger <?php if(isset($_COOKIE['theme']) && ($_COOKIE['theme']=='dark'))echo "text-white bg-dark"; ?>">
                                    <div class="card-body text-danger">
                                        <h5 class="card-title" id="bankCardNo"><?php echo $row['card_no']; ?></h5>
                                        <img src="../image/paymentMethod.png" width="100px">
                                    </div>
                                </div>
                            </div>

                            <?php } ?>
                            
                            <div class="col-6">
                                <div class="custom-control custom-checkbox mb-2">
                                    <input type="radio" class="custom-control-input" onclick="paymentOrMailMethodChange()" onchange="paymentOrMailMethodChange()" name="paymentRadio" id="paymentAnother" <?php if($flag==0) echo "checked"; ?>>
                                    <label class="custom-control-label" for="paymentAnother">Another Card</label>
                                </div>
                                <div id="paymentAnotherDiv">
                                    <div class="form-group">
                                        <input type="text" class="form-control paymentInput" maxlength="25" id="cardName" placeholder="CARD HOLDER NAME *" required disabled>
                                    </div>
                                    <div class="form-group">
                                        <input type="text" class="form-control paymentInput" maxlength="20" id="cardNo" placeholder="CARD NUMBER *" required disabled>
                                    </div>
                                    <div class="form-group">
                                        <input type="text" class="form-control paymentInput" maxlength="5" id="cardExp" placeholder="EXPIRES *" required disabled>
                                    </div>
                                    <div class="form-group">
                                        <input type="number" class="form-control paymentInput" id="cardCvv" placeholder="CVV *" required disabled>
                                    </div>
                                </div>
                                
                            </div>


                        </div>
                        
                    </div>
                    

                </div>
                
                <div class="shadow-lg p-4 mb-4 rounded-lg col-lg-4 h-100 <?php if(isset($_COOKIE['theme']) && ($_COOKIE['theme']=='dark'))echo "text-white bg-dark"; ?>">
                    
                    <h2>Order</h2>
                    
                    <div class="d-flex justify-content-between">
                        <div class="p-2 font-weight-bold">PRODUCT ID X QTY</div>
                        <div class="p-2 font-weight-bold">PRICE (LKR)</div>
                    </div>
                    
                    <?php
                    if(is_array($_SESSION['productId'])) {
                        if(isset($_SESSION['itemCount'])) {

                            $i = 0;

                            while ($i < $_SESSION['itemCount']) {
                    
                    ?>
                    
                    <div class="d-flex justify-content-between">
                        <div class="p-2"><?php echo $_SESSION['productId'][$i]; ?> X <?php echo $_SESSION['productQty'][$i]; ?></div>
                        <div class="p-2"><?php echo number_format($_SESSION['productPrice'][$i]*$_SESSION['productQty'][$i], 2); ?></div>
                    </div>
                    
                    <?php
                                $i++;
                            }
                        }
                    } else {
                    
                    ?>
                    
                    <div class="d-flex justify-content-between">
                        <div class="p-2"><?php echo $_SESSION['productId']; ?> X <?php echo $_SESSION['productQty']; ?></div>
                        <div class="p-2"><?php echo number_format($_SESSION['productPrice']*$_SESSION['productQty'], 2); ?></div>
                    </div>
                    
                    <?php
                        
                    }
                    
                    ?>
                    
                    <div class="d-flex border-top mt-4 border-danger">
                        <div class="mr-auto p-2"><h5>Total</h5></div>
                        <div class="p-2"><h5 id="totalPrice">LKR <?php echo number_format($_SESSION['total'], 2); ?></h5></div>
                    </div>
                    
                    <button id="buyDisabled" class="btn btn-outline-danger w-100 mt-3" data-toggle="tooltip" data-placement="bottom" title="Select item" disabled>Buy</button>
                    <a onclick="window.location.href = 'mail_and_payment.php?buy=1';" id="buy" name="buy" class="btn btn-danger w-100 mt-3">Buy</a>

                </div>
                <!-- /.col-lg-3 -->
                    
            </div>

            <br>

        </div>
    
    </div>
    
    <?php
        require_once('footer.php');
    ?>
    
</body>
</html>