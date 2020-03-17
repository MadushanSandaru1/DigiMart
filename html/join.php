<?php

    //require_once('connection/connection.php');

    session_start();

    if(isset($_GET['currency'])){
        setcookie("currency_type", $_GET['currency'], time() + (86400 * 30), "/");
        header('Location: '.$_SERVER['PHP_SELF']);
    }

    if(isset($_GET['theme'])){
        setcookie("theme", $_GET['theme'], time() + (86400 * 30), "/");
        header('Location: '.$_SERVER['PHP_SELF']);
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
            max-width: 500px;
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
        
    </style>
    
    <script>
        $(document).ready(function(){
            $('[data-toggle="tooltip"]').tooltip();
        });
        
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
    
    <?php
        require_once('header_half.php');
    ?>
    
    <div class="container">
        <div class="row my-5">
            <div class="col-md-5 mx-auto">
                <div class="myform form p-5 shadow-lg <?php if(isset($_COOKIE['theme']) && ($_COOKIE['theme']=='dark'))echo "bg-dark"; else echo "bg-white"; ?>">
                    <div class="logo mb-3">
                        <div class="col-md-12 text-center text-danger">
                            <h1>Join</h1>
                        </div>
                    </div>
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
                            <input type="checkbox" class="form-check-input" id="rememberMe">
                            <label class="form-check-label <?php if(isset($_COOKIE['theme']) && ($_COOKIE['theme']=='dark'))echo "text-white"; ?>" for="rememberMe"><small class="form-text">Remember me</small></label>
                        </div>
                        <div class="form-group">
                            <p class="text-center <?php if(isset($_COOKIE['theme']) && ($_COOKIE['theme']=='dark'))echo "text-white"; else echo "text-dark"; ?>">By signing up you accept our <a href="join_terms.php" class="text-danger" target="_blank">Terms Of Use</a></p>
                        </div>
                        <div class="col-md-12 text-center ">
                            <button type="submit" id="btn-submit" class="btn btn-block mybtn btn-outline-danger tx-tfm" disabled>JOIN</button>
                        </div>
                        <div class="col-md-12 ">
                            <div class="login-or text-secondary">
                                <hr class="hr-or">
                                <span class="span-or <?php if(isset($_COOKIE['theme']) && ($_COOKIE['theme']=='dark'))echo "bg-dark"; ?>">or</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <p class="text-center <?php if(isset($_COOKIE['theme']) && ($_COOKIE['theme']=='dark'))echo "text-white"; else echo "text-dark"; ?>">Already have an account? <a href="sign_in.php" id="signup" class="text-danger">Sign in here</a></p>
                        </div>
                    </form>
                </div>
            </div>
		</div>
      </div>
    
    <?php
        require_once('footer.php');
    ?>
    
</body>
</html>