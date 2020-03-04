<?php

    $conn = mysqli_connect('localhost', 'root', '', 'digimart');

    if ($conn) {
        header('location:../index.php');
    }

?>

<!DOCTYPE html>
<html lang="en">

    <head>

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">

        <title>Error | DigiMart</title>

        <!--title icon-->
        <link rel="icon" type="image/ico" href="../image/logo.png"/>

        <!-- Bootstrap core CSS -->
        <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
        
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        
        <style>
            body {
                /*background-image: url('../image/back.gif');
                background-image: url('../image/disconnected.gif');
                background-repeat: no-repeat;
                background-attachment: fixed;
                background-position: center;*/
            }
            
            .btn {
                position: absolute;
            }
        </style>

    </head>

<body>
    
    <!-- Page Content -->
    
    <div class="container">
		<div class="d-flex justify-content-center">
            <div class="col-8 d-flex justify-content-center mt-4">
                <img src="../image/disconnected.gif">
                <input type="button" value="Refresh" onclick="window.location.reload();" class="btn btn-lg btn-danger">
            </div>
		</div>
    </div>
  <!-- /.container -->

  <!-- Bootstrap core JavaScript -->
  <script src="../vendor/jquery/jquery.min.js"></script>
  <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

</body>

</html>
