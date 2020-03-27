<?php

    require_once('../connection/connection.php');

    session_start();

    date_default_timezone_set("Asia/Colombo");
    $dt = "";
    $ur = "";
    $em = "";

    if(isset($_GET['currency'])){
        setcookie("currency_type", $_GET['currency'], time() + (86400 * 30), "/");
        header('Location: '.$_SERVER['PHP_SELF']);
    }

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

    if(isset($_GET['msgId'])) {
                            
        $msgId = $_GET['msgId'];

        $sql = "UPDATE `customer_message` SET `is_unread` = 0 WHERE `from` = '{$msgId}' AND `is_deleted` = 0";

        mysqli_query($conn, $sql);
    
    }



    if(isset($_POST['sendMsg'])){
        $msg = $_POST['msg'];
        $msgToId = $_POST['msgToId'];
        
        $sql = "INSERT INTO `customer_message`(`from`, `to`, `message`) VALUES ( 'digimart','{$msgToId}', '{$msg}')";
        
        mysqli_query($conn, $sql);
        
        header('Location: digimart_message_center.php?msgId='.$msgToId);
    }

?>

<!DOCTYPE html>
<html>
<head>
    <!-- title -->
	<title>Message Center | DigiMart</title>
    
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
        
        .incoming_msg_img img {
            width: 70px;
        }
        
        .msgArea {
            height: 650px;
            overflow-x: hidden;
            overflow-y: scroll;
        }
        
        .msgListArea {
            height: 760px;
            overflow-x: hidden;
            overflow-y: scroll;
        }
        
        .scrollbar-deep-purple::-webkit-scrollbar-track {
            -webkit-box-shadow: inset 0 0 6px rgba(0, 0, 0, 0.1);
            background-color: transparent;
            border-radius: 10px;
        }
        
        .scrollbar-deep-purple::-webkit-scrollbar {
            width: 12px;
            background-color: transparent;
        }
        
        .scrollbar-deep-purple::-webkit-scrollbar-thumb {
            border-radius: 10px;
            -webkit-box-shadow: inset 0 0 6px rgba(0, 0, 0, 0.1); 
            background-color: #dd123d;
        }
        
        .scrollbar-deep-purple {
            scrollbar-color: #dd123d #fff;
        }
        
        .bordered-deep-purple::-webkit-scrollbar-track {
            -webkit-box-shadow: none;
            border: 1px solid #dd123d;
        }
        
        .bordered-deep-purple::-webkit-scrollbar-thumb {
            -webkit-box-shadow: none;
        }
        
        .thin::-webkit-scrollbar {
            width: 5px;
            background-color: transparent;
        }
        
        .msgTypeArea {
            color: #dd123d;
            border: 1px solid #dd123d;
            border-radius: 50px;
            background-color: rgba(221,18,60,0.1);
            font-size: 18px;
        }

        .msgTypeArea:focus {
            color: #dd123d;
            border: 1px solid #dd123d;
            background-color: rgba(221,18,60,0.1);
        }
        
        .msgTypeArea:disabled {
            border: 1px solid #dd123d;
            background-color: rgba(221,18,60,0.1);
            cursor: not-allowed;
        }
        
        #sendMsg:disabled {
            cursor: not-allowed;
        }

        .sidebar a {
            text-decoration: none;
            color: #dd123d;
        }
        
        .sidebar a:hover:not(.active) {
            background-color: rgba(221, 18, 61,.5);
            color: white;
        }
        
    </style>
    
    <script>
        $(document).ready(function(){
            $('[data-toggle="tooltip"]').tooltip();
        });
        
        function chatBottomView() {
            document.getElementById("chatSpinner").scrollIntoView();
        }
        
    </script>
    
    
</head>
    
