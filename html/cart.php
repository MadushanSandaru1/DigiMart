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
        //var_dump($_SESSION['productQty']);
        header('Location: mail_and_payment.php');
        
    }

?>

<!DOCTYPE html>
<html>
<head>
    <!-- title -->
	<title>Shopping Cart | DigiMart</title>
    
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
        
        .form-control-sm, .form-control-sm:focus {
            background-color: transparent;
        }
        
        #getCartDisabled {
            display: block;
        }
        
        #getCart {
            display: none;
        }
        
    </style>
    
    <script>
        $(document).ready(function(){
            $('[data-toggle="tooltip"]').tooltip();
        });
        
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
            document.getElementById("getCart").setAttribute("href",strLink);
            
            if(total != 0.0) {
                document.getElementById("getCart").style.display = "block";
                document.getElementById("getCartDisabled").style.display = "none";
            } else {
                document.getElementById("getCart").style.display = "none";
                document.getElementById("getCartDisabled").style.display = "block";
            }
        
        }
        
        /*function checkAll() {
            $("#checkAll").change(function () {
                $("input:checkbox").prop('checked', $(this).prop("checked"));
            });
        }*/
    </script>
    
    
</head>
    
<body onload="calculateTotal()">
    
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
                
                if($cartCount <= 0){
        ?>
        
        <div class="justify-content-center mb-2 p-5 <?php if(isset($_COOKIE['theme']) && ($_COOKIE['theme']=='dark'))echo "text-white"; ?>" style="height: 300px;">
            <h2 class="text-center">You don't have any items in your shopping cart. Let's get shopping!</h2>
            
            <div class="justify-content-center p-1 d-flex mt-4">
                <a href="../index.php" class="btn btn-outline-danger px-5">Start shopping</a>
            </div>
        </div>
        
        <?php
                }
                else {
        ?>
        
        
        
        
        
        
        
        <div class="container">
            
            <div class="row mt-3">

                <div class="col-lg-8">
                    
                    <div class="row justify-content-end mw-100" id="product-container">
                        <div class="mb-4 d-flex mx-2">
                            <a href='cart.php?removeAll=1' onclick="return confirm('This action will remove all item from your shopping cart.');" class="btn btn-outline-danger w-100 px-5"><i class='far fa-trash-alt fa-lg'></i> Remove All</a>
                        </div>
                    </div>
                    
                    <?php 

                        $query2 = "SELECT c.`id` AS 'cartId', p.* FROM `shopping_cart` c, `product` p WHERE c.`product_id` = p.`id` AND c.`customer_id` = '{$_SESSION['digimart_current_user_id']}' ORDER BY `date_time` DESC";

                        $result = $conn->query($query2);

                        while ($row = $result->fetch_assoc()) { 

                    ?>
                    
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
                
                <div class="shadow-lg p-4 mb-5 rounded-lg col-lg-4 h-100 <?php if(isset($_COOKIE['theme']) && ($_COOKIE['theme']=='dark'))echo "text-white bg-dark"; ?>">
                    
                    <h2>Order</h2>
                    
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
                    
                    <button id="getCartDisabled" class="btn btn-outline-danger w-100 mt-3" data-toggle="tooltip" data-placement="bottom" title="Select item" disabled>Buy</button>
                    <a href='' id="getCart" name="getCart" class="btn btn-danger w-100 mt-3">Buy</a>

                </div>
                <!-- /.col-lg-3 -->

            </div>

            <br>

        </div>
        
        
        
        
        <?php
                    
                }                
            }
            else {
                
        ?>
        
        <div class="justify-content-center mb-2 p-5 <?php if(isset($_COOKIE['theme']) && ($_COOKIE['theme']=='dark'))echo "text-white"; ?>" style="height: 300px;">
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