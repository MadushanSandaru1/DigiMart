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

    //Buy button submit
    if(isset($_GET['buyProductId'])) {
        
        $_SESSION['productId'] = $_GET['buyProductId'];
        $_SESSION['productPrice'] = $_GET['productPrice'];
        $_SESSION['productQty'] = $_GET['productQty'];
        $_SESSION['total'] = $_GET['productPrice']*$_GET['productQty'];
        
        header('Location: mail_and_payment.php');
        
    }

    //product details
    if(isset($_GET['productId'])) {
        
        $sql = "SELECT p.*, b.`logo` FROM `product` p, `brand` b WHERE p.`id` = {$_GET['productId']} AND p.`brand_id` = b.`id`";

        $result = mysqli_query($conn, $sql);

        $productInfo = mysqli_fetch_assoc($result);
        
    }

?>

<!DOCTYPE html>
<html>
<head>
    <!-- title -->
	<title>Product | DigiMart</title>
    
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
        
        .hr1 {
            border-top: 1px solid #dd123d;
        }
        
    </style>
    
    <!-- Script -->
    <script>
        //for tooltips
        $(document).ready(function(){
            $('[data-toggle="tooltip"]').tooltip();
        });
        
        //for calculate price of quantity
        function qtyPrice() {
            
            if(document.getElementById("qty").value == "" || document.getElementById("qty").value == 0){
                document.getElementById("qty").value = 1;
            }
            
            var qty = document.getElementById("qty").value;
            var price = parseFloat(document.getElementById("price").value);
            var qtyPrice = qty*price;
            document.getElementById("qtyPrice").innerHTML = "LKR " + qtyPrice.toFixed(2);
            
            var strLink = "product.php?buyProductId=" + <?php echo $productInfo['id']; ?> + "&productPrice=" + price + "&productQty=" + qty;
            
            document.getElementById("getBuy").setAttribute("href",strLink);
        }
    </script>
    
    </head>
    
    <body>

        <!-- import navbar -->
        <?php
            require_once('header_half.php');
        ?>

        <!-- page content row 1 | topic -->
        <div class="container">

            <div class="mt-4">
                <h1 class="text-danger"><?php echo $productInfo['name']; ?></h1>
            </div>
        
        </div>

        <!-- page content row 2 -->
        <div class="container-fluid mt-4">

            <!-- quotation not empty -->
            <div class="container">

                <div class="row mt-3">

                    <div class="col-lg-12">

                        <!-- items -->
                        <div class="row mw-100" id="product-container">
                            <div class="mb-4 d-flex mx-2 shadow-sm">
                                <div class="card <?php if(isset($_COOKIE['theme']) && ($_COOKIE['theme']=='dark'))echo "text-white bg-dark"; ?>">
                                    <div class="card-header d-flex justify-content-between" id="card-header">
                                        <h6 class="lead">Product Id : <?php echo $productInfo['id']; ?></h6>
                                    </div>
                                    <div class="d-flex justify-content-between p-2">
                                        <div class="col-5 card-img">
                                            <a><img class="card-img-top" src="../image/product/<?php echo $productInfo['image'] ?>" alt=""></a>
                                        </div>
                                        <div class="p-3">
                                            <h5 class="card-title">
                                                <address class="text-justify"><?php echo $productInfo['description']?></address>
                                                <div class="d-flex flex-column text-danger">
                                                    <h6 class=''>
                                                        <?php
                                                            $reviewSql = "SELECT AVG(`review_value`) AS 'review' FROM `product_review` WHERE `product_id` = '{$productInfo['id']}' LIMIT 1";
                                
                                                            $reviewResult = mysqli_query($conn, $reviewSql);

                                                            if (mysqli_num_rows($reviewResult) > 0) {
                                                                while($reviewRow = mysqli_fetch_assoc($reviewResult)) {
                                                                    $rate = $reviewRow['review'];
                                                                }
                                                            } else {
                                                                $rate = 0;
                                                            }
                                                             for($count=1;$count<6;$count++) {
                                                                if($rate>=$count) {
                                                                    echo "<i class='fas fa-star fa-sm'></i>&nbsp;";
                                                                }
                                                                else {
                                                                    echo "<i class='far fa-star fa-sm'></i>&nbsp;";
                                                                }
                                                             }
                                                             echo "&nbsp;".number_format($rate,1);
                                                        ?>
                                                    </h6>
                                                </div>
                                            </h5>
                                            <hr class="hr1">
                                            <h2 class="mb-3">LKR <?php echo number_format($productInfo['price'],2); ?></h2>
                                            <input type="text" id="price" value="<?php echo $productInfo['price']; ?>" hidden>
                                            <div class="pl-3 form-group row d-flex justify-content-start">
                                                <label for="qty" class="col-form-label col-form-label-sm">Quentity </label>
                                                <input type="number" class="form-control form-control-sm col-2 mx-2 <?php if(isset($_COOKIE['theme']) && ($_COOKIE['theme']=='dark'))echo "text-white"; ?>" id="qty" min="1" value="1" onchange="qtyPrice()" onkeydown="qtyPrice()" onkeyup="qtyPrice()" onselect="qtyPrice()">
                                                <h3 id="qtyPrice" class="text-secondary">LKR <?php echo $productInfo['price']; ?></h3>
                                            </div>
                                            <hr class="hr1">
                                            <img class='' src="../image/brand/<?php echo $productInfo['logo']; ?>" height='50px'>
                                        </div>
                                    </div>

                                    <div class="card-footer d-flex justify-content-end" id="card-footer">
                                        <?php
                                            if(isset($_SESSION['digimart_current_user_id'])) {
                                        ?>
                                        
                                        <a href='' id="addCart" name="addCart" class="btn btn-warning px-3 mr-4">Add to cart</a>
                                        <a href='<?php echo 'product.php?buyProductId='.$productInfo['id'].'&productPrice='.$productInfo['price'].'&productQty=1'; ?>' id="getBuy" name="getBuy" class="btn btn-danger px-5">Buy</a>
                                        <?php
                                            } else {
                                        ?>
                                        
                                        <button id="addCartDisabled" class="btn btn-outline-warning px-3 mr-4" data-toggle="tooltip" data-placement="bottom" title="Login first" disabled>Add to cart</button>
                                        <button id="getBuyDisabled" class="btn btn-outline-danger px-5" data-toggle="tooltip" data-placement="bottom" title="Login first" disabled>Buy</button>
                                        
                                        <?php
                                            }
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- review -->
                        <div class="row pr-4">
                            <div class="mb-4 mx-2 shadow-sm w-100">
                                <div class="card <?php if(isset($_COOKIE['theme']) && ($_COOKIE['theme']=='dark'))echo "text-white bg-dark"; ?>">
                                    
                                    <div class="p-5">
                                        <h4 class="card-title">Customer review</h4>
                                        
                                        <table class="table <?php if(isset($_COOKIE['theme']) && ($_COOKIE['theme']=='dark')) echo "text-white table-dark"; ?>">
                                            <tbody>

                                                <?php

                                                    $query2 = "SELECT * FROM `product_review` WHERE `product_id` = {$productInfo['id']} ORDER BY `review_value` DESC";

                                                    $result = $conn->query($query2);

                                                    if (mysqli_num_rows($result) > 0) {
                                                        while ($row = $result->fetch_assoc()) {
                                                ?>
                                                <tr>
                                                    <th scope="row"><?php echo $row['customer_id']; ?></th>
                                                    <td class="d-flex justify-content-start">
                                                        <h6 class=""><?php echo $row['review_text']; ?></h6>
                                                    </td>
                                                    <td class="text-right">
                                                        <div class="d-flex flex-column text-danger">
                                                            <h6 class=''>
                                                                <?php
                                                                    $rate = $row['review_value'];

                                                                    for($count=1;$count<6;$count++) {
                                                                        if($rate>=$count) {
                                                                            echo "<i class='fas fa-star fa-sm'></i>&nbsp;";
                                                                        }
                                                                        else {
                                                                            echo "<i class='far fa-star fa-sm'></i>&nbsp;";
                                                                        }
                                                                    }
                                                                    echo "&nbsp;".number_format($rate,1);
                                                                ?>
                                                            </h6>
                                                        </div>
                                                    </td>
                                                </tr>


                                                <?php
                                                        }
                                                    }

                                                ?>

                                            </tbody>
                                        </table>
                                        
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                    
                    </div>

                </div>

                <br>

            </div>

        </div>

        <!-- footer -->
        <?php
            require_once('footer.php');
        ?>

    </body>
</html>