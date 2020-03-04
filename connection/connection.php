<?php

    $conn = mysqli_connect('localhost', 'root', '', 'digimart');

    if (!$conn) {
        header('location:html/disconnected.php');
    }

?>