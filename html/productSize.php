<?php

    require_once('../connection/connection.php');

    session_start();

    $sql = "SELECT * FROM `stock` WHERE `size` = {$_GET['size']}";

    $result = mysqli_query($conn, $sql);

    $rowProId = mysqli_fetch_assoc($result);

    //$_SESSION['maxSize'] = $rowProId['available'];

    echo $rowProId['available'];
?>