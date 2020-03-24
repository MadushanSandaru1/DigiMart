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
	    
        $sql = "DELETE FROM `quotation` WHERE `customer_id` = '{$_SESSION['digimart_current_user_id']}' AND `id` = {$_GET['remove']}";
        
        mysqli_query($conn, $sql);
        
        header('Location: quotation.php');
    
    }

    if(isset($_GET['removeAll'])) {
	    
        $sql = "DELETE FROM `quotation` WHERE `customer_id` = '{$_SESSION['digimart_current_user_id']}'";
        
        mysqli_query($conn, $sql);
        
        header('Location: quotation.php');
    
    }


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
        
        #getQuoteDisabled {
            display: block;
        }
        
        #getQuote {
            display: none;
        }
        
    </style>
    
    <script>
        $(document).ready(function(){
            $('[data-toggle="tooltip"]').tooltip();
        });
        
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
            <h1 class="display-5 text-danger"><img src="../image/mail.png" width="60px"> Mail Information</h1>
        </div>
        
        
        
    </div>
    
    <div class="container-fluid mt-4">
        
        <div class="container">
            
            <div class="row mt-3">

                <div class="col-lg-8 shadow-sm <?php if(isset($_COOKIE['theme']) && ($_COOKIE['theme']=='dark'))echo "text-white bg-dark"; ?>">
                    
                    <div class="row mw-100 p-2" id="product-container">
                        <div class="d-flex m-3">
                            <a href='quotation.php?removeAll=1' onclick="return confirm('This action will remove all item from your quotation.');" class="btn btn-outline-danger w-100 px-5"><i class="fas fa-plus fa-lg"></i> Add a new address</a>
                        </div>
                    </div>
                    
                    <div class="row mw-100 p-2" id="product-container">
                        
                        <div class="col-6 d-flex">
                            <div class="card border-danger <?php if(isset($_COOKIE['theme']) && ($_COOKIE['theme']=='dark'))echo "text-white bg-dark"; ?>">
                                <div class="card-header">Default Address</div>
                                <div class="card-body text-danger">
                                    <h5 class="card-title">Madushan Sandaruwan</h5>
                                    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-6 d-flex">
                            <div class="card border-danger <?php if(isset($_COOKIE['theme']) && ($_COOKIE['theme']=='dark'))echo "text-white bg-dark"; ?>">
                                <div class="card-header">Header</div>
                                <div class="card-body text-danger">
                                    <h5 class="card-title">Danger card title</h5>
                                    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <?php 

                        $query2 = "SELECT q.`id` AS 'quoteId', p.* FROM `quotation` q, `product` p WHERE q.`product_id` = p.`id` AND q.`customer_id` = '{$_SESSION['digimart_current_user_id']}' ORDER BY `date_time` DESC";

                        $result = $conn->query($query2);

                        while ($row = $result->fetch_assoc()) { 

                    ?>
                    
                    <div class="row mw-100 shadow-sm <?php if(isset($_COOKIE['theme']) && ($_COOKIE['theme']=='dark'))echo "text-white bg-dark"; ?>" id="product-container">
                        <div class="m-3 d-flex">
                            
                            <div class="card <?php if(isset($_COOKIE['theme']) && ($_COOKIE['theme']=='dark'))echo "text-white bg-dark"; ?>">
                                <div class="card-header d-flex justify-content-between" id="card-header<?php echo $row['quoteId'] ?>">
                                    <h6 class="lead">Default Address</h6>
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
                                        echo "<a href='quotation.php?remove={$row['quoteId']}' onclick=\"return confirm('This action will remove this item from your quotation.');\" class='text-danger mx-5'><i class='far fa-trash-alt fa-lg'></i></a>";
                                        echo "<a href='quotation.php' class='btn btn-outline-danger px-5'>Buy</a>";
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <?php } ?>
                    

                </div>

            </div>

            <br>

        </div>
        
    </div>
    
    <?php
        require_once('footer.php');
    ?>
    
</body>
</html>