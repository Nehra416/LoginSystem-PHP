<?php
    // set connection vaariables
    $server = "localhost";
    $username = "root";
    $password = "";
    $database = "test";

    // create database connection
    $con = mysqli_connect($server, $username, $password, $database);

    // check for connection success
    if (!$con) {
        die("Connection failed with the database due to " . $mysqli_connect_error());
    } 
?>
