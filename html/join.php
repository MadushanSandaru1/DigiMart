<?php

    //connection start
    require_once('../connection/connection.php');

    //session variable start
    session_start();

?>

<?php

    function emailSend($firstName, $lastName, $email){
        
        $heading = "Account Created Successfully";
        $message = "Dear ".$firstName." ".$firstName.",<br><p>You have successfully created your DIGIMART account by emailing <b>".$email."</b></p><br>Thank You!<br><pre>Team Digimart,<br>Karagoda,<br>Uyangoda,<br>Kamburupitiya,<br>Matara,<br>Sri Lanka - 81100</pre>";

        require '../email/PHPMailerAutoload.php';
        $credential = include('../email/credential.php');      //credentials import

        $mail = new PHPMailer;
        $mail->isSMTP();                                    // Set mailer to use SMTP
        $mail->Host = 'smtp.gmail.com';                     // Specify main and backup SMTP servers
        $mail->SMTPAuth = true;                             // Enable SMTP authentication
        $mail->Username = $credential['user'];              // SMTP username
        $mail->Password = $credential['pass'];              // SMTP password
        $mail->SMTPSecure = 'tls';                          // Enable TLS encryption, `ssl` also accepted
        $mail->Port = 587;                                  // TCP port to connect to
        $mail->setFrom($email);
        $mail->addAddress($email);                          // Name is optional

        $mail->addReplyTo('hello');

        $mail->isHTML(true);                                    // Set email format to HTML

        $mail->Subject = $heading;
        $mail->Body    = $message;
        $mail->AltBody = 'If you see this mail. please reload the page.';

        if(!$mail->send()) {
            //echo 'Message could not be sent.';
            //echo 'Mailer Error: ' . $mail->ErrorInfo;
        }
    }

?>

