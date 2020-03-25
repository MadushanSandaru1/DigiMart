<?php

    require_once('../connection/connection.php');

    session_start();

    $usernameErr = "";
    $passwordErr = "";

    if(isset($_GET['currency'])){
        setcookie("currency_type", $_GET['currency'], time() + (86400 * 30), "/");
        header('Location: '.$_SERVER['PHP_SELF']);
    }

    if(isset($_GET['theme'])){
        setcookie("theme", $_GET['theme'], time() + (86400 * 30), "/");
        header('Location: '.$_SERVER['PHP_SELF']);
    }

    if(isset($_POST['btnSigninSubmit'])){
        
        if(!isset($_POST['rememberMe'])){
            setcookie("digimart_email", "", time() - 3600, "/");
        }
        
        /* data for login */
		$username =  mysqli_real_escape_string($conn,trim($_POST['username']));
		$pwd = mysqli_real_escape_string($conn,trim($_POST['password']));
        
        /* password encrypt */
		$h_pwd = md5($pwd);
        
        /* login query */
		$login_query = "SELECT * FROM `user` WHERE `username` = '{$username}' AND `password` = '{$h_pwd}' AND `is_deleted` = 0 LIMIT 1";
        
        /* query execute */
		$result_set = mysqli_query($conn,$login_query);

        /* query result */
		if (mysqli_num_rows($result_set) == 1) {
			$details = mysqli_fetch_assoc($result_set);
            
            /* if user available, user info load to session array */
			$_SESSION = array();
            $_SESSION['digimart_current_user_email'] = $details['username'];
            $_SESSION['digimart_current_user_role'] = $details['role'];
            
            $query = "SELECT * FROM `{$_SESSION['digimart_current_user_role']}` WHERE `email` = '{$_SESSION['digimart_current_user_email']}' LIMIT 1";
            
            $result_set = mysqli_query($conn,$query);
            $user_details = mysqli_fetch_assoc($result_set);
            /* if user available, user info load to session array */
			
			$_SESSION['digimart_current_user_id'] = $user_details['id'];
            $_SESSION['digimart_current_user_first_name'] = $user_details['first_name'];
            $_SESSION['digimart_current_user_last_name'] = $user_details['last_name'];
            
            if(isset($_POST['rememberMe'])){
                setcookie("digimart_email", $_SESSION['digimart_current_user_email'], time() + (86400 * 30), "/");
            }
            
            /* redirect to dashboard page */
            if($_SESSION['digimart_current_user_role'] == 'customer') {
                header("location:../index.php");
            }
            else {
                header("location:digimart_account.php");
            }
            
		}
        /* if user not available, displayerror msg */
		else{
            $usernameErr = "Incorrect username.";
            $passwordErr = "Incorrect password.";
		}
    
    }
?>

<!DOCTYPE html>
<html>
<head>
    <!-- title -->
	<title>Sign In | DigiMart</title>
    
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
        
        #email-errmsg, #password-errmsg {
            color: red;
        }
        
    </style>
    
    <script>
        $(document).ready(function(){
            $('[data-toggle="tooltip"]').tooltip();
        });
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
                            <h1>Sign In</h1>
                        </div>
                    </div>
                    <form action="sign_in.php" method="post" name="sign-in">
                        <div class="form-group">
                            <label for="exampleInputEmail1" class="<?php if(isset($_COOKIE['theme']) && ($_COOKIE['theme']=='dark'))echo "text-white"; else echo "text-dark"; ?>">Email address</label>
                            <input type="email" name="username"  class="form-control" id="username" aria-describedby="emailHelp" placeholder="Enter email address" maxlength="100" value="<?php if(isset($_COOKIE['digimart_email'])) echo $_COOKIE['digimart_email']; ?>" required>
                            <small id="email-errmsg"><?php echo $usernameErr; ?></small>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1" class="<?php if(isset($_COOKIE['theme']) && ($_COOKIE['theme']=='dark'))echo "text-white"; else echo "text-dark"; ?>">Password</label>
                            <input type="password" name="password" id="password"  class="form-control" aria-describedby="emailHelp" placeholder="Enter password" required>
                            <small id="password-errmsg"><?php echo $passwordErr; ?></small>
                        </div>
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="rememberMe" name="rememberMe" <?php if(isset($_COOKIE['digimart_email'])) echo 'checked'; ?> >
                            <label class="form-check-label <?php if(isset($_COOKIE['theme']) && ($_COOKIE['theme']=='dark'))echo "text-white"; ?>" for="rememberMe"><small class="form-text">Remember me</small></label>
                        </div>
                        <div class="col-md-12 text-center mt-3">
                            <button type="submit" name="btnSigninSubmit" class=" btn btn-block mybtn btn-outline-danger tx-tfm">SIGN IN</button>
                        </div>
                        <div class="col-md-12 ">
                            <div class="login-or text-secondary">
                                <hr class="hr-or">
                                <span class="span-or <?php if(isset($_COOKIE['theme']) && ($_COOKIE['theme']=='dark'))echo "bg-dark"; ?>">or</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <p class="text-center <?php if(isset($_COOKIE['theme']) && ($_COOKIE['theme']=='dark'))echo "text-white"; else echo "text-dark"; ?>">Don't have account? <a href="join.php" id="signup" class="text-danger">Join here</a></p>
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