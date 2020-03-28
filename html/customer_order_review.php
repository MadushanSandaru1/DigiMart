<?php

    require_once('../connection/connection.php');

    session_start();

    date_default_timezone_set("Asia/Colombo");

    if(isset($_GET['currency'])){
        setcookie("currency_type", $_GET['currency'], time() + (86400 * 30), "/");
        header('Location: '.$_SERVER['PHP_SELF']);
    }

    if(isset($_GET['theme'])){
        setcookie("theme", $_GET['theme'], time() + (86400 * 30), "/");
        header('Location: '.$_SERVER['PHP_SELF']);
    }
        
    if(isset($_GET['itemId'])){
        $itemId = $_GET['itemId'];
        
        $sql = "SELECT * FROM `product_review` WHERE `product_id` = {$itemId} AND `customer_id` = '{$_SESSION['digimart_current_user_id']}'";
        
        $result = mysqli_query($conn, $sql);
                
        if (mysqli_num_rows($result) == 1) {
            header('Location: customer_order.php');
        }
    }

    if(isset($_POST['review'])){
        $reviewProId = $_POST['reviewProId'];
        $reviewRate = $_POST['reviewRate'];
        $reviewComment = $_POST['reviewComment'];
        
        $sql = "INSERT INTO `product_review`(`product_id`, `customer_id`, `review_value`, `review_text`) VALUES ({$reviewProId}, '{$_SESSION['digimart_current_user_id']}', {$reviewRate}, '{$reviewComment}')";
        
        mysqli_query($conn, $sql);
                
        header('Location: customer_order.php');
    }
?>

<!DOCTYPE html>
<html>
<head>
    <!-- title -->
	<title>My Order | DigiMart</title>
    
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
        .form-control {
            border-color: #dd123d;
            color: #dd123d;
            background:none!important;
        }
        
        .form-control:focus {
            border-color: #dd123d;
            color: #dd123d;
        }
        
        textarea::-webkit-scrollbar {
            width: 12px;
            background-color: #F5F5F5;
        }
        
        textarea::-webkit-scrollbar-thumb {
            border-radius: 10px;
            -webkit-box-shadow: inset 0 0 6px rgba(0, 0, 0, 0.1);
            background-color: #dd123d;
            cursor: pointer;
        }
        
        #reviewDisabled {
            display: block;
        }
        
        #review {
            display: none;
        }
        
    </style>
    
    <script>
        $(document).ready(function(){
            $('[data-toggle="tooltip"]').tooltip();
        });
        
        /*function starFill() {
            var element = document.getElementById("star");
            element.classList.toggle("fas");
        }
        
        function starFillOut() {
            var element = document.getElementById("star");
            element.classList.toggle("far");
        }*/
        
        $(document).ready(function () {
            
            <?php 
                $i = 1; $j = 0;
            
                for($i;$i<=5;$i++) {
            ?>
            
            $('#star<?php echo $i; ?>').hover(function () {
            <?php 
                    for($j=$i;$j>=1;$j--) {
            ?>
                
                $('#star<?php echo $j; ?>').removeClass('far');
                $('#star<?php echo $j; ?>').addClass('fas');
                
            <?php
                    }
            ?>
                
            }, function () {
                
            <?php 
                    for($j=$i;$j>=1;$j--) {
            ?>
                
                $('#star<?php echo $j; ?>').removeClass('fas');
                $('#star<?php echo $j; ?>').addClass('far');
                
            <?php
                    }
            ?>
            });
            
            <?php
                }
            ?>
            
        });
        
        function btnActive() {
            
            document.getElementById("review").style.display = "block";
            document.getElementById("reviewDisabled").style.display = "none";
            
        }
    </script>
    
    
</head>
    
<body>
    
    <div class="container">
        
        <div class="row d-flex justify-content-center py-5">
        
            <div class="shadow-lg p-5 mb-4 rounded-lg col-lg-10 h-100 <?php if(isset($_COOKIE['theme']) && ($_COOKIE['theme']=='dark'))echo "text-white bg-dark"; ?>">
                    
                <h2 class="text-center border-top border-bottom border-danger">Product Review</h2>

                <?php
                
                    $query2 = "SELECT * FROM `product` WHERE `id` = {$_GET['itemId']}";

                    $result = $conn->query($query2);

                    $row = $result->fetch_assoc();

                ?>
                <div class="my-4 text-center">
                    <div class="p-2"><h5><?php echo $row['name']; ?></h5></div>
                    <div class="px-5 mx-auto col-5"><img src="../image/product/<?php echo $row['image']; ?>"  class="rounded img-thumbnail"></div>
                </div>
                
                <form method="post" action="customer_order_review.php">
                    <div class="d-flex justify-content-center text-danger">
                        <input type="radio" name="reviewRate" id="r1" value="1" onclick="btnActive()">
                        <label for="r1"><i id="star1" class="far fa-star fa-2x mx-1"></i></label>
                        <input type="radio" name="reviewRate" id="r2" value="2" onclick="btnActive()">
                        <label for="r2"><i id="star2" class="far fa-star fa-2x mx-1"></i></label>
                        <input type="radio" name="reviewRate" id="r3" value="3" onclick="btnActive()">
                        <label for="r3"><i id="star3" class="far fa-star fa-2x mx-1"></i></label>
                        <input type="radio" name="reviewRate" id="r4" value="4" onclick="btnActive()">
                        <label for="r4"><i id="star4" class="far fa-star fa-2x mx-1"></i></label>
                        <input type="radio" name="reviewRate" id="r5" value="5" onclick="btnActive()">
                        <label for="r5"><i id="star5" class="far fa-star fa-2x mx-1"></i></label>
                    </div>

                    <div class="my-4">
                        <div class="form-group">
                            <input type="text" name="reviewProId" value="<?php echo $row['id']; ?>" hidden>
                            <textarea name="reviewComment" class="form-control" placeholder="Leave a comment..." maxlength="255"></textarea>
                        </div>
                    </div>
                    <button id="reviewDisabled" class="btn btn-outline-danger w-100 mt-3" data-toggle="tooltip" data-placement="bottom" title="Review" disabled>Review</button>
                    <button id="review" name="review" class="btn btn-danger w-100 mt-3">Review</button>
                </form>

            </div>
            
        </div>
        
    </div>
    
    <?php
        require_once('footer.php');
    ?>
    
</body>
</html>