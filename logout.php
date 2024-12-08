<?php
    // destroy the session and redirect the user to the login page
    session_start();
    session_reset();
    session_destroy();
    header("location: login.php");
    exit;
?>