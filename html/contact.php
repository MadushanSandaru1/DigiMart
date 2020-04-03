<?php

    //connection start
    require_once('../connection/connection.php');

    //session variable start
    session_start();

    //variable for toast visible
    $alertStatus = 0;

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

    //contact Send Message button submit
    if(isset($_POST['btnMsgSubmit'])){
        
        $name = $_POST['contactName'];
        $email = $_POST['contactEmail'];
        $phone = $_POST['contactPhone'];
        $subject = $_POST['contactSubject'];
        $msg = $_POST['contactMsg'];
        
        $qurey = "INSERT INTO `contact_message`(`name`, `email`, `mobile_no`, `subject`, `message`) VALUES ('{$name}','{$email}','{$phone}','{$subject}','{$msg}')";

        $result = mysqli_query($conn,$qurey);

        if ($result) {
            //if data inserted display tooltips message as Successful
            $alertStatus = 1;
        }
        else{
            //if data not inserted display tooltips message as Unsuccessful
            $alertStatus = 2;
        }
    }
?>

<!DOCTYPE html>
<html>
<head>
    <!-- title -->
	<title>Contact | DigiMart</title>
    
    <!-- title icon -->
    <link rel="icon" type="image/ico" href="../image/logo.png"/>
    
    <!-- Bootstrap CSS -->
    <link type="text/css" href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- CSS -->
    <link type="text/css" href="../css/navbar.css" rel="stylesheet">
    
    <!-- google font -->
    <link href='https://fonts.googleapis.com/css?family=Alata' rel='stylesheet'>
    <link href='https://fonts.googleapis.com/css?family=Atomic Age' rel='stylesheet'>
    <link href='https://fonts.googleapis.com/css?family=Eagle Lake' rel='stylesheet'>
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
        
        .contactDescription {
            background-color: rgba(221,18,60,0.1);
            font-family: 'Alata';
            font-size: 20px;
        }
        
        .contactDescription p {
            font-family: 'Abel';
        }
        
        .display-4 {
            font-family: 'Atomic Age';
        }
        
        .mapouter {
            position:relative;
            text-align:right;
            height:500px;
            width:100%px;
        }
        
        .gmap_canvas {
            overflow:hidden;
            background:none!important;
            height:500px;
            width:100%px;
        }
        
        .contact-form {
            border: 8px solid #dd123d;
            width: 70%;
        }
        
        .contact-form .form-control {
            border-radius:2rem;
        }
        
        .contact-image img{
            border-left: 3px solid #dd123d;
            border-right: 3px solid #dd123d;
            border-radius: 6rem;
            width: 15%;
            margin-top: -8%;
            <?php if(isset($_COOKIE['theme']) && ($_COOKIE['theme']=='dark'))echo "background-color: #404550"; else echo "background-color: #fff"; ?>
        }
        
        .contact-form form{
            padding: 14%;
        }
        
        .contact-form form .row{
            margin-bottom: -8%;
        }
        
        .contact-form h3{
            margin-top: -15%;
            font-family: 'Eagle Lake';
        }
        
        .form-control {
            border-color: #dd123d;
            color: #dd123d;
            padding: 20px;
            background:none!important;
        }
        
        .form-control:focus {
            border-color: #dd123d;
            color: #dd123d;
        }
        
        textarea::-webkit-scrollbar {
            width: 5px;
            background-color: transparent;
        }
        
        textarea::-webkit-scrollbar-thumb {
            border-radius: 10px;
            -webkit-box-shadow: inset 0 0 6px rgba(0, 0, 0, 0.1);
            background-color: #dd123d;
            cursor: pointer;
        }
        
        .toastNotify {
            position: fixed;
            top: 10px;
            right: 10px;
            z-index: 1;
            border: 1px solid #dd123d;
            display: <?php if($alertStatus != 0) echo "block"; else echo "none"; ?>;
            
            -webkit-animation: cssAnimation 8s forwards; 
            animation: cssAnimation 8s forwards;
        }
        
        @keyframes cssAnimation {
            0%   {opacity: 1;}
            50%  {opacity: 0.7;}
            100% {opacity: 0;}
        }
        
        @-webkit-keyframes cssAnimation {
            0%   {opacity: 1;}
            50%  {opacity: 0.7;}
            100% {opacity: 0;}
        }
        
    </style>
    
    <!-- Script -->
    <script>
        //for tooltips
        $(document).ready(function(){
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>

</head>
    
<body>
    
    <!-- toast notification box -->
    <div class="toastNotify <?php if(isset($_COOKIE['theme']) && ($_COOKIE['theme']=='dark'))echo "bg-dark"; else echo "bg-white"; ?> col-7 col-sm-6 col-md-4 col-lg-3" data-autohide="false">
        
        <!-- toast header -->
        <div class="toast-header <?php if(isset($_COOKIE['theme']) && ($_COOKIE['theme']=='dark'))echo "bg-dark"; ?>">
            <strong class="mr-auto text-danger"><?php if($alertStatus == 1) echo "Thank you!"; else echo "Unsuccessful!"; ?></strong>
            <small class="text-muted"></small>
            <button type="button" class="ml-2 mb-1 close text-danger" data-dismiss="toast">&times;</button>
        </div>
        
        <!-- toast body -->
        <div class="toast-body <?php if(isset($_COOKIE['theme']) && ($_COOKIE['theme']=='dark'))echo "text-white"; ?>">
            <?php if($alertStatus == 1) echo "Your message has been sent."; else echo "Failed to send your message."; ?>
        </div>
        
    </div>
    
    <!-- import navbar -->
    <?php
        require_once('header_half.php');
    ?>
    
    <!-- page content row 1 | topic and map -->
    <div class="container">
        
        <!-- Main topic -->
        <div class="mt-4">
            <h1 class="display-4 text-danger"><img src="../image/contact.png" width="60px"> Contact</h1>
        </div>
        
        <!-- Google map -->
        <div class="pb-5">
            <div class="mapouter">
                <div class="gmap_canvas">
                    <iframe width="100%" height="500" id="gmap_canvas" src="https://maps.google.com/maps?q=Faculty%20of%20Technology%2C%20University%20of%20Ruhuna&t=&z=13&ie=UTF8&iwloc=&output=embed" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"></iframe>
                </div>
            </div>
        </div>
        
    </div>
    
    <!-- page content row 2 | feedback form -->
    <div class="container contact-form mt-5">
        
        <!-- top image -->
        <div class="contact-image text-center">
            <img src="../image/contact_image.png" alt="Contact-image"/>
        </div>
        
        <!-- form -->
        <form method="post" action="contact.php">
            
            <!-- heading -->
            <h3 class="text-danger text-center mb-5">Drop Us a Message</h3>
            
            <!-- input fields -->
            <div class="row mb-3">
                <div class="col-md-6">
                    
                    <div class="form-group">
                        <input type="text" name="contactName" class="form-control" pattern="[A-Za-z ]{2,20}" maxlength="20" title="alphabets only" placeholder="Your Name *" value="<?php if(isset($_SESSION['digimart_current_user_email'])) echo $_SESSION['digimart_current_user_first_name']." ".$_SESSION['digimart_current_user_last_name']; ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <input type="email" name="contactEmail" class="form-control" placeholder="Your Email *" maxlength="50" value="<?php if(isset($_SESSION['digimart_current_user_email'])) echo $_SESSION['digimart_current_user_email']; ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <input type="text" name="contactPhone" class="form-control" pattern="0[0-9]{9}" maxlength="10" title="0*********" placeholder="Your Phone Number *" value="" required>
                    </div>
                    
                    <div class="form-group">
                        <input type="text" name="contactSubject" class="form-control" pattern="[A-Za-z ]{2,50}" maxlength="50" title="alphabets only" placeholder="Your Subject *" value="" required>
                    </div>
                    
                </div>
                
                <div class="col-md-6">
                    <div class="form-group">
                        <textarea name="contactMsg" class="form-control" placeholder="Your Message *" maxlength="255" style="width: 100%; height: 200px;" required></textarea>
                    </div>
                </div>
            </div>
            
            <!-- submit button -->
            <div class="row">
                <div class="col-12 d-flex flex-row justify-content-center">
                    <div class="form-group">
                        <input type="submit" name="btnMsgSubmit" class="btn btn-outline-danger" value="Send Message" required>
                    </div>
                </div>
            </div>
            
        </form>
    </div>
    
    <!-- page content row 3 | contact information -->
    <div class="container-fluid contactDescription mt-4">
        <div class="container pt-5">
            
            <!-- Digimart name -->
            <div class="row">
                <div class="col-12 <?php if(isset($_COOKIE['theme']) && ($_COOKIE['theme']=='dark'))echo "text-white"; else echo "text-danger"; ?>">
                    <h3>DigiMart</h3>
                    <hr>
                </div>
            </div>
            
            <!-- contact info -->
            <div class="row">
                <div class="col-12 col-md-4 text-secondary text-center m-auto pb-4">
                    <i class="fas fa-map-marker-alt fa-5x"></i>
                </div>
                <div class="col-12 col-sm-12 col-md-4 text-secondary pb-4">
                    <p>Karagoda,</p>
                    <p>Uyangoda,</p>
                    <p>Kamburupitiya,</p>
                    <p>Matara. 81100</p>
                </div>
                <div class="col-12 col-sm-12 col-md-4 text-secondary pb-4">
                    <p><i class="fas fa-at mr-3"></i> team_digimart@gmail.com</p>
                    <p><i class="fas fa-phone mr-3"></i> + 94 11 2345678</p>
                    <p><i class="fas fa-fax mr-3"></i> + 94 11 2345679</p>
                </div>
            </div>
            
        </div>
    </div>
    
    <!-- footer -->
    <?php
        require_once('footer.php');
    ?>
    
</body>
</html>