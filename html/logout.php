<?php
    /* start the session */
	session_start();

    /* empty the session array */
	$_SESSION  = array();

    /* stop the session */
	session_destroy();

    /* redirect to login page */
	header("location:../index.php");
?>