<body onload="chatBottomView()">
    
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
                    <li class="nav-item mx-5">
                        <a class="nav-link" href="digimart_manage_digimart.php">Manage DigiMart</a>
                    </li>
                    <li class="nav-item active mx-5">
                        <a class="nav-link" href="digimart_message_center.php">Message Center <span class="badge badge-pill badge-danger"><?php if($unreadMsgCount!=0) echo $unreadMsgCount; ?></span></a>
                    </li>
                </ul>
            </div>
        </nav>
        
    </div>
    
    <div class="container">
        <h3 class="text-danger"><i class="far fa-comments"></i> Messages</h3>
        <div class="row">
            
            <div class="msgListArea scrollbar-deep-purple bordered-deep-purple thin py-3 col-4 border border-danger shadow-lg <?php if(isset($_COOKIE['theme']) && ($_COOKIE['theme']=='dark'))echo "text-light bg-dark"; ?>">

                <div class="sidebar d-flex flex-column">
                    
                    <?php
                
                        $query2 = "SELECT DISTINCT `from`, `to` FROM `customer_message` WHERE `to` = 'digimart' AND `is_deleted` = 0 ORDER BY `date_time` ASC";

                        $result = $conn->query($query2);

                        while ($row = $result->fetch_assoc()) {
                            $query1 = "SELECT m.*, c.`email` FROM `customer_message` m, `customer` c WHERE (m.`from` = c.`id` OR m.`to` = c.`id`) AND (m.`from` = '{$row['from']}' OR m.`to` = '{$row['from']}') AND m.`is_deleted` = 0 ORDER BY m.`date_time` DESC LIMIT 1";

                            $result1 = $conn->query($query1);
                            
                            while ($row1 = $result1->fetch_assoc()) {
                                $dt = $row1['date_time'];
                                $em = $row1['email'];
                            }
                    ?>
                    
                    <a href="digimart_message_center.php?msgId=<?php echo $row['from']; ?>">
                        <div class="p-1 border-bottom border-danger">
                            <b class="d-flex justify-content-between"><?php echo $em; ?></b><br>
                            <small class="d-flex justify-content-between text-secondary"><lable><?php echo $row['from']; ?></lable><?php echo $dt; ?></small>
                        </div>
                    </a>
                    
                    <?php
                            
                        }
                    ?>
                    
                </div>
            </div>
            
            <div class="col-8 border border-danger shadow-lg <?php if(isset($_COOKIE['theme']) && ($_COOKIE['theme']=='dark'))echo "text-light bg-dark"; ?>">

                <div class="row p-5 msgArea scrollbar-deep-purple bordered-deep-purple thin">
                    <div id="msgcontainer">
                        
                        <?php
                        
                        if(isset($_GET['msgId'])) {
                            
                            $msgId = $_GET['msgId'];
                
                            $sql = "UPDATE `customer_message` SET `is_unread` = 0 WHERE `from` = '{$msgId}' AND `is_deleted` = 0";
                            
                            mysqli_query($conn, $sql);
                            
                            $query2 = "SELECT * FROM `customer_message` WHERE `is_deleted` = 0 AND (`from` = '{$msgId}' OR `to` = '{$msgId}') ORDER BY `date_time` ASC";

                            $result = $conn->query($query2);
                        
                            $prev = null;
                            $next = null;

                            if (mysqli_num_rows($result) > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    
                                    
                                    $date_time = date_create($row['date_time']);
                                    $time = date_format($date_time,"H:m a");
                                    
                                    $next = date_format($date_time,"M d, Y");
                                    
                                    if($prev == null) {
                                        if(date("M d, Y") == $next) {
                                            //today print
                        ?>
                        
                        <div class="row my-3 date">
                            <div class="col-12 d-flex justify-content-center">
                                <div class="rounded-pill border border-danger text-danger px-5">
                                    <p class="mt-3"><b>
                                        <?php echo "Today"; ?>
                                    </b></p>
                                    
                                </div>
                            </div>
                        </div>
                        
                        <?php
                                        } else {
                                            //not today
                        ?>
                        
                        <div class="row my-3 date">
                            <div class="col-12 d-flex justify-content-center">
                                <div class="rounded-pill border border-danger text-danger px-5">
                                    <p class="mt-3"><b>
                                        <?php echo $next; ?>
                                    </b></p>
                                    
                                </div>
                            </div>
                        </div>
                        
                        <?php
                                        }
                                    } else {
                                        if($prev != $next) {
                                            if(date("M d, Y") == $next) {
                                            //today print
                        ?>
                        
                        <div class="row my-3 date">
                            <div class="col-12 d-flex justify-content-center">
                                <div class="rounded-pill border border-danger text-danger px-5">
                                    <p class="mt-3"><b>
                                        <?php echo "Today"; ?>
                                    </b></p>
                                    
                                </div>
                            </div>
                        </div>
                        
                        <?php
                                            } else {
                                                //not today
                        ?>
                        
                        <div class="row my-3 date">
                            <div class="col-12 d-flex justify-content-center">
                                <div class="rounded-pill border border-danger text-danger px-5">
                                    <p class="mt-3"><b>
                                        <?php echo $next; ?>
                                    </b></p>
                                    
                                </div>
                            </div>
                        </div>
                        
                        <?php
                                            }
                                        }
                                    }
                                        
                                        $prev = $next;
                                    
                                    
                                    if($row['from'] == 'digimart'){
                                        
                        ?>
                        
                        
                        <div class="row my-2 send">
                            <div class="col-12 d-flex pl-5 justify-content-end">
                                <div class="pl-5 ml-5 float-right">
                                    <p class="mr-2 p-3 ml-5 rounded-lg bg-danger text-light lead">
                                        <?php echo $row['message']; ?>
                                        <br>
                                        <a class="d-flex flex-row-reverse"><small class="text-white"><?php echo $time; ?> <i class="fas fa-check <?php if($row['is_unread']==0) echo "text-primary"; ?>"></i></small></a>
                                        
                                    </p>
                                    
                                </div>
                            </div>
                        </div>                        
                        
                        <?php
                                        
                                    } else {
                                        
                        ?>
                        
                        <div class="row my-2 received">
                            <div class="d-flex justify-content-start">
                                <div class="incoming_msg_img">
                                    <img src="../image/customer_msg_icon.jpg" alt="msg_icon">
                                </div>
                                <div class="pr-5 mr-5">
                                    <p class="ml-3 p-3 mr-5 rounded-lg border border-danger lead">
                                        <?php echo $row['message']; ?>
                                        <br>
                                        <small class="text-muted d-flex flex-row-reverse"><?php echo $time; ?></small>
                                    </p>
                                </div>
                            </div>
                        </div>
                        
                        <?php
                                        
                                    }
                                }
                            }
                        }
                        ?>
                        
                        <div class="row">
                            <div class="col-12 d-flex pl-5 justify-content-end">
                                <div class="spinner-grow text-danger" id="chatSpinner" role="status">
                                    <span class="sr-only"></span>
                                </div>
                            </div>
                        </div>
                        
                        
                        
                    </div>
                </div>
                <form method="post" action="digimart_message_center.php">
                    <div class="row m-0 p-2">
                        <div class="d-flex flex-row w-100">
                            <textarea class="form-control msgTypeArea px-4" name="msg" id="msg" rows="3" required <?php if(!isset($_GET['msgId'])) echo "disabled"; ?>></textarea>
                            <input type="hidden" name="msgToId" value="<?php if(isset($_GET['msgId'])) echo $_GET['msgId']; ?>">
                            <button type="submit" id="sendMsg" class="mx-4 pt-2 btn btn-outline-danger" name="sendMsg" <?php if(!isset($_GET['msgId'])) echo "disabled"; ?>><i class="fas fa-paper-plane fa-3x px-2"></i></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
            
            <p class="text-center my-3"> &copy; <a class="text-danger">Team Digimart</a></p>
    </div>
    
    <?php
        require_once('footer.php');
    ?>
    
</body>
</html>