<?php

    //variable for tooltips visible
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

    //Join button submit
    if(isset($_POST['btnJoinSubmit'])){
        
        //check email address account already exists or not
        $queryEmailCheck = "SELECT * FROM `user` WHERE `username` = '{$_POST['email']}' AND `is_deleted` = 0";
        
        $result_set = mysqli_query($conn,$queryEmailCheck);

        //if already exists
        if (mysqli_num_rows($result_set) == 1) {

            //display toast with error message
            $alertStatus = 1;
            
        }
        //if already not exists
        else {
            
            //get last customer ID and add 1 (+1) for set new account customer ID
            $queryGetLastId = "SELECT id FROM `customer` ORDER BY `id` DESC LIMIT 1";

            $result_set = mysqli_query($conn,$queryGetLastId);

            //if have a customer account, set ID as last ID
            if (mysqli_num_rows($result_set) == 1) {

                $lastId = mysqli_fetch_assoc($result_set);
                $num = substr($lastId['id'],1,strlen($lastId['id']));

            }
            //if don't have customer account, set 0 as last ID
            else {
                $num = 0;
            }

            //create new ID add 1 to last ID
            $id =  "C".sprintf("%05d", ++$num);

            $firstName = mysqli_real_escape_string($conn,trim($_POST['firstName']));
            $lastName = mysqli_real_escape_string($conn,trim($_POST['lastName']));
            $email = mysqli_real_escape_string($conn,trim($_POST['email']));
            $pwd = mysqli_real_escape_string($conn,trim($_POST['password']));
            
            //password encrypt
            $h_pwd = md5($pwd);

            //insert data to customer table
            $qurey = "INSERT INTO `customer`(`id`, `first_name`, `last_name`, `email`) VALUES  ('{$id}','{$firstName}','{$lastName}','{$email}')";

            $result = mysqli_query($conn,$qurey);

            //if data inserted, then insert data to user table
            if ($result) {

                $qurey = "INSERT INTO `user`(`username`, `password`, `role`) VALUES  ('{$email}','{$h_pwd}','customer')";

                $result = mysqli_query($conn,$qurey);

                //send email
                emailSend($firstName, $lastName, $email);

                //user info load to session array
                $_SESSION['digimart_current_user_id'] = $id;
                $_SESSION['digimart_current_user_email'] = $email;
                $_SESSION['digimart_current_user_first_name'] = $firstName;
                $_SESSION['digimart_current_user_last_name'] = $lastName;
                $_SESSION['digimart_current_user_role'] = "customer";

                //if checked Remember Me, set user email as cookie in local machine
                if(isset($_POST['rememberMe'])){
                    setcookie("digimart_email", $_SESSION['digimart_current_user_email'], time() + (86400 * 30), "/");
                }
                
                //redirect to index page
                header("location:../index.php");
            }
            //if data not inserted display tooltips message as Unsuccessful
            else{
                $alertStatus = 2;
            }
            
        }
    
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <!-- title -->
        <title>Join | DigiMart</title>

        <!-- title icon -->
        <link rel="icon" type="image/ico" href="../image/logo.png"/>

        <!-- Bootstrap CSS -->
        <link type="text/css" href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

        <!-- CSS -->
        <link type="text/css" href="../css/navbar.css" rel="stylesheet">

        <!-- google font -->
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

            a {
                text-decoration:none !important;
            }

            .myform {
                position: relative;
                display: -ms-flexbox;
                display: flex;
                padding: 1rem;
                -ms-flex-direction: column;
                flex-direction: column;
                width: 100%;
                pointer-events: auto;
                background-color: #fff;
                background-clip: padding-box;
                border: 1px solid rgba(221,18,61,.3);
                border-radius: 1.1rem;
                outline: 0;
            }

            .logo {
                font-family: 'Atomic Age';
            }

            label {
                font-family: 'Abel';
                font-size: 20px;
            }

            .form-control {
                border-color: #dd123d;
                color: #dd123d;
                background:none!important;
            }

            .form-control:focus {
                border-color: #dd123d;
                color: #dd123d;
                box-shadow: 2px 2px 3px #dd123d;
            }

            .mybtn {
                border-radius:50px;
            }

            .login-or {
                position: relative;
                margin-top: 10px;
                margin-bottom: 10px;
                padding-top: 10px;
                padding-bottom: 10px;
            }

            .span-or {
                display: block;
                position: absolute;
                left: 50%;
                top: -2px;
                margin-left: -25px;
                background-color: #fff;
                width: 50px;
                text-align: center;
            }

            .hr-or {
                height: 1px;
                margin-top: 0px !important;
                margin-bottom: 0px !important;
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

            //for active submit button
            $(document).ready(function(){
                $("#confirmPassword").keyup(function(){
                    if ($("#password").val() != $("#confirmPassword").val()) {
                        $("#match-msg").html("Password do not match").css("color","red");
                        $("#btn-submit").attr('disabled','disabled');
                    }else{
                        $("#match-msg").html("Password matched").css("color","green");
                        $("#btn-submit").removeAttr('disabled');
                    }
                });
            });

            //for view password field content as character
            function passwordVisible() {
                var x = document.getElementById("password");
                var y = document.getElementById("confirmPassword");
                if (x.type === "password") {
                    x.type = "text";
                    y.type = "text";
                } else {
                    x.type = "password";
                    y.type = "password";
                }
            }
        </script>
    
    </head>
    
    <body>

        <!-- toast notification box -->
        <div class="toastNotify <?php if(isset($_COOKIE['theme']) && ($_COOKIE['theme']=='dark'))echo "bg-dark"; else echo "bg-white"; ?> col-7 col-sm-6 col-md-4 col-lg-3" data-autohide="false">
            
            <!-- toast header -->
            <div class="toast-header <?php if(isset($_COOKIE['theme']) && ($_COOKIE['theme']=='dark'))echo "bg-dark"; ?>">
                <strong class="mr-auto text-danger">Error!</strong>
                <small class="text-muted"></small>
                <button type="button" class="ml-2 mb-1 close text-danger" data-dismiss="toast">&times;</button>
            </div>

            <!-- toast body -->
            <div class="toast-body <?php if(isset($_COOKIE['theme']) && ($_COOKIE['theme']=='dark'))echo "text-white"; ?>">
                <?php if($alertStatus == 1) echo "This email already exists."; else echo "Failed to create your user account."; ?>
            </div>
            
        </div>

        <!-- import navbar -->
        <?php
            require_once('header_half.php');
        ?>

        <!-- page content row 1 | topic and map -->
        <div class="container">
            <div class="row my-5">
                <div class="col-11 col-sm-11 col-md-6 mx-auto">
                    
                    <div class="myform form p-5 shadow-lg <?php if(isset($_COOKIE['theme']) && ($_COOKIE['theme']=='dark'))echo "bg-dark"; else echo "bg-white"; ?>">
                        
                        <!-- heading -->
                        <div class="logo mb-3">
                            <div class="col-md-12 text-center text-danger">
                                <h1>Join</h1>
                            </div>
                        </div>
                        
                        <!-- form -->
                        <form action="join.php" method="post" name="join">
                            
                            <div class="form-group">
                                <label for="firstName" class="<?php if(isset($_COOKIE['theme']) && ($_COOKIE['theme']=='dark'))echo "text-white"; else echo "text-dark"; ?>">First Name</label>
                                <input type="text" name="firstName"  class="form-control" id="username" aria-describedby="emailHelp" placeholder="Enter first name" maxlength="25" required>
                            </div>
                            
                            <div class="form-group">
                                <label for="lastName" class="<?php if(isset($_COOKIE['theme']) && ($_COOKIE['theme']=='dark'))echo "text-white"; else echo "text-dark"; ?>">Last Name</label>
                                <input type="text" name="lastName"  class="form-control" id="username" aria-describedby="emailHelp" placeholder="Enter last name" maxlength="25" required>
                            </div>
                            
                            <div class="form-group">
                                <label for="email" class="<?php if(isset($_COOKIE['theme']) && ($_COOKIE['theme']=='dark'))echo "text-white"; else echo "text-dark"; ?>">Email address</label>
                                <input type="email" name="email"  class="form-control" id="username" aria-describedby="emailHelp" placeholder="Enter email address" maxlength="100" required>
                            </div>
                            
                            <div class="form-group">
                                <label for="password" class="<?php if(isset($_COOKIE['theme']) && ($_COOKIE['theme']=='dark'))echo "text-white"; else echo "text-dark"; ?>">Password</label>
                                <input type="password" name="password" id="password"  class="form-control" aria-describedby="emailHelp" placeholder="Enter password" required>
                                <small><input type="checkbox" id="showPwd" onclick="passwordVisible()"><label class="form-check-label <?php if(isset($_COOKIE['theme']) && ($_COOKIE['theme']=='dark'))echo "text-white"; ?>" for="showPwd"><small class="form-text">Show password</small></label></small>
                            </div>
                            
                            <div class="form-group">
                                <label for="confirmPassword" class="<?php if(isset($_COOKIE['theme']) && ($_COOKIE['theme']=='dark'))echo "text-white"; else echo "text-dark"; ?>">Confirm password</label>
                                <input type="password" name="confirmPassword" id="confirmPassword"  class="form-control" aria-describedby="emailHelp" placeholder="Enter confirm password" required>
                                <small id="match-msg"></small>
                            </div>
                            
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="rememberMe" name="rememberMe">
                                <label class="form-check-label <?php if(isset($_COOKIE['theme']) && ($_COOKIE['theme']=='dark'))echo "text-white"; ?>" for="rememberMe"><small class="form-text">Remember me</small></label>
                            </div>
                            
                            <div class="form-group">
                                <p class="text-center <?php if(isset($_COOKIE['theme']) && ($_COOKIE['theme']=='dark'))echo "text-white"; else echo "text-dark"; ?>">By signing up you accept our <a href="join_terms.php" class="text-danger" target="_blank">Terms Of Use</a></p>
                            </div>
                            
                            <!-- submit button -->
                            <div class="col-md-12 text-center ">
                                <button type="submit" id="btn-submit" name="btnJoinSubmit" class="btn btn-block mybtn btn-outline-danger tx-tfm" disabled>JOIN</button>
                            </div>
                            
                            <div class="col-md-12 ">
                                <div class="login-or text-secondary">
                                    <hr class="hr-or">
                                    <span class="span-or <?php if(isset($_COOKIE['theme']) && ($_COOKIE['theme']=='dark'))echo "bg-dark"; ?>">or</span>
                                </div>
                            </div>
                            
                            <!-- sign in link -->
                            <div class="form-group">
                                <p class="text-center <?php if(isset($_COOKIE['theme']) && ($_COOKIE['theme']=='dark'))echo "text-white"; else echo "text-dark"; ?>">Already have an account? <a href="sign_in.php" id="signup" class="text-danger">Sign in here</a></p>
                            </div>
                            
                        </form>
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