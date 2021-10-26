<?php
    $host = "feenix-mariadb.swin.edu.au"; //MySQL Database Server
    $user = "s101571578";
    $pswd = "4vj6y8n462";
    $dbnm = "s101571578_db";
    //mysqli_connect() return false if not found
    $conn = mysqli_connect($host, $user, $pswd, $dbnm);
?>