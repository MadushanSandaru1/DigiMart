<?php

    require_once('../connection/connection.php');

    session_start();

    date_default_timezone_set("Asia/Colombo");
    $alert = "";
    $alertStatus = 0;

    if(isset($_GET['theme'])){
        setcookie("theme", $_GET['theme'], time() + (86400 * 30), "/");
        header('Location: '.$_SERVER['PHP_SELF']);
    }

    $unreadMsgCount = 0;

    if(isset($_SESSION['digimart_current_user_id'])){
        
        $sql = "SELECT COUNT(*) AS 'unreadMsg' FROM `customer_message` WHERE `to` = 'digimart' AND `is_unread` = 1 AND `is_deleted` = 0";
        
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_assoc($result)) {
                $unreadMsgCount = $row['unreadMsg'];
            }
        }
    }

    if(isset($_POST['btnSubmit'])){
        
        $proId = $_POST["proId"];
        $proName = $_POST["proName"];
        $proDescription = $_POST["proDescription"];
        $proPrice = $_POST["proPrice"];
        $brandId = $_POST["brandId"];
        $categoryId = $_POST["categoryId"];

        if(isset($_FILES['proImage'])){
            $targetDir = "../image/product/";
            $fileName = $_FILES['proImage']['name'];
            $tmpFileName = $_FILES['proImage']['tmp_name'];
            $pathForSave = $targetDir.$fileName;

            $status = 0;

            $status = move_uploaded_file($tmpFileName, $pathForSave);

            if($status){
                $sql="INSERT INTO `product`(`id`, `name`, `description`, `image`, `price`, `brand_id`, `category_id`) VALUES ({$proId}, '{$proName}', '{$proDescription}', '{$fileName}', '{$proPrice}', {$brandId}, {$categoryId})";
                $sqlResult=mysqli_query($conn,$sql);
            }
        } else {
            $sql="INSERT INTO `product`(`id`, `name`, `description`, `image`, `price`, `brand_id`, `category_id`) VALUES ({$proId}, '{$proName}', '{$proDescription}', '{$fileName}', '{$proPrice}', {$brandId}, {$categoryId})";
             $sqlResult=mysqli_query($conn,$sql);
        }
        
        $alertStatus = 1;
        
        
    }

    if(isset($_GET['deleteProduct'])){
        
        $deleteProduct = $_GET['deleteProduct'];
        
        
        $sql = "UPDATE `product` SET `is_deleted`= 1 WHERE `id` = '{$deleteProduct}'";
        
        $result = mysqli_query($conn, $sql);
        
        header('Location: digimart_product.php');
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
        
        .sidebar {
            width: 200px;
            position: fixed;
            overflow: auto;
        }

        .sidebar a {
            text-decoration: none;
            color: #dd123d;
        }
        
        .sidebar a:hover:not(.active) {
            background-color: #dd123d;
            color: white;
        }

        div.content {
            margin-left: 220px;
            min-height: 500px;
        }
        
        @media screen and (max-width: 700px) {
            .sidebar {
                width: 100%;
                height: auto;
                position: relative;
                margin-bottom: 10px;
            }
            
            .sidebar a {
                float: left;
            }
            
            div.content {
                margin-left: 0;
            }
        }
        
        @media screen and (max-width: 400px) {
            .sidebar a {
                text-align: center;
                float: none;
            }
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

        .dropDownLink a {
            text-decoration: none;
            color: #dd123d;
            border: 1px solid #dd123d;
            border-radius: 10px;
        }
        
        .dropDownLink a:hover:not(.active) {
            background-color: #dd123d;
            color: white;
        }
        
    </style>
    
    <script>
        $(document).ready(function(){
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>
    
    
</head>
    
<body>
    
    <div class="toastNotify <?php if(isset($_COOKIE['theme']) && ($_COOKIE['theme']=='dark'))echo "bg-dark"; else echo "bg-white"; ?> col-7 col-sm-6 col-md-4 col-lg-3" data-autohide="false">
        <div class="toast-header <?php if(isset($_COOKIE['theme']) && ($_COOKIE['theme']=='dark'))echo "bg-dark"; ?>">
            <strong class="mr-auto text-danger">Successful!</strong>
            <small class="text-muted"></small>
            <button type="button" class="ml-2 mb-1 close text-danger" data-dismiss="toast">&times;</button>
        </div>

        <div class="toast-body <?php if(isset($_COOKIE['theme']) && ($_COOKIE['theme']=='dark'))echo "text-white"; ?>">
            Data has been created.
        </div>
    </div>
    
    <?php
        require_once('digimart_header_half.php');
    ?>
    
    
    <div class="container-fluide">
        
        <nav class="navbar navbar-expand-lg <?php if(isset($_COOKIE['theme']) && ($_COOKIE['theme']=='dark'))echo "navbar-dark bg-dark"; else echo "navbar-light bg-light"; ?> my-3">
            <div class="collapse navbar-collapse d-flex justify-content-center" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item mx-5">
                        <a class="nav-link" href="digimart_account.php">My Account</a>
                    </li>
                    <li class="nav-item active mx-5">
                        <a class="nav-link" href="digimart_manage_digimart.php">Manage DigiMart</a>
                    </li>
                    <li class="nav-item mx-5">
                        <a class="nav-link" href="digimart_message_center.php">Message Center <span class="badge badge-pill badge-danger"><?php if($unreadMsgCount!=0) echo $unreadMsgCount; ?></span></a>
                    </li>
                </ul>
            </div>
        </nav>
        
    </div>
    
    <div class="container">
        <h3 class="text-danger mb-3"><i class="fas fa-tasks"></i> Manage DigiMart</h3>
        
        <div class="sidebar shadow-lg d-flex flex-column rounded-lg <?php if(isset($_COOKIE['theme']) && ($_COOKIE['theme']=='dark')) echo "bg-dark"; ?>">
            <a class="p-3" href="digimart_manage_digimart.php">Dashboard</a>
            
            <?php
                if($_SESSION['digimart_current_user_role'] == "admin"){
            ?>
            
            <a class="p-3" href="digimart_admin.php">Administratior</a>
            <a class="p-3" href="digimart_inventory_officer.php">Inventory Officer</a>
            <a class="p-3" href="digimart_customer.php">Customer</a>
            <a class="p-3" href="digimart_transactions_details.php">Transactions Details</a>
            
            <?php
                } elseif ($_SESSION['digimart_current_user_role'] == "inventory_officer") {
            ?>
            
            <a class="p-3" href="digimart_brand.php">Brand</a>
            <a class="p-3" href="digimart_category.php">Category</a>
            <a class="p-3" href="digimart_product.php">Product</a>
            <a class="p-3" href="digimart_order_details.php">Order Details</a>
            
            <?php
                }
            ?>
            
            <a class="p-3" href="digimart_contact_message.php">Contact Message</a>
        </div>
        
        <div class="content p-1 mb-5 rounded-lg shadow-lg <?php if(isset($_COOKIE['theme']) && ($_COOKIE['theme']=='dark')) echo "bg-dark"; ?>">
            <h4 class="text-danger mb-3"><i class="fas fa-laptop"></i> Product</h4>
            
            <div id="accordion" class="mt-4">
                <div class="m-3 <?php if(isset($_COOKIE['theme']) && ($_COOKIE['theme']=='dark')) echo "bg-dark"; ?>">
                    <div class="dropDownLink ml-4 mb-2">
                        <a class="py-2 px-5" data-toggle="collapse" href="#collapseOne">
                            Add Product
                        </a>
                    </div>
                    <div id="collapseOne" class="collapse" data-parent="#accordion">
                        <div class="row mw-100 p-2" id="product-container">

                            <div class="col-md-6 col-sm-12">
                                <div class="custom-control custom-checkbox">
                                    <form action="digimart_product.php" method="post" enctype="multipart/form-data">
                                        <div class="">

                                            <?php

                                                $queryIoId = "SELECT * FROM `product` ORDER BY `id` DESC LIMIT 1";

                                                $result_set = mysqli_query($conn,$queryIoId);

                                                if (mysqli_num_rows($result_set) == 1) {

                                                    $lastId = mysqli_fetch_assoc($result_set);
                                                    $lastNum = $lastId['id'];

                                                }
                                                else {
                                                    $lastNum = 0;
                                                }

                                                $acnId =  ++$lastNum;

                                            ?>

                                            <div class="form-group">
                                                <label for="proId" class="<?php if(isset($_COOKIE['theme']) && ($_COOKIE['theme']=='dark'))echo "text-white"; ?>">Product Id</label>
                                                <input type="text" class="form-control"  name="proId" id="proId" value="<?php echo $acnId; ?>" readonly>
                                            </div>
                                            <div class="form-group">
                                                <label for="proName" class="<?php if(isset($_COOKIE['theme']) && ($_COOKIE['theme']=='dark'))echo "text-white"; ?>">Product Name</label>
                                                <input type="text" class="form-control" name="proName" placeholder="Product Name *" id="proName" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="proDescription" class="<?php if(isset($_COOKIE['theme']) && ($_COOKIE['theme']=='dark'))echo "text-white"; ?>">Product Description</label>
                                                <textarea class="form-control" id="proDescription" name="proDescription" placeholder="Product Description *" rows="3" required></textarea>
                                            </div>
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input" name="proImage" id="proImage" accept="image/x-png" required>
                                                <label for="proImage" class="custom-file-label">Product Image (.png)</label>
                                            </div>
                                            <div class="form-group">
                                                <label for="proPrice" class="<?php if(isset($_COOKIE['theme']) && ($_COOKIE['theme']=='dark'))echo "text-white"; ?>">Unit Price</label>
                                                <input type="text" class="form-control" name="proPrice" id="proPrice" placeholder="Unit Price *" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="brandId" class="<?php if(isset($_COOKIE['theme']) && ($_COOKIE['theme']=='dark'))echo "text-white"; ?>">Brand Name</label>
                                                <select class="form-control" id="brandId" name="brandId" required>
                                                    
                                                    <?php
                                                    
                                                        $brandQuery = "SELECT * FROM `brand` WHERE `is_deleted` = 0";

                                                        $brandResult = $conn->query($brandQuery);

                                                        while ($brandRow = $brandResult->fetch_assoc()) {
                                                            echo "<option value='".$brandRow['id']."'>".$brandRow['name']."</option>";
                                                        }
                                                    ?>
                                                
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="categoryId" class="<?php if(isset($_COOKIE['theme']) && ($_COOKIE['theme']=='dark'))echo "text-white"; ?>">Category Type</label>
                                                <select class="form-control" id="categoryId" name="categoryId" required>
                                                    
                                                    <?php
                                                    
                                                        $categoryQuery = "SELECT * FROM `category` WHERE `is_deleted` = 0";

                                                        $categoryResult = $conn->query($categoryQuery);

                                                        while ($categoryRow = $categoryResult->fetch_assoc()) {
                                                            echo "<option value='".$categoryRow['id']."'>".$categoryRow['type']."</option>";
                                                        }
                                                    ?>
                                                
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <input type="submit" value="Submit" class="btn btn-outline-danger px-5" id="btnSubmit" name="btnSubmit">
                                            </div>
                                        </div>
                                    </form>

                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            
            <script>
                // Add the following code if you want the name of the file appear on select
                $(".custom-file-input").on("change", function() {
                    var fileName = $(this).val().split("\\").pop();
                    $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
                });
            </script>
            
            <table class="table table-striped <?php if(isset($_COOKIE['theme']) && ($_COOKIE['theme']=='dark')) echo "text-white table-dark"; ?>">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Product</th>
                        <th scope="col"></th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <tbody>

                    <?php

                        $i=1;

                        $query2 = "SELECT p.*, b.`name` AS 'brand', c.`type` AS 'category' FROM `product` p, `brand` b, `category` c WHERE p.`brand_id` = b.`id` AND p.`category_id` = c.`id` AND p.`is_deleted` = 0";

                        $result = $conn->query($query2);

                        if (mysqli_num_rows($result) > 0) {
                            while ($row = $result->fetch_assoc()) {
                    ?>


                    <tr>
                        <th scope="row"><?php echo $i; ?></th>
                        <td>
                            <address>
                                <a class="text-secondary">Product ID: <b class="<?php if($row['is_deleted']!=0) echo "text-secondary"; else echo "text-danger"; ?>"><?php echo $row['id']; ?></b></a><br>
                                <a class="text-secondary">Unit Price: <b class="<?php if($row['is_deleted']!=0) echo "text-secondary"; else echo "text-danger"; ?>">LKR <?php echo number_format($row['price'],2); ?></b></a>
                            </address>
                        </td>
                        <td>
                            <address>
                                <a class="text-secondary">Brand Name: <b class="<?php if($row['is_deleted']!=0) echo "text-secondary"; else echo "text-danger"; ?>"><?php echo $row['brand']; ?></b></a><br>
                                <a class="text-secondary">Category Type: <b class="<?php if($row['is_deleted']!=0) echo "text-secondary"; else echo "text-danger"; ?>"><?php echo $row['category']; ?></b></a>
                            </address>
                        </td>
                        <td class="d-flex justify-content-center">
                            <?php if(($row['is_deleted']==0)) echo "<a href='digimart_product.php?deleteProduct={$row['id']}' onclick=\"return confirm('This action will remove this product from inventory.');\" class='text-danger'><i class='far fa-trash-alt fa-lg'></i></a>"; ?>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"></th>
                        <td class="" colspan="3">
                            <div class="ml-3 d-flex flex-row">
                                <img src="../image/product/<?php echo $row['image']; ?>" width="110px;">
                                <address class="text-justify ml-3">
                                    <a class="text-danger"><b class="<?php if($row['is_deleted']!=0) echo "text-secondary"; ?>"><?php echo $row['name']; ?></b></a><br>
                                    <a class=""><?php echo $row['description']; ?></a>
                                </address>
                            </div>
                        </td>
                    </tr>


                    <?php
                                $i++;
                            }
                        }

                    ?>

                </tbody>
            </table>
            
            
            
        </div>

        
    </div>
    
    <?php
        require_once('footer.php');
    ?>
    
</body>
</